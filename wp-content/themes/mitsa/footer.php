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
	<div class="mitsa-container site-footer__inner">
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

		<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
			<div class="footer-widgets">
				<?php dynamic_sidebar( 'footer-1' ); ?>
			</div>
		<?php endif; ?>

		<p class="site-footer__copy">
			&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.
			<?php esc_html_e( 'Todos los derechos reservados.', 'mitsa' ); ?>
		</p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
