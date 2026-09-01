# Resiliencia de API, Core Web Vitals y Accesibilidad WCAG 2.1 AA

Este documento documenta las garantías de fiabilidad, velocidad y accesibilidad universal implementadas en la arquitectura.

## 1. Tolerancia a Fallos y Resiliencia de API

El cliente `fetchWithResilience` aplica las siguientes salvaguardas:

1. **Timeout Controlado**: AbortSignal programado a 3500ms para evitar que peticiones colgadas bloqueen la generación de páginas.
2. **Reintentos Transparentes**: Un reintento inmediato ante errores efímeros de red.
3. **Fallback Inmutable**: Dataset estático tipado que asegura que la compilación (build SSG) y la experiencia de usuario nunca sufran errores 500 ni pantallas en blanco.
4. **Registro de Advertencias**: Mensajes claros en consola con prefijo `[WP-API Offline]` para diagnóstico operacional.

## 2. Core Web Vitals Budget

- **LCP (< 2.5s)**:
  - Imagen destacada en Hero con `fetchpriority="high"` y `loading="eager"`.
  - Estilos críticos integrados en Astro.
  - Preconexión a Google Fonts (`rel="preconnect"`).
- **CLS (0.00)**:
  - Todas las imágenes tienen ancho/alto explícito (`width="800" height="600"`) y relación de aspecto CSS.
  - Fuentes cargadas con `display: swap`.
- **INP (< 200ms)**:
  - Animaciones delegadas a la GPU mediante CSS puro (`transform` y `opacity`).
  - Cero JavaScript bloqueante en el hilo principal.

## 3. Accesibilidad Universal (WCAG 2.1 Nivel AA)

- **Contraste de Color**:
  - Azul naval (`#0D1B2A`) sobre marfil (`#F8F6F0`) -> Ratio > 14:1 (exigencia mínima: 4.5:1).
  - Azul pizarra (`#415A77`) sobre marfil (`#F8F6F0`) -> Ratio > 4.8:1.
- **Navegación por Teclado**:
  - Selectores de triaje y formularios con estilos `:focus-visible` claramente delineados.
  - Áreas mínimas de toque de 44x44px.
- **Lectores de Pantalla**:
  - Clases `.sr-only` para anunciar el texto completo de las palabras rotativas.
  - Atributo `aria-hidden="true"` en los spans animados para evitar locuciones duplicadas.
