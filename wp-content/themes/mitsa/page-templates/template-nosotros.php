<?php
/**
 * Template Name: MITSA — Nosotros
 * Description: Página "Nosotros". Contenido validado (ver content/02-nosotros.md).
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
			// TODO: secciones específicas de "Nosotros" (historia, misión/visión,
			// hitos) a maquetar según el diseño visual final y el contenido
			// validado en content/02-nosotros.md.
			?>
		</article>

	<?php endwhile; ?>

</div>

<?php
get_footer();
