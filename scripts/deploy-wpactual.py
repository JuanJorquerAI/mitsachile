# scripts/deploy-wpactual.py
import os
import sys
import zipfile
import ftplib
import requests
import shutil
from dotenv import load_dotenv

load_dotenv()

ftp_host = os.getenv("MITSA_FTP_HOST") or os.getenv("MITSA_CPANEL_URL")
if ftp_host and "://" in ftp_host:
    ftp_host = ftp_host.split("://")[1].split(":")[0]
ftp_user = os.getenv("MITSA_FTP_USER") or os.getenv("MITSA_CPANEL_USER")
ftp_pass = os.getenv("MITSA_FTP_PASS") or os.getenv("MITSA_CPANEL_PASS")
remote_root = os.getenv("MITSA_FTP_REMOTE_ROOT", "public_html")
wp_url = os.getenv("MITSA_WP_URL", "https://mitsachile.com")

if not all([ftp_host, ftp_user, ftp_pass]):
    print("Error: Credenciales incompletas en el archivo .env", file=sys.stderr)
    sys.exit(1)

staging_dir = os.path.join(os.path.dirname(os.path.dirname(__file__)), "staging")
wpactual_dir = os.path.join(os.path.dirname(os.path.dirname(__file__)), "wpactual")

print("==> 1. Exportando base de datos local mitsa_actual...")
local_sql_file = os.path.join(staging_dir, "new_site_production.sql")
db_user_local = "mitsa_dev"
db_pass_local = "mitsa_dev_local_pw"
db_name_local = "mitsa_actual"

# Exportar base de datos local
cmd = f"mysqldump -u {db_user_local} -p{db_pass_local} {db_name_local} > {local_sql_file}"
ret = os.system(cmd)
if ret != 0:
    print("Error: No se pudo exportar la base de datos local", file=sys.stderr)
    sys.exit(1)
print("    Base de datos local exportada.")

print("==> 2. Generando paquete zip de wpactual...")
local_zip_file = os.path.join(staging_dir, "wpactual.zip")

# Crear el ZIP con los archivos del sitio nuevo
with zipfile.ZipFile(local_zip_file, 'w', zipfile.ZIP_DEFLATED) as zipf:
    for root, dirs, files in os.walk(wpactual_dir):
        for file in files:
            file_path = os.path.join(root, file)
            rel_path = os.path.relpath(file_path, wpactual_dir)
            zipf.write(file_path, rel_path)
print("    Paquete wpactual.zip creado.")

print("==> 3. Conectando al FTP de producción para subir el paquete...")
try:
    ftp = ftplib.FTP(ftp_host)
    ftp.login(ftp_user, ftp_pass)
    ftp.cwd(remote_root)
except Exception as e:
    print(f"Error FTP: {e}", file=sys.stderr)
    sys.exit(1)

# Subir wpactual.zip
print("    Subiendo wpactual.zip...")
with open(local_zip_file, "rb") as f:
    ftp.storbinary("STOR wpactual.zip", f)

# Subir new_site_production.sql
print("    Subiendo new_site_production.sql...")
with open(local_sql_file, "rb") as f:
    ftp.storbinary("STOR new_site_production.sql", f)

# Subir helper-deploy.php
print("    Subiendo helper-deploy.php...")
local_helper = os.path.join(os.path.dirname(__file__), "helper-deploy.php")
with open(local_helper, "rb") as f:
    ftp.storbinary("STOR helper-deploy.php", f)

print("==> 4. Ejecutando la implementación en el servidor de producción (esto puede tomar 2-5 minutos)...")
token = "mitsa_deploy_secure_token_2026"
deploy_url = f"{wp_url}/helper-deploy.php?token={token}"
try:
    headers = {"User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36"}
    r = requests.get(deploy_url, headers=headers, timeout=300)
    res = r.json()
    if res.get("status") == "success":
        print(f"    Extracción: {res.get('unzip')}")
        print(f"    Importación BD: {res.get('import')}")
        print(f"    Reemplazo de URLs: {res.get('replace')}")
    else:
        print(f"Error en servidor: {res.get('message')}", file=sys.stderr)
        ftp.quit()
        sys.exit(1)
except Exception as e:
    print(f"Error ejecutando la URL de deploy: {e}", file=sys.stderr)
    ftp.quit()
    sys.exit(1)

print("==> 5. Eliminando archivos temporales del servidor...")
try:
    ftp.delete("helper-deploy.php")
    ftp.delete("wpactual.zip")
    ftp.delete("new_site_production.sql")
    print("    Archivos temporales borrados del servidor.")
except Exception as e:
    print(f"Advertencia al limpiar servidor: {e}", file=sys.stderr)

ftp.quit()
print("\n==> ¡PROCESO DE DESPLIEGUE COMPLETADO CON ÉXITO! <==")
