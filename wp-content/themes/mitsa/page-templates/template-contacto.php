<?php
/**
 * Template Name: MITSA — Contacto
 * Description: Página "Contacto". Formulario HTML básico sin lógica de envío
 * (ver TODO más abajo). Contenido propuesto, pendiente de validar con el
 * cliente (ver content/00-sitemap.md y CLAUDE.md).
 *
 * @package mitsa
 */

get_header();
?>

<div class="mitsa-container">

	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</header>

			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</article>

	<?php endwhile; ?>

	<section class="mitsa-contacto-formulario" aria-labelledby="mitsa-contacto-formulario-title">
		<h2 id="mitsa-contacto-formulario-title">
			<?php esc_html_e( 'Escríbenos', 'mitsa' ); ?>
		</h2>

		<?php
		/**
		 * TODO: este es un formulario HTML estático sin lógica de envío.
		 * Integrar con un plugin real antes de producción — opciones
		 * recomendadas: Contact Form 7 (shortcode [contact-form-7]) o
		 * WPForms. No implementar manejo de envíos a mano en el tema salvo
		 * que se decida explícitamente lo contrario.
		 */
		?>
		<form class="mitsa-form" method="post" action="">
			<div class="mitsa-form__field">
				<label for="mitsa-contacto-nombre"><?php esc_html_e( 'Nombre', 'mitsa' ); ?></label>
				<input type="text" id="mitsa-contacto-nombre" name="mitsa_contacto_nombre" autocomplete="name" required>
			</div>

			<div class="mitsa-form__field">
				<label for="mitsa-contacto-empresa"><?php esc_html_e( 'Empresa', 'mitsa' ); ?></label>
				<input type="text" id="mitsa-contacto-empresa" name="mitsa_contacto_empresa" autocomplete="organization">
			</div>

			<div class="mitsa-form__field">
				<label for="mitsa-contacto-email"><?php esc_html_e( 'Correo electrónico', 'mitsa' ); ?></label>
				<input type="email" id="mitsa-contacto-email" name="mitsa_contacto_email" autocomplete="email" required>
			</div>

			<div class="mitsa-form__field">
				<label for="mitsa-contacto-telefono"><?php esc_html_e( 'Teléfono', 'mitsa' ); ?></label>
				<input type="tel" id="mitsa-contacto-telefono" name="mitsa_contacto_telefono" autocomplete="tel">
			</div>

			<div class="mitsa-form__field">
				<label for="mitsa-contacto-mensaje"><?php esc_html_e( 'Mensaje', 'mitsa' ); ?></label>
				<textarea id="mitsa-contacto-mensaje" name="mitsa_contacto_mensaje" rows="6" required></textarea>
			</div>

			<button type="submit" disabled>
				<?php esc_html_e( 'Enviar (pendiente de integrar)', 'mitsa' ); ?>
			</button>
		</form>
	</section>

</div>

<?php
get_footer();
