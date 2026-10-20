<?php
/** Execute approved migration tasks with Site Kit's existing Google authorization. */
if (!defined('WP_CLI') || !WP_CLI || wp_parse_url(home_url(), PHP_URL_HOST) !== 'mitsachile.com') {
    exit(1);
}
$context = new Google\Site_Kit\Context(WP_PLUGIN_DIR . '/google-site-kit/google-site-kit.php');
$modules = new Google\Site_Kit\Core\Modules\Modules($context);
$action = $args[0] ?? 'status';
$sc = $modules->get_module('search-console');
$warm = $sc->get_data('sites');
if (is_wp_error($warm)) {
    WP_CLI::error($warm->get_error_code() . ': ' . $warm->get_error_message());
}
$client = $sc->get_client();
$client->setDefer(false);
$search = new Google\Site_Kit_Dependencies\Google\Service\SearchConsole($client);
$result = ['action' => $action, 'captured_at_utc' => gmdate('c')];
try {
    if ($action === 'verify-new-site') {
        $module = $modules->get_module('site-verification');
        $warm = $module->get_data('verified-sites');
        if (is_wp_error($warm)) {
            WP_CLI::error($warm->get_error_code() . ': ' . $warm->get_error_message());
        }
        $vclient = $module->get_client();
        $vclient->setDefer(false);
        $service = new Google\Site_Kit_Dependencies\Google\Service\SiteVerification($vclient);
        $request = new Google\Site_Kit_Dependencies\Google\Service\SiteVerification\SiteVerificationWebResourceGettokenRequest([
            'site' => ['type' => 'SITE', 'identifier' => 'https://mitsa.org/'],
            'verificationMethod' => 'FILE',
        ]);
        $token = $service->webResource->getToken($request)->getToken();
        if (!preg_match('/\Agoogle[a-z0-9]+\.html\z/iD', $token)) {
            WP_CLI::error('Unexpected verification filename.');
        }
        $file = '/home/u549101671/domains/mitsa.org/public_html/' . $token;
        $content = 'google-site-verification: ' . $token;
        if (file_exists($file) && file_get_contents($file) !== $content) {
            WP_CLI::error('Verification file already exists with different content.');
        }
        if (!file_exists($file)) {
            if (file_put_contents($file, $content) === false) {
                WP_CLI::error('Could not write verification file.');
            }
            chmod($file, 0644);
        }
        $response = wp_remote_get('https://mitsa.org/' . $token, ['timeout' => 20]);
        if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200 || trim(wp_remote_retrieve_body($response)) !== $content) {
            WP_CLI::error('Public verification file does not match.');
        }
        $resource = new Google\Site_Kit_Dependencies\Google\Service\SiteVerification\SiteVerificationWebResourceResource([
            'site' => ['type' => 'SITE', 'identifier' => 'https://mitsa.org/'],
        ]);
        $verified = $service->webResource->insert('FILE', $resource);
        $search->sites->add('https://mitsa.org/');
        $result['verified'] = $verified->getSite()->getIdentifier();
        $result['permission'] = $search->sites->get('https://mitsa.org/')->getPermissionLevel();
        $result['verification_file'] = $token;
    } elseif ($action === 'ownership-status' || $action === 'preserve-existing-owner') {
        $module = $modules->get_module('site-verification');
        $warm = $module->get_data('verified-sites');
        if (is_wp_error($warm)) {
            WP_CLI::error($warm->get_error_message());
        }
        $vclient = $module->get_client();
        $vclient->setDefer(false);
        $service = new Google\Site_Kit_Dependencies\Google\Service\SiteVerification($vclient);
        $resources = $service->webResource->listWebResource()->getItems();
        $selected = [];
        foreach ($resources as $resource) {
            $identifier = $resource->getSite()->getIdentifier();
            if (in_array($identifier, ['https://mitsachile.com/', 'https://mitsa.org/'], true)) {
                $selected[$identifier] = $resource;
                $result['sites'][$identifier] = ['id' => $resource->getId(), 'owners' => $resource->getOwners()];
            }
        }
        if ($action === 'preserve-existing-owner') {
            $existing = 'juan@aplicacionesweb.cl';
            $old = $selected['https://mitsachile.com/'] ?? null;
            $new = $selected['https://mitsa.org/'] ?? null;
            if (!$old || !$new || !in_array($existing, (array) $old->getOwners(), true)) {
                WP_CLI::error('Target owner is not a verified owner on the old site; no access change made.');
            }
            $new->setOwners(array_values(array_unique(array_merge((array) $new->getOwners(), [$existing]))));
            $updated = $service->webResource->update($new->getId(), $new);
            $result['preserved_owner'] = $existing;
            $result['new_owners'] = $updated->getOwners();
        }
    } elseif ($action === 'analytics-stream' || $action === 'migrate-analytics-stream') {
        $admin = new Google\Site_Kit_Dependencies\Google\Service\GoogleAnalyticsAdmin($client);
        $name = 'properties/546711733/dataStreams/15305402446';
        $stream = $admin->properties_dataStreams->get($name);
        $result['before'] = json_decode(wp_json_encode($stream), true);
        if ($stream->getWebStreamData()->getMeasurementId() !== 'G-BNP4L272V2') {
            WP_CLI::error('Unexpected measurement ID; refusing to modify stream.');
        }
        if ($action === 'migrate-analytics-stream') {
            $backup = '/home/u549101671/mitsa-seo-migration-20261020/analytics-stream-before.json';
            if (!is_file($backup)) {
                file_put_contents($backup, wp_json_encode($stream, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                chmod($backup, 0600);
            }
            $web = $stream->getWebStreamData();
            $web->setDefaultUri('https://mitsa.org');
            $stream->setWebStreamData($web);
            $admin->properties_dataStreams->patch($name, $stream, ['updateMask' => 'web_stream_data.default_uri']);
            $result['after'] = $admin->properties_dataStreams->get($name);
        }
    } elseif ($action === 'analytics-baseline' || $action === 'analytics-realtime') {
        $data = new Google\Site_Kit_Dependencies\Google\Service\AnalyticsData($client);
        if ($action === 'analytics-baseline') {
            foreach (['90days' => '2026-07-20', '28days' => '2026-09-20'] as $label => $start) {
                $request = new Google\Site_Kit_Dependencies\Google\Service\AnalyticsData\RunReportRequest([
                    'dateRanges' => [['startDate' => $start, 'endDate' => '2026-10-17']],
                    'dimensions' => [['name' => 'hostName'], ['name' => 'sessionDefaultChannelGroup'], ['name' => 'landingPage']],
                    'metrics' => [['name' => 'sessions'], ['name' => 'activeUsers'], ['name' => 'keyEvents']],
                    'limit' => 10000,
                ]);
                $result['reports'][$label] = $data->properties->runReport('properties/546711733', $request);
            }
        } else {
            $request = new Google\Site_Kit_Dependencies\Google\Service\AnalyticsData\RunRealtimeReportRequest([
                'dimensions' => [['name' => 'eventName']],
                'metrics' => [['name' => 'eventCount']],
                'dimensionFilter' => ['filter' => ['fieldName' => 'eventName', 'stringFilter' => ['matchType' => 'EXACT', 'value' => 'seo_migration_check']]],
                'limit' => 10,
            ]);
            $result['report'] = $data->properties->runRealtimeReport('properties/546711733', $request);
        }
    } elseif ($action === 'submit-sitemap') {
        $search->sitemaps->submit('https://mitsa.org/', 'https://mitsa.org/sitemap_index.xml');
        $result['sitemaps'] = $search->sitemaps->listSitemaps('https://mitsa.org/');
    } elseif ($action === 'status') {
        foreach (['https://mitsachile.com/', 'https://mitsa.org/'] as $site) {
            try {
                $result['sites'][$site] = ['permission' => $search->sites->get($site)->getPermissionLevel(), 'sitemaps' => $search->sitemaps->listSitemaps($site)];
            } catch (Exception $e) {
                $result['sites'][$site] = ['error_code' => $e->getCode(), 'message' => $e->getMessage()];
            }
        }
    } else {
        WP_CLI::error('Unknown action.');
    }
} catch (Exception $e) {
    WP_CLI::error($e->getCode() . ': ' . $e->getMessage());
}
WP_CLI::line(wp_json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
