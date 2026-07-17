<?php
/**
 * Template Name: MITSA — Productos
 * Description: Página "Productos" (líneas de negocio). Da a la página la misma
 * cabecera `.mitsa-page-hero` que el resto de páginas interiores (Nosotros,
 * Representaciones) — kicker + título + bajada — y luego renderiza el cuerpo
 * editable (`the_content`) con las tarjetas de línea de negocio. El pulido de
 * hover y el scroll-reveal son heredados del tema; las tarjetas del contenido
 * llevan `.mitsa-reveal` (ver docs/replica-tema-overrides/carino-clases.md).
 *
 * @package mitsa
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<section class="mitsa-page-hero mitsa-page-hero--center">
		<div class="mitsa-container">
			<div class="mitsa-page-hero__inner">
				<span class="mitsa-kicker"><?php esc_html_e( 'Catálogo', 'mitsa' ); ?></span>
				<?php the_title( '<h1>', '</h1>' ); ?>
				<p class="mitsa-page-hero__lead">
					<?php esc_html_e( 'Equipos y sistemas para el tratamiento de aguas, la operación marina y la protección ambiental. Explore nuestras líneas de negocio.', 'mitsa' ); ?>
				</p>
			</div>
		</div>
	</section>

	<div class="mitsa-container">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</article>
	</div>

	<?php
endwhile;

get_footer();
