<?php
/**
 * Template Name: MITSA — Servicios
 * Description: Página "Servicios". Contenido propuesto, pendiente de validar
 * con el cliente (ver content/00-sitemap.md y CLAUDE.md).
 *
 * @package mitsa
 */

get_header();
?>

<div class="mitsa-container">

	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</header>

			<div class="entry-content">
				<?php the_content(); ?>
			</div>

			<?php
			// TODO: listado de servicios (soporte técnico, biblioteca de
			// descargas, mantención, etc.) — contenido "propuesto", pendiente
			// de validación del cliente. No tratar como final.
			?>
		</article>

	<?php endwhile; ?>

</div>

<?php
get_footer();
