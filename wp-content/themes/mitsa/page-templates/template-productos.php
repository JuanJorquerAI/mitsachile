<?php
/**
 * Template Name: MITSA — Productos
 * Description: Landing de Productos. Muestra las categorías de la taxonomía
 * `categoria-producto` (registrada en inc/cpt-producto.php) como catálogo de
 * tarjetas enlazadas a cada término.
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

			<?php if ( trim( get_the_content() ) ) : ?>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>
		</article>

	<?php endwhile; ?>

	<section class="mitsa-categorias-listado mitsa-section" aria-labelledby="mitsa-categorias-listado-title">
		<span class="mitsa-kicker"><?php esc_html_e( 'Catálogo', 'mitsa' ); ?></span>
		<h2 id="mitsa-categorias-listado-title" class="mitsa-section__title">
			<?php esc_html_e( 'Categorías de producto', 'mitsa' ); ?>
		</h2>
		<p class="mitsa-lead">
			<?php esc_html_e( 'Representamos equipos y sistemas para el tratamiento de aguas, la operación marina y la protección ambiental. Explore por línea de negocio para ver las soluciones de cada especialidad.', 'mitsa' ); ?>
		</p>

		<?php
		$mitsa_categorias_producto = get_terms(
			array(
				'taxonomy'   => 'categoria-producto',
				'hide_empty' => false,
			)
		);
		?>

		<?php if ( ! is_wp_error( $mitsa_categorias_producto ) && ! empty( $mitsa_categorias_producto ) ) : ?>
			<div class="mitsa-grid mitsa-grid--3">
				<?php foreach ( $mitsa_categorias_producto as $mitsa_categoria ) : ?>
					<?php
					$mitsa_cat_link = get_term_link( $mitsa_categoria );
					if ( is_wp_error( $mitsa_cat_link ) ) {
						continue;
					}
					?>
					<article class="mitsa-card mitsa-card--producto mitsa-card--link">
						<div class="mitsa-card__body">
							<span class="mitsa-card__eyebrow"><?php esc_html_e( 'Línea de negocio', 'mitsa' ); ?></span>
							<h3 class="mitsa-card__title">
								<a href="<?php echo esc_url( $mitsa_cat_link ); ?>">
									<?php echo esc_html( $mitsa_categoria->name ); ?>
								</a>
							</h3>
							<?php if ( ! empty( $mitsa_categoria->description ) ) : ?>
								<p class="mitsa-card__excerpt"><?php echo esc_html( $mitsa_categoria->description ); ?></p>
							<?php endif; ?>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<p class="mitsa-notice"><?php esc_html_e( 'Aún no hay categorías de producto cargadas.', 'mitsa' ); ?></p>
		<?php endif; ?>
	</section>

</div>

<?php
get_footer();
