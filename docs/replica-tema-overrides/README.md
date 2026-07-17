# Overrides del tema — sitio réplica (wpactual)

El sitio réplica del sitio actual mitsachile.com vive en `wpactual/` (gitignoreado,
WordPress 7.0.1, puerto 8892). Usa una copia del tema `mitsa` con dos archivos que
divergen del tema del rediseño (`wp-content/themes/mitsa/`):

- `front-page.php` — portada con la estructura del SITIO ACTUAL (hero "La nuestra
  es servir", presentación desde 1982, productos destacados Marina/Terrestre,
  servicios, representaciones, noticias). NO las secciones del rediseño (BWTS, etc.).
- `page-templates/template-contacto.php` — con el bug corregido: el campo "Asunto"
  es `type="text"` (en el sitio original estaba mal como `type="email"`).

Estos archivos se respaldan aquí porque `wpactual/` no se versiona. Si se pierde el
entorno local, reponer copiando estos sobre la copia del tema en wpactual.

Pendiente: formalizar el tema réplica como tema versionado propio si la réplica
avanza a producción.
