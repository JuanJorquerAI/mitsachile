<?php
/** Build a scoped redirect block; its output precedes existing WordPress/LiteSpeed rules. */
$root = dirname(__DIR__, 2);
$input = $root . '/docs/entregables/migracion-seo-mitsa-org-2026-10-20/mapa-redirecciones.csv';
$stream = fopen($input, 'r');
if (!$stream) {
    throw new RuntimeException('URL map is missing.');
}
$header = fgetcsv($stream, null, ',', '"', '');
$header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);
$map = [];
while (($values = fgetcsv($stream, null, ',', '"', '')) !== false) {
    $row = array_combine($header, $values);
    if (!$row || !$row['destino_propuesto']) {
        continue;
    }
    if (parse_url($row['origen'], PHP_URL_HOST) !== 'mitsachile.com' || parse_url($row['destino_propuesto'], PHP_URL_HOST) !== 'mitsa.org') {
        throw new RuntimeException('Unexpected domain in URL map.');
    }
    $map[trim((string) parse_url($row['origen'], PHP_URL_PATH), '/')] = $row['destino_propuesto'];
}
fclose($stream);
// Historical URL found in Search Console, absent from the original public sitemap.
$map['productos'] = 'https://mitsa.org/soluciones/';
unset($map['hello-world']);
ksort($map);
$lines = [
    '# BEGIN MITSA SEO MIGRATION 2026-10-20',
    '<IfModule mod_rewrite.c>',
    'RewriteEngine On',
    '# Only public GET/HEAD requests on the old domain participate in this move.',
    'RewriteCond %{HTTP_HOST} ^(?:www\\.)?mitsachile\\.com(?::[0-9]+)?$ [NC]',
    'RewriteCond %{REQUEST_METHOD} ^(?:GET|HEAD)$',
    'RewriteCond %{REQUEST_URI} !^/(?:wp-admin(?:/|$)|wp-login\\.php(?:/|$)|wp-json(?:/|$)|wp-cron\\.php$|wp-comments-post\\.php$|xmlrpc\\.php$|robots\\.txt$|[^/]*sitemap[^/]*\\.xml$|google[^/]*\\.html$|\\.well-known(?:/|$)) [NC]',
    'RewriteCond %{QUERY_STRING} !(^|&)(?:rest_route|preview|preview_id|preview_nonce)= [NC]',
    'RewriteRule ^ - [E=MITSA_PUBLIC_MOVE:1]',
    '',
    '# Demonstration content was retired; no unrelated destination is substituted.',
    'RewriteCond %{ENV:MITSA_PUBLIC_MOVE} =1',
    'RewriteRule ^(?:hello-world|a-sample-blog-post)/?$ - [G,L,NC]',
    'RewriteCond %{ENV:MITSA_PUBLIC_MOVE} =1',
    'RewriteRule ^trituradores-organicos/?$ - [R=404,L,NC]',
    '',
];
foreach ($map as $path => $destination) {
    $pattern = $path === '' ? '^$' : '^' . preg_quote($path, '~') . '/?$';
    $lines[] = 'RewriteCond %{ENV:MITSA_PUBLIC_MOVE} =1';
    $lines[] = 'RewriteRule ' . $pattern . ' ' . $destination . ' [R=301,L,NC]';
}
$lines = array_merge($lines, [
    '',
    '# Move files only when the matching destination file actually exists.',
    '# REQUEST_URI keeps the original path during internal WordPress rewrites.',
    'RewriteCond %{ENV:MITSA_PUBLIC_MOVE} =1',
    'RewriteCond /home/u549101671/domains/mitsa.org/public_html%{REQUEST_URI} -f',
    'RewriteRule ^ https://mitsa.org%{REQUEST_URI} [R=301,L,NE]',
    '</IfModule>',
    '# END MITSA SEO MIGRATION 2026-10-20',
    '',
]);
echo implode("\n", $lines);
