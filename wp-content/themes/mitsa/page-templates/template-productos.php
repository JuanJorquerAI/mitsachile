<?php
/**
 * Template Name: MITSA — Productos
 * Description: Listado de las 5 categorías de producto (taxonomía
 * `categoria-producto`, registrada en inc/cpt-producto.php).
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
		</article>

	<?php endwhile; ?>

	<section class="mitsa-categorias-listado" aria-labelledby="mitsa-categorias-listado-title">
		<h2 id="mitsa-categorias-listado-title">
			<?php esc_html_e( 'Categorías de producto', 'mitsa' ); ?>
		</h2>

		<?php
		$mitsa_categorias_producto = get_terms(
			array(
				'taxonomy'   => 'categoria-producto',
				'hide_empty' => false,
			)
		);
		?>

		<?php if ( ! is_wp_error( $mitsa_categorias_producto ) && ! empty( $mitsa_categorias_producto ) ) : ?>
			<ul class="mitsa-categorias-producto">
				<?php foreach ( $mitsa_categorias_producto as $mitsa_categoria ) : ?>
					<li>
						<h3>
							<a href="<?php echo esc_url( get_term_link( $mitsa_categoria ) ); ?>">
								<?php echo esc_html( $mitsa_categoria->name ); ?>
							</a>
						</h3>
						<?php if ( ! empty( $mitsa_categoria->description ) ) : ?>
							<p><?php echo esc_html( $mitsa_categoria->description ); ?></p>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php else : ?>
			<p><?php esc_html_e( 'Aún no hay categorías de producto cargadas.', 'mitsa' ); ?></p>
		<?php endif; ?>
	</section>

</div>

<?php
get_footer();
