# scripts/rollback-produccion.py
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

print("==> 1. Conectando al FTP de producción para iniciar el rollback...")
try:
    ftp = ftplib.FTP(ftp_host)
    ftp.login(ftp_user, ftp_pass)
    ftp.cwd(remote_root)
except Exception as e:
    print(f"Error FTP: {e}", file=sys.stderr)
    sys.exit(1)

# Subir mitsa_db_backup.sql (el backup dorado)
print("    Subiendo mitsa_db_backup.sql para restaurar base de datos...")
local_sql = os.path.join(os.path.dirname(os.path.dirname(__file__)), "staging", "mitsa_db_backup.sql")
with open(local_sql, "rb") as f:
    ftp.storbinary("STOR mitsa_db_backup.sql", f)

# Subir helper-rollback.php
print("    Subiendo helper-rollback.php...")
local_helper = os.path.join(os.path.dirname(__file__), "helper-rollback.php")
with open(local_helper, "rb") as f:
    ftp.storbinary("STOR helper-rollback.php", f)

print("==> 2. Ejecutando el rollback en el servidor de producción...")
token = "mitsa_rollback_secure_token_2026"
rollback_url = f"{wp_url}/helper-rollback.php?token={token}"
try:
    headers = {"User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36"}
    r = requests.get(rollback_url, headers=headers, timeout=300)
    res = r.json()
    if res.get("status") == "success":
        print(f"    Restauración de archivos: {res.get('restore_files')}")
        print(f"    Restauración BD: {res.get('restore_db')}")
    else:
        print(f"Error en servidor: {res.get('message')}", file=sys.stderr)
        ftp.quit()
        sys.exit(1)
except Exception as e:
    print(f"Error ejecutando la URL de rollback: {e}", file=sys.stderr)
    ftp.quit()
    sys.exit(1)

print("==> 3. Eliminando archivos de control del servidor...")
try:
    ftp.delete("helper-rollback.php")
    ftp.delete("mitsa_db_backup.sql")
    print("    Archivos de control borrados del servidor.")
except Exception as e:
    print(f"Advertencia al limpiar servidor: {e}", file=sys.stderr)

ftp.quit()
print("\n==> ¡PROCESO DE ROLLBACK COMPLETADO CON ÉXITO! EL SITIO ANTERIOR HA SIDO RESTAURADO. <==\n")
