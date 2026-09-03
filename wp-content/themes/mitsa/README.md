# Tema MITSA

Tema WordPress custom para mitsachile.com (MITSA SpA), desarrollado por
AplicacionesWeb. PHP + CSS/JS plano — sin page builder (Elementor/Divi) y sin
dependencias de build tools (webpack, etc.).

**Arquitectura headless:** el tema ya no es solo renderizado clásico. Expone
una API REST custom (`inc/api-sections.php`, rutas `/wp-json/mitsa/v1/*`) que
normaliza campos ACF (`inc/acf-fields.php`) y alimenta el frontend
desacoplado en `frontend/` (Astro SSG, 100% estático). Ese frontend Astro es
el sitio de producción real; los templates PHP clásicos (`front-page.php`,
`page-templates/`) quedan como capa de respaldo/preview en wp-admin y deben
mantenerse sincronizados con lo que expone la API si se siguen usando.

Este README documenta el estado actual del **andamiaje estructural**. El
diseño visual definitivo del wp-admin/preview clásico aún no existe: lo que
hay hoy es HTML/CSS simple, semántico y accesible, a propósito sin pretender
verse "terminado". El diseño real vive en `frontend/`.

## Cómo levantar el tema localmente

Este repositorio **no incluye WordPress**, solo el tema. Para probarlo hace
falta una instalación de WordPress aparte. Dos caminos:

### Opción A — LocalWP (recomendado para el equipo de diseño/contenido)

1. Instalar [Local](https://localwp.com/).
2. Crear un sitio nuevo (PHP 8.x, MySQL, cualquier servidor web).
3. Copiar (o symlink) esta carpeta a `wp-content/themes/mitsa/` dentro del
   sitio de Local.
4. Activar el tema "MITSA" desde **Apariencia → Temas** en el wp-admin.
5. Crear las páginas del sitemap (ver `content/00-sitemap.md`) y asignarles
   el page template correspondiente desde **Atributos de página**:
   - Nosotros → `MITSA — Nosotros`
   - Productos → `MITSA — Productos`
   - Sectores → `MITSA — Sectores`
   - Servicios → `MITSA — Servicios`
   - Contacto → `MITSA — Contacto`
   - Home → marcarla como página de portada estática (usa `front-page.php`
     automáticamente).
6. Crear los menús `primary` y `footer` en **Apariencia → Menús** y
   asignarlos a sus ubicaciones.

### Opción B — wp-cli + servidor local propio

```bash
# Desde la raíz de una instalación WordPress existente:
wp theme activate mitsa

# Crear páginas con su template (ejemplo):
wp post create --post_type=page --post_title="Nosotros" --post_status=publish \
  --page_template='page-templates/template-nosotros.php'
```

Requiere PHP >= 7.4 y una base de datos MySQL/MariaDB accesible por esa
instalación de WordPress.

## Qué falta

- **Diseño visual final.** `style.css` trae únicamente reset + variables CSS
  placeholder (colores, tipografía) documentadas con comentarios `TODO`. No
  hay sistema de diseño de marca todavía — se define en una etapa posterior.
- **Contenido real.** Las secciones "Sectores", "Servicios", "Contacto" y
  parte de "Representadas" están marcadas como propuestas/pendientes de
  validación del cliente (ver `content/00-sitemap.md` y `CLAUDE.md`). No
  cargar ese contenido como definitivo.
- **Plugins requeridos:**
  - **ACF (Advanced Custom Fields)** — ya implementado y es el corazón de la
    arquitectura actual: `inc/acf-fields.php` registra los grupos que
    alimentan tanto las páginas clásicas como la API REST
    (`inc/api-sections.php`) que consume el frontend Astro. Definiciones
    versionadas también en `acf-json/`.
  - **Plugin de formulario** — el formulario de contacto real vive en el
    frontend Astro (`frontend/src/components/sections/contacto/
    ContactoFormSection.astro`) y envía a un endpoint externo (Formspree),
    no a WordPress. `page-templates/template-contacto.php` (si sigue en uso)
    es HTML estático sin lógica de envío propia.
  - **Plugin SEO** — Yoast SEO o Rank Math para producción. `inc/seo.php`
    solo trae un fallback mínimo (title tag + meta description) que se
    desactiva automáticamente si detecta Yoast o Rank Math activos.
- **Analítica.** Gestionada en producción por el plugin **Site Kit**
  (GA4 + GSC operativos, GTM automático) — no hay código de analítica en
  este tema.
- **Imágenes/assets.** No hay carpeta `assets/` con imágenes aún; el tema no
  depende de ninguna por ahora (sin logo por defecto, `has_custom_logo` cae
  a texto). Las imágenes del sitio real viven en `frontend/public/`.

## Convenciones del tema

- **Prefijo de funciones:** todas las funciones globales usan `mitsa_`
  (ej. `mitsa_setup()`, `mitsa_registrar_cpt_producto()`).
- **Textdomain:** `mitsa` en todos los strings traducibles vía `__()` /
  `_e()` / `esc_html_e()`. Esto prepara el tema para una futura versión en
  inglés (ver CLAUDE.md — "Estructura preparada... sin implementar inglés en
  esta etapa"), aunque hoy no exista archivo `.pot`/`.po` cargado.
- **Escape de salida:** todo dato dinámico se imprime con `esc_html()`,
  `esc_url()`, `esc_attr()` o equivalentes.
- **Sin build tools:** CSS y JS se editan y sirven directo, sin
  transpilación ni bundling. Si se agrega `assets/js/theme.js`, se enqueuea
  automáticamente si el archivo existe (ver `functions.php`).
- **Organización:**
  - `inc/` — un archivo por dominio de responsabilidad (CPTs, SEO, campos
    ACF, opciones del sitio, API REST). `functions.php` se mantiene corto y
    solo hace `require`.
  - `page-templates/` — un archivo por página con necesidades de layout
    propias; el resto usa `page.php` genérico.
- **CPTs y taxonomías:** `producto` (con `categoria-producto` y `marca`) y
  `representada`, registrados en `inc/cpt-producto.php` e
  `inc/cpt-representada.php` respectivamente. Los 5 términos iniciales de
  `categoria-producto` se crean automáticamente al activar el tema
  (`after_switch_theme`), no en cada carga de página.
