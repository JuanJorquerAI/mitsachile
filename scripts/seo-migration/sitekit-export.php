<?php
/** Read Search Console through the existing Site Kit authorization; never output tokens. */
if (!defined('WP_CLI') || !WP_CLI) {
    exit(1);
}
$domain = (string) wp_parse_url(home_url(), PHP_URL_HOST);
if (!in_array($domain, ['mitsachile.com', 'mitsa.org'], true)) {
    WP_CLI::error('Unexpected site.');
}
$context = new Google\Site_Kit\Context(WP_PLUGIN_DIR . '/google-site-kit/google-site-kit.php');
$modules = new Google\Site_Kit\Core\Modules\Modules($context);
$module = $modules->get_module('search-console');
$end = new DateTimeImmutable('2026-10-17', new DateTimeZone('America/Los_Angeles'));
$requests = [
    'sites' => ['sites', []],
];
foreach (['16months' => '2025-06-20', '90days' => '2026-07-20', '28days' => '2026-09-20'] as $label => $start) {
    foreach (['pages' => ['page'], 'queries' => ['query'], 'dates' => ['date']] as $group => $dimensions) {
        $requests[$label . '-' . $group] = ['searchanalytics', [
            'startDate' => $start,
            'endDate' => $end->format('Y-m-d'),
            'dimensions' => $dimensions,
            'rowLimit' => 25000,
        ]];
    }
}
$report = ['site' => home_url('/'), 'captured_at_utc' => gmdate('c'), 'reports' => []];
foreach ($requests as $name => [$point, $args]) {
    $response = $module->get_data($point, $args);
    if (is_wp_error($response)) {
        $report['reports'][$name] = ['ok' => false, 'error_code' => $response->get_error_code(), 'message' => $response->get_error_message()];
        // A failed authorization cannot be fixed by repeating reports.
        break;
    }
    $report['reports'][$name] = ['ok' => true, 'request' => $args, 'data' => $response];
}
WP_CLI::line(wp_json_encode($report, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
