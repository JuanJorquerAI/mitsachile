# Productos 🟢 VALIDADO CON MENÚ REAL

Fuente: menú real del sitio actual + brochure. Ver `content/00-sitemap.md` para el árbol completo con badges de estado.

## Categorías

### Aguas y sanitarios
- Toilet al vacío
- Sistemas generadores de vacío
- Plantas de tratamiento de aguas servidas
- Plantas separadoras de agua sentina
- Osmosis inversa
- **Tratamiento de agua de lastre (BWTS)** 🔴 nuevo — representada: Erma First. Producto estrella del brochure, sin presencia en el menú actual. Prioridad alta para SEO (ver `content/seo-keywords.md`).

### Bombas y fluidos
- Bombas marinas
- Compresores de aire
- Cañerías, fittings y accesorios
- **Intercambiadores de calor** 🔴 nuevo

### Propulsión
- Propulsión y maniobra
- Grúas hidráulicas marinas

### Confort a bordo
- Equipos de refrigeración
- Contenedores para supermercados / trituradores orgánicos — ⚠️ ver DECISIONS.md #5 (bug de URL `/trituradores-organicos/`, revisar en CMS antes de migrar)

### Protección casco 🔴 nueva categoría (existe en brochure, no en sitio actual)
- Sistemas anticorrosión / ICCP
- Antifouling
- Ánodos de sacrificio

## Notas de implementación

- BWTS, anticorrosión e ICCP tienen 15+ páginas de contenido en el brochure — priorizar su desarrollo de contenido/ficha técnica por sobre categorías ya bien cubiertas en el sitio actual.
- Cada producto debería tener: descripción técnica breve, marca(s) representada(s) asociadas (ver `content/04-representadas.md`), ficha técnica descargable (biblioteca técnica), mercados/sectores donde aplica (cross-link a `content/05-sectores.md`).
- Estructura de contenido en WordPress: Custom Post Type `producto` con taxonomía `categoria-producto` (las 5 categorías de arriba) y taxonomía `marca` (relación con Representadas).
