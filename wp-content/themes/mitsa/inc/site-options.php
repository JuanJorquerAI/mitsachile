<?php
/**
 * Opciones Globales del Sitio (Header, Footer, Marca, Contacto y Redes)
 *
 * Provee interfaz de administración nativa en WordPress con integración
 * a la Biblioteca de Medios (wp.media) y almacenamiento en la tabla wp_options,
 * expuesto a través de la API REST /wp-json/mitsa/v1/options.
 *
 * @package Mitsa
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Habilita subida de archivos SVG en la Biblioteca de Medios de WordPress.
 *
 * @param array $mimes Tipos MIME permitidos.
 * @return array
 */
function mitsa_allow_svg_upload( $mimes ) {
	$mimes['svg']  = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'mitsa_allow_svg_upload' );

/**
 * Encola los scripts de la Biblioteca de Medios (wp.media) en la página de opciones.
 *
 * @param string $hook_suffix Sufijo de la página actual en WP Admin.
 */
function mitsa_site_options_enqueue_media( $hook_suffix ) {
	if ( 'toplevel_page_mitsa-site-options' === $hook_suffix ) {
		wp_enqueue_media();
	}
}
add_action( 'admin_enqueue_scripts', 'mitsa_site_options_enqueue_media' );

/**
 * Obtiene las opciones globales del sitio con valores por defecto.
 *
 * @return array
 */
function mitsa_get_site_options() {
	$theme_uri = get_template_directory_uri();
	$defaults  = array(
		'brand'   => array(
			'name'       => 'MITSA SpA',
			'tagline'    => 'Integramos tecnología. Resolvemos desafíos.',
			'since'      => 'Desde 1982',
			'logo_main'  => '/images/mitsa-27703545.svg',
			'logo_white' => '/images/mitsa-0e284396.svg',
			'favicon'    => '/favicon.ico',
		),
		'header'  => array(
			'announcement'        => '',
			'btn_repuestos_label' => 'Repuestos',
			'btn_repuestos_url'   => '/contacto/?tipo=repuestos',
			'btn_cta_label'       => 'Conversemos',
			'btn_cta_url'         => '/contacto/',
		),
		'footer'  => array(
			'statement_prefix'     => 'Integramos',
			'statement_prefix_sub' => 'tecnología.',
			'statement_suffix'     => 'Resolvemos',
			'statement_suffix_sub' => 'desafíos.',
			'description'          => 'Ingeniería de aplicación, suministro, retrofit y soporte postventa para sistemas marítimos e industriales.',
			'location'             => 'Reñaca, Viña del Mar · Chile',
			'copyright'            => '© 2026 MITSA SpA. Todos los derechos reservados.',
			'agency_name'          => 'AplicacionesWeb',
			'agency_url'           => 'https://aplicacionesweb.cl',
		),
		'contact' => array(
			'email_general' => 'contacto@mitsachile.com',
			'email_sales'   => 'fjdelaiglesia@mitsachile.com',
			'phone_main'    => '+56 32 2835055',
			'phone_mobile'  => '+56 9 9876 5432',
			'address'       => 'Av. Edmundo Eluchans 1737, Of. 61, Reñaca, Viña del Mar, Chile',
			'whatsapp'      => '+56998765432',
		),
		'social'  => array(
			'linkedin'    => 'https://www.linkedin.com/company/mitsa-chile',
			'catalog_pdf' => '/recursos/catalogo-general-mitsa.pdf',
			'smm_expo'    => '/smm2026/',
		),
	);

	$saved = get_option( 'mitsa_site_options', array() );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}

	return array_replace_recursive( $defaults, $saved );
}

/**
 * Registra el menú de Opciones Globales en WP Admin.
 */
function mitsa_register_site_options_menu() {
	add_menu_page(
		__( 'Opciones Globales del Sitio', 'mitsa' ),
		__( '⚙️ Opciones del Sitio', 'mitsa' ),
		'manage_options',
		'mitsa-site-options',
		'mitsa_render_site_options_page',
		'dashicons-admin-generic',
		2
	);
}
add_action( 'admin_menu', 'mitsa_register_site_options_menu' );

/**
 * Renderiza la interfaz de configuración en WP Admin.
 */
function mitsa_render_site_options_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Procesar guardado si se envió formulario
	if ( isset( $_POST['mitsa_options_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mitsa_options_nonce'] ) ), 'mitsa_save_options' ) ) {
		$opts = array(
			'brand'   => array(
				'name'       => isset( $_POST['brand_name'] ) ? sanitize_text_field( wp_unslash( $_POST['brand_name'] ) ) : '',
				'tagline'    => isset( $_POST['brand_tagline'] ) ? sanitize_text_field( wp_unslash( $_POST['brand_tagline'] ) ) : '',
				'since'      => isset( $_POST['brand_since'] ) ? sanitize_text_field( wp_unslash( $_POST['brand_since'] ) ) : '',
				'logo_main'  => isset( $_POST['brand_logo_main'] ) ? esc_url_raw( wp_unslash( $_POST['brand_logo_main'] ) ) : '',
				'logo_white' => isset( $_POST['brand_logo_white'] ) ? esc_url_raw( wp_unslash( $_POST['brand_logo_white'] ) ) : '',
				'favicon'    => isset( $_POST['brand_favicon'] ) ? esc_url_raw( wp_unslash( $_POST['brand_favicon'] ) ) : '',
			),
			'header'  => array(
				'announcement'        => isset( $_POST['header_announcement'] ) ? sanitize_text_field( wp_unslash( $_POST['header_announcement'] ) ) : '',
				'btn_repuestos_label' => isset( $_POST['btn_repuestos_label'] ) ? sanitize_text_field( wp_unslash( $_POST['btn_repuestos_label'] ) ) : '',
				'btn_repuestos_url'   => isset( $_POST['btn_repuestos_url'] ) ? sanitize_text_field( wp_unslash( $_POST['btn_repuestos_url'] ) ) : '',
				'btn_cta_label'       => isset( $_POST['btn_cta_label'] ) ? sanitize_text_field( wp_unslash( $_POST['btn_cta_label'] ) ) : '',
				'btn_cta_url'         => isset( $_POST['btn_cta_url'] ) ? sanitize_text_field( wp_unslash( $_POST['btn_cta_url'] ) ) : '',
			),
			'footer'  => array(
				'statement_prefix'     => isset( $_POST['footer_statement_prefix'] ) ? sanitize_text_field( wp_unslash( $_POST['footer_statement_prefix'] ) ) : '',
				'statement_prefix_sub' => isset( $_POST['footer_statement_prefix_sub'] ) ? sanitize_text_field( wp_unslash( $_POST['footer_statement_prefix_sub'] ) ) : '',
				'statement_suffix'     => isset( $_POST['footer_statement_suffix'] ) ? sanitize_text_field( wp_unslash( $_POST['footer_statement_suffix'] ) ) : '',
				'statement_suffix_sub' => isset( $_POST['footer_statement_suffix_sub'] ) ? sanitize_text_field( wp_unslash( $_POST['footer_statement_suffix_sub'] ) ) : '',
				'description'          => isset( $_POST['footer_description'] ) ? sanitize_textarea_field( wp_unslash( $_POST['footer_description'] ) ) : '',
				'location'             => isset( $_POST['footer_location'] ) ? sanitize_text_field( wp_unslash( $_POST['footer_location'] ) ) : '',
				'copyright'            => isset( $_POST['footer_copyright'] ) ? sanitize_text_field( wp_unslash( $_POST['footer_copyright'] ) ) : '',
				'agency_name'          => isset( $_POST['footer_agency_name'] ) ? sanitize_text_field( wp_unslash( $_POST['footer_agency_name'] ) ) : '',
				'agency_url'           => isset( $_POST['footer_agency_url'] ) ? esc_url_raw( wp_unslash( $_POST['footer_agency_url'] ) ) : '',
			),
			'contact' => array(
				'email_general' => isset( $_POST['contact_email_general'] ) ? sanitize_email( wp_unslash( $_POST['contact_email_general'] ) ) : '',
				'email_sales'   => isset( $_POST['contact_email_sales'] ) ? sanitize_email( wp_unslash( $_POST['contact_email_sales'] ) ) : '',
				'phone_main'    => isset( $_POST['contact_phone_main'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_phone_main'] ) ) : '',
				'phone_mobile'  => isset( $_POST['contact_phone_mobile'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_phone_mobile'] ) ) : '',
				'address'       => isset( $_POST['contact_address'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_address'] ) ) : '',
				'whatsapp'      => isset( $_POST['contact_whatsapp'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_whatsapp'] ) ) : '',
			),
			'social'  => array(
				'linkedin'    => isset( $_POST['social_linkedin'] ) ? esc_url_raw( wp_unslash( $_POST['social_linkedin'] ) ) : '',
				'catalog_pdf' => isset( $_POST['social_catalog_pdf'] ) ? sanitize_text_field( wp_unslash( $_POST['social_catalog_pdf'] ) ) : '',
				'smm_expo'    => isset( $_POST['social_smm_expo'] ) ? sanitize_text_field( wp_unslash( $_POST['social_smm_expo'] ) ) : '',
			),
		);

		update_option( 'mitsa_site_options', $opts );
		echo '<div class="notice notice-success is-dismissible"><p><strong>' . esc_html__( 'Opciones globales guardadas correctamente.', 'mitsa' ) . '</strong></p></div>';
	}

	$options   = mitsa_get_site_options();
	$theme_uri = get_template_directory_uri();

	// Helper para resolver URL de vista previa (si es relativa /images/... usar la URI del tema)
	$resolve_preview = function( $path, $default_filename ) use ( $theme_uri ) {
		if ( empty( $path ) ) {
			return $theme_uri . '/assets/images/' . $default_filename;
		}
		if ( strpos( $path, 'http' ) === 0 ) {
			return $path;
		}
		if ( strpos( $path, '/images/' ) === 0 ) {
			return $theme_uri . '/assets/images/' . basename( $path );
		}
		return $path;
	};

	$logo_main_preview  = $resolve_preview( $options['brand']['logo_main'], 'mitsa-27703545.svg' );
	$logo_white_preview = $resolve_preview( $options['brand']['logo_white'], 'mitsa-0e284396.svg' );
	?>
	<div class="wrap" style="max-width: 1040px;">
		<h1 style="font-size: 24px; font-weight: 800; color: #0D1B2A; margin-bottom: 20px;">
			⚙️ Opciones Globales del Sitio (MITSA)
		</h1>
		<p style="color: #64748B; font-size: 14px; margin-bottom: 24px;">
			Administre el logo principal, datos de cabecera, pie de página, números de contacto y redes sociales para todo el sitio web.
		</p>

		<form method="post" action="" style="background: #FFFFFF; border: 1px solid #CBD5E1; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,0.04); overflow: hidden;">
			<?php wp_nonce_field( 'mitsa_save_options', 'mitsa_options_nonce' ); ?>

			<!-- Barra de pestañas -->
			<div class="mitsa-tabs-nav" style="display: flex; background: #F8FAFC; border-bottom: 1px solid #E2E8F0; padding: 0 16px; overflow-x: auto;">
				<button type="button" class="tab-btn active" data-tab="tab-brand" style="padding: 14px 20px; border: none; background: transparent; font-weight: 700; color: #0D1B2A; border-bottom: 3px solid #E63946; cursor: pointer; white-space: nowrap;">🏛️ Marca & Logos</button>
				<button type="button" class="tab-btn" data-tab="tab-header" style="padding: 14px 20px; border: none; background: transparent; font-weight: 600; color: #64748B; border-bottom: 3px solid transparent; cursor: pointer; white-space: nowrap;">🧭 Header</button>
				<button type="button" class="tab-btn" data-tab="tab-footer" style="padding: 14px 20px; border: none; background: transparent; font-weight: 600; color: #64748B; border-bottom: 3px solid transparent; cursor: pointer; white-space: nowrap;">📋 Footer</button>
				<button type="button" class="tab-btn" data-tab="tab-contact" style="padding: 14px 20px; border: none; background: transparent; font-weight: 600; color: #64748B; border-bottom: 3px solid transparent; cursor: pointer; white-space: nowrap;">📞 Contacto & Teléfonos</button>
				<button type="button" class="tab-btn" data-tab="tab-social" style="padding: 14px 20px; border: none; background: transparent; font-weight: 600; color: #64748B; border-bottom: 3px solid transparent; cursor: pointer; white-space: nowrap;">🌐 Redes & Enlaces</button>
			</div>

			<div style="padding: 32px 28px;">
				<!-- Tab 1: Marca & Logos -->
				<div id="tab-brand" class="tab-content" style="display: block;">
					<h3 style="margin-top: 0; color: #0D1B2A; border-bottom: 1px solid #E2E8F0; padding-bottom: 10px;">Identidad de Marca y Logos</h3>
					<table class="form-table" role="presentation">
						<tr>
							<th scope="row"><label for="brand_name">Nombre de Marca</label></th>
							<td><input name="brand_name" type="text" id="brand_name" value="<?php echo esc_attr( $options['brand']['name'] ); ?>" class="regular-text" /></td>
						</tr>
						<tr>
							<th scope="row"><label for="brand_tagline">Slogan Institucional</label></th>
							<td><input name="brand_tagline" type="text" id="brand_tagline" value="<?php echo esc_attr( $options['brand']['tagline'] ); ?>" class="large-text" /></td>
						</tr>
						<tr>
							<th scope="row"><label for="brand_since">Año / Trayectoria</label></th>
							<td><input name="brand_since" type="text" id="brand_since" value="<?php echo esc_attr( $options['brand']['since'] ); ?>" class="regular-text" /></td>
						</tr>

						<!-- Campo Logo Principal con Uploader de Medios -->
						<tr>
							<th scope="row"><label>Logo Principal (Fondo Claro)</label></th>
							<td>
								<div class="mitsa-media-field" data-target="brand_logo_main" data-preview="preview_logo_main" data-bg="light">
									<div style="margin-bottom: 12px; background: #F8F6F0; padding: 16px 20px; border-radius: 8px; display: inline-block; border: 1px solid #CBD5E1; min-width: 220px; text-align: center;">
										<img id="preview_logo_main" src="<?php echo esc_url( $logo_main_preview ); ?>" alt="Vista previa logo principal" style="height: 42px; width: auto; max-width: 260px; display: inline-block;" />
									</div>
									<div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
										<input type="text" name="brand_logo_main" id="brand_logo_main" value="<?php echo esc_attr( $options['brand']['logo_main'] ); ?>" class="large-text" style="max-width: 450px;" />
										<button type="button" class="button button-secondary mitsa-upload-media-btn" data-field="brand_logo_main" data-preview="preview_logo_main" data-title="Seleccionar Logo Principal">
											<span class="dashicons dashicons-admin-media" style="vertical-align: middle; margin-top: -2px;"></span> Subir / Elegir de Medios
										</button>
										<button type="button" class="button mitsa-remove-media-btn" data-field="brand_logo_main" data-preview="preview_logo_main" data-default="<?php echo esc_url( $theme_uri . '/assets/images/mitsa-27703545.svg' ); ?>">
											Quitar
										</button>
									</div>
									<p class="description" style="margin-top: 6px;">Seleccione un archivo SVG, PNG o WebP desde la biblioteca de medios de WordPress.</p>
								</div>
							</td>
						</tr>

						<!-- Campo Logo Blanco con Uploader de Medios -->
						<tr>
							<th scope="row"><label>Logo Blanco (Fondo Oscuro / Footer)</label></th>
							<td>
								<div class="mitsa-media-field" data-target="brand_logo_white" data-preview="preview_logo_white" data-bg="dark">
									<div style="margin-bottom: 12px; background: #0D1B2A; padding: 16px 20px; border-radius: 8px; display: inline-block; border: 1px solid #1B263B; min-width: 220px; text-align: center;">
										<img id="preview_logo_white" src="<?php echo esc_url( $logo_white_preview ); ?>" alt="Vista previa logo blanco" style="height: 42px; width: auto; max-width: 260px; display: inline-block;" />
									</div>
									<div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
										<input type="text" name="brand_logo_white" id="brand_logo_white" value="<?php echo esc_attr( $options['brand']['logo_white'] ); ?>" class="large-text" style="max-width: 450px;" />
										<button type="button" class="button button-secondary mitsa-upload-media-btn" data-field="brand_logo_white" data-preview="preview_logo_white" data-title="Seleccionar Logo Blanco">
											<span class="dashicons dashicons-admin-media" style="vertical-align: middle; margin-top: -2px;"></span> Subir / Elegir de Medios
										</button>
										<button type="button" class="button mitsa-remove-media-btn" data-field="brand_logo_white" data-preview="preview_logo_white" data-default="<?php echo esc_url( $theme_uri . '/assets/images/mitsa-0e284396.svg' ); ?>">
											Quitar
										</button>
									</div>
									<p class="description" style="margin-top: 6px;">Versión monocromática o blanca para pie de página y fondos azul marino.</p>
								</div>
							</td>
						</tr>
					</table>
				</div>

				<!-- Tab 2: Header -->
				<div id="tab-header" class="tab-content" style="display: none;">
					<h3 style="margin-top: 0; color: #0D1B2A; border-bottom: 1px solid #E2E8F0; padding-bottom: 10px;">Cabecera & Botones de Acción</h3>
					<table class="form-table" role="presentation">
						<tr>
							<th scope="row"><label for="btn_repuestos_label">Botón Repuestos (Texto)</label></th>
							<td><input name="btn_repuestos_label" type="text" id="btn_repuestos_label" value="<?php echo esc_attr( $options['header']['btn_repuestos_label'] ); ?>" class="regular-text" /></td>
						</tr>
						<tr>
							<th scope="row"><label for="btn_repuestos_url">Botón Repuestos (URL)</label></th>
							<td><input name="btn_repuestos_url" type="text" id="btn_repuestos_url" value="<?php echo esc_attr( $options['header']['btn_repuestos_url'] ); ?>" class="large-text" /></td>
						</tr>
						<tr>
							<th scope="row"><label for="btn_cta_label">Botón Principal CTA (Texto)</label></th>
							<td><input name="btn_cta_label" type="text" id="btn_cta_label" value="<?php echo esc_attr( $options['header']['btn_cta_label'] ); ?>" class="regular-text" /></td>
						</tr>
						<tr>
							<th scope="row"><label for="btn_cta_url">Botón Principal CTA (URL)</label></th>
							<td><input name="btn_cta_url" type="text" id="btn_cta_url" value="<?php echo esc_attr( $options['header']['btn_cta_url'] ); ?>" class="large-text" /></td>
						</tr>
					</table>
				</div>

				<!-- Tab 3: Footer -->
				<div id="tab-footer" class="tab-content" style="display: none;">
					<h3 style="margin-top: 0; color: #0D1B2A; border-bottom: 1px solid #E2E8F0; padding-bottom: 10px;">Pie de Página (Footer)</h3>
					<table class="form-table" role="presentation">
						<tr>
							<th scope="row"><label for="footer_statement_prefix">Frase Grande - Línea 1</label></th>
							<td>
								<input name="footer_statement_prefix" type="text" id="footer_statement_prefix" value="<?php echo esc_attr( $options['footer']['statement_prefix'] ); ?>" placeholder="Integramos" style="width: 180px;" />
								<input name="footer_statement_prefix_sub" type="text" id="footer_statement_prefix_sub" value="<?php echo esc_attr( $options['footer']['statement_prefix_sub'] ); ?>" placeholder="tecnología." style="width: 180px;" />
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="footer_statement_suffix">Frase Grande - Línea 2</label></th>
							<td>
								<input name="footer_statement_suffix" type="text" id="footer_statement_suffix" value="<?php echo esc_attr( $options['footer']['statement_suffix'] ); ?>" placeholder="Resolvemos" style="width: 180px;" />
								<input name="footer_statement_suffix_sub" type="text" id="footer_statement_suffix_sub" value="<?php echo esc_attr( $options['footer']['statement_suffix_sub'] ); ?>" placeholder="desafíos." style="width: 180px;" />
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="footer_description">Descripción Institucional</label></th>
							<td><textarea name="footer_description" id="footer_description" rows="3" class="large-text"><?php echo esc_textarea( $options['footer']['description'] ); ?></textarea></td>
						</tr>
						<tr>
							<th scope="row"><label for="footer_location">Sede y Ubicación</label></th>
							<td><input name="footer_location" type="text" id="footer_location" value="<?php echo esc_attr( $options['footer']['location'] ); ?>" class="regular-text" /></td>
						</tr>
						<tr>
							<th scope="row"><label for="footer_copyright">Texto de Copyright</label></th>
							<td><input name="footer_copyright" type="text" id="footer_copyright" value="<?php echo esc_attr( $options['footer']['copyright'] ); ?>" class="large-text" /></td>
						</tr>
					</table>
				</div>

				<!-- Tab 4: Contacto -->
				<div id="tab-contact" class="tab-content" style="display: none;">
					<h3 style="margin-top: 0; color: #0D1B2A; border-bottom: 1px solid #E2E8F0; padding-bottom: 10px;">Canales de Contacto Directo</h3>
					<table class="form-table" role="presentation">
						<tr>
							<th scope="row"><label for="contact_email_general">Email General</label></th>
							<td><input name="contact_email_general" type="email" id="contact_email_general" value="<?php echo esc_attr( $options['contact']['email_general'] ); ?>" class="regular-text" /></td>
						</tr>
						<tr>
							<th scope="row"><label for="contact_email_sales">Email Operaciones / Ventas</label></th>
							<td><input name="contact_email_sales" type="email" id="contact_email_sales" value="<?php echo esc_attr( $options['contact']['email_sales'] ); ?>" class="regular-text" /></td>
						</tr>
						<tr>
							<th scope="row"><label for="contact_phone_main">Teléfono Fijo Central</label></th>
							<td><input name="contact_phone_main" type="text" id="contact_phone_main" value="<?php echo esc_attr( $options['contact']['phone_main'] ); ?>" class="regular-text" /></td>
						</tr>
						<tr>
							<th scope="row"><label for="contact_phone_mobile">WhatsApp / Móvil</label></th>
							<td><input name="contact_phone_mobile" type="text" id="contact_phone_mobile" value="<?php echo esc_attr( $options['contact']['phone_mobile'] ); ?>" class="regular-text" /></td>
						</tr>
						<tr>
							<th scope="row"><label for="contact_address">Dirección Completa</label></th>
							<td><input name="contact_address" type="text" id="contact_address" value="<?php echo esc_attr( $options['contact']['address'] ); ?>" class="large-text" /></td>
						</tr>
					</table>
				</div>

				<!-- Tab 5: Redes -->
				<div id="tab-social" class="tab-content" style="display: none;">
					<h3 style="margin-top: 0; color: #0D1B2A; border-bottom: 1px solid #E2E8F0; padding-bottom: 10px;">Redes Sociales & Accesos Rápidos</h3>
					<table class="form-table" role="presentation">
						<tr>
							<th scope="row"><label for="social_linkedin">Perfil de LinkedIn</label></th>
							<td><input name="social_linkedin" type="url" id="social_linkedin" value="<?php echo esc_attr( $options['social']['linkedin'] ); ?>" class="large-text" /></td>
						</tr>
						<tr>
							<th scope="row"><label for="social_catalog_pdf">Descarga Catálogo General (PDF)</label></th>
							<td><input name="social_catalog_pdf" type="text" id="social_catalog_pdf" value="<?php echo esc_attr( $options['social']['catalog_pdf'] ); ?>" class="large-text" /></td>
						</tr>
						<tr>
							<th scope="row"><label for="social_smm_expo">Landing SMM Hamburgo 2026</label></th>
							<td><input name="social_smm_expo" type="text" id="social_smm_expo" value="<?php echo esc_attr( $options['social']['smm_expo'] ); ?>" class="regular-text" /></td>
						</tr>
					</table>
				</div>
			</div>

			<div style="background: #F8FAFC; padding: 20px 28px; border-top: 1px solid #E2E8F0; display: flex; justify-content: flex-end;">
				<button type="submit" class="button button-primary" style="background: #0D1B2A; border-color: #0D1B2A; font-weight: 700; padding: 6px 24px; font-size: 14px; height: auto;">
					Guardar Opciones Globales
				</button>
			</div>
		</form>
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			// 1. Manejo de Pestañas
			var tabBtns = document.querySelectorAll('.tab-btn');
			var tabContents = document.querySelectorAll('.tab-content');

			tabBtns.forEach(function(btn) {
				btn.addEventListener('click', function() {
					var target = this.getAttribute('data-tab');

					tabBtns.forEach(function(b) {
						b.classList.remove('active');
						b.style.color = '#64748B';
						b.style.borderBottomColor = 'transparent';
					});

					tabContents.forEach(function(c) {
						c.style.display = 'none';
					});

					this.classList.add('active');
					this.style.color = '#0D1B2A';
					this.style.borderBottomColor = '#E63946';

					var activeContent = document.getElementById(target);
					if (activeContent) {
						activeContent.style.display = 'block';
					}
				});
			});

			// 2. Integración nativa con wp.media (Biblioteca de Medios)
			var mediaFrames = {};

			document.querySelectorAll('.mitsa-upload-media-btn').forEach(function(button) {
				button.addEventListener('click', function(e) {
					e.preventDefault();

					var fieldId = this.getAttribute('data-field');
					var previewId = this.getAttribute('data-preview');
					var modalTitle = this.getAttribute('data-title') || 'Seleccionar Archivo de Medios';

					if (mediaFrames[fieldId]) {
						mediaFrames[fieldId].open();
						return;
					}

					mediaFrames[fieldId] = wp.media({
						title: modalTitle,
						button: {
							text: 'Usar este archivo'
						},
						multiple: false
					});

					mediaFrames[fieldId].on('select', function() {
						var attachment = mediaFrames[fieldId].state().get('selection').first().toJSON();
						var inputField = document.getElementById(fieldId);
						var previewImg = document.getElementById(previewId);

						if (inputField) {
							inputField.value = attachment.url;
						}
						if (previewImg) {
							previewImg.src = attachment.url;
						}
					});

					mediaFrames[fieldId].open();
				});
			});

			// 3. Botón Quitar / Restaurar Imagen
			document.querySelectorAll('.mitsa-remove-media-btn').forEach(function(button) {
				button.addEventListener('click', function(e) {
					e.preventDefault();
					var fieldId = this.getAttribute('data-field');
					var previewId = this.getAttribute('data-preview');
					var defaultSrc = this.getAttribute('data-default');

					var inputField = document.getElementById(fieldId);
					var previewImg = document.getElementById(previewId);

					if (inputField) {
						inputField.value = '';
					}
					if (previewImg && defaultSrc) {
						previewImg.src = defaultSrc;
					}
				});
			});
		});
	</script>
	<?php
}
