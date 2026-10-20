#!/usr/bin/env bash
# Restores routing only, preserving all inquiries and current database content.
set -euo pipefail
SSH_KEY="${SSH_KEY:-$HOME/.ssh/hostinger_aw}"
if [[ "${1:-}" != '--apply' ]]; then
    echo 'Usage: bash scripts/seo-migration/rollback-redirects.sh --apply'
    exit 2
fi
ssh -i "$SSH_KEY" -p 65002 -o IdentitiesOnly=yes -o BatchMode=yes -o StrictHostKeyChecking=yes \
    u549101671@46.202.94.242 'bash -s' <<'REMOTE_SCRIPT'
set -euo pipefail
B=/home/u549101671/mitsa-seo-migration-20261020
D=/home/u549101671/domains/mitsachile.com/public_html
test -s "$B/mitsachile.com.pre-cutover.htaccess"
cp "$B/mitsachile.com.pre-cutover.htaccess" "$D/.htaccess.mitsa-rollback"
chmod 644 "$D/.htaccess.mitsa-rollback"
mv "$D/.htaccess.mitsa-rollback" "$D/.htaccess"
cd "$D"
wp litespeed-purge all
echo 'Old-domain routing restored; current databases were preserved.'
REMOTE_SCRIPT
