#!/usr/bin/env bash
# Bootstrap del ambiente WordPress local para mitsachile (una sola vez).
# Instala herramientas vía Homebrew, crea la BD local y descarga/instala
# WordPress en wp/ (gitignoreado). Idempotente: puede correrse de nuevo
# sin duplicar nada.
#
# Uso: bash scripts/setup-wp.sh
# Requiere: Homebrew, PHP >= 8.0 (brew install php), MySQL/MariaDB.

set -euo pipefail

REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
WP_DIR="$REPO_ROOT/wp"
WPCLI="$REPO_ROOT/scripts/wpcli.sh"

DB_NAME="${MITSA_DB_NAME:-mitsa_dev}"
DB_USER="${MITSA_DB_USER:-mitsa_dev}"
DB_PASS="${MITSA_DB_PASS:-mitsa_dev_local_pw}"
SITE_PORT="${MITSA_SITE_PORT:-8891}"
SITE_URL="http://localhost:${SITE_PORT}"

echo "==> Verificando herramientas..."
command -v php >/dev/null || { echo "Falta PHP (brew install php)"; exit 1; }
command -v mysql >/dev/null || { echo "Falta MySQL/MariaDB client (brew install mariadb)"; exit 1; }
command -v brew >/dev/null || { echo "Falta Homebrew"; exit 1; }

brew list wp-cli &>/dev/null || brew install wp-cli
brew list mailpit &>/dev/null || brew install mailpit

echo "==> Arrancando MariaDB..."
brew services start mariadb >/dev/null 2>&1 || true
for i in $(seq 1 15); do
	mysqladmin ping >/dev/null 2>&1 && break
	sleep 2
done
mysqladmin ping >/dev/null 2>&1 || { echo "MariaDB no responde tras 30s"; exit 1; }

echo "==> Arrancando Mailpit..."
brew services start mailpit >/dev/null 2>&1 || true

echo "==> Creando base de datos y usuario local (si no existen)..."
mysql -e "CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -e "CREATE USER IF NOT EXISTS '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASS}';"
mysql -e "GRANT ALL PRIVILEGES ON \`${DB_NAME}\`.* TO '${DB_USER}'@'localhost';"
mysql -e "FLUSH PRIVILEGES;"

if [ ! -f "$WP_DIR/wp-load.php" ]; then
	echo "==> Descargando WordPress core en wp/..."
	mkdir -p "$WP_DIR"
	(cd "$WP_DIR" && "$WPCLI" core download --locale=es_ES --path=.)
else
	echo "==> WordPress core ya descargado, se omite."
fi

if [ ! -f "$WP_DIR/wp-config.php" ]; then
	echo "==> Generando wp-config.php..."
	(cd "$WP_DIR" && "$WPCLI" config create \
		--dbname="$DB_NAME" --dbuser="$DB_USER" --dbpass="$DB_PASS" \
		--dbhost=localhost --locale=es_ES --path=. --skip-check)
else
	echo "==> wp-config.php ya existe, se omite."
fi

if ! (cd "$WP_DIR" && "$WPCLI" core is-installed --path=. 2>/dev/null); then
	echo "==> Instalando WordPress..."
	(cd "$WP_DIR" && "$WPCLI" core install \
		--url="$SITE_URL" --title="MITSA (dev local)" \
		--admin_user=admin --admin_password=mitsa_admin_local \
		--admin_email=dev@aplicacionesweb.cl --path=.)
else
	echo "==> WordPress ya instalado, se omite."
fi

echo "==> Bootstrap completo. Corre ahora: bash scripts/provision.sh"
