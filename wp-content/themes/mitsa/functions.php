<?php
/**
 * Setup del tema MITSA.
 *
 * Tema custom clásico (PHP + CSS/JS plano, sin page builder ni build tools).
 * Todas las funciones globales usan el prefijo `mitsa_` para evitar colisiones.
 *
 * @package mitsa
 */

// Salir si se accede directamente al archivo.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MITSA_THEME_VERSION', '0.2.0' );
define( 'MITSA_THEME_DIR', get_template_directory() );
define( 'MITSA_THEME_URI', get_template_directory_uri() );

/**
 * Setup básico del tema: soporte de theme features y registro de menús.
 */
function mitsa_setup() {
	// Textdomain, preparado para futura traducción a inglés (ver CLAUDE.md).
	load_theme_textdomain( 'mitsa', MITSA_THEME_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'customize-selective-refresh-widgets' );

	register_nav_menus(
		array(
			'primary' => __( 'Menú principal', 'mitsa' ),
			'footer'  => __( 'Menú de pie de página', 'mitsa' ),
		)
	);
}
add_action( 'after_setup_theme', 'mitsa_setup' );

/**
 * Enqueue de estilos y scripts del tema.
 *
 * Solo CSS/JS plano: sin bundlers ni pasos de build. El JS del tema es
 * opcional y se engancha únicamente si el archivo existe.
 */
function mitsa_enqueue_assets() {
	wp_enqueue_style( 'mitsa-style', get_stylesheet_uri(), array(), MITSA_THEME_VERSION );

	$theme_js = MITSA_THEME_DIR . '/assets/js/theme.js';
	if ( file_exists( $theme_js ) ) {
		wp_enqueue_script( 'mitsa-theme', MITSA_THEME_URI . '/assets/js/theme.js', array(), MITSA_THEME_VERSION, true );
	}
}
add_action( 'wp_enqueue_scripts', 'mitsa_enqueue_assets' );

/**
 * Enqueue de estilos personalizados para el panel de administración y ACF.
 */
function mitsa_admin_enqueue_assets() {
	$admin_css = MITSA_THEME_DIR . '/assets/css/admin-acf.css';
	if ( file_exists( $admin_css ) ) {
		wp_enqueue_style(
			'mitsa-admin-acf',
			MITSA_THEME_URI . '/assets/css/admin-acf.css',
			array(),
			MITSA_THEME_VERSION . '.' . filemtime( $admin_css )
		);
	}

	$admin_js = MITSA_THEME_DIR . '/assets/js/admin-tabs.js';
	if ( file_exists( $admin_js ) ) {
		wp_enqueue_script(
			'mitsa-admin-tabs',
			MITSA_THEME_URI . '/assets/js/admin-tabs.js',
			array( 'jquery' ),
			MITSA_THEME_VERSION . '.' . filemtime( $admin_js ),
			true
		);
	}
}
add_action( 'admin_enqueue_scripts', 'mitsa_admin_enqueue_assets' );
add_action( 'acf/input/admin_enqueue_scripts', 'mitsa_admin_enqueue_assets' );

/**
 * Desactiva el editor de bloques (Gutenberg) en páginas para habilitar
 * la interfaz clásica y nativa completa de 2 columnas de ACF.
 */
add_filter( 'use_block_editor_for_post_type', function( $use_block_editor, $post_type ) {
	if ( 'page' === $post_type ) {
		return false;
	}
	return $use_block_editor;
}, 10, 2 );

/**
 * Registra las áreas de widgets del footer.
 */
function mitsa_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Pie de página', 'mitsa' ),
			'id'            => 'footer-1',
			'description'   => __( 'Widgets mostrados en el pie de página del sitio.', 'mitsa' ),
			'before_widget' => '<div class="footer-widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="footer-widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'mitsa_widgets_init' );

/**
 * Incluye los módulos del tema alojados en /inc.
 *
 * Cada archivo es responsable de un dominio específico (CPTs, SEO,
 * analítica) para mantener funciones.php corto y legible.
 */
require MITSA_THEME_DIR . '/inc/cpt-producto.php';
require MITSA_THEME_DIR . '/inc/cpt-representada.php';
require MITSA_THEME_DIR . '/inc/seo.php';
require MITSA_THEME_DIR . '/inc/analytics.php';
require MITSA_THEME_DIR . '/inc/acf-fields.php';
require MITSA_THEME_DIR . '/inc/api-sections.php';
