# Títulos y meta descriptions — sitio ACTUAL de mitsachile.com

Estos metadatos son para las páginas que **existen hoy** en producción, mientras
se construye el sitio nuevo. Son un puente: mejoran el snippet en Google apenas
se abra la indexación, sin esperar al relanzamiento.

Alineados con `content/seo-keywords.md` v2, pero conservadores: no prometen
páginas ni marcas que el sitio actual no tiene.

Longitudes objetivo: **title ≤ 60 caracteres**, **meta description 140–160**.

| Página | Title propuesto | Meta description propuesta |
|---|---|---|
| Home `/` | `MITSA: Tratamiento de Aguas y Equipos Marinos` (46) | `Representamos marcas líderes mundiales en tratamiento de aguas, equipos marinos y ambientales. Soluciones técnicas para el sector naval, industrial y acuícola en Chile desde 1982.` (177 → recortar a: `Representantes de marcas líderes en tratamiento de aguas y equipos marinos y ambientales. Soluciones técnicas para el sector naval e industrial en Chile desde 1982.` = 160) |
| Nosotros `/nosotros/` | `Sobre MITSA: 40 Años en Tecnología Marina` (42) | `MITSA representa desde 1982 a fabricantes líderes en tratamiento de aguas y equipos marinos. Conoce nuestra trayectoria y respaldo técnico en Chile.` (146) |
| Productos `/tt-service/productos/` | `Productos: Tratamiento de Aguas y Equipos Marinos` (49) | `Sistemas de tratamiento de aguas, equipos sanitarios marinos, bombas y soluciones ambientales para buques e industria. Catálogo técnico de MITSA en Chile.` (154) |
| Representaciones `/representaciones/` | `Marcas Representadas por MITSA en Chile` (39) | `MITSA representa en Chile a fabricantes líderes mundiales en tecnología de tratamiento de aguas y equipos marinos. Conoce nuestras marcas representadas.` (150) |
| Noticias `/noticias/` | `Noticias y Columnas Técnicas \| MITSA` (37) | `Actualidad técnica y regulatoria del sector marino, acuícola e industrial: normativa OMI/MARPOL, tratamiento de aguas y novedades de MITSA.` (137) |
| Contacto `/contacto/` | `Contacto \| MITSA Chile` (23) | `Contáctanos para soluciones en tratamiento de aguas y equipos marinos. MITSA, Av. Vicuña Mackenna 882, Viña del Mar. Tel. +56 32 2834052.` (135) |

## Nota sobre la meta de la Home

La versión final recomendada (160 caracteres exactos):

> Representantes de marcas líderes en tratamiento de aguas y equipos marinos y ambientales. Soluciones técnicas para el sector naval e industrial en Chile desde 1982.

## Cómo aplicar

- **Con Yoast SEO** (si se instala en producción): editar cada página → sección
  "Yoast SEO" al pie del editor → campos "Título SEO" y "Meta descripción".
- **Sin plugin SEO** (situación actual): el tema `logiscargo` no expone estos
  campos. La forma más limpia es instalar Yoast en producción (gratis) y
  cargarlos ahí. Instalar Yoast también genera el `sitemap.xml` automáticamente,
  con lo que el `sitemap.xml` manual de este paquete deja de ser necesario.

## Dato corregido para DECISIONS.md

La decisión abierta #6 dice que teléfono y email "no existen en ninguna fuente
disponible". **Sí existen, publicados en el propio sitio actual:**
- Teléfono: **+56 32 2834052**
- Emails: **info@mitsachile.com** y **evacequips@mitsachile.com**
- Dirección: **Av. Vicuña Mackenna 882, Viña del Mar (Reñaca)**

Confirmar con el cliente que siguen vigentes antes de publicarlos en el sitio nuevo.
