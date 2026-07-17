<?php
/**
 * Template Name: MITSA — Representaciones
 * Description: Página "Representaciones". Reemplaza el grid estático por un muro
 * de marcas vivo: page-hero de cabecera + rejilla interactiva (.mitsa-repr-grid)
 * de tarjetas .mitsa-card--representada con hover pulido y scroll-reveal
 * escalonado (.mitsa-reveal, stagger vía --i). El sitio actual usaba un carrusel;
 * aquí se logra sensación de vida con motion sobrio, sin dependencias externas.
 *
 * Los logos ya están en la biblioteca de medios (ver
 * content/sitio-actual/02-representaciones.md). Se referencian por ID de adjunto
 * para que el template sea independiente de la URL del entorno.
 *
 * @package mitsa
 */

get_header();

/**
 * Marcas representadas: nombre, país e ID del logo en la biblioteca de medios.
 * Orden y datos tomados de content/sitio-actual/02-representaciones.md (validado
 * contra el sitio actual). 'name' vacío = marca sin nombre legible en el logo;
 * en ese caso la tarjeta muestra el país como título.
 */
$mitsa_representadas = array(
	array( 'name' => 'EVAC',          'country' => 'Finlandia',        'id' => 17 ),
	array( 'name' => 'Blücher',       'country' => 'Dinamarca',        'id' => 9 ),
	array( 'name' => 'USON Marine',   'country' => 'Suecia',           'id' => 4 ),
	array( 'name' => 'Ervor',         'country' => 'Francia',          'id' => 15 ),
	array( 'name' => 'Incorr',        'country' => 'España',           'id' => 22 ),
	array( 'name' => 'Hepworth Group', 'country' => 'Inglaterra',      'id' => 23 ),
	array( 'name' => 'Osmofilter',    'country' => 'España',           'id' => 13 ),
	array( 'name' => 'ESP',           'country' => 'República Checa',  'id' => 16 ),
	array( 'name' => 'Bravo Mobarrow', 'country' => 'República Checa', 'id' => 28 ),
	array( 'name' => 'Meclube',       'country' => 'Italia',           'id' => 31 ),
	array( 'name' => 'Burks',         'country' => 'Estados Unidos',   'id' => 10 ),
	array( 'name' => 'Egger',         'country' => 'Suiza',            'id' => 14 ),
	array( 'name' => 'Haigh',         'country' => 'Inglaterra',       'id' => 20 ),
	array( 'name' => 'Herborner Pumpentechnik', 'country' => 'Alemania', 'id' => 12 ),
	array( 'name' => 'Moyno',         'country' => 'Estados Unidos',   'id' => 33 ),
	array( 'name' => 'Sterling SIHI', 'country' => 'Alemania',         'id' => 36 ),
	array( 'name' => 'Harwil',        'country' => 'Estados Unidos',   'id' => 27 ),
	array( 'name' => 'Besta',         'country' => 'Suiza',            'id' => 24 ),
	array( 'name' => 'Cram',          'country' => 'Argentina',        'id' => 25 ),
);

$mitsa_total_marcas = count( $mitsa_representadas );
?>

<section class="mitsa-page-hero mitsa-page-hero--center">
	<div class="mitsa-container">
		<div class="mitsa-page-hero__inner">
			<span class="mitsa-kicker"><?php esc_html_e( 'Representaciones', 'mitsa' ); ?></span>
			<h1><?php esc_html_e( 'Marcas líderes que representamos', 'mitsa' ); ?></h1>
			<p class="mitsa-page-hero__lead">
				<?php esc_html_e( 'Representamos en Chile a compañías inventoras y líderes mundiales en tratamiento de aguas, equipos marinos y protección ambiental, con presencia en varios países de América Latina.', 'mitsa' ); ?>
			</p>
		</div>
	</div>
</section>

<div class="mitsa-container">

	<section class="mitsa-section" aria-labelledby="mitsa-representadas-title">
		<span class="mitsa-kicker"><?php esc_html_e( 'Alianzas técnicas', 'mitsa' ); ?></span>
		<h2 id="mitsa-representadas-title" class="mitsa-section__title">
			<?php
			printf(
				/* translators: %d: número de marcas representadas. */
				esc_html__( '%d marcas representadas', 'mitsa' ),
				(int) $mitsa_total_marcas
			);
			?>
		</h2>
		<p class="mitsa-lead">
			<?php esc_html_e( 'Hemos seleccionado a los fabricantes más reconocidos en cada especialidad para entregar en Chile equipos, repuestos y respaldo técnico de nivel mundial. Pasa el cursor sobre cada marca para verla con detalle.', 'mitsa' ); ?>
		</p>

		<div class="mitsa-repr-grid">
			<?php foreach ( $mitsa_representadas as $mitsa_index => $mitsa_marca ) : ?>
				<?php
				$mitsa_has_name = ( '' !== $mitsa_marca['name'] );
				$mitsa_title    = $mitsa_has_name ? $mitsa_marca['name'] : $mitsa_marca['country'];

				// Alt descriptivo: nombre de marca cuando existe; si no, país.
				$mitsa_alt = $mitsa_has_name
					? sprintf(
						/* translators: %s: nombre de la marca. */
						esc_attr__( 'Logo %s', 'mitsa' ),
						$mitsa_marca['name']
					)
					: sprintf(
						/* translators: %s: país de origen de la marca. */
						esc_attr__( 'Logo de marca representada (%s)', 'mitsa' ),
						$mitsa_marca['country']
					);

				$mitsa_logo = wp_get_attachment_image(
					$mitsa_marca['id'],
					'medium',
					false,
					array(
						'alt'      => $mitsa_alt,
						'loading'  => 'lazy',
						'decoding' => 'async',
					)
				);

				// Si el adjunto no existe, se omite la tarjeta (nunca imagen rota).
				if ( '' === $mitsa_logo ) {
					continue;
				}

				// Stagger acotado (0–5) para que el reveal se sienta ágil aun con
				// muchas tarjetas; evita retardos largos en filas inferiores.
				$mitsa_stagger = $mitsa_index % 6;
				?>
				<article class="mitsa-card mitsa-card--representada mitsa-reveal" style="--i:<?php echo (int) $mitsa_stagger; ?>">
					<div class="mitsa-card__media">
						<?php echo $mitsa_logo; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_get_attachment_image() ya devuelve markup seguro. ?>
					</div>
					<div class="mitsa-card__body">
						<h3 class="mitsa-card__title"><?php echo esc_html( $mitsa_title ); ?></h3>
						<?php if ( $mitsa_has_name ) : ?>
							<p class="mitsa-card__meta"><?php echo esc_html( $mitsa_marca['country'] ); ?></p>
						<?php endif; ?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</section>

</div>

<?php
get_footer();
