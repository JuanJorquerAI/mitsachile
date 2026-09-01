---
name: enterprise-seo-schema
description: Competencia para la arquitectura y auditoría de SEO técnico de nivel enterprise en MITSA. Cubre meta tags dinámicos, Open Graph, Twitter Cards, jerarquía estricta de encabezados (un H1 único, H2/H3 semánticos), y generación modular de Schema.org JSON-LD (Organization, WebSite, WebPage, Service, Product, FAQPage, BreadcrumbList).
---

# Enterprise SEO & Structured Data Skill

Esta skill gobierna la estrategia de posicionamiento técnico para MITSA, asegurando que cada sección y página cumpla con los estándares más rigurosos de indexación y comprensión para motores de búsqueda y LLMs (AEO/GEO).

## Principios de SEO Técnico

1. **Jerarquía Semántica Estricta**:
   - Cada página contiene exactamente un `<h1>` alineado a la palabra clave primaria sin competencia directa (ej. *Ingeniería Sanitaria Marina, BWTS, Protección Catódica ICCP*).
   - Los subtítulos de sección usan `<h2>` y las tarjetas o ítems usan `<h3>`.
2. **Metadatos Dinámicos**:
   - `title`: Entre 50 y 60 caracteres. Formato: `Título de Página | MITSA` o `Propuesta de Valor — MITSA`.
   - `description`: Entre 140 y 160 caracteres con llamada a la acción implícita y términos clave.
   - `canonical`: URL canónica absoluta autodefinida.
3. **Open Graph & Social Cards**:
   - `og:title`, `og:description`, `og:image` (1200x630px), `og:url`, `og:type` ('website' o 'article').
   - `twitter:card` ('summary_large_image').
4. **Structured Data JSON-LD Modular (@graph)**:
   - Toda página incluye el grafo unificado con `Organization` y `WebSite`.
   - Páginas de servicios agregan entidades `Service` o `Product`.
   - Secciones con preguntas frecuentes agregan `FAQPage` con `mainEntity: [{ @type: 'Question', name, acceptedAnswer }]`.
   - Migas de pan enriquecidas con `BreadcrumbList`.

## Validación Automatizada

Todo componente o sección debe pasar tests de validación JSON-LD y jerarquía de encabezados antes de considerarse Production-Ready.
