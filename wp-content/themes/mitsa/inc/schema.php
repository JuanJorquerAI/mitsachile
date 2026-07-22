<?php
/**
 * Datos estructurados schema.org (JSON-LD) para MITSA.
 *
 * Proporciona metadatos avanzados para motores de búsqueda tradicionales
 * y sistemas RAG de Inteligencia Artificial (GEO).
 *
 * @package mitsa
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Genera e imprime el JSON-LD en el head.
 */
function mitsa_print_json_ld_schema() {
	$graph = array();

	// 1. Entidad: Organización (MITSA SpA)
	$org_schema = array(
		'@type'       => 'Organization',
		'@id'         => home_url( '/#organization' ),
		'name'        => 'MITSA',
		'legalName'   => 'Maquinarias e Inversiones Técnicas S.A.',
		'url'         => home_url( '/' ),
		'logo'        => array(
			'@type' => 'ImageObject',
			'@id'   => home_url( '/#logo' ),
			'url'   => get_site_icon_url( 512 ) ? get_site_icon_url( 512 ) : home_url( '/wp-content/themes/mitsa/assets/images/logo.png' ),
			'caption' => 'MITSA',
		),
		'sameAs'      => array(
			'https://www.facebook.com/mitsachile/',
		),
	);
	$graph[] = $org_schema;

	// 2. Entidad: LocalBusiness (Sede física Reñaca)
	$business_schema = array(
		'@type'       => 'LocalBusiness',
		'@id'         => home_url( '/#localbusiness' ),
		'name'        => 'MITSA',
		'image'       => get_site_icon_url( 512 ) ? get_site_icon_url( 512 ) : home_url( '/wp-content/themes/mitsa/assets/images/logo.png' ),
		'url'         => home_url( '/' ),
		'telephone'   => '+56322834052',
		'email'       => 'info@mitsachile.com',
		'priceRange'  => '$$',
		'address'     => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => 'Av. Vicuña Mackenna 882, Reñaca',
			'addressLocality' => 'Viña del Mar',
			'addressRegion'   => 'Valparaíso',
			'addressCountry'  => 'CL',
		),
		'areaServed'  => array(
			'@type' => 'Country',
			'name'  => 'CL',
		),
		'knowsAbout'  => array(
			'Tratamiento de agua de lastre',
			'Sistemas BWTS',
			'Ósmosis inversa marina',
			'Plantas de tratamiento de aguas servidas para buques',
			'Protección catódica ICCP naval',
			'Sistemas antiincrustantes',
			'Ánodos de sacrificio',
			'Intercambiadores de calor navales',
		),
	);
	$graph[] = $business_schema;

	// 3. Entidad: BreadcrumbList (Si aplica y no estamos en la Home)
	if ( ! is_front_page() && ! is_home() ) {
		$breadcrumbs = array();
		$breadcrumbs[] = array(
			'@type'    => 'ListItem',
			'position' => 1,
			'name'     => 'Inicio',
			'item'     => home_url( '/' ),
		);

		if ( is_singular( 'producto' ) ) {
			$breadcrumbs[] = array(
				'@type'    => 'ListItem',
				'position' => 2,
				'name'     => 'Productos',
				'item'     => home_url( '/productos/' ),
			);
			
			// Añadir categoría del producto si tiene
			$terms = get_the_terms( get_the_ID(), 'categoria-producto' );
			$pos = 3;
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				$term = array_shift( $terms );
				$breadcrumbs[] = array(
					'@type'    => 'ListItem',
					'position' => 3,
					'name'     => $term->name,
					'item'     => get_term_link( $term ),
				);
				$pos = 4;
			}

			$breadcrumbs[] = array(
				'@type'    => 'ListItem',
				'position' => $pos,
				'name'     => get_the_title(),
				'item'     => get_permalink(),
			);
		} elseif ( is_tax( 'categoria-producto' ) ) {
			$breadcrumbs[] = array(
				'@type'    => 'ListItem',
				'position' => 2,
				'name'     => 'Productos',
				'item'     => home_url( '/productos/' ),
			);
			$breadcrumbs[] = array(
				'@type'    => 'ListItem',
				'position' => 3,
				'name'     => single_term_title( '', false ),
				'item'     => get_term_link( get_queried_object() ),
			);
		} elseif ( is_page() ) {
			$breadcrumbs[] = array(
				'@type'    => 'ListItem',
				'position' => 2,
				'name'     => get_the_title(),
				'item'     => get_permalink(),
			);
		}

		$breadcrumb_schema = array(
			'@type'           => 'BreadcrumbList',
			'@id'             => get_permalink() . '#breadcrumb',
			'itemListElement' => $breadcrumbs,
		);
		$graph[] = $breadcrumb_schema;
	}

	// 4. Entidad: Product (Singles de producto)
	if ( is_singular( 'producto' ) ) {
		$product_id = get_the_ID();
		
		// Obtener marca (representada) del producto
		$marcas = get_the_terms( $product_id, 'marca' );
		$brand_name = 'MITSA'; // fallback
		if ( ! empty( $marcas ) && ! is_wp_error( $marcas ) ) {
			$marca = array_shift( $marcas );
			$brand_name = $marca->name;
		}

		$product_schema = array(
			'@type'       => 'Product',
			'@id'         => get_permalink() . '#product',
			'name'        => get_the_title(),
			'description' => has_excerpt() ? get_the_excerpt() : wp_strip_all_tags( get_the_content() ),
			'url'         => get_permalink(),
			'brand'       => array(
				'@type' => 'Brand',
				'name'  => $brand_name,
			),
		);
		$graph[] = $product_schema;
	}

	// 5. Entidad: FAQPage (Páginas con FAQ inyectado)
	// Si hay FAQs definidos para esta página
	$faqs = array();
	
	// Si estamos en la página de BWTS, inyectamos FAQs regulatorios directamente
	if ( is_page( 'tratamiento-agua-lastre' ) || ( is_singular( 'producto' ) && strpos( get_post_field( 'post_name', get_the_ID() ), 'lastre' ) !== false ) ) {
		$faqs = array(
			array(
				'question' => '¿Qué es un sistema BWTS y por qué es obligatorio?',
				'answer'   => 'Un sistema de tratamiento de agua de lastre (BWTS) elimina organismos acuáticos nocivos de las aguas de lastre de los buques. Su obligatoriedad está definida por el Convenio de Agua de Lastre de la OMI, exigiendo que todos los buques cumplan con el estándar D-2 para evitar la transferencia de especies invasoras.',
			),
			array(
				'question' => '¿Qué exige DIRECTEMAR sobre la norma D-2 en Chile?',
				'answer'   => 'DIRECTEMAR fiscaliza activamente en puertos chilenos el cumplimiento del estándar D-2 de la OMI. Todo Plan de Gestión de Agua de Lastre (BWMP) aprobado o modificado a partir de septiembre de 2024 debe incorporar el cumplimiento de la norma D-2, verificado en terreno mediante fluorómetros.',
			),
			array(
				'question' => '¿Cómo funciona la tecnología de tratamiento de Erma First?',
				'answer'   => 'El sistema Erma First FIT BWTS utiliza un proceso de filtración mecánica de 40 micras para retener partículas grandes, seguido por electrólisis de flujo total (electroloración) durante la toma de lastre, asegurando la desinfección total de microorganismos.',
			),
		);
	}

	if ( ! empty( $faqs ) ) {
		$faq_elements = array();
		foreach ( $faqs as $faq ) {
			$faq_elements[] = array(
				'@type'          => 'Question',
				'name'           => $faq['question'],
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => $faq['answer'],
				),
			);
		}

		$faq_schema = array(
			'@type'           => 'FAQPage',
			'@id'             => get_permalink() . '#faq',
			'mainEntity'      => $faq_elements,
		);
		$graph[] = $faq_schema;
	}

	// Imprimir el script JSON-LD
	if ( ! empty( $graph ) ) {
		$output = array(
			'@context' => 'https://schema.org',
			'@graph'   => $graph,
		);

		echo "\n" . '<!-- MITSA Schema Markup -->' . "\n";
		echo '<script type="application/ld+json">' . "\n";
		echo wp_json_encode( $output, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT ) . "\n";
		echo '</script>' . "\n";
	}
}
add_action( 'wp_head', 'mitsa_print_json_ld_schema', 90 );
