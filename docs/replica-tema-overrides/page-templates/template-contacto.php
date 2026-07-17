<?php
/**
 * Template Name: MITSA — Contacto
 * Description: Página "Contacto". Réplica mejorada del contacto del sitio actual:
 * page-hero de cabecera + layout de dos columnas (formulario a la izquierda,
 * datos de contacto y mapa a la derecha). Formulario HTML básico sin lógica de
 * envío (ver TODO más abajo). Datos reales tomados de
 * content/sitio-actual/09-contacto.md.
 *
 * @package mitsa
 */

get_header();

// Coordenadas del pin (content/sitio-actual/09-contacto.md).
$mitsa_lat = -32.97226;
$mitsa_lng = -71.53574;

// Bounding box pequeño alrededor del pin para el embed de OpenStreetMap
// (sin API key). Marker en las coordenadas exactas.
$mitsa_bbox_lng_min = $mitsa_lng - 0.006;
$mitsa_bbox_lat_min = $mitsa_lat - 0.004;
$mitsa_bbox_lng_max = $mitsa_lng + 0.006;
$mitsa_bbox_lat_max = $mitsa_lat + 0.004;

// URL del embed de OpenStreetMap (sin API key). Se construye con '&' plano;
// esc_url() en el atributo src se encarga del escapado correcto.
$mitsa_map_src = 'https://www.openstreetmap.org/export/embed.html'
	. '?bbox=' . rawurlencode( $mitsa_bbox_lng_min . ',' . $mitsa_bbox_lat_min . ',' . $mitsa_bbox_lng_max . ',' . $mitsa_bbox_lat_max )
	. '&layer=mapnik'
	. '&marker=' . rawurlencode( $mitsa_lat . ',' . $mitsa_lng );

$mitsa_map_link = 'https://www.openstreetmap.org/?mlat=' . rawurlencode( (string) $mitsa_lat ) . '&mlon=' . rawurlencode( (string) $mitsa_lng ) . '#map=17/' . $mitsa_lat . '/' . $mitsa_lng;

// Teléfonos: etiqueta visible + versión tel: (sin espacios).
$mitsa_telefonos = array(
	array(
		'label' => '+56 32 2834052',
		'tel'   => '+56322834052',
	),
	array(
		'label' => '+56 32 2485196',
		'tel'   => '+56322485196',
	),
	array(
		'label' => '+56 9 9324 0162',
		'tel'   => '+56993240162',
	),
);
?>

<style>
	/* Estilo mínimo y específico para el mapa embebido de Contacto. No existe
	   una clase equivalente en el contrato (carino-clases.md §8). Reusa tokens
	   del tema; no redefine ninguna clase existente. */
	.mitsa-contacto-mapa {
		margin-top: var(--mitsa-space-md);
	}

	.mitsa-contacto-mapa iframe {
		display: block;
		width: 100%;
		height: 300px;
		border: 1px solid var(--mitsa-color-border);
		border-radius: var(--mitsa-radius-lg);
		box-shadow: var(--mitsa-shadow-sm);
	}

	.mitsa-contacto-mapa__link {
		display: inline-block;
		margin-top: var(--mitsa-space-xs, 0.5rem);
		font-size: var(--mitsa-text-sm, 0.875rem);
	}
</style>

<section class="mitsa-page-hero mitsa-page-hero--center">
	<div class="mitsa-container">
		<div class="mitsa-page-hero__inner">
			<span class="mitsa-kicker"><?php esc_html_e( 'Contacto', 'mitsa' ); ?></span>
			<h1><?php esc_html_e( 'Conversemos sobre tu proyecto', 'mitsa' ); ?></h1>
			<p class="mitsa-page-hero__lead">
				<?php esc_html_e( 'Representación técnica de marcas líderes en tratamiento de aguas y equipos marinos. Escríbenos y te responderemos a la brevedad.', 'mitsa' ); ?>
			</p>
		</div>
	</div>
</section>

<div class="mitsa-container">

	<section class="mitsa-section" aria-labelledby="mitsa-contacto-title">
		<div class="mitsa-contacto-layout">

			<!-- Columna izquierda: formulario -->
			<div class="mitsa-reveal">
				<h2 id="mitsa-contacto-title" class="mitsa-section__title">
					<?php esc_html_e( 'Escríbenos', 'mitsa' ); ?>
				</h2>
				<p>
					<?php esc_html_e( 'Ante cualquier duda o consulta sobre nuestros productos y representaciones, déjanos un mensaje en el siguiente formulario.', 'mitsa' ); ?>
				</p>

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

					<button type="submit" class="mitsa-btn mitsa-btn--accent">
						<?php esc_html_e( 'Enviar', 'mitsa' ); ?>
					</button>
				</form>
			</div>

			<!-- Columna derecha: datos de contacto + mapa -->
			<aside class="mitsa-reveal" aria-label="<?php esc_attr_e( 'Datos de contacto', 'mitsa' ); ?>">
				<ul class="mitsa-datos">
					<li class="mitsa-dato">
						<span class="mitsa-dato__icon" aria-hidden="true">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" role="img"><path d="M21 10c0 7-9 12-9 12s-9-5-9-12a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>
						</span>
						<span>
							<span class="mitsa-dato__label"><?php esc_html_e( 'Dirección', 'mitsa' ); ?></span>
							<span class="mitsa-dato__value">
								Avda. Vicuña Mackenna 882<br>
								Reñaca, Viña del Mar, Chile
							</span>
						</span>
					</li>

					<li class="mitsa-dato">
						<span class="mitsa-dato__icon" aria-hidden="true">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" role="img"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
						</span>
						<span>
							<span class="mitsa-dato__label"><?php esc_html_e( 'Teléfonos', 'mitsa' ); ?></span>
							<span class="mitsa-dato__value">
								<?php foreach ( $mitsa_telefonos as $index => $mitsa_tel ) : ?>
									<a href="tel:<?php echo esc_attr( $mitsa_tel['tel'] ); ?>"><?php echo esc_html( $mitsa_tel['label'] ); ?></a><?php echo ( $index < count( $mitsa_telefonos ) - 1 ) ? '<br>' : ''; ?>
								<?php endforeach; ?>
							</span>
						</span>
					</li>

					<li class="mitsa-dato">
						<span class="mitsa-dato__icon" aria-hidden="true">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" role="img"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
						</span>
						<span>
							<span class="mitsa-dato__label"><?php esc_html_e( 'Email', 'mitsa' ); ?></span>
							<span class="mitsa-dato__value">
								<a href="mailto:info@mitsachile.com">info@mitsachile.com</a>
							</span>
						</span>
					</li>
				</ul>

				<div class="mitsa-contacto-mapa">
					<iframe
						title="<?php esc_attr_e( 'Ubicación de MITSA en el mapa', 'mitsa' ); ?>"
						src="<?php echo esc_url( $mitsa_map_src ); ?>"
						width="100%"
						height="300"
						loading="lazy"
						referrerpolicy="no-referrer-when-downgrade"
						style="border:0;"></iframe>
					<a class="mitsa-contacto-mapa__link" href="<?php echo esc_url( $mitsa_map_link ); ?>" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Ver mapa más grande', 'mitsa' ); ?>
					</a>
				</div>
			</aside>

		</div>
	</section>

</div>

<?php
get_footer();
