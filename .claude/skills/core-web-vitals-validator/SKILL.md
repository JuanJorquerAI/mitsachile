---
name: core-web-vitals-validator
description: Estándares de velocidad y rendimiento de nivel empresarial (Core Web Vitals) para el sitio web de MITSA. Define umbrales de LCP (< 2.5s), CLS (< 0.1), INP (< 200ms) y TTFB (< 800ms), así como buenas prácticas de fuentes, preloads, render-blocking scripts y CSS crítico.
---

# Core Web Vitals Validator Skill

Esta skill define las métricas de rendimiento web y las técnicas de ingeniería requeridas para garantizar puntuaciones de 95-100 en Google Lighthouse y PageSpeed Insights.

## Presupuesto de Rendimiento (Performance Budget)

| Métrica | Umbral Verde (Good) | Estrategia Técnica |
| :--- | :--- | :--- |
| **LCP** (Largest Contentful Paint) | < 2.5s | Preload de fuentes críticas, `fetchpriority="high"` en imagen principal, cero JS bloqueante en `<head>`, SSG con TTFB < 50ms. |
| **CLS** (Cumulative Layout Shift) | < 0.1 (objetivo: 0.00) | Dimensiones explícitas (`width`/`height` o `aspect-ratio`) en imágenes y contenedores dinámicos. Fuentes con `font-display: swap`. |
| **INP** (Interaction to Next Paint) | < 200ms | Hidratación parcial (islas de Astro), event listeners pasivos, JS ultra-ligero (< 20KB total). |
| **TTFB** (Time to First Byte) | < 800ms (SSG < 50ms) | Compilación estática pre-renderizada servida desde Hostinger/CDN. |

## Auditorías Previas al Despliegue

Cada sección modular debe ser evaluada para verificar que no agregue bloqueos de renderizado ni cambios de diseño no contenidos.
