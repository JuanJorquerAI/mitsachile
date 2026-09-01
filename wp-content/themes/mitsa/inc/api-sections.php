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
}
add_action( 'rest_api_init', 'mitsa_register_rest_routes' );

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
	$seo_title = function_exists( 'get_field' ) && $page_id ? get_field( 'seo_meta_title', $page_id ) : '';
	$seo_desc  = function_exists( 'get_field' ) && $page_id ? get_field( 'seo_meta_description', $page_id ) : '';
	$seo_img   = function_exists( 'get_field' ) && $page_id ? get_field( 'seo_og_image', $page_id ) : '';

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
 * Genera la estructura de datos genérica para páginas estándar de WordPress.
 *
 * @param WP_Post $page Objeto de página de WordPress.
 * @return array
 */
function mitsa_get_generic_page_sections_data( WP_Post $page ) {
	$page_id = $page->ID;

	$seo_title = function_exists( 'get_field' ) ? get_field( 'seo_meta_title', $page_id ) : '';
	$seo_desc  = function_exists( 'get_field' ) ? get_field( 'seo_meta_description', $page_id ) : '';
	$seo_img   = function_exists( 'get_field' ) ? get_field( 'seo_og_image', $page_id ) : '';

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
