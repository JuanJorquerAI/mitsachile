#!/usr/bin/env bash
# Apply the approved old-domain rules only after the acceptance gates pass.
set -euo pipefail
ROOT="$(cd "$(dirname "$0")/../.." && pwd)"
SSH_KEY="${SSH_KEY:-$HOME/.ssh/hostinger_aw}"
REMOTE="u549101671@46.202.94.242"
SSH_OPTS=(-i "$SSH_KEY" -p 65002 -o IdentitiesOnly=yes -o BatchMode=yes -o StrictHostKeyChecking=yes)
if [[ "${1:-}" != '--apply' ]]; then
    echo 'Usage: bash scripts/seo-migration/cutover.sh --apply'
    exit 2
fi
python3 - "$ROOT" <<'PY'
import json, sys
from pathlib import Path
p = Path(sys.argv[1]) / 'docs/entregables/migracion-seo-mitsa-org-2026-10-20'
for name, minimum in [('preflight.json', 52), ('destino-preparado.json', 230)]:
    d = json.loads((p / name).read_text())
    if d['failed'] != 0 or d['passed'] < minimum:
        raise SystemExit('Acceptance gate failed: ' + name)
print('Local acceptance gates passed.')
PY
php "$ROOT/scripts/seo-migration/build-redirects.php" > "$ROOT/scripts/seo-migration/redirects.htaccess"
scp -i "$SSH_KEY" -P 65002 -o IdentitiesOnly=yes -o BatchMode=yes -o StrictHostKeyChecking=yes \
    "$ROOT/scripts/seo-migration/redirects.htaccess" "$REMOTE:/home/u549101671/mitsa-seo-migration-20261020/redirects.htaccess.next"
ssh "${SSH_OPTS[@]}" "$REMOTE" 'bash -s' <<'REMOTE_SCRIPT'
set -euo pipefail
B=/home/u549101671/mitsa-seo-migration-20261020
D=/home/u549101671/domains/mitsachile.com/public_html
N=/home/u549101671/domains/mitsa.org/public_html
for site in mitsa.org mitsachile.com; do
    test -s "$B/$site.files.tar.gz"
    gzip -t "$B/$site.sql.gz"
done
if grep -q 'BEGIN MITSA SEO MIGRATION' "$D/.htaccess"; then
    echo 'Migration already active; refusing to stack redirect blocks.' >&2
    exit 1
fi
cmp "$D/.htaccess" "$B/mitsachile.com.htaccess"
test -f "$N/smm2026/index.html"
test -f "$N/smm2026/MITSA-Company-Profile-2026.pdf"
test -f "$N/smm2026/francisco-de-la-iglesia.vcf"
test -f "$N/wp-content/mu-plugins/mitsa-seo-migration.php"
cd "$N"
test "$(wp option get blog_public)" = 1
cd "$D"
cp .htaccess "$B/mitsachile.com.pre-cutover.htaccess"
cat "$B/redirects.htaccess.next" "$B/mitsachile.com.pre-cutover.htaccess" > .htaccess.mitsa-next
chmod 644 .htaccess.mitsa-next
mv .htaccess.mitsa-next .htaccess
date -u '+%Y-%m-%dT%H:%M:%SZ' > "$B/cutover-at-utc.txt"
wp litespeed-purge all
sha256sum .htaccess > "$B/mitsachile.com.post-cutover.sha256"
echo 'Redirect block activated atomically.'
REMOTE_SCRIPT
for path in / /nosotros/; do
    result="$(curl --max-time 25 -sS -I -o /dev/null -w '%{http_code} %{redirect_url}' "https://mitsachile.com$path")" || result='request failed'
    if [[ "$result" != "301 https://mitsa.org$path" ]]; then
        echo "Immediate acceptance failed for $path: $result. Restoring previous routing." >&2
        bash "$ROOT/scripts/seo-migration/rollback-redirects.sh" --apply
        exit 1
    fi
done
echo 'Immediate external acceptance passed for home and Nosotros.'
