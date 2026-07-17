<?php
/**
 * Índice del blog / Noticias (page_for_posts).
 *
 * Renderiza las entradas como grid de tarjetas usando las clases del contrato
 * (.mitsa-noticias-grid / .mitsa-noticia-card). Cada tarjeta muestra imagen
 * destacada (con degradación vía has_post_thumbnail y respaldo temático marino),
 * título, fecha, extracto y enlace "Leer más".
 *
 * @package mitsa
 */

get_header();

// Título / bajada tomados de la página asignada como "página de entradas".
$mitsa_blog_page_id = (int) get_option( 'page_for_posts' );
$mitsa_blog_title   = $mitsa_blog_page_id ? get_the_title( $mitsa_blog_page_id ) : __( 'Noticias', 'mitsa' );
$mitsa_blog_lead    = $mitsa_blog_page_id ? get_post_field( 'post_excerpt', $mitsa_blog_page_id ) : '';

/**
 * Respaldo temático (marino/acuícola) para entradas sin imagen destacada.
 * Se resuelve por slug de adjunto ya importado; si no existe, se omite la media.
 */
$mitsa_fallback_thumb_id = 0;
$mitsa_fallback_slugs    = array(
	'embarcacion-de-servicio-acuicola-en-el-mar',
	'passenger_airplanes_ships_517418_1920x1080-2',
	'foto-770x310',
);
foreach ( $mitsa_fallback_slugs as $mitsa_slug ) {
	$mitsa_att = get_page_by_path( $mitsa_slug, OBJECT, 'attachment' );
	if ( $mitsa_att instanceof WP_Post ) {
		$mitsa_fallback_thumb_id = (int) $mitsa_att->ID;
		break;
	}
}
?>

<section class="mitsa-page-hero mitsa-page-hero--center">
	<div class="mitsa-container">
		<nav class="mitsa-breadcrumbs" aria-label="<?php esc_attr_e( 'Migas de pan', 'mitsa' ); ?>">
			<ol>
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Inicio', 'mitsa' ); ?></a></li>
				<li aria-current="page"><?php echo esc_html( $mitsa_blog_title ); ?></li>
			</ol>
		</nav>
		<div class="mitsa-page-hero__inner">
			<span class="mitsa-kicker"><?php esc_html_e( 'Actualidad', 'mitsa' ); ?></span>
			<h1><?php echo esc_html( $mitsa_blog_title ); ?></h1>
			<?php if ( '' !== trim( (string) $mitsa_blog_lead ) ) : ?>
				<p class="mitsa-page-hero__lead"><?php echo esc_html( $mitsa_blog_lead ); ?></p>
			<?php else : ?>
				<p class="mitsa-page-hero__lead"><?php esc_html_e( 'Novedades técnicas, columnas y proyectos destacados de MITSA.', 'mitsa' ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>

<div class="mitsa-container">
	<section class="mitsa-section" aria-label="<?php esc_attr_e( 'Listado de noticias', 'mitsa' ); ?>">

		<?php if ( have_posts() ) : ?>

			<div class="mitsa-noticias-grid">
				<?php
				$mitsa_i = 0;
				while ( have_posts() ) :
					the_post();

					$mitsa_thumb_id = has_post_thumbnail() ? get_post_thumbnail_id() : $mitsa_fallback_thumb_id;
					?>
					<article class="mitsa-noticia-card mitsa-reveal" style="--i:<?php echo esc_attr( (string) ( $mitsa_i % 3 ) ); ?>">
						<?php if ( $mitsa_thumb_id ) : ?>
							<a class="mitsa-noticia-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
								<?php
								echo wp_get_attachment_image(
									$mitsa_thumb_id,
									'medium_large',
									false,
									array(
										'alt'     => the_title_attribute( array( 'echo' => false ) ),
										'loading' => 'lazy',
									)
								);
								?>
							</a>
						<?php endif; ?>

						<div class="mitsa-noticia-card__body">
							<p class="mitsa-noticia-card__meta">
								<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							</p>
							<h2 class="mitsa-noticia-card__title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>
							<p class="mitsa-noticia-card__excerpt">
								<?php echo esc_html( wp_trim_words( get_the_excerpt(), 24, '…' ) ); ?>
							</p>
							<a class="mitsa-btn mitsa-btn--outline mitsa-btn--sm" href="<?php the_permalink(); ?>">
								<?php esc_html_e( 'Leer más', 'mitsa' ); ?>
								<span class="screen-reader-text"><?php echo esc_html( wp_strip_all_tags( get_the_title() ) ); ?></span>
							</a>
						</div>
					</article>
					<?php
					++$mitsa_i;
				endwhile;
				?>
			</div>

			<?php
			the_posts_pagination(
				array(
					'mid_size'  => 1,
					'prev_text' => esc_html__( 'Anteriores', 'mitsa' ),
					'next_text' => esc_html__( 'Siguientes', 'mitsa' ),
				)
			);
			?>

		<?php else : ?>

			<p class="mitsa-notice"><?php esc_html_e( 'Aún no hay noticias publicadas.', 'mitsa' ); ?></p>

		<?php endif; ?>

	</section>
</div>

<?php
get_footer();
