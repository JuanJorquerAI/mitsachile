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

	// =========================================================================
	// GRUPO MAESTRO: ADMINISTRACIÓN DE PÁGINA "SERVICIOS"
	// =========================================================================
	acf_add_local_field_group(
		array(
			'key'                   => 'group_mitsa_servicios_master',
			'title'                 => __( 'Administración de Página "Servicios" (MITSA)', 'mitsa' ),
			'fields'                => array(

				// PESTAÑA 1: HERO & BOTONES RÁPIDOS
				array(
					'key'       => 'tab_servicios_hero',
					'label'     => __( '🚀 Hero & Acciones', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_servicios_hero_title',
					'label'         => __( 'Título Principal (H1)', 'mitsa' ),
					'name'          => 'servicios_hero_title',
					'type'          => 'text',
					'default_value' => 'El equipo llega. Alguien tiene que responder por él.',
					'required'      => 1,
				),
				array(
					'key'           => 'field_servicios_hero_desc',
					'label'         => __( 'Descripción de Introducción', 'mitsa' ),
					'name'          => 'servicios_hero_desc',
					'type'          => 'textarea',
					'default_value' => 'Seis servicios que cubren el ciclo completo: desde el levantamiento a bordo hasta el repuesto que se necesita cinco años después de la entrega.',
					'rows'          => 3,
					'required'      => 1,
				),
				array(
					'key'           => 'field_servicios_hero_btn1_label',
					'label'         => __( 'Botón 1 - Texto', 'mitsa' ),
					'name'          => 'servicios_hero_btn1_label',
					'type'          => 'text',
					'default_value' => 'Solicitar servicio técnico',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_servicios_hero_btn1_url',
					'label'         => __( 'Botón 1 - URL', 'mitsa' ),
					'name'          => 'servicios_hero_btn1_url',
					'type'          => 'text',
					'default_value' => '/contacto/?tipo=servicio',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_servicios_hero_btn2_label',
					'label'         => __( 'Botón 2 - Texto', 'mitsa' ),
					'name'          => 'servicios_hero_btn2_label',
					'type'          => 'text',
					'default_value' => 'Pedir repuestos',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_servicios_hero_btn2_url',
					'label'         => __( 'Botón 2 - URL', 'mitsa' ),
					'name'          => 'servicios_hero_btn2_url',
					'type'          => 'text',
					'default_value' => '/contacto/?tipo=repuestos',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_servicios_hero_image',
					'label'         => __( 'Fotografía Destacada Hero', 'mitsa' ),
					'name'          => 'servicios_hero_image',
					'type'          => 'image',
					'return_format' => 'url',
				),

				// PESTAÑA 2: MÉTRICAS DE CAPACIDAD
				array(
					'key'       => 'tab_servicios_metrics',
					'label'     => __( '📊 Métricas', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key' => 'field_srv_m1_val', 'label' => __( 'Métrica 1: Cifra', 'mitsa' ), 'name' => 'servicios_m1_val', 'type' => 'text', 'default_value' => '6', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_srv_m1_lbl', 'label' => __( 'Métrica 1: Etiqueta', 'mitsa' ), 'name' => 'servicios_m1_lbl', 'type' => 'text', 'default_value' => 'servicios sobre el mismo sistema', 'wrapper' => array( 'width' => '70' ),
				),
				array(
					'key' => 'field_srv_m2_val', 'label' => __( 'Métrica 2: Cifra', 'mitsa' ), 'name' => 'servicios_m2_val', 'type' => 'text', 'default_value' => '5', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_srv_m2_lbl', 'label' => __( 'Métrica 2: Etiqueta', 'mitsa' ), 'name' => 'servicios_m2_lbl', 'type' => 'text', 'default_value' => 'fabricantes representados directamente', 'wrapper' => array( 'width' => '70' ),
				),
				array(
					'key' => 'field_srv_m3_val', 'label' => __( 'Métrica 3: Cifra', 'mitsa' ), 'name' => 'servicios_m3_val', 'type' => 'text', 'default_value' => '100%', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_srv_m3_lbl', 'label' => __( 'Métrica 3: Etiqueta', 'mitsa' ), 'name' => 'servicios_m3_lbl', 'type' => 'text', 'default_value' => 'cobertura de puertos y astilleros en Chile', 'wrapper' => array( 'width' => '70' ),
				),

				// PESTAÑA 3: CATÁLOGO DE SERVICIOS (6)
				array(
					'key'       => 'tab_servicios_catalog',
					'label'     => __( '⚙️ Catálogo (6 Servicios)', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				// Servicio 1
				array(
					'key' => 'field_srv1_num', 'label' => __( 'Servicio 1: Número', 'mitsa' ), 'name' => 'srv1_num', 'type' => 'text', 'default_value' => '01', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_srv1_executor', 'label' => __( 'Servicio 1: Ejecuta', 'mitsa' ), 'name' => 'srv1_executor', 'type' => 'text', 'default_value' => 'Ejecuta MITSA', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_srv1_title', 'label' => __( 'Servicio 1: Título', 'mitsa' ), 'name' => 'srv1_title', 'type' => 'text', 'default_value' => 'Ingeniería y dimensionamiento', 'wrapper' => array( 'width' => '50' ),
				),
				array(
					'key' => 'field_srv1_desc', 'label' => __( 'Servicio 1: Descripción', 'mitsa' ), 'name' => 'srv1_desc', 'type' => 'textarea', 'default_value' => 'Levantamiento a bordo, cálculo de capacidad y definición del sistema antes de cotizar. El alcance queda formalizado por escrito para evitar sobrecostos en obra.', 'rows' => 2,
				),
				array(
					'key' => 'field_srv1_tags', 'label' => __( 'Servicio 1: Entregables / Tags (separados por coma)', 'mitsa' ), 'name' => 'srv1_tags', 'type' => 'text', 'default_value' => 'Levantamiento a bordo, Memoria de cálculo, Planos de integración CAD', 'wrapper' => array( 'width' => '60' ),
				),
				array(
					'key' => 'field_srv1_image', 'label' => __( 'Servicio 1: Imagen', 'mitsa' ), 'name' => 'srv1_image', 'type' => 'image', 'return_format' => 'url', 'wrapper' => array( 'width' => '40' ),
				),
				// Servicio 2
				array(
					'key' => 'field_srv2_num', 'label' => __( 'Servicio 2: Número', 'mitsa' ), 'name' => 'srv2_num', 'type' => 'text', 'default_value' => '02', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_srv2_executor', 'label' => __( 'Servicio 2: Ejecuta', 'mitsa' ), 'name' => 'srv2_executor', 'type' => 'text', 'default_value' => 'Ejecuta MITSA', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_srv2_title', 'label' => __( 'Servicio 2: Título', 'mitsa' ), 'name' => 'srv2_title', 'type' => 'text', 'default_value' => 'Suministro e importación oficial', 'wrapper' => array( 'width' => '50' ),
				),
				array(
					'key' => 'field_srv2_desc', 'label' => __( 'Servicio 2: Descripción', 'mitsa' ), 'name' => 'srv2_desc', 'type' => 'textarea', 'default_value' => 'Equipos de las cinco representadas con garantía directa de fábrica, gestión aduanera e integración con la carta Gantt del astillero o armador.', 'rows' => 2,
				),
				array(
					'key' => 'field_srv2_tags', 'label' => __( 'Servicio 2: Entregables / Tags', 'mitsa' ), 'name' => 'srv2_tags', 'type' => 'text', 'default_value' => 'Importación directa, Garantía de fábrica, Coordinación de plazos', 'wrapper' => array( 'width' => '60' ),
				),
				array(
					'key' => 'field_srv2_image', 'label' => __( 'Servicio 2: Imagen', 'mitsa' ), 'name' => 'srv2_image', 'type' => 'image', 'return_format' => 'url', 'wrapper' => array( 'width' => '40' ),
				),
				// Servicio 3
				array(
					'key' => 'field_srv3_num', 'label' => __( 'Servicio 3: Número', 'mitsa' ), 'name' => 'srv3_num', 'type' => 'text', 'default_value' => '03', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_srv3_executor', 'label' => __( 'Servicio 3: Ejecuta', 'mitsa' ), 'name' => 'srv3_executor', 'type' => 'text', 'default_value' => 'MITSA · Astillero', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_srv3_title', 'label' => __( 'Servicio 3: Título', 'mitsa' ), 'name' => 'srv3_title', 'type' => 'text', 'default_value' => 'Montaje y supervisión', 'wrapper' => array( 'width' => '50' ),
				),
				array(
					'key' => 'field_srv3_desc', 'label' => __( 'Servicio 3: Descripción', 'mitsa' ), 'name' => 'srv3_desc', 'type' => 'textarea', 'default_value' => 'Supervisión técnica de montaje mecánico, eléctrico e hidráulico durante la instalación, tanto en dique como con la nave en operación.', 'rows' => 2,
				),
				array(
					'key' => 'field_srv3_tags', 'label' => __( 'Servicio 3: Entregables / Tags', 'mitsa' ), 'name' => 'srv3_tags', 'type' => 'text', 'default_value' => 'Supervisión en obra, Protocolos de montaje, Registro fotográfico', 'wrapper' => array( 'width' => '60' ),
				),
				array(
					'key' => 'field_srv3_image', 'label' => __( 'Servicio 3: Imagen', 'mitsa' ), 'name' => 'srv3_image', 'type' => 'image', 'return_format' => 'url', 'wrapper' => array( 'width' => '40' ),
				),
				// Servicio 4
				array(
					'key' => 'field_srv4_num', 'label' => __( 'Servicio 4: Número', 'mitsa' ), 'name' => 'srv4_num', 'type' => 'text', 'default_value' => '04', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_srv4_executor', 'label' => __( 'Servicio 4: Ejecuta', 'mitsa' ), 'name' => 'srv4_executor', 'type' => 'text', 'default_value' => 'MITSA + Fabricante', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_srv4_title', 'label' => __( 'Servicio 4: Título', 'mitsa' ), 'name' => 'srv4_title', 'type' => 'text', 'default_value' => 'Puesta en marcha y comisionamiento', 'wrapper' => array( 'width' => '50' ),
				),
				array(
					'key' => 'field_srv4_desc', 'label' => __( 'Servicio 4: Descripción', 'mitsa' ), 'name' => 'srv4_desc', 'type' => 'textarea', 'default_value' => 'Pruebas de mar, ajuste de parámetros, calibración de sensores, capacitación a la tripulación y emisión del acta de entrega oficial.', 'rows' => 2,
				),
				array(
					'key' => 'field_srv4_tags', 'label' => __( 'Servicio 4: Entregables / Tags', 'mitsa' ), 'name' => 'srv4_tags', 'type' => 'text', 'default_value' => 'Pruebas de mar, Capacitación tripulación, Acta de entrega', 'wrapper' => array( 'width' => '60' ),
				),
				array(
					'key' => 'field_srv4_image', 'label' => __( 'Servicio 4: Imagen', 'mitsa' ), 'name' => 'srv4_image', 'type' => 'image', 'return_format' => 'url', 'wrapper' => array( 'width' => '40' ),
				),
				// Servicio 5
				array(
					'key' => 'field_srv5_num', 'label' => __( 'Servicio 5: Número', 'mitsa' ), 'name' => 'srv5_num', 'type' => 'text', 'default_value' => '05', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_srv5_executor', 'label' => __( 'Servicio 5: Ejecuta', 'mitsa' ), 'name' => 'srv5_executor', 'type' => 'text', 'default_value' => 'Ejecuta MITSA', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_srv5_title', 'label' => __( 'Servicio 5: Título', 'mitsa' ), 'name' => 'srv5_title', 'type' => 'text', 'default_value' => 'Repuestos originales y retrofit', 'wrapper' => array( 'width' => '50' ),
				),
				array(
					'key' => 'field_srv5_desc', 'label' => __( 'Servicio 5: Descripción', 'mitsa' ), 'name' => 'srv5_desc', 'type' => 'textarea', 'default_value' => 'Identificación exacta por número de parte (P/N), reemplazo de componentes obsoletos y actualización de sistemas sanitarios o de tratamiento sin rehacer la red completa.', 'rows' => 2,
				),
				array(
					'key' => 'field_srv5_tags', 'label' => __( 'Servicio 5: Entregables / Tags', 'mitsa' ), 'name' => 'srv5_tags', 'type' => 'text', 'default_value' => 'N° de parte oficial, Stock crítico, Actualización normativa', 'wrapper' => array( 'width' => '60' ),
				),
				array(
					'key' => 'field_srv5_image', 'label' => __( 'Servicio 5: Imagen', 'mitsa' ), 'name' => 'srv5_image', 'type' => 'image', 'return_format' => 'url', 'wrapper' => array( 'width' => '40' ),
				),
				// Servicio 6
				array(
					'key' => 'field_srv6_num', 'label' => __( 'Servicio 6: Número', 'mitsa' ), 'name' => 'srv6_num', 'type' => 'text', 'default_value' => '06', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_srv6_executor', 'label' => __( 'Servicio 6: Ejecuta', 'mitsa' ), 'name' => 'srv6_executor', 'type' => 'text', 'default_value' => 'Ejecuta MITSA', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_srv6_title', 'label' => __( 'Servicio 6: Título', 'mitsa' ), 'name' => 'srv6_title', 'type' => 'text', 'default_value' => 'Soporte y continuidad operacional', 'wrapper' => array( 'width' => '50' ),
				),
				array(
					'key' => 'field_srv6_desc', 'label' => __( 'Servicio 6: Descripción', 'mitsa' ), 'name' => 'srv6_desc', 'type' => 'textarea', 'default_value' => 'Diagnóstico remoto de alarmas, visitas técnicas de emergencia en puerto y programas de mantenimiento preventivo durante toda la vida útil del buque.', 'rows' => 2,
				),
				array(
					'key' => 'field_srv6_tags', 'label' => __( 'Servicio 6: Entregables / Tags', 'mitsa' ), 'name' => 'srv6_tags', 'type' => 'text', 'default_value' => 'Diagnóstico remoto, Visita en terreno, Plan de mantenimiento', 'wrapper' => array( 'width' => '60' ),
				),
				array(
					'key' => 'field_srv6_image', 'label' => __( 'Servicio 6: Imagen', 'mitsa' ), 'name' => 'srv6_image', 'type' => 'image', 'return_format' => 'url', 'wrapper' => array( 'width' => '40' ),
				),

				// PESTAÑA 4: PROCESO DE ASESORAMIENTO (4 ETAPAS DEL BROCHURE)
				array(
					'key'       => 'tab_servicios_process',
					'label'     => __( '🔄 Proceso (4 Etapas)', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_process_heading',
					'label'         => __( 'Título de la Sección (H2)', 'mitsa' ),
					'name'          => 'process_heading',
					'type'          => 'text',
					'default_value' => 'Proceso de asesoramiento y cotización técnica',
				),
				array(
					'key'           => 'field_process_subheading',
					'label'         => __( 'Subtítulo', 'mitsa' ),
					'name'          => 'process_subheading',
					'type'          => 'textarea',
					'default_value' => 'Metodología estructurada de 4 etapas que asegura la compatibilidad exacta entre el requerimiento operativo y el diseño del fabricante.',
					'rows'          => 2,
				),
				// Etapa 1
				array(
					'key' => 'field_pstep1_title', 'label' => __( 'Etapa 1: Título', 'mitsa' ), 'name' => 'process_step1_title', 'type' => 'text', 'default_value' => '1. Requerimiento', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_pstep1_desc', 'label' => __( 'Etapa 1: Descripción', 'mitsa' ), 'name' => 'process_step1_desc', 'type' => 'textarea', 'default_value' => 'El cliente solicita cotizar un sistema, equipo o elemento específico para su embarcación o instalación.', 'rows' => 2, 'wrapper' => array( 'width' => '70' ),
				),
				// Etapa 2
				array(
					'key' => 'field_pstep2_title', 'label' => __( 'Etapa 2: Título', 'mitsa' ), 'name' => 'process_step2_title', 'type' => 'text', 'default_value' => '2. Evaluación', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_pstep2_desc', 'label' => __( 'Etapa 2: Descripción', 'mitsa' ), 'name' => 'process_step2_desc', 'type' => 'textarea', 'default_value' => 'MITSA evalúa junto con sus representadas las alternativas de diseño de cada fabricante según precio, innovación, normativa y calidad.', 'rows' => 2, 'wrapper' => array( 'width' => '70' ),
				),
				// Etapa 3
				array(
					'key' => 'field_pstep3_title', 'label' => __( 'Etapa 3: Título', 'mitsa' ), 'name' => 'process_step3_title', 'type' => 'text', 'default_value' => '3. Presentación', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_pstep3_desc', 'label' => __( 'Etapa 3: Descripción', 'mitsa' ), 'name' => 'process_step3_desc', 'type' => 'textarea', 'default_value' => 'Presentamos al cliente las mejores opciones técnicas y comerciales que satisfacen plenamente su necesidad.', 'rows' => 2, 'wrapper' => array( 'width' => '70' ),
				),
				// Etapa 4
				array(
					'key' => 'field_pstep4_title', 'label' => __( 'Etapa 4: Título', 'mitsa' ), 'name' => 'process_step4_title', 'type' => 'text', 'default_value' => '4. Suministro & Soporte', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_pstep4_desc', 'label' => __( 'Etapa 4: Descripción', 'mitsa' ), 'name' => 'process_step4_desc', 'type' => 'textarea', 'default_value' => 'Una vez elegida la opción, se procede al suministro, coordinación de entrega e inicio del plan de acompañamiento operativo.', 'rows' => 2, 'wrapper' => array( 'width' => '70' ),
				),

				// PESTAÑA 5: LLAMADO A LA ACCIÓN (CTA)
				array(
					'key'       => 'tab_servicios_cta',
					'label'     => __( '📢 Call to Action', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_servicios_cta_heading',
					'label'         => __( 'Título del Banner CTA', 'mitsa' ),
					'name'          => 'servicios_cta_heading',
					'type'          => 'text',
					'default_value' => '¿Tiene un proyecto naval o industrial en curso?',
				),
				array(
					'key'           => 'field_servicios_cta_desc',
					'label'         => __( 'Descripción del CTA', 'mitsa' ),
					'name'          => 'servicios_cta_desc',
					'type'          => 'textarea',
					'default_value' => 'Revise requerimientos de caudal, espacio y plazos de entrega directamente con nuestros ingenieros de aplicación.',
					'rows'          => 2,
				),
				array(
					'key'           => 'field_servicios_cta_btn1_label',
					'label'         => __( 'Botón Primario - Texto', 'mitsa' ),
					'name'          => 'servicios_cta_btn1_label',
					'type'          => 'text',
					'default_value' => 'Solicitar evaluación técnica',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_servicios_cta_btn1_url',
					'label'         => __( 'Botón Primario - URL', 'mitsa' ),
					'name'          => 'servicios_cta_btn1_url',
					'type'          => 'text',
					'default_value' => '/contacto/?tipo=evaluacion',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_servicios_cta_btn2_label',
					'label'         => __( 'Botón Secundario - Texto', 'mitsa' ),
					'name'          => 'servicios_cta_btn2_label',
					'type'          => 'text',
					'default_value' => 'Consultar repuestos',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_servicios_cta_btn2_url',
					'label'         => __( 'Botón Secundario - URL', 'mitsa' ),
					'name'          => 'servicios_cta_btn2_url',
					'type'          => 'text',
					'default_value' => '/contacto/?tipo=repuestos',
					'wrapper'       => array( 'width' => '50' ),
				),

				// PESTAÑA 6: SEO & OPEN GRAPH
				array(
					'key'       => 'tab_servicios_seo',
					'label'     => __( '🔍 SEO & Open Graph', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_servicios_seo_title',
					'label'         => __( 'Meta Título (SEO)', 'mitsa' ),
					'name'          => 'seo_meta_title',
					'type'          => 'text',
					'default_value' => 'Servicios de Ingeniería Marina, Suministro y Puesta en Marcha | MITSA',
				),
				array(
					'key'           => 'field_servicios_seo_desc',
					'label'         => __( 'Meta Descripción', 'mitsa' ),
					'name'          => 'seo_meta_description',
					'type'          => 'textarea',
					'default_value' => 'Servicios integrales de ingeniería marítima: dimensionamiento a bordo, suministro oficial, supervisión de montaje, comisionamiento, repuestos originales y soporte.',
					'rows'          => 3,
				),
				array(
					'key'           => 'field_servicios_seo_image',
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
						'value'    => '10', // ID de la página Servicios
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
	// GRUPO MAESTRO: ADMINISTRACIÓN DE PÁGINA "INDUSTRIAS / SECTORES"
	// =========================================================================
	acf_add_local_field_group(
		array(
			'key'                   => 'group_mitsa_industrias_master',
			'title'                 => __( 'Administración de Página "Industrias / Sectores" (MITSA)', 'mitsa' ),
			'fields'                => array(

				// PESTAÑA 1: HERO & BOTONES
				array(
					'key'       => 'tab_industrias_hero',
					'label'     => __( '🚀 Hero & Acciones', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_industrias_hero_title',
					'label'         => __( 'Título Principal (H1)', 'mitsa' ),
					'name'          => 'industrias_hero_title',
					'type'          => 'text',
					'default_value' => 'Cada industria exige una respuesta técnica distinta',
					'required'      => 1,
				),
				array(
					'key'           => 'field_industrias_hero_desc',
					'label'         => __( 'Descripción de Introducción', 'mitsa' ),
					'name'          => 'industrias_hero_desc',
					'type'          => 'textarea',
					'default_value' => 'La solución no la define el catálogo: la definen la normativa que aplica, la ventana de intervención disponible y qué pasa si el sistema se detiene.',
					'rows'          => 3,
					'required'      => 1,
				),
				array(
					'key'           => 'field_industrias_hero_btn1_label',
					'label'         => __( 'Botón 1 - Texto', 'mitsa' ),
					'name'          => 'industrias_hero_btn1_label',
					'type'          => 'text',
					'default_value' => 'Solicitar evaluación técnica',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_industrias_hero_btn1_url',
					'label'         => __( 'Botón 1 - URL', 'mitsa' ),
					'name'          => 'industrias_hero_btn1_url',
					'type'          => 'text',
					'default_value' => '/contacto/?tipo=evaluacion',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_industrias_hero_btn2_label',
					'label'         => __( 'Botón 2 - Texto', 'mitsa' ),
					'name'          => 'industrias_hero_btn2_label',
					'type'          => 'text',
					'default_value' => 'Ver sectores',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_industrias_hero_btn2_url',
					'label'         => __( 'Botón 2 - URL', 'mitsa' ),
					'name'          => 'industrias_hero_btn2_url',
					'type'          => 'text',
					'default_value' => '#sectores',
					'wrapper'       => array( 'width' => '50' ),
				),

				// PESTAÑA 2: SECTORES / INDUSTRIAS (6)
				array(
					'key'       => 'tab_industrias_sectors',
					'label'     => __( '🏭 Sectores (6 Industrias)', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				// Sector 1: Naval y Defensa
				array(
					'key' => 'field_ind1_id', 'label' => __( 'Sector 1: ID Anchor', 'mitsa' ), 'name' => 'ind1_id', 'type' => 'text', 'default_value' => 'naval', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_ind1_num', 'label' => __( 'Sector 1: Número', 'mitsa' ), 'name' => 'ind1_num', 'type' => 'text', 'default_value' => '01', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_ind1_title', 'label' => __( 'Sector 1: Título', 'mitsa' ), 'name' => 'ind1_title', 'type' => 'text', 'default_value' => 'Naval y defensa', 'wrapper' => array( 'width' => '60' ),
				),
				array(
					'key' => 'field_ind1_desc', 'label' => __( 'Sector 1: Descripción', 'mitsa' ), 'name' => 'ind1_desc', 'type' => 'textarea', 'default_value' => 'Fragatas, OPVs y patrulleras: construcción nueva, modernización y disponibilidad operacional bajo estrictos requisitos de clase militar.', 'rows' => 2,
				),
				array(
					'key' => 'field_ind1_tags', 'label' => __( 'Sector 1: Soluciones / Tags', 'mitsa' ), 'name' => 'ind1_tags', 'type' => 'text', 'default_value' => 'Sanitarios al vacío, ICCP, Aguas residuales, Agua dulce', 'wrapper' => array( 'width' => '60' ),
				),
				array(
					'key' => 'field_ind1_image', 'label' => __( 'Sector 1: Imagen', 'mitsa' ), 'name' => 'ind1_image', 'type' => 'image', 'return_format' => 'url', 'wrapper' => array( 'width' => '40' ),
				),
				// Sector 2: Acuicultura y Pesca
				array(
					'key' => 'field_ind2_id', 'label' => __( 'Sector 2: ID Anchor', 'mitsa' ), 'name' => 'ind2_id', 'type' => 'text', 'default_value' => 'acuicultura', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_ind2_num', 'label' => __( 'Sector 2: Número', 'mitsa' ), 'name' => 'ind2_num', 'type' => 'text', 'default_value' => '02', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_ind2_title', 'label' => __( 'Sector 2: Título', 'mitsa' ), 'name' => 'ind2_title', 'type' => 'text', 'default_value' => 'Acuicultura y pesca', 'wrapper' => array( 'width' => '60' ),
				),
				array(
					'key' => 'field_ind2_desc', 'label' => __( 'Sector 2: Descripción', 'mitsa' ), 'name' => 'ind2_desc', 'type' => 'textarea', 'default_value' => 'Wellboats, pontones y centros de cultivo con tripulación permanente y ventanas de mantenimiento sumamente acotadas.', 'rows' => 2,
				),
				array(
					'key' => 'field_ind2_tags', 'label' => __( 'Sector 2: Soluciones / Tags', 'mitsa' ), 'name' => 'ind2_tags', 'type' => 'text', 'default_value' => 'Sanitarios, Agua dulce, Repuestos, ICAF', 'wrapper' => array( 'width' => '60' ),
				),
				array(
					'key' => 'field_ind2_image', 'label' => __( 'Sector 2: Imagen', 'mitsa' ), 'name' => 'ind2_image', 'type' => 'image', 'return_format' => 'url', 'wrapper' => array( 'width' => '40' ),
				),
				// Sector 3: Offshore y Energía
				array(
					'key' => 'field_ind3_id', 'label' => __( 'Sector 3: ID Anchor', 'mitsa' ), 'name' => 'ind3_id', 'type' => 'text', 'default_value' => 'offshore', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_ind3_num', 'label' => __( 'Sector 3: Número', 'mitsa' ), 'name' => 'ind3_num', 'type' => 'text', 'default_value' => '03', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_ind3_title', 'label' => __( 'Sector 3: Título', 'mitsa' ), 'name' => 'ind3_title', 'type' => 'text', 'default_value' => 'Offshore y energía', 'wrapper' => array( 'width' => '60' ),
				),
				array(
					'key' => 'field_ind3_desc', 'label' => __( 'Sector 3: Descripción', 'mitsa' ), 'name' => 'ind3_desc', 'type' => 'textarea', 'default_value' => 'Plataformas y unidades de apoyo marítimo (PSV/AHTS) donde el espacio, el peso y la descarga de efluentes están fuertemente normados.', 'rows' => 2,
				),
				array(
					'key' => 'field_ind3_tags', 'label' => __( 'Sector 3: Soluciones / Tags', 'mitsa' ), 'name' => 'ind3_tags', 'type' => 'text', 'default_value' => 'BWTS, ICAF, Drenajes, Aguas residuales', 'wrapper' => array( 'width' => '60' ),
				),
				array(
					'key' => 'field_ind3_image', 'label' => __( 'Sector 3: Imagen', 'mitsa' ), 'name' => 'ind3_image', 'type' => 'image', 'return_format' => 'url', 'wrapper' => array( 'width' => '40' ),
				),
				// Sector 4: Astilleros y Reparación
				array(
					'key' => 'field_ind4_id', 'label' => __( 'Sector 4: ID Anchor', 'mitsa' ), 'name' => 'ind4_id', 'type' => 'text', 'default_value' => 'astilleros', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_ind4_num', 'label' => __( 'Sector 4: Número', 'mitsa' ), 'name' => 'ind4_num', 'type' => 'text', 'default_value' => '04', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_ind4_title', 'label' => __( 'Sector 4: Título', 'mitsa' ), 'name' => 'ind4_title', 'type' => 'text', 'default_value' => 'Astilleros y reparación', 'wrapper' => array( 'width' => '60' ),
				),
				array(
					'key' => 'field_ind4_desc', 'label' => __( 'Sector 4: Descripción', 'mitsa' ), 'name' => 'ind4_desc', 'type' => 'textarea', 'default_value' => 'Integración de sistemas durante construcción nueva o retrofit en dique seco, coordinado con la carta Gantt del astillero.', 'rows' => 2,
				),
				array(
					'key' => 'field_ind4_tags', 'label' => __( 'Sector 4: Soluciones / Tags', 'mitsa' ), 'name' => 'ind4_tags', 'type' => 'text', 'default_value' => 'Retrofit, Montaje, Puesta en marcha, Supervisión', 'wrapper' => array( 'width' => '60' ),
				),
				array(
					'key' => 'field_ind4_image', 'label' => __( 'Sector 4: Imagen', 'mitsa' ), 'name' => 'ind4_image', 'type' => 'image', 'return_format' => 'url', 'wrapper' => array( 'width' => '40' ),
				),
				// Sector 5: Transporte Marítimo y Carga
				array(
					'key' => 'field_ind5_id', 'label' => __( 'Sector 5: ID Anchor', 'mitsa' ), 'name' => 'ind5_id', 'type' => 'text', 'default_value' => 'carga', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_ind5_num', 'label' => __( 'Sector 5: Número', 'mitsa' ), 'name' => 'ind5_num', 'type' => 'text', 'default_value' => '05', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_ind5_title', 'label' => __( 'Sector 5: Título', 'mitsa' ), 'name' => 'ind5_title', 'type' => 'text', 'default_value' => 'Transporte marítimo y carga', 'wrapper' => array( 'width' => '60' ),
				),
				array(
					'key' => 'field_ind5_desc', 'label' => __( 'Sector 5: Descripción', 'mitsa' ), 'name' => 'ind5_desc', 'type' => 'textarea', 'default_value' => 'Flotas mercantes y portacontenedores que deben cumplir convenios MARPOL y agua de lastre D-2 sin alterar su itinerario.', 'rows' => 2,
				),
				array(
					'key' => 'field_ind5_tags', 'label' => __( 'Sector 5: Soluciones / Tags', 'mitsa' ), 'name' => 'ind5_tags', 'type' => 'text', 'default_value' => 'BWTS, Aguas residuales, Servicio a bordo, ICCP', 'wrapper' => array( 'width' => '60' ),
				),
				array(
					'key' => 'field_ind5_image', 'label' => __( 'Sector 5: Imagen', 'mitsa' ), 'name' => 'ind5_image', 'type' => 'image', 'return_format' => 'url', 'wrapper' => array( 'width' => '40' ),
				),
				// Sector 6: Instalaciones en Tierra y Minería
				array(
					'key' => 'field_ind6_id', 'label' => __( 'Sector 6: ID Anchor', 'mitsa' ), 'name' => 'ind6_id', 'type' => 'text', 'default_value' => 'tierra', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_ind6_num', 'label' => __( 'Sector 6: Número', 'mitsa' ), 'name' => 'ind6_num', 'type' => 'text', 'default_value' => '06', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_ind6_title', 'label' => __( 'Sector 6: Título', 'mitsa' ), 'name' => 'ind6_title', 'type' => 'text', 'default_value' => 'Instalaciones en tierra y minería', 'wrapper' => array( 'width' => '60' ),
				),
				array(
					'key' => 'field_ind6_desc', 'label' => __( 'Sector 6: Descripción', 'mitsa' ), 'name' => 'ind6_desc', 'type' => 'textarea', 'default_value' => 'Plantas industriales, faenas mineras y edificios donde no existe cota de pendiente para redes de evacuación por gravedad.', 'rows' => 2,
				),
				array(
					'key' => 'field_ind6_tags', 'label' => __( 'Sector 6: Soluciones / Tags', 'mitsa' ), 'name' => 'ind6_tags', 'type' => 'text', 'default_value' => 'Sanitarios al vacío, Drenajes inox, Agua caliente, Efluentes', 'wrapper' => array( 'width' => '60' ),
				),
				array(
					'key' => 'field_ind6_image', 'label' => __( 'Sector 6: Imagen', 'mitsa' ), 'name' => 'ind6_image', 'type' => 'image', 'return_format' => 'url', 'wrapper' => array( 'width' => '40' ),
				),

				// PESTAÑA 3: CRITERIOS DE INGENIERÍA
				array(
					'key'       => 'tab_industrias_criteria',
					'label'     => __( '📐 Criterios Técnicos', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_crit_heading',
					'label'         => __( 'Título de Sección (H2)', 'mitsa' ),
					'name'          => 'criteria_heading',
					'type'          => 'text',
					'default_value' => 'Criterios de ingeniería por industria',
				),
				array(
					'key'           => 'field_crit_subheading',
					'label'         => __( 'Subtítulo', 'mitsa' ),
					'name'          => 'criteria_subheading',
					'type'          => 'textarea',
					'default_value' => 'Variables críticas de diseño que evalúan nuestros ingenieros de aplicación para cada tipo de instalación.',
					'rows'          => 2,
				),
				// Criterio 1
				array(
					'key' => 'field_crit1_title', 'label' => __( 'Criterio 1: Título', 'mitsa' ), 'name' => 'crit1_title', 'type' => 'text', 'default_value' => 'Normativa y Certificaciones de Clase', 'wrapper' => array( 'width' => '40' ),
				),
				array(
					'key' => 'field_crit1_desc', 'label' => __( 'Criterio 1: Descripción', 'mitsa' ), 'name' => 'crit1_desc', 'type' => 'textarea', 'default_value' => 'Cumplimiento estricto con IMO MARPOL (Anexo IV y D-2), SOLAS, USCG y casas clasificadoras (DNV, Lloyd\'s Register, ABS).', 'rows' => 2, 'wrapper' => array( 'width' => '60' ),
				),
				// Criterio 2
				array(
					'key' => 'field_crit2_title', 'label' => __( 'Criterio 2: Título', 'mitsa' ), 'name' => 'crit2_title', 'type' => 'text', 'default_value' => 'Ventanas de Intervención en Faena', 'wrapper' => array( 'width' => '40' ),
				),
				array(
					'key' => 'field_crit2_desc', 'label' => __( 'Criterio 2: Descripción', 'mitsa' ), 'name' => 'crit2_desc', 'type' => 'textarea', 'default_value' => 'Coordinación con recaladas acotadas, diques secos y paradas de planta programadas para evitar sobrecostos por detención.', 'rows' => 2, 'wrapper' => array( 'width' => '60' ),
				),
				// Criterio 3
				array(
					'key' => 'field_crit3_title', 'label' => __( 'Criterio 3: Título', 'mitsa' ), 'name' => 'crit3_title', 'type' => 'text', 'default_value' => 'Redundancia y Continuidad Operativa', 'wrapper' => array( 'width' => '40' ),
				),
				array(
					'key' => 'field_crit3_desc', 'label' => __( 'Criterio 3: Descripción', 'mitsa' ), 'name' => 'crit3_desc', 'type' => 'textarea', 'default_value' => 'Diseño con bombas duplicadas, módulos en standby y repuestos críticos garantizados por el fabricante.', 'rows' => 2, 'wrapper' => array( 'width' => '60' ),
				),
				// Criterio 4
				array(
					'key' => 'field_crit4_title', 'label' => __( 'Criterio 4: Título', 'mitsa' ), 'name' => 'crit4_title', 'type' => 'text', 'default_value' => 'Eficiencia Hídrica y Energética', 'wrapper' => array( 'width' => '40' ),
				),
				array(
					'key' => 'field_crit4_desc', 'label' => __( 'Criterio 4: Descripción', 'mitsa' ), 'name' => 'crit4_desc', 'type' => 'textarea', 'default_value' => 'Reducción de consumo de agua hasta un 90% mediante sistemas al vacío e intercambiadores térmicos de alta eficiencia.', 'rows' => 2, 'wrapper' => array( 'width' => '60' ),
				),

				// PESTAÑA 4: CALL TO ACTION
				array(
					'key'       => 'tab_industrias_cta',
					'label'     => __( '📢 Call to Action', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_industrias_cta_heading',
					'label'         => __( 'Título del Banner CTA', 'mitsa' ),
					'name'          => 'industrias_cta_heading',
					'type'          => 'text',
					'default_value' => '¿Necesita dimensionar una solución para su sector?',
				),
				array(
					'key'           => 'field_industrias_cta_desc',
					'label'         => __( 'Descripción del CTA', 'mitsa' ),
					'name'          => 'industrias_cta_desc',
					'type'          => 'textarea',
					'default_value' => 'Nuestros ingenieros evalúan requerimientos específicos de espacio, caudal y normativas aplicables a su industria.',
					'rows'          => 2,
				),
				array(
					'key'           => 'field_industrias_cta_btn_label',
					'label'         => __( 'Botón - Texto', 'mitsa' ),
					'name'          => 'industrias_cta_btn_label',
					'type'          => 'text',
					'default_value' => 'Contactar a ingeniería de aplicación',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_industrias_cta_btn_url',
					'label'         => __( 'Botón - URL', 'mitsa' ),
					'name'          => 'industrias_cta_btn_url',
					'type'          => 'text',
					'default_value' => '/contacto/?tipo=evaluacion',
					'wrapper'       => array( 'width' => '50' ),
				),

				// PESTAÑA 5: SEO & OPEN GRAPH
				array(
					'key'       => 'tab_industrias_seo',
					'label'     => __( '🔍 SEO & Open Graph', 'mitsa' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'           => 'field_industrias_seo_title',
					'label'         => __( 'Meta Título (SEO)', 'mitsa' ),
					'name'          => 'seo_meta_title',
					'type'          => 'text',
					'default_value' => 'Sectores e Industrias · Soluciones Navales, Acuícolas e Industriales | MITSA',
				),
				array(
					'key'           => 'field_industrias_seo_desc',
					'label'         => __( 'Meta Descripción', 'mitsa' ),
					'name'          => 'seo_meta_description',
					'type'          => 'textarea',
					'default_value' => 'Soluciones de ingeniería naval, sanitaria y ambiental por sector: Naval & Defensa, Astilleros, Acuicultura, Offshore, Transporte Marítimo e Instalaciones en Tierra.',
					'rows'          => 3,
				),
				array(
					'key'           => 'field_industrias_seo_image',
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
						'value'    => '9', // ID de la página Industrias
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

	// ==========================================
	// GRUPO 6: PÁGINA "PROYECTOS" (Post ID 401)
	// ==========================================
	acf_add_local_field_group(
		array(
			'key'                   => 'group_mitsa_proyectos_master',
			'title'                 => __( 'Administración de Página "Proyectos" (MITSA)', 'mitsa' ),
			'fields'                => array(
				// TAB 1: HERO & MÉTRICAS
				array(
					'key'   => 'tab_proy_hero',
					'label' => __( '🚀 Hero & Métricas', 'mitsa' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_mitsa_proy_hero_title',
					'label'         => __( 'Título Principal (H1)', 'mitsa' ),
					'name'          => 'proyectos_hero_title',
					'type'          => 'text',
					'default_value' => 'Lo que ya está instalado y operando.',
				),
				array(
					'key'           => 'field_mitsa_proy_hero_desc',
					'label'         => __( 'Bajada / Descripción', 'mitsa' ),
					'name'          => 'proyectos_hero_desc',
					'type'          => 'textarea',
					'default_value' => 'Cada proyecto publica el sistema, la industria y el fabricante detrás. Casos reales y representativos respaldados por 40 años de trayectoria.',
					'rows'          => 3,
				),
				array(
					'key'           => 'field_mitsa_proy_hero_img',
					'label'         => __( 'Imagen Destacada Hero', 'mitsa' ),
					'name'          => 'proyectos_hero_img',
					'type'          => 'image',
					'return_format' => 'url',
					'default_value' => '/images/proyectos-img-2-149f33fe.jpg',
				),
				array(
					'key'           => 'field_mitsa_proy_btn1_label',
					'label'         => __( 'Botón 1: Texto', 'mitsa' ),
					'name'          => 'proyectos_btn1_label',
					'type'          => 'text',
					'default_value' => 'Ver proyectos',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_proy_btn1_url',
					'label'         => __( 'Botón 1: Enlace', 'mitsa' ),
					'name'          => 'proyectos_btn1_url',
					'type'          => 'text',
					'default_value' => '#catalogo-proyectos',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_proy_btn2_label',
					'label'         => __( 'Botón 2: Texto', 'mitsa' ),
					'name'          => 'proyectos_btn2_label',
					'type'          => 'text',
					'default_value' => 'Solicitar referencias',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_proy_btn2_url',
					'label'         => __( 'Botón 2: Enlace', 'mitsa' ),
					'name'          => 'proyectos_btn2_url',
					'type'          => 'text',
					'default_value' => '/contacto/?tipo=evaluacion',
					'wrapper'       => array( 'width' => '50' ),
				),
				// Métricas
				array(
					'key'           => 'field_mitsa_proy_m1_num',
					'label'         => __( 'Métrica 1: Cifra', 'mitsa' ),
					'name'          => 'proyectos_m1_num',
					'type'          => 'text',
					'default_value' => '40+',
					'wrapper'       => array( 'width' => '30' ),
				),
				array(
					'key'           => 'field_mitsa_proy_m1_label',
					'label'         => __( 'Métrica 1: Etiqueta', 'mitsa' ),
					'name'          => 'proyectos_m1_label',
					'type'          => 'text',
					'default_value' => 'años integrando sistemas en Chile',
					'wrapper'       => array( 'width' => '70' ),
				),
				array(
					'key'           => 'field_mitsa_proy_m2_num',
					'label'         => __( 'Métrica 2: Cifra', 'mitsa' ),
					'name'          => 'proyectos_m2_num',
					'type'          => 'text',
					'default_value' => '10',
					'wrapper'       => array( 'width' => '30' ),
				),
				array(
					'key'           => 'field_mitsa_proy_m2_label',
					'label'         => __( 'Métrica 2: Etiqueta', 'mitsa' ),
					'name'          => 'proyectos_m2_label',
					'type'          => 'text',
					'default_value' => 'líneas de solución en operación',
					'wrapper'       => array( 'width' => '70' ),
				),
				array(
					'key'           => 'field_mitsa_proy_m3_num',
					'label'         => __( 'Métrica 3: Cifra', 'mitsa' ),
					'name'          => 'proyectos_m3_num',
					'type'          => 'text',
					'default_value' => '100%',
					'wrapper'       => array( 'width' => '30' ),
				),
				array(
					'key'           => 'field_mitsa_proy_m3_label',
					'label'         => __( 'Métrica 3: Etiqueta', 'mitsa' ),
					'name'          => 'proyectos_m3_label',
					'type'          => 'text',
					'default_value' => 'cumplimiento en protocolos y pruebas de mar',
					'wrapper'       => array( 'width' => '70' ),
				),

				// TAB 2: CASOS DE ÉXITO (6 PROYECTOS)
				array(
					'key'   => 'tab_proy_cases',
					'label' => __( '🏗️ Casos de Éxito (6)', 'mitsa' ),
					'type'  => 'tab',
				),
				// Proyecto 1
				array(
					'key' => 'field_mitsa_pcase1_num', 'label' => __( 'Caso 1: N°', 'mitsa' ), 'name' => 'pcase1_num', 'type' => 'text', 'default_value' => '01', 'wrapper' => array( 'width' => '15' ),
				),
				array(
					'key' => 'field_mitsa_pcase1_sector', 'label' => __( 'Caso 1: Sector', 'mitsa' ), 'name' => 'pcase1_sector', 'type' => 'text', 'default_value' => 'Astillero', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_pcase1_title', 'label' => __( 'Caso 1: Título', 'mitsa' ), 'name' => 'pcase1_title', 'type' => 'text', 'default_value' => 'Astillero — Construcción nueva', 'wrapper' => array( 'width' => '60' ),
				),
				array(
					'key' => 'field_mitsa_pcase1_desc', 'label' => __( 'Caso 1: Descripción', 'mitsa' ), 'name' => 'pcase1_desc', 'type' => 'textarea', 'default_value' => 'Sistema sanitario al vacío completo para una unidad en construcción, dimensionado antes del corte de primera plancha de acero.', 'rows' => 2, 'wrapper' => array( 'width' => '50' ),
				),
				array(
					'key' => 'field_mitsa_pcase1_tags', 'label' => __( 'Caso 1: Tags (separados por coma)', 'mitsa' ), 'name' => 'pcase1_tags', 'type' => 'text', 'default_value' => 'Astillero, Sanitarios al vacío, EVAC', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_pcase1_image', 'label' => __( 'Caso 1: Imagen', 'mitsa' ), 'name' => 'pcase1_image', 'type' => 'image', 'return_format' => 'url', 'wrapper' => array( 'width' => '25' ),
				),
				// Proyecto 2
				array(
					'key' => 'field_mitsa_pcase2_num', 'label' => __( 'Caso 2: N°', 'mitsa' ), 'name' => 'pcase2_num', 'type' => 'text', 'default_value' => '02', 'wrapper' => array( 'width' => '15' ),
				),
				array(
					'key' => 'field_mitsa_pcase2_sector', 'label' => __( 'Caso 2: Sector', 'mitsa' ), 'name' => 'pcase2_sector', 'type' => 'text', 'default_value' => 'Buques de apoyo', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_pcase2_title', 'label' => __( 'Caso 2: Título', 'mitsa' ), 'name' => 'pcase2_title', 'type' => 'text', 'default_value' => 'Buque de apoyo (PSV) — Retrofit', 'wrapper' => array( 'width' => '60' ),
				),
				array(
					'key' => 'field_mitsa_pcase2_desc', 'label' => __( 'Caso 2: Descripción', 'mitsa' ), 'name' => 'pcase2_desc', 'type' => 'textarea', 'default_value' => 'Reemplazo integral de la planta de tratamiento de aguas servidas con la nave en operación, sin alterar la red troncal existente.', 'rows' => 2, 'wrapper' => array( 'width' => '50' ),
				),
				array(
					'key' => 'field_mitsa_pcase2_tags', 'label' => __( 'Caso 2: Tags (separados por coma)', 'mitsa' ), 'name' => 'pcase2_tags', 'type' => 'text', 'default_value' => 'Buques de apoyo, Aguas residuales, EVAC · BLÜCHER', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_pcase2_image', 'label' => __( 'Caso 2: Imagen', 'mitsa' ), 'name' => 'pcase2_image', 'type' => 'image', 'return_format' => 'url', 'wrapper' => array( 'width' => '25' ),
				),
				// Proyecto 3
				array(
					'key' => 'field_mitsa_pcase3_num', 'label' => __( 'Caso 3: N°', 'mitsa' ), 'name' => 'pcase3_num', 'type' => 'text', 'default_value' => '03', 'wrapper' => array( 'width' => '15' ),
				),
				array(
					'key' => 'field_mitsa_pcase3_sector', 'label' => __( 'Caso 3: Sector', 'mitsa' ), 'name' => 'pcase3_sector', 'type' => 'text', 'default_value' => 'Offshore', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_pcase3_title', 'label' => __( 'Caso 3: Título', 'mitsa' ), 'name' => 'pcase3_title', 'type' => 'text', 'default_value' => 'Plataforma offshore — Protección catódica', 'wrapper' => array( 'width' => '60' ),
				),
				array(
					'key' => 'field_mitsa_pcase3_desc', 'label' => __( 'Caso 3: Descripción', 'mitsa' ), 'name' => 'pcase3_desc', 'type' => 'textarea', 'default_value' => 'Protección catódica por corriente impresa (ICCP) y control de bioincrustación (ICAF) en estructura fija con monitoreo automático continuo.', 'rows' => 2, 'wrapper' => array( 'width' => '50' ),
				),
				array(
					'key' => 'field_mitsa_pcase3_tags', 'label' => __( 'Caso 3: Tags (separados por coma)', 'mitsa' ), 'name' => 'pcase3_tags', 'type' => 'text', 'default_value' => 'Offshore, ICCP · ICAF, Cathelco', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_pcase3_image', 'label' => __( 'Caso 3: Imagen', 'mitsa' ), 'name' => 'pcase3_image', 'type' => 'image', 'return_format' => 'url', 'wrapper' => array( 'width' => '25' ),
				),
				// Proyecto 4
				array(
					'key' => 'field_mitsa_pcase4_num', 'label' => __( 'Caso 4: N°', 'mitsa' ), 'name' => 'pcase4_num', 'type' => 'text', 'default_value' => '04', 'wrapper' => array( 'width' => '15' ),
				),
				array(
					'key' => 'field_mitsa_pcase4_sector', 'label' => __( 'Caso 4: Sector', 'mitsa' ), 'name' => 'pcase4_sector', 'type' => 'text', 'default_value' => 'Acuicultura', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_pcase4_title', 'label' => __( 'Caso 4: Título', 'mitsa' ), 'name' => 'pcase4_title', 'type' => 'text', 'default_value' => 'Centro de cultivo — Pontón habitable', 'wrapper' => array( 'width' => '60' ),
				),
				array(
					'key' => 'field_mitsa_pcase4_desc', 'label' => __( 'Caso 4: Descripción', 'mitsa' ), 'name' => 'pcase4_desc', 'type' => 'textarea', 'default_value' => 'Tratamiento de efluentes y saneamiento integral en pontón habitable con logística y soporte de repuestos en la Región de Los Lagos.', 'rows' => 2, 'wrapper' => array( 'width' => '50' ),
				),
				array(
					'key' => 'field_mitsa_pcase4_tags', 'label' => __( 'Caso 4: Tags (separados por coma)', 'mitsa' ), 'name' => 'pcase4_tags', 'type' => 'text', 'default_value' => 'Acuicultura, Tratamiento de aguas, ERMA FIRST', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_pcase4_image', 'label' => __( 'Caso 4: Imagen', 'mitsa' ), 'name' => 'pcase4_image', 'type' => 'image', 'return_format' => 'url', 'wrapper' => array( 'width' => '25' ),
				),
				// Proyecto 5
				array(
					'key' => 'field_mitsa_pcase5_num', 'label' => __( 'Caso 5: N°', 'mitsa' ), 'name' => 'pcase5_num', 'type' => 'text', 'default_value' => '05', 'wrapper' => array( 'width' => '15' ),
				),
				array(
					'key' => 'field_mitsa_pcase5_sector', 'label' => __( 'Caso 5: Sector', 'mitsa' ), 'name' => 'pcase5_sector', 'type' => 'text', 'default_value' => 'Pesca', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_pcase5_title', 'label' => __( 'Caso 5: Título', 'mitsa' ), 'name' => 'pcase5_title', 'type' => 'text', 'default_value' => 'Flota pesquera — Redes al vacío continuas', 'wrapper' => array( 'width' => '60' ),
				),
				array(
					'key' => 'field_mitsa_pcase5_desc', 'label' => __( 'Caso 5: Descripción', 'mitsa' ), 'name' => 'pcase5_desc', 'type' => 'textarea', 'default_value' => 'Modernización de sistemas sanitarios y drenajes inoxidables en flota de alta mar para operaciones continuas en aguas frías.', 'rows' => 2, 'wrapper' => array( 'width' => '50' ),
				),
				array(
					'key' => 'field_mitsa_pcase5_tags', 'label' => __( 'Caso 5: Tags (separados por coma)', 'mitsa' ), 'name' => 'pcase5_tags', 'type' => 'text', 'default_value' => 'Pesca industrial, Vacío marino, BLÜCHER · EVAC', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_pcase5_image', 'label' => __( 'Caso 5: Imagen', 'mitsa' ), 'name' => 'pcase5_image', 'type' => 'image', 'return_format' => 'url', 'wrapper' => array( 'width' => '25' ),
				),
				// Proyecto 6
				array(
					'key' => 'field_mitsa_pcase6_num', 'label' => __( 'Caso 6: N°', 'mitsa' ), 'name' => 'pcase6_num', 'type' => 'text', 'default_value' => '06', 'wrapper' => array( 'width' => '15' ),
				),
				array(
					'key' => 'field_mitsa_pcase6_sector', 'label' => __( 'Caso 6: Sector', 'mitsa' ), 'name' => 'pcase6_sector', 'type' => 'text', 'default_value' => 'Minería e Industria', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_pcase6_title', 'label' => __( 'Caso 6: Título', 'mitsa' ), 'name' => 'pcase6_title', 'type' => 'text', 'default_value' => 'Campamento minero — Evacuación sin pendiente', 'wrapper' => array( 'width' => '60' ),
				),
				array(
					'key' => 'field_mitsa_pcase6_desc', 'label' => __( 'Caso 6: Descripción', 'mitsa' ), 'name' => 'pcase6_desc', 'type' => 'textarea', 'default_value' => 'Red de vacío en terreno plano para campamento en altura geográfica, eliminando excavaciones profundas y optimizando consumo de agua.', 'rows' => 2, 'wrapper' => array( 'width' => '50' ),
				),
				array(
					'key' => 'field_mitsa_pcase6_tags', 'label' => __( 'Caso 6: Tags (separados por coma)', 'mitsa' ), 'name' => 'pcase6_tags', 'type' => 'text', 'default_value' => 'Minería, Drenajes, EVAC · BLÜCHER', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_pcase6_image', 'label' => __( 'Caso 6: Imagen', 'mitsa' ), 'name' => 'pcase6_image', 'type' => 'image', 'return_format' => 'url', 'wrapper' => array( 'width' => '25' ),
				),

				// TAB 3: METODOLOGÍA
				array(
					'key'   => 'tab_proy_method',
					'label' => __( '📋 Metodología de Ejecución', 'mitsa' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_mitsa_proy_method_heading',
					'label'         => __( 'Título de Metodología', 'mitsa' ),
					'name'          => 'proyectos_method_heading',
					'type'          => 'text',
					'default_value' => '¿Cómo ejecutamos cada proyecto?',
				),
				array(
					'key'           => 'field_mitsa_proy_method_desc',
					'label'         => __( 'Bajada de Metodología', 'mitsa' ),
					'name'          => 'proyectos_method_desc',
					'type'          => 'textarea',
					'default_value' => 'Desde la ingeniería de preventa hasta las pruebas de mar y el soporte postventa a largo plazo.',
					'rows'          => 2,
				),
				array(
					'key' => 'field_mitsa_meth1_title', 'label' => __( 'Etapa 1: Título', 'mitsa' ), 'name' => 'meth1_title', 'type' => 'text', 'default_value' => '1. Levantamiento & Viabilidad', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_mitsa_meth1_desc', 'label' => __( 'Etapa 1: Descripción', 'mitsa' ), 'name' => 'meth1_desc', 'type' => 'text', 'default_value' => 'Evaluación de planos, requerimientos de caudal, consumo energético y espacios disponibles en la nave o instalación.', 'wrapper' => array( 'width' => '70' ),
				),
				array(
					'key' => 'field_mitsa_meth2_title', 'label' => __( 'Etapa 2: Título', 'mitsa' ), 'name' => 'meth2_title', 'type' => 'text', 'default_value' => '2. Ingeniería & Suministro', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_mitsa_meth2_desc', 'label' => __( 'Etapa 2: Descripción', 'mitsa' ), 'name' => 'meth2_desc', 'type' => 'text', 'default_value' => 'Selección directa con los fabricantes representados y coordinación de plazos de entrega en puerto o faena.', 'wrapper' => array( 'width' => '70' ),
				),
				array(
					'key' => 'field_mitsa_meth3_title', 'label' => __( 'Etapa 3: Título', 'mitsa' ), 'name' => 'meth3_title', 'type' => 'text', 'default_value' => '3. Supervisión & Puesta en Marcha', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_mitsa_meth3_desc', 'label' => __( 'Etapa 3: Descripción', 'mitsa' ), 'name' => 'meth3_desc', 'type' => 'text', 'default_value' => 'Acompañamiento en dique seco o terreno por ingenieros certificados para pruebas FAT/HAT y comisionamiento.', 'wrapper' => array( 'width' => '70' ),
				),
				array(
					'key' => 'field_mitsa_meth4_title', 'label' => __( 'Etapa 4: Título', 'mitsa' ), 'name' => 'meth4_title', 'type' => 'text', 'default_value' => '4. Garantía & Soporte Continuo', 'wrapper' => array( 'width' => '30' ),
				),
				array(
					'key' => 'field_mitsa_meth4_desc', 'label' => __( 'Etapa 4: Descripción', 'mitsa' ), 'name' => 'meth4_desc', 'type' => 'text', 'default_value' => 'Entrega de protocolos a inspectores de clase, capacitación a tripulación y provisión continua de repuestos originales.', 'wrapper' => array( 'width' => '70' ),
				),

				// TAB 4: CTA
				array(
					'key'   => 'tab_proy_cta',
					'label' => __( '📢 Call to Action', 'mitsa' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_mitsa_proy_cta_heading',
					'label'         => __( 'Título de Llamado a la Acción', 'mitsa' ),
					'name'          => 'proyectos_cta_heading',
					'type'          => 'text',
					'default_value' => '¿Tiene un proyecto naval o industrial en evaluación?',
				),
				array(
					'key'           => 'field_mitsa_proy_cta_desc',
					'label'         => __( 'Descripción del CTA', 'mitsa' ),
					'name'          => 'proyectos_cta_desc',
					'type'          => 'textarea',
					'default_value' => 'Podemos compartir casos técnicos de referencia similares y coordinar una reunión con nuestros ingenieros de aplicación.',
					'rows'          => 2,
				),
				array(
					'key'           => 'field_mitsa_proy_cta_btn_label',
					'label'         => __( 'Texto del Botón', 'mitsa' ),
					'name'          => 'proyectos_cta_btn_label',
					'type'          => 'text',
					'default_value' => 'Solicitar referencias de ingeniería',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_proy_cta_btn_url',
					'label'         => __( 'Enlace del Botón', 'mitsa' ),
					'name'          => 'proyectos_cta_btn_url',
					'type'          => 'text',
					'default_value' => '/contacto/?tipo=evaluacion',
					'wrapper'       => array( 'width' => '50' ),
				),

				// TAB 5: SEO
				array(
					'key'   => 'tab_proy_seo',
					'label' => __( '🔍 SEO & Open Graph', 'mitsa' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_mitsa_proy_seo_meta_title',
					'label'         => __( 'Meta Title', 'mitsa' ),
					'name'          => 'seo_meta_title',
					'type'          => 'text',
					'default_value' => 'Proyectos & Casos de Éxito · Casos de Ingeniería en Chile y Latinoamérica | MITSA',
				),
				array(
					'key'           => 'field_mitsa_proy_seo_meta_desc',
					'label'         => __( 'Meta Description', 'mitsa' ),
					'name'          => 'seo_meta_description',
					'type'          => 'textarea',
					'default_value' => 'Casos representativos de ingeniería naval y ambiental instalados y operando en Chile: Armada, astilleros, navieras, minería y acuicultura.',
					'rows'          => 2,
				),
				array(
					'key'           => 'field_mitsa_proy_seo_og_image',
					'label'         => __( 'Imagen Open Graph', 'mitsa' ),
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
						'value'    => '401', // ID de la página Proyectos
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

	// ==========================================
	// GRUPO 7: PÁGINA "RECURSOS" (Post ID 402)
	// ==========================================
	acf_add_local_field_group(
		array(
			'key'                   => 'group_mitsa_recursos_master',
			'title'                 => __( 'Administración de Página "Recursos" (MITSA)', 'mitsa' ),
			'fields'                => array(
				// TAB 1: HERO
				array(
					'key'   => 'tab_rec_hero',
					'label' => __( '🚀 Hero & Accesos', 'mitsa' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_mitsa_rec_hero_title',
					'label'         => __( 'Título Principal (H1)', 'mitsa' ),
					'name'          => 'recursos_hero_title',
					'type'          => 'text',
					'default_value' => 'El criterio técnico, publicado.',
				),
				array(
					'key'           => 'field_mitsa_rec_hero_desc',
					'label'         => __( 'Bajada / Descripción', 'mitsa' ),
					'name'          => 'recursos_hero_desc',
					'type'          => 'textarea',
					'default_value' => 'Artículos abiertos sobre normativa marítima, documentación técnica de representadas y protocolos de ingeniería para clientes.',
					'rows'          => 3,
				),
				array(
					'key'           => 'field_mitsa_rec_hero_img',
					'label'         => __( 'Imagen Destacada Hero', 'mitsa' ),
					'name'          => 'recursos_hero_img',
					'type'          => 'image',
					'return_format' => 'url',
					'default_value' => '/images/recursos-img-2-92bb5d09.jpg',
				),
				array(
					'key'           => 'field_mitsa_rec_btn1_label',
					'label'         => __( 'Botón 1: Texto', 'mitsa' ),
					'name'          => 'recursos_btn1_label',
					'type'          => 'text',
					'default_value' => 'Ver artículos técnicos',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_rec_btn1_url',
					'label'         => __( 'Botón 1: Enlace', 'mitsa' ),
					'name'          => 'recursos_btn1_url',
					'type'          => 'text',
					'default_value' => '#articulos',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_rec_btn2_label',
					'label'         => __( 'Botón 2: Texto', 'mitsa' ),
					'name'          => 'recursos_btn2_label',
					'type'          => 'text',
					'default_value' => 'Biblioteca de descargas',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_rec_btn2_url',
					'label'         => __( 'Botón 2: Enlace', 'mitsa' ),
					'name'          => 'recursos_btn2_url',
					'type'          => 'text',
					'default_value' => '#biblioteca',
					'wrapper'       => array( 'width' => '50' ),
				),

				// TAB 2: GATEWAYS
				array(
					'key'   => 'tab_rec_gateways',
					'label' => __( '📚 Portales de Acceso (2)', 'mitsa' ),
					'type'  => 'tab',
				),
				// Gateway 1
				array(
					'key'           => 'field_mitsa_gw1_badge',
					'label'         => __( 'Portal 1: Etiqueta / Badge', 'mitsa' ),
					'name'          => 'gw1_badge',
					'type'          => 'text',
					'default_value' => 'Centro Técnico',
					'wrapper'       => array( 'width' => '30' ),
				),
				array(
					'key'           => 'field_mitsa_gw1_title',
					'label'         => __( 'Portal 1: Título', 'mitsa' ),
					'name'          => 'gw1_title',
					'type'          => 'text',
					'default_value' => 'Cómo se decide un sistema a bordo',
					'wrapper'       => array( 'width' => '70' ),
				),
				array(
					'key'           => 'field_mitsa_gw1_desc',
					'label'         => __( 'Portal 1: Descripción', 'mitsa' ),
					'name'          => 'gw1_desc',
					'type'          => 'textarea',
					'default_value' => 'Artículos abiertos sobre dimensionamiento, normativa OMI, DIRECTEMAR y mejores prácticas de mantenimiento preventivo.',
					'rows'          => 2,
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_gw1_link_label',
					'label'         => __( 'Portal 1: Texto Enlace', 'mitsa' ),
					'name'          => 'gw1_link_label',
					'type'          => 'text',
					'default_value' => 'Ver artículos técnicos →',
					'wrapper'       => array( 'width' => '25' ),
				),
				array(
					'key'           => 'field_mitsa_gw1_link_url',
					'label'         => __( 'Portal 1: URL Enlace', 'mitsa' ),
					'name'          => 'gw1_link_url',
					'type'          => 'text',
					'default_value' => '#articulos',
					'wrapper'       => array( 'width' => '25' ),
				),
				// Gateway 2
				array(
					'key'           => 'field_mitsa_gw2_badge',
					'label'         => __( 'Portal 2: Etiqueta / Badge', 'mitsa' ),
					'name'          => 'gw2_badge',
					'type'          => 'text',
					'default_value' => 'Biblioteca Técnica',
					'wrapper'       => array( 'width' => '30' ),
				),
				array(
					'key'           => 'field_mitsa_gw2_title',
					'label'         => __( 'Portal 2: Título', 'mitsa' ),
					'name'          => 'gw2_title',
					'type'          => 'text',
					'default_value' => 'Fichas, manuales y protocolos',
					'wrapper'       => array( 'width' => '70' ),
				),
				array(
					'key'           => 'field_mitsa_gw2_desc',
					'label'         => __( 'Portal 2: Descripción', 'mitsa' ),
					'name'          => 'gw2_desc',
					'type'          => 'textarea',
					'default_value' => 'Documentación de las representadas oficiales (EVAC, Cathelco, ERMA FIRST, EPE, BLÜCHER), organizada por equipo.',
					'rows'          => 2,
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_gw2_link_label',
					'label'         => __( 'Portal 2: Texto Enlace', 'mitsa' ),
					'name'          => 'gw2_link_label',
					'type'          => 'text',
					'default_value' => 'Entrar a la biblioteca →',
					'wrapper'       => array( 'width' => '25' ),
				),
				array(
					'key'           => 'field_mitsa_gw2_link_url',
					'label'         => __( 'Portal 2: URL Enlace', 'mitsa' ),
					'name'          => 'gw2_link_url',
					'type'          => 'text',
					'default_value' => '#biblioteca',
					'wrapper'       => array( 'width' => '25' ),
				),

				// TAB 3: DESCARGAS (5 DOCUMENTOS)
				array(
					'key'   => 'tab_rec_downloads',
					'label' => __( '📥 Descargas (5)', 'mitsa' ),
					'type'  => 'tab',
				),
				// Doc 1
				array(
					'key' => 'field_mitsa_doc1_title', 'label' => __( 'Doc 1: Título', 'mitsa' ), 'name' => 'doc1_title', 'type' => 'text', 'default_value' => 'Catálogo General de Soluciones MITSA 2026', 'wrapper' => array( 'width' => '40' ),
				),
				array(
					'key' => 'field_mitsa_doc1_format', 'label' => __( 'Doc 1: Formato / Tamaño', 'mitsa' ), 'name' => 'doc1_format', 'type' => 'text', 'default_value' => 'PDF · 4.2 MB', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_doc1_level', 'label' => __( 'Doc 1: Nivel de Acceso', 'mitsa' ), 'name' => 'doc1_level', 'type' => 'text', 'default_value' => 'Descarga Libre', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_doc1_url', 'label' => __( 'Doc 1: URL / Archivo', 'mitsa' ), 'name' => 'doc1_url', 'type' => 'text', 'default_value' => '/docs/brochure-extracto.pdf', 'wrapper' => array( 'width' => '20' ),
				),
				// Doc 2
				array(
					'key' => 'field_mitsa_doc2_title', 'label' => __( 'Doc 2: Título', 'mitsa' ), 'name' => 'doc2_title', 'type' => 'text', 'default_value' => 'Ficha Técnica — Sistema Sanitario al Vacío EVAC', 'wrapper' => array( 'width' => '40' ),
				),
				array(
					'key' => 'field_mitsa_doc2_format', 'label' => __( 'Doc 2: Formato / Tamaño', 'mitsa' ), 'name' => 'doc2_format', 'type' => 'text', 'default_value' => 'PDF · 1.8 MB', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_doc2_level', 'label' => __( 'Doc 2: Nivel de Acceso', 'mitsa' ), 'name' => 'doc2_level', 'type' => 'text', 'default_value' => 'Acceso Libre', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_doc2_url', 'label' => __( 'Doc 2: URL / Archivo', 'mitsa' ), 'name' => 'doc2_url', 'type' => 'text', 'default_value' => '/contacto/?tipo=evaluacion', 'wrapper' => array( 'width' => '20' ),
				),
				// Doc 3
				array(
					'key' => 'field_mitsa_doc3_title', 'label' => __( 'Doc 3: Título', 'mitsa' ), 'name' => 'doc3_title', 'type' => 'text', 'default_value' => 'Manual de Operación de Plantas de Tratamiento de Aguas Servidas', 'wrapper' => array( 'width' => '40' ),
				),
				array(
					'key' => 'field_mitsa_doc3_format', 'label' => __( 'Doc 3: Formato / Tamaño', 'mitsa' ), 'name' => 'doc3_format', 'type' => 'text', 'default_value' => 'PDF · 3.1 MB', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_doc3_level', 'label' => __( 'Doc 3: Nivel de Acceso', 'mitsa' ), 'name' => 'doc3_level', 'type' => 'text', 'default_value' => 'Clientes / Registro', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_doc3_url', 'label' => __( 'Doc 3: URL / Archivo', 'mitsa' ), 'name' => 'doc3_url', 'type' => 'text', 'default_value' => '/contacto/?tipo=evaluacion', 'wrapper' => array( 'width' => '20' ),
				),
				// Doc 4
				array(
					'key' => 'field_mitsa_doc4_title', 'label' => __( 'Doc 4: Título', 'mitsa' ), 'name' => 'doc4_title', 'type' => 'text', 'default_value' => 'Listado de Repuestos Críticos y Números de Parte (P/N)', 'wrapper' => array( 'width' => '40' ),
				),
				array(
					'key' => 'field_mitsa_doc4_format', 'label' => __( 'Doc 4: Formato / Tamaño', 'mitsa' ), 'name' => 'doc4_format', 'type' => 'text', 'default_value' => 'XLSX / PDF', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_doc4_level', 'label' => __( 'Doc 4: Nivel de Acceso', 'mitsa' ), 'name' => 'doc4_level', 'type' => 'text', 'default_value' => 'Clientes', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_doc4_url', 'label' => __( 'Doc 4: URL / Archivo', 'mitsa' ), 'name' => 'doc4_url', 'type' => 'text', 'default_value' => '/contacto/?tipo=repuestos', 'wrapper' => array( 'width' => '20' ),
				),
				// Doc 5
				array(
					'key' => 'field_mitsa_doc5_title', 'label' => __( 'Doc 5: Título', 'mitsa' ), 'name' => 'doc5_title', 'type' => 'text', 'default_value' => 'Protocolo de Comisionamiento y Pruebas de Puesta en Marcha', 'wrapper' => array( 'width' => '40' ),
				),
				array(
					'key' => 'field_mitsa_doc5_format', 'label' => __( 'Doc 5: Formato / Tamaño', 'mitsa' ), 'name' => 'doc5_format', 'type' => 'text', 'default_value' => 'PDF · 950 KB', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_doc5_level', 'label' => __( 'Doc 5: Nivel de Acceso', 'mitsa' ), 'name' => 'doc5_level', 'type' => 'text', 'default_value' => 'Acceso con Registro', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_doc5_url', 'label' => __( 'Doc 5: URL / Archivo', 'mitsa' ), 'name' => 'doc5_url', 'type' => 'text', 'default_value' => '/contacto/?tipo=servicio', 'wrapper' => array( 'width' => '20' ),
				),

				// TAB 4: CTA
				array(
					'key'   => 'tab_rec_cta',
					'label' => __( '📢 Call to Action', 'mitsa' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_mitsa_rec_cta_heading',
					'label'         => __( 'Título de Llamado a la Acción', 'mitsa' ),
					'name'          => 'recursos_cta_heading',
					'type'          => 'text',
					'default_value' => '¿Necesita documentación técnica específica o certificación de fábrica?',
				),
				array(
					'key'           => 'field_mitsa_rec_cta_desc',
					'label'         => __( 'Descripción del CTA', 'mitsa' ),
					'name'          => 'recursos_cta_desc',
					'type'          => 'textarea',
					'default_value' => 'Gestionamos directamente con los fabricantes las fichas de homologación, certificados tipo (Type Approval) y planos de montaje para su proyecto.',
					'rows'          => 2,
				),
				array(
					'key'           => 'field_mitsa_rec_cta_btn_label',
					'label'         => __( 'Texto del Botón', 'mitsa' ),
					'name'          => 'recursos_cta_btn_label',
					'type'          => 'text',
					'default_value' => 'Solicitar documentación técnica',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_rec_cta_btn_url',
					'label'         => __( 'Enlace del Botón', 'mitsa' ),
					'name'          => 'recursos_cta_btn_url',
					'type'          => 'text',
					'default_value' => '/contacto/?tipo=evaluacion',
					'wrapper'       => array( 'width' => '50' ),
				),

				// TAB 5: SEO
				array(
					'key'   => 'tab_rec_seo',
					'label' => __( '🔍 SEO & Open Graph', 'mitsa' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_mitsa_rec_seo_meta_title',
					'label'         => __( 'Meta Title', 'mitsa' ),
					'name'          => 'seo_meta_title',
					'type'          => 'text',
					'default_value' => 'Recursos & Biblioteca Técnica · Artículos Regulatorios y Descargas | MITSA',
				),
				array(
					'key'           => 'field_mitsa_rec_seo_meta_desc',
					'label'         => __( 'Meta Description', 'mitsa' ),
					'name'          => 'seo_meta_description',
					'type'          => 'textarea',
					'default_value' => 'Artículos técnicos de ingeniería naval, guías regulatorias OMI/DIRECTEMAR (D-2, ICCP, MARPOL, ósmosis) y biblioteca de descargas de MITSA.',
					'rows'          => 2,
				),
				array(
					'key'           => 'field_mitsa_rec_seo_og_image',
					'label'         => __( 'Imagen Open Graph', 'mitsa' ),
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
						'value'    => '402', // ID de la página Recursos
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

	// ==========================================
	// GRUPO 8: PÁGINA "CONTACTO" (Post ID 11)
	// ==========================================
	acf_add_local_field_group(
		array(
			'key'                   => 'group_mitsa_contacto_master',
			'title'                 => __( 'Administración de Página "Contacto" (MITSA)', 'mitsa' ),
			'fields'                => array(
				// TAB 1: HERO & 4 PUERTAS
				array(
					'key'   => 'tab_cto_hero',
					'label' => __( '🚀 Hero & Puertas (4)', 'mitsa' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_mitsa_cto_hero_title',
					'label'         => __( 'Título Principal (H1)', 'mitsa' ),
					'name'          => 'contacto_hero_title',
					'type'          => 'text',
					'default_value' => 'Cuéntenos qué necesita resolver',
				),
				array(
					'key'           => 'field_mitsa_cto_hero_desc',
					'label'         => __( 'Bajada / Descripción', 'mitsa' ),
					'name'          => 'contacto_hero_desc',
					'type'          => 'textarea',
					'default_value' => 'Cada requerimiento pide datos distintos. Elegir la puerta correcta conecta su consulta directo con el especialista correspondiente.',
					'rows'          => 3,
				),
				// Puerta 1
				array(
					'key' => 'field_mitsa_door1_num', 'label' => __( 'Puerta 1: N°', 'mitsa' ), 'name' => 'door1_num', 'type' => 'text', 'default_value' => '01', 'wrapper' => array( 'width' => '15' ),
				),
				array(
					'key' => 'field_mitsa_door1_title', 'label' => __( 'Puerta 1: Título', 'mitsa' ), 'name' => 'door1_title', 'type' => 'text', 'default_value' => 'Evaluación técnica', 'wrapper' => array( 'width' => '35' ),
				),
				array(
					'key' => 'field_mitsa_door1_desc', 'label' => __( 'Puerta 1: Descripción', 'mitsa' ), 'name' => 'door1_desc', 'type' => 'text', 'default_value' => 'Proyecto nuevo o retrofit que requiere dimensionar una solución.', 'wrapper' => array( 'width' => '50' ),
				),
				// Puerta 2
				array(
					'key' => 'field_mitsa_door2_num', 'label' => __( 'Puerta 2: N°', 'mitsa' ), 'name' => 'door2_num', 'type' => 'text', 'default_value' => '02', 'wrapper' => array( 'width' => '15' ),
				),
				array(
					'key' => 'field_mitsa_door2_title', 'label' => __( 'Puerta 2: Título', 'mitsa' ), 'name' => 'door2_title', 'type' => 'text', 'default_value' => 'Repuestos', 'wrapper' => array( 'width' => '35' ),
				),
				array(
					'key' => 'field_mitsa_door2_desc', 'label' => __( 'Puerta 2: Descripción', 'mitsa' ), 'name' => 'door2_desc', 'type' => 'text', 'default_value' => 'Identificación y cotización de piezas por número de parte (P/N).', 'wrapper' => array( 'width' => '50' ),
				),
				// Puerta 3
				array(
					'key' => 'field_mitsa_door3_num', 'label' => __( 'Puerta 3: N°', 'mitsa' ), 'name' => 'door3_num', 'type' => 'text', 'default_value' => '03', 'wrapper' => array( 'width' => '15' ),
				),
				array(
					'key' => 'field_mitsa_door3_title', 'label' => __( 'Puerta 3: Título', 'mitsa' ), 'name' => 'door3_title', 'type' => 'text', 'default_value' => 'Servicio técnico', 'wrapper' => array( 'width' => '35' ),
				),
				array(
					'key' => 'field_mitsa_door3_desc', 'label' => __( 'Puerta 3: Descripción', 'mitsa' ), 'name' => 'door3_desc', 'type' => 'text', 'default_value' => 'Diagnóstico, comisionamiento o asistencia sobre un sistema.', 'wrapper' => array( 'width' => '50' ),
				),
				// Puerta 4
				array(
					'key' => 'field_mitsa_door4_num', 'label' => __( 'Puerta 4: N°', 'mitsa' ), 'name' => 'door4_num', 'type' => 'text', 'default_value' => '04', 'wrapper' => array( 'width' => '15' ),
				),
				array(
					'key' => 'field_mitsa_door4_title', 'label' => __( 'Puerta 4: Título', 'mitsa' ), 'name' => 'door4_title', 'type' => 'text', 'default_value' => 'Contacto general', 'wrapper' => array( 'width' => '35' ),
				),
				array(
					'key' => 'field_mitsa_door4_desc', 'label' => __( 'Puerta 4: Descripción', 'mitsa' ), 'name' => 'door4_desc', 'type' => 'text', 'default_value' => 'Consultas comerciales, institucionales o de representación.', 'wrapper' => array( 'width' => '50' ),
				),

				// TAB 2: UBICACIÓN & CANALES DIRECTOS
				array(
					'key'   => 'tab_cto_channels',
					'label' => __( '🏢 Canales & Ubicación', 'mitsa' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_mitsa_cto_address',
					'label'         => __( 'Dirección Principal', 'mitsa' ),
					'name'          => 'contacto_address',
					'type'          => 'text',
					'default_value' => 'Av. Vicuña Mackenna 882, Reñaca, Viña del Mar, Chile',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_cto_branch',
					'label'         => __( 'Oficina Comercial / Sucursal', 'mitsa' ),
					'name'          => 'contacto_branch',
					'type'          => 'text',
					'default_value' => 'Av. Edmundo Eluchans 1737, Of. 61, Reñaca, Viña del Mar',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_cto_phone_main',
					'label'         => __( 'Teléfono Principal', 'mitsa' ),
					'name'          => 'contacto_phone_main',
					'type'          => 'text',
					'default_value' => '+56 32 2835055',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_cto_phone_mobile',
					'label'         => __( 'Teléfono Móvil / WhatsApp', 'mitsa' ),
					'name'          => 'contacto_phone_mobile',
					'type'          => 'text',
					'default_value' => '+56 9 9876 5432',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_cto_email_general',
					'label'         => __( 'Email General', 'mitsa' ),
					'name'          => 'contacto_email_general',
					'type'          => 'text',
					'default_value' => 'contacto@mitsachile.com',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_cto_email_sales',
					'label'         => __( 'Email Operaciones & Ventas', 'mitsa' ),
					'name'          => 'contacto_email_sales',
					'type'          => 'text',
					'default_value' => 'fjdelaiglesia@mitsachile.com',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_cto_hours',
					'label'         => __( 'Horario de Atención', 'mitsa' ),
					'name'          => 'contacto_hours',
					'type'          => 'text',
					'default_value' => 'Lunes a Viernes: 08:30 a 18:00 hrs',
				),

				// TAB 3: COBERTURA REGIONAL
				array(
					'key'   => 'tab_cto_coverage',
					'label' => __( '🌎 Cobertura Regional (8)', 'mitsa' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_mitsa_cto_coverage_title',
					'label'         => __( 'Título de Cobertura', 'mitsa' ),
					'name'          => 'contacto_coverage_title',
					'type'          => 'text',
					'default_value' => 'Presencia y Cobertura Regional',
				),
				array(
					'key'           => 'field_mitsa_cto_coverage_desc',
					'label'         => __( 'Descripción de Cobertura', 'mitsa' ),
					'name'          => 'contacto_coverage_desc',
					'type'          => 'textarea',
					'default_value' => 'Atención comercial y soporte de ingeniería para proyectos marítimos e industriales en 8 países de Latinoamérica.',
					'rows'          => 2,
				),
				array(
					'key'           => 'field_mitsa_cto_countries',
					'label'         => __( 'Países (separados por coma)', 'mitsa' ),
					'name'          => 'contacto_countries',
					'type'          => 'text',
					'default_value' => 'Chile, Perú, Ecuador, Colombia, Panamá, Paraguay, Bolivia, Venezuela',
				),

				// TAB 4: CONFIGURACIÓN FORMULARIO
				array(
					'key'   => 'tab_cto_form',
					'label' => __( '📝 Configuración Formulario', 'mitsa' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_mitsa_cto_form_action',
					'label'         => __( 'URL de Envío (Endpoint / Formspree)', 'mitsa' ),
					'name'          => 'contacto_form_action',
					'type'          => 'text',
					'default_value' => 'https://formspree.io/f/placeholder',
				),
				array(
					'key'           => 'field_mitsa_cto_form_title',
					'label'         => __( 'Título del Formulario', 'mitsa' ),
					'name'          => 'contacto_form_title',
					'type'          => 'text',
					'default_value' => 'Formulario de contacto y asesoría técnica',
				),
				array(
					'key'           => 'field_mitsa_cto_form_desc',
					'label'         => __( 'Bajada del Formulario', 'mitsa' ),
					'name'          => 'contacto_form_desc',
					'type'          => 'textarea',
					'default_value' => 'Complete los datos requeridos y nuestro equipo técnico le responderá en menos de 24 horas hábiles.',
					'rows'          => 2,
				),

				// TAB 5: SEO
				array(
					'key'   => 'tab_cto_seo',
					'label' => __( '🔍 SEO & Open Graph', 'mitsa' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_mitsa_cto_seo_meta_title',
					'label'         => __( 'Meta Title', 'mitsa' ),
					'name'          => 'seo_meta_title',
					'type'          => 'text',
					'default_value' => 'Contacto & Asesoría Técnica · Canales de Ingeniería y Soporte | MITSA',
				),
				array(
					'key'           => 'field_mitsa_cto_seo_meta_desc',
					'label'         => __( 'Meta Description', 'mitsa' ),
					'name'          => 'seo_meta_description',
					'type'          => 'textarea',
					'default_value' => 'Canales de contacto especializados de MITSA: evaluación de proyectos, cotización de repuestos originales, servicio técnico a bordo y cobertura regional en 8 países.',
					'rows'          => 2,
				),
				array(
					'key'           => 'field_mitsa_cto_seo_og_image',
					'label'         => __( 'Imagen Open Graph', 'mitsa' ),
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
						'value'    => '11', // ID de la página Contacto
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

	// ==========================================
	// GRUPO 9: PÁGINA "REPRESENTADAS" (Post ID 8)
	// ==========================================
	acf_add_local_field_group(
		array(
			'key'                   => 'group_mitsa_representadas_master',
			'title'                 => __( 'Administración de Página "Representadas" (MITSA)', 'mitsa' ),
			'fields'                => array(
				// TAB 1: HERO & MÉTRICAS
				array(
					'key'   => 'tab_rep_hero',
					'label' => __( '🚀 Hero & Métricas', 'mitsa' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_mitsa_rep_hero_title',
					'label'         => __( 'Título Principal (H1)', 'mitsa' ),
					'name'          => 'representadas_hero_title',
					'type'          => 'text',
					'default_value' => 'Marcas líderes mundiales representadas en Chile y la región.',
				),
				array(
					'key'           => 'field_mitsa_rep_hero_desc',
					'label'         => __( 'Bajada / Descripción', 'mitsa' ),
					'name'          => 'representadas_hero_desc',
					'type'          => 'textarea',
					'default_value' => 'Ingeniería de aplicación directa con los fabricantes, repuestos originales y certificación oficial de fábrica para sistemas marinos e industriales.',
					'rows'          => 3,
				),
				array(
					'key'           => 'field_mitsa_rep_hero_img',
					'label'         => __( 'Imagen Destacada Hero', 'mitsa' ),
					'name'          => 'representadas_hero_img',
					'type'          => 'image',
					'return_format' => 'url',
					'default_value' => '/images/hero-1-8a9d042f.jpg',
				),
				array(
					'key'           => 'field_mitsa_rep_btn1_label',
					'label'         => __( 'Botón 1: Texto', 'mitsa' ),
					'name'          => 'representadas_btn1_label',
					'type'          => 'text',
					'default_value' => 'Ver representadas',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_rep_btn1_url',
					'label'         => __( 'Botón 1: Enlace', 'mitsa' ),
					'name'          => 'representadas_btn1_url',
					'type'          => 'text',
					'default_value' => '#marcas-principales',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_rep_btn2_label',
					'label'         => __( 'Botón 2: Texto', 'mitsa' ),
					'name'          => 'representadas_btn2_label',
					'type'          => 'text',
					'default_value' => 'Solicitar repuestos',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_rep_btn2_url',
					'label'         => __( 'Botón 2: Enlace', 'mitsa' ),
					'name'          => 'representadas_btn2_url',
					'type'          => 'text',
					'default_value' => '/contacto/?tipo=repuestos',
					'wrapper'       => array( 'width' => '50' ),
				),
				// Métricas
				array(
					'key'           => 'field_mitsa_rep_m1_num',
					'label'         => __( 'Métrica 1: Cifra', 'mitsa' ),
					'name'          => 'rep_m1_num',
					'type'          => 'text',
					'default_value' => '14+',
					'wrapper'       => array( 'width' => '30' ),
				),
				array(
					'key'           => 'field_mitsa_rep_m1_label',
					'label'         => __( 'Métrica 1: Etiqueta', 'mitsa' ),
					'name'          => 'rep_m1_label',
					'type'          => 'text',
					'default_value' => 'marcas internacionales representadas',
					'wrapper'       => array( 'width' => '70' ),
				),
				array(
					'key'           => 'field_mitsa_rep_m2_num',
					'label'         => __( 'Métrica 2: Cifra', 'mitsa' ),
					'name'          => 'rep_m2_num',
					'type'          => 'text',
					'default_value' => '40+',
					'wrapper'       => array( 'width' => '30' ),
				),
				array(
					'key'           => 'field_mitsa_rep_m2_label',
					'label'         => __( 'Métrica 2: Etiqueta', 'mitsa' ),
					'name'          => 'rep_m2_label',
					'type'          => 'text',
					'default_value' => 'años de alianza con fabricantes líderes',
					'wrapper'       => array( 'width' => '70' ),
				),
				array(
					'key'           => 'field_mitsa_rep_m3_num',
					'label'         => __( 'Métrica 3: Cifra', 'mitsa' ),
					'name'          => 'rep_m3_num',
					'type'          => 'text',
					'default_value' => '100%',
					'wrapper'       => array( 'width' => '30' ),
				),
				array(
					'key'           => 'field_mitsa_rep_m3_label',
					'label'         => __( 'Métrica 3: Etiqueta', 'mitsa' ),
					'name'          => 'rep_m3_label',
					'type'          => 'text',
					'default_value' => 'soporte y certificación directa de fábrica',
					'wrapper'       => array( 'width' => '70' ),
				),

				// TAB 2: MARCAS PRINCIPALES (6)
				array(
					'key'   => 'tab_rep_main',
					'label' => __( '🏆 Marcas Principales (6)', 'mitsa' ),
					'type'  => 'tab',
				),
				// Brand 1: EVAC
				array(
					'key' => 'field_mitsa_bmain1_name', 'label' => __( 'Marca 1: Nombre', 'mitsa' ), 'name' => 'bmain1_name', 'type' => 'text', 'default_value' => 'EVAC', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain1_country', 'label' => __( 'Marca 1: País', 'mitsa' ), 'name' => 'bmain1_country', 'type' => 'text', 'default_value' => 'Finlandia', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain1_holding', 'label' => __( 'Marca 1: Grupo / Holding', 'mitsa' ), 'name' => 'bmain1_holding', 'type' => 'text', 'default_value' => 'Evac Group', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain1_category', 'label' => __( 'Marca 1: Categoría', 'mitsa' ), 'name' => 'bmain1_category', 'type' => 'text', 'default_value' => 'Aguas y sanitarios', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain1_desc', 'label' => __( 'Marca 1: Descripción', 'mitsa' ), 'name' => 'bmain1_desc', 'type' => 'textarea', 'default_value' => 'Líder mundial en sistemas sanitarios al vacío (Optima), unidades generadoras de vacío (OnlineVac) y biorreactores de membrana biológica (MBR).', 'rows' => 2, 'wrapper' => array( 'width' => '50' ),
				),
				array(
					'key' => 'field_mitsa_bmain1_solutions', 'label' => __( 'Marca 1: Soluciones (separadas por coma)', 'mitsa' ), 'name' => 'bmain1_solutions', 'type' => 'text', 'default_value' => 'Sanitarios al vacío, Biorreactores MBR, Tratamiento de aguas grises y negras', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain1_image', 'label' => __( 'Marca 1: Imagen', 'mitsa' ), 'name' => 'bmain1_image', 'type' => 'image', 'return_format' => 'url', 'default_value' => '/images/naval-y-defensa-5b2a62fc.jpg', 'wrapper' => array( 'width' => '25' ),
				),

				// Brand 2: Cathelco
				array(
					'key' => 'field_mitsa_bmain2_name', 'label' => __( 'Marca 2: Nombre', 'mitsa' ), 'name' => 'bmain2_name', 'type' => 'text', 'default_value' => 'Cathelco', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain2_country', 'label' => __( 'Marca 2: País', 'mitsa' ), 'name' => 'bmain2_country', 'type' => 'text', 'default_value' => 'Inglaterra', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain2_holding', 'label' => __( 'Marca 2: Grupo / Holding', 'mitsa' ), 'name' => 'bmain2_holding', 'type' => 'text', 'default_value' => 'Evac Group', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain2_category', 'label' => __( 'Marca 2: Categoría', 'mitsa' ), 'name' => 'bmain2_category', 'type' => 'text', 'default_value' => 'Protección casco & Desalinización', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain2_desc', 'label' => __( 'Marca 2: Descripción', 'mitsa' ), 'name' => 'bmain2_desc', 'type' => 'textarea', 'default_value' => 'Especialista en protección catódica por corriente impresa (ICCP), prevención de bioincrustación (ICAF/MGPS) y plantas desalinizadoras por ósmosis inversa (Seafresh / H2O Mk3).', 'rows' => 2, 'wrapper' => array( 'width' => '50' ),
				),
				array(
					'key' => 'field_mitsa_bmain2_solutions', 'label' => __( 'Marca 2: Soluciones (separadas por coma)', 'mitsa' ), 'name' => 'bmain2_solutions', 'type' => 'text', 'default_value' => 'Protección catódica ICCP, Control biofouling ICAF/MGPS, Ósmosis inversa marina', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain2_image', 'label' => __( 'Marca 2: Imagen', 'mitsa' ), 'name' => 'bmain2_image', 'type' => 'image', 'return_format' => 'url', 'default_value' => '/images/plataforma-offshore-8886341c.jpg', 'wrapper' => array( 'width' => '25' ),
				),

				// Brand 3: ERMA FIRST
				array(
					'key' => 'field_mitsa_bmain3_name', 'label' => __( 'Marca 3: Nombre', 'mitsa' ), 'name' => 'bmain3_name', 'type' => 'text', 'default_value' => 'ERMA FIRST', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain3_country', 'label' => __( 'Marca 3: País', 'mitsa' ), 'name' => 'bmain3_country', 'type' => 'text', 'default_value' => 'Grecia', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain3_holding', 'label' => __( 'Marca 3: Grupo / Holding', 'mitsa' ), 'name' => 'bmain3_holding', 'type' => 'text', 'default_value' => 'Erma First Group', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain3_category', 'label' => __( 'Marca 3: Categoría', 'mitsa' ), 'name' => 'bmain3_category', 'type' => 'text', 'default_value' => 'Tratamiento agua de lastre', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain3_desc', 'label' => __( 'Marca 3: Descripción', 'mitsa' ), 'name' => 'bmain3_desc', 'type' => 'textarea', 'default_value' => 'Fabricante referente en sistemas de tratamiento de agua de lastre (BWTS) bajo estándar D-2 de la OMI y homologación USCG, con filtración de 40 micras y desinfección electrolítica.', 'rows' => 2, 'wrapper' => array( 'width' => '50' ),
				),
				array(
					'key' => 'field_mitsa_bmain3_solutions', 'label' => __( 'Marca 3: Soluciones (separadas por coma)', 'mitsa' ), 'name' => 'bmain3_solutions', 'type' => 'text', 'default_value' => 'FIT BWTS, Monitoreo por IA METIS, Cumplimiento OMI D-2 y USCG', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain3_image', 'label' => __( 'Marca 3: Imagen', 'mitsa' ), 'name' => 'bmain3_image', 'type' => 'image', 'return_format' => 'url', 'default_value' => '/images/transporte-maritimo-3720ea8c.jpg', 'wrapper' => array( 'width' => '25' ),
				),

				// Brand 4: EPE
				array(
					'key' => 'field_mitsa_bmain4_name', 'label' => __( 'Marca 4: Nombre', 'mitsa' ), 'name' => 'bmain4_name', 'type' => 'text', 'default_value' => 'EPE', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain4_country', 'label' => __( 'Marca 4: País', 'mitsa' ), 'name' => 'bmain4_country', 'type' => 'text', 'default_value' => 'Grecia', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain4_holding', 'label' => __( 'Marca 4: Grupo / Holding', 'mitsa' ), 'name' => 'bmain4_holding', 'type' => 'text', 'default_value' => 'EPE Environmental', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain4_category', 'label' => __( 'Marca 4: Categoría', 'mitsa' ), 'name' => 'bmain4_category', 'type' => 'text', 'default_value' => 'Protección ambiental & Fisicoquímico', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain4_desc', 'label' => __( 'Marca 4: Descripción', 'mitsa' ), 'name' => 'bmain4_desc', 'type' => 'textarea', 'default_value' => 'Más de 45 años en protección ambiental marina: plantas fisicoquímicas de aguas residuales Triton FIT (certificación DNV/MEPC.227) y equipos de contingencia.', 'rows' => 2, 'wrapper' => array( 'width' => '50' ),
				),
				array(
					'key' => 'field_mitsa_bmain4_solutions', 'label' => __( 'Marca 4: Soluciones (separadas por coma)', 'mitsa' ), 'name' => 'bmain4_solutions', 'type' => 'text', 'default_value' => 'Triton FIT 3.0 / 6.0, Plantas fisicoquímicas, Separadores de sentina', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain4_image', 'label' => __( 'Marca 4: Imagen', 'mitsa' ), 'name' => 'bmain4_image', 'type' => 'image', 'return_format' => 'url', 'default_value' => '/images/astilleros-y-diques-0e241764.jpg', 'wrapper' => array( 'width' => '25' ),
				),

				// Brand 5: BLÜCHER
				array(
					'key' => 'field_mitsa_bmain5_name', 'label' => __( 'Marca 5: Nombre', 'mitsa' ), 'name' => 'bmain5_name', 'type' => 'text', 'default_value' => 'BLÜCHER', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain5_country', 'label' => __( 'Marca 5: País', 'mitsa' ), 'name' => 'bmain5_country', 'type' => 'text', 'default_value' => 'Dinamarca', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain5_holding', 'label' => __( 'Marca 5: Grupo / Holding', 'mitsa' ), 'name' => 'bmain5_holding', 'type' => 'text', 'default_value' => 'Watts Water', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain5_category', 'label' => __( 'Marca 5: Categoría', 'mitsa' ), 'name' => 'bmain5_category', 'type' => 'text', 'default_value' => 'Drenajes & Cañerías inoxidables', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain5_desc', 'label' => __( 'Marca 5: Descripción', 'mitsa' ), 'name' => 'bmain5_desc', 'type' => 'textarea', 'default_value' => 'Sistemas de drenaje de alta resistencia, canaletas, sumideros y tuberías push-fit en acero inoxidable AISI 316L para buques, plantas de alimentos e industrias.', 'rows' => 2, 'wrapper' => array( 'width' => '50' ),
				),
				array(
					'key' => 'field_mitsa_bmain5_solutions', 'label' => __( 'Marca 5: Soluciones (separadas por coma)', 'mitsa' ), 'name' => 'bmain5_solutions', 'type' => 'text', 'default_value' => 'Tuberías EuroPipe AISI 316L, Drenajes marinos, Canales industriales', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain5_image', 'label' => __( 'Marca 5: Imagen', 'mitsa' ), 'name' => 'bmain5_image', 'type' => 'image', 'return_format' => 'url', 'default_value' => '/images/acuicultura-y-pesca-6ece81b5.jpg', 'wrapper' => array( 'width' => '25' ),
				),

				// Brand 6: Uson Marine
				array(
					'key' => 'field_mitsa_bmain6_name', 'label' => __( 'Marca 6: Nombre', 'mitsa' ), 'name' => 'bmain6_name', 'type' => 'text', 'default_value' => 'Uson Marine', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain6_country', 'label' => __( 'Marca 6: País', 'mitsa' ), 'name' => 'bmain6_country', 'type' => 'text', 'default_value' => 'Suecia', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain6_holding', 'label' => __( 'Marca 6: Grupo / Holding', 'mitsa' ), 'name' => 'bmain6_holding', 'type' => 'text', 'default_value' => 'Evac Group', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain6_category', 'label' => __( 'Marca 6: Categoría', 'mitsa' ), 'name' => 'bmain6_category', 'type' => 'text', 'default_value' => 'Gestión de residuos a bordo', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain6_desc', 'label' => __( 'Marca 6: Descripción', 'mitsa' ), 'name' => 'bmain6_desc', 'type' => 'textarea', 'default_value' => 'Sistemas integrales para compactación, trituración y almacenamiento higiénico de residuos sólidos y orgánicos a bordo de buques y plataformas.', 'rows' => 2, 'wrapper' => array( 'width' => '50' ),
				),
				array(
					'key' => 'field_mitsa_bmain6_solutions', 'label' => __( 'Marca 6: Soluciones (separadas por coma)', 'mitsa' ), 'name' => 'bmain6_solutions', 'type' => 'text', 'default_value' => 'Compactadores marinos, Trituradores orgánicos, Gestión de residuos', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_bmain6_image', 'label' => __( 'Marca 6: Imagen', 'mitsa' ), 'name' => 'bmain6_image', 'type' => 'image', 'return_format' => 'url', 'default_value' => '/images/instalaciones-en-tie-f9537988.jpg', 'wrapper' => array( 'width' => '25' ),
				),

				// TAB 3: DIRECTORIO COMPLEMENTARIO
				array(
					'key'   => 'tab_rep_directory',
					'label' => __( '🌐 Directorio Global (8)', 'mitsa' ),
					'type'  => 'tab',
				),
				// Dir 1
				array(
					'key' => 'field_mitsa_dir1_name', 'label' => __( 'Dir 1: Marca', 'mitsa' ), 'name' => 'dir1_name', 'type' => 'text', 'default_value' => 'Herborner Pumpen', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_dir1_country', 'label' => __( 'Dir 1: País', 'mitsa' ), 'name' => 'dir1_country', 'type' => 'text', 'default_value' => 'Alemania', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_dir1_cat', 'label' => __( 'Dir 1: Categoría', 'mitsa' ), 'name' => 'dir1_cat', 'type' => 'text', 'default_value' => 'Bombas y fluidos', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_dir1_desc', 'label' => __( 'Dir 1: Descripción', 'mitsa' ), 'name' => 'dir1_desc', 'type' => 'text', 'default_value' => 'Bombas marinas centrífugas con recubrimiento cerámico resistente a la corrosión.', 'wrapper' => array( 'width' => '30' ),
				),
				// Dir 2
				array(
					'key' => 'field_mitsa_dir2_name', 'label' => __( 'Dir 2: Marca', 'mitsa' ), 'name' => 'dir2_name', 'type' => 'text', 'default_value' => 'SIHI', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_dir2_country', 'label' => __( 'Dir 2: País', 'mitsa' ), 'name' => 'dir2_country', 'type' => 'text', 'default_value' => 'Alemania', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_dir2_cat', 'label' => __( 'Dir 2: Categoría', 'mitsa' ), 'name' => 'dir2_cat', 'type' => 'text', 'default_value' => 'Bombas y vacío', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_dir2_desc', 'label' => __( 'Dir 2: Descripción', 'mitsa' ), 'name' => 'dir2_desc', 'type' => 'text', 'default_value' => 'Bombas de vacío de anillo líquido y sistemas de bombeo de procesos industriales.', 'wrapper' => array( 'width' => '30' ),
				),
				// Dir 3
				array(
					'key' => 'field_mitsa_dir3_name', 'label' => __( 'Dir 3: Marca', 'mitsa' ), 'name' => 'dir3_name', 'type' => 'text', 'default_value' => 'Harwil', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_dir3_country', 'label' => __( 'Dir 3: País', 'mitsa' ), 'name' => 'dir3_country', 'type' => 'text', 'default_value' => 'USA', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_dir3_cat', 'label' => __( 'Dir 3: Categoría', 'mitsa' ), 'name' => 'dir3_cat', 'type' => 'text', 'default_value' => 'Instrumentación', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_dir3_desc', 'label' => __( 'Dir 3: Descripción', 'mitsa' ), 'name' => 'dir3_desc', 'type' => 'text', 'default_value' => 'Interruptores de flujo y sensores de nivel para automatización y control de bombas.', 'wrapper' => array( 'width' => '30' ),
				),
				// Dir 4
				array(
					'key' => 'field_mitsa_dir4_name', 'label' => __( 'Dir 4: Marca', 'mitsa' ), 'name' => 'dir4_name', 'type' => 'text', 'default_value' => 'Moyno', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_dir4_country', 'label' => __( 'Dir 4: País', 'mitsa' ), 'name' => 'dir4_country', 'type' => 'text', 'default_value' => 'USA', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_dir4_cat', 'label' => __( 'Dir 4: Categoría', 'mitsa' ), 'name' => 'dir4_cat', 'type' => 'text', 'default_value' => 'Bombas y fluidos', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_dir4_desc', 'label' => __( 'Dir 4: Descripción', 'mitsa' ), 'name' => 'dir4_desc', 'type' => 'text', 'default_value' => 'Bombas de cavidad progresiva para lodos, fluidos viscosos y efluentes marinos.', 'wrapper' => array( 'width' => '30' ),
				),
				// Dir 5
				array(
					'key' => 'field_mitsa_dir5_name', 'label' => __( 'Dir 5: Marca', 'mitsa' ), 'name' => 'dir5_name', 'type' => 'text', 'default_value' => 'Burks Pumps', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_dir5_country', 'label' => __( 'Dir 5: País', 'mitsa' ), 'name' => 'dir5_country', 'type' => 'text', 'default_value' => 'USA', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_dir5_cat', 'label' => __( 'Dir 5: Categoría', 'mitsa' ), 'name' => 'dir5_cat', 'type' => 'text', 'default_value' => 'Bombas industriales', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_dir5_desc', 'label' => __( 'Dir 5: Descripción', 'mitsa' ), 'name' => 'dir5_desc', 'type' => 'text', 'default_value' => 'Bombas centrífugas y turbinas regenerativas para alta presión y servicios auxiliares.', 'wrapper' => array( 'width' => '30' ),
				),
				// Dir 6
				array(
					'key' => 'field_mitsa_dir6_name', 'label' => __( 'Dir 6: Marca', 'mitsa' ), 'name' => 'dir6_name', 'type' => 'text', 'default_value' => 'FCI Watermaker', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_dir6_country', 'label' => __( 'Dir 6: País', 'mitsa' ), 'name' => 'dir6_country', 'type' => 'text', 'default_value' => 'USA', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_dir6_cat', 'label' => __( 'Dir 6: Categoría', 'mitsa' ), 'name' => 'dir6_cat', 'type' => 'text', 'default_value' => 'Desalinización', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_dir6_desc', 'label' => __( 'Dir 6: Descripción', 'mitsa' ), 'name' => 'dir6_desc', 'type' => 'text', 'default_value' => 'Plantas desalinizadoras automáticas por ósmosis inversa para embarcaciones.', 'wrapper' => array( 'width' => '30' ),
				),
				// Dir 7
				array(
					'key' => 'field_mitsa_dir7_name', 'label' => __( 'Dir 7: Marca', 'mitsa' ), 'name' => 'dir7_name', 'type' => 'text', 'default_value' => 'Planus', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_dir7_country', 'label' => __( 'Dir 7: País', 'mitsa' ), 'name' => 'dir7_country', 'type' => 'text', 'default_value' => 'Italia', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_dir7_cat', 'label' => __( 'Dir 7: Categoría', 'mitsa' ), 'name' => 'dir7_cat', 'type' => 'text', 'default_value' => 'Aguas y sanitarios', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_dir7_desc', 'label' => __( 'Dir 7: Descripción', 'mitsa' ), 'name' => 'dir7_desc', 'type' => 'text', 'default_value' => 'Sanitarios marinos integrados y sistemas de bombeo de maceración.', 'wrapper' => array( 'width' => '30' ),
				),
				// Dir 8
				array(
					'key' => 'field_mitsa_dir8_name', 'label' => __( 'Dir 8: Marca', 'mitsa' ), 'name' => 'dir8_name', 'type' => 'text', 'default_value' => 'Terminator', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_dir8_country', 'label' => __( 'Dir 8: País', 'mitsa' ), 'name' => 'dir8_country', 'type' => 'text', 'default_value' => 'Chile', 'wrapper' => array( 'width' => '20' ),
				),
				array(
					'key' => 'field_mitsa_dir8_cat', 'label' => __( 'Dir 8: Categoría', 'mitsa' ), 'name' => 'dir8_cat', 'type' => 'text', 'default_value' => 'Confort & Residuos', 'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key' => 'field_mitsa_dir8_desc', 'label' => __( 'Dir 8: Descripción', 'mitsa' ), 'name' => 'dir8_desc', 'type' => 'text', 'default_value' => 'Equipos compactadores y trituradores de residuos para faenas en tierra y mar.', 'wrapper' => array( 'width' => '30' ),
				),

				// TAB 4: CTA
				array(
					'key'   => 'tab_rep_cta',
					'label' => __( '📢 Call to Action', 'mitsa' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_mitsa_rep_cta_heading',
					'label'         => __( 'Título de Llamado a la Acción', 'mitsa' ),
					'name'          => 'representadas_cta_heading',
					'type'          => 'text',
					'default_value' => '¿Requiere asesoría directa o repuestos de nuestras representadas?',
				),
				array(
					'key'           => 'field_mitsa_rep_cta_desc',
					'label'         => __( 'Descripción del CTA', 'mitsa' ),
					'name'          => 'representadas_cta_desc',
					'type'          => 'textarea',
					'default_value' => 'Como representantes oficiales, contamos con acceso directo a ingeniería de fábrica, números de parte originales y tiempos prioritarios de entrega.',
					'rows'          => 2,
				),
				array(
					'key'           => 'field_mitsa_rep_cta_btn_label',
					'label'         => __( 'Texto del Botón', 'mitsa' ),
					'name'          => 'representadas_cta_btn_label',
					'type'          => 'text',
					'default_value' => 'Contactar a un especialista de marca',
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_mitsa_rep_cta_btn_url',
					'label'         => __( 'Enlace del Botón', 'mitsa' ),
					'name'          => 'representadas_cta_btn_url',
					'type'          => 'text',
					'default_value' => '/contacto/?tipo=repuestos',
					'wrapper'       => array( 'width' => '50' ),
				),

				// TAB 5: SEO
				array(
					'key'   => 'tab_rep_seo',
					'label' => __( '🔍 SEO & Open Graph', 'mitsa' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_mitsa_rep_seo_meta_title',
					'label'         => __( 'Meta Title', 'mitsa' ),
					'name'          => 'seo_meta_title',
					'type'          => 'text',
					'default_value' => 'Marcas Representadas Oficiales · Tecnologías Marinas y Sanitarias | MITSA',
				),
				array(
					'key'           => 'field_mitsa_rep_seo_meta_desc',
					'label'         => __( 'Meta Description', 'mitsa' ),
					'name'          => 'seo_meta_description',
					'type'          => 'textarea',
					'default_value' => 'Representación oficial en Chile y Latinoamérica: EVAC, Cathelco, ERMA FIRST, EPE, BLÜCHER y fabricantes líderes mundiales.',
					'rows'          => 2,
				),
				array(
					'key'           => 'field_mitsa_rep_seo_og_image',
					'label'         => __( 'Imagen Open Graph', 'mitsa' ),
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
						'value'    => '8', // ID de la página Representadas
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
