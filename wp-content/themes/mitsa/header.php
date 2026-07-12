<?php
/**
 * Cabecera del tema: apertura de <html>, <head> y estructura del <header>.
 *
 * @package mitsa
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content">
	<?php esc_html_e( 'Saltar al contenido principal', 'mitsa' ); ?>
</a>

<header class="site-header" role="banner">
	<div class="mitsa-container site-header__inner">
		<div class="site-branding">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<p class="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php bloginfo( 'name' ); ?>
					</a>
				</p>
			<?php endif; ?>
		</div>

		<nav class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Menú principal', 'mitsa' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'primary-menu',
					'fallback_cb'    => false,
				)
			);
			?>
		</nav>
	</div>
</header>

<main id="main-content" class="site-content">
