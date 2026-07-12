<?php
/**
 * Custom Post Type "producto" + taxonomías `categoria-producto` y `marca`.
 *
 * `categoria-producto` refleja las 5 categorías del sitemap (ver
 * content/00-sitemap.md). `marca` relaciona cada producto con una marca
 * representada (CPT `representada`, ver inc/cpt-representada.php).
 *
 * @package mitsa
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registra el CPT "producto".
 */
function mitsa_registrar_cpt_producto() {
	$labels = array(
		'name'                  => __( 'Productos', 'mitsa' ),
		'singular_name'         => __( 'Producto', 'mitsa' ),
		'add_new'               => __( 'Añadir nuevo', 'mitsa' ),
		'add_new_item'          => __( 'Añadir nuevo producto', 'mitsa' ),
		'edit_item'             => __( 'Editar producto', 'mitsa' ),
		'new_item'              => __( 'Nuevo producto', 'mitsa' ),
		'view_item'             => __( 'Ver producto', 'mitsa' ),
		'view_items'            => __( 'Ver productos', 'mitsa' ),
		'search_items'          => __( 'Buscar productos', 'mitsa' ),
		'not_found'             => __( 'No se encontraron productos.', 'mitsa' ),
		'not_found_in_trash'    => __( 'No hay productos en la papelera.', 'mitsa' ),
		'all_items'             => __( 'Todos los productos', 'mitsa' ),
		'archives'              => __( 'Archivo de productos', 'mitsa' ),
		'menu_name'             => __( 'Productos', 'mitsa' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'menu_icon'          => 'dashicons-admin-tools',
		'has_archive'        => 'productos',
		'rewrite'            => array(
			'slug'       => 'productos',
			'with_front' => false,
		),
		'capability_type'    => 'post',
		'hierarchical'       => false,
		'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
	);

	register_post_type( 'producto', $args );
}
add_action( 'init', 'mitsa_registrar_cpt_producto' );

/**
 * Registra la taxonomía `categoria-producto` (jerárquica, tipo categoría).
 */
function mitsa_registrar_taxonomia_categoria_producto() {
	$labels = array(
		'name'          => __( 'Categorías de producto', 'mitsa' ),
		'singular_name' => __( 'Categoría de producto', 'mitsa' ),
		'search_items'  => __( 'Buscar categorías', 'mitsa' ),
		'all_items'     => __( 'Todas las categorías', 'mitsa' ),
		'edit_item'     => __( 'Editar categoría', 'mitsa' ),
		'add_new_item'  => __( 'Añadir nueva categoría', 'mitsa' ),
		'menu_name'     => __( 'Categorías de producto', 'mitsa' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'categoria-producto' ),
	);

	register_taxonomy( 'categoria-producto', array( 'producto' ), $args );
}
add_action( 'init', 'mitsa_registrar_taxonomia_categoria_producto' );

/**
 * Registra la taxonomía `marca` (no jerárquica, tipo etiqueta).
 *
 * Relaciona productos con marcas representadas. El listado completo de
 * marcas vive como CPT `representada` (inc/cpt-representada.php); esta
 * taxonomía es el puente ligero para filtrar productos por marca sin
 * depender de una relación ACF.
 */
function mitsa_registrar_taxonomia_marca() {
	$labels = array(
		'name'          => __( 'Marcas', 'mitsa' ),
		'singular_name' => __( 'Marca', 'mitsa' ),
		'search_items'  => __( 'Buscar marcas', 'mitsa' ),
		'all_items'     => __( 'Todas las marcas', 'mitsa' ),
		'edit_item'     => __( 'Editar marca', 'mitsa' ),
		'add_new_item'  => __( 'Añadir nueva marca', 'mitsa' ),
		'menu_name'     => __( 'Marcas', 'mitsa' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'marca' ),
	);

	register_taxonomy( 'marca', array( 'producto' ), $args );
}
add_action( 'init', 'mitsa_registrar_taxonomia_marca' );

/**
 * Crea los 5 términos iniciales de `categoria-producto` según el sitemap
 * (ver content/00-sitemap.md). Corre solo al activar el tema, no en cada
 * carga — evitar trabajo repetido en `init`.
 */
function mitsa_crear_categorias_producto_iniciales() {
	// Asegura que la taxonomía exista antes de insertar términos.
	mitsa_registrar_taxonomia_categoria_producto();

	$categorias = array(
		'aguas-sanitarios'   => __( 'Aguas y sanitarios', 'mitsa' ),
		'bombas-fluidos'     => __( 'Bombas y fluidos', 'mitsa' ),
		'propulsion'         => __( 'Propulsión', 'mitsa' ),
		'confort-a-bordo'    => __( 'Confort a bordo', 'mitsa' ),
		'proteccion-casco'   => __( 'Protección casco', 'mitsa' ),
	);

	foreach ( $categorias as $slug => $nombre ) {
		if ( ! term_exists( $slug, 'categoria-producto' ) ) {
			wp_insert_term( $nombre, 'categoria-producto', array( 'slug' => $slug ) );
		}
	}
}
add_action( 'after_switch_theme', 'mitsa_crear_categorias_producto_iniciales' );

/**
 * Fuerza el refresco de las reglas de reescritura al activar el tema, para
 * que las URLs del CPT y las taxonomías funcionen sin pasos manuales.
 */
function mitsa_flush_rewrite_rules_en_activacion() {
	mitsa_registrar_cpt_producto();
	mitsa_registrar_taxonomia_categoria_producto();
	mitsa_registrar_taxonomia_marca();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'mitsa_flush_rewrite_rules_en_activacion' );
