# Catálogo de componentes — Tema MITSA

> **Contrato de diseño (P2).** Este archivo es la fuente de verdad del markup
> de los componentes del tema. Los pasos posteriores (P3–P7, P10) deben usar
> **exactamente** estas clases y esta estructura HTML en sus templates. Si un
> componente necesita una variante nueva, se agrega aquí primero.
>
> - Todos los estilos viven en `wp-content/themes/mitsa/style.css` (CSS puro,
>   sin frameworks). El JS de interacción vive en `assets/js/theme.js` (vanilla).
> - Prefijo de clases: `mitsa-`. Convención BEM suelta: `bloque__elemento`,
>   `bloque--modificador`.
> - En PHP, **todo output se escapa** (`esc_html`, `esc_url`, `esc_attr`). Los
>   bloques de este documento muestran HTML ya renderizado; en los templates
>   deben envolverse con las funciones de escape correspondientes.
> - Sistema visual: azul marino profundo (`--mitsa-navy-*`) + acento técnico
>   teal (`--mitsa-teal-*`) + neutros fríos (`--mitsa-slate-*`). Contraste
>   WCAG 2.1 AA verificado en todos los pares texto/fondo.

## Índice

1. [Tokens de diseño](#1-tokens-de-diseño)
2. [Layout: contenedor, grid y secciones](#2-layout-contenedor-grid-y-secciones)
3. [Header + navegación responsive](#3-header--navegación-responsive)
4. [Footer 3 columnas](#4-footer-3-columnas)
5. [Hero](#5-hero)
6. [Botones](#6-botones)
7. [Card genérica y variantes](#7-card-genérica-y-variantes)
8. [Badges](#8-badges)
9. [Breadcrumbs](#9-breadcrumbs)
10. [Tabla de especificaciones](#10-tabla-de-especificaciones)
11. [Formularios (+ Contact Form 7)](#11-formularios--contact-form-7)
12. [Paginación](#12-paginación)
13. [Utilidades](#13-utilidades)

---

## 1. Tokens de diseño

Definidos en `:root` de `style.css`. Usar siempre las custom properties, nunca
valores hex/px sueltos en componentes nuevos.

| Grupo | Tokens principales |
|---|---|
| Marca (navy) | `--mitsa-navy-900/800/700/600/500` |
| Acento (teal) | `--mitsa-teal-700/600/500/300/050` |
| Neutros (slate) | `--mitsa-slate-900…050`, `--mitsa-white` |
| Semánticos | `--mitsa-color-primary`, `--mitsa-color-accent`, `--mitsa-color-text`, `--mitsa-color-text-muted`, `--mitsa-color-bg`, `--mitsa-color-bg-alt`, `--mitsa-color-border`, `--mitsa-color-link` |
| Estado | `--mitsa-success-700/050`, `--mitsa-warning-700/050` |
| Tipografía | `--mitsa-font-heading`, `--mitsa-font-body`, `--mitsa-font-mono` (system stack, sin CDN) |
| Escala texto | `--mitsa-text-xs…4xl` |
| Espaciado | `--mitsa-space-3xs…2xl` (escala 4pt) |
| Radios | `--mitsa-radius-sm/md/lg/pill` |
| Sombras | `--mitsa-shadow-xs/sm/md/lg` |
| Layout | `--mitsa-content-width` (1200px), `--mitsa-content-narrow` (760px) |

**Regla tipográfica:** un solo `<h1>` por página. La escala de encabezados
crece en breakpoint ≥768px.

---

## 2. Layout: contenedor, grid y secciones

Contenedor centrado (máx. 1200px) y grids fluidos mobile-first.

```html
<div class="mitsa-container">
  <!-- contenido con ancho máximo y padding lateral -->
</div>

<!-- Variante angosta para lectura larga (760px) -->
<div class="mitsa-container mitsa-container--narrow"> … </div>

<!-- Sección con encabezado (kicker + título) -->
<section class="mitsa-section">
  <div class="mitsa-container">
    <span class="mitsa-kicker">Áreas de solución</span>
    <h2 class="mitsa-section__title">Categorías de producto</h2>
    <!-- … -->
  </div>
</section>

<!-- Sección con fondo alterno (franja gris fría de ancho completo) -->
<section class="mitsa-section mitsa-section--alt">
  <div class="mitsa-container"> … </div>
</section>
```

Grids reutilizables (usar como contenedor de cards):

```html
<div class="mitsa-grid mitsa-grid--3">  <!-- 1 col móvil → 2 → 3 -->
  <!-- .mitsa-card … -->
</div>
<!-- Modificadores: --2, --3, --4, o --auto (auto-fill minmax 240px) -->
```

---

## 3. Header + navegación responsive

Header **sticky** con logo/título + navegación. En móvil (<900px) el menú
colapsa tras el botón hamburguesa; en escritorio es horizontal con submenús
desplegables. La interacción la maneja `assets/js/theme.js` (toggle accesible
con `aria-expanded`, cierre con Escape / clic fuera / resize a escritorio).

Estructura de referencia (ver `header.php`):

```html
<header class="site-header" role="banner">
  <div class="mitsa-container site-header__inner">
    <div class="site-branding">
      <!-- has_custom_logo() → the_custom_logo(); si no: -->
      <p class="site-title"><a href="/" rel="home">MITSA</a></p>
    </div>

    <button class="menu-toggle" aria-controls="mitsa-primary-nav" aria-expanded="false">
      <span class="menu-toggle__bars" aria-hidden="true"></span>
      <span class="menu-toggle__label">Menú</span>
    </button>

    <nav id="mitsa-primary-nav" class="main-navigation" role="navigation" aria-label="Menú principal">
      <ul class="primary-menu">
        <li class="current-menu-item"><a href="/productos/">Productos</a></li>
        <li><a href="/representadas/">Representadas</a>
          <ul class="sub-menu"><li><a href="#">Submenú</a></li></ul>
        </li>
        <li><a href="/contacto/">Contacto</a></li>
      </ul>
    </nav>
  </div>
</header>
```

Notas:
- El menú lo genera `wp_nav_menu()`; las clases `current-menu-item`,
  `sub-menu`, etc. las aporta WordPress y ya están estilizadas.
- `#mitsa-primary-nav` debe coincidir con el `aria-controls` del botón.

---

## 4. Footer 3 columnas

Franja navy con marca + tagline, menú de pie y widgets/contacto; barra inferior
con copyright. Ver `footer.php`.

```html
<footer class="site-footer" role="contentinfo">
  <div class="mitsa-container">
    <div class="site-footer__cols">

      <div class="site-footer__col site-footer__col--brand">
        <p class="site-footer__brand">MITSA</p>
        <p class="site-footer__tagline">Representantes de marcas líderes… desde 1982.</p>
      </div>

      <div class="site-footer__col site-footer__col--nav">
        <h2 class="site-footer__col-title">Navegación</h2>
        <nav class="footer-navigation" aria-label="Menú de pie de página">
          <ul class="footer-menu"><li><a href="/productos/">Productos</a></li></ul>
        </nav>
      </div>

      <div class="site-footer__col site-footer__col--widgets">
        <h2 class="site-footer__col-title">Contacto</h2>
        <p class="site-footer__tagline">Reñaca, Viña del Mar, Chile.</p>
      </div>

    </div>

    <div class="site-footer__bottom">
      <p class="site-footer__copy">&copy; 2026 MITSA. Todos los derechos reservados.</p>
    </div>
  </div>
</footer>
```

Layout: 1 columna (móvil) → 2 (≥640px) → 3 (≥900px, la de marca más ancha).

---

## 5. Hero

Bloque de portada full-bleed con fondo navy en degradado y textura de rejilla
técnica sutil. **Va fuera de `.mitsa-container`**; su contenido usa un
contenedor interno. Ver `front-page.php`.

```html
<section class="mitsa-hero" aria-labelledby="mitsa-hero-title">
  <div class="mitsa-container mitsa-hero__inner">
    <span class="mitsa-kicker">Tecnología de tratamiento de aguas y equipos marinos</span>
    <h1 id="mitsa-hero-title">Ingeniería marina y ambiental de marcas líderes, representadas en Chile desde 1982.</h1>
    <p class="mitsa-hero__lead">MITSA provee y da soporte a tecnología de tratamiento de aguas, protección de casco, propulsión y confort a bordo…</p>
    <div class="mitsa-hero__actions">
      <a class="mitsa-btn mitsa-btn--accent" href="/productos/">Ver productos</a>
      <a class="mitsa-btn mitsa-btn--ghost-light" href="/contacto/">Contactar a un especialista</a>
    </div>
  </div>
</section>
```

---

## 6. Botones

Clase base `.mitsa-btn` + un modificador de estilo. Sirven en `<a>` y `<button>`.

```html
<a class="mitsa-btn mitsa-btn--primary" href="#">Acción primaria</a>   <!-- navy sólido -->
<a class="mitsa-btn mitsa-btn--accent" href="#">CTA principal</a>       <!-- teal sólido -->
<a class="mitsa-btn mitsa-btn--outline" href="#">Secundaria</a>         <!-- contorno -->
<a class="mitsa-btn mitsa-btn--ghost-light" href="#">Sobre fondo oscuro</a>

<!-- Modificadores de tamaño / ancho -->
<button class="mitsa-btn mitsa-btn--primary mitsa-btn--sm">Compacto</button>
<a class="mitsa-btn mitsa-btn--accent mitsa-btn--block" href="#">Ancho completo</a>
```

`--ghost-light` es el único pensado para colocarse sobre fondos navy (hero,
footer). Estado `disabled` soportado.

---

## 7. Card genérica y variantes

Card base `.mitsa-card` con 4 variantes: `--producto`, `--representada`,
`--caso`, `--documento`. Colocarlas dentro de un `.mitsa-grid`.

**Patrón de card enlazable accesible:** añadir `.mitsa-card--link`; el `<a>`
del título lleva un pseudo-elemento que cubre toda la card, de modo que el
enlace es toda la superficie pero el nombre accesible es el título. No anidar
otros enlaces dentro salvo dentro de `.mitsa-card__footer`.

### 7.1 Producto — `.mitsa-card--producto`

```html
<article class="mitsa-card mitsa-card--producto mitsa-card--link">
  <a class="mitsa-card__media" href="/producto/bwts-x/" tabindex="-1" aria-hidden="true">
    <img src="/img/producto.jpg" alt="" loading="lazy" width="480" height="300">
  </a>
  <div class="mitsa-card__body">
    <span class="mitsa-card__eyebrow">Tratamiento de aguas</span>
    <h3 class="mitsa-card__title"><a href="/producto/bwts-x/">Sistema BWTS de agua de lastre</a></h3>
    <p class="mitsa-card__excerpt">Tratamiento de agua de lastre conforme a la normativa IMO.</p>
    <div class="mitsa-card__meta">
      <span class="mitsa-badge mitsa-badge--navy">Marca X</span>
    </div>
  </div>
</article>
```

### 7.2 Representada — `.mitsa-card--representada`

Logo centrado sobre fondo blanco (`object-fit: contain`), cuerpo centrado.

```html
<article class="mitsa-card mitsa-card--representada mitsa-card--link">
  <a class="mitsa-card__media" href="/representadas/marca-x/" tabindex="-1" aria-hidden="true">
    <img src="/img/logo-marca.png" alt="" loading="lazy">
  </a>
  <div class="mitsa-card__body">
    <h3 class="mitsa-card__title"><a href="/representadas/marca-x/">Marca X</a></h3>
    <div class="mitsa-card__meta"><span>Alemania</span></div>
  </div>
</article>
```

### 7.3 Caso de éxito — `.mitsa-card--caso`

Registro editorial; eyebrow en navy. Usar para archive de casos.

```html
<article class="mitsa-card mitsa-card--caso mitsa-card--link">
  <a class="mitsa-card__media" href="/casos/armada-bwts/" tabindex="-1" aria-hidden="true">
    <img src="/img/caso.jpg" alt="" loading="lazy" width="480" height="270">
  </a>
  <div class="mitsa-card__body">
    <span class="mitsa-card__eyebrow">Naval y defensa</span>
    <h3 class="mitsa-card__title"><a href="/casos/armada-bwts/">Modernización de tratamiento de aguas en flota</a></h3>
    <p class="mitsa-card__excerpt">Caso representativo: cliente institucional del sector naval.</p>
  </div>
</article>
```

### 7.4 Documento (biblioteca) — `.mitsa-card--documento`

Fila compacta con icono de tipo + metadatos + badge de acceso. **No** usa
`--link` de superficie completa: el enlace real es el botón de descarga del
footer.

```html
<article class="mitsa-card mitsa-card--documento">
  <span class="mitsa-card__doc-icon" aria-hidden="true">PDF</span>
  <div class="mitsa-card__body">
    <span class="mitsa-card__eyebrow">Ficha técnica</span>
    <h3 class="mitsa-card__title">Ficha técnica — Sistema BWTS</h3>
    <p class="mitsa-card__excerpt">Especificaciones y curvas de rendimiento.</p>
    <div class="mitsa-card__meta">
      <span class="mitsa-badge mitsa-badge--free">Descarga libre</span>
    </div>
  </div>
</article>

<!-- Documento con acceso restringido (gated). El bloqueo real es P6b. -->
<article class="mitsa-card mitsa-card--documento">
  <span class="mitsa-card__doc-icon" aria-hidden="true">PDF</span>
  <div class="mitsa-card__body">
    <span class="mitsa-card__eyebrow">Catálogo</span>
    <h3 class="mitsa-card__title">Catálogo general de productos</h3>
    <div class="mitsa-card__meta">
      <span class="mitsa-badge mitsa-badge--gated">Requiere registro</span>
    </div>
  </div>
</article>
```

---

## 8. Badges

Etiqueta breve. Base `.mitsa-badge` + modificador de color.

```html
<span class="mitsa-badge">Neutral</span>
<span class="mitsa-badge mitsa-badge--accent">Acento</span>
<span class="mitsa-badge mitsa-badge--navy">Marca</span>
<span class="mitsa-badge mitsa-badge--free">Descarga libre</span>     <!-- verde -->
<span class="mitsa-badge mitsa-badge--gated">Requiere registro</span> <!-- ámbar -->
```

Convención biblioteca (P6a/P6b): `--free` = descarga directa, `--gated` = tras
formulario.

---

## 9. Breadcrumbs

Migas de pan. Marcar la página actual con `aria-current="page"`. El separador
lo dibuja el CSS (no incluir "/" en el HTML). Envolver en `<nav>` etiquetado.

```html
<nav class="mitsa-breadcrumbs" aria-label="Ruta de navegación">
  <ol>
    <li><a href="/">Inicio</a></li>
    <li><a href="/productos/">Productos</a></li>
    <li><a href="/productos/categoria/aguas-y-sanitarios/">Aguas y sanitarios</a></li>
    <li><span aria-current="page">Sistema BWTS</span></li>
  </ol>
</nav>
```

---

## 10. Tabla de especificaciones

Para fichas técnicas. Envolver **siempre** en `.mitsa-table-wrap` para el
scroll horizontal en móvil. Dos patrones:

**a) Clave/valor** (specs de un producto; usar `th[scope="row"]`):

```html
<div class="mitsa-table-wrap">
  <table class="mitsa-specs">
    <caption>Especificaciones técnicas</caption>
    <tbody>
      <tr><th scope="row">Caudal</th><td>250 m³/h</td></tr>
      <tr><th scope="row">Presión de trabajo</th><td>6 bar</td></tr>
      <tr><th scope="row">Certificación</th><td>IMO / USCG</td></tr>
    </tbody>
  </table>
</div>
```

> En P3 las specs se guardan como textarea línea-por-línea `clave|valor` (ACF
> free). Al parsear, cada línea genera una fila: `<th scope="row">clave</th>
> <td>valor</td>`. Líneas sin `|` se ignoran (no rompen el render).

**b) Comparativa** (varias columnas; usar `thead`):

```html
<div class="mitsa-table-wrap">
  <table class="mitsa-specs">
    <thead>
      <tr><th scope="col">Modelo</th><th scope="col">Caudal</th><th scope="col">Potencia</th></tr>
    </thead>
    <tbody>
      <tr><th scope="row">Serie A</th><td>120 m³/h</td><td>15 kW</td></tr>
    </tbody>
  </table>
</div>
```

---

## 11. Formularios (+ Contact Form 7)

Contenedor `.mitsa-form`. Las clases estilizan tanto markup propio como el que
genera Contact Form 7 (los estilos apuntan a los inputs directamente). Incluir
siempre un honeypot `.mitsa-form__hp`.

**Markup propio:**

```html
<form class="mitsa-form" method="post" action="">
  <div class="mitsa-form__row mitsa-form__row--2">
    <div class="mitsa-form__field">
      <label for="f-nombre">Nombre <span class="mitsa-form__req" aria-hidden="true">*</span></label>
      <input type="text" id="f-nombre" name="nombre" autocomplete="name" required>
    </div>
    <div class="mitsa-form__field">
      <label for="f-empresa">Empresa</label>
      <input type="text" id="f-empresa" name="empresa" autocomplete="organization">
    </div>
  </div>

  <div class="mitsa-form__field">
    <label for="f-email">Correo electrónico <span class="mitsa-form__req" aria-hidden="true">*</span></label>
    <input type="email" id="f-email" name="email" autocomplete="email" required>
    <span class="mitsa-form__hint">No compartimos tu correo con terceros.</span>
  </div>

  <div class="mitsa-form__field">
    <label for="f-mensaje">Mensaje <span class="mitsa-form__req" aria-hidden="true">*</span></label>
    <textarea id="f-mensaje" name="mensaje" rows="6" required></textarea>
  </div>

  <!-- Honeypot: oculto accesiblemente, debe quedar vacío -->
  <div class="mitsa-form__hp" aria-hidden="true">
    <label>No llenar<input type="text" name="mitsa_hp" tabindex="-1" autocomplete="off"></label>
  </div>

  <button type="submit" class="mitsa-btn mitsa-btn--accent">Enviar</button>
</form>
```

**Contact Form 7 (P7).** El plantillado CF7 va dentro de un
`<div class="mitsa-form">` (o el shortcode se envuelve con esa clase). CF7
genera `.wpcf7-form-control`, `.wpcf7-submit`, `.wpcf7-response-output`,
`.wpcf7-not-valid-tip`, ya estilizados. Los estados `form.sent` (éxito, verde)
y `form.invalid/failed` (error, rojo) tienen tratamiento propio.

---

## 12. Paginación

Compatible con `paginate_links()` / `the_posts_pagination()` de WordPress
(clases `page-numbers`, `current`, `dots`). Envolver en `.mitsa-pagination`.

```html
<nav class="mitsa-pagination" aria-label="Paginación">
  <div class="nav-links">
    <a class="prev page-numbers" href="?paged=1">Anterior</a>
    <a class="page-numbers" href="?paged=1">1</a>
    <span aria-current="page" class="page-numbers current">2</span>
    <a class="page-numbers" href="?paged=3">3</a>
    <span class="page-numbers dots">…</span>
    <a class="next page-numbers" href="?paged=3">Siguiente</a>
  </div>
</nav>
```

En PHP: `the_posts_pagination( array( 'class' => 'mitsa-pagination' ) )` o
envolver `paginate_links()` en `<nav class="mitsa-pagination">`.

---

## 13. Utilidades

Clases auxiliares para composición rápida:

| Clase | Efecto |
|---|---|
| `.mitsa-stack` | Espacio vertical uniforme entre hijos directos |
| `.mitsa-cluster` | Fila con wrap y gap (chips, badges, botones) |
| `.mitsa-lead` | Párrafo introductorio (texto mayor, atenuado) |
| `.mitsa-muted` | Texto atenuado |
| `.mitsa-text-center` | Centrar texto |
| `.mitsa-notice` | Aviso interno (contenido en borrador, notas de maqueta) |
| `.mitsa-visually-hidden` / `.screen-reader-text` | Oculto visualmente, visible para lectores de pantalla |
| `.mitsa-mt-0`, `.mitsa-mb-0` | Reset de margen puntual |

Ejemplo de aviso de borrador (usar para contenido no validado por el cliente):

```html
<p class="mitsa-notice">[BORRADOR — pendiente de validación del cliente]</p>
```
