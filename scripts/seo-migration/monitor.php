<?php
/** Daily read-only SEO migration monitoring. Store reports outside the web root. */
if (!defined('WP_CLI') || !WP_CLI || home_url('/') !== 'https://mitsachile.com/') {
    exit(1);
}
$base = '/home/u549101671/mitsa-seo-migration-20261020';
if (!is_file($base . '/cutover-at-utc.txt')) {
    WP_CLI::error('The cutover timestamp is missing; monitoring was not started.');
}
$started = new DateTimeImmutable(trim(file_get_contents($base . '/cutover-at-utc.txt')));
$today = new DateTimeImmutable('now', new DateTimeZone('UTC'));
$age = (int) $started->diff($today)->format('%a');
if ($age > 90) {
    WP_CLI::line('The 90-day observation window has ended. Remove the documented Hostinger monitoring cron.');
    return;
}
$report = ['captured_at_utc' => gmdate('c'), 'day' => $age, 'checks' => [], 'search_console' => []];
$map = json_decode(file_get_contents($base . '/monitor-map.json'), true, 512, JSON_THROW_ON_ERROR);
foreach ($map as $entry) {
    $response = wp_remote_get($entry['url'], ['timeout' => 20, 'redirection' => 0, 'user-agent' => 'MITSA-SEO-Migration-Monitor/1.0']);
    $code = is_wp_error($response) ? 0 : wp_remote_retrieve_response_code($response);
    $location = is_wp_error($response) ? '' : wp_remote_retrieve_header($response, 'location');
    $ok = $code === $entry['status'] && ($entry['status'] !== 301 || $location === $entry['location']);
    $report['checks'][] = ['url' => $entry['url'], 'ok' => $ok, 'status' => $code, 'location' => $location];
    usleep(100000);
}
foreach (['/', '/nosotros/', '/soluciones/', '/representadas/', '/contacto/', '/smm2026/'] as $path) {
    $url = 'https://mitsa.org' . $path;
    $response = wp_remote_get($url, ['timeout' => 20, 'redirection' => 0]);
    $body = is_wp_error($response) ? '' : wp_remote_retrieve_body($response);
    $status = is_wp_error($response) ? 0 : wp_remote_retrieve_response_code($response);
    $meta_noindex = false;
    $headers = is_wp_error($response) ? '' : wp_remote_retrieve_header($response, 'x-robots-tag');
    $canonical = false;
    if ($body !== '') {
        $doc = new DOMDocument();
        $doc->loadHTML($body, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);
        $xpath = new DOMXPath($doc);
        foreach ($xpath->query('//meta[translate(@name,"ABCDEFGHIJKLMNOPQRSTUVWXYZ","abcdefghijklmnopqrstuvwxyz")="robots"]') as $meta) {
            $meta_noindex = $meta_noindex || preg_match('/\bnoindex\b/i', $meta->getAttribute('content')) === 1;
        }
        $nodes = $xpath->query('//link[@rel="canonical"]/@href');
        $canonical = $nodes->length === 1 && $nodes->item(0)->nodeValue === $url;
    }
    $report['checks'][] = ['url' => $url, 'ok' => $status === 200 && !$meta_noindex && stripos((string) $headers, 'noindex') === false && $canonical && str_contains($body, 'GT-577M5DL3'), 'status' => $status, 'canonical_ok' => $canonical, 'meta_noindex' => $meta_noindex];
}
try {
    $context = new Google\Site_Kit\Context(WP_PLUGIN_DIR . '/google-site-kit/google-site-kit.php');
    $modules = new Google\Site_Kit\Core\Modules\Modules($context);
    $module = $modules->get_module('search-console');
    $warm = $module->get_data('sites');
    if (is_wp_error($warm)) {
        throw new RuntimeException($warm->get_error_code() . ': ' . $warm->get_error_message());
    }
    $client = $module->get_client();
    $client->setDefer(false);
    $service = new Google\Site_Kit_Dependencies\Google\Service\SearchConsole($client);
    foreach (['https://mitsachile.com/', 'https://mitsa.org/'] as $property) {
        $request = new Google\Site_Kit_Dependencies\Google\Service\SearchConsole\SearchAnalyticsQueryRequest([
            'startDate' => gmdate('Y-m-d', strtotime('-30 days')),
            'endDate' => gmdate('Y-m-d', strtotime('-3 days')),
            'dimensions' => ['date'], 'dataState' => 'final', 'rowLimit' => 1000,
        ]);
        $response = $service->searchanalytics->query($property, $request);
        $report['search_console'][$property] = $response;
    }
} catch (Throwable $error) {
    $report['google_error'] = $error->getMessage();
}
$report['passed'] = count(array_filter($report['checks'], static fn(array $r): bool => $r['ok']));
$report['failed'] = count($report['checks']) - $report['passed'];
$report['ok'] = $report['failed'] === 0 && !isset($report['google_error']);
$directory = $base . '/daily';
if (!is_dir($directory)) {
    mkdir($directory, 0700, true);
}
$file = $directory . '/' . gmdate('Y-m-d') . '.json';
file_put_contents($file, wp_json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
chmod($file, 0600);
WP_CLI::line(wp_json_encode(['report' => $file, 'day' => $age, 'passed' => $report['passed'], 'failed' => $report['failed'], 'google_ok' => !isset($report['google_error'])]));
if (!$report['ok']) {
    WP_CLI::halt(1);
}
