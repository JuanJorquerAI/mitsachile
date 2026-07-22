# scripts/deploy-hostinger.py
import os
import sys
import zipfile
import subprocess
from dotenv import load_dotenv

load_dotenv()

# Cargar credenciales SSH de Hostinger
ssh_host = "46.202.94.242"
ssh_user = "u549101671"
ssh_port = "65002"
ssh_key = os.path.expanduser("~/.ssh/hostinger_aw")

# Cargar credenciales DB de Hostinger
db_name = os.getenv("HOSTINGER_DB_NAME")
db_user = os.getenv("HOSTINGER_DB_USER")
db_pass = os.getenv("HOSTINGER_DB_PASS")
db_host = os.getenv("HOSTINGER_DB_HOST", "127.0.0.1")

if not all([db_name, db_user, db_pass]):
    print("Error: Credenciales de base de datos de Hostinger no encontradas en el archivo .env", file=sys.stderr)
    print("Por favor corre primero: python3 scripts/hostinger-helper.py", file=sys.stderr)
    sys.exit(1)

staging_dir = os.path.join(os.path.dirname(os.path.dirname(__file__)), "staging")
wpactual_dir = os.path.join(os.path.dirname(os.path.dirname(__file__)), "wpactual")

print("==> 1. Exportando base de datos local mitsa_actual...")
local_sql_file = os.path.join(staging_dir, "new_site_production.sql")
db_user_local = "mitsa_dev"
db_pass_local = "mitsa_dev_local_pw"
db_name_local = "mitsa_actual"

# Exportar base de datos local
cmd_mysql = f'mysqldump -u {db_user_local} -p{db_pass_local} {db_name_local} > "{local_sql_file}"'
ret = os.system(cmd_mysql)
if ret != 0:
    print("Error: No se pudo exportar la base de datos local", file=sys.stderr)
    sys.exit(1)
print("    Base de datos local exportada.")

print("==> 2. Generando paquete zip de wpactual adaptado para Hostinger...")
local_zip_file = os.path.join(staging_dir, "wpactual.zip")

# Crear el ZIP con los archivos del sitio nuevo, reemplazando credenciales en wp-config.php al vuelo
with zipfile.ZipFile(local_zip_file, 'w', zipfile.ZIP_DEFLATED) as zipf:
    for root, dirs, files in os.walk(wpactual_dir):
        for file in files:
            file_path = os.path.join(root, file)
            rel_path = os.path.relpath(file_path, wpactual_dir)
            if rel_path == 'wp-config.php':
                with open(file_path, "r", encoding="utf-8") as f_cfg:
                    cfg_content = f_cfg.read()
                cfg_content = cfg_content.replace("'mitsa_actual'", f"'{db_name}'")
                cfg_content = cfg_content.replace("'mitsa_dev'", f"'{db_user}'")
                cfg_content = cfg_content.replace("'mitsa_dev_local_pw'", f"'{db_pass}'")
                cfg_content = cfg_content.replace("'localhost'", f"'{db_host}'")
                zipf.writestr(rel_path, cfg_content)
            else:
                zipf.write(file_path, rel_path)
print("    Paquete wpactual.zip creado.")

print("==> 3. Subiendo paquetes a Hostinger vía SCP por SSH...")
# Comando SCP para subir los archivos al servidor Hostinger
scp_cmd = [
    "scp",
    "-P", ssh_port,
    "-i", ssh_key,
    "-o", "StrictHostKeyChecking=no",
    local_zip_file,
    local_sql_file,
    f"{ssh_user}@{ssh_host}:domains/mitsachile.com/"
]

try:
    subprocess.run(scp_cmd, check=True)
    print("    Archivos wpactual.zip y new_site_production.sql subidos con éxito.")
except Exception as e:
    print(f"Error al subir archivos vía SCP: {e}", file=sys.stderr)
    sys.exit(1)

print("==> 4. Ejecutando la extracción e importación en Hostinger vía SSH...")

# Comandos remotos a ejecutar en Hostinger
remote_commands = f"""
set -e
echo "   -> Creando carpetas de trabajo..."
mkdir -p domains/mitsachile.com/public_html
mkdir -p domains/mitsachile.com/old_site_backup_tmp

echo "   -> Respaldando archivos previos..."
# Mover archivos viejos al backup (si existen)
find domains/mitsachile.com/public_html/ -maxdepth 1 -mindepth 1 -exec mv -t domains/mitsachile.com/old_site_backup_tmp/ {{}} + 2>/dev/null || true

echo "   -> Extrayendo paquete del sitio nuevo..."
unzip -o domains/mitsachile.com/wpactual.zip -d domains/mitsachile.com/public_html/

echo "   -> Importando la base de datos MySQL..."
mysql -h {db_host} -u {db_user} -p'{db_pass}' {db_name} < domains/mitsachile.com/new_site_production.sql

echo "   -> Ejecutando search-replace de URLs con WP-CLI..."
wp search-replace "http://localhost:8892" "https://mitsachile.com" --path="domains/mitsachile.com/public_html" --all-tables --skip-columns=guid
wp cache flush --path="domains/mitsachile.com/public_html"

echo "   -> Limpiando archivos temporales remotos..."
rm -f domains/mitsachile.com/wpactual.zip
rm -f domains/mitsachile.com/new_site_production.sql
"""

ssh_cmd = [
    "ssh",
    "-p", ssh_port,
    "-i", ssh_key,
    "-o", "StrictHostKeyChecking=no",
    f"{ssh_user}@{ssh_host}",
    remote_commands
]

try:
    subprocess.run(ssh_cmd, check=True)
    print("\n==> ¡PROCESO DE DESPLIEGUE EN HOSTINGER COMPLETADO CON ÉXITO! <==")
    print("    El sitio ya está activo en tu servidor Hostinger.")
    print("    Asegúrate de que los DNS de mitsachile.com apunten a la IP 46.202.94.242.")
except Exception as e:
    print(f"Error al ejecutar comandos en el servidor Hostinger: {e}", file=sys.stderr)
    sys.exit(1)
