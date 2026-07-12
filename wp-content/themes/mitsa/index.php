<?php
/**
 * Template genérico de respaldo (blog/loop por defecto).
 *
 * @package mitsa
 */

get_header();
?>

<div class="mitsa-container">

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php
					if ( is_singular() ) {
						the_title( '<h1 class="entry-title">', '</h1>' );
					} else {
						the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
					}
					?>
				</header>

				<div class="entry-content">
					<?php
					if ( is_singular() ) {
						the_content();
					} else {
						the_excerpt();
					}
					?>
				</div>
			</article>

		<?php endwhile; ?>

		<?php the_posts_navigation(); ?>

	<?php else : ?>

		<p><?php esc_html_e( 'No se encontró contenido.', 'mitsa' ); ?></p>

	<?php endif; ?>

</div>

<?php
get_footer();
