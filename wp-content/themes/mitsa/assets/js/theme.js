/**
 * MITSA — JavaScript del tema (vanilla, sin dependencias).
 *
 * Responsabilidades:
 *   1. Navegacion responsive: abrir/cerrar el menu movil de forma accesible
 *      (aria-expanded, cierre con Escape, clic fuera y al pasar a escritorio).
 *   2. Sombra del header al hacer scroll (clase .is-scrolled).
 *
 * Presupuesto: < 10 KB, sin librerias externas. Degrada con gracia: si el
 * markup esperado no existe, cada bloque simplemente no hace nada.
 *
 * @package mitsa
 */
( function () {
	'use strict';

	var DESKTOP_BREAKPOINT = 900; // Coincide con el media query de style.css.

	/**
	 * Navegacion movil.
	 */
	function initNav() {
		var toggle = document.querySelector( '.menu-toggle' );
		var nav = document.querySelector( '.main-navigation' );

		if ( ! toggle || ! nav ) {
			return;
		}

		function closeMenu() {
			nav.classList.remove( 'is-open' );
			toggle.setAttribute( 'aria-expanded', 'false' );
		}

		function openMenu() {
			nav.classList.add( 'is-open' );
			toggle.setAttribute( 'aria-expanded', 'true' );
		}

		toggle.addEventListener( 'click', function () {
			if ( nav.classList.contains( 'is-open' ) ) {
				closeMenu();
			} else {
				openMenu();
			}
		} );

		// Cerrar con la tecla Escape y devolver el foco al boton.
		document.addEventListener( 'keydown', function ( event ) {
			if ( event.key === 'Escape' && nav.classList.contains( 'is-open' ) ) {
				closeMenu();
				toggle.focus();
			}
		} );

		// Cerrar al hacer clic fuera del header.
		document.addEventListener( 'click', function ( event ) {
			if ( ! nav.classList.contains( 'is-open' ) ) {
				return;
			}
			if ( ! nav.contains( event.target ) && ! toggle.contains( event.target ) ) {
				closeMenu();
			}
		} );

		// Al navegar dentro del menu, cerrarlo (enlaces ancla / misma pagina).
		nav.addEventListener( 'click', function ( event ) {
			var link = event.target.closest( 'a' );
			if ( link && nav.classList.contains( 'is-open' ) ) {
				closeMenu();
			}
		} );

		// Si la ventana pasa a ancho de escritorio, resetear el estado movil.
		var resizeTimer;
		window.addEventListener( 'resize', function () {
			window.clearTimeout( resizeTimer );
			resizeTimer = window.setTimeout( function () {
				if ( window.innerWidth >= DESKTOP_BREAKPOINT ) {
					closeMenu();
				}
			}, 150 );
		} );
	}

	/**
	 * Sombra del header al desplazarse.
	 */
	function initHeaderScroll() {
		var header = document.querySelector( '.site-header' );

		if ( ! header ) {
			return;
		}

		var ticking = false;

		function update() {
			if ( window.scrollY > 8 ) {
				header.classList.add( 'is-scrolled' );
			} else {
				header.classList.remove( 'is-scrolled' );
			}
			ticking = false;
		}

		window.addEventListener(
			'scroll',
			function () {
				if ( ! ticking ) {
					window.requestAnimationFrame( update );
					ticking = true;
				}
			},
			{ passive: true }
		);

		update();
	}

	function init() {
		initNav();
		initHeaderScroll();
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
}() );
