<?php
/**
 * Synchronize the 5 regulatory technical articles into WordPress as drafts.
 * Usage via WP-CLI:
 *   wp eval-file sync-drafts.php --user=1
 */
if (!defined('WP_CLI') || !WP_CLI) {
    exit(1);
}

$payload_file = __DIR__ . '/blog-drafts-payload.json';
if (!file_exists($payload_file)) {
    WP_CLI::error("Payload file not found: $payload_file");
}

$articles = json_decode(file_get_contents($payload_file), true);
if (!$articles || !is_array($articles)) {
    WP_CLI::error("Invalid payload JSON in $payload_file");
}

$results = [];

foreach ($articles as $art) {
    $slug = $art['slug'];
    $title = $art['title'];
    $body_html = $art['body_html'];
    $excerpt = $art['excerpt'];
    $category_id = (int) $art['category_id'];
    $solution_ids = array_map('intval', (array) $art['solution_ids']);
    $reuse_id = !empty($art['reuse_id']) ? (int) $art['reuse_id'] : null;

    $post_id = 0;
    if ($reuse_id && get_post($reuse_id)) {
        $post_id = $reuse_id;
        $update_data = [
            'ID' => $post_id,
            'post_title' => $title,
            'post_name' => $slug,
            'post_content' => $body_html,
            'post_excerpt' => $excerpt,
            'post_status' => 'draft',
            'post_type' => 'post',
            'post_category' => [$category_id],
        ];
        wp_update_post($update_data);
    } else {
        // Search by slug
        $existing = get_page_by_path($slug, OBJECT, 'post');
        if ($existing) {
            $post_id = $existing->ID;
            $update_data = [
                'ID' => $post_id,
                'post_title' => $title,
                'post_name' => $slug,
                'post_content' => $body_html,
                'post_excerpt' => $excerpt,
                'post_status' => 'draft',
                'post_category' => [$category_id],
            ];
            wp_update_post($update_data);
        } else {
            $insert_data = [
                'post_title' => $title,
                'post_name' => $slug,
                'post_content' => $body_html,
                'post_excerpt' => $excerpt,
                'post_status' => 'draft',
                'post_type' => 'post',
                'post_category' => [$category_id],
            ];
            $post_id = wp_insert_post($insert_data);
            if (is_wp_error($post_id)) {
                WP_CLI::error("Failed to insert post $slug: " . $post_id->get_error_message());
            }
        }
    }

    // Yoast SEO meta
    if (!empty($art['seo_title'])) {
        update_post_meta($post_id, '_yoast_wpseo_title', $art['seo_title']);
    }
    if (!empty($art['seo_desc'])) {
        update_post_meta($post_id, '_yoast_wpseo_metadesc', $art['seo_desc']);
    }
    if (!empty($art['kw'])) {
        update_post_meta($post_id, '_yoast_wpseo_focuskw', $art['kw']);
    }

    // Related solution chips
    delete_post_meta($post_id, '_mitsa_art_soluciones');
    foreach ($solution_ids as $sid) {
        add_post_meta($post_id, '_mitsa_art_soluciones', $sid);
    }

    $results[] = [
        'id' => $post_id,
        'slug' => $slug,
        'title' => $title,
        'status' => get_post_status($post_id),
        'category' => get_cat_name($category_id),
        'preview_url' => "https://mitsa.org/?p={$post_id}&preview=true",
        'edit_url' => "https://mitsa.org/wp-admin/post.php?post={$post_id}&action=edit",
        'solutions' => $solution_ids,
    ];
}

WP_CLI::line(wp_json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
