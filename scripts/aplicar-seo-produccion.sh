#!/usr/bin/env bash
# Aplica el paquete SEO de producción a mitsachile.com vía SFTP.
# CONSERVADOR: solo sube robots.txt y sitemap.xml (reversibles, no rompen el
# sitio). Hace backup del robots.txt actual antes de sobrescribir. La
# redirección https (.htaccess) y la instalación de Yoast/GTM quedan manuales
# — ver docs/entregables/seo-produccion/INSTRUCCIONES.md — porque tocar
# .htaccess a ciegas puede tumbar el sitio.
#
# Requiere un archivo .env en la raíz del repo (gitignoreado) con:
#   MITSA_SFTP_HOST=...
#   MITSA_SFTP_USER=...
#   MITSA_SFTP_PASS=...          # o usar clave: MITSA_SFTP_KEY=/ruta/id_rsa
#   MITSA_SFTP_REMOTE_ROOT=public_html   # ruta al docroot en el hosting
#
# Uso:  bash scripts/aplicar-seo-produccion.sh
set -euo pipefail

REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
PKG="$REPO_ROOT/docs/entregables/seo-produccion"
ENV_FILE="$REPO_ROOT/.env"
BACKUP_DIR="$REPO_ROOT/.seo-backups/$(date +%Y%m%d-%H%M%S)"

[ -f "$ENV_FILE" ] || { echo "ERROR: falta .env en $REPO_ROOT (ver cabecera del script)"; exit 1; }
# shellcheck disable=SC1090
set -a; source "$ENV_FILE"; set +a

: "${MITSA_SFTP_HOST:?falta MITSA_SFTP_HOST en .env}"
: "${MITSA_SFTP_USER:?falta MITSA_SFTP_USER en .env}"
REMOTE_ROOT="${MITSA_SFTP_REMOTE_ROOT:-public_html}"

[ -f "$PKG/robots.txt" ]  || { echo "ERROR: falta $PKG/robots.txt";  exit 1; }
[ -f "$PKG/sitemap.xml" ] || { echo "ERROR: falta $PKG/sitemap.xml"; exit 1; }

mkdir -p "$BACKUP_DIR"

# Construye el batch de sftp. Autenticación por clave si MITSA_SFTP_KEY, si no
# se asume que el usuario cargó la clave en el agente o usará sshpass aparte.
SFTP_OPTS=(-oBatchMode=no -oStrictHostKeyChecking=accept-new)
[ -n "${MITSA_SFTP_KEY:-}" ] && SFTP_OPTS+=(-i "$MITSA_SFTP_KEY")
DEST="$MITSA_SFTP_USER@$MITSA_SFTP_HOST"

echo "==> 1/3 Backup del robots.txt actual"
sftp "${SFTP_OPTS[@]}" "$DEST" <<EOF || echo "   (no había robots.txt remoto o falló la descarga — continúo)"
get $REMOTE_ROOT/robots.txt $BACKUP_DIR/robots.txt.remoto
bye
EOF
echo "   backup en $BACKUP_DIR/"

echo "==> 2/3 Subiendo robots.txt y sitemap.xml"
sftp "${SFTP_OPTS[@]}" "$DEST" <<EOF
put $PKG/robots.txt  $REMOTE_ROOT/robots.txt
put $PKG/sitemap.xml $REMOTE_ROOT/sitemap.xml
bye
EOF

echo "==> 3/3 Verificación pública"
UA="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 Chrome/126 Safari/537.36"
echo -n "   robots.txt: "; curl -s --compressed -A "$UA" https://mitsachile.com/robots.txt | head -3 | tr '\n' ' '; echo
if curl -s --compressed -A "$UA" https://mitsachile.com/robots.txt | grep -qE '^\s*Disallow:\s*/\s*$'; then
  echo "   ⚠️  ADVERTENCIA: sigue apareciendo 'Disallow: /'. Puede que robots.txt lo genere un plugin (Yoast/WP) y no sea un archivo físico. Ver INSTRUCCIONES.md."
else
  echo "   ✓ robots.txt ya no bloquea la indexación."
fi
echo -n "   sitemap.xml HTTP: "; curl -s -o /dev/null -w "%{http_code}\n" --compressed -A "$UA" https://mitsachile.com/sitemap.xml

cat <<'NOTA'

PENDIENTE MANUAL (no lo hace este script, por seguridad):
  - Redirección http->https en .htaccess (bloque en INSTRUCCIONES.md §2)
  - Instalar Yoast SEO (metas + sitemap automático) y GTM4WP (analítica)
  - Verificar propiedad en Search Console y enviar el sitemap
Rollback robots.txt:  subir de vuelta el archivo en .seo-backups/<fecha>/
NOTA
