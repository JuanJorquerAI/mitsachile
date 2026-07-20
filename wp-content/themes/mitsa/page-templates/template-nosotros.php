<?php
/**
 * Template Name: MITSA — Nosotros
 * Description: Página "Nosotros". Contenido validado (ver content/sitio-actual/01-nosotros.md).
 *   Cabecera con banner de imagen (marina/aviación), bloque destacado "Quiénes
 *   somos" y Misión/Visión en paneles con fondo. Usa solo clases del contrato
 *   docs/replica-tema-overrides/carino-clases.md (fase Fundación posee style.css/theme.js).
 *
 * @package mitsa
 */

get_header();

/*
 * Resuelve la imagen de fondo del banner:
 *   1) imagen destacada de la página (si el editor la define), o
 *   2) primer candidato disponible en la biblioteca (marina / aviación).
 * Se degrada con elegancia: si no hay imagen, .mitsa-page-hero cae al fondo
 * navy plano definido en el tema.
 */
$mitsa_hero_img = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : '';

if ( ! $mitsa_hero_img ) {
	$mitsa_hero_candidatos = array(
		'passenger_airplanes_ships_517418_1920x1080',
		'mitza',
		'embarcacion-de-servicio-acuicola-en-el-mar',
		'hero_',
	);

	foreach ( $mitsa_hero_candidatos as $mitsa_slug ) {
		$mitsa_attachment = get_page_by_path( $mitsa_slug, OBJECT, 'attachment' );

		if ( $mitsa_attachment ) {
			$mitsa_url = wp_get_attachment_image_url( $mitsa_attachment->ID, 'full' );

			if ( $mitsa_url ) {
				$mitsa_hero_img = $mitsa_url;
				break;
			}
		}
	}
}

$mitsa_hero_attrs = $mitsa_hero_img
	? ' style="background-image:url(\'' . esc_url( $mitsa_hero_img ) . '\');"'
	: '';
?>

<section class="mitsa-page-hero mitsa-page-hero--center"<?php echo $mitsa_hero_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- construido con esc_url arriba. ?>>
	<div class="mitsa-container">
		<div class="mitsa-page-hero__inner">
			<span class="mitsa-kicker"><?php esc_html_e( 'Nosotros', 'mitsa' ); ?></span>
			<h1><?php esc_html_e( 'Todos tenemos una especialidad, "La nuestra es servir"', 'mitsa' ); ?></h1>
			<p class="mitsa-page-hero__lead">
				<?php esc_html_e( 'Representación técnica de marcas líderes mundiales en tratamiento de aguas y equipos marinos, con ingeniería confiable desde 1982.', 'mitsa' ); ?>
			</p>
		</div>
	</div>
</section>

<div class="mitsa-container">

	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<section class="mitsa-section mitsa-reveal" aria-labelledby="mitsa-quienes-title">
				<div class="mitsa-panel">
					<span class="mitsa-kicker"><?php esc_html_e( 'Quiénes somos', 'mitsa' ); ?></span>
					<h2 id="mitsa-quienes-title" class="mitsa-panel__title">
						<?php esc_html_e( 'Trayectoria y compromiso', 'mitsa' ); ?>
					</h2>

					<p>
						<?php esc_html_e( 'Somos una empresa pionera en introducir tecnología avanzada en el segmento sanitario para uso marino, aviación, pesquero, acuícola, minero, industrial, comercial y residencial. Hemos seleccionado y representamos a las compañías inventoras más importantes y líderes en el mercado mundial en sus respectivas especialidades en varios países de América Latina.', 'mitsa' ); ?>
					</p>
				</div>
			</section>

			<section class="mitsa-section mitsa-reveal" aria-labelledby="mitsa-proposito-title">
				<span class="mitsa-kicker"><?php esc_html_e( 'Nuestro propósito', 'mitsa' ); ?></span>
				<h2 id="mitsa-proposito-title" class="mitsa-section__title">
					<?php esc_html_e( 'Misión y Visión', 'mitsa' ); ?>
				</h2>

				<div class="mitsa-grid mitsa-grid--2">
					<div class="mitsa-panel mitsa-panel--accent mitsa-reveal" style="--i:0">
						<h3 class="mitsa-panel__title"><?php esc_html_e( 'Misión', 'mitsa' ); ?></h3>
						<p>
							<?php esc_html_e( 'Otorgar los mejores servicios de asistencia técnica (pre y post venta), de garantía de buen funcionamiento y de partes y piezas de todos nuestros equipamientos orientados a nuestros clientes y usuarios de manera integral, velando siempre por lograr la plena satisfacción de nuestros clientes.', 'mitsa' ); ?>
						</p>
					</div>

					<div class="mitsa-panel mitsa-panel--alt mitsa-reveal" style="--i:1">
						<h3 class="mitsa-panel__title"><?php esc_html_e( 'Visión', 'mitsa' ); ?></h3>
						<p>
							<?php esc_html_e( 'Ser una de las empresas más innovadoras en la entrega de nuestros servicios considerando los más altos niveles de excelencia, confianza y seguridad en un ambiente de cooperación y desarrollo, entre nuestra empresa, las empresas que representamos y nuestros clientes.', 'mitsa' ); ?>
						</p>
					</div>
				</div>
			</section>

			<section class="mitsa-section mitsa-reveal" aria-labelledby="mitsa-contacto-cta-title">
				<div class="mitsa-panel mitsa-panel--accent">
					<h2 id="mitsa-contacto-cta-title" class="mitsa-panel__title">
						<?php esc_html_e( '¿Tiene dudas sobre nuestros productos y representaciones?', 'mitsa' ); ?>
					</h2>
					<p>
						<?php esc_html_e( 'Nuestro equipo técnico está disponible para asesorarle en la solución que su operación necesita.', 'mitsa' ); ?>
					</p>
					<p>
						<a class="mitsa-btn mitsa-btn--accent" href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>">
							<?php esc_html_e( 'Contáctanos', 'mitsa' ); ?>
						</a>
					</p>
				</div>
			</section>

		</article>

	<?php endwhile; ?>

</div>

<?php
get_footer();
