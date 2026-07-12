<?php
/**
 * SEO — fallback mínimo (title tag dinámico + meta description).
 *
 * IMPORTANTE: esto NO reemplaza un plugin SEO real. Es solo un fallback para
 * que el sitio tenga <title> y meta description razonables mientras no haya
 * un plugin instalado. Para producción, instalar y configurar Yoast SEO o
 * Rank Math — ambos manejan title/meta description, Open Graph, schema.org,
 * sitemap.xml, etc. de forma mucho más completa que este archivo (ver
 * CLAUDE.md: "SEO inicial" en Alcance técnico).
 *
 * Si se instala un plugin SEO real, desactivar estos hooks para evitar
 * conflictos (ambos intentarían imprimir meta description).
 *
 * @package mitsa
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Imprime una meta description básica en <head>.
 *
 * Prioridad: excerpt manual > primeros ~160 caracteres del contenido >
 * tagline del sitio (para home).
 */
function mitsa_meta_description_fallback() {
	// No pisar un plugin SEO real si está activo.
	if ( defined( 'WPSEO_VERSION' ) || class_exists( 'RankMath' ) ) {
		return;
	}

	$description = '';

	if ( is_singular() ) {
		global $post;

		if ( $post instanceof WP_Post ) {
			if ( ! empty( $post->post_excerpt ) ) {
				$description = wp_strip_all_tags( $post->post_excerpt );
			} else {
				$description = wp_strip_all_tags( $post->post_content );
			}
		}
	} elseif ( is_home() || is_front_page() ) {
		$description = get_bloginfo( 'description' );
	}

	$description = trim( $description );

	if ( empty( $description ) ) {
		return;
	}

	$description = wp_html_excerpt( $description, 160, '…' );

	printf( '<meta name="description" content="%s">' . "\n", esc_attr( $description ) );
}
add_action( 'wp_head', 'mitsa_meta_description_fallback', 1 );

/**
 * Personaliza el separador del title tag generado por `add_theme_support( 'title-tag' )`.
 *
 * WordPress ya arma el <title> automáticamente (ver functions.php); esto
 * solo ajusta el separador visual entre "Página · Sitio".
 */
function mitsa_document_title_separator( $sep ) {
	if ( defined( 'WPSEO_VERSION' ) || class_exists( 'RankMath' ) ) {
		return $sep;
	}

	return '·';
}
add_filter( 'document_title_separator', 'mitsa_document_title_separator' );
