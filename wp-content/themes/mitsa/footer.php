<?php
/**
 * Pie de página del tema: cierre de <main>, estructura del <footer> y cierre
 * de <body>/<html>.
 *
 * @package mitsa
 */
?>
</main><!-- .site-content -->

<footer class="site-footer" role="contentinfo">
	<div class="mitsa-container">
		<div class="site-footer__cols">

			<div class="site-footer__col site-footer__col--brand">
				<p class="site-footer__brand"><?php bloginfo( 'name' ); ?></p>
				<p class="site-footer__tagline">
					<?php esc_html_e( 'Representantes de marcas líderes mundiales en tecnología de tratamiento de aguas y equipos marinos/ambientales. Ingeniería confiable desde 1982, con sede en Reñaca, Viña del Mar.', 'mitsa' ); ?>
				</p>
			</div>

			<div class="site-footer__col site-footer__col--nav">
				<h2 class="site-footer__col-title"><?php esc_html_e( 'Navegación', 'mitsa' ); ?></h2>
				<nav class="footer-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Menú de pie de página', 'mitsa' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'container'      => false,
							'menu_class'     => 'footer-menu',
							'fallback_cb'    => false,
						)
					);
					?>
				</nav>
			</div>

			<div class="site-footer__col site-footer__col--widgets">
				<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
					<div class="footer-widgets">
						<?php dynamic_sidebar( 'footer-1' ); ?>
					</div>
				<?php else : ?>
					<h2 class="site-footer__col-title"><?php esc_html_e( 'Contacto', 'mitsa' ); ?></h2>
					<p class="site-footer__tagline">
						<?php esc_html_e( 'Reñaca, Viña del Mar, Chile.', 'mitsa' ); ?>
					</p>
				<?php endif; ?>
			</div>

		</div>

		<div class="site-footer__bottom">
			<p class="site-footer__copy">
				&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.
				<?php esc_html_e( 'Todos los derechos reservados.', 'mitsa' ); ?>
			</p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
