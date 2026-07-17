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
			<li class="mitsa-card">
				<h3 class="mitsa-card__title"><?php esc_html_e( 'Asistencia técnica', 'mitsa' ); ?></h3>
				<p class="mitsa-card__text"><?php esc_html_e( 'Le asesoramos en la instalación y puesta en marcha de sus equipos.', 'mitsa' ); ?></p>
			</li>
			<li class="mitsa-card">
				<h3 class="mitsa-card__title"><?php esc_html_e( 'Personal calificado', 'mitsa' ); ?></h3>
				<p class="mitsa-card__text"><?php esc_html_e( 'Técnicos especializados para mantener sus equipos en funcionamiento.', 'mitsa' ); ?></p>
			</li>
			<li class="mitsa-card">
				<h3 class="mitsa-card__title"><?php esc_html_e( 'Tecnología de punta', 'mitsa' ); ?></h3>
				<p class="mitsa-card__text"><?php esc_html_e( 'Pioneros en introducir tecnología avanzada del segmento sanitario en Chile.', 'mitsa' ); ?></p>
			</li>
			<li class="mitsa-card">
				<h3 class="mitsa-card__title"><?php esc_html_e( 'Garantía', 'mitsa' ); ?></h3>
				<p class="mitsa-card__text"><?php esc_html_e( 'Todos nuestros equipos cuentan con garantía de buen funcionamiento.', 'mitsa' ); ?></p>
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
						<h3 class="mitsa-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p class="mitsa-card__meta"><?php echo esc_html( get_the_date() ); ?></p>
						<p class="mitsa-card__text"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
						<a class="mitsa-btn mitsa-btn--ghost" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Leer más', 'mitsa' ); ?></a>
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
