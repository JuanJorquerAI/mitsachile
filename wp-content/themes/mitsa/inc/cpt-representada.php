<?php
/**
 * Custom Post Type "representada" (marca representada por MITSA).
 *
 * @package mitsa
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registra el CPT "representada".
 */
function mitsa_registrar_cpt_representada() {
	$labels = array(
		'name'               => __( 'Representadas', 'mitsa' ),
		'singular_name'      => __( 'Representada', 'mitsa' ),
		'add_new'            => __( 'Añadir nueva', 'mitsa' ),
		'add_new_item'       => __( 'Añadir nueva representada', 'mitsa' ),
		'edit_item'          => __( 'Editar representada', 'mitsa' ),
		'new_item'           => __( 'Nueva representada', 'mitsa' ),
		'view_item'          => __( 'Ver representada', 'mitsa' ),
		'view_items'         => __( 'Ver representadas', 'mitsa' ),
		'search_items'       => __( 'Buscar representadas', 'mitsa' ),
		'not_found'          => __( 'No se encontraron representadas.', 'mitsa' ),
		'not_found_in_trash' => __( 'No hay representadas en la papelera.', 'mitsa' ),
		'all_items'          => __( 'Todas las representadas', 'mitsa' ),
		'menu_name'          => __( 'Representadas', 'mitsa' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'menu_icon'          => 'dashicons-awards',
		'has_archive'        => 'representadas',
		'rewrite'            => array(
			'slug'       => 'representadas',
			'with_front' => false,
		),
		'capability_type'    => 'post',
		'hierarchical'       => false,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
	);

	register_post_type( 'representada', $args );
}
add_action( 'init', 'mitsa_registrar_cpt_representada' );

/**
 * Fuerza el refresco de las reglas de reescritura al activar el tema.
 */
function mitsa_flush_rewrite_rules_representada_en_activacion() {
	mitsa_registrar_cpt_representada();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'mitsa_flush_rewrite_rules_representada_en_activacion' );

/**
 * TODO: campos custom vía ACF (Advanced Custom Fields) para "representada".
 *
 * Este CPT hoy solo tiene título + editor + imagen destacada (soportes
 * nativos de WP). Los campos específicos de negocio deben implementarse con
 * ACF cuando el plugin esté instalado — no hardcodear meta boxes a mano
 * salvo que se decida explícitamente no usar ACF. Campos previstos:
 *
 * - logo               (Image)  — logo de la marca representada.
 * - descripcion_corta  (Textarea) — bajada breve para tarjetas/listados.
 * - sitio_web          (URL)    — sitio oficial de la marca.
 * - categorias_asociadas (Taxonomy field → `categoria-producto`, múltiple)
 *   — para cruzar "Representadas" con las categorías de "Productos" y
 *   poder listar, p. ej., todas las marcas de "Protección casco".
 *
 * Registrar el grupo de campos vía acf_add_local_field_group() (PHP, para
 * mantenerlo versionado en el tema) una vez que ACF esté disponible, en
 * lugar de configurarlo solo desde el admin.
 */
