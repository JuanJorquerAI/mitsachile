<?php
/**
 * Definición local de campos ACF (Advanced Custom Fields) para el tema MITSA.
 *
 * Registra un panel unificado con pestañas (ACF Tabs) 100% compatible con ACF Free y Pro,
 * con la interfaz visual característica de ACF, sin acordeones dispersos.
 *
 * @package mitsa
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registra los grupos de campos locales para las secciones de la Home y páginas.
 */
function mitsa_register_acf_field_groups() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	// Grupo Maestro Unificado: Administración de la Página de Inicio (Home) con Pestañas ACF
	acf_add_local_field_group(
		array(
			'key'                   => 'group_mitsa_home_master',
			'title'                 => __( 'Administración de Página de Inicio (MITSA)', 'mitsa' ),
			'fields'                => array(

				// ==========================================
				// PESTAÑA 1: HERO & TRIAJE
				// ==========================================
				array(
					'key'       => 'tab_mitsa_hero',
					'label'     => __( '🚀 Hero & Triaje', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_mitsa_hero_title_prefix',
					'label'         => __( 'Prefijo del Título Principal (H1)', 'mitsa' ),
					'name'          => 'hero_title_prefix',
					'type'          => 'text',
					'default_value' => 'Toda su ingeniería resuelta, del proyecto a la operación:',
					'required'      => 1,
				),
				array(
					'key'           => 'field_mitsa_hero_rotating_words',
					'label'         => __( 'Palabras Rotativas Animadas', 'mitsa' ),
					'name'          => 'hero_rotating_words',
					'type'          => 'textarea',
					'instructions'  => __( 'Ingrese una palabra o frase por línea (se alternan automáticamente).', 'mitsa' ),
					'default_value' => "sanitaria\nde tratamiento\nde protección\nde agua dulce",
					'rows'          => 4,
					'required'      => 1,
				),
				array(
					'key'           => 'field_mitsa_hero_description',
					'label'         => __( 'Descripción / Bajada de Hero', 'mitsa' ),
					'name'          => 'hero_description',
					'type'          => 'textarea',
					'default_value' => 'Ingeniería de aplicación, suministro, retrofit, puesta en marcha y soporte. Cinco fabricantes representados de forma directa, cuarenta años de proyectos en Chile y Latinoamérica.',
					'rows'          => 3,
					'required'      => 1,
				),
				array(
					'key'           => 'field_mitsa_triage_title',
					'label'         => __( 'Título de Caja de Triaje', 'mitsa' ),
					'name'          => 'triage_title',
					'type'          => 'text',
					'default_value' => '¿Qué necesita resolver?',
				),
				// Triaje Opción 1
				array(
					'key'           => 'field_mitsa_triage_opt1_label',
					'label'         => __( 'Triaje: Botón 1 (Etiqueta)', 'mitsa' ),
					'name'          => 'triage_opt1_label',
					'type'          => 'text',
					'default_value' => 'Evaluación técnica',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_triage_opt1_url',
					'label'         => __( 'Triaje: Botón 1 (URL)', 'mitsa' ),
					'name'          => 'triage_opt1_url',
					'type'          => 'text',
					'default_value' => '/contacto/?tipo=evaluacion',
					'wrapper'       => array( 'width' => '50' ),
				),
				// Triaje Opción 2
				array(
					'key'           => 'field_mitsa_triage_opt2_label',
					'label'         => __( 'Triaje: Botón 2 (Etiqueta)', 'mitsa' ),
					'name'          => 'triage_opt2_label',
					'type'          => 'text',
					'default_value' => 'Repuestos',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_triage_opt2_url',
					'label'         => __( 'Triaje: Botón 2 (URL)', 'mitsa' ),
					'name'          => 'triage_opt2_url',
					'type'          => 'text',
					'default_value' => '/contacto/?tipo=repuestos',
					'wrapper'       => array( 'width' => '50' ),
				),
				// Triaje Opción 3
				array(
					'key'           => 'field_mitsa_triage_opt3_label',
					'label'         => __( 'Triaje: Botón 3 (Etiqueta)', 'mitsa' ),
					'name'          => 'triage_opt3_label',
					'type'          => 'text',
					'default_value' => 'Servicio técnico',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_triage_opt3_url',
					'label'         => __( 'Triaje: Botón 3 (URL)', 'mitsa' ),
					'name'          => 'triage_opt3_url',
					'type'          => 'text',
					'default_value' => '/contacto/?tipo=servicio',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_triage_placeholder',
					'label'         => __( 'Placeholder del Buscador', 'mitsa' ),
					'name'          => 'triage_placeholder',
					'type'          => 'text',
					'default_value' => 'Describa su proyecto o nave...',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_triage_action_url',
					'label'         => __( 'URL Acción de Formulario', 'mitsa' ),
					'name'          => 'triage_action_url',
					'type'          => 'text',
					'default_value' => '/contacto/',
					'wrapper'       => array( 'width' => '50' ),
				),

				// ==========================================
				// PESTAÑA 2: GRID VISUAL DE PROYECTOS
				// ==========================================
				array(
					'key'       => 'tab_mitsa_projects',
					'label'     => __( '🚢 Proyectos (4 Tarjetas)', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				// Tarjeta 1
				array(
					'key'           => 'field_mitsa_vcard1_title',
					'label'         => __( 'Proyecto 1: Título', 'mitsa' ),
					'name'          => 'vcard1_title',
					'type'          => 'text',
					'default_value' => 'Fragata FF-18 · ICCP',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_vcard1_alt',
					'label'         => __( 'Proyecto 1: Alt Text Accesible', 'mitsa' ),
					'name'          => 'vcard1_alt',
					'type'          => 'text',
					'default_value' => 'Protección catódica por corriente impresa ICCP en Fragata FF-18',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_vcard1_image',
					'label'         => __( 'Proyecto 1: Foto', 'mitsa' ),
					'name'          => 'vcard1_image',
					'type'          => 'image',
					'return_format' => 'url',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_vcard1_loading',
					'label'         => __( 'Proyecto 1: Carga LCP', 'mitsa' ),
					'name'          => 'vcard1_loading',
					'type'          => 'select',
					'choices'       => array( 'eager' => 'Eager (Prioritaria / LCP)', 'lazy' => 'Lazy (Carga diferida)' ),
					'default_value' => 'eager',
					'wrapper'       => array( 'width' => '50' ),
				),

				// Tarjeta 2
				array(
					'key'           => 'field_mitsa_vcard2_title',
					'label'         => __( 'Proyecto 2: Título', 'mitsa' ),
					'name'          => 'vcard2_title',
					'type'          => 'text',
					'default_value' => 'OPV Cabo Odger · Sanitarios',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_vcard2_alt',
					'label'         => __( 'Proyecto 2: Alt Text Accesible', 'mitsa' ),
					'name'          => 'vcard2_alt',
					'type'          => 'text',
					'default_value' => 'Sistemas sanitarios al vacío EVAC en buque patrullero OPV Cabo Odger',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_vcard2_image',
					'label'         => __( 'Proyecto 2: Foto', 'mitsa' ),
					'name'          => 'vcard2_image',
					'type'          => 'image',
					'return_format' => 'url',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_vcard2_loading',
					'label'         => __( 'Proyecto 2: Carga LCP', 'mitsa' ),
					'name'          => 'vcard2_loading',
					'type'          => 'select',
					'choices'       => array( 'eager' => 'Eager (Prioritaria / LCP)', 'lazy' => 'Lazy (Carga diferida)' ),
					'default_value' => 'eager',
					'wrapper'       => array( 'width' => '50' ),
				),

				// Tarjeta 3
				array(
					'key'           => 'field_mitsa_vcard3_title',
					'label'         => __( 'Proyecto 3: Título', 'mitsa' ),
					'name'          => 'vcard3_title',
					'type'          => 'text',
					'default_value' => 'Magellan Discovery · Agua caliente',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_vcard3_alt',
					'label'         => __( 'Proyecto 3: Alt Text Accesible', 'mitsa' ),
					'name'          => 'vcard3_alt',
					'type'          => 'text',
					'default_value' => 'Sistemas de generación y distribución de agua caliente a bordo',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_vcard3_image',
					'label'         => __( 'Proyecto 3: Foto', 'mitsa' ),
					'name'          => 'vcard3_image',
					'type'          => 'image',
					'return_format' => 'url',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_vcard3_loading',
					'label'         => __( 'Proyecto 3: Carga LCP', 'mitsa' ),
					'name'          => 'vcard3_loading',
					'type'          => 'select',
					'choices'       => array( 'eager' => 'Eager (Prioritaria / LCP)', 'lazy' => 'Lazy (Carga diferida)' ),
					'default_value' => 'lazy',
					'wrapper'       => array( 'width' => '50' ),
				),

				// Tarjeta 4
				array(
					'key'           => 'field_mitsa_vcard4_title',
					'label'         => __( 'Proyecto 4: Título', 'mitsa' ),
					'name'          => 'vcard4_title',
					'type'          => 'text',
					'default_value' => 'Wellboat · BWTS',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_vcard4_alt',
					'label'         => __( 'Proyecto 4: Alt Text Accesible', 'mitsa' ),
					'name'          => 'vcard4_alt',
					'type'          => 'text',
					'default_value' => 'Tratamiento de agua de lastre BWTS ERMA FIRST en wellboat',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_vcard4_image',
					'label'         => __( 'Proyecto 4: Foto', 'mitsa' ),
					'name'          => 'vcard4_image',
					'type'          => 'image',
					'return_format' => 'url',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_vcard4_loading',
					'label'         => __( 'Proyecto 4: Carga LCP', 'mitsa' ),
					'name'          => 'vcard4_loading',
					'type'          => 'select',
					'choices'       => array( 'eager' => 'Eager (Prioritaria / LCP)', 'lazy' => 'Lazy (Carga diferida)' ),
					'default_value' => 'lazy',
					'wrapper'       => array( 'width' => '50' ),
				),

				// ==========================================
				// PESTAÑA 3: OBJECIONES & RESOLUCIONES
				// ==========================================
				array(
					'key'       => 'tab_mitsa_pain_points',
					'label'     => __( '💬 Objeciones & Resoluciones', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_mitsa_pp_heading',
					'label'         => __( 'Título de la Sección (H2)', 'mitsa' ),
					'name'          => 'pain_points_heading',
					'type'          => 'text',
					'default_value' => 'Resolvemos lo que frena un proyecto naval',
				),
				array(
					'key'           => 'field_mitsa_pp_quote',
					'label'         => __( 'Cita / Testimonio de Objeción', 'mitsa' ),
					'name'          => 'pain_points_quote',
					'type'          => 'textarea',
					'default_value' => '«Nos ofrecen el equipo, pero nadie se hace cargo de la puesta en marcha ni de los repuestos tres años después.»',
				),
				array(
					'key'           => 'field_mitsa_pp_author_initials',
					'label'         => __( 'Iniciales del Autor', 'mitsa' ),
					'name'          => 'pain_points_author_initials',
					'type'          => 'text',
					'default_value' => 'JP',
					'wrapper'       => array( 'width' => '33' ),
				),
				array(
					'key'           => 'field_mitsa_pp_author_role',
					'label'         => __( 'Cargo / Industria', 'mitsa' ),
					'name'          => 'pain_points_author_role',
					'type'          => 'text',
					'default_value' => 'Jefe de Proyecto · Astillero Naval',
					'wrapper'       => array( 'width' => '33' ),
				),
				array(
					'key'           => 'field_mitsa_pp_author_note',
					'label'         => __( 'Nota de Contexto', 'mitsa' ),
					'name'          => 'pain_points_author_note',
					'type'          => 'text',
					'default_value' => 'Caso representativo de la industria',
					'wrapper'       => array( 'width' => '34' ),
				),
				array(
					'key'           => 'field_mitsa_pp_resolutions',
					'label'         => __( 'Puntos de Resolución (1 por línea con checklist)', 'mitsa' ),
					'name'          => 'pain_points_resolutions',
					'type'          => 'textarea',
					'default_value' => "Especificaciones que calzan exactamente con la normativa aplicable\nIngeniería de aplicación y dimensionamiento previo a la compra\nTrazabilidad de repuestos originales por número de parte oficial\nPuesta en marcha y comisionamiento ejecutado en terreno en Chile\nAlcance contractual y técnico claro entre astillero, armador y MITSA",
					'rows'          => 5,
				),

				// ==========================================
				// PESTAÑA 4: MÉTRICAS DE AUTORIDAD
				// ==========================================
				array(
					'key'       => 'tab_mitsa_metrics',
					'label'     => __( '📊 Métricas de Autoridad', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				// Métrica 1
				array(
					'key'           => 'field_mitsa_metric1_val',
					'label'         => __( 'Métrica 1: Cifra', 'mitsa' ),
					'name'          => 'metric1_val',
					'type'          => 'text',
					'default_value' => '40+',
					'wrapper'       => array( 'width' => '30' ),
				),
				array(
					'key'           => 'field_mitsa_metric1_lbl',
					'label'         => __( 'Métrica 1: Etiqueta', 'mitsa' ),
					'name'          => 'metric1_lbl',
					'type'          => 'text',
					'default_value' => 'años integrando soluciones marítimas y ambientales en Chile',
					'wrapper'       => array( 'width' => '70' ),
				),
				// Métrica 2
				array(
					'key'           => 'field_mitsa_metric2_val',
					'label'         => __( 'Métrica 2: Cifra', 'mitsa' ),
					'name'          => 'metric2_val',
					'type'          => 'text',
					'default_value' => '5',
					'wrapper'       => array( 'width' => '30' ),
				),
				array(
					'key'           => 'field_mitsa_metric2_lbl',
					'label'         => __( 'Métrica 2: Etiqueta', 'mitsa' ),
					'name'          => 'metric2_lbl',
					'type'          => 'text',
					'default_value' => 'fabricantes representados de forma directa y oficial',
					'wrapper'       => array( 'width' => '70' ),
				),
				// Métrica 3
				array(
					'key'           => 'field_mitsa_metric3_val',
					'label'         => __( 'Métrica 3: Cifra', 'mitsa' ),
					'name'          => 'metric3_val',
					'type'          => 'text',
					'default_value' => '100%',
					'wrapper'       => array( 'width' => '30' ),
				),
				array(
					'key'           => 'field_mitsa_metric3_lbl',
					'label'         => __( 'Métrica 3: Etiqueta', 'mitsa' ),
					'name'          => 'metric3_lbl',
					'type'          => 'text',
					'default_value' => 'cobertura nacional con ingenieros especialistas en terreno',
					'wrapper'       => array( 'width' => '70' ),
				),

				// ==========================================
				// PESTAÑA 5: MARCAS REPRESENTADAS
				// ==========================================
				array(
					'key'       => 'tab_mitsa_brands',
					'label'     => __( '🏷️ Marcas Representadas', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_mitsa_brands_heading',
					'label'         => __( 'Título de la Sección (H2)', 'mitsa' ),
					'name'          => 'brands_heading',
					'type'          => 'text',
					'default_value' => 'Quién está detrás de cada solución',
				),
				// Marca 1
				array(
					'key'           => 'field_mitsa_b1_name',
					'label'         => __( 'Marca 1: Nombre', 'mitsa' ),
					'name'          => 'b1_name',
					'type'          => 'text',
					'default_value' => 'EVAC',
					'wrapper'       => array( 'width' => '30' ),
				),
				array(
					'key'           => 'field_mitsa_b1_tagline',
					'label'         => __( 'Marca 1: Tagline', 'mitsa' ),
					'name'          => 'b1_tagline',
					'type'          => 'text',
					'default_value' => 'Sanitarios al vacío',
					'wrapper'       => array( 'width' => '30' ),
				),
				array(
					'key'           => 'field_mitsa_b1_desc',
					'label'         => __( 'Marca 1: Descripción', 'mitsa' ),
					'name'          => 'b1_desc',
					'type'          => 'text',
					'default_value' => 'Tratamiento de aguas residuales y gestión de residuos a bordo.',
					'wrapper'       => array( 'width' => '40' ),
				),
				// Marca 2
				array(
					'key'           => 'field_mitsa_b2_name',
					'label'         => __( 'Marca 2: Nombre', 'mitsa' ),
					'name'          => 'b2_name',
					'type'          => 'text',
					'default_value' => 'Cathelco',
					'wrapper'       => array( 'width' => '30' ),
				),
				array(
					'key'           => 'field_mitsa_b2_tagline',
					'label'         => __( 'Marca 2: Tagline', 'mitsa' ),
					'name'          => 'b2_tagline',
					'type'          => 'text',
					'default_value' => 'ICCP & ICAF',
					'wrapper'       => array( 'width' => '30' ),
				),
				array(
					'key'           => 'field_mitsa_b2_desc',
					'label'         => __( 'Marca 2: Descripción', 'mitsa' ),
					'name'          => 'b2_desc',
					'type'          => 'text',
					'default_value' => 'Protección catódica por corriente impresa y prevención de bioincrustaciones.',
					'wrapper'       => array( 'width' => '40' ),
				),
				// Marca 3
				array(
					'key'           => 'field_mitsa_b3_name',
					'label'         => __( 'Marca 3: Nombre', 'mitsa' ),
					'name'          => 'b3_name',
					'type'          => 'text',
					'default_value' => 'ERMA FIRST',
					'wrapper'       => array( 'width' => '30' ),
				),
				array(
					'key'           => 'field_mitsa_b3_tagline',
					'label'         => __( 'Marca 3: Tagline', 'mitsa' ),
					'name'          => 'b3_tagline',
					'type'          => 'text',
					'default_value' => 'Agua de lastre (BWTS)',
					'wrapper'       => array( 'width' => '30' ),
				),
				array(
					'key'           => 'field_mitsa_b3_desc',
					'label'         => __( 'Marca 3: Descripción', 'mitsa' ),
					'name'          => 'b3_desc',
					'type'          => 'text',
					'default_value' => 'Sistemas certificados D-2 con tecnología de electrólisis y filtración.',
					'wrapper'       => array( 'width' => '40' ),
				),
				// Marca 4
				array(
					'key'           => 'field_mitsa_b4_name',
					'label'         => __( 'Marca 4: Nombre', 'mitsa' ),
					'name'          => 'b4_name',
					'type'          => 'text',
					'default_value' => 'EPE',
					'wrapper'       => array( 'width' => '30' ),
				),
				array(
					'key'           => 'field_mitsa_b4_tagline',
					'label'         => __( 'Marca 4: Tagline', 'mitsa' ),
					'name'          => 'b4_tagline',
					'type'          => 'text',
					'default_value' => 'Tratamiento de efluentes',
					'wrapper'       => array( 'width' => '30' ),
				),
				array(
					'key'           => 'field_mitsa_b4_desc',
					'label'         => __( 'Marca 4: Descripción', 'mitsa' ),
					'name'          => 'b4_desc',
					'type'          => 'text',
					'default_value' => 'Plantas de tratamiento y separadores marinos de sentinas.',
					'wrapper'       => array( 'width' => '40' ),
				),
				// Marca 5
				array(
					'key'           => 'field_mitsa_b5_name',
					'label'         => __( 'Marca 5: Nombre', 'mitsa' ),
					'name'          => 'b5_name',
					'type'          => 'text',
					'default_value' => 'BLÜCHER',
					'wrapper'       => array( 'width' => '30' ),
				),
				array(
					'key'           => 'field_mitsa_b5_tagline',
					'label'         => __( 'Marca 5: Tagline', 'mitsa' ),
					'name'          => 'b5_tagline',
					'type'          => 'text',
					'default_value' => 'Drenajes inoxidables',
					'wrapper'       => array( 'width' => '30' ),
				),
				array(
					'key'           => 'field_mitsa_b5_desc',
					'label'         => __( 'Marca 5: Descripción', 'mitsa' ),
					'name'          => 'b5_desc',
					'type'          => 'text',
					'default_value' => 'Sistemas de evacuación y tuberías de acero inoxidable AISI 316L.',
					'wrapper'       => array( 'width' => '40' ),
				),

				// ==========================================
				// PESTAÑA 6: SOLUCIONES TECNOLÓGICAS (8)
				// ==========================================
				array(
					'key'       => 'tab_mitsa_solutions',
					'label'     => __( '⚙️ Soluciones (8)', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_mitsa_solutions_heading',
					'label'         => __( 'Título de la Sección (H2)', 'mitsa' ),
					'name'          => 'solutions_heading',
					'type'          => 'text',
					'default_value' => 'Soluciones tecnológicas especializadas',
				),
				array(
					'key'           => 'field_mitsa_solutions_subheading',
					'label'         => __( 'Subtítulo / Bajada', 'mitsa' ),
					'name'          => 'solutions_subheading',
					'type'          => 'textarea',
					'default_value' => 'Sistemas marinos y terrestres integrados con ingeniería de aplicación, comisionamiento y respaldo técnico en terreno.',
					'rows'          => 2,
				),
				// Sol 1
				array(
					'key' => 'field_mitsa_sol1_title', 'label' => __( 'Solución 1: Título', 'mitsa' ), 'name' => 'sol1_title', 'type' => 'text', 'default_value' => 'Sanitarios al vacío', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_mitsa_sol1_brand', 'label' => __( 'Solución 1: Marca', 'mitsa' ), 'name' => 'sol1_brand', 'type' => 'text', 'default_value' => 'EVAC', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_sol1_desc', 'label' => __( 'Solución 1: Descripción', 'mitsa' ), 'name' => 'sol1_desc', 'type' => 'text', 'default_value' => 'Sistemas sanitarios marinos y terrestres de alta eficiencia con ahorro de agua.', 'wrapper' => array( 'width' => '50' ),
				),
				// Sol 2
				array(
					'key' => 'field_mitsa_sol2_title', 'label' => __( 'Solución 2: Título', 'mitsa' ), 'name' => 'sol2_title', 'type' => 'text', 'default_value' => 'Aguas residuales', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_mitsa_sol2_brand', 'label' => __( 'Solución 2: Marca', 'mitsa' ), 'name' => 'sol2_brand', 'type' => 'text', 'default_value' => 'EVAC · EPE', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_sol2_desc', 'label' => __( 'Solución 2: Descripción', 'mitsa' ), 'name' => 'sol2_desc', 'type' => 'text', 'default_value' => 'Plantas de tratamiento biológico y físico-químico según normativa MARPOL Anexo IV.', 'wrapper' => array( 'width' => '50' ),
				),
				// Sol 3
				array(
					'key' => 'field_mitsa_sol3_title', 'label' => __( 'Solución 3: Título', 'mitsa' ), 'name' => 'sol3_title', 'type' => 'text', 'default_value' => 'Agua de lastre (BWTS)', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_mitsa_sol3_brand', 'label' => __( 'Solución 3: Marca', 'mitsa' ), 'name' => 'sol3_brand', 'type' => 'text', 'default_value' => 'ERMA FIRST', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_sol3_desc', 'label' => __( 'Solución 3: Descripción', 'mitsa' ), 'name' => 'sol3_desc', 'type' => 'text', 'default_value' => 'Sistemas de tratamiento de agua de lastre bajo estándar D-2 de la OMI.', 'wrapper' => array( 'width' => '50' ),
				),
				// Sol 4
				array(
					'key' => 'field_mitsa_sol4_title', 'label' => __( 'Solución 4: Título', 'mitsa' ), 'name' => 'sol4_title', 'type' => 'text', 'default_value' => 'Corrosión (ICCP)', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_mitsa_sol4_brand', 'label' => __( 'Solución 4: Marca', 'mitsa' ), 'name' => 'sol4_brand', 'type' => 'text', 'default_value' => 'Cathelco', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_sol4_desc', 'label' => __( 'Solución 4: Descripción', 'mitsa' ), 'name' => 'sol4_desc', 'type' => 'text', 'default_value' => 'Protección catódica por corriente impresa para cascos de buques e instalaciones.', 'wrapper' => array( 'width' => '50' ),
				),
				// Sol 5
				array(
					'key' => 'field_mitsa_sol5_title', 'label' => __( 'Solución 5: Título', 'mitsa' ), 'name' => 'sol5_title', 'type' => 'text', 'default_value' => 'Bioincrustaciones (ICAF)', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_mitsa_sol5_brand', 'label' => __( 'Solución 5: Marca', 'mitsa' ), 'name' => 'sol5_brand', 'type' => 'text', 'default_value' => 'Cathelco', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_sol5_desc', 'label' => __( 'Solución 5: Descripción', 'mitsa' ), 'name' => 'sol5_desc', 'type' => 'text', 'default_value' => 'Sistemas anti-incrustaciones para tomas de mar y circuitos de refrigeración.', 'wrapper' => array( 'width' => '50' ),
				),
				// Sol 6
				array(
					'key' => 'field_mitsa_sol6_title', 'label' => __( 'Solución 6: Título', 'mitsa' ), 'name' => 'sol6_title', 'type' => 'text', 'default_value' => 'Generación de agua dulce', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_mitsa_sol6_brand', 'label' => __( 'Solución 6: Marca', 'mitsa' ), 'name' => 'sol6_brand', 'type' => 'text', 'default_value' => 'Representadas oficiales', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_sol6_desc', 'label' => __( 'Solución 6: Descripción', 'mitsa' ), 'name' => 'sol6_desc', 'type' => 'text', 'default_value' => 'Plantas desalinizadoras por ósmosis inversa y evaporadores marinos.', 'wrapper' => array( 'width' => '50' ),
				),
				// Sol 7
				array(
					'key' => 'field_mitsa_sol7_title', 'label' => __( 'Solución 7: Título', 'mitsa' ), 'name' => 'sol7_title', 'type' => 'text', 'default_value' => 'Sistemas de agua caliente', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_mitsa_sol7_brand', 'label' => __( 'Solución 7: Marca', 'mitsa' ), 'name' => 'sol7_brand', 'type' => 'text', 'default_value' => 'Ingeniería MITSA', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_sol7_desc', 'label' => __( 'Solución 7: Descripción', 'mitsa' ), 'name' => 'sol7_desc', 'type' => 'text', 'default_value' => 'Calderas, intercambiadores y acumuladores para habitabilidad a bordo.', 'wrapper' => array( 'width' => '50' ),
				),
				// Sol 8
				array(
					'key' => 'field_mitsa_sol8_title', 'label' => __( 'Solución 8: Título', 'mitsa' ), 'name' => 'sol8_title', 'type' => 'text', 'default_value' => 'Drenajes inoxidables', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_mitsa_sol8_brand', 'label' => __( 'Solución 8: Marca', 'mitsa' ), 'name' => 'sol8_brand', 'type' => 'text', 'default_value' => 'BLÜCHER', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_sol8_desc', 'label' => __( 'Solución 8: Descripción', 'mitsa' ), 'name' => 'sol8_desc', 'type' => 'text', 'default_value' => 'Canaletas, sifones y tuberías de acero inoxidable AISI 316L para higiene naval.', 'wrapper' => array( 'width' => '50' ),
				),

				// ==========================================
				// PESTAÑA 7: ¿POR QUÉ MITSA?
				// ==========================================
				array(
					'key'       => 'tab_mitsa_why',
					'label'     => __( '⭐ ¿Por qué MITSA?', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_mitsa_why_heading',
					'label'         => __( 'Título de la Sección (H2)', 'mitsa' ),
					'name'          => 'why_heading',
					'type'          => 'text',
					'default_value' => '¿Por qué MITSA?',
				),
				array(
					'key'           => 'field_mitsa_why_subheading',
					'label'         => __( 'Bajada / Subtítulo', 'mitsa' ),
					'name'          => 'why_subheading',
					'type'          => 'textarea',
					'default_value' => 'Seis razones técnicas que sostienen un proyecto completo, de la especificación al soporte en operación.',
					'rows'          => 2,
				),
				// Razón 1
				array(
					'key' => 'field_mitsa_why1_title', 'label' => __( 'Razón 1: Título', 'mitsa' ), 'name' => 'why1_title', 'type' => 'text', 'default_value' => 'Años de experiencia', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_mitsa_why1_metric', 'label' => __( 'Razón 1: Cifra Destacada', 'mitsa' ), 'name' => 'why1_metric', 'type' => 'text', 'default_value' => '40+', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_why1_desc', 'label' => __( 'Razón 1: Descripción', 'mitsa' ), 'name' => 'why1_desc', 'type' => 'text', 'default_value' => 'Cuatro décadas resolviendo proyectos marítimos e industriales en Chile.', 'wrapper' => array( 'width' => '50' ),
				),
				// Razón 2
				array(
					'key' => 'field_mitsa_why2_title', 'label' => __( 'Razón 2: Título', 'mitsa' ), 'name' => 'why2_title', 'type' => 'text', 'default_value' => 'Ingeniería especializada', 'wrapper' => array( 'width' => '40' ),
				),
				array(
					'key' => 'field_mitsa_why2_desc', 'label' => __( 'Razón 2: Descripción', 'mitsa' ), 'name' => 'why2_desc', 'type' => 'text', 'default_value' => 'Ingeniería de aplicación propia: la solución se dimensiona, no se cotiza de catálogo.', 'wrapper' => array( 'width' => '60' ),
				),
				// Razón 3
				array(
					'key' => 'field_mitsa_why3_title', 'label' => __( 'Razón 3: Título', 'mitsa' ), 'name' => 'why3_title', 'type' => 'text', 'default_value' => 'Representantes oficiales', 'wrapper' => array( 'width' => '40' ),
				),
				array(
					'key' => 'field_mitsa_why3_desc', 'label' => __( 'Razón 3: Descripción', 'mitsa' ), 'name' => 'why3_desc', 'type' => 'text', 'default_value' => 'Representación directa de cinco fabricantes internacionales, con respaldo y garantía de fábrica.', 'wrapper' => array( 'width' => '60' ),
				),
				// Razón 4 (Foto en terreno)
				array(
					'key'           => 'field_mitsa_why4_image',
					'label'         => __( 'Razón 4: Foto de Equipo en Terreno', 'mitsa' ),
					'name'          => 'why4_image',
					'type'          => 'image',
					'return_format' => 'url',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_why4_caption',
					'label'         => __( 'Razón 4: Leyenda sobre imagen', 'mitsa' ),
					'name'          => 'why4_caption',
					'type'          => 'text',
					'default_value' => 'Equipo en terreno',
					'wrapper'       => array( 'width' => '50' ),
				),
				// Razón 5
				array(
					'key' => 'field_mitsa_why5_title', 'label' => __( 'Razón 5: Título', 'mitsa' ), 'name' => 'why5_title', 'type' => 'text', 'default_value' => 'Cobertura nacional y regional', 'wrapper' => array( 'width' => '40' ),
				),
				array(
					'key' => 'field_mitsa_why5_desc', 'label' => __( 'Razón 5: Descripción', 'mitsa' ), 'name' => 'why5_desc', 'type' => 'text', 'default_value' => 'Presencia donde está la operación: puertos, astilleros, faenas y centros de cultivo.', 'wrapper' => array( 'width' => '60' ),
				),
				// Razón 6
				array(
					'key' => 'field_mitsa_why6_title', 'label' => __( 'Razón 6: Título', 'mitsa' ), 'name' => 'why6_title', 'type' => 'text', 'default_value' => 'Puesta en marcha y soporte', 'wrapper' => array( 'width' => '40' ),
				),
				array(
					'key' => 'field_mitsa_why6_desc', 'label' => __( 'Razón 6: Descripción', 'mitsa' ), 'name' => 'why6_desc', 'type' => 'text', 'default_value' => 'Comisionamiento, capacitación a la tripulación y asistencia después de la entrega.', 'wrapper' => array( 'width' => '60' ),
				),

				// ==========================================
				// PESTAÑA 8: GRAN CALL TO ACTION
				// ==========================================
				array(
					'key'       => 'tab_mitsa_cta',
					'label'     => __( '📢 Call to Action', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_mitsa_cta_heading',
					'label'         => __( 'Título de CTA (H2)', 'mitsa' ),
					'name'          => 'cta_heading',
					'type'          => 'text',
					'default_value' => 'Evaluación técnica sin costo para dimensionar su proyecto',
				),
				array(
					'key'           => 'field_mitsa_cta_desc',
					'label'         => __( 'Descripción', 'mitsa' ),
					'name'          => 'cta_desc',
					'type'          => 'textarea',
					'default_value' => 'Revise requerimientos de caudal, normativa OMI / DIRECTEMAR, espacio disponible y tiempos de entrega con nuestros ingenieros de aplicación.',
					'rows'          => 2,
				),
				array(
					'key'           => 'field_mitsa_cta_btn1_label',
					'label'         => __( 'Botón Primario - Texto', 'mitsa' ),
					'name'          => 'cta_btn1_label',
					'type'          => 'text',
					'default_value' => 'Solicitar evaluación técnica',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_cta_btn1_url',
					'label'         => __( 'Botón Primario - URL', 'mitsa' ),
					'name'          => 'cta_btn1_url',
					'type'          => 'text',
					'default_value' => '/contacto/?tipo=evaluacion',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_cta_btn2_label',
					'label'         => __( 'Botón Secundario - Texto', 'mitsa' ),
					'name'          => 'cta_btn2_label',
					'type'          => 'text',
					'default_value' => 'Contactar a ingeniería',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_cta_btn2_url',
					'label'         => __( 'Botón Secundario - URL', 'mitsa' ),
					'name'          => 'cta_btn2_url',
					'type'          => 'text',
					'default_value' => '/contacto/?tipo=servicio',
					'wrapper'       => array( 'width' => '50' ),
				),

				// ==========================================
				// PESTAÑA 9: PREGUNTAS FRECUENTES (FAQS)
				// ==========================================
				array(
					'key'       => 'tab_mitsa_faqs',
					'label'     => __( '❓ Preguntas Frecuentes', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_mitsa_faqs_heading',
					'label'         => __( 'Título de la Sección (H2)', 'mitsa' ),
					'name'          => 'faqs_heading',
					'type'          => 'text',
					'default_value' => 'Preguntas frecuentes de ingeniería',
				),
				// FAQ 1
				array(
					'key' => 'field_mitsa_faq1_q', 'label' => __( 'Pregunta 1', 'mitsa' ), 'name' => 'faq1_q', 'type' => 'text', 'default_value' => '¿Cómo se determina si un buque requiere sistema ICCP o ánodos de sacrificio?',
				),
				array(
					'key' => 'field_mitsa_faq1_a', 'label' => __( 'Respuesta 1', 'mitsa' ), 'name' => 'faq1_a', 'type' => 'textarea', 'default_value' => 'Depende del perfil operativo, área mojada del casco, tiempo entre diques y costo de ciclo de vida. ICCP ofrece control regulable en tiempo real sin reposición física en cada carena.', 'rows' => 2,
				),
				// FAQ 2
				array(
					'key' => 'field_mitsa_faq2_q', 'label' => __( 'Pregunta 2', 'mitsa' ), 'name' => 'faq2_q', 'type' => 'text', 'default_value' => '¿Qué certificaciones tienen las plantas de tratamiento de aguas servidas que suministran?',
				),
				array(
					'key' => 'field_mitsa_faq2_a', 'label' => __( 'Respuesta 2', 'mitsa' ), 'name' => 'faq2_a', 'type' => 'textarea', 'default_value' => 'Equipos certificados bajo la Resolución MEPC.227(64) de la OMI (MARPOL Anexo IV) y aprobados por las principales casas clasificadoras (DNV, Lloyd\'s Register, ABS, BV).', 'rows' => 2,
				),
				// FAQ 3
				array(
					'key' => 'field_mitsa_faq3_q', 'label' => __( 'Pregunta 3', 'mitsa' ), 'name' => 'faq3_q', 'type' => 'text', 'default_value' => '¿MITSA realiza la puesta en marcha en cualquier puerto de Chile?',
				),
				array(
					'key' => 'field_mitsa_faq3_a', 'label' => __( 'Respuesta 3', 'mitsa' ), 'name' => 'faq3_a', 'type' => 'textarea', 'default_value' => 'Sí, nuestros ingenieros de servicio técnico operan en todo Chile (Arica a Punta Arenas) y en puertos de la región para comisionamiento, pruebas de mar y capacitación.', 'rows' => 2,
				),
				// FAQ 4
				array(
					'key' => 'field_mitsa_faq4_q', 'label' => __( 'Pregunta 4', 'mitsa' ), 'name' => 'faq4_q', 'type' => 'text', 'default_value' => '¿Cómo solicito repuestos originales de marcas representadas?',
				),
				array(
					'key' => 'field_mitsa_faq4_a', 'label' => __( 'Respuesta 4', 'mitsa' ), 'name' => 'faq4_a', 'type' => 'textarea', 'default_value' => 'A través de nuestro portal de repuestos o contacto directo, indicando fabricante, modelo, número de serie y número de parte (P/N) de la placa del equipo.', 'rows' => 2,
				),

				// ==========================================
				// PESTAÑA 10: CONFIGURACIÓN SEO
				// ==========================================
				array(
					'key'       => 'tab_mitsa_seo',
					'label'     => __( '🔍 SEO & Open Graph', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_mitsa_seo_title',
					'label'         => __( 'Meta Título (SEO)', 'mitsa' ),
					'name'          => 'seo_meta_title',
					'type'          => 'text',
					'default_value' => 'MITSA — Integramos tecnología. Resolvemos desafíos.',
					'instructions'  => __( '50-60 caracteres recomendados.', 'mitsa' ),
				),
				array(
					'key'           => 'field_mitsa_seo_desc',
					'label'         => __( 'Meta Descripción', 'mitsa' ),
					'name'          => 'seo_meta_description',
					'type'          => 'textarea',
					'default_value' => 'Ingeniería de aplicación, suministro, retrofit, puesta en marcha y soporte. Cinco fabricantes representados, cuarenta años de proyectos en Chile y Latinoamérica.',
					'instructions'  => __( '140-160 caracteres con llamada a la acción implícita.', 'mitsa' ),
					'rows'          => 3,
				),
				array(
					'key'           => 'field_mitsa_seo_image',
					'label'         => __( 'Imagen Open Graph (Social Share)', 'mitsa' ),
					'name'          => 'seo_og_image',
					'type'          => 'image',
					'return_format' => 'url',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'page_type',
						'operator' => '==',
						'value'    => 'front_page',
					),
				),
			),
			'menu_order'            => 10,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'left',
			'instruction_placement' => 'label',
			'hide_on_screen'        => array(
				'the_content',
				'featured_image',
			),
		)
	);

	// =========================================================================
	// GRUPO MAESTRO: ADMINISTRACIÓN DE PÁGINA "NOSOTROS"
	// =========================================================================
	acf_add_local_field_group(
		array(
			'key'                   => 'group_mitsa_nosotros_master',
			'title'                 => __( 'Administración de Página "Nosotros" (MITSA)', 'mitsa' ),
			'fields'                => array(

				// PESTAÑA 1: HERO & TAGLINE
				array(
					'key'       => 'tab_nosotros_hero',
					'label'     => __( '🚀 Hero & Tagline', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_nosotros_hero_title',
					'label'         => __( 'Título Principal (H1)', 'mitsa' ),
					'name'          => 'nosotros_hero_title',
					'type'          => 'text',
					'default_value' => 'Cuatro décadas integrando ingeniería, tecnología y servicio especializado',
					'required'      => 1,
				),
				array(
					'key'           => 'field_nosotros_hero_tagline',
					'label'         => __( 'Lema / Tagline Corporativo', 'mitsa' ),
					'name'          => 'nosotros_hero_tagline',
					'type'          => 'text',
					'default_value' => '«Todos tenemos una especialidad, la nuestra es servir»',
					'required'      => 1,
				),
				array(
					'key'           => 'field_nosotros_hero_desc',
					'label'         => __( 'Descripción de Introducción', 'mitsa' ),
					'name'          => 'nosotros_hero_desc',
					'type'          => 'textarea',
					'default_value' => 'Pioneros en introducir tecnología avanzada en el segmento sanitario y ambiental para uso marino, industrial, pesquero, acuícola y minero en Chile y Latinoamérica desde 1982.',
					'rows'          => 3,
					'required'      => 1,
				),
				array(
					'key'           => 'field_nosotros_hero_image',
					'label'         => __( 'Fotografía Corporativa Destacada', 'mitsa' ),
					'name'          => 'nosotros_hero_image',
					'type'          => 'image',
					'return_format' => 'url',
				),

				// PESTAÑA 2: QUIÉNES SOMOS & TRAYECTORIA
				array(
					'key'       => 'tab_nosotros_story',
					'label'     => __( '🏢 Trayectoria (Hitos)', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_nosotros_story_title',
					'label'         => __( 'Título de Sección (H2)', 'mitsa' ),
					'name'          => 'nosotros_story_title',
					'type'          => 'text',
					'default_value' => 'Pioneros en tecnología marina y ambiental desde 1982',
				),
				array(
					'key'           => 'field_nosotros_story_p1',
					'label'         => __( 'Párrafo de Historia 1', 'mitsa' ),
					'name'          => 'nosotros_story_p1',
					'type'          => 'textarea',
					'default_value' => 'Fundada en 1982 en Reñaca, Viña del Mar, MITSA nació con la convicción de conectar a las industrias marítimas y productivas de Chile con los inventores y fabricantes de tecnología de mayor estándar mundial.',
					'rows'          => 3,
				),
				array(
					'key'           => 'field_nosotros_story_p2',
					'label'         => __( 'Párrafo de Historia 2', 'mitsa' ),
					'name'          => 'nosotros_story_p2',
					'type'          => 'textarea',
					'default_value' => 'A lo largo de más de cuatro décadas, hemos evolucionado de la provisión de equipos sanitarios al vacío hacia la ingeniería de aplicación integral, comisionamiento y respaldo operativo en terreno en todo el país.',
					'rows'          => 3,
				),
				// Hitos
				array(
					'key' => 'field_nosotros_m1_year', 'label' => __( 'Hito 1: Año', 'mitsa' ), 'name' => 'nosotros_m1_year', 'type' => 'text', 'default_value' => '1982', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_nosotros_m1_title', 'label' => __( 'Hito 1: Título', 'mitsa' ), 'name' => 'nosotros_m1_title', 'type' => 'text', 'default_value' => 'Fundación en Reñaca, Viña del Mar', 'wrapper' => array( 'width' => '40' ),
				),
				array(
					'key' => 'field_nosotros_m1_desc', 'label' => __( 'Hito 1: Detalle', 'mitsa' ), 'name' => 'nosotros_m1_desc', 'type' => 'text', 'default_value' => 'Inicio de operaciones representando tecnología pionera sanitaria marina.', 'wrapper' => array( 'width' => '40' ),
				),
				array(
					'key' => 'field_nosotros_m2_year', 'label' => __( 'Hito 2: Año', 'mitsa' ), 'name' => 'nosotros_m2_year', 'type' => 'text', 'default_value' => '1995', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_nosotros_m2_title', 'label' => __( 'Hito 2: Título', 'mitsa' ), 'name' => 'nosotros_m2_title', 'type' => 'text', 'default_value' => 'Expansión a Flotas y Astilleros', 'wrapper' => array( 'width' => '40' ),
				),
				array(
					'key' => 'field_nosotros_m2_desc', 'label' => __( 'Hito 2: Detalle', 'mitsa' ), 'name' => 'nosotros_m2_desc', 'type' => 'text', 'default_value' => 'Consolidación en buques de la Armada de Chile, marina mercante y salmonicultura.', 'wrapper' => array( 'width' => '40' ),
				),
				array(
					'key' => 'field_nosotros_m3_year', 'label' => __( 'Hito 3: Año', 'mitsa' ), 'name' => 'nosotros_m3_year', 'type' => 'text', 'default_value' => '2010', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_nosotros_m3_title', 'label' => __( 'Hito 3: Título', 'mitsa' ), 'name' => 'nosotros_m3_title', 'type' => 'text', 'default_value' => 'Alianzas Globales de Fabricación', 'wrapper' => array( 'width' => '40' ),
				),
				array(
					'key' => 'field_nosotros_m3_desc', 'label' => __( 'Hito 3: Detalle', 'mitsa' ), 'name' => 'nosotros_m3_desc', 'type' => 'text', 'default_value' => 'Representación directa y exclusiva de EVAC, Cathelco, ERMA FIRST, EPE y BLÜCHER.', 'wrapper' => array( 'width' => '40' ),
				),
				array(
					'key' => 'field_nosotros_m4_year', 'label' => __( 'Hito 4: Año', 'mitsa' ), 'name' => 'nosotros_m4_year', 'type' => 'text', 'default_value' => '2026', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_nosotros_m4_title', 'label' => __( 'Hito 4: Título', 'mitsa' ), 'name' => 'nosotros_m4_title', 'type' => 'text', 'default_value' => 'Ingeniería y Presencia Regional', 'wrapper' => array( 'width' => '40' ),
				),
				array(
					'key' => 'field_nosotros_m4_desc', 'label' => __( 'Hito 4: Detalle', 'mitsa' ), 'name' => 'nosotros_m4_desc', 'type' => 'text', 'default_value' => 'Proyectos de retrofit, BWTS D-2, protección ICCP y servicios en Chile y Latinoamérica.', 'wrapper' => array( 'width' => '40' ),
				),

				// PESTAÑA 3: MISIÓN & VISIÓN
				array(
					'key'       => 'tab_nosotros_mv',
					'label'     => __( '🎯 Misión & Visión', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_nosotros_mission_title',
					'label'         => __( 'Título de Misión', 'mitsa' ),
					'name'          => 'nosotros_mission_title',
					'type'          => 'text',
					'default_value' => 'Nuestra Misión',
				),
				array(
					'key'           => 'field_nosotros_mission_text',
					'label'         => __( 'Texto de Misión (Brochure Oficial)', 'mitsa' ),
					'name'          => 'nosotros_mission_text',
					'type'          => 'textarea',
					'default_value' => 'Liderar el mercado chileno y latinoamericano en la provisión de tecnologías y equipos para el cuidado del medio ambiente acuático, manteniendo altos estándares de calidad y servicio.',
					'rows'          => 3,
				),
				array(
					'key'           => 'field_nosotros_vision_title',
					'label'         => __( 'Título de Visión', 'mitsa' ),
					'name'          => 'nosotros_vision_title',
					'type'          => 'text',
					'default_value' => 'Nuestra Visión',
				),
				array(
					'key'           => 'field_nosotros_vision_text',
					'label'         => __( 'Texto de Visión (Brochure Oficial)', 'mitsa' ),
					'name'          => 'nosotros_vision_text',
					'type'          => 'textarea',
					'default_value' => 'Ofrecer soluciones integrales y especializadas para el cuidado del medio ambiente acuático, utilizando tecnologías avanzadas y representando a las compañías líderes a nivel mundial.',
					'rows'          => 3,
				),

				// PESTAÑA 4: PILARES Y COMPROMISO
				array(
					'key'       => 'tab_nosotros_pillars',
					'label'     => __( '🛡️ Pilares de Valor', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_nosotros_pillars_heading',
					'label'         => __( 'Título de la Sección (H2)', 'mitsa' ),
					'name'          => 'nosotros_pillars_heading',
					'type'          => 'text',
					'default_value' => 'Los pilares que fundamentan nuestra propuesta',
				),
				// Pilar 1
				array(
					'key' => 'field_nosotros_p1_title', 'label' => __( 'Pilar 1: Título', 'mitsa' ), 'name' => 'nosotros_p1_title', 'type' => 'text', 'default_value' => 'Representación Oficial Directa', 'wrapper' => array( 'width' => '40' ),
				),
				array(
					'key' => 'field_nosotros_p1_desc', 'label' => __( 'Pilar 1: Descripción', 'mitsa' ), 'name' => 'nosotros_p1_desc', 'type' => 'text', 'default_value' => 'Vínculo directo sin intermediarios con fabricantes líderes mundiales e inventores de la tecnología.', 'wrapper' => array( 'width' => '60' ),
				),
				// Pilar 2
				array(
					'key' => 'field_nosotros_p2_title', 'label' => __( 'Pilar 2: Título', 'mitsa' ), 'name' => 'nosotros_p2_title', 'type' => 'text', 'default_value' => 'Ingeniería de Aplicación Propia', 'wrapper' => array( 'width' => '40' ),
				),
				array(
					'key' => 'field_nosotros_p2_desc', 'label' => __( 'Pilar 2: Descripción', 'mitsa' ), 'name' => 'nosotros_p2_desc', 'type' => 'text', 'default_value' => 'Dimensionamiento a medida, selección de materiales y cumplimiento estricto de normativas internacionales.', 'wrapper' => array( 'width' => '60' ),
				),
				// Pilar 3
				array(
					'key' => 'field_nosotros_p3_title', 'label' => __( 'Pilar 3: Título', 'mitsa' ), 'name' => 'nosotros_p3_title', 'type' => 'text', 'default_value' => 'Servicio Técnico en Terreno', 'wrapper' => array( 'width' => '40' ),
				),
				array(
					'key' => 'field_nosotros_p3_desc', 'label' => __( 'Pilar 3: Descripción', 'mitsa' ), 'name' => 'nosotros_p3_desc', 'type' => 'text', 'default_value' => 'Ingenieros especialistas para puesta en marcha, pruebas de mar, mantenciones y capacitación.', 'wrapper' => array( 'width' => '60' ),
				),
				// Pilar 4
				array(
					'key' => 'field_nosotros_p4_title', 'label' => __( 'Pilar 4: Título', 'mitsa' ), 'name' => 'nosotros_p4_title', 'type' => 'text', 'default_value' => 'Cuidado del Medio Ambiente Acuático', 'wrapper' => array( 'width' => '40' ),
				),
				array(
					'key' => 'field_nosotros_p4_desc', 'label' => __( 'Pilar 4: Descripción', 'mitsa' ), 'name' => 'nosotros_p4_desc', 'type' => 'text', 'default_value' => 'Tecnologías certificadas bajo normas OMI MARPOL Anexo IV y D-2 para cero impacto ambiental.', 'wrapper' => array( 'width' => '60' ),
				),

				// PESTAÑA 5: COBERTURA Y PRESENCIA
				array(
					'key'       => 'tab_nosotros_coverage',
					'label'     => __( '🌍 Cobertura Regional', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_nosotros_coverage_title',
					'label'         => __( 'Título de Cobertura (H2)', 'mitsa' ),
					'name'          => 'nosotros_coverage_title',
					'type'          => 'text',
					'default_value' => 'Presencia estratégica en Chile y la región',
				),
				array(
					'key'           => 'field_nosotros_coverage_desc',
					'label'         => __( 'Descripción del Alcance', 'mitsa' ),
					'name'          => 'nosotros_coverage_desc',
					'type'          => 'textarea',
					'default_value' => 'Desde nuestra sede central en Reñaca, Viña del Mar, atendemos faenas, astilleros, puertos y centros acuícolas a lo largo de toda la costa de Chile y brindamos soporte para proyectos en Sudamérica.',
					'rows'          => 3,
				),
				array(
					'key'           => 'field_nosotros_hq_city',
					'label'         => __( 'Sede Central', 'mitsa' ),
					'name'          => 'nosotros_hq_city',
					'type'          => 'text',
					'default_value' => 'Reñaca, Viña del Mar, Región de Valparaíso, Chile',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_nosotros_coverage_scope',
					'label'         => __( 'Alcance Operativo', 'mitsa' ),
					'name'          => 'nosotros_coverage_scope',
					'type'          => 'text',
					'default_value' => 'Nacional (Arica a Punta Arenas) y Latinoamérica',
					'wrapper'       => array( 'width' => '50' ),
				),

				// PESTAÑA 6: LLAMADO A LA ACCIÓN (CTA)
				array(
					'key'       => 'tab_nosotros_cta',
					'label'     => __( '📢 Call to Action', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_nosotros_cta_heading',
					'label'         => __( 'Título del Banner CTA', 'mitsa' ),
					'name'          => 'nosotros_cta_heading',
					'type'          => 'text',
					'default_value' => 'Conozca cómo nuestros ingenieros pueden respaldar su próximo proyecto',
				),
				array(
					'key'           => 'field_nosotros_cta_desc',
					'label'         => __( 'Descripción del CTA', 'mitsa' ),
					'name'          => 'nosotros_cta_desc',
					'type'          => 'textarea',
					'default_value' => 'Contáctenos para evaluar requerimientos técnicos, dimensionamiento de equipos o asistencia en terreno.',
					'rows'          => 2,
				),
				array(
					'key'           => 'field_nosotros_cta_btn_label',
					'label'         => __( 'Texto del Botón', 'mitsa' ),
					'name'          => 'nosotros_cta_btn_label',
					'type'          => 'text',
					'default_value' => 'Contactar al equipo de ingeniería',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_nosotros_cta_btn_url',
					'label'         => __( 'URL del Botón', 'mitsa' ),
					'name'          => 'nosotros_cta_btn_url',
					'type'          => 'text',
					'default_value' => '/contacto/',
					'wrapper'       => array( 'width' => '50' ),
				),

				// PESTAÑA 7: SEO & OPEN GRAPH
				array(
					'key'       => 'tab_nosotros_seo',
					'label'     => __( '🔍 SEO & Open Graph', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_nosotros_seo_title',
					'label'         => __( 'Meta Título (SEO)', 'mitsa' ),
					'name'          => 'seo_meta_title',
					'type'          => 'text',
					'default_value' => 'Nosotros · Trayectoria y Especialistas en Tecnología Marina | MITSA',
				),
				array(
					'key'           => 'field_nosotros_seo_desc',
					'label'         => __( 'Meta Descripción', 'mitsa' ),
					'name'          => 'seo_meta_description',
					'type'          => 'textarea',
					'default_value' => 'Pioneros en tecnología marina y ambiental en Chile desde 1982. Representantes oficiales de EVAC, Cathelco, ERMA FIRST, EPE y BLÜCHER.',
					'rows'          => 3,
				),
				array(
					'key'           => 'field_nosotros_seo_image',
					'label'         => __( 'Imagen Open Graph (Social Share)', 'mitsa' ),
					'name'          => 'seo_og_image',
					'type'          => 'image',
					'return_format' => 'url',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'page',
						'operator' => '==',
						'value'    => '6', // ID de la página Nosotros
					),
				),
			),
			'menu_order'            => 10,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'left',
			'instruction_placement' => 'label',
			'hide_on_screen'        => array(
				'the_content',
				'featured_image',
			),
		)
	);
}
add_action( 'acf/init', 'mitsa_register_acf_field_groups' );

/**
 * Configura la ruta de guardado automático de ACF JSON.
 */
function mitsa_acf_json_save_point( $path ) {
	return get_template_directory() . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'mitsa_acf_json_save_point' );

/**
 * Configura la ruta de carga de ACF JSON para sincronización en WP Admin.
 */
function mitsa_acf_json_load_point( $paths ) {
	unset( $paths[0] );
	$paths[] = get_template_directory() . '/acf-json';
	return $paths;
}
add_filter( 'acf/settings/load_json', 'mitsa_acf_json_load_point' );
