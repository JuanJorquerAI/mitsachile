<?php
/**
 * Template de portada (Home).
 *
 * Estructura: hero + contenido editable + grid de categorías, seguido de las
 * secciones comerciales de la Home: destacado BWTS/regulatorio, marcas
 * representadas, sectores, por qué MITSA y CTA de cierre.
 *
 * Copy: content/01-home.md (P10). Solo se publican marcas confirmadas del
 * brochure; no se incluyen Ervor/EGGE (DECISIONS #5) ni Cathelco/Evac/Uson
 * Marine (DECISIONS #7).
 *
 * @package mitsa
 */

get_header();
?>

<section class="mitsa-hero" aria-labelledby="mitsa-hero-title">
	<div class="mitsa-container mitsa-hero__inner">
		<span class="mitsa-kicker"><?php esc_html_e( 'Tecnología para el cuidado del medio ambiente acuático', 'mitsa' ); ?></span>
		<h1 id="mitsa-hero-title">
			<?php esc_html_e( 'Soluciones técnicas en tratamiento de aguas y equipos marinos', 'mitsa' ); ?>
		</h1>
		<p class="mitsa-hero__lead">
			<?php esc_html_e( 'Representamos a fabricantes líderes mundiales en tecnología sanitaria, marina y ambiental. Desde 1982 llevamos ingeniería especializada a la industria naval, acuícola, minera e industrial de Chile y Latinoamérica.', 'mitsa' ); ?>
		</p>
		<div class="mitsa-hero__actions">
			<a class="mitsa-btn mitsa-btn--accent" href="<?php echo esc_url( home_url( '/productos/' ) ); ?>">
				<?php esc_html_e( 'Ver productos', 'mitsa' ); ?>
			</a>
			<a class="mitsa-btn mitsa-btn--ghost-light" href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>">
				<?php esc_html_e( 'Contáctanos', 'mitsa' ); ?>
			</a>
		</div>
	</div>
</section>

<div class="mitsa-container">

	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php if ( trim( get_the_content() ) ) : ?>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>
		<?php endwhile; ?>
	<?php endif; ?>

	<section class="mitsa-home-categorias mitsa-section" aria-labelledby="mitsa-home-categorias-title">
		<span class="mitsa-kicker"><?php esc_html_e( 'Áreas de solución', 'mitsa' ); ?></span>
		<h2 id="mitsa-home-categorias-title" class="mitsa-section__title">
			<?php esc_html_e( 'Tecnología especializada, por línea de negocio', 'mitsa' ); ?>
		</h2>
		<p class="mitsa-lead">
			<?php esc_html_e( 'Representamos y damos soporte técnico a equipos para el tratamiento de aguas, la operación marina y la protección ambiental.', 'mitsa' ); ?>
		</p>

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
					<?php
					$mitsa_cat_link = get_term_link( $mitsa_categoria );
					if ( is_wp_error( $mitsa_cat_link ) ) {
						continue;
					}
					?>
					<li>
						<h3>
							<a href="<?php echo esc_url( $mitsa_cat_link ); ?>">
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

<?php // Bloque 2 — Destacado regulatorio (BWTS): diferenciador comercial #1. ?>
<section class="mitsa-section mitsa-section--destacado" aria-labelledby="mitsa-home-bwts-title">
	<div class="mitsa-container">
		<span class="mitsa-kicker"><?php esc_html_e( 'Cumplimiento normativo', 'mitsa' ); ?></span>
		<h2 id="mitsa-home-bwts-title" class="mitsa-section__title">
			<?php esc_html_e( '¿Su flota cumple la norma D-2 de agua de lastre?', 'mitsa' ); ?>
		</h2>
		<div class="mitsa-stack">
			<p>
				<?php esc_html_e( 'El Convenio BWM de la OMI exige que todo Plan de Gestión de Agua de Lastre cumpla el estándar D-2, y DIRECTEMAR ya fiscaliza en terreno en puertos chilenos. Representamos sistemas de tratamiento de agua de lastre (BWTS) certificados para poner su operación en regla.', 'mitsa' ); ?>
			</p>
			<div class="mitsa-cluster">
				<a class="mitsa-btn mitsa-btn--accent" href="<?php echo esc_url( home_url( '/productos/' ) ); ?>">
					<?php esc_html_e( 'Conocer BWTS', 'mitsa' ); ?>
				</a>
			</div>
		</div>
	</div>
</section>

<?php // Bloque 3 — Marcas representadas. Solo marcas confirmadas del brochure. ?>
<section class="mitsa-section mitsa-section--alt" aria-labelledby="mitsa-home-marcas-title">
	<div class="mitsa-container">
		<span class="mitsa-kicker"><?php esc_html_e( 'Representadas', 'mitsa' ); ?></span>
		<h2 id="mitsa-home-marcas-title" class="mitsa-section__title">
			<?php esc_html_e( 'Representamos a los líderes de cada especialidad', 'mitsa' ); ?>
		</h2>
		<div class="mitsa-stack">
			<p class="mitsa-lead">
				<?php esc_html_e( 'Desde 1982 traemos a Chile y Latinoamérica a las compañías inventoras y líderes del mercado mundial en su rubro, con respaldo técnico local.', 'mitsa' ); ?>
			</p>

			<?php
			// Marcas confirmadas en el brochure. Ampliar solo con validación del cliente.
			$mitsa_marcas = array( 'Erma First', 'Herborner Pumpen', 'EPE' );
			?>
			<div class="mitsa-grid mitsa-grid--3">
				<?php foreach ( $mitsa_marcas as $mitsa_marca ) : ?>
					<article class="mitsa-card mitsa-card--representada">
						<div class="mitsa-card__body">
							<h3 class="mitsa-card__title"><?php echo esc_html( $mitsa_marca ); ?></h3>
						</div>
					</article>
				<?php endforeach; ?>
			</div>

			<p class="mitsa-notice"><?php esc_html_e( 'Logos de representadas — pendientes de carga.', 'mitsa' ); ?></p>

			<div class="mitsa-cluster">
				<a class="mitsa-btn mitsa-btn--outline" href="<?php echo esc_url( home_url( '/representadas/' ) ); ?>">
					<?php esc_html_e( 'Ver representadas', 'mitsa' ); ?>
				</a>
			</div>
		</div>
	</div>
</section>

<?php // Bloque 4 — Sectores que atendemos. ?>
<section class="mitsa-section" aria-labelledby="mitsa-home-sectores-title">
	<div class="mitsa-container">
		<span class="mitsa-kicker"><?php esc_html_e( 'Sectores', 'mitsa' ); ?></span>
		<h2 id="mitsa-home-sectores-title" class="mitsa-section__title">
			<?php esc_html_e( 'Al servicio de las industrias que mueven a Chile', 'mitsa' ); ?>
		</h2>
		<div class="mitsa-stack">
			<p class="mitsa-lead">
				<?php esc_html_e( 'Naval y marino, acuícola, pesquero, minero, industrial y municipal. Adaptamos tecnología probada a las exigencias de cada operación.', 'mitsa' ); ?>
			</p>

			<?php $mitsa_sectores = array( 'Naval', 'Acuícola', 'Pesquero', 'Minero', 'Industrial', 'Municipal' ); ?>
			<div class="mitsa-cluster">
				<?php foreach ( $mitsa_sectores as $mitsa_sector ) : ?>
					<span class="mitsa-badge mitsa-badge--navy"><?php echo esc_html( $mitsa_sector ); ?></span>
				<?php endforeach; ?>
			</div>

			<div class="mitsa-cluster">
				<a class="mitsa-btn mitsa-btn--outline" href="<?php echo esc_url( home_url( '/sectores/' ) ); ?>">
					<?php esc_html_e( 'Ver sectores', 'mitsa' ); ?>
				</a>
			</div>
		</div>
	</div>
</section>

<?php // Bloque 5 — Por qué MITSA (confianza). Solo puntos verificables del brochure. ?>
<section class="mitsa-section mitsa-section--alt" aria-labelledby="mitsa-home-porque-title">
	<div class="mitsa-container">
		<span class="mitsa-kicker"><?php esc_html_e( 'Por qué MITSA', 'mitsa' ); ?></span>
		<h2 id="mitsa-home-porque-title" class="mitsa-section__title">
			<?php esc_html_e( 'Cuatro décadas de especialización técnica', 'mitsa' ); ?>
		</h2>

		<?php
		$mitsa_confianza = array(
			array(
				'titulo' => __( 'Desde 1982', 'mitsa' ),
				'texto'  => __( 'Más de 40 años representando tecnología de punta en el rubro.', 'mitsa' ),
			),
			array(
				'titulo' => __( 'Representación de líderes mundiales', 'mitsa' ),
				'texto'  => __( 'Fabricantes inventores en su especialidad, con presencia global.', 'mitsa' ),
			),
			array(
				'titulo' => __( 'Soporte técnico local', 'mitsa' ),
				'texto'  => __( 'No solo vendemos equipos: acompañamos la operación en terreno.', 'mitsa' ),
			),
			array(
				'titulo' => __( 'Foco ambiental', 'mitsa' ),
				'texto'  => __( 'Tecnología para el cuidado del medio ambiente acuático.', 'mitsa' ),
			),
		);
		?>
		<div class="mitsa-grid mitsa-grid--4">
			<?php foreach ( $mitsa_confianza as $mitsa_i => $mitsa_punto ) : ?>
				<article class="mitsa-card">
					<div class="mitsa-card__body">
						<span class="mitsa-card__eyebrow"><?php echo esc_html( sprintf( '%02d', $mitsa_i + 1 ) ); ?></span>
						<h3 class="mitsa-card__title"><?php echo esc_html( $mitsa_punto['titulo'] ); ?></h3>
						<p class="mitsa-card__excerpt"><?php echo esc_html( $mitsa_punto['texto'] ); ?></p>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php // Bloque 6 — CTA de cierre / contacto. ?>
<section class="mitsa-section mitsa-section--destacado" aria-labelledby="mitsa-home-cta-title">
	<div class="mitsa-container">
		<span class="mitsa-kicker"><?php esc_html_e( 'Contacto', 'mitsa' ); ?></span>
		<h2 id="mitsa-home-cta-title" class="mitsa-section__title">
			<?php esc_html_e( '¿Necesita una solución técnica para su operación?', 'mitsa' ); ?>
		</h2>
		<div class="mitsa-stack">
			<p>
				<?php esc_html_e( 'Cuéntenos su requerimiento y nuestro equipo lo orientará hacia el equipo o sistema adecuado.', 'mitsa' ); ?>
			</p>
			<div class="mitsa-cluster">
				<a class="mitsa-btn mitsa-btn--accent" href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>">
					<?php esc_html_e( 'Contáctanos', 'mitsa' ); ?>
				</a>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
