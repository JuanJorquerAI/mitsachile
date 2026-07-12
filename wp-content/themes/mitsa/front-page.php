<?php
/**
 * Template de portada (Home).
 *
 * Andamiaje estructural mínimo — secciones a definir con el diseño visual
 * final. Por ahora: hero simple + acceso a las 5 categorías de producto +
 * llamado a contacto.
 *
 * @package mitsa
 */

get_header();
?>

<div class="mitsa-container">

	<section class="mitsa-hero" aria-labelledby="mitsa-hero-title">
		<h1 id="mitsa-hero-title">
			<?php bloginfo( 'name' ); ?>
		</h1>
		<p>
			<?php
			// TODO: reemplazar por el copy definitivo de portada (ver content/).
			esc_html_e( 'Representantes de marcas líderes mundiales en tecnología de tratamiento de aguas y equipos marinos.', 'mitsa' );
			?>
		</p>
	</section>

	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		<?php endwhile; ?>
	<?php endif; ?>

	<section class="mitsa-home-categorias" aria-labelledby="mitsa-home-categorias-title">
		<h2 id="mitsa-home-categorias-title">
			<?php esc_html_e( 'Categorías de producto', 'mitsa' ); ?>
		</h2>

		<?php
		$mitsa_categorias = get_terms(
			array(
				'taxonomy'   => 'categoria-producto',
				'hide_empty' => false,
			)
		);
		?>

		<?php if ( ! is_wp_error( $mitsa_categorias ) && ! empty( $mitsa_categorias ) ) : ?>
			<ul class="mitsa-categorias-producto">
				<?php foreach ( $mitsa_categorias as $mitsa_categoria ) : ?>
					<li>
						<a href="<?php echo esc_url( get_term_link( $mitsa_categoria ) ); ?>">
							<?php echo esc_html( $mitsa_categoria->name ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</section>

</div>

<?php
get_footer();
