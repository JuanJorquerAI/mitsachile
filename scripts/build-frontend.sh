#!/usr/bin/env bash
# Compila el frontend desacoplado (Astro SSG) y prepara la salida estática en export/
set -euo pipefail

REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
FRONTEND_DIR="$REPO_ROOT/frontend"
EXPORT_DIR="$REPO_ROOT/export"

echo "==> 1/3 Compilando frontend estático (Astro SSG)..."
cd "$FRONTEND_DIR"
npm run build

echo "==> 2/3 Sincronizando salida a $EXPORT_DIR..."
rm -rf "$EXPORT_DIR"
mkdir -p "$EXPORT_DIR"
cp -R "$FRONTEND_DIR/dist/"* "$EXPORT_DIR/"

PAGES=$(find "$EXPORT_DIR" -name "*.html" | wc -l | tr -d ' ')
SIZE=$(du -sh "$EXPORT_DIR" | cut -f1)

echo "==> 3/3 Build completado con éxito:"
echo "    - $PAGES páginas estáticas generadas"
echo "    - Peso total: $SIZE"
echo "    - Salida en: $EXPORT_DIR"
echo "    - Sitemap XML listo en $EXPORT_DIR/sitemap-index.xml"
echo ""
echo "Para previsualizar en local:"
echo "    cd frontend && npm run dev (puerto 8895)"
