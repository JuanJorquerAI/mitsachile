/**
 * Navegación horizontal con flechas deslizantes para pestañas ACF en WP Admin.
 *
 * Mantiene todas las pestañas en una sola fila horizontal limpia y permite
 * desplazarse suavemente a la izquierda y derecha mediante botones de flecha.
 */
(function() {
  'use strict';

  function initAcfTabNav() {
    var tabWraps = document.querySelectorAll('.acf-tab-wrap');

    tabWraps.forEach(function(wrap) {
      if (wrap.dataset.mitsaNavInitialized) {
        return;
      }
      wrap.dataset.mitsaNavInitialized = 'true';

      var tabGroup = wrap.querySelector('.acf-tab-group');
      if (!tabGroup) return;

      // Crear botón Izquierda (Prev)
      var btnPrev = document.createElement('button');
      btnPrev.type = 'button';
      btnPrev.className = 'mitsa-tab-nav-btn -prev';
      btnPrev.setAttribute('aria-label', 'Desplazar pestañas a la izquierda');
      btnPrev.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>';

      // Crear botón Derecha (Next)
      var btnNext = document.createElement('button');
      btnNext.type = 'button';
      btnNext.className = 'mitsa-tab-nav-btn -next';
      btnNext.setAttribute('aria-label', 'Desplazar pestañas a la derecha');
      btnNext.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>';

      // Insertar contenedor y botones
      wrap.classList.add('mitsa-tab-wrap-enhanced');
      wrap.insertBefore(btnPrev, tabGroup);
      wrap.appendChild(btnNext);

      function updateArrowStates() {
        var scrollLeft = tabGroup.scrollLeft;
        var maxScroll = tabGroup.scrollWidth - tabGroup.clientWidth - 2;

        if (tabGroup.scrollWidth <= tabGroup.clientWidth + 5) {
          btnPrev.style.display = 'none';
          btnNext.style.display = 'none';
          wrap.classList.remove('-can-scroll-left', '-can-scroll-right');
          return;
        }

        btnPrev.style.display = 'flex';
        btnNext.style.display = 'flex';

        if (scrollLeft <= 5) {
          btnPrev.classList.add('-disabled');
          wrap.classList.remove('-can-scroll-left');
        } else {
          btnPrev.classList.remove('-disabled');
          wrap.classList.add('-can-scroll-left');
        }

        if (scrollLeft >= maxScroll - 5) {
          btnNext.classList.add('-disabled');
          wrap.classList.remove('-can-scroll-right');
        } else {
          btnNext.classList.remove('-disabled');
          wrap.classList.add('-can-scroll-right');
        }
      }

      // Eventos de clic en flechas
      btnPrev.addEventListener('click', function(e) {
        e.preventDefault();
        tabGroup.scrollBy({ left: -220, behavior: 'smooth' });
      });

      btnNext.addEventListener('click', function(e) {
        e.preventDefault();
        tabGroup.scrollBy({ left: 220, behavior: 'smooth' });
      });

      // Evento de scroll en el grupo
      tabGroup.addEventListener('scroll', updateArrowStates, { passive: true });

      // Centrar pestaña activa al hacer clic
      tabGroup.addEventListener('click', function(e) {
        var clickedTab = e.target.closest('li');
        if (clickedTab) {
          setTimeout(function() {
            clickedTab.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            updateArrowStates();
          }, 50);
        }
      });

      // Inicializar y observar cambios de tamaño
      window.addEventListener('resize', updateArrowStates);
      setTimeout(updateArrowStates, 100);
      setTimeout(updateArrowStates, 500);
    });
  }

  // Inicializar al cargar el DOM o cuando ACF esté listo
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAcfTabNav);
  } else {
    initAcfTabNav();
  }

  if (window.acf) {
    window.acf.addAction('ready', initAcfTabNav);
    window.acf.addAction('append', initAcfTabNav);
  }
})();
