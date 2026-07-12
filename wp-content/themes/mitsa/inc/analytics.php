<?php
/**
 * Analítica — placeholder para GA4 y Google Tag Manager.
 *
 * CLAUDE.md especifica que GA4 + Google Search Console + GTM deben estar
 * instalados desde el lanzamiento. Este archivo deja el enganche listo pero
 * NO inyecta nada todavía: las constantes MITSA_GA4_ID y MITSA_GTM_ID no
 * existen aún en wp-config.php.
 *
 * Para activar, definir en wp-config.php (fuera de este repo, no versionar
 * IDs reales si se decide tratarlos como secreto — en general los IDs de
 * GA4/GTM no son secretos, pero seguir la convención del proyecto):
 *
 *     define( 'MITSA_GA4_ID', 'G-XXXXXXXXXX' );
 *     define( 'MITSA_GTM_ID', 'GTM-XXXXXXX' );
 *
 * @package mitsa
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Inyecta el snippet de Google Tag Manager en <head>.
 *
 * TODO: descomentar cuando MITSA_GTM_ID esté definido en wp-config.php.
 */
function mitsa_gtm_head() {
	if ( ! defined( 'MITSA_GTM_ID' ) || ! MITSA_GTM_ID ) {
		return;
	}

	/*
	printf(
		"<!-- Google Tag Manager -->\n<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':\n new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],\n j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=\n 'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);\n })(window,document,'script','dataLayer','%s');</script>\n<!-- End Google Tag Manager -->\n",
		esc_js( MITSA_GTM_ID )
	);
	*/
}
add_action( 'wp_head', 'mitsa_gtm_head', 1 );

/**
 * Inyecta el <noscript> de GTM justo después de <body>.
 *
 * TODO: descomentar junto con mitsa_gtm_head() cuando MITSA_GTM_ID exista.
 */
function mitsa_gtm_body_open() {
	if ( ! defined( 'MITSA_GTM_ID' ) || ! MITSA_GTM_ID ) {
		return;
	}

	/*
	printf(
		'<!-- Google Tag Manager (noscript) --><noscript><iframe src="https://www.googletagmanager.com/ns.html?id=%s" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript><!-- End Google Tag Manager (noscript) -->',
		esc_attr( MITSA_GTM_ID )
	);
	*/
}
add_action( 'wp_body_open', 'mitsa_gtm_body_open' );

/**
 * Inyecta el snippet de Google Analytics 4 (gtag.js) en <head>.
 *
 * Si ya se usa GTM para disparar GA4, normalmente NO hace falta este
 * snippet además — evaluar con el equipo de analítica cuál de los dos usar
 * como fuente de la etiqueta (GTM es lo recomendado por CLAUDE.md).
 *
 * TODO: descomentar cuando MITSA_GA4_ID esté definido en wp-config.php.
 */
function mitsa_ga4_head() {
	if ( ! defined( 'MITSA_GA4_ID' ) || ! MITSA_GA4_ID ) {
		return;
	}

	/*
	printf(
		'<script async src="https://www.googletagmanager.com/gtag/js?id=%1$s"></script><script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());gtag("config","%1$s");</script>',
		esc_js( MITSA_GA4_ID )
	);
	*/
}
add_action( 'wp_head', 'mitsa_ga4_head', 2 );
