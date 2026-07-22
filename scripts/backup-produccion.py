# scripts/backup-produccion.py
import os
import sys
import ftplib
import requests
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

print("==> 1. Conectando al servidor FTP...")
try:
    ftp = ftplib.FTP(ftp_host)
    ftp.login(ftp_user, ftp_pass)
    ftp.cwd(remote_root)
    print("    Conexión establecida con éxito.")
except Exception as e:
    print(f"Error FTP: {e}", file=sys.stderr)
    sys.exit(1)

print("==> 2. Subiendo el script helper-backup.php...")
local_php = os.path.join(os.path.dirname(__file__), "helper-backup.php")
with open(local_php, "rb") as f:
    ftp.storbinary("STOR helper-backup.php", f)
print("    Script subido correctamente.")

print("==> 3. Ejecutando el respaldo en el servidor de producción (esto puede tomar 1-3 minutos)...")
token = "mitsa_backup_secure_token_2026"
backup_url = f"{wp_url}/helper-backup.php?token={token}"
try:
    r = requests.get(backup_url, timeout=300)
    res = r.json()
    if res.get("status") == "success":
        print(f"    Respaldo de BD: {res.get('database')}")
        print(f"    Tamaño de BD: {res.get('sql_size')} bytes")
        print(f"    Tamaño de ZIP: {res.get('zip_size')} bytes")
    else:
        print(f"Error devuelto por el servidor: {res.get('message')}", file=sys.stderr)
        ftp.quit()
        sys.exit(1)
except Exception as e:
    print(f"Error ejecutando el backup HTTP: {e}", file=sys.stderr)
    ftp.quit()
    sys.exit(1)

print("==> 4. Descargando los archivos de respaldo a la carpeta local staging/...")
staging_dir = os.path.join(os.path.dirname(os.path.dirname(__file__)), "staging")
os.makedirs(staging_dir, exist_ok=True)

local_zip = os.path.join(staging_dir, "mitsa_files_backup.zip")
local_sql = os.path.join(staging_dir, "mitsa_db_backup.sql")

with open(local_zip, "wb") as f:
    ftp.retrbinary("RETR mitsa_files_backup.zip", f.write)
print("    ZIP de archivos descargado a staging/mitsa_files_backup.zip")

with open(local_sql, "wb") as f:
    ftp.retrbinary("RETR mitsa_db_backup.sql", f.write)
print("    SQL de base de datos descargado a staging/mitsa_db_backup.sql")

print("==> 5. Eliminando archivos temporales de producción para no comprometer la seguridad...")
try:
    ftp.delete("helper-backup.php")
    ftp.delete("mitsa_files_backup.zip")
    ftp.delete("mitsa_db_backup.sql")
    print("    Archivos temporales borrados del servidor.")
except Exception as e:
    print(f"Advertencia al limpiar servidor: {e}", file=sys.stderr)

ftp.quit()
print("\n==> ¡PROCESO DE RESPALDO COMPLETADO CON ÉXITO! <==")
