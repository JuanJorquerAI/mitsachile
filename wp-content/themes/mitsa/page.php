<?php
/**
 * Template base para páginas estándar (sin template específico asignado).
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

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="entry-thumbnail">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
			<?php endif; ?>

			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</article>

	<?php endwhile; ?>

</div>

<?php
get_footer();
