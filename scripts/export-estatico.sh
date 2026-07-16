#!/usr/bin/env bash
# Genera una copia ESTÁTICA navegable del sitio WordPress local para compartir
# con el cliente como preview (sin exponer el WP ni la base de datos).
#
# Espeja http://localhost:PUERTO con wget, reescribe los enlaces a relativos y
# deja el resultado en export/ (gitignoreado). Ese directorio se puede subir a
# cualquier hosting estático o comprimir y enviar.
#
# Uso:  bash scripts/export-estatico.sh [puerto]
#   puerto por defecto: 8080
set -euo pipefail

REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
PORT="${1:-8080}"
BASE="http://localhost:$PORT"
OUT="$REPO_ROOT/export"

command -v wget >/dev/null || { echo "ERROR: wget no está instalado (brew install wget)"; exit 1; }

echo -n "==> Verificando WP local en $BASE ... "
code=$(curl -s -o /dev/null -w "%{http_code}" --max-time 8 "$BASE/" || echo "000")
if [ "$code" = "000" ]; then
  echo "SIN RESPUESTA"; echo "   Levanta el entorno con scripts/setup-wp.sh + provision.sh y reintenta."; exit 1
fi
echo "HTTP $code ✓"

rm -rf "$OUT"; mkdir -p "$OUT"

echo "==> Espejando el sitio (wget recursivo)"
# --mirror: recursivo + timestamps ; -p: requisitos de página (css/js/img)
# -k: convierte enlaces a relativos ; -E: agrega .html ; -np: no subir de nivel
# -e robots=off: ignora el robots local ; --restrict-file-names=windows evita ? en nombres
wget \
  --mirror --page-requisites --convert-links --adjust-extension --no-parent \
  -e robots=off \
  --restrict-file-names=windows \
  --no-host-directories \
  --directory-prefix="$OUT" \
  --reject "xmlrpc.php*,wp-login.php*,wp-json*" \
  "$BASE/" || true   # wget devuelve !=0 si algún asset 404ea; no es fatal

# Métrica simple
PAGES=$(find "$OUT" -name "*.html" | wc -l | tr -d ' ')
SIZE=$(du -sh "$OUT" | cut -f1)
echo "==> Export listo: $PAGES páginas HTML, $SIZE en $OUT/"
echo "    Previsualiza local:  (cd export && python3 -m http.server 9000) y abre http://localhost:9000/"
echo "    Comprimir para enviar:  tar -czf mitsa-preview.tgz -C export ."
echo ""
echo "    NOTA: es un espejo estático. Formularios (Contact Form 7) NO funcionan"
echo "    en el export — para probar envíos reales se necesita el WP vivo o un staging."
