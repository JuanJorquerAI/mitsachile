# Gobernanza SEO & Structured Data (Schema.org JSON-LD)

Este documento establece las especificaciones técnicas de posicionamiento en buscadores (Google, Bing) y optimización para modelos de lenguaje (GEO/AEO).

## Grafo Unificado de Schema.org (`@graph`)

Toda página servida por el frontend genera dinámicamente un bloque `<script type="application/ld+json">` que contiene una estructura enlazada:

```json
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Organization",
      "@id": "https://mitsachile.com/#organization",
      "name": "MITSA SpA",
      "url": "https://mitsachile.com",
      "foundingDate": "1982",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Viña del Mar",
        "addressCountry": "CL"
      }
    },
    {
      "@type": "WebSite",
      "@id": "https://mitsachile.com/#website",
      "name": "MITSA",
      "publisher": { "@id": "https://mitsachile.com/#organization" }
    },
    {
      "@type": "WebPage",
      "@id": "https://mitsachile.com/#webpage",
      "name": "MITSA — Integramos tecnología. Resolvemos desafíos.",
      "isPartOf": { "@id": "https://mitsachile.com/#website" },
      "about": { "@id": "https://mitsachile.com/#organization" }
    },
    {
      "@type": "FAQPage",
      "@id": "https://mitsachile.com/#faq",
      "isPartOf": { "@id": "https://mitsachile.com/#webpage" },
      "mainEntity": [
        {
          "@type": "Question",
          "name": "¿Cómo se determina si un buque requiere sistema ICCP o ánodos de sacrificio?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Depende del perfil operativo, área mojada del casco, tiempo entre diques..."
          }
        }
      ]
    }
  ]
}
```

## Estructura Semántica de Encabezados (Heading Hierarchy)

- **H1 (Único)**: Exclusivo para la propuesta central de ingeniería (`HeroSection.astro`).
- **H2 (Secciones principales)**:
  - *"Resolvemos lo que frena un proyecto naval"* (Objeciones / Pain Points)
  - *"Quién está detrás de cada solución"* (Representadas)
  - *"Soluciones tecnológicas especializadas"* (Soluciones)
  - *"¿Por qué MITSA?"* (Diferenciadores)
  - *"Guías y análisis de ingeniería aplicada"* (Biblioteca técnica / Blog)
  - *"Preguntas frecuentes de ingeniería"* (FAQs)
- **H3 (Tarjetas e ítems de soluciones)**:
  - Fichas de sanitarios al vacío, BWTS, ICCP, etc.
