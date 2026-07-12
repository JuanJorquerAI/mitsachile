# Tema MITSA

Tema WordPress custom clásico para mitsachile.com (MITSA SpA), desarrollado por
AplicacionesWeb. PHP + CSS/JS plano — sin page builder (Elementor/Divi) y sin
dependencias de build tools (webpack, etc.).

Este README documenta el estado actual del **andamiaje estructural**. El
diseño visual definitivo aún no existe: lo que hay hoy es HTML/CSS simple,
semántico y accesible, a propósito sin pretender verse "terminado".

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
  - **ACF (Advanced Custom Fields)** — para los campos custom del CPT
    `representada` (logo, descripción corta, sitio web, categorías
    asociadas). Ver TODO en `inc/cpt-representada.php`.
  - **Plugin de formulario** — Contact Form 7 o WPForms para el formulario de
    `page-templates/template-contacto.php`, que hoy es HTML estático sin
    lógica de envío.
  - **Plugin SEO** — Yoast SEO o Rank Math para producción. `inc/seo.php`
    solo trae un fallback mínimo (title tag + meta description) que se
    desactiva automáticamente si detecta Yoast o Rank Math activos.
- **Analítica.** `inc/analytics.php` deja los hooks de GA4/GTM listos pero
  comentados, a la espera de que `wp-config.php` defina `MITSA_GA4_ID` y
  `MITSA_GTM_ID`.
- **Imágenes/assets.** No hay carpeta `assets/` con imágenes aún; el tema no
  depende de ninguna por ahora (sin logo por defecto, `has_custom_logo` cae
  a texto).

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
  - `inc/` — un archivo por dominio de responsabilidad (CPTs, SEO,
    analítica). `functions.php` se mantiene corto y solo hace `require`.
  - `page-templates/` — un archivo por página con necesidades de layout
    propias; el resto usa `page.php` genérico.
- **CPTs y taxonomías:** `producto` (con `categoria-producto` y `marca`) y
  `representada`, registrados en `inc/cpt-producto.php` e
  `inc/cpt-representada.php` respectivamente. Los 5 términos iniciales de
  `categoria-producto` se crean automáticamente al activar el tema
  (`after_switch_theme`), no en cada carga de página.
