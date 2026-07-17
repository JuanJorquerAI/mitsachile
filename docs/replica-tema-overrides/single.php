<?php
/**
 * Detalle de entrada (single de Noticias).
 *
 * Usa las clases del contrato (.mitsa-single) para una lectura cómoda: imagen
 * destacada grande, meta (fecha/autor), cuerpo legible y enlace de regreso al
 * listado de Noticias.
 *
 * @package mitsa
 */

get_header();

// Enlace de regreso: la página asignada como índice de entradas, o el home.
$mitsa_blog_page_id = (int) get_option( 'page_for_posts' );
$mitsa_blog_url     = $mitsa_blog_page_id ? get_permalink( $mitsa_blog_page_id ) : home_url( '/' );
$mitsa_blog_title   = $mitsa_blog_page_id ? get_the_title( $mitsa_blog_page_id ) : __( 'Noticias', 'mitsa' );
?>

<div class="mitsa-container">

	<?php
	while ( have_posts() ) :
		the_post();
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'mitsa-single mitsa-reveal' ); ?>>

			<header>
				<div class="mitsa-single__meta">
					<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
					<span><?php echo esc_html( get_the_author() ); ?></span>
					<?php
					$mitsa_cats = get_the_category_list( ', ' );
					if ( $mitsa_cats ) :
						?>
						<span><?php echo wp_kses_post( $mitsa_cats ); ?></span>
					<?php endif; ?>
				</div>
				<h1 class="mitsa-single__title"><?php the_title(); ?></h1>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="mitsa-single__media">
					<?php the_post_thumbnail( 'large', array( 'loading' => 'eager' ) ); ?>
				</figure>
			<?php endif; ?>

			<div class="mitsa-single__content">
				<?php
				the_content();

				wp_link_pages(
					array(
						'before' => '<nav class="mitsa-single__pages" aria-label="' . esc_attr__( 'Páginas del artículo', 'mitsa' ) . '">',
						'after'  => '</nav>',
					)
				);
				?>
			</div>

			<footer>
				<p>
					<a class="mitsa-btn mitsa-btn--outline mitsa-btn--sm" href="<?php echo esc_url( $mitsa_blog_url ); ?>">
						<?php
						/* translators: %s: nombre de la sección de noticias. */
						printf( esc_html__( '← Volver a %s', 'mitsa' ), esc_html( $mitsa_blog_title ) );
						?>
					</a>
				</p>
			</footer>

		</article>

		<?php
	endwhile;
	?>

</div>

<?php
get_footer();
