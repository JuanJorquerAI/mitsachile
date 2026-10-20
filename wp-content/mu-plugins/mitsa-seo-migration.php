<?php
/**
 * Plugin Name: MITSA SEO migration
 * Description: Legacy URL mapping and sitemap policy for the approved move to mitsa.org.
 */
defined('ABSPATH') || exit;

if (wp_parse_url(home_url(), PHP_URL_HOST) !== 'mitsa.org') {
    return;
}

add_filter('mitsa_redirects', static function (array $map): array {
    $map['representaciones'] = '/representadas/';
    $map['productos'] = '/soluciones/';
    $map['tt-service/productos'] = '/soluciones/';
    return $map;
});

// Keep utility archives accessible without making them search landing pages.
add_filter('wpseo_robots', static function (string $robots): string {
    if (is_author() || is_category('uncategorized')) {
        return 'noindex, follow';
    }
    return $robots;
});
add_filter('wpseo_sitemap_exclude_author', static fn(array $users): array => []);
add_filter('wpseo_exclude_from_sitemap_by_term_ids', static function (array $ids): array {
    $term = get_term_by('slug', 'uncategorized', 'category');
    if ($term instanceof WP_Term) {
        $ids[] = (int) $term->term_id;
    }
    return array_values(array_unique($ids));
});

// The SMM microsite is static and is not part of WordPress's page provider.
add_filter('wpseo_sitemap_index', static function (string $xml): string {
    $path = ABSPATH . 'smm2026/sitemap.xml';
    if (is_file($path)) {
        $xml .= '<sitemap><loc>' . esc_url(home_url('/smm2026/sitemap.xml')) . '</loc></sitemap>';
    }
    return $xml;
});

// Retired demonstration content has no editorial equivalent.
add_action('template_redirect', static function (): void {
    $path = trim((string) wp_parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
    if (is_404() && in_array($path, ['hello-world', 'a-sample-blog-post'], true)) {
        status_header(410);
        nocache_headers();
        $template = get_404_template();
        if ($template !== '') {
            include $template;
        }
        exit;
    }
}, 0);
