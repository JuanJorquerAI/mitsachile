#!/usr/bin/env bash
# =============================================================================
# legacy-descarga.sh — Descarga los ARCHIVOS del sitio de producción de
# mitsachile.com (el WordPress viejo) vía FTP/FTPS a un directorio de trabajo
# local, para luego montarlo en Local by WP Engine (ver legacy-guia-local.md).
#
# NO es destructivo:
#   - Solo LEE de producción (mirror en modo descarga; nunca sube ni borra
#     en el servidor).
#   - NO borra archivos locales que ya no estén en producción (sin --delete).
#   - Es idempotente: re-ejecutarlo solo trae archivos nuevos o modificados
#     (lftp mirror --continue --only-newer), así que se puede correr las
#     veces que haga falta sin volver a bajar todo.
#
# Requiere un archivo .env en la raíz del repo (gitignoreado). Variables:
#
#   Opción A — explícitas de FTP (tienen prioridad):
#     MITSA_FTP_HOST=ftp.mitsachile.com   # o mitsachile.com
#     MITSA_FTP_USER=usuario_ftp
#     MITSA_FTP_PASS=clave_ftp
#
#   Opción B — derivar de las credenciales de cPanel ya presentes en .env:
#     MITSA_CPANEL_URL=https://mitsachile.com:2083   # se le quita esquema y puerto
#     MITSA_CPANEL_USER=...
#     MITSA_CPANEL_PASS=...
#   (Si faltan las MITSA_FTP_*, el script usa las MITSA_CPANEL_* como fallback.
#    El usuario de cPanel suele funcionar también como usuario FTP principal.)
#
#   Opcionales (con default):
#     MITSA_FTP_REMOTE_ROOT=public_html   # docroot del sitio en el hosting
#     MITSA_FTP_PORT=21                   # puerto FTP de control
#     MITSA_FTP_PROTOCOL=ftps             # ftps (recomendado) | ftp (plano)
#
# Uso:
#   bash scripts/legacy-descarga.sh --dry-run   # valida y muestra el plan, NO conecta
#   bash scripts/legacy-descarga.sh             # descarga real a staging/legacy-download/
#
# Salida: staging/legacy-download/  (gitignoreado — ver .gitignore)
# =============================================================================
set -euo pipefail

REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
ENV_FILE="$REPO_ROOT/.env"
DEST_DIR="$REPO_ROOT/staging/legacy-download"

# --- Parseo de argumentos ----------------------------------------------------
DRY_RUN=0
for arg in "$@"; do
	case "$arg" in
		--dry-run) DRY_RUN=1 ;;
		-h|--help)
			# Imprime la cabecera de documentación de este archivo y sale.
			sed -n '2,45p' "${BASH_SOURCE[0]}" | sed 's/^# \{0,1\}//'
			exit 0
			;;
		*)
			echo "ERROR: argumento desconocido: $arg (usa --dry-run o --help)" >&2
			exit 2
			;;
	esac
done

# --- Carga del .env ----------------------------------------------------------
if [ ! -f "$ENV_FILE" ]; then
	echo "ERROR: falta el archivo .env en $REPO_ROOT" >&2
	echo "       Créalo (está gitignoreado) con las variables MITSA_FTP_* o MITSA_CPANEL_*." >&2
	echo "       Ver la cabecera de este script: bash scripts/legacy-descarga.sh --help" >&2
	exit 1
fi
# Se desactiva 'nounset' (-u) solo mientras se carga el .env: algunos valores
# (p. ej. contraseñas) pueden contener metacaracteres como $! que, bajo -u,
# bash intentaría expandir y abortaría con "unbound variable".
set -a; set +u
# shellcheck disable=SC1090
source "$ENV_FILE"
set -u; set +a

# --- Resolución de credenciales: FTP explícito con fallback a cPanel ---------
# Deriva el host de cPanel quitándole el esquema (https://) y el puerto (:2083).
derive_host_from_url() {
	local url="${1:-}"
	url="${url#*://}"   # quita esquema
	url="${url%%/*}"    # quita cualquier path
	url="${url%%:*}"    # quita el puerto
	printf '%s' "$url"
}

FTP_HOST="${MITSA_FTP_HOST:-}"
FTP_USER="${MITSA_FTP_USER:-}"
FTP_PASS="${MITSA_FTP_PASS:-}"

if [ -z "$FTP_HOST" ]; then
	FTP_HOST="$(derive_host_from_url "${MITSA_CPANEL_URL:-}")"
fi
FTP_USER="${FTP_USER:-${MITSA_CPANEL_USER:-}}"
FTP_PASS="${FTP_PASS:-${MITSA_CPANEL_PASS:-}}"

REMOTE_ROOT="${MITSA_FTP_REMOTE_ROOT:-public_html}"
FTP_PORT="${MITSA_FTP_PORT:-21}"
FTP_PROTOCOL="${MITSA_FTP_PROTOCOL:-ftps}"

# --- Validación explícita: falla claro si falta algo -------------------------
missing=0
check_var() {
	local name="$1" value="$2"
	if [ -z "$value" ]; then
		echo "ERROR: falta '$name' — defínela en .env como MITSA_FTP_* o vía MITSA_CPANEL_*." >&2
		missing=1
	fi
}
check_var "host FTP (MITSA_FTP_HOST / MITSA_CPANEL_URL)" "$FTP_HOST"
check_var "usuario FTP (MITSA_FTP_USER / MITSA_CPANEL_USER)" "$FTP_USER"
check_var "clave FTP (MITSA_FTP_PASS / MITSA_CPANEL_PASS)" "$FTP_PASS"
[ "$missing" -eq 0 ] || exit 1

case "$FTP_PROTOCOL" in
	ftp|ftps) : ;;
	*) echo "ERROR: MITSA_FTP_PROTOCOL debe ser 'ftp' o 'ftps' (valor: $FTP_PROTOCOL)" >&2; exit 1 ;;
esac

# --- Reporte del plan (sin exponer la contraseña) ----------------------------
echo "==> Plan de descarga del sitio legacy (mitsachile.com)"
echo "    Protocolo   : $FTP_PROTOCOL"
echo "    Host        : $FTP_HOST"
echo "    Puerto      : $FTP_PORT"
echo "    Usuario     : $FTP_USER"
echo "    Clave       : (definida, oculta)"
echo "    Remote root : $REMOTE_ROOT"
echo "    Destino     : $DEST_DIR"
echo "    Modo        : $([ "$DRY_RUN" -eq 1 ] && echo 'DRY-RUN (no conecta, no descarga)' || echo 'DESCARGA REAL')"

if [ "$DRY_RUN" -eq 1 ]; then
	echo
	echo "==> DRY-RUN: validación OK. No se realizó ninguna conexión a producción."
	echo "    Para descargar de verdad, re-ejecuta SIN --dry-run."
	exit 0
fi

# --- Verificación de herramienta: lftp (preferida) ---------------------------
# lftp mirror hace descarga recursiva, reanudable e idempotente. Si no está,
# se indica cómo instalarlo (curl no hace mirror recursivo cómodamente).
if ! command -v lftp >/dev/null 2>&1; then
	echo "ERROR: 'lftp' no está instalado y es la herramienta usada para el mirror." >&2
	echo "       Instálalo con: brew install lftp" >&2
	echo "       (Alternativa manual con curl: curl --ftp-ssl -u USER:PASS ftp://HOST/RUTA/ARCHIVO -o destino," >&2
	echo "        pero no hace descarga recursiva de todo el árbol; se recomienda lftp.)" >&2
	exit 1
fi

mkdir -p "$DEST_DIR"

# --- Descarga con lftp -------------------------------------------------------
# - ssl-allow/ssl-force según protocolo (ftps fuerza TLS explícito).
# - ssl-protect-data on: cifra también el canal de datos.
# - mirror (sin --reverse): SOLO baja de remoto a local.
# - --continue --only-newer: idempotencia (reanuda y solo trae lo cambiado).
# - SIN --delete: NO borra archivos locales que ya no estén en el remoto.
# - -x uploads/cache : opcional, se deja comentado por si quieres omitir caches.
if [ "$FTP_PROTOCOL" = "ftps" ]; then
	SSL_SETTINGS="set ftp:ssl-force true; set ftp:ssl-protect-data true; set ssl:verify-certificate no;"
else
	SSL_SETTINGS="set ftp:ssl-allow false;"
fi

echo "==> Iniciando mirror (esto puede tardar según el tamaño del sitio)..."
# La contraseña se pasa DENTRO del script de lftp (comando 'open'), no en la
# línea de comandos: así no aparece en 'ps' ni en el historial del shell.
# No la imprimimos en ningún log.
lftp <<LFTP_SCRIPT
set net:max-retries 3
set net:timeout 20
set ftp:passive-mode true
$SSL_SETTINGS
open -u "$FTP_USER","$FTP_PASS" -p "$FTP_PORT" "$FTP_HOST"
mirror --continue --only-newer --parallel=2 --verbose "$REMOTE_ROOT" "$DEST_DIR"
bye
LFTP_SCRIPT

echo
echo "==> Descarga completada."
echo "    Archivos en: $DEST_DIR"
echo "    Siguiente paso: montar la copia en Local by WP Engine."
echo "    Ver la guía: scripts/legacy-guia-local.md"
