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

<section class="mitsa-hero" aria-labelledby="mitsa-hero-title">
	<div class="mitsa-container mitsa-hero__inner">
		<span class="mitsa-kicker"><?php esc_html_e( 'Tecnología de tratamiento de aguas y equipos marinos', 'mitsa' ); ?></span>
		<h1 id="mitsa-hero-title">
			<?php
			// TODO: reemplazar por el copy definitivo de portada (ver content/01-home.md, P10).
			esc_html_e( 'Ingeniería marina y ambiental de marcas líderes, representadas en Chile desde 1982.', 'mitsa' );
			?>
		</h1>
		<p class="mitsa-hero__lead">
			<?php esc_html_e( 'MITSA provee y da soporte a tecnología de tratamiento de aguas, protección de casco, propulsión y confort a bordo para la Armada, astilleros, salmoneras, navieras, minería e industria.', 'mitsa' ); ?>
		</p>
		<div class="mitsa-hero__actions">
			<a class="mitsa-btn mitsa-btn--accent" href="<?php echo esc_url( home_url( '/productos/' ) ); ?>">
				<?php esc_html_e( 'Ver productos', 'mitsa' ); ?>
			</a>
			<a class="mitsa-btn mitsa-btn--ghost-light" href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>">
				<?php esc_html_e( 'Contactar a un especialista', 'mitsa' ); ?>
			</a>
		</div>
	</div>
</section>

<div class="mitsa-container">

	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		<?php endwhile; ?>
	<?php endif; ?>

	<section class="mitsa-home-categorias mitsa-section" aria-labelledby="mitsa-home-categorias-title">
		<span class="mitsa-kicker"><?php esc_html_e( 'Áreas de solución', 'mitsa' ); ?></span>
		<h2 id="mitsa-home-categorias-title" class="mitsa-section__title">
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
		<?php endif; ?>
	</section>

</div>

<?php
get_footer();
