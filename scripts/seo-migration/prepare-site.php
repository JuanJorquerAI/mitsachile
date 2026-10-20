<?php
/** One-time, guarded preparation of mitsa.org; run with wp eval-file. */
if (!defined('WP_CLI') || !WP_CLI || home_url('/') !== 'https://mitsa.org/') {
    exit(1);
}
$backup = '/home/u549101671/mitsa-seo-migration-20261020';
if (!is_file($backup . '/mitsa.org.sql.gz') || !is_file($backup . '/mitsa.org.files.tar.gz')) {
    WP_CLI::error('Required backups are missing.');
}
$state_path = $backup . '/preparation-state.json';
if (file_exists($state_path)) {
    WP_CLI::error('Preparation already started; inspect saved state before rerunning.');
}
$posts = get_posts(['post_type' => ['page', 'post', 'solucion', 'industria', 'proyecto'], 'post_status' => 'publish', 'posts_per_page' => -1]);
$state = ['captured_at_utc' => gmdate('c'), 'blog_public' => get_option('blog_public'), 'wpseo_titles' => get_option('wpseo_titles'), 'wpseo_taxonomy_meta' => get_option('wpseo_taxonomy_meta'), 'posts' => []];
foreach ($posts as $post) {
    $state['posts'][$post->ID] = ['status' => $post->post_status, 'description' => get_post_meta($post->ID, '_yoast_wpseo_metadesc', true)];
}
if (file_put_contents($state_path, wp_json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) === false) {
    WP_CLI::error('Could not save preparation state.');
}
chmod($state_path, 0600);
$descriptions = [
    109 => 'Aviso de la planta de tratamiento de aguas servidas ORCA IV de Evac en la revista Visión Acuícola. Publicación del archivo técnico de MITSA.',
    111 => 'Columna de Eduardo De la Iglesia sobre selección de plantas de tratamiento de aguas servidas, publicada en Visión Acuícola en diciembre de 2018.',
    113 => 'Columna de Eduardo De la Iglesia sobre tecnologías de tratamiento de aguas servidas, publicada en la revista Visión Acuícola en octubre de 2018.',
    115 => 'Publicación de MITSA en Visión Acuícola sobre selección de plantas de tratamiento de aguas servidas y sistemas sanitarios a bordo.',
    116 => 'Presentación de la planta de tratamiento de aguas servidas ORCA IV de Evac. Consulte esta publicación del archivo técnico de MITSA.',
    124 => 'Conozca el proyecto SOCIBER · Dique Valparaíso y sus antecedentes publicados por MITSA. Consulte el alcance y las soluciones técnicas del proyecto.',
    125 => 'Conozca ASENAV · Proyecto 193 y sus antecedentes publicados por MITSA. Consulte el alcance y las soluciones técnicas de este proyecto naval.',
];
foreach ($descriptions as $id => $description) {
    $post = get_post($id);
    if (!$post || !isset($state['posts'][$id])) {
        WP_CLI::error('Expected published post missing: ' . $id);
    }
    if (get_post_meta($id, '_yoast_wpseo_metadesc', true) === '') {
        update_post_meta($id, '_yoast_wpseo_metadesc', $description);
    }
}
$sample = get_post(1);
if (!$sample || $sample->post_name !== 'hello-world') {
    WP_CLI::error('Unexpected sample post; refusing to change it.');
}
$result = wp_update_post(['ID' => 1, 'post_status' => 'draft'], true);
if (is_wp_error($result)) {
    WP_CLI::error($result->get_error_message());
}
$options = get_option('wpseo_titles', []);
$options['noindex-author-wpseo'] = true;
update_option('wpseo_titles', $options);
$news = get_term_by('slug', 'noticias-y-actualidad', 'category');
if ($news instanceof WP_Term) {
    WPSEO_Taxonomy_Meta::set_value($news->term_id, 'category', 'desc', 'Noticias y publicaciones del archivo técnico de MITSA: tecnologías, sistemas sanitarios y tratamiento de aguas para aplicaciones marítimas.');
}
update_option('blog_public', 1);
wp_cache_flush();
WP_CLI::success('Prepared mitsa.org: visibility, metadata and reversible sample removal.');
