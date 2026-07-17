<?php
/**
 * Portada (Home) — RÉPLICA del sitio actual mitsachile.com.
 *
 * Refleja la estructura del sitio actual (hero + presentación desde 1982 +
 * productos destacados + servicios + representaciones + noticias), no el
 * rediseño. Contenido real extraído en content/sitio-actual/00-home.md.
 *
 * @package mitsa
 */

get_header();

// Imagen de fondo del hero (réplica del slider del sitio actual).
$mitsa_hero_src   = wp_get_attachment_image_url( 58, 'full' );
$mitsa_hero_style = '';
if ( $mitsa_hero_src ) {
	$mitsa_hero_style = sprintf(
		' style="background-image: linear-gradient(135deg, rgba(10,42,66,0.82) 0%%, rgba(6,32,51,0.90) 100%%), url(%s); background-size: cover; background-position: center;"',
		esc_url( $mitsa_hero_src )
	);
}
?>

<section class="mitsa-hero mitsa-hero--photo" aria-labelledby="mitsa-hero-title"<?php echo $mitsa_hero_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="mitsa-container mitsa-hero__inner">
		<span class="mitsa-kicker"><?php esc_html_e( 'Tecnología para el cuidado del medio ambiente acuático', 'mitsa' ); ?></span>
		<h1 id="mitsa-hero-title"><?php esc_html_e( 'Todos tenemos una especialidad. La nuestra es servir.', 'mitsa' ); ?></h1>
		<p class="mitsa-hero__lead">
			<?php esc_html_e( 'MITSA, junto a los equipos y tecnologías de nuestras representadas, brinda soluciones técnicas concretas para el sector marino y terrestre. Empresa pionera en tecnología avanzada del segmento sanitario en Chile desde 1982.', 'mitsa' ); ?>
		</p>
		<div class="mitsa-hero__actions">
			<a class="mitsa-btn mitsa-btn--accent" href="<?php echo esc_url( home_url( '/productos/' ) ); ?>"><?php esc_html_e( 'Conoce nuestros productos', 'mitsa' ); ?></a>
			<a class="mitsa-btn mitsa-btn--ghost-light" href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>"><?php esc_html_e( 'Contáctanos', 'mitsa' ); ?></a>
		</div>
	</div>
</section>

<div class="mitsa-container">

	<?php
	// Bloque de presentación "desde 1982" (contenido de la página Inicio).
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			$mitsa_intro = trim( wp_strip_all_tags( get_the_content() ) );
			if ( '' !== $mitsa_intro ) :
				?>
				<section class="mitsa-section mitsa-intro">
					<div class="entry-content"><?php the_content(); ?></div>
				</section>
				<?php
			endif;
		endwhile;
	endif;
	?>

	<!-- Productos destacados -->
	<section class="mitsa-section" aria-labelledby="mitsa-destacados-title">
		<span class="mitsa-kicker"><?php esc_html_e( 'Productos', 'mitsa' ); ?></span>
		<h2 id="mitsa-destacados-title" class="mitsa-section__title"><?php esc_html_e( 'Productos destacados', 'mitsa' ); ?></h2>
		<p><?php esc_html_e( 'Representamos a las compañías inventoras más importantes y líderes del mercado mundial en sus especialidades.', 'mitsa' ); ?></p>
		<ul class="mitsa-grid mitsa-grid--2 mitsa-cards">
			<li class="mitsa-card mitsa-card--producto">
				<a class="mitsa-card__media" href="<?php echo esc_url( home_url( '/marina-e-industrial/' ) ); ?>" tabindex="-1" aria-hidden="true">
					<?php echo wp_get_attachment_image( 62, 'medium_large', false, array( 'alt' => __( 'Productos marinos e industriales', 'mitsa' ) ) ); ?>
				</a>
				<div class="mitsa-card__body">
					<h3 class="mitsa-card__title"><a href="<?php echo esc_url( home_url( '/marina-e-industrial/' ) ); ?>"><?php esc_html_e( 'Marina e Industrial', 'mitsa' ); ?></a></h3>
					<p class="mitsa-card__text"><?php esc_html_e( 'Amplia variedad de productos y equipos para aplicaciones marinas e industriales.', 'mitsa' ); ?></p>
					<a class="mitsa-btn mitsa-btn--ghost" href="<?php echo esc_url( home_url( '/marina-e-industrial/' ) ); ?>"><?php esc_html_e( 'Ver más', 'mitsa' ); ?></a>
				</div>
			</li>
			<li class="mitsa-card mitsa-card--producto">
				<a class="mitsa-card__media" href="<?php echo esc_url( home_url( '/terrestre-y-construccion/' ) ); ?>" tabindex="-1" aria-hidden="true">
					<?php echo wp_get_attachment_image( 61, 'medium_large', false, array( 'alt' => __( 'Equipos para el sector terrestre y de la construcción', 'mitsa' ) ) ); ?>
				</a>
				<div class="mitsa-card__body">
					<h3 class="mitsa-card__title"><a href="<?php echo esc_url( home_url( '/terrestre-y-construccion/' ) ); ?>"><?php esc_html_e( 'Terrestre y Construcción', 'mitsa' ); ?></a></h3>
					<p class="mitsa-card__text"><?php esc_html_e( 'Las mejores opciones en equipos para el sector terrestre y de la construcción.', 'mitsa' ); ?></p>
					<a class="mitsa-btn mitsa-btn--ghost" href="<?php echo esc_url( home_url( '/terrestre-y-construccion/' ) ); ?>"><?php esc_html_e( 'Ver más', 'mitsa' ); ?></a>
				</div>
			</li>
		</ul>
	</section>

</div>

<!-- Servicios -->
<section class="mitsa-section mitsa-section--alt" aria-labelledby="mitsa-servicios-title">
	<div class="mitsa-container">
		<span class="mitsa-kicker"><?php esc_html_e( 'Por qué MITSA', 'mitsa' ); ?></span>
		<h2 id="mitsa-servicios-title" class="mitsa-section__title"><?php esc_html_e( 'Respaldo técnico en cada equipo', 'mitsa' ); ?></h2>
		<ul class="mitsa-grid mitsa-grid--4 mitsa-cards">
			<li class="mitsa-card mitsa-card--servicio">
				<div class="mitsa-card__body">
					<span class="mitsa-card__icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" focusable="false">
							<path d="M4 14v-2a8 8 0 0 1 16 0v2" />
							<rect x="3" y="13" width="4" height="7" rx="1.6" />
							<rect x="17" y="13" width="4" height="7" rx="1.6" />
							<path d="M20 20a3 3 0 0 1-3 3h-3" />
						</svg>
					</span>
					<h3 class="mitsa-card__title"><?php esc_html_e( 'Asistencia técnica', 'mitsa' ); ?></h3>
					<p class="mitsa-card__text"><?php esc_html_e( 'Le asesoramos en la instalación y puesta en marcha de sus equipos.', 'mitsa' ); ?></p>
				</div>
			</li>
			<li class="mitsa-card mitsa-card--servicio">
				<div class="mitsa-card__body">
					<span class="mitsa-card__icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" focusable="false">
							<circle cx="10" cy="8" r="4" />
							<path d="M3 21v-1a6 6 0 0 1 9.2-5.1" />
							<path d="M15 18.5l2 2 4-4" />
						</svg>
					</span>
					<h3 class="mitsa-card__title"><?php esc_html_e( 'Personal calificado', 'mitsa' ); ?></h3>
					<p class="mitsa-card__text"><?php esc_html_e( 'Técnicos especializados para mantener sus equipos en funcionamiento.', 'mitsa' ); ?></p>
				</div>
			</li>
			<li class="mitsa-card mitsa-card--servicio">
				<div class="mitsa-card__body">
					<span class="mitsa-card__icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" focusable="false">
							<rect x="6" y="6" width="12" height="12" rx="2" />
							<rect x="9.5" y="9.5" width="5" height="5" rx="1" />
							<path d="M9 3v2M15 3v2M9 19v2M15 19v2M3 9h2M3 15h2M19 9h2M19 15h2" />
						</svg>
					</span>
					<h3 class="mitsa-card__title"><?php esc_html_e( 'Tecnología de punta', 'mitsa' ); ?></h3>
					<p class="mitsa-card__text"><?php esc_html_e( 'Pioneros en introducir tecnología avanzada del segmento sanitario en Chile.', 'mitsa' ); ?></p>
				</div>
			</li>
			<li class="mitsa-card mitsa-card--servicio">
				<div class="mitsa-card__body">
					<span class="mitsa-card__icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" focusable="false">
							<path d="M12 3l7 3v5c0 4.5-3 7.6-7 9-4-1.4-7-4.5-7-9V6z" />
							<path d="M9 12l2 2 4-4" />
						</svg>
					</span>
					<h3 class="mitsa-card__title"><?php esc_html_e( 'Garantía', 'mitsa' ); ?></h3>
					<p class="mitsa-card__text"><?php esc_html_e( 'Todos nuestros equipos cuentan con garantía de buen funcionamiento.', 'mitsa' ); ?></p>
				</div>
			</li>
		</ul>
	</div>
</section>

<!-- Representaciones -->
<section class="mitsa-section" aria-labelledby="mitsa-repr-title">
	<div class="mitsa-container">
		<span class="mitsa-kicker"><?php esc_html_e( 'Representaciones', 'mitsa' ); ?></span>
		<h2 id="mitsa-repr-title" class="mitsa-section__title"><?php esc_html_e( 'Representamos a los líderes de cada especialidad', 'mitsa' ); ?></h2>
		<p><?php esc_html_e( 'Desde 1982 traemos a Chile y Latinoamérica a las compañías inventoras y líderes del mercado mundial en su rubro.', 'mitsa' ); ?></p>
		<p><a class="mitsa-btn mitsa-btn--accent" href="<?php echo esc_url( home_url( '/representaciones/' ) ); ?>"><?php esc_html_e( 'Ver nuestras representaciones', 'mitsa' ); ?></a></p>
	</div>
</section>

<?php
// Noticias — últimas entradas.
$mitsa_noticias = new WP_Query(
	array(
		'post_type'      => 'post',
		'posts_per_page' => 3,
		'no_found_rows'  => true,
	)
);
if ( $mitsa_noticias->have_posts() ) :
	?>
	<section class="mitsa-section mitsa-section--alt" aria-labelledby="mitsa-noticias-title">
		<div class="mitsa-container">
			<span class="mitsa-kicker"><?php esc_html_e( 'Noticias', 'mitsa' ); ?></span>
			<h2 id="mitsa-noticias-title" class="mitsa-section__title"><?php esc_html_e( 'Últimas noticias', 'mitsa' ); ?></h2>
			<ul class="mitsa-grid mitsa-grid--3 mitsa-cards">
				<?php
				while ( $mitsa_noticias->have_posts() ) :
					$mitsa_noticias->the_post();
					?>
					<li class="mitsa-card mitsa-card--caso">
						<?php if ( has_post_thumbnail() ) : ?>
							<a class="mitsa-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
								<?php the_post_thumbnail( 'medium_large', array( 'alt' => the_title_attribute( array( 'echo' => false ) ) ) ); ?>
							</a>
						<?php endif; ?>
						<div class="mitsa-card__body">
							<h3 class="mitsa-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p class="mitsa-card__meta"><?php echo esc_html( get_the_date() ); ?></p>
							<p class="mitsa-card__text"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
							<a class="mitsa-btn mitsa-btn--ghost" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Leer más', 'mitsa' ); ?></a>
						</div>
					</li>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</ul>
		</div>
	</section>
	<?php
endif;

get_footer();
