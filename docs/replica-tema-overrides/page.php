<?php
/**
 * Template base para páginas estándar (sin template específico asignado).
 *
 * Si la página tiene imagen destacada, se muestra como banner
 * `.mitsa-page-hero` (fondo + overlay navy) con el título encima. Sin imagen
 * destacada, degrada a una cabecera estándar `.entry-header`.
 *
 * @package mitsa
 */

get_header();
?>

<?php while ( have_posts() ) : ?>
	<?php the_post(); ?>

	<?php if ( has_post_thumbnail() ) : ?>
		<?php $mitsa_hero_bg = get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>
		<section class="mitsa-page-hero mitsa-page-hero--center"<?php echo $mitsa_hero_bg ? ' style="background-image:url(\'' . esc_url( $mitsa_hero_bg ) . '\');"' : ''; ?>>
			<div class="mitsa-container">
				<div class="mitsa-page-hero__inner">
					<?php the_title( '<h1>', '</h1>' ); ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<div class="mitsa-container">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php if ( ! has_post_thumbnail() ) : ?>
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</header>
			<?php endif; ?>

			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</article>
	</div>

<?php endwhile; ?>

<?php
get_footer();
