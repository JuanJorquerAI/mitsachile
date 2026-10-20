#!/bin/sh
set -eu
umask 077
BASE=/home/u549101671/mitsa-seo-migration-20261020
cd /home/u549101671/domains/mitsachile.com/public_html
exec /usr/bin/flock -n "$BASE/monitor.lock" /usr/local/bin/wp --user=1 eval-file "$BASE/monitor.php" > "$BASE/monitor-last.log" 2>&1
