<?php
/**
 * Endpoints REST API personalizados para el tema MITSA (WordPress Headless).
 *
 * Expone /wp-json/mitsa/v1/sections/{slug} con normalización de campos ACF
 * y cabeceras de caché HTTP para máxima resiliencia y performance.
 *
 * @package mitsa
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registra las rutas de la API REST de MITSA.
 */
function mitsa_register_rest_routes() {
	register_rest_route(
		'mitsa/v1',
		'/sections/(?P<slug>[a-zA-Z0-9-_]+)',
		array(
			'methods'             => 'GET',
			'callback'            => 'mitsa_rest_get_sections_by_slug',
			'permission_callback' => '__return_true',
			'args'                => array(
				'slug' => array(
					'required'          => true,
					'validate_callback' => function( $param ) {
						return is_string( $param ) && ! empty( $param );
					},
					'sanitize_callback' => 'sanitize_title',
				),
			),
		)
	);

	register_rest_route(
		'mitsa/v1',
		'/options',
		array(
			'methods'             => 'GET',
			'callback'            => 'mitsa_rest_get_site_options',
			'permission_callback' => '__return_true',
		)
	);
}
add_action( 'rest_api_init', 'mitsa_register_rest_routes' );

/**
 * Controlador para /mitsa/v1/options.
 *
 * @return WP_REST_Response
 */
function mitsa_rest_get_site_options() {
	$options = function_exists( 'mitsa_get_site_options' ) ? mitsa_get_site_options() : array();
	return new WP_REST_Response( $options, 200 );
}

/**
 * Controlador principal del endpoint /mitsa/v1/sections/{slug}.
 *
 * @param WP_REST_Request $request Solicitud REST entrante.
 * @return WP_REST_Response
 */
function mitsa_rest_get_sections_by_slug( WP_REST_Request $request ) {
	$slug = $request->get_param( 'slug' );

	if ( 'home' === $slug || 'inicio' === $slug ) {
		$data = mitsa_get_home_sections_data();
	} elseif ( 'nosotros' === $slug ) {
		$data = mitsa_get_nosotros_sections_data();
	} elseif ( 'servicios' === $slug ) {
		$data = mitsa_get_servicios_sections_data();
	} elseif ( 'industrias' === $slug || 'sectores' === $slug ) {
		$data = mitsa_get_industrias_sections_data();
	} elseif ( 'proyectos' === $slug ) {
		$data = mitsa_get_proyectos_sections_data();
	} elseif ( 'recursos' === $slug ) {
		$data = mitsa_get_recursos_sections_data();
	} elseif ( 'contacto' === $slug ) {
		$data = mitsa_get_contacto_sections_data();
	} elseif ( 'representadas' === $slug ) {
		$data = mitsa_get_representadas_sections_data();
	} else {
		$page = get_page_by_path( $slug );
		if ( ! $page ) {
			return new WP_REST_Response(
				array(
					'code'    => 'section_not_found',
					'message' => __( 'La sección solicitada no existe.', 'mitsa' ),
				),
				404
			);
		}
		$data = mitsa_get_generic_page_sections_data( $page );
	}

	$response = new WP_REST_Response( $data, 200 );
	$response->header( 'Cache-Control', 'public, max-age=300, stale-while-revalidate=86400' );
	$response->header( 'X-Robots-Tag', 'index, follow' );

	return $response;
}

/**
 * Genera la estructura de datos normalizada para la página de inicio (Home).
 *
 * @return array
 */
function mitsa_get_home_sections_data() {
	$page_on_front_id = get_option( 'page_on_front' );
	$page_id = $page_on_front_id ? (int) $page_on_front_id : 0;

	// 1. Hero & Triaje
	$hero_prefix = function_exists( 'get_field' ) && $page_id ? get_field( 'hero_title_prefix', $page_id ) : '';
	$hero_words  = function_exists( 'get_field' ) && $page_id ? get_field( 'hero_rotating_words', $page_id ) : '';
	$hero_desc   = function_exists( 'get_field' ) && $page_id ? get_field( 'hero_description', $page_id ) : '';
	$triage_tit  = function_exists( 'get_field' ) && $page_id ? get_field( 'triage_title', $page_id ) : '';

	$hero_title_prefix   = ! empty( $hero_prefix ) ? sanitize_text_field( $hero_prefix ) : 'Toda su ingeniería resuelta, del proyecto a la operación:';
	$hero_rotating_words = ! empty( $hero_words )
		? array_filter( array_map( 'trim', explode( "\n", sanitize_textarea_field( $hero_words ) ) ) )
		: array( 'sanitaria', 'de tratamiento', 'de protección', 'de agua dulce' );
	$hero_description    = ! empty( $hero_desc ) ? sanitize_textarea_field( $hero_desc ) : 'Ingeniería de aplicación, suministro, retrofit, puesta en marcha y soporte. Cinco fabricantes representados de forma directa, cuarenta años de proyectos en Chile y Latinoamérica.';
	$triage_title        = ! empty( $triage_tit ) ? sanitize_text_field( $triage_tit ) : '¿Qué necesita resolver?';

	$t1_lbl = function_exists( 'get_field' ) && $page_id ? get_field( 'triage_opt1_label', $page_id ) : 'Evaluación técnica';
	$t1_url = function_exists( 'get_field' ) && $page_id ? get_field( 'triage_opt1_url', $page_id ) : '/contacto/?tipo=evaluacion';
	$t2_lbl = function_exists( 'get_field' ) && $page_id ? get_field( 'triage_opt2_label', $page_id ) : 'Repuestos';
	$t2_url = function_exists( 'get_field' ) && $page_id ? get_field( 'triage_opt2_url', $page_id ) : '/contacto/?tipo=repuestos';
	$t3_lbl = function_exists( 'get_field' ) && $page_id ? get_field( 'triage_opt3_label', $page_id ) : 'Servicio técnico';
	$t3_url = function_exists( 'get_field' ) && $page_id ? get_field( 'triage_opt3_url', $page_id ) : '/contacto/?tipo=servicio';

	$triage_options = array(
		array( 'label' => $t1_lbl ?: 'Evaluación técnica', 'url' => $t1_url ?: '/contacto/?tipo=evaluacion', 'highlight' => true ),
		array( 'label' => $t2_lbl ?: 'Repuestos', 'url' => $t2_url ?: '/contacto/?tipo=repuestos', 'highlight' => false ),
		array( 'label' => $t3_lbl ?: 'Servicio técnico', 'url' => $t3_url ?: '/contacto/?tipo=servicio', 'highlight' => false ),
	);

	// 2. Tarjetas Visuales de Proyectos (4 Tarjetas)
	$visual_cards = array(
		array(
			'title'   => ( function_exists( 'get_field' ) && $page_id && get_field( 'vcard1_title', $page_id ) ) ? get_field( 'vcard1_title', $page_id ) : 'Fragata FF-18 · ICCP',
			'image'   => ( function_exists( 'get_field' ) && $page_id && get_field( 'vcard1_image', $page_id ) ) ? get_field( 'vcard1_image', $page_id ) : '/images/plataforma-offshore-8886341c.jpg',
			'alt'     => ( function_exists( 'get_field' ) && $page_id && get_field( 'vcard1_alt', $page_id ) ) ? get_field( 'vcard1_alt', $page_id ) : 'Protección catódica por corriente impresa ICCP en Fragata FF-18',
			'width'   => 800,
			'height'  => 600,
			'loading' => ( function_exists( 'get_field' ) && $page_id && get_field( 'vcard1_loading', $page_id ) ) ? get_field( 'vcard1_loading', $page_id ) : 'eager',
		),
		array(
			'title'   => ( function_exists( 'get_field' ) && $page_id && get_field( 'vcard2_title', $page_id ) ) ? get_field( 'vcard2_title', $page_id ) : 'OPV Cabo Odger · Sanitarios',
			'image'   => ( function_exists( 'get_field' ) && $page_id && get_field( 'vcard2_image', $page_id ) ) ? get_field( 'vcard2_image', $page_id ) : '/images/buque-de-apoyo-8d5d1037.jpg',
			'alt'     => ( function_exists( 'get_field' ) && $page_id && get_field( 'vcard2_alt', $page_id ) ) ? get_field( 'vcard2_alt', $page_id ) : 'Sistemas sanitarios al vacío EVAC en buque patrullero OPV Cabo Odger',
			'width'   => 800,
			'height'  => 600,
			'loading' => ( function_exists( 'get_field' ) && $page_id && get_field( 'vcard2_loading', $page_id ) ) ? get_field( 'vcard2_loading', $page_id ) : 'eager',
		),
		array(
			'title'   => ( function_exists( 'get_field' ) && $page_id && get_field( 'vcard3_title', $page_id ) ) ? get_field( 'vcard3_title', $page_id ) : 'Magellan Discovery · Agua caliente',
			'image'   => ( function_exists( 'get_field' ) && $page_id && get_field( 'vcard3_image', $page_id ) ) ? get_field( 'vcard3_image', $page_id ) : '/images/wellboat-en-centro-d-6ece81b5.jpg',
			'alt'     => ( function_exists( 'get_field' ) && $page_id && get_field( 'vcard3_alt', $page_id ) ) ? get_field( 'vcard3_alt', $page_id ) : 'Sistemas de generación y distribución de agua caliente a bordo',
			'width'   => 800,
			'height'  => 600,
			'loading' => ( function_exists( 'get_field' ) && $page_id && get_field( 'vcard3_loading', $page_id ) ) ? get_field( 'vcard3_loading', $page_id ) : 'lazy',
		),
		array(
			'title'   => ( function_exists( 'get_field' ) && $page_id && get_field( 'vcard4_title', $page_id ) ) ? get_field( 'vcard4_title', $page_id ) : 'Wellboat · BWTS',
			'image'   => ( function_exists( 'get_field' ) && $page_id && get_field( 'vcard4_image', $page_id ) ) ? get_field( 'vcard4_image', $page_id ) : '/images/astillero-636210b7.jpg',
			'alt'     => ( function_exists( 'get_field' ) && $page_id && get_field( 'vcard4_alt', $page_id ) ) ? get_field( 'vcard4_alt', $page_id ) : 'Tratamiento de agua de lastre BWTS ERMA FIRST en wellboat',
			'width'   => 800,
			'height'  => 600,
			'loading' => ( function_exists( 'get_field' ) && $page_id && get_field( 'vcard4_loading', $page_id ) ) ? get_field( 'vcard4_loading', $page_id ) : 'lazy',
		),
	);

	// 3. Pain Points / Objeciones
	$acf_pp_heading  = function_exists( 'get_field' ) && $page_id ? get_field( 'pain_points_heading', $page_id ) : '';
	$acf_pp_quote    = function_exists( 'get_field' ) && $page_id ? get_field( 'pain_points_quote', $page_id ) : '';
	$acf_pp_initials = function_exists( 'get_field' ) && $page_id ? get_field( 'pain_points_author_initials', $page_id ) : '';
	$acf_pp_role     = function_exists( 'get_field' ) && $page_id ? get_field( 'pain_points_author_role', $page_id ) : '';
	$acf_pp_note     = function_exists( 'get_field' ) && $page_id ? get_field( 'pain_points_author_note', $page_id ) : '';
	$acf_pp_res      = function_exists( 'get_field' ) && $page_id ? get_field( 'pain_points_resolutions', $page_id ) : '';

	$pain_points = array(
		'heading'         => ! empty( $acf_pp_heading ) ? sanitize_text_field( $acf_pp_heading ) : 'Resolvemos lo que frena un proyecto naval',
		'quote'           => ! empty( $acf_pp_quote ) ? sanitize_textarea_field( $acf_pp_quote ) : '«Nos ofrecen el equipo, pero nadie se hace cargo de la puesta en marcha ni de los repuestos tres años después.»',
		'author_initials' => ! empty( $acf_pp_initials ) ? sanitize_text_field( $acf_pp_initials ) : 'JP',
		'author_role'     => ! empty( $acf_pp_role ) ? sanitize_text_field( $acf_pp_role ) : 'Jefe de Proyecto · Astillero Naval',
		'author_note'     => ! empty( $acf_pp_note ) ? sanitize_text_field( $acf_pp_note ) : 'Caso representativo de la industria',
		'resolutions'     => ! empty( $acf_pp_res )
			? array_filter( array_map( 'trim', explode( "\n", sanitize_textarea_field( $acf_pp_res ) ) ) )
			: array(
				'Especificaciones que calzan exactamente con la normativa aplicable',
				'Ingeniería de aplicación y dimensionamiento previo a la compra',
				'Trazabilidad de repuestos originales por número de parte oficial',
				'Puesta en marcha y comisionamiento ejecutado en terreno en Chile',
				'Alcance contractual y técnico claro entre astillero, armador y MITSA',
			),
	);

	// 4. Banner de Métricas
	$m1_v = function_exists( 'get_field' ) && $page_id ? get_field( 'metric1_val', $page_id ) : '40+';
	$m1_l = function_exists( 'get_field' ) && $page_id ? get_field( 'metric1_lbl', $page_id ) : 'años integrando soluciones marítimas y ambientales en Chile';
	$m2_v = function_exists( 'get_field' ) && $page_id ? get_field( 'metric2_val', $page_id ) : '5';
	$m2_l = function_exists( 'get_field' ) && $page_id ? get_field( 'metric2_lbl', $page_id ) : 'fabricantes representados de forma directa y oficial';
	$m3_v = function_exists( 'get_field' ) && $page_id ? get_field( 'metric3_val', $page_id ) : '100%';
	$m3_l = function_exists( 'get_field' ) && $page_id ? get_field( 'metric3_lbl', $page_id ) : 'cobertura nacional con ingenieros especialistas en terreno';

	$metrics = array(
		array( 'value' => $m1_v ?: '40+', 'label' => $m1_l ?: 'años integrando soluciones marítimas y ambientales en Chile', 'highlight' => false ),
		array( 'value' => $m2_v ?: '5', 'label' => $m2_l ?: 'fabricantes representados de forma directa y oficial', 'highlight' => false ),
		array( 'value' => $m3_v ?: '100%', 'label' => $m3_l ?: 'cobertura nacional con ingenieros especialistas en terreno', 'highlight' => true ),
	);

	// 5. Showcase de Marcas
	$brands_heading = function_exists( 'get_field' ) && $page_id ? get_field( 'brands_heading', $page_id ) : '';
	$brands = array(
		'heading' => ! empty( $brands_heading ) ? sanitize_text_field( $brands_heading ) : 'Quién está detrás de cada solución',
		'items'   => array(
			array(
				'name'        => ( function_exists( 'get_field' ) && $page_id && get_field( 'b1_name', $page_id ) ) ? get_field( 'b1_name', $page_id ) : 'EVAC',
				'tagline'     => ( function_exists( 'get_field' ) && $page_id && get_field( 'b1_tagline', $page_id ) ) ? get_field( 'b1_tagline', $page_id ) : 'Sanitarios al vacío',
				'description' => ( function_exists( 'get_field' ) && $page_id && get_field( 'b1_desc', $page_id ) ) ? get_field( 'b1_desc', $page_id ) : 'Tratamiento de aguas residuales y gestión de residuos a bordo.',
				'url'         => '/representadas/',
			),
			array(
				'name'        => ( function_exists( 'get_field' ) && $page_id && get_field( 'b2_name', $page_id ) ) ? get_field( 'b2_name', $page_id ) : 'Cathelco',
				'tagline'     => ( function_exists( 'get_field' ) && $page_id && get_field( 'b2_tagline', $page_id ) ) ? get_field( 'b2_tagline', $page_id ) : 'ICCP & ICAF',
				'description' => ( function_exists( 'get_field' ) && $page_id && get_field( 'b2_desc', $page_id ) ) ? get_field( 'b2_desc', $page_id ) : 'Protección catódica por corriente impresa y prevención de bioincrustaciones.',
				'url'         => '/representadas/',
			),
			array(
				'name'        => ( function_exists( 'get_field' ) && $page_id && get_field( 'b3_name', $page_id ) ) ? get_field( 'b3_name', $page_id ) : 'ERMA FIRST',
				'tagline'     => ( function_exists( 'get_field' ) && $page_id && get_field( 'b3_tagline', $page_id ) ) ? get_field( 'b3_tagline', $page_id ) : 'Agua de lastre (BWTS)',
				'description' => ( function_exists( 'get_field' ) && $page_id && get_field( 'b3_desc', $page_id ) ) ? get_field( 'b3_desc', $page_id ) : 'Sistemas certificados D-2 con tecnología de electrólisis y filtración.',
				'url'         => '/representadas/',
			),
			array(
				'name'        => ( function_exists( 'get_field' ) && $page_id && get_field( 'b4_name', $page_id ) ) ? get_field( 'b4_name', $page_id ) : 'EPE',
				'tagline'     => ( function_exists( 'get_field' ) && $page_id && get_field( 'b4_tagline', $page_id ) ) ? get_field( 'b4_tagline', $page_id ) : 'Tratamiento de efluentes',
				'description' => ( function_exists( 'get_field' ) && $page_id && get_field( 'b4_desc', $page_id ) ) ? get_field( 'b4_desc', $page_id ) : 'Plantas de tratamiento y separadores marinos de sentinas.',
				'url'         => '/representadas/',
			),
			array(
				'name'        => ( function_exists( 'get_field' ) && $page_id && get_field( 'b5_name', $page_id ) ) ? get_field( 'b5_name', $page_id ) : 'BLÜCHER',
				'tagline'     => ( function_exists( 'get_field' ) && $page_id && get_field( 'b5_tagline', $page_id ) ) ? get_field( 'b5_tagline', $page_id ) : 'Drenajes inoxidables',
				'description' => ( function_exists( 'get_field' ) && $page_id && get_field( 'b5_desc', $page_id ) ) ? get_field( 'b5_desc', $page_id ) : 'Sistemas de evacuación y tuberías de acero inoxidable AISI 316L.',
				'url'         => '/representadas/',
			),
		),
	);

	// 6. Soluciones Tecnológicas
	$sol_heading = function_exists( 'get_field' ) && $page_id ? get_field( 'solutions_heading', $page_id ) : '';
	$sol_sub     = function_exists( 'get_field' ) && $page_id ? get_field( 'solutions_subheading', $page_id ) : '';

	$solutions = array(
		'heading'    => ! empty( $sol_heading ) ? sanitize_text_field( $sol_heading ) : 'Soluciones tecnológicas especializadas',
		'subheading' => ! empty( $sol_sub ) ? sanitize_textarea_field( $sol_sub ) : 'Sistemas marinos y terrestres integrados con ingeniería de aplicación, comisionamiento y respaldo técnico en terreno.',
		'items'      => array(
			array(
				'title' => ( function_exists( 'get_field' ) && $page_id && get_field( 'sol1_title', $page_id ) ) ? get_field( 'sol1_title', $page_id ) : 'Sanitarios al vacío',
				'brand' => ( function_exists( 'get_field' ) && $page_id && get_field( 'sol1_brand', $page_id ) ) ? get_field( 'sol1_brand', $page_id ) : 'EVAC',
				'img'   => '/images/sistemas-sanitarios--c457bd2a.jpg',
				'desc'  => ( function_exists( 'get_field' ) && $page_id && get_field( 'sol1_desc', $page_id ) ) ? get_field( 'sol1_desc', $page_id ) : 'Sistemas sanitarios marinos y terrestres de alta eficiencia con ahorro de agua.',
			),
			array(
				'title' => ( function_exists( 'get_field' ) && $page_id && get_field( 'sol2_title', $page_id ) ) ? get_field( 'sol2_title', $page_id ) : 'Aguas residuales',
				'brand' => ( function_exists( 'get_field' ) && $page_id && get_field( 'sol2_brand', $page_id ) ) ? get_field( 'sol2_brand', $page_id ) : 'EVAC · EPE',
				'img'   => '/images/tratamiento-de-aguas-8ead4ece.jpg',
				'desc'  => ( function_exists( 'get_field' ) && $page_id && get_field( 'sol2_desc', $page_id ) ) ? get_field( 'sol2_desc', $page_id ) : 'Plantas de tratamiento biológico y físico-químico según normativa MARPOL Anexo IV.',
			),
			array(
				'title' => ( function_exists( 'get_field' ) && $page_id && get_field( 'sol3_title', $page_id ) ) ? get_field( 'sol3_title', $page_id ) : 'Agua de lastre (BWTS)',
				'brand' => ( function_exists( 'get_field' ) && $page_id && get_field( 'sol3_brand', $page_id ) ) ? get_field( 'sol3_brand', $page_id ) : 'ERMA FIRST',
				'img'   => '/images/ingeniería-de-detall-616b7dfd.jpg',
				'desc'  => ( function_exists( 'get_field' ) && $page_id && get_field( 'sol3_desc', $page_id ) ) ? get_field( 'sol3_desc', $page_id ) : 'Sistemas de tratamiento de agua de lastre bajo estándar D-2 de la OMI.',
			),
			array(
				'title' => ( function_exists( 'get_field' ) && $page_id && get_field( 'sol4_title', $page_id ) ) ? get_field( 'sol4_title', $page_id ) : 'Corrosión (ICCP)',
				'brand' => ( function_exists( 'get_field' ) && $page_id && get_field( 'sol4_brand', $page_id ) ) ? get_field( 'sol4_brand', $page_id ) : 'Cathelco',
				'img'   => '/images/datos-de-operación-y-92c78919.jpg',
				'desc'  => ( function_exists( 'get_field' ) && $page_id && get_field( 'sol4_desc', $page_id ) ) ? get_field( 'sol4_desc', $page_id ) : 'Protección catódica por corriente impresa para cascos de buques e instalaciones.',
			),
			array(
				'title' => ( function_exists( 'get_field' ) && $page_id && get_field( 'sol5_title', $page_id ) ) ? get_field( 'sol5_title', $page_id ) : 'Bioincrustaciones (ICAF)',
				'brand' => ( function_exists( 'get_field' ) && $page_id && get_field( 'sol5_brand', $page_id ) ) ? get_field( 'sol5_brand', $page_id ) : 'Cathelco',
				'img'   => '/images/acuicultura-64fec532.jpg',
				'desc'  => ( function_exists( 'get_field' ) && $page_id && get_field( 'sol5_desc', $page_id ) ) ? get_field( 'sol5_desc', $page_id ) : 'Sistemas anti-incrustaciones para tomas de mar y circuitos de refrigeración.',
			),
			array(
				'title' => ( function_exists( 'get_field' ) && $page_id && get_field( 'sol6_title', $page_id ) ) ? get_field( 'sol6_title', $page_id ) : 'Generación de agua dulce',
				'brand' => ( function_exists( 'get_field' ) && $page_id && get_field( 'sol6_brand', $page_id ) ) ? get_field( 'sol6_brand', $page_id ) : 'Representadas oficiales',
				'img'   => '/images/recursos-img-5-02ed53ff.jpg',
				'desc'  => ( function_exists( 'get_field' ) && $page_id && get_field( 'sol6_desc', $page_id ) ) ? get_field( 'sol6_desc', $page_id ) : 'Plantas desalinizadoras por ósmosis inversa y evaporadores marinos.',
			),
			array(
				'title' => ( function_exists( 'get_field' ) && $page_id && get_field( 'sol7_title', $page_id ) ) ? get_field( 'sol7_title', $page_id ) : 'Sistemas de agua caliente',
				'brand' => ( function_exists( 'get_field' ) && $page_id && get_field( 'sol7_brand', $page_id ) ) ? get_field( 'sol7_brand', $page_id ) : 'Ingeniería MITSA',
				'img'   => '/images/recursos-img-6-2ffa0056.jpg',
				'desc'  => ( function_exists( 'get_field' ) && $page_id && get_field( 'sol7_desc', $page_id ) ) ? get_field( 'sol7_desc', $page_id ) : 'Calderas, intercambiadores y acumuladores para habitabilidad a bordo.',
			),
			array(
				'title' => ( function_exists( 'get_field' ) && $page_id && get_field( 'sol8_title', $page_id ) ) ? get_field( 'sol8_title', $page_id ) : 'Drenajes inoxidables',
				'brand' => ( function_exists( 'get_field' ) && $page_id && get_field( 'sol8_brand', $page_id ) ) ? get_field( 'sol8_brand', $page_id ) : 'BLÜCHER',
				'img'   => '/images/recursos-img-7-8ead4ece.jpg',
				'desc'  => ( function_exists( 'get_field' ) && $page_id && get_field( 'sol8_desc', $page_id ) ) ? get_field( 'sol8_desc', $page_id ) : 'Canaletas, sifones y tuberías de acero inoxidable AISI 316L para higiene naval.',
			),
		),
	);

	// 7. ¿Por qué MITSA?
	$why_heading = function_exists( 'get_field' ) && $page_id ? get_field( 'why_heading', $page_id ) : '';
	$why_sub     = function_exists( 'get_field' ) && $page_id ? get_field( 'why_subheading', $page_id ) : '';

	$why_mitsa = array(
		'heading'    => ! empty( $why_heading ) ? sanitize_text_field( $why_heading ) : '¿Por qué MITSA?',
		'subheading' => ! empty( $why_sub ) ? sanitize_textarea_field( $why_sub ) : 'Seis razones técnicas que sostienen un proyecto completo, de la especificación al soporte en operación.',
		'cards'      => array(
			array(
				'title'   => ( function_exists( 'get_field' ) && $page_id && get_field( 'why1_title', $page_id ) ) ? get_field( 'why1_title', $page_id ) : 'Años de experiencia',
				'desc'    => ( function_exists( 'get_field' ) && $page_id && get_field( 'why1_desc', $page_id ) ) ? get_field( 'why1_desc', $page_id ) : 'Cuatro décadas resolviendo proyectos marítimos e industriales en Chile.',
				'metric'  => ( function_exists( 'get_field' ) && $page_id && get_field( 'why1_metric', $page_id ) ) ? get_field( 'why1_metric', $page_id ) : '40+',
				'is_dark' => true,
			),
			array(
				'title' => ( function_exists( 'get_field' ) && $page_id && get_field( 'why2_title', $page_id ) ) ? get_field( 'why2_title', $page_id ) : 'Ingeniería especializada',
				'desc'  => ( function_exists( 'get_field' ) && $page_id && get_field( 'why2_desc', $page_id ) ) ? get_field( 'why2_desc', $page_id ) : 'Ingeniería de aplicación propia: la solución se dimensiona, no se cotiza de catálogo.',
			),
			array(
				'title' => ( function_exists( 'get_field' ) && $page_id && get_field( 'why3_title', $page_id ) ) ? get_field( 'why3_title', $page_id ) : 'Representantes oficiales',
				'desc'  => ( function_exists( 'get_field' ) && $page_id && get_field( 'why3_desc', $page_id ) ) ? get_field( 'why3_desc', $page_id ) : 'Representación directa de cinco fabricantes internacionales, con respaldo y garantía de fábrica.',
			),
			array(
				'image'   => ( function_exists( 'get_field' ) && $page_id && get_field( 'why4_image', $page_id ) ) ? get_field( 'why4_image', $page_id ) : '/images/inspección-de-compon-94016740.jpg',
				'caption' => ( function_exists( 'get_field' ) && $page_id && get_field( 'why4_caption', $page_id ) ) ? get_field( 'why4_caption', $page_id ) : 'Equipo en terreno',
			),
			array(
				'title' => ( function_exists( 'get_field' ) && $page_id && get_field( 'why5_title', $page_id ) ) ? get_field( 'why5_title', $page_id ) : 'Cobertura nacional y regional',
				'desc'  => ( function_exists( 'get_field' ) && $page_id && get_field( 'why5_desc', $page_id ) ) ? get_field( 'why5_desc', $page_id ) : 'Presencia donde está la operación: puertos, astilleros, faenas y centros de cultivo.',
			),
			array(
				'title' => ( function_exists( 'get_field' ) && $page_id && get_field( 'why6_title', $page_id ) ) ? get_field( 'why6_title', $page_id ) : 'Puesta en marcha y soporte',
				'desc'  => ( function_exists( 'get_field' ) && $page_id && get_field( 'why6_desc', $page_id ) ) ? get_field( 'why6_desc', $page_id ) : 'Comisionamiento, capacitación a la tripulación y asistencia después de la entrega.',
			),
		),
	);

	// 8. Gran Call to Action
	$cta_head  = function_exists( 'get_field' ) && $page_id ? get_field( 'cta_heading', $page_id ) : '';
	$cta_desc  = function_exists( 'get_field' ) && $page_id ? get_field( 'cta_desc', $page_id ) : '';
	$cta_b1_l  = function_exists( 'get_field' ) && $page_id ? get_field( 'cta_btn1_label', $page_id ) : '';
	$cta_b1_u  = function_exists( 'get_field' ) && $page_id ? get_field( 'cta_btn1_url', $page_id ) : '';
	$cta_b2_l  = function_exists( 'get_field' ) && $page_id ? get_field( 'cta_btn2_label', $page_id ) : '';
	$cta_b2_u  = function_exists( 'get_field' ) && $page_id ? get_field( 'cta_btn2_url', $page_id ) : '';

	$cta_banner = array(
		'heading'          => ! empty( $cta_head ) ? sanitize_text_field( $cta_head ) : 'Evaluación técnica sin costo para dimensionar su proyecto',
		'description'      => ! empty( $cta_desc ) ? sanitize_textarea_field( $cta_desc ) : 'Revise requerimientos de caudal, normativa OMI / DIRECTEMAR, espacio disponible y tiempos de entrega con nuestros ingenieros de aplicación.',
		'primary_button'   => array(
			'label' => ! empty( $cta_b1_l ) ? sanitize_text_field( $cta_b1_l ) : 'Solicitar evaluación técnica',
			'url'   => ! empty( $cta_b1_u ) ? esc_url_raw( $cta_b1_u ) : '/contacto/?tipo=evaluacion',
		),
		'secondary_button' => array(
			'label' => ! empty( $cta_b2_l ) ? sanitize_text_field( $cta_b2_l ) : 'Contactar a ingeniería',
			'url'   => ! empty( $cta_b2_u ) ? esc_url_raw( $cta_b2_u ) : '/contacto/?tipo=servicio',
		),
		'background_image' => '/images/index-img-7-85955fa0.jpg',
	);

	// 9. FAQs
	$faqs_heading = function_exists( 'get_field' ) && $page_id ? get_field( 'faqs_heading', $page_id ) : '';

	$faqs = array(
		'heading' => ! empty( $faqs_heading ) ? sanitize_text_field( $faqs_heading ) : 'Preguntas frecuentes de ingeniería',
		'items'   => array(
			array(
				'question' => ( function_exists( 'get_field' ) && $page_id && get_field( 'faq1_q', $page_id ) ) ? get_field( 'faq1_q', $page_id ) : '¿Cómo se determina si un buque requiere sistema ICCP o ánodos de sacrificio?',
				'answer'   => ( function_exists( 'get_field' ) && $page_id && get_field( 'faq1_a', $page_id ) ) ? get_field( 'faq1_a', $page_id ) : 'Depende del perfil operativo, área mojada del casco, tiempo entre diques y costo de ciclo de vida. ICCP ofrece control regulable en tiempo real sin reposición física en cada carena.',
			),
			array(
				'question' => ( function_exists( 'get_field' ) && $page_id && get_field( 'faq2_q', $page_id ) ) ? get_field( 'faq2_q', $page_id ) : '¿Qué certificaciones tienen las plantas de tratamiento de aguas servidas que suministran?',
				'answer'   => ( function_exists( 'get_field' ) && $page_id && get_field( 'faq2_a', $page_id ) ) ? get_field( 'faq2_a', $page_id ) : 'Equipos certificados bajo la Resolución MEPC.227(64) de la OMI (MARPOL Anexo IV) y aprobados por las principales casas clasificadoras (DNV, Lloyd\'s Register, ABS, BV).',
			),
			array(
				'question' => ( function_exists( 'get_field' ) && $page_id && get_field( 'faq3_q', $page_id ) ) ? get_field( 'faq3_q', $page_id ) : '¿MITSA realiza la puesta en marcha en cualquier puerto de Chile?',
				'answer'   => ( function_exists( 'get_field' ) && $page_id && get_field( 'faq3_a', $page_id ) ) ? get_field( 'faq3_a', $page_id ) : 'Sí, nuestros ingenieros de servicio técnico operan en todo Chile (Arica a Punta Arenas) y en puertos de la región para comisionamiento, pruebas de mar y capacitación.',
			),
			array(
				'question' => ( function_exists( 'get_field' ) && $page_id && get_field( 'faq4_q', $page_id ) ) ? get_field( 'faq4_q', $page_id ) : '¿Cómo solicito repuestos originales de marcas representadas?',
				'answer'   => ( function_exists( 'get_field' ) && $page_id && get_field( 'faq4_a', $page_id ) ) ? get_field( 'faq4_a', $page_id ) : 'A través de nuestro portal de repuestos o contacto directo, indicando fabricante, modelo, número de serie y número de parte (P/N) de la placa del equipo.',
			),
		),
	);

	// 10. Metadatos SEO
	$seo_title = function_exists( 'get_field' ) && $page_id ? sanitize_text_field( (string) get_field( 'seo_meta_title', $page_id ) ) : '';
	$seo_desc  = function_exists( 'get_field' ) && $page_id ? sanitize_text_field( (string) get_field( 'seo_meta_description', $page_id ) ) : '';
	$seo_img   = function_exists( 'get_field' ) && $page_id ? esc_url_raw( (string) get_field( 'seo_og_image', $page_id ) ) : '';

	return array(
		'slug'     => 'home',
		'title'    => ! empty( $seo_title ) ? $seo_title : 'MITSA — Integramos tecnología. Resolvemos desafíos.',
		'seo'      => array(
			'meta_title'       => ! empty( $seo_title ) ? $seo_title : 'MITSA — Integramos tecnología. Resolvemos desafíos.',
			'meta_description' => ! empty( $seo_desc ) ? $seo_desc : 'Ingeniería de aplicación, suministro, retrofit, puesta en marcha y soporte. Cinco fabricantes representados, cuarenta años de proyectos en Chile y Latinoamérica.',
			'canonical_url'    => 'https://mitsachile.com/',
			'og_image'         => ! empty( $seo_img ) ? $seo_img : 'https://mitsachile.com/images/plataforma-offshore-8886341c.jpg',
			'og_type'          => 'website',
		),
		'sections' => array(
			'hero'          => array(
				'title_prefix'   => $hero_title_prefix,
				'rotating_words' => $hero_rotating_words,
				'description'    => $hero_description,
				'triage'         => array(
					'title'       => $triage_title,
					'options'     => $triage_options,
					'placeholder' => 'Describa su proyecto o nave...',
					'button_text' => '→',
					'action_url'  => '/contacto/',
				),
			),
			'visual_cards'  => $visual_cards,
			'pain_points'   => $pain_points,
			'metrics'       => $metrics,
			'brands'        => $brands,
			'solutions'     => $solutions,
			'why_mitsa'     => $why_mitsa,
			'cta_banner'    => $cta_banner,
			'faqs'          => $faqs,
		),
	);
}

/**
 * Genera la estructura de datos normalizada para la página Nosotros.
 *
 * @return array
 */
function mitsa_get_nosotros_sections_data() {
	$page = get_page_by_path( 'nosotros' );
	$page_id = $page ? (int) $page->ID : 0;

	// 1. Hero & Tagline
	$h_title   = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_hero_title', $page_id ) : '';
	$h_tagline = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_hero_tagline', $page_id ) : '';
	$h_desc    = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_hero_desc', $page_id ) : '';
	$h_image   = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_hero_image', $page_id ) : '';

	$hero = array(
		'title'       => ! empty( $h_title ) ? sanitize_text_field( $h_title ) : 'Cuatro décadas integrando ingeniería, tecnología y servicio especializado',
		'tagline'     => ! empty( $h_tagline ) ? sanitize_text_field( $h_tagline ) : '«Todos tenemos una especialidad, la nuestra es servir»',
		'description' => ! empty( $h_desc ) ? sanitize_textarea_field( $h_desc ) : 'Pioneros en introducir tecnología avanzada en el segmento sanitario y ambiental para uso marino, industrial, pesquero, acuícola y minero en Chile y Latinoamérica desde 1982.',
		'image'       => ! empty( $h_image ) ? esc_url_raw( $h_image ) : '/images/oficina-mitsa-54b17efd.jpg',
	);

	// 2. Historia y Trayectoria
	$s_title = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_story_title', $page_id ) : '';
	$s_p1    = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_story_p1', $page_id ) : '';
	$s_p2    = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_story_p2', $page_id ) : '';

	$m1_y = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_m1_year', $page_id ) : '1982';
	$m1_t = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_m1_title', $page_id ) : 'Fundación en Reñaca, Viña del Mar';
	$m1_d = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_m1_desc', $page_id ) : 'Inicio de operaciones representando tecnología pionera sanitaria marina.';

	$m2_y = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_m2_year', $page_id ) : '1995';
	$m2_t = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_m2_title', $page_id ) : 'Expansión a Flotas y Astilleros';
	$m2_d = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_m2_desc', $page_id ) : 'Consolidación en buques de la Armada de Chile, marina mercante y salmonicultura.';

	$m3_y = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_m3_year', $page_id ) : '2010';
	$m3_t = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_m3_title', $page_id ) : 'Alianzas Globales de Fabricación';
	$m3_d = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_m3_desc', $page_id ) : 'Representación directa y exclusiva de EVAC, Cathelco, ERMA FIRST, EPE y BLÜCHER.';

	$m4_y = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_m4_year', $page_id ) : '2026';
	$m4_t = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_m4_title', $page_id ) : 'Ingeniería y Presencia Regional';
	$m4_d = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_m4_desc', $page_id ) : 'Proyectos de retrofit, BWTS D-2, protección ICCP y servicios en Chile y Latinoamérica.';

	$story = array(
		'title'      => ! empty( $s_title ) ? sanitize_text_field( $s_title ) : 'Pioneros en tecnología marina y ambiental desde 1982',
		'paragraphs' => array(
			! empty( $s_p1 ) ? sanitize_textarea_field( $s_p1 ) : 'Fundada en 1982 en Reñaca, Viña del Mar, MITSA nació con la convicción de conectar a las industrias marítimas y productivas de Chile con los inventores y fabricantes de tecnología de mayor estándar mundial.',
			! empty( $s_p2 ) ? sanitize_textarea_field( $s_p2 ) : 'A lo largo de más de cuatro décadas, hemos evolucionado de la provisión de equipos sanitarios al vacío hacia la ingeniería de aplicación integral, comisionamiento y respaldo operativo en terreno en todo el país.',
		),
		'milestones' => array(
			array( 'year' => $m1_y ?: '1982', 'title' => $m1_t ?: 'Fundación en Reñaca, Viña del Mar', 'description' => $m1_d ?: 'Inicio de operaciones representando tecnología pionera sanitaria marina.' ),
			array( 'year' => $m2_y ?: '1995', 'title' => $m2_t ?: 'Expansión a Flotas y Astilleros', 'description' => $m2_d ?: 'Consolidación en buques de la Armada de Chile, marina mercante y salmonicultura.' ),
			array( 'year' => $m3_y ?: '2010', 'title' => $m3_t ?: 'Alianzas Globales de Fabricación', 'description' => $m3_d ?: 'Representación directa y exclusiva de EVAC, Cathelco, ERMA FIRST, EPE y BLÜCHER.' ),
			array( 'year' => $m4_y ?: '2026', 'title' => $m4_t ?: 'Ingeniería y Presencia Regional', 'description' => $m4_d ?: 'Proyectos de retrofit, BWTS D-2, protección ICCP y servicios en Chile y Latinoamérica.' ),
		),
	);

	// 3. Misión & Visión (fuente oficial: brochure corporativo)
	$mv_mt = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_mission_title', $page_id ) : 'Nuestra Misión';
	$mv_mx = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_mission_text', $page_id ) : 'Liderar el mercado chileno y latinoamericano en la provisión de tecnologías y equipos para el cuidado del medio ambiente acuático, manteniendo altos estándares de calidad y servicio.';
	$mv_vt = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_vision_title', $page_id ) : 'Nuestra Visión';
	$mv_vx = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_vision_text', $page_id ) : 'Ofrecer soluciones integrales y especializadas para el cuidado del medio ambiente acuático, utilizando tecnologías avanzadas y representando a las compañías líderes a nivel mundial.';

	$mission_vision = array(
		'mission' => array(
			'title' => ! empty( $mv_mt ) ? sanitize_text_field( $mv_mt ) : 'Nuestra Misión',
			'text'  => ! empty( $mv_mx ) ? sanitize_textarea_field( $mv_mx ) : 'Liderar el mercado chileno y latinoamericano en la provisión de tecnologías y equipos para el cuidado del medio ambiente acuático, manteniendo altos estándares de calidad y servicio.',
		),
		'vision'  => array(
			'title' => ! empty( $mv_vt ) ? sanitize_text_field( $mv_vt ) : 'Nuestra Visión',
			'text'  => ! empty( $mv_vx ) ? sanitize_textarea_field( $mv_vx ) : 'Ofrecer soluciones integrales y especializadas para el cuidado del medio ambiente acuático, utilizando tecnologías avanzadas y representando a las compañías líderes a nivel mundial.',
		),
	);

	// 4. Pilares de Valor
	$p_head = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_pillars_heading', $page_id ) : 'Los pilares que fundamentan nuestra propuesta';
	$p1_t   = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_p1_title', $page_id ) : 'Representación Oficial Directa';
	$p1_d   = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_p1_desc', $page_id ) : 'Vínculo directo sin intermediarios con fabricantes líderes mundiales e inventores de la tecnología.';
	$p2_t   = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_p2_title', $page_id ) : 'Ingeniería de Aplicación Propia';
	$p2_d   = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_p2_desc', $page_id ) : 'Dimensionamiento a medida, selección de materiales y cumplimiento estricto de normativas internacionales.';
	$p3_t   = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_p3_title', $page_id ) : 'Servicio Técnico en Terreno';
	$p3_d   = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_p3_desc', $page_id ) : 'Ingenieros especialistas para puesta en marcha, pruebas de mar, mantenciones y capacitación.';
	$p4_t   = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_p4_title', $page_id ) : 'Cuidado del Medio Ambiente Acuático';
	$p4_d   = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_p4_desc', $page_id ) : 'Tecnologías certificadas bajo normas OMI MARPOL Anexo IV y D-2 para cero impacto ambiental.';

	$pillars = array(
		'heading' => ! empty( $p_head ) ? sanitize_text_field( $p_head ) : 'Los pilares que fundamentan nuestra propuesta',
		'items'   => array(
			array( 'title' => $p1_t ?: 'Representación Oficial Directa', 'description' => $p1_d ?: 'Vínculo directo sin intermediarios con fabricantes líderes mundiales e inventores de la tecnología.' ),
			array( 'title' => $p2_t ?: 'Ingeniería de Aplicación Propia', 'description' => $p2_d ?: 'Dimensionamiento a medida, selección de materiales y cumplimiento estricto de normativas internacionales.' ),
			array( 'title' => $p3_t ?: 'Servicio Técnico en Terreno', 'description' => $p3_d ?: 'Ingenieros especialistas para puesta en marcha, pruebas de mar, mantenciones y capacitación.' ),
			array( 'title' => $p4_t ?: 'Cuidado del Medio Ambiente Acuático', 'description' => $p4_d ?: 'Tecnologías certificadas bajo normas OMI MARPOL Anexo IV y D-2 para cero impacto ambiental.' ),
		),
	);

	// 5. Cobertura Regional
	$cov_t = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_coverage_title', $page_id ) : 'Presencia estratégica en Chile y la región';
	$cov_d = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_coverage_desc', $page_id ) : 'Desde nuestra sede central en Reñaca, Viña del Mar, atendemos faenas, astilleros, puertos y centros acuícolas a lo largo de toda la costa de Chile y brindamos soporte para proyectos en Sudamérica.';
	$cov_c = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_hq_city', $page_id ) : 'Reñaca, Viña del Mar, Región de Valparaíso, Chile';
	$cov_s = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_coverage_scope', $page_id ) : 'Nacional (Arica a Punta Arenas) y Latinoamérica';

	$coverage = array(
		'title'        => ! empty( $cov_t ) ? sanitize_text_field( $cov_t ) : 'Presencia estratégica en Chile y la región',
		'description'  => ! empty( $cov_d ) ? sanitize_textarea_field( $cov_d ) : 'Desde nuestra sede central en Reñaca, Viña del Mar, atendemos faenas, astilleros, puertos y centros acuícolas a lo largo de toda la costa de Chile y brindamos soporte para proyectos en Sudamérica.',
		'headquarters' => ! empty( $cov_c ) ? sanitize_text_field( $cov_c ) : 'Reñaca, Viña del Mar, Región de Valparaíso, Chile',
		'scope'        => ! empty( $cov_s ) ? sanitize_text_field( $cov_s ) : 'Nacional (Arica a Punta Arenas) y Latinoamérica',
	);

	// 6. Call to Action
	$cta_h = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_cta_heading', $page_id ) : 'Conozca cómo nuestros ingenieros pueden respaldar su próximo proyecto';
	$cta_d = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_cta_desc', $page_id ) : 'Contáctenos para evaluar requerimientos técnicos, dimensionamiento de equipos o asistencia en terreno.';
	$cta_l = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_cta_btn_label', $page_id ) : 'Contactar al equipo de ingeniería';
	$cta_u = function_exists( 'get_field' ) && $page_id ? get_field( 'nosotros_cta_btn_url', $page_id ) : '/contacto/';

	$cta = array(
		'heading'     => ! empty( $cta_h ) ? sanitize_text_field( $cta_h ) : 'Conozca cómo nuestros ingenieros pueden respaldar su próximo proyecto',
		'description' => ! empty( $cta_d ) ? sanitize_textarea_field( $cta_d ) : 'Contáctenos para evaluar requerimientos técnicos, dimensionamiento de equipos o asistencia en terreno.',
		'button'      => array(
			'label' => ! empty( $cta_l ) ? sanitize_text_field( $cta_l ) : 'Contactar al equipo de ingeniería',
			'url'   => ! empty( $cta_u ) ? esc_url_raw( $cta_u ) : '/contacto/',
		),
	);

	// 7. SEO
	$seo_title = function_exists( 'get_field' ) && $page_id ? sanitize_text_field( (string) get_field( 'seo_meta_title', $page_id ) ) : '';
	$seo_desc  = function_exists( 'get_field' ) && $page_id ? sanitize_text_field( (string) get_field( 'seo_meta_description', $page_id ) ) : '';
	$seo_img   = function_exists( 'get_field' ) && $page_id ? esc_url_raw( (string) get_field( 'seo_og_image', $page_id ) ) : '';

	return array(
		'slug'     => 'nosotros',
		'title'    => ! empty( $seo_title ) ? $seo_title : 'Nosotros · Trayectoria y Especialistas en Tecnología Marina | MITSA',
		'seo'      => array(
			'meta_title'       => ! empty( $seo_title ) ? $seo_title : 'Nosotros · Trayectoria y Especialistas en Tecnología Marina | MITSA',
			'meta_description' => ! empty( $seo_desc ) ? $seo_desc : 'Pioneros en tecnología marina y ambiental en Chile desde 1982. Representantes oficiales de EVAC, Cathelco, ERMA FIRST, EPE y BLÜCHER.',
			'canonical_url'    => 'https://mitsachile.com/nosotros/',
			'og_image'         => ! empty( $seo_img ) ? $seo_img : 'https://mitsachile.com/images/oficina-mitsa-54b17efd.jpg',
			'og_type'          => 'website',
		),
		'sections' => array(
			'hero'           => $hero,
			'story'          => $story,
			'mission_vision' => $mission_vision,
			'pillars'        => $pillars,
			'coverage'       => $coverage,
			'cta'            => $cta,
		),
	);
}

/**
 * Genera la estructura de datos normalizada para la página Servicios.
 *
 * @return array
 */
function mitsa_get_servicios_sections_data() {
	$page = get_page_by_path( 'servicios' );
	$page_id = $page ? (int) $page->ID : 0;

	// 1. Hero
	$h_title = function_exists( 'get_field' ) && $page_id ? get_field( 'servicios_hero_title', $page_id ) : '';
	$h_desc  = function_exists( 'get_field' ) && $page_id ? get_field( 'servicios_hero_desc', $page_id ) : '';
	$h_b1_l  = function_exists( 'get_field' ) && $page_id ? get_field( 'servicios_hero_btn1_label', $page_id ) : '';
	$h_b1_u  = function_exists( 'get_field' ) && $page_id ? get_field( 'servicios_hero_btn1_url', $page_id ) : '';
	$h_b2_l  = function_exists( 'get_field' ) && $page_id ? get_field( 'servicios_hero_btn2_label', $page_id ) : '';
	$h_b2_u  = function_exists( 'get_field' ) && $page_id ? get_field( 'servicios_hero_btn2_url', $page_id ) : '';
	$h_img   = function_exists( 'get_field' ) && $page_id ? get_field( 'servicios_hero_image', $page_id ) : '';

	$hero = array(
		'title'            => ! empty( $h_title ) ? sanitize_text_field( $h_title ) : 'El equipo llega. Alguien tiene que responder por él.',
		'description'      => ! empty( $h_desc ) ? sanitize_textarea_field( $h_desc ) : 'Seis servicios que cubren el ciclo completo: desde el levantamiento a bordo hasta el repuesto que se necesita cinco años después de la entrega.',
		'primary_button'   => array(
			'label' => ! empty( $h_b1_l ) ? sanitize_text_field( $h_b1_l ) : 'Solicitar servicio técnico',
			'url'   => ! empty( $h_b1_u ) ? esc_url_raw( $h_b1_u ) : '/contacto/?tipo=servicio',
		),
		'secondary_button' => array(
			'label' => ! empty( $h_b2_l ) ? sanitize_text_field( $h_b2_l ) : 'Pedir repuestos',
			'url'   => ! empty( $h_b2_u ) ? esc_url_raw( $h_b2_u ) : '/contacto/?tipo=repuestos',
		),
		'image'            => ! empty( $h_img ) ? esc_url_raw( $h_img ) : '/images/montaje-y-supervisió-55f086a2.jpg',
	);

	// 2. Métricas
	$m1_v = function_exists( 'get_field' ) && $page_id ? get_field( 'servicios_m1_val', $page_id ) : '6';
	$m1_l = function_exists( 'get_field' ) && $page_id ? get_field( 'servicios_m1_lbl', $page_id ) : 'servicios sobre el mismo sistema';
	$m2_v = function_exists( 'get_field' ) && $page_id ? get_field( 'servicios_m2_val', $page_id ) : '5';
	$m2_l = function_exists( 'get_field' ) && $page_id ? get_field( 'servicios_m2_lbl', $page_id ) : 'fabricantes representados directamente';
	$m3_v = function_exists( 'get_field' ) && $page_id ? get_field( 'servicios_m3_val', $page_id ) : '100%';
	$m3_l = function_exists( 'get_field' ) && $page_id ? get_field( 'servicios_m3_lbl', $page_id ) : 'cobertura de puertos y astilleros en Chile';

	$metrics = array(
		array( 'value' => $m1_v ?: '6', 'label' => $m1_l ?: 'servicios sobre el mismo sistema' ),
		array( 'value' => $m2_v ?: '5', 'label' => $m2_l ?: 'fabricantes representados directamente' ),
		array( 'value' => $m3_v ?: '100%', 'label' => $m3_l ?: 'cobertura de puertos y astilleros en Chile' ),
	);

	// 3. Catálogo de 6 Servicios
	$catalog = array();
	$default_services = array(
		1 => array( 'num' => '01', 'exec' => 'Ejecuta MITSA', 'title' => 'Ingeniería y dimensionamiento', 'desc' => 'Levantamiento a bordo, cálculo de capacidad y definición del sistema antes de cotizar. El alcance queda formalizado por escrito para evitar sobrecostos en obra.', 'tags' => 'Levantamiento a bordo, Memoria de cálculo, Planos de integración CAD', 'img' => '/images/ingeniería-y-dimensi-fcbfca32.jpg' ),
		2 => array( 'num' => '02', 'exec' => 'Ejecuta MITSA', 'title' => 'Suministro e importación oficial', 'desc' => 'Equipos de las cinco representadas con garantía directa de fábrica, gestión aduanera e integración con la carta Gantt del astillero o armador.', 'tags' => 'Importación directa, Garantía de fábrica, Coordinación de plazos', 'img' => '/images/suministro-832ba3a1.jpg' ),
		3 => array( 'num' => '03', 'exec' => 'MITSA · Astillero', 'title' => 'Montaje y supervisión', 'desc' => 'Supervisión técnica de montaje mecánico, eléctrico e hidráulico durante la instalación, tanto en dique como con la nave en operación.', 'tags' => 'Supervisión en obra, Protocolos de montaje, Registro fotográfico', 'img' => '/images/montaje-y-supervisió-55f086a2.jpg' ),
		4 => array( 'num' => '04', 'exec' => 'MITSA + Fabricante', 'title' => 'Puesta en marcha y comisionamiento', 'desc' => 'Pruebas de mar, ajuste de parámetros, calibración de sensores, capacitación a la tripulación y emisión del acta de entrega oficial.', 'tags' => 'Pruebas de mar, Capacitación tripulación, Acta de entrega', 'img' => '/images/puesta-en-marcha-b7442d66.jpg' ),
		5 => array( 'num' => '05', 'exec' => 'Ejecuta MITSA', 'title' => 'Repuestos originales y retrofit', 'desc' => 'Identificación exacta por número de parte (P/N), reemplazo de componentes obsoletos y actualización de sistemas sanitarios o de tratamiento sin rehacer la red completa.', 'tags' => 'N° de parte oficial, Stock crítico, Actualización normativa', 'img' => '/images/repuestos-y-retrofit-4936b635.jpg' ),
		6 => array( 'num' => '06', 'exec' => 'Ejecuta MITSA', 'title' => 'Soporte y continuidad operacional', 'desc' => 'Diagnóstico remoto de alarmas, visitas técnicas de emergencia en puerto y programas de mantenimiento preventivo durante toda la vida útil del buque.', 'tags' => 'Diagnóstico remoto, Visita en terreno, Plan de mantenimiento', 'img' => '/images/técnico-en-terreno-c-3f561914.jpg' ),
	);

	for ( $i = 1; $i <= 6; $i++ ) {
		$def = $default_services[ $i ];
		$num  = function_exists( 'get_field' ) && $page_id ? get_field( "srv{$i}_num", $page_id ) : $def['num'];
		$exec = function_exists( 'get_field' ) && $page_id ? get_field( "srv{$i}_executor", $page_id ) : $def['exec'];
		$tit  = function_exists( 'get_field' ) && $page_id ? get_field( "srv{$i}_title", $page_id ) : $def['title'];
		$dsc  = function_exists( 'get_field' ) && $page_id ? get_field( "srv{$i}_desc", $page_id ) : $def['desc'];
		$tgs  = function_exists( 'get_field' ) && $page_id ? get_field( "srv{$i}_tags", $page_id ) : $def['tags'];
		$img  = function_exists( 'get_field' ) && $page_id ? get_field( "srv{$i}_image", $page_id ) : $def['img'];

		$tags_array = array_filter( array_map( 'trim', explode( ',', $tgs ?: $def['tags'] ) ) );

		$catalog[] = array(
			'num'      => $num ?: $def['num'],
			'executor' => $exec ?: $def['exec'],
			'title'    => $tit ?: $def['title'],
			'desc'     => $dsc ?: $def['desc'],
			'tags'     => $tags_array,
			'image'    => $img ?: $def['img'],
		);
	}

	// 4. Proceso de Asesoramiento (4 etapas confirmadas por el brochure)
	$pr_head = function_exists( 'get_field' ) && $page_id ? get_field( 'process_heading', $page_id ) : 'Proceso de asesoramiento y cotización técnica';
	$pr_sub  = function_exists( 'get_field' ) && $page_id ? get_field( 'process_subheading', $page_id ) : 'Metodología estructurada de 4 etapas que asegura la compatibilidad exacta entre el requerimiento operativo y el diseño del fabricante.';

	$steps = array(
		array(
			'step'        => '01',
			'title'       => ( function_exists( 'get_field' ) && $page_id && get_field( 'process_step1_title', $page_id ) ) ? get_field( 'process_step1_title', $page_id ) : '1. Requerimiento',
			'description' => ( function_exists( 'get_field' ) && $page_id && get_field( 'process_step1_desc', $page_id ) ) ? get_field( 'process_step1_desc', $page_id ) : 'El cliente solicita cotizar un sistema, equipo o elemento específico para su embarcación o instalación.',
		),
		array(
			'step'        => '02',
			'title'       => ( function_exists( 'get_field' ) && $page_id && get_field( 'process_step2_title', $page_id ) ) ? get_field( 'process_step2_title', $page_id ) : '2. Evaluación',
			'description' => ( function_exists( 'get_field' ) && $page_id && get_field( 'process_step2_desc', $page_id ) ) ? get_field( 'process_step2_desc', $page_id ) : 'MITSA evalúa junto con sus representadas las alternativas de diseño de cada fabricante según precio, innovación, normativa y calidad.',
		),
		array(
			'step'        => '03',
			'title'       => ( function_exists( 'get_field' ) && $page_id && get_field( 'process_step3_title', $page_id ) ) ? get_field( 'process_step3_title', $page_id ) : '3. Presentación',
			'description' => ( function_exists( 'get_field' ) && $page_id && get_field( 'process_step3_desc', $page_id ) ) ? get_field( 'process_step3_desc', $page_id ) : 'Presentamos al cliente las mejores opciones técnicas y comerciales que satisfacen plenamente su necesidad.',
		),
		array(
			'step'        => '04',
			'title'       => ( function_exists( 'get_field' ) && $page_id && get_field( 'process_step4_title', $page_id ) ) ? get_field( 'process_step4_title', $page_id ) : '4. Suministro & Soporte',
			'description' => ( function_exists( 'get_field' ) && $page_id && get_field( 'process_step4_desc', $page_id ) ) ? get_field( 'process_step4_desc', $page_id ) : 'Una vez elegida la opción, se procede al suministro, coordinación de entrega e inicio del plan de acompañamiento operativo.',
		),
	);

	$process = array(
		'heading'    => ! empty( $pr_head ) ? sanitize_text_field( $pr_head ) : 'Proceso de asesoramiento y cotización técnica',
		'subheading' => ! empty( $pr_sub ) ? sanitize_textarea_field( $pr_sub ) : 'Metodología estructurada de 4 etapas que asegura la compatibilidad exacta entre el requerimiento operativo y el diseño del fabricante.',
		'steps'      => $steps,
	);

	// 5. Call to Action
	$cta_h   = function_exists( 'get_field' ) && $page_id ? get_field( 'servicios_cta_heading', $page_id ) : '¿Tiene un proyecto naval o industrial en curso?';
	$cta_d   = function_exists( 'get_field' ) && $page_id ? get_field( 'servicios_cta_desc', $page_id ) : 'Revise requerimientos de caudal, espacio y plazos de entrega directamente con nuestros ingenieros de aplicación.';
	$cta_b1l = function_exists( 'get_field' ) && $page_id ? get_field( 'servicios_cta_btn1_label', $page_id ) : 'Solicitar evaluación técnica';
	$cta_b1u = function_exists( 'get_field' ) && $page_id ? get_field( 'servicios_cta_btn1_url', $page_id ) : '/contacto/?tipo=evaluacion';
	$cta_b2l = function_exists( 'get_field' ) && $page_id ? get_field( 'servicios_cta_btn2_label', $page_id ) : 'Consultar repuestos';
	$cta_b2u = function_exists( 'get_field' ) && $page_id ? get_field( 'servicios_cta_btn2_url', $page_id ) : '/contacto/?tipo=repuestos';

	$cta = array(
		'heading'          => ! empty( $cta_h ) ? sanitize_text_field( $cta_h ) : '¿Tiene un proyecto naval o industrial en curso?',
		'description'      => ! empty( $cta_d ) ? sanitize_textarea_field( $cta_d ) : 'Revise requerimientos de caudal, espacio y plazos de entrega directamente con nuestros ingenieros de aplicación.',
		'primary_button'   => array(
			'label' => ! empty( $cta_b1l ) ? sanitize_text_field( $cta_b1l ) : 'Solicitar evaluación técnica',
			'url'   => ! empty( $cta_b1u ) ? esc_url_raw( $cta_b1u ) : '/contacto/?tipo=evaluacion',
		),
		'secondary_button' => array(
			'label' => ! empty( $cta_b2l ) ? sanitize_text_field( $cta_b2l ) : 'Consultar repuestos',
			'url'   => ! empty( $cta_b2u ) ? esc_url_raw( $cta_b2u ) : '/contacto/?tipo=repuestos',
		),
	);

	// 6. SEO
	$seo_title = function_exists( 'get_field' ) && $page_id ? sanitize_text_field( (string) get_field( 'seo_meta_title', $page_id ) ) : '';
	$seo_desc  = function_exists( 'get_field' ) && $page_id ? sanitize_text_field( (string) get_field( 'seo_meta_description', $page_id ) ) : '';
	$seo_img   = function_exists( 'get_field' ) && $page_id ? esc_url_raw( (string) get_field( 'seo_og_image', $page_id ) ) : '';

	return array(
		'slug'     => 'servicios',
		'title'    => ! empty( $seo_title ) ? $seo_title : 'Servicios de Ingeniería Marina, Suministro y Puesta en Marcha | MITSA',
		'seo'      => array(
			'meta_title'       => ! empty( $seo_title ) ? $seo_title : 'Servicios de Ingeniería Marina, Suministro y Puesta en Marcha | MITSA',
			'meta_description' => ! empty( $seo_desc ) ? $seo_desc : 'Servicios integrales de ingeniería marítima: dimensionamiento a bordo, suministro oficial, supervisión de montaje, comisionamiento, repuestos originales y soporte.',
			'canonical_url'    => 'https://mitsachile.com/servicios/',
			'og_image'         => ! empty( $seo_img ) ? $seo_img : 'https://mitsachile.com/images/montaje-y-supervisió-55f086a2.jpg',
			'og_type'          => 'website',
		),
		'sections' => array(
			'hero'    => $hero,
			'metrics' => $metrics,
			'catalog' => $catalog,
			'process' => $process,
			'cta'     => $cta,
		),
	);
}

/**
 * Genera la estructura de datos normalizada para la página Industrias / Sectores.
 *
 * @return array
 */
function mitsa_get_industrias_sections_data() {
	$page = get_page_by_path( 'sectores' );
	if ( ! $page ) {
		$page = get_page_by_path( 'industrias' );
	}
	$page_id = $page ? (int) $page->ID : 0;

	// 1. Hero
	$h_title = function_exists( 'get_field' ) && $page_id ? get_field( 'industrias_hero_title', $page_id ) : '';
	$h_desc  = function_exists( 'get_field' ) && $page_id ? get_field( 'industrias_hero_desc', $page_id ) : '';
	$h_b1_l  = function_exists( 'get_field' ) && $page_id ? get_field( 'industrias_hero_btn1_label', $page_id ) : '';
	$h_b1_u  = function_exists( 'get_field' ) && $page_id ? get_field( 'industrias_hero_btn1_url', $page_id ) : '';
	$h_b2_l  = function_exists( 'get_field' ) && $page_id ? get_field( 'industrias_hero_btn2_label', $page_id ) : '';
	$h_b2_u  = function_exists( 'get_field' ) && $page_id ? get_field( 'industrias_hero_btn2_url', $page_id ) : '';

	$hero = array(
		'title'            => ! empty( $h_title ) ? sanitize_text_field( $h_title ) : 'Cada industria exige una respuesta técnica distinta',
		'description'      => ! empty( $h_desc ) ? sanitize_textarea_field( $h_desc ) : 'La solución no la define el catálogo: la definen la normativa que aplica, la ventana de intervención disponible y qué pasa si el sistema se detiene.',
		'primary_button'   => array(
			'label' => ! empty( $h_b1_l ) ? sanitize_text_field( $h_b1_l ) : 'Solicitar evaluación técnica',
			'url'   => ! empty( $h_b1_u ) ? esc_url_raw( $h_b1_u ) : '/contacto/?tipo=evaluacion',
		),
		'secondary_button' => array(
			'label' => ! empty( $h_b2_l ) ? sanitize_text_field( $h_b2_l ) : 'Ver sectores',
			'url'   => ! empty( $h_b2_u ) ? sanitize_text_field( $h_b2_u ) : '#sectores',
		),
	);

	// 2. Sectores / Industrias (6)
	$industries = array();
	$default_ind = array(
		1 => array( 'id' => 'naval', 'num' => '01', 'title' => 'Naval y defensa', 'desc' => 'Fragatas, OPVs y patrulleras: construcción nueva, modernización y disponibilidad operacional bajo estrictos requisitos de clase militar.', 'tags' => 'Sanitarios al vacío, ICCP, Aguas residuales, Agua dulce', 'img' => '/images/naval-y-defensa-5b2a62fc.jpg' ),
		2 => array( 'id' => 'acuicultura', 'num' => '02', 'title' => 'Acuicultura y pesca', 'desc' => 'Wellboats, pontones y centros de cultivo con tripulación permanente y ventanas de mantenimiento sumamente acotadas.', 'tags' => 'Sanitarios, Agua dulce, Repuestos, ICAF', 'img' => '/images/acuicultura-64fec532.jpg' ),
		3 => array( 'id' => 'offshore', 'num' => '03', 'title' => 'Offshore y energía', 'desc' => 'Plataformas y unidades de apoyo marítimo (PSV/AHTS) donde el espacio, el peso y la descarga de efluentes están fuertemente normados.', 'tags' => 'BWTS, ICAF, Drenajes, Aguas residuales', 'img' => '/images/offshore-y-energía-37f4cf0d.jpg' ),
		4 => array( 'id' => 'astilleros', 'num' => '04', 'title' => 'Astilleros y reparación', 'desc' => 'Integración de sistemas durante construcción nueva o retrofit en dique seco, coordinado con la carta Gantt del astillero.', 'tags' => 'Retrofit, Montaje, Puesta en marcha, Supervisión', 'img' => '/images/astilleros-y-reparac-9d3b1bf1.jpg' ),
		5 => array( 'id' => 'carga', 'num' => '05', 'title' => 'Transporte marítimo y carga', 'desc' => 'Flotas mercantes y portacontenedores que deben cumplir convenios MARPOL y agua de lastre D-2 sin alterar su itinerario.', 'tags' => 'BWTS, Aguas residuales, Servicio a bordo, ICCP', 'img' => '/images/transporte-marítimo--e848a060.jpg' ),
		6 => array( 'id' => 'tierra', 'num' => '06', 'title' => 'Instalaciones en tierra y minería', 'desc' => 'Plantas industriales, faenas mineras y edificios donde no existe cota de pendiente para redes de evacuación por gravedad.', 'tags' => 'Sanitarios al vacío, Drenajes inox, Agua caliente, Efluentes', 'img' => '/images/instalaciones-en-tie-f9537988.jpg' ),
	);

	for ( $i = 1; $i <= 6; $i++ ) {
		$def  = $default_ind[ $i ];
		$id   = function_exists( 'get_field' ) && $page_id ? get_field( "ind{$i}_id", $page_id ) : $def['id'];
		$num  = function_exists( 'get_field' ) && $page_id ? get_field( "ind{$i}_num", $page_id ) : $def['num'];
		$tit  = function_exists( 'get_field' ) && $page_id ? get_field( "ind{$i}_title", $page_id ) : $def['title'];
		$dsc  = function_exists( 'get_field' ) && $page_id ? get_field( "ind{$i}_desc", $page_id ) : $def['desc'];
		$tgs  = function_exists( 'get_field' ) && $page_id ? get_field( "ind{$i}_tags", $page_id ) : $def['tags'];
		$img  = function_exists( 'get_field' ) && $page_id ? get_field( "ind{$i}_image", $page_id ) : $def['img'];

		$tags_array = array_filter( array_map( 'trim', explode( ',', $tgs ?: $def['tags'] ) ) );

		$industries[] = array(
			'id'    => $id ?: $def['id'],
			'num'   => $num ?: $def['num'],
			'title' => $tit ?: $def['title'],
			'desc'  => $dsc ?: $def['desc'],
			'tags'  => $tags_array,
			'image' => $img ?: $def['img'],
		);
	}

	// 3. Criterios Técnicos
	$cr_head = function_exists( 'get_field' ) && $page_id ? get_field( 'criteria_heading', $page_id ) : 'Criterios de ingeniería por industria';
	$cr_sub  = function_exists( 'get_field' ) && $page_id ? get_field( 'criteria_subheading', $page_id ) : 'Variables críticas de diseño que evalúan nuestros ingenieros de aplicación para cada tipo de instalación.';

	$criteria_items = array(
		array(
			'title'       => ( function_exists( 'get_field' ) && $page_id && get_field( 'crit1_title', $page_id ) ) ? get_field( 'crit1_title', $page_id ) : 'Normativa y Certificaciones de Clase',
			'description' => ( function_exists( 'get_field' ) && $page_id && get_field( 'crit1_desc', $page_id ) ) ? get_field( 'crit1_desc', $page_id ) : 'Cumplimiento estricto con IMO MARPOL (Anexo IV y D-2), SOLAS, USCG y casas clasificadoras (DNV, Lloyd\'s Register, ABS).',
		),
		array(
			'title'       => ( function_exists( 'get_field' ) && $page_id && get_field( 'crit2_title', $page_id ) ) ? get_field( 'crit2_title', $page_id ) : 'Ventanas de Intervención en Faena',
			'description' => ( function_exists( 'get_field' ) && $page_id && get_field( 'crit2_desc', $page_id ) ) ? get_field( 'crit2_desc', $page_id ) : 'Coordinación con recaladas acotadas, diques secos y paradas de planta programadas para evitar sobrecostos por detención.',
		),
		array(
			'title'       => ( function_exists( 'get_field' ) && $page_id && get_field( 'crit3_title', $page_id ) ) ? get_field( 'crit3_title', $page_id ) : 'Redundancia y Continuidad Operativa',
			'description' => ( function_exists( 'get_field' ) && $page_id && get_field( 'crit3_desc', $page_id ) ) ? get_field( 'crit3_desc', $page_id ) : 'Diseño con bombas duplicadas, módulos en standby y repuestos críticos garantizados por el fabricante.',
		),
		array(
			'title'       => ( function_exists( 'get_field' ) && $page_id && get_field( 'crit4_title', $page_id ) ) ? get_field( 'crit4_title', $page_id ) : 'Eficiencia Hídrica y Energética',
			'description' => ( function_exists( 'get_field' ) && $page_id && get_field( 'crit4_desc', $page_id ) ) ? get_field( 'crit4_desc', $page_id ) : 'Reducción de consumo de agua hasta un 90% mediante sistemas al vacío e intercambiadores térmicos de alta eficiencia.',
		),
	);

	$criteria = array(
		'heading'    => ! empty( $cr_head ) ? sanitize_text_field( $cr_head ) : 'Criterios de ingeniería por industria',
		'subheading' => ! empty( $cr_sub ) ? sanitize_textarea_field( $cr_sub ) : 'Variables críticas de diseño que evalúan nuestros ingenieros de aplicación para cada tipo de instalación.',
		'items'      => $criteria_items,
	);

	// 4. CTA
	$cta_h = function_exists( 'get_field' ) && $page_id ? get_field( 'industrias_cta_heading', $page_id ) : '¿Necesita dimensionar una solución para su sector?';
	$cta_d = function_exists( 'get_field' ) && $page_id ? get_field( 'industrias_cta_desc', $page_id ) : 'Nuestros ingenieros evalúan requerimientos específicos de espacio, caudal y normativas aplicables a su industria.';
	$cta_l = function_exists( 'get_field' ) && $page_id ? get_field( 'industrias_cta_btn_label', $page_id ) : 'Contactar a ingeniería de aplicación';
	$cta_u = function_exists( 'get_field' ) && $page_id ? get_field( 'industrias_cta_btn_url', $page_id ) : '/contacto/?tipo=evaluacion';

	$cta = array(
		'heading'     => ! empty( $cta_h ) ? sanitize_text_field( $cta_h ) : '¿Necesita dimensionar una solución para su sector?',
		'description' => ! empty( $cta_d ) ? sanitize_textarea_field( $cta_d ) : 'Nuestros ingenieros evalúan requerimientos específicos de espacio, caudal y normativas aplicables a su industria.',
		'button'      => array(
			'label' => ! empty( $cta_l ) ? sanitize_text_field( $cta_l ) : 'Contactar a ingeniería de aplicación',
			'url'   => ! empty( $cta_u ) ? esc_url_raw( $cta_u ) : '/contacto/?tipo=evaluacion',
		),
	);

	// 5. SEO
	$seo_title = function_exists( 'get_field' ) && $page_id ? sanitize_text_field( (string) get_field( 'seo_meta_title', $page_id ) ) : '';
	$seo_desc  = function_exists( 'get_field' ) && $page_id ? sanitize_text_field( (string) get_field( 'seo_meta_description', $page_id ) ) : '';
	$seo_img   = function_exists( 'get_field' ) && $page_id ? esc_url_raw( (string) get_field( 'seo_og_image', $page_id ) ) : '';

	return array(
		'slug'     => 'industrias',
		'title'    => ! empty( $seo_title ) ? $seo_title : 'Sectores e Industrias · Soluciones Navales, Acuícolas e Industriales | MITSA',
		'seo'      => array(
			'meta_title'       => ! empty( $seo_title ) ? $seo_title : 'Sectores e Industrias · Soluciones Navales, Acuícolas e Industriales | MITSA',
			'meta_description' => ! empty( $seo_desc ) ? $seo_desc : 'Soluciones de ingeniería naval, sanitaria y ambiental por sector: Naval & Defensa, Astilleros, Acuicultura, Offshore, Transporte Marítimo e Instalaciones en Tierra.',
			'canonical_url'    => 'https://mitsachile.com/industrias/',
			'og_image'         => ! empty( $seo_img ) ? $seo_img : 'https://mitsachile.com/images/naval-y-defensa-5b2a62fc.jpg',
			'og_type'          => 'website',
		),
		'sections' => array(
			'hero'       => $hero,
			'industries' => $industries,
			'criteria'   => $criteria,
			'cta'        => $cta,
		),
	);
}

/**
 * Genera la estructura de datos normalizada para la página Proyectos & Casos de Éxito.
 *
 * @return array
 */
function mitsa_get_proyectos_sections_data() {
	$page    = get_page_by_path( 'proyectos' );
	$page_id = $page ? (int) $page->ID : 0;

	// 1. Hero
	$h_title = function_exists( 'get_field' ) && $page_id ? get_field( 'proyectos_hero_title', $page_id ) : '';
	$h_desc  = function_exists( 'get_field' ) && $page_id ? get_field( 'proyectos_hero_desc', $page_id ) : '';
	$h_img   = function_exists( 'get_field' ) && $page_id ? get_field( 'proyectos_hero_img', $page_id ) : '';
	$h_b1_l  = function_exists( 'get_field' ) && $page_id ? get_field( 'proyectos_btn1_label', $page_id ) : '';
	$h_b1_u  = function_exists( 'get_field' ) && $page_id ? get_field( 'proyectos_btn1_url', $page_id ) : '';
	$h_b2_l  = function_exists( 'get_field' ) && $page_id ? get_field( 'proyectos_btn2_label', $page_id ) : '';
	$h_b2_u  = function_exists( 'get_field' ) && $page_id ? get_field( 'proyectos_btn2_url', $page_id ) : '';

	$hero = array(
		'title'            => ! empty( $h_title ) ? sanitize_text_field( $h_title ) : 'Lo que ya está instalado y operando.',
		'description'      => ! empty( $h_desc ) ? sanitize_textarea_field( $h_desc ) : 'Cada proyecto publica el sistema, la industria y el fabricante detrás. Casos reales y representativos respaldados por 40 años de trayectoria.',
		'image'            => ! empty( $h_img ) ? esc_url_raw( $h_img ) : '/images/proyectos-img-2-149f33fe.jpg',
		'primary_button'   => array(
			'label' => ! empty( $h_b1_l ) ? sanitize_text_field( $h_b1_l ) : 'Ver proyectos',
			'url'   => ! empty( $h_b1_u ) ? sanitize_text_field( $h_b1_u ) : '#catalogo-proyectos',
		),
		'secondary_button' => array(
			'label' => ! empty( $h_b2_l ) ? sanitize_text_field( $h_b2_l ) : 'Solicitar referencias',
			'url'   => ! empty( $h_b2_u ) ? esc_url_raw( $h_b2_u ) : '/contacto/?tipo=evaluacion',
		),
	);

	// 2. Métricas (3)
	$m1_num = function_exists( 'get_field' ) && $page_id ? get_field( 'proyectos_m1_num', $page_id ) : '40+';
	$m1_lbl = function_exists( 'get_field' ) && $page_id ? get_field( 'proyectos_m1_label', $page_id ) : 'años integrando sistemas en Chile';
	$m2_num = function_exists( 'get_field' ) && $page_id ? get_field( 'proyectos_m2_num', $page_id ) : '10';
	$m2_lbl = function_exists( 'get_field' ) && $page_id ? get_field( 'proyectos_m2_label', $page_id ) : 'líneas de solución en operación';
	$m3_num = function_exists( 'get_field' ) && $page_id ? get_field( 'proyectos_m3_num', $page_id ) : '100%';
	$m3_lbl = function_exists( 'get_field' ) && $page_id ? get_field( 'proyectos_m3_label', $page_id ) : 'cumplimiento en protocolos y pruebas de mar';

	$metrics = array(
		array( 'value' => $m1_num ?: '40+', 'label' => $m1_lbl ?: 'años integrando sistemas en Chile' ),
		array( 'value' => $m2_num ?: '10', 'label' => $m2_lbl ?: 'líneas de solución en operación' ),
		array( 'value' => $m3_num ?: '100%', 'label' => $m3_lbl ?: 'cumplimiento en protocolos y pruebas de mar' ),
	);

	// 3. Proyectos / Casos de Éxito (6)
	$default_projects = array(
		1 => array( 'num' => '01', 'sector' => 'Astillero', 'title' => 'Astillero — Construcción nueva', 'desc' => 'Sistema sanitario al vacío completo para una unidad en construcción, dimensionado antes del corte de primera plancha de acero.', 'tags' => 'Astillero, Sanitarios al vacío, EVAC', 'img' => '/images/proyectos-img-3-636210b7.jpg' ),
		2 => array( 'num' => '02', 'sector' => 'Buques de apoyo', 'title' => 'Buque de apoyo (PSV) — Retrofit', 'desc' => 'Reemplazo integral de la planta de tratamiento de aguas servidas con la nave en operación, sin alterar la red troncal existente.', 'tags' => 'Buques de apoyo, Aguas residuales, EVAC · BLÜCHER', 'img' => '/images/proyectos-img-4-8d5d1037.jpg' ),
		3 => array( 'num' => '03', 'sector' => 'Offshore', 'title' => 'Plataforma offshore — Protección catódica', 'desc' => 'Protección catódica por corriente impresa (ICCP) y control de bioincrustación (ICAF) en estructura fija con monitoreo automático continuo.', 'tags' => 'Offshore, ICCP · ICAF, Cathelco', 'img' => '/images/proyectos-img-5-8886341c.jpg' ),
		4 => array( 'num' => '04', 'sector' => 'Acuicultura', 'title' => 'Centro de cultivo — Pontón habitable', 'desc' => 'Tratamiento de efluentes y saneamiento integral en pontón habitable con logística y soporte de repuestos en la Región de Los Lagos.', 'tags' => 'Acuicultura, Tratamiento de aguas, ERMA FIRST', 'img' => '/images/proyectos-img-6-6ece81b5.jpg' ),
		5 => array( 'num' => '05', 'sector' => 'Pesca', 'title' => 'Flota pesquera — Redes al vacío continuas', 'desc' => 'Modernización de sistemas sanitarios y drenajes inoxidables en flota de alta mar para operaciones continuas en aguas frías.', 'tags' => 'Pesca industrial, Vacío marino, BLÜCHER · EVAC', 'img' => '/images/proyectos-img-2-149f33fe.jpg' ),
		6 => array( 'num' => '06', 'sector' => 'Minería e Industria', 'title' => 'Campamento minero — Evacuación sin pendiente', 'desc' => 'Red de vacío en terreno plano para campamento en altura geográfica, eliminando excavaciones profundas y optimizando consumo de agua.', 'tags' => 'Minería, Drenajes, EVAC · BLÜCHER', 'img' => '/images/instalaciones-en-tie-f9537988.jpg' ),
	);

	$projects = array();
	for ( $i = 1; $i <= 6; $i++ ) {
		$def  = $default_projects[ $i ];
		$num  = function_exists( 'get_field' ) && $page_id ? get_field( "pcase{$i}_num", $page_id ) : $def['num'];
		$sec  = function_exists( 'get_field' ) && $page_id ? get_field( "pcase{$i}_sector", $page_id ) : $def['sector'];
		$tit  = function_exists( 'get_field' ) && $page_id ? get_field( "pcase{$i}_title", $page_id ) : $def['title'];
		$dsc  = function_exists( 'get_field' ) && $page_id ? get_field( "pcase{$i}_desc", $page_id ) : $def['desc'];
		$tgs  = function_exists( 'get_field' ) && $page_id ? get_field( "pcase{$i}_tags", $page_id ) : $def['tags'];
		$img  = function_exists( 'get_field' ) && $page_id ? get_field( "pcase{$i}_image", $page_id ) : $def['img'];

		$tags_array = array_filter( array_map( 'trim', explode( ',', $tgs ?: $def['tags'] ) ) );

		$projects[] = array(
			'num'         => $num ?: $def['num'],
			'sector'      => $sec ?: $def['sector'],
			'title'       => $tit ?: $def['title'],
			'description' => $dsc ?: $def['desc'],
			'tags'        => $tags_array,
			'image'       => $img ?: $def['img'],
			'url'         => '/contacto/?tipo=evaluacion&proyecto=' . sanitize_title( $tit ?: $def['title'] ),
		);
	}

	// 4. Metodología de Ejecución
	$m_head = function_exists( 'get_field' ) && $page_id ? get_field( 'proyectos_method_heading', $page_id ) : '¿Cómo ejecutamos cada proyecto?';
	$m_desc = function_exists( 'get_field' ) && $page_id ? get_field( 'proyectos_method_desc', $page_id ) : 'Desde la ingeniería de preventa hasta las pruebas de mar y el soporte postventa a largo plazo.';

	$steps = array(
		array(
			'step'        => '01',
			'title'       => ( function_exists( 'get_field' ) && $page_id && get_field( 'meth1_title', $page_id ) ) ? get_field( 'meth1_title', $page_id ) : '1. Levantamiento & Viabilidad',
			'description' => ( function_exists( 'get_field' ) && $page_id && get_field( 'meth1_desc', $page_id ) ) ? get_field( 'meth1_desc', $page_id ) : 'Evaluación de planos, requerimientos de caudal, consumo energético y espacios disponibles en la nave o instalación.',
		),
		array(
			'step'        => '02',
			'title'       => ( function_exists( 'get_field' ) && $page_id && get_field( 'meth2_title', $page_id ) ) ? get_field( 'meth2_title', $page_id ) : '2. Ingeniería & Suministro',
			'description' => ( function_exists( 'get_field' ) && $page_id && get_field( 'meth2_desc', $page_id ) ) ? get_field( 'meth2_desc', $page_id ) : 'Selección directa con los fabricantes representados y coordinación de plazos de entrega en puerto o faena.',
		),
		array(
			'step'        => '03',
			'title'       => ( function_exists( 'get_field' ) && $page_id && get_field( 'meth3_title', $page_id ) ) ? get_field( 'meth3_title', $page_id ) : '3. Supervisión & Puesta en Marcha',
			'description' => ( function_exists( 'get_field' ) && $page_id && get_field( 'meth3_desc', $page_id ) ) ? get_field( 'meth3_desc', $page_id ) : 'Acompañamiento en dique seco o terreno por ingenieros certificados para pruebas FAT/HAT y comisionamiento.',
		),
		array(
			'step'        => '04',
			'title'       => ( function_exists( 'get_field' ) && $page_id && get_field( 'meth4_title', $page_id ) ) ? get_field( 'meth4_title', $page_id ) : '4. Garantía & Soporte Continuo',
			'description' => ( function_exists( 'get_field' ) && $page_id && get_field( 'meth4_desc', $page_id ) ) ? get_field( 'meth4_desc', $page_id ) : 'Entrega de protocolos a inspectores de clase, capacitación a tripulación y provisión continua de repuestos originales.',
		),
	);

	$methodology = array(
		'heading'     => ! empty( $m_head ) ? sanitize_text_field( $m_head ) : '¿Cómo ejecutamos cada proyecto?',
		'description' => ! empty( $m_desc ) ? sanitize_textarea_field( $m_desc ) : 'Desde la ingeniería de preventa hasta las pruebas de mar y el soporte postventa a largo plazo.',
		'steps'       => $steps,
	);

	// 5. CTA
	$cta_h = function_exists( 'get_field' ) && $page_id ? get_field( 'proyectos_cta_heading', $page_id ) : '¿Tiene un proyecto naval o industrial en evaluación?';
	$cta_d = function_exists( 'get_field' ) && $page_id ? get_field( 'proyectos_cta_desc', $page_id ) : 'Podemos compartir casos técnicos de referencia similares y coordinar una reunión con nuestros ingenieros de aplicación.';
	$cta_l = function_exists( 'get_field' ) && $page_id ? get_field( 'proyectos_cta_btn_label', $page_id ) : 'Solicitar referencias de ingeniería';
	$cta_u = function_exists( 'get_field' ) && $page_id ? get_field( 'proyectos_cta_btn_url', $page_id ) : '/contacto/?tipo=evaluacion';

	$cta = array(
		'heading'     => ! empty( $cta_h ) ? sanitize_text_field( $cta_h ) : '¿Tiene un proyecto naval o industrial en evaluación?',
		'description' => ! empty( $cta_d ) ? sanitize_textarea_field( $cta_d ) : 'Podemos compartir casos técnicos de referencia similares y coordinar una reunión con nuestros ingenieros de aplicación.',
		'button'      => array(
			'label' => ! empty( $cta_l ) ? sanitize_text_field( $cta_l ) : 'Solicitar referencias de ingeniería',
			'url'   => ! empty( $cta_u ) ? esc_url_raw( $cta_u ) : '/contacto/?tipo=evaluacion',
		),
	);

	// 6. SEO
	$seo_title = function_exists( 'get_field' ) && $page_id ? sanitize_text_field( (string) get_field( 'seo_meta_title', $page_id ) ) : '';
	$seo_desc  = function_exists( 'get_field' ) && $page_id ? sanitize_text_field( (string) get_field( 'seo_meta_description', $page_id ) ) : '';
	$seo_img   = function_exists( 'get_field' ) && $page_id ? esc_url_raw( (string) get_field( 'seo_og_image', $page_id ) ) : '';

	return array(
		'slug'     => 'proyectos',
		'title'    => ! empty( $seo_title ) ? $seo_title : 'Proyectos & Casos de Éxito · Casos de Ingeniería en Chile y Latinoamérica | MITSA',
		'seo'      => array(
			'meta_title'       => ! empty( $seo_title ) ? $seo_title : 'Proyectos & Casos de Éxito · Casos de Ingeniería en Chile y Latinoamérica | MITSA',
			'meta_description' => ! empty( $seo_desc ) ? $seo_desc : 'Casos representativos de ingeniería naval y ambiental instalados y operando en Chile: Armada, astilleros, navieras, minería y acuicultura.',
			'canonical_url'    => 'https://mitsachile.com/proyectos/',
			'og_image'         => ! empty( $seo_img ) ? $seo_img : 'https://mitsachile.com/images/proyectos-img-2-149f33fe.jpg',
			'og_type'          => 'website',
		),
		'sections' => array(
			'hero'        => $hero,
			'metrics'     => $metrics,
			'projects'    => $projects,
			'methodology' => $methodology,
			'cta'         => $cta,
		),
	);
}

/**
 * Genera la estructura de datos normalizada para la página Recursos & Biblioteca Técnica.
 *
 * @return array
 */
function mitsa_get_recursos_sections_data() {
	$page    = get_page_by_path( 'recursos' );
	$page_id = $page ? (int) $page->ID : 0;

	// 1. Hero
	$h_title = function_exists( 'get_field' ) && $page_id ? get_field( 'recursos_hero_title', $page_id ) : '';
	$h_desc  = function_exists( 'get_field' ) && $page_id ? get_field( 'recursos_hero_desc', $page_id ) : '';
	$h_img   = function_exists( 'get_field' ) && $page_id ? get_field( 'recursos_hero_img', $page_id ) : '';
	$h_b1_l  = function_exists( 'get_field' ) && $page_id ? get_field( 'recursos_btn1_label', $page_id ) : '';
	$h_b1_u  = function_exists( 'get_field' ) && $page_id ? get_field( 'recursos_btn1_url', $page_id ) : '';
	$h_b2_l  = function_exists( 'get_field' ) && $page_id ? get_field( 'recursos_btn2_label', $page_id ) : '';
	$h_b2_u  = function_exists( 'get_field' ) && $page_id ? get_field( 'recursos_btn2_url', $page_id ) : '';

	$hero = array(
		'title'            => ! empty( $h_title ) ? sanitize_text_field( $h_title ) : 'El criterio técnico, publicado.',
		'description'      => ! empty( $h_desc ) ? sanitize_textarea_field( $h_desc ) : 'Artículos abiertos sobre normativa marítima, documentación técnica de representadas y protocolos de ingeniería para clientes.',
		'image'            => ! empty( $h_img ) ? esc_url_raw( $h_img ) : '/images/recursos-img-2-92bb5d09.jpg',
		'primary_button'   => array(
			'label' => ! empty( $h_b1_l ) ? sanitize_text_field( $h_b1_l ) : 'Ver artículos técnicos',
			'url'   => ! empty( $h_b1_u ) ? sanitize_text_field( $h_b1_u ) : '#articulos',
		),
		'secondary_button' => array(
			'label' => ! empty( $h_b2_l ) ? sanitize_text_field( $h_b2_l ) : 'Biblioteca de descargas',
			'url'   => ! empty( $h_b2_u ) ? sanitize_text_field( $h_b2_u ) : '#biblioteca',
		),
	);

	// 2. Gateways (2)
	$gw1_b = function_exists( 'get_field' ) && $page_id ? get_field( 'gw1_badge', $page_id ) : 'Centro Técnico';
	$gw1_t = function_exists( 'get_field' ) && $page_id ? get_field( 'gw1_title', $page_id ) : 'Cómo se decide un sistema a bordo';
	$gw1_d = function_exists( 'get_field' ) && $page_id ? get_field( 'gw1_desc', $page_id ) : 'Artículos abiertos sobre dimensionamiento, normativa OMI, DIRECTEMAR y mejores prácticas de mantenimiento preventivo.';
	$gw1_l = function_exists( 'get_field' ) && $page_id ? get_field( 'gw1_link_label', $page_id ) : 'Ver artículos técnicos →';
	$gw1_u = function_exists( 'get_field' ) && $page_id ? get_field( 'gw1_link_url', $page_id ) : '#articulos';

	$gw2_b = function_exists( 'get_field' ) && $page_id ? get_field( 'gw2_badge', $page_id ) : 'Biblioteca Técnica';
	$gw2_t = function_exists( 'get_field' ) && $page_id ? get_field( 'gw2_title', $page_id ) : 'Fichas, manuales y protocolos';
	$gw2_d = function_exists( 'get_field' ) && $page_id ? get_field( 'gw2_desc', $page_id ) : 'Documentación de las representadas oficiales (EVAC, Cathelco, ERMA FIRST, EPE, BLÜCHER), organizada por equipo.';
	$gw2_l = function_exists( 'get_field' ) && $page_id ? get_field( 'gw2_link_label', $page_id ) : 'Entrar a la biblioteca →';
	$gw2_u = function_exists( 'get_field' ) && $page_id ? get_field( 'gw2_link_url', $page_id ) : '#biblioteca';

	$gateways = array(
		array(
			'badge'       => ! empty( $gw1_b ) ? sanitize_text_field( $gw1_b ) : 'Centro Técnico',
			'title'       => ! empty( $gw1_t ) ? sanitize_text_field( $gw1_t ) : 'Cómo se decide un sistema a bordo',
			'description' => ! empty( $gw1_d ) ? sanitize_textarea_field( $gw1_d ) : 'Artículos abiertos sobre dimensionamiento, normativa OMI, DIRECTEMAR y mejores prácticas de mantenimiento preventivo.',
			'link_label'  => ! empty( $gw1_l ) ? sanitize_text_field( $gw1_l ) : 'Ver artículos técnicos →',
			'link_url'    => ! empty( $gw1_u ) ? sanitize_text_field( $gw1_u ) : '#articulos',
		),
		array(
			'badge'       => ! empty( $gw2_b ) ? sanitize_text_field( $gw2_b ) : 'Biblioteca Técnica',
			'title'       => ! empty( $gw2_t ) ? sanitize_text_field( $gw2_t ) : 'Fichas, manuales y protocolos',
			'description' => ! empty( $gw2_d ) ? sanitize_textarea_field( $gw2_d ) : 'Documentación de las representadas oficiales (EVAC, Cathelco, ERMA FIRST, EPE, BLÜCHER), organizada por equipo.',
			'link_label'  => ! empty( $gw2_l ) ? sanitize_text_field( $gw2_l ) : 'Entrar a la biblioteca →',
			'link_url'    => ! empty( $gw2_u ) ? sanitize_text_field( $gw2_u ) : '#biblioteca',
		),
	);

	// 3. Artículos Técnicos (Cluster Regulatorio)
	$articles = array(
		array(
			'slug'        => 'norma-d2-omi-chile-agua-lastre',
			'title'       => 'Norma D-2 OMI en Chile: Plazos, Exigencias y Soluciones BWTS',
			'description' => 'Guía técnica sobre la implementación del estándar D-2 del Convenio BWM en naves que operan en aguas jurisdiccionales chilenas.',
			'category'    => 'Agua de Lastre · OMI',
			'status'      => 'Borrador Técnico',
			'summary'     => 'Análisis técnico y normativo para el cumplimiento de tratamiento de agua de lastre bajo inspección DIRECTEMAR.',
		),
		array(
			'slug'        => 'circular-a-52-007-directemar-aguas-grises-negras',
			'title'       => 'Circular A-52/007 de DIRECTEMAR: Tratamiento de Aguas Servidas',
			'description' => 'Exigencias de descarga y certificación para naves mayores, pontones y artefactos navales en aguas interiores y bahías chilenas.',
			'category'    => 'DIRECTEMAR · Aguas Servidas',
			'status'      => 'Borrador Técnico',
			'summary'     => 'Requisitos de muestreo, límites de descarga de coliformes fecales y DQO según la autoridad marítima nacional.',
		),
		array(
			'slug'        => 'iccp-vs-anodos-sacrificio-proteccion-catodica-chile',
			'title'       => 'Protección Catódica ICCP vs. Ánodos de Sacrificio',
			'description' => 'Comparativa técnico-económica para cascos de acero en buques mercantes, naves de defensa y plataformas marinas en Chile.',
			'category'    => 'Protección Catódica · Casco',
			'status'      => 'Borrador Técnico',
			'summary'     => 'Cuándo conviene migrar de ánodos galvánicos a corriente impresa automática (ICCP) en dique seco.',
		),
		array(
			'slug'        => 'osmosis-inversa-marina-desalinizacion-a-bordo',
			'title'       => 'Ósmosis Inversa Marina: Desalinización Confiable a Bordo',
			'description' => 'Dimensionamiento, pretratamiento y mantenimiento de plantas desalinizadoras para autonomía de tripulación y faenas en alta mar.',
			'category'    => 'Generación de Agua Dulce',
			'status'      => 'Borrador Técnico',
			'summary'     => 'Criterios de ingeniería para evitar incrustación de membranas y asegurar agua potable continua.',
		),
		array(
			'slug'        => 'marpol-anexo-iv-planta-tratamiento-aguas-servidas-chile',
			'title'       => 'MARPOL Anexo IV y Resolución MEPC.227(64): Plantas Marinas',
			'description' => 'Estándares internacionales de prevención de la contaminación por aguas sucias procedentes de los buques y zonas especiales.',
			'category'    => 'MARPOL · Tratamiento Marino',
			'status'      => 'Borrador Técnico',
			'summary'     => 'Diferencias entre plantas de tratamiento biológico MBBR vs físico-químico y su aprobación de tipo.',
		),
	);

	// 4. Descargas (5 Documentos)
	$default_docs = array(
		1 => array( 'title' => 'Catálogo General de Soluciones MITSA 2026', 'format' => 'PDF · 4.2 MB', 'level' => 'Descarga Libre', 'url' => '/docs/brochure-extracto.pdf' ),
		2 => array( 'title' => 'Ficha Técnica — Sistema Sanitario al Vacío EVAC', 'format' => 'PDF · 1.8 MB', 'level' => 'Acceso Libre', 'url' => '/contacto/?tipo=evaluacion' ),
		3 => array( 'title' => 'Manual de Operación de Plantas de Tratamiento de Aguas Servidas', 'format' => 'PDF · 3.1 MB', 'level' => 'Clientes / Registro', 'url' => '/contacto/?tipo=evaluacion' ),
		4 => array( 'title' => 'Listado de Repuestos Críticos y Números de Parte (P/N)', 'format' => 'XLSX / PDF', 'level' => 'Clientes', 'url' => '/contacto/?tipo=repuestos' ),
		5 => array( 'title' => 'Protocolo de Comisionamiento y Pruebas de Puesta en Marcha', 'format' => 'PDF · 950 KB', 'level' => 'Acceso con Registro', 'url' => '/contacto/?tipo=servicio' ),
	);

	$downloads = array();
	for ( $i = 1; $i <= 5; $i++ ) {
		$def = $default_docs[ $i ];
		$tit = function_exists( 'get_field' ) && $page_id ? get_field( "doc{$i}_title", $page_id ) : $def['title'];
		$fmt = function_exists( 'get_field' ) && $page_id ? get_field( "doc{$i}_format", $page_id ) : $def['format'];
		$lvl = function_exists( 'get_field' ) && $page_id ? get_field( "doc{$i}_level", $page_id ) : $def['level'];
		$url = function_exists( 'get_field' ) && $page_id ? get_field( "doc{$i}_url", $page_id ) : $def['url'];

		$downloads[] = array(
			'title'  => $tit ?: $def['title'],
			'format' => $fmt ?: $def['format'],
			'level'  => $lvl ?: $def['level'],
			'url'    => $url ?: $def['url'],
		);
	}

	// 5. CTA
	$cta_h = function_exists( 'get_field' ) && $page_id ? get_field( 'recursos_cta_heading', $page_id ) : '¿Necesita documentación técnica específica o certificación de fábrica?';
	$cta_d = function_exists( 'get_field' ) && $page_id ? get_field( 'recursos_cta_desc', $page_id ) : 'Gestionamos directamente con los fabricantes las fichas de homologación, certificados tipo (Type Approval) y planos de montaje para su proyecto.';
	$cta_l = function_exists( 'get_field' ) && $page_id ? get_field( 'recursos_cta_btn_label', $page_id ) : 'Solicitar documentación técnica';
	$cta_u = function_exists( 'get_field' ) && $page_id ? get_field( 'recursos_cta_btn_url', $page_id ) : '/contacto/?tipo=evaluacion';

	$cta = array(
		'heading'     => ! empty( $cta_h ) ? sanitize_text_field( $cta_h ) : '¿Necesita documentación técnica específica o certificación de fábrica?',
		'description' => ! empty( $cta_d ) ? sanitize_textarea_field( $cta_d ) : 'Gestionamos directamente con los fabricantes las fichas de homologación, certificados tipo (Type Approval) y planos de montaje para su proyecto.',
		'button'      => array(
			'label' => ! empty( $cta_l ) ? sanitize_text_field( $cta_l ) : 'Solicitar documentación técnica',
			'url'   => ! empty( $cta_u ) ? esc_url_raw( $cta_u ) : '/contacto/?tipo=evaluacion',
		),
	);

	// 6. SEO
	$seo_title = function_exists( 'get_field' ) && $page_id ? sanitize_text_field( (string) get_field( 'seo_meta_title', $page_id ) ) : '';
	$seo_desc  = function_exists( 'get_field' ) && $page_id ? sanitize_text_field( (string) get_field( 'seo_meta_description', $page_id ) ) : '';
	$seo_img   = function_exists( 'get_field' ) && $page_id ? esc_url_raw( (string) get_field( 'seo_og_image', $page_id ) ) : '';

	return array(
		'slug'     => 'recursos',
		'title'    => ! empty( $seo_title ) ? $seo_title : 'Recursos & Biblioteca Técnica · Artículos Regulatorios y Descargas | MITSA',
		'seo'      => array(
			'meta_title'       => ! empty( $seo_title ) ? $seo_title : 'Recursos & Biblioteca Técnica · Artículos Regulatorios y Descargas | MITSA',
			'meta_description' => ! empty( $seo_desc ) ? $seo_desc : 'Artículos técnicos de ingeniería naval, guías regulatorias OMI/DIRECTEMAR (D-2, ICCP, MARPOL, ósmosis) y biblioteca de descargas de MITSA.',
			'canonical_url'    => 'https://mitsachile.com/recursos/',
			'og_image'         => ! empty( $seo_img ) ? $seo_img : 'https://mitsachile.com/images/recursos-img-2-92bb5d09.jpg',
			'og_type'          => 'website',
		),
		'sections' => array(
			'hero'      => $hero,
			'gateways'  => $gateways,
			'articles'  => $articles,
			'downloads' => $downloads,
			'cta'       => $cta,
		),
	);
}

/**
 * Genera la estructura de datos normalizada para la página Contacto & Asesoría Técnica.
 *
 * @return array
 */
function mitsa_get_contacto_sections_data() {
	$page    = get_page_by_path( 'contacto' );
	$page_id = $page ? (int) $page->ID : 0;

	// 1. Hero
	$h_title = function_exists( 'get_field' ) && $page_id ? get_field( 'contacto_hero_title', $page_id ) : '';
	$h_desc  = function_exists( 'get_field' ) && $page_id ? get_field( 'contacto_hero_desc', $page_id ) : '';

	$hero = array(
		'title'       => ! empty( $h_title ) ? sanitize_text_field( $h_title ) : 'Cuéntenos qué necesita resolver',
		'description' => ! empty( $h_desc ) ? sanitize_textarea_field( $h_desc ) : 'Cada requerimiento pide datos distintos. Elegir la puerta correcta conecta su consulta directo con el especialista correspondiente.',
	);

	// 2. 4 Puertas de Entrada
	$default_doors = array(
		1 => array( 'key' => 'evaluacion', 'num' => '01', 'title' => 'Evaluación técnica', 'desc' => 'Proyecto nuevo o retrofit que requiere dimensionar una solución.' ),
		2 => array( 'key' => 'repuestos', 'num' => '02', 'title' => 'Repuestos', 'desc' => 'Identificación y cotización de piezas por número de parte (P/N).' ),
		3 => array( 'key' => 'servicio', 'num' => '03', 'title' => 'Servicio técnico', 'desc' => 'Diagnóstico, comisionamiento o asistencia sobre un sistema.' ),
		4 => array( 'key' => 'general', 'num' => '04', 'title' => 'Contacto general', 'desc' => 'Consultas comerciales, institucionales o de representación.' ),
	);

	$doors = array();
	for ( $i = 1; $i <= 4; $i++ ) {
		$def = $default_doors[ $i ];
		$num = function_exists( 'get_field' ) && $page_id ? get_field( "door{$i}_num", $page_id ) : $def['num'];
		$tit = function_exists( 'get_field' ) && $page_id ? get_field( "door{$i}_title", $page_id ) : $def['title'];
		$dsc = function_exists( 'get_field' ) && $page_id ? get_field( "door{$i}_desc", $page_id ) : $def['desc'];

		$doors[] = array(
			'key'         => $def['key'],
			'num'         => $num ?: $def['num'],
			'title'       => $tit ?: $def['title'],
			'description' => $dsc ?: $def['desc'],
		);
	}

	// 3. Canales & Ubicación
	$addr = function_exists( 'get_field' ) && $page_id ? get_field( 'contacto_address', $page_id ) : 'Av. Vicuña Mackenna 882, Reñaca, Viña del Mar, Chile';
	$brch = function_exists( 'get_field' ) && $page_id ? get_field( 'contacto_branch', $page_id ) : 'Av. Edmundo Eluchans 1737, Of. 61, Reñaca, Viña del Mar';
	$ph_m = function_exists( 'get_field' ) && $page_id ? get_field( 'contacto_phone_main', $page_id ) : '+56 32 2835055';
	$ph_c = function_exists( 'get_field' ) && $page_id ? get_field( 'contacto_phone_mobile', $page_id ) : '+56 9 9876 5432';
	$em_g = function_exists( 'get_field' ) && $page_id ? get_field( 'contacto_email_general', $page_id ) : 'contacto@mitsachile.com';
	$em_s = function_exists( 'get_field' ) && $page_id ? get_field( 'contacto_email_sales', $page_id ) : 'fjdelaiglesia@mitsachile.com';
	$hrs  = function_exists( 'get_field' ) && $page_id ? get_field( 'contacto_hours', $page_id ) : 'Lunes a Viernes: 08:30 a 18:00 hrs';

	$channels = array(
		'address'       => ! empty( $addr ) ? sanitize_text_field( $addr ) : 'Av. Vicuña Mackenna 882, Reñaca, Viña del Mar, Chile',
		'branch'        => ! empty( $brch ) ? sanitize_text_field( $brch ) : 'Av. Edmundo Eluchans 1737, Of. 61, Reñaca, Viña del Mar',
		'phone_main'    => ! empty( $ph_m ) ? sanitize_text_field( $ph_m ) : '+56 32 2835055',
		'phone_mobile'  => ! empty( $ph_c ) ? sanitize_text_field( $ph_c ) : '+56 9 9876 5432',
		'email_general' => ! empty( $em_g ) ? sanitize_email( $em_g ) : 'contacto@mitsachile.com',
		'email_sales'   => ! empty( $em_s ) ? sanitize_email( $em_s ) : 'fjdelaiglesia@mitsachile.com',
		'hours'         => ! empty( $hrs ) ? sanitize_text_field( $hrs ) : 'Lunes a Viernes: 08:30 a 18:00 hrs',
	);

	// 4. Cobertura Regional (8 Países)
	$cov_t = function_exists( 'get_field' ) && $page_id ? get_field( 'contacto_coverage_title', $page_id ) : 'Presencia y Cobertura Regional';
	$cov_d = function_exists( 'get_field' ) && $page_id ? get_field( 'contacto_coverage_desc', $page_id ) : 'Atención comercial y soporte de ingeniería para proyectos marítimos e industriales en 8 países de Latinoamérica.';
	$cov_c = function_exists( 'get_field' ) && $page_id ? get_field( 'contacto_countries', $page_id ) : 'Chile, Perú, Ecuador, Colombia, Panamá, Paraguay, Bolivia, Venezuela';

	$countries_array = array_filter( array_map( 'trim', explode( ',', $cov_c ?: 'Chile, Perú, Ecuador, Colombia, Panamá, Paraguay, Bolivia, Venezuela' ) ) );

	$coverage = array(
		'title'       => ! empty( $cov_t ) ? sanitize_text_field( $cov_t ) : 'Presencia y Cobertura Regional',
		'description' => ! empty( $cov_d ) ? sanitize_textarea_field( $cov_d ) : 'Atención comercial y soporte de ingeniería para proyectos marítimos e industriales en 8 países de Latinoamérica.',
		'countries'   => $countries_array,
	);

	// 5. Formulario
	$f_act = function_exists( 'get_field' ) && $page_id ? get_field( 'contacto_form_action', $page_id ) : 'https://formspree.io/f/placeholder';
	$f_tit = function_exists( 'get_field' ) && $page_id ? get_field( 'contacto_form_title', $page_id ) : 'Formulario de contacto y asesoría técnica';
	$f_dsc = function_exists( 'get_field' ) && $page_id ? get_field( 'contacto_form_desc', $page_id ) : 'Complete los datos requeridos y nuestro equipo técnico le responderá en menos de 24 horas hábiles.';

	$form = array(
		'action_url'  => ! empty( $f_act ) ? esc_url_raw( $f_act ) : 'https://formspree.io/f/placeholder',
		'title'       => ! empty( $f_tit ) ? sanitize_text_field( $f_tit ) : 'Formulario de contacto y asesoría técnica',
		'description' => ! empty( $f_dsc ) ? sanitize_textarea_field( $f_dsc ) : 'Complete los datos requeridos y nuestro equipo técnico le responderá en menos de 24 horas hábiles.',
	);

	// 6. SEO
	$seo_title = function_exists( 'get_field' ) && $page_id ? sanitize_text_field( (string) get_field( 'seo_meta_title', $page_id ) ) : '';
	$seo_desc  = function_exists( 'get_field' ) && $page_id ? sanitize_text_field( (string) get_field( 'seo_meta_description', $page_id ) ) : '';
	$seo_img   = function_exists( 'get_field' ) && $page_id ? esc_url_raw( (string) get_field( 'seo_og_image', $page_id ) ) : '';

	return array(
		'slug'     => 'contacto',
		'title'    => ! empty( $seo_title ) ? $seo_title : 'Contacto & Asesoría Técnica · Canales de Ingeniería y Soporte | MITSA',
		'seo'      => array(
			'meta_title'       => ! empty( $seo_title ) ? $seo_title : 'Contacto & Asesoría Técnica · Canales de Ingeniería y Soporte | MITSA',
			'meta_description' => ! empty( $seo_desc ) ? $seo_desc : 'Canales de contacto especializados de MITSA: evaluación de proyectos, cotización de repuestos originales, servicio técnico a bordo y cobertura regional en 8 países.',
			'canonical_url'    => 'https://mitsachile.com/contacto/',
			'og_image'         => ! empty( $seo_img ) ? $seo_img : 'https://mitsachile.com/images/recursos-img-2-92bb5d09.jpg',
			'og_type'          => 'website',
		),
		'sections' => array(
			'hero'     => $hero,
			'doors'    => $doors,
			'channels' => $channels,
			'coverage' => $coverage,
			'form'     => $form,
		),
	);
}

/**
 * Genera la estructura de datos normalizada para la página Marcas Representadas.
 *
 * @return array
 */
function mitsa_get_representadas_sections_data() {
	$page    = get_page_by_path( 'representadas' );
	$page_id = $page ? (int) $page->ID : 0;

	// 1. Hero
	$h_title = function_exists( 'get_field' ) && $page_id ? get_field( 'representadas_hero_title', $page_id ) : '';
	$h_desc  = function_exists( 'get_field' ) && $page_id ? get_field( 'representadas_hero_desc', $page_id ) : '';
	$h_img   = function_exists( 'get_field' ) && $page_id ? get_field( 'representadas_hero_img', $page_id ) : '';
	$b1_lbl  = function_exists( 'get_field' ) && $page_id ? get_field( 'representadas_btn1_label', $page_id ) : '';
	$b1_url  = function_exists( 'get_field' ) && $page_id ? get_field( 'representadas_btn1_url', $page_id ) : '';
	$b2_lbl  = function_exists( 'get_field' ) && $page_id ? get_field( 'representadas_btn2_label', $page_id ) : '';
	$b2_url  = function_exists( 'get_field' ) && $page_id ? get_field( 'representadas_btn2_url', $page_id ) : '';

	$hero = array(
		'title'            => ! empty( $h_title ) ? sanitize_text_field( $h_title ) : 'Marcas líderes mundiales representadas en Chile y la región.',
		'description'      => ! empty( $h_desc ) ? sanitize_textarea_field( $h_desc ) : 'Ingeniería de aplicación directa con los fabricantes, repuestos originales y certificación oficial de fábrica para sistemas marinos e industriales.',
		'image'            => ! empty( $h_img ) ? esc_url_raw( $h_img ) : '/images/hero-1-8a9d042f.jpg',
		'primary_button'   => array(
			'label' => ! empty( $b1_lbl ) ? sanitize_text_field( $b1_lbl ) : 'Ver representadas',
			'url'   => ! empty( $b1_url ) ? esc_url_raw( $b1_url ) : '#marcas-principales',
		),
		'secondary_button' => array(
			'label' => ! empty( $b2_lbl ) ? sanitize_text_field( $b2_lbl ) : 'Solicitar repuestos',
			'url'   => ! empty( $b2_url ) ? esc_url_raw( $b2_url ) : '/contacto/?tipo=repuestos',
		),
	);

	// 2. Métricas
	$m1_n = function_exists( 'get_field' ) && $page_id ? get_field( 'rep_m1_num', $page_id ) : '14+';
	$m1_l = function_exists( 'get_field' ) && $page_id ? get_field( 'rep_m1_label', $page_id ) : 'marcas internacionales representadas';
	$m2_n = function_exists( 'get_field' ) && $page_id ? get_field( 'rep_m2_num', $page_id ) : '40+';
	$m2_l = function_exists( 'get_field' ) && $page_id ? get_field( 'rep_m2_label', $page_id ) : 'años de alianza con fabricantes líderes';
	$m3_n = function_exists( 'get_field' ) && $page_id ? get_field( 'rep_m3_num', $page_id ) : '100%';
	$m3_l = function_exists( 'get_field' ) && $page_id ? get_field( 'rep_m3_label', $page_id ) : 'soporte y certificación directa de fábrica';

	$metrics = array(
		array( 'num' => $m1_n ?: '14+', 'label' => $m1_l ?: 'marcas internacionales representadas' ),
		array( 'num' => $m2_n ?: '40+', 'label' => $m2_l ?: 'años de alianza con fabricantes líderes' ),
		array( 'num' => $m3_n ?: '100%', 'label' => $m3_l ?: 'soporte y certificación directa de fábrica' ),
	);

	// 3. 6 Marcas Principales
	$default_main = array(
		1 => array( 'name' => 'EVAC', 'country' => 'Finlandia', 'holding' => 'Evac Group', 'category' => 'Aguas y sanitarios', 'desc' => 'Líder mundial en sistemas sanitarios al vacío (Optima), unidades generadoras de vacío (OnlineVac) y biorreactores de membrana biológica (MBR).', 'solutions' => 'Sanitarios al vacío, Biorreactores MBR, Tratamiento de aguas grises y negras', 'img' => '/images/naval-y-defensa-5b2a62fc.jpg' ),
		2 => array( 'name' => 'Cathelco', 'country' => 'Inglaterra', 'holding' => 'Evac Group', 'category' => 'Protección casco & Desalinización', 'desc' => 'Especialista en protección catódica por corriente impresa (ICCP), prevención de bioincrustación (ICAF/MGPS) y plantas desalinizadoras por ósmosis inversa (Seafresh / H2O Mk3).', 'solutions' => 'Protección catódica ICCP, Control biofouling ICAF/MGPS, Ósmosis inversa marina', 'img' => '/images/plataforma-offshore-8886341c.jpg' ),
		3 => array( 'name' => 'ERMA FIRST', 'country' => 'Grecia', 'holding' => 'Erma First Group', 'category' => 'Tratamiento agua de lastre', 'desc' => 'Fabricante referente en sistemas de tratamiento de agua de lastre (BWTS) bajo estándar D-2 de la OMI y homologación USCG, con filtración de 40 micras y desinfección electrolítica.', 'solutions' => 'FIT BWTS, Monitoreo por IA METIS, Cumplimiento OMI D-2 y USCG', 'img' => '/images/transporte-maritimo-3720ea8c.jpg' ),
		4 => array( 'name' => 'EPE', 'country' => 'Grecia', 'holding' => 'EPE Environmental', 'category' => 'Protección ambiental & Fisicoquímico', 'desc' => 'Más de 45 años en protección ambiental marina: plantas fisicoquímicas de aguas residuales Triton FIT (certificación DNV/MEPC.227) y equipos de contingencia.', 'solutions' => 'Triton FIT 3.0 / 6.0, Plantas fisicoquímicas, Separadores de sentina', 'img' => '/images/astilleros-y-diques-0e241764.jpg' ),
		5 => array( 'name' => 'BLÜCHER', 'country' => 'Dinamarca', 'holding' => 'Watts Water', 'category' => 'Drenajes & Cañerías inoxidables', 'desc' => 'Sistemas de drenaje de alta resistencia, canaletas, sumideros y tuberías push-fit en acero inoxidable AISI 316L para buques, plantas de alimentos e industrias.', 'solutions' => 'Tuberías EuroPipe AISI 316L, Drenajes marinos, Canales industriales', 'img' => '/images/acuicultura-y-pesca-6ece81b5.jpg' ),
		6 => array( 'name' => 'Uson Marine', 'country' => 'Suecia', 'holding' => 'Evac Group', 'category' => 'Gestión de residuos a bordo', 'desc' => 'Sistemas integrales para compactación, trituración y almacenamiento higiénico de residuos sólidos y orgánicos a bordo de buques y plataformas.', 'solutions' => 'Compactadores marinos, Trituradores orgánicos, Gestión de residuos', 'img' => '/images/instalaciones-en-tie-f9537988.jpg' ),
	);

	$main_brands = array();
	for ( $i = 1; $i <= 6; $i++ ) {
		$def = $default_main[ $i ];
		$nm  = function_exists( 'get_field' ) && $page_id ? get_field( "bmain{$i}_name", $page_id ) : $def['name'];
		$co  = function_exists( 'get_field' ) && $page_id ? get_field( "bmain{$i}_country", $page_id ) : $def['country'];
		$hd  = function_exists( 'get_field' ) && $page_id ? get_field( "bmain{$i}_holding", $page_id ) : $def['holding'];
		$ct  = function_exists( 'get_field' ) && $page_id ? get_field( "bmain{$i}_category", $page_id ) : $def['category'];
		$ds  = function_exists( 'get_field' ) && $page_id ? get_field( "bmain{$i}_desc", $page_id ) : $def['desc'];
		$sl  = function_exists( 'get_field' ) && $page_id ? get_field( "bmain{$i}_solutions", $page_id ) : $def['solutions'];
		$im  = function_exists( 'get_field' ) && $page_id ? get_field( "bmain{$i}_image", $page_id ) : $def['img'];

		$solutions_array = array_filter( array_map( 'trim', explode( ',', $sl ?: $def['solutions'] ) ) );

		$main_brands[] = array(
			'name'        => $nm ?: $def['name'],
			'country'     => $co ?: $def['country'],
			'holding'     => $hd ?: $def['holding'],
			'category'    => $ct ?: $def['category'],
			'description' => $ds ?: $def['desc'],
			'solutions'   => $solutions_array,
			'image'       => $im ?: $def['img'],
			'consult_url' => '/contacto/?tipo=repuestos&marca=' . sanitize_title( $nm ?: $def['name'] ),
		);
	}

	// 4. Directorio Complementario (8 Marcas)
	$default_dir = array(
		1 => array( 'name' => 'Herborner Pumpen', 'country' => 'Alemania', 'cat' => 'Bombas y fluidos', 'desc' => 'Bombas marinas centrífugas con recubrimiento cerámico resistente a la corrosión.' ),
		2 => array( 'name' => 'SIHI', 'country' => 'Alemania', 'cat' => 'Bombas y vacío', 'desc' => 'Bombas de vacío de anillo líquido y sistemas de bombeo de procesos industriales.' ),
		3 => array( 'name' => 'Harwil', 'country' => 'USA', 'cat' => 'Instrumentación', 'desc' => 'Interruptores de flujo y sensores de nivel para automatización y control de bombas.' ),
		4 => array( 'name' => 'Moyno', 'country' => 'USA', 'cat' => 'Bombas y fluidos', 'desc' => 'Bombas de cavidad progresiva para lodos, fluidos viscosos y efluentes marinos.' ),
		5 => array( 'name' => 'Burks Pumps', 'country' => 'USA', 'cat' => 'Bombas industriales', 'desc' => 'Bombas centrífugas y turbinas regenerativas para alta presión y servicios auxiliares.' ),
		6 => array( 'name' => 'FCI Watermaker', 'country' => 'USA', 'cat' => 'Desalinización', 'desc' => 'Plantas desalinizadoras automáticas por ósmosis inversa para embarcaciones.' ),
		7 => array( 'name' => 'Planus', 'country' => 'Italia', 'cat' => 'Aguas y sanitarios', 'desc' => 'Sanitarios marinos integrados y sistemas de bombeo de maceración.' ),
		8 => array( 'name' => 'Terminator', 'country' => 'Chile', 'cat' => 'Confort & Residuos', 'desc' => 'Equipos compactadores y trituradores de residuos para faenas en tierra y mar.' ),
	);

	$directory = array();
	for ( $i = 1; $i <= 8; $i++ ) {
		$def = $default_dir[ $i ];
		$nm  = function_exists( 'get_field' ) && $page_id ? get_field( "dir{$i}_name", $page_id ) : $def['name'];
		$co  = function_exists( 'get_field' ) && $page_id ? get_field( "dir{$i}_country", $page_id ) : $def['country'];
		$ct  = function_exists( 'get_field' ) && $page_id ? get_field( "dir{$i}_cat", $page_id ) : $def['cat'];
		$ds  = function_exists( 'get_field' ) && $page_id ? get_field( "dir{$i}_desc", $page_id ) : $def['desc'];

		$directory[] = array(
			'name'        => $nm ?: $def['name'],
			'country'     => $co ?: $def['country'],
			'category'    => $ct ?: $def['cat'],
			'description' => $ds ?: $def['desc'],
		);
	}

	// 5. CTA
	$c_hd  = function_exists( 'get_field' ) && $page_id ? get_field( 'representadas_cta_heading', $page_id ) : '';
	$c_ds  = function_exists( 'get_field' ) && $page_id ? get_field( 'representadas_cta_desc', $page_id ) : '';
	$c_lbl = function_exists( 'get_field' ) && $page_id ? get_field( 'representadas_cta_btn_label', $page_id ) : '';
	$c_url = function_exists( 'get_field' ) && $page_id ? get_field( 'representadas_cta_btn_url', $page_id ) : '';

	$cta = array(
		'heading'     => ! empty( $c_hd ) ? sanitize_text_field( $c_hd ) : '¿Requiere asesoría directa o repuestos de nuestras representadas?',
		'description' => ! empty( $c_ds ) ? sanitize_textarea_field( $c_ds ) : 'Como representantes oficiales, contamos con acceso directo a ingeniería de fábrica, números de parte originales y tiempos prioritarios de entrega.',
		'button'      => array(
			'label' => ! empty( $c_lbl ) ? sanitize_text_field( $c_lbl ) : 'Contactar a un especialista de marca',
			'url'   => ! empty( $c_url ) ? esc_url_raw( $c_url ) : '/contacto/?tipo=repuestos',
		),
	);

	// 6. SEO
	$seo_title = function_exists( 'get_field' ) && $page_id ? sanitize_text_field( (string) get_field( 'seo_meta_title', $page_id ) ) : '';
	$seo_desc  = function_exists( 'get_field' ) && $page_id ? sanitize_text_field( (string) get_field( 'seo_meta_description', $page_id ) ) : '';
	$seo_img   = function_exists( 'get_field' ) && $page_id ? esc_url_raw( (string) get_field( 'seo_og_image', $page_id ) ) : '';

	return array(
		'slug'     => 'representadas',
		'title'    => ! empty( $seo_title ) ? $seo_title : 'Marcas Representadas Oficiales · Tecnologías Marinas y Sanitarias | MITSA',
		'seo'      => array(
			'meta_title'       => ! empty( $seo_title ) ? $seo_title : 'Marcas Representadas Oficiales · Tecnologías Marinas y Sanitarias | MITSA',
			'meta_description' => ! empty( $seo_desc ) ? $seo_desc : 'Representación oficial en Chile y Latinoamérica: EVAC, Cathelco, ERMA FIRST, EPE, BLÜCHER y fabricantes líderes mundiales.',
			'canonical_url'    => 'https://mitsachile.com/representadas/',
			'og_image'         => ! empty( $seo_img ) ? $seo_img : 'https://mitsachile.com/images/hero-1-8a9d042f.jpg',
			'og_type'          => 'website',
		),
		'sections' => array(
			'hero'        => $hero,
			'metrics'     => $metrics,
			'main_brands' => $main_brands,
			'directory'   => $directory,
			'cta'         => $cta,
		),
	);
}

/**
 * Genera la estructura de datos genérica para páginas estándar de WordPress.
 *
 * @param WP_Post $page Objeto de página de WordPress.
 * @return array
 */
function mitsa_get_generic_page_sections_data( WP_Post $page ) {
	$page_id = $page->ID;

	$seo_title = function_exists( 'get_field' ) ? sanitize_text_field( (string) get_field( 'seo_meta_title', $page_id ) ) : '';
	$seo_desc  = function_exists( 'get_field' ) ? sanitize_text_field( (string) get_field( 'seo_meta_description', $page_id ) ) : '';
	$seo_img   = function_exists( 'get_field' ) ? esc_url_raw( (string) get_field( 'seo_og_image', $page_id ) ) : '';

	return array(
		'slug'     => $page->post_name,
		'title'    => get_the_title( $page_id ),
		'content'  => apply_filters( 'the_content', $page->post_content ),
		'seo'      => array(
			'meta_title'       => ! empty( $seo_title ) ? $seo_title : get_the_title( $page_id ) . ' · MITSA',
			'meta_description' => ! empty( $seo_desc ) ? $seo_desc : wp_strip_all_tags( $page->post_content ),
			'canonical_url'    => get_permalink( $page_id ),
			'og_image'         => ! empty( $seo_img ) ? $seo_img : 'https://mitsachile.com/images/plataforma-offshore-8886341c.jpg',
			'og_type'          => 'article',
		),
		'sections' => array(),
	);
}
