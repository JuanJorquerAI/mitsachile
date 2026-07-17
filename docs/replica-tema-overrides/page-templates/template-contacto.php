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
		 * Réplica del formulario de contacto del sitio actual (Contact Form 7).
		 * Campos: Nombre, Email, Asunto, Mensaje. En el sitio original el campo
		 * "Asunto" estaba mal declarado como type="email"; aquí se corrige a
		 * type="text" (ver content/sitio-actual/09-contacto.md).
		 *
		 * TODO: integrar con un plugin real de formularios (Contact Form 7 /
		 * WPForms) antes de producción. Este marcado no procesa envíos.
		 */
		?>
		<form class="mitsa-form" method="post" action="">
			<div class="mitsa-form__field">
				<label for="mitsa-contacto-nombre"><?php esc_html_e( 'Nombre', 'mitsa' ); ?></label>
				<input type="text" id="mitsa-contacto-nombre" name="mitsa_contacto_nombre" autocomplete="name" required>
			</div>

			<div class="mitsa-form__field">
				<label for="mitsa-contacto-email"><?php esc_html_e( 'Email', 'mitsa' ); ?></label>
				<input type="email" id="mitsa-contacto-email" name="mitsa_contacto_email" autocomplete="email" required>
			</div>

			<div class="mitsa-form__field">
				<label for="mitsa-contacto-asunto"><?php esc_html_e( 'Asunto', 'mitsa' ); ?></label>
				<input type="text" id="mitsa-contacto-asunto" name="mitsa_contacto_asunto">
			</div>

			<div class="mitsa-form__field">
				<label for="mitsa-contacto-mensaje"><?php esc_html_e( 'Mensaje', 'mitsa' ); ?></label>
				<textarea id="mitsa-contacto-mensaje" name="mitsa_contacto_mensaje" rows="6" required></textarea>
			</div>

			<button type="submit">
				<?php esc_html_e( 'Enviar', 'mitsa' ); ?>
			</button>
		</form>
	</section>

</div>

<?php
get_footer();
