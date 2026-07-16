<?php
/**
 * mu-plugin de desarrollo local: enruta wp_mail() a Mailpit (SMTP local en
 * 127.0.0.1:1025) para que formularios/descargas gated sean verificables
 * sin depender de un proveedor de correo real. Solo debe copiarse al
 * ambiente local (ver scripts/provision.sh); nunca a producción.
 */
add_action(
	'phpmailer_init',
	function ( $phpmailer ) {
		$phpmailer->isSMTP();
		$phpmailer->Host       = '127.0.0.1';
		$phpmailer->Port       = 1025;
		$phpmailer->SMTPAuth   = false;
		$phpmailer->SMTPSecure = '';
	}
);

// wordpress@localhost no pasa la validación de PHPMailer (dominio sin TLD).
add_filter( 'wp_mail_from', fn() => 'no-reply@mitsachile.local' );
add_filter( 'wp_mail_from_name', fn() => 'MITSA (dev local)' );
