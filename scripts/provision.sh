#!/usr/bin/env bash
# Provisioning idempotente del sitio MITSA sobre un WordPress ya instalado
# (ver scripts/setup-wp.sh primero). Puede correrse tantas veces como se
# quiera: no duplica páginas, menús ni items.
#
# Uso: bash scripts/provision.sh

set -euo pipefail

REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
WP_DIR="$REPO_ROOT/wp"
WPCLI_BIN="$REPO_ROOT/scripts/wpcli.sh"
SITE_PORT="${MITSA_SITE_PORT:-8891}"

wpcli() {
	(cd "$WP_DIR" && "$WPCLI_BIN" "$@" --path=.)
}

# Extrae el primer entero de una salida de wp-cli, descartando avisos
# "Deprecated" de PHP 8.5 que a veces se cuelan en stdout.
first_int() {
	grep -E '^[0-9]+$' | head -1
}

echo "==> Symlink del tema..."
mkdir -p "$WP_DIR/wp-content/themes"
# -n (no-dereference): sin esto, si el symlink ya existe de una corrida
# previa, `ln -sf` lo sigue (por ser symlink-a-directorio) y crea el enlace
# ADENTRO del tema real (wp-content/themes/mitsa/mitsa) en vez de
# reemplazarlo — rompe la idempotencia y contamina el repo.
ln -sfn "$REPO_ROOT/wp-content/themes/mitsa" "$WP_DIR/wp-content/themes/mitsa"
wpcli theme activate mitsa >/dev/null

echo "==> Plugins base (ACF free, Contact Form 7, Yoast SEO)..."
for slug in advanced-custom-fields contact-form-7 wordpress-seo; do
	if wpcli plugin is-installed "$slug" 2>/dev/null; then
		wpcli plugin is-active "$slug" 2>/dev/null || wpcli plugin activate "$slug" >/dev/null
	else
		wpcli plugin install "$slug" --activate >/dev/null
	fi
done

echo "==> mu-plugin de Mailpit (correo local)..."
mkdir -p "$WP_DIR/wp-content/mu-plugins"
cp "$REPO_ROOT/scripts/mu-mitsa-mailpit.php" "$WP_DIR/wp-content/mu-plugins/mitsa-mailpit.php"

echo "==> Páginas del sitemap..."
# Nota: sin `declare -A` a propósito — el bash 3.2 de serie en macOS no
# soporta arrays asociativos. Un helper explícito por título es más portable
# que arrastrar una dependencia de bash 4+.
page_template_for() {
	case "$1" in
	Nosotros) echo "page-templates/template-nosotros.php" ;;
	Productos) echo "page-templates/template-productos.php" ;;
	Sectores) echo "page-templates/template-sectores.php" ;;
	Servicios) echo "page-templates/template-servicios.php" ;;
	Contacto) echo "page-templates/template-contacto.php" ;;
	*) echo "" ;;
	esac
}

ensure_page() {
	local title="$1" template
	local existing_id
	existing_id="$(wpcli post list --post_type=page --title="$title" --field=ID 2>/dev/null | first_int)"
	if [ -n "$existing_id" ]; then
		echo "   '$title' ya existe (ID $existing_id)" >&2
		echo "$existing_id"
	else
		local new_id
		new_id="$(wpcli post create --post_type=page --post_title="$title" --post_status=publish --porcelain 2>/dev/null | first_int)"
		echo "   '$title' creada (ID $new_id)" >&2
		echo "$new_id"
	fi
}

id_inicio="$(ensure_page "Inicio")"
id_nosotros="$(ensure_page "Nosotros")"
id_productos="$(ensure_page "Productos")"
id_representadas="$(ensure_page "Representadas")"
id_sectores="$(ensure_page "Sectores")"
id_servicios="$(ensure_page "Servicios")"
id_contacto="$(ensure_page "Contacto")"

for pair in "Nosotros:$id_nosotros" "Productos:$id_productos" "Sectores:$id_sectores" "Servicios:$id_servicios" "Contacto:$id_contacto"; do
	title="${pair%%:*}"
	id="${pair##*:}"
	template="$(page_template_for "$title")"
	if [ -n "$template" ]; then
		wpcli post meta update "$id" _wp_page_template "$template" >/dev/null
	fi
done

echo "==> Home estática..."
wpcli option update show_on_front page >/dev/null
wpcli option update page_on_front "$id_inicio" >/dev/null

echo "==> Menús primary/footer..."
for menu in primary footer; do
	wpcli menu list --fields=name 2>/dev/null | grep -qx "$menu" || wpcli menu create "$menu" >/dev/null
	wpcli menu location assign "$menu" "$menu" >/dev/null 2>&1 || true
done

for pair in "Nosotros:$id_nosotros" "Productos:$id_productos" "Representadas:$id_representadas" "Sectores:$id_sectores" "Servicios:$id_servicios" "Contacto:$id_contacto"; do
	title="${pair%%:*}"
	id="${pair##*:}"
	if wpcli menu item list primary --fields=object_id --format=csv 2>/dev/null | grep -qx "$id"; then
		echo "   '$title' ya está en el menú primary"
	else
		wpcli menu item add-post primary "$id" >/dev/null
		echo "   '$title' agregada al menú primary"
	fi
done

echo "==> Ítems de navegación adicionales (Casos de éxito, Biblioteca técnica)..."
for entry in "Casos de éxito|/casos/" "Biblioteca técnica|/biblioteca/"; do
	label="${entry%%|*}"
	url="${entry##*|}"
	if wpcli menu item list primary --fields=title --format=csv 2>/dev/null | sed 's/^"//;s/"$//' | grep -qx "$label"; then
		echo "   '$label' ya está en el menú primary"
	else
		wpcli menu item add-custom primary "$label" "http://localhost:${SITE_PORT}${url}" >/dev/null
		echo "   '$label' agregada al menú primary (ítem custom, el archive del CPT lo crea su propio paso)"
	fi
done

echo "==> Permalinks amigables..."
wpcli rewrite structure '/%postname%/' --hard >/dev/null
wpcli rewrite flush --hard >/dev/null 2>&1 || true

echo "==> Servidor PHP local (puerto ${SITE_PORT})..."
if ! curl -s -o /dev/null "http://127.0.0.1:${SITE_PORT}/"; then
	nohup php -S "127.0.0.1:${SITE_PORT}" -t "$WP_DIR/" "$REPO_ROOT/scripts/router.php" \
		> /tmp/mitsa-wp-server.log 2>&1 &

	echo $! > /tmp/mitsa-wp-server.pid
	sleep 2
	echo "   Servidor arrancado, PID $(cat /tmp/mitsa-wp-server.pid)"
else
	echo "   Servidor ya está corriendo en el puerto ${SITE_PORT}"
fi

brew services start mailpit >/dev/null 2>&1 || true

echo "==> Smoke test..."
code="$(curl -s -o /dev/null -w '%{http_code}' "http://localhost:${SITE_PORT}/")"
echo "   Home -> HTTP $code"
for slug in nosotros productos representadas sectores servicios contacto; do
	code="$(curl -s -o /dev/null -w '%{http_code}' "http://localhost:${SITE_PORT}/$slug/")"
	echo "   /$slug/ -> HTTP $code"
done

echo "==> Listo. Sitio: http://localhost:${SITE_PORT}/  ·  wp-admin: admin / mitsa_admin_local  ·  Mailpit: http://localhost:8025/"
