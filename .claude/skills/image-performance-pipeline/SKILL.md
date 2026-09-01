---
name: image-performance-pipeline
description: Estándares de optimización de imágenes para Core Web Vitals (LCP < 2.5s, CLS 0), renderizado responsive (srcset, sizes, WebP/AVIF), alt text descriptivo administrable vía WP REST API, y control estricto de prioridades de carga (fetchpriority=high y loading=eager en hero vs loading=lazy abajo).
---

# Image Performance Pipeline Skill

Esta skill define la gestión integral de imágenes en el frontend y backend de MITSA, optimizando tanto el posicionamiento SEO como las métricas de rendimiento en móviles y escritorio.

## Reglas de Arquitectura de Imágenes

1. **Largest Contentful Paint (LCP) Optimization**:
   - Toda imagen en la sección Hero (above-the-fold) debe usar:
     - `loading="eager"`
     - `decoding="async"`
     - `fetchpriority="high"`
   - Nunca usar `loading="lazy"` en la primera pantalla.
2. **Cumulative Layout Shift (CLS = 0)**:
   - Toda imagen debe especificar `width` y `height` intrínsecos o una relación de aspecto CSS (`aspect-ratio: 16/9`, `object-fit: cover`) para que el navegador reserve el espacio antes de la descarga.
3. **Alt Text Accesible y Administrable**:
   - Todo atributo `alt` debe provenir del campo `alt_text` del attachment de WordPress REST API.
   - El texto alternativo debe ser conciso, descriptivo y sin frases redundantes como "imagen de" o "foto de".
4. **Formatos Modernos y Responsive**:
   - Servir formatos WebP o AVIF con dimensiones adaptadas al viewport del usuario mediante `srcset` y `sizes`.
