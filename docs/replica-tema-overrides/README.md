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

## Assets e identidad visual (config en BD, respaldados en assets/)

El logo original de MITSA era blanco (para el header oscuro de LogisCargo). Se
recoloreó a navy (#0f2b47) para el header claro del tema mitsa:
- `assets/logo-mitsa-chile-navy.png` → importado y fijado como `custom_logo` (theme mod).
- `assets/favicon-isotipo-512.png` → isotipo (elipse) sobre navy, fijado como `site_icon` (option).

Para reponer en wpactual: `wp media import <asset> --path=wpactual --porcelain`,
luego `wp theme mod set custom_logo <id>` / `wp option update site_icon <id>`.

El hero de la portada usa una foto de fondo (attachment 58, mitza.jpg) con overlay
navy; las cards de Productos destacados usan fotos reales (attachments 61/62).
