# Capa de pulido ("cariño") — contrato de clases

Documento de contrato para la **fase 2** (páginas interiores). Todas las clases
listadas aquí ya viven en `wpactual/wp-content/themes/mitsa/style.css` (§18) y en
`assets/js/theme.js`. Las páginas de la fase 2 **usan exactamente estas clases**;
no deben redefinir CSS ni tocar JS.

Reglas del contrato:

- Reusar tokens de `:root` (`--mitsa-*`). No inventar colores ni tamaños.
- Todo output PHP escapado (`esc_html_e`, `esc_url`, `esc_attr`), textdomain `mitsa`.
- El motion respeta `prefers-reduced-motion` de forma automática (ya resuelto en
  CSS/JS). No hace falta lógica extra en las plantillas.
- Sin dependencias externas ni CDN.

Índice:

1. [Motion e hover ya existentes (heredados)](#1-motion-e-hover-heredados)
2. [Cards: elevación e hover pulido](#2-cards-elevacion-e-hover)
3. [Botones, enlaces y kicker](#3-botones-enlaces-y-kicker)
4. [`.mitsa-page-hero` — banner de páginas interiores](#4-mitsa-page-hero)
5. [`.mitsa-panel` — bloque con fondo](#5-mitsa-panel)
6. [`.mitsa-repr-grid` / `.mitsa-repr-logo` — representadas interactivas](#6-representadas)
7. [`.mitsa-reveal` — scroll-reveal](#7-mitsa-reveal)
8. [`.mitsa-contacto-layout` / `.mitsa-datos` / `.mitsa-dato`](#8-contacto)
9. [Noticias: grid, card y single](#9-noticias)

---

## 1. Motion e hover heredados

Se pulieron transiciones y estados sobre clases que **ya existían** en el tema.
La fase 2 no necesita hacer nada especial para obtenerlos; basta con usar las
clases base del tema:

- `.mitsa-card` (y variantes `--producto`, `--representada`, `--caso`,
  `--servicio`, `--link`): al pasar el mouse o recibir foco de teclado suben
  `translateY(-4px)` con sombra más marcada. Cada variante conserva su acento de
  borde propio (producto/servicio/representada = teal, caso = navy).
- `.mitsa-btn--primary` / `.mitsa-btn--accent`: hover con sombra media y leve
  elevación; `:active` baja 1px. Coherente y sobrio.
- Enlaces (`a`) y `.mitsa-kicker`: transición de color suave.

Nada de esto cambia el markup que ya usan Home/Nosotros/Productos.

---

## 2. Cards: elevación e hover

Usar la card estándar del tema. El pulido de hover es automático.

```html
<article class="mitsa-card mitsa-card--producto">
  <a class="mitsa-card__media" href="#"><img src="..." alt="..."></a>
  <div class="mitsa-card__body">
    <span class="mitsa-card__eyebrow">Categoría</span>
    <h3 class="mitsa-card__title"><a href="#">Título</a></h3>
    <p class="mitsa-card__excerpt">Resumen breve.</p>
  </div>
</article>
```

- Para card enteramente clickeable: añadir `mitsa-card--link` y poner el `<a>`
  en `.mitsa-card__title a` (el `::after` cubre toda la card).

---

## 3. Botones, enlaces y kicker

Sin clases nuevas. Reforzados los estados de `.mitsa-btn--primary` y
`.mitsa-btn--accent`. Usar como siempre:

```html
<a class="mitsa-btn mitsa-btn--accent" href="/contacto/">Contáctanos</a>
<span class="mitsa-kicker">Sección</span>
```

---

## 4. `.mitsa-page-hero`

Banner de cabecera para páginas interiores. Fondo navy por defecto (o imagen de
fondo inline) con **overlay** que garantiza contraste AA del título blanco.
Altura ~260px (móvil) a ~320px (escritorio). Rejilla técnica sutil incluida.

Clases:

| Clase | Rol |
|---|---|
| `.mitsa-page-hero` | Contenedor del banner (fondo navy + overlay + rejilla). |
| `.mitsa-page-hero--center` | Centra el contenido (texto y lead). |
| `.mitsa-page-hero__inner` | Envoltorio del contenido (por encima del overlay). Va **dentro** de `.mitsa-container`. |
| `.mitsa-page-hero__lead` | Bajada opcional (slate-300). |

Dentro del banner funcionan `.mitsa-kicker` (teal-300) y `.mitsa-breadcrumbs`
(recoloreados a claro automáticamente).

**Fondo navy plano (por defecto):**

```html
<section class="mitsa-page-hero mitsa-page-hero--center">
  <div class="mitsa-container">
    <div class="mitsa-page-hero__inner">
      <span class="mitsa-kicker">Nosotros</span>
      <h1>Quiénes somos</h1>
      <p class="mitsa-page-hero__lead">Representación técnica desde 1982.</p>
    </div>
  </div>
</section>
```

**Con imagen de fondo (variante inline):** poner la imagen vía `style` en el
propio contenedor. El overlay navy se aplica solo encima.

```php
<section class="mitsa-page-hero" style="background-image:url('<?php echo esc_url( $img ); ?>');">
  <div class="mitsa-container">
    <nav class="mitsa-breadcrumbs" aria-label="<?php esc_attr_e( 'Migas de pan', 'mitsa' ); ?>"> ... </nav>
    <div class="mitsa-page-hero__inner">
      <h1><?php esc_html_e( 'Productos', 'mitsa' ); ?></h1>
    </div>
  </div>
</section>
```

---

## 5. `.mitsa-panel`

Bloque de contenido con fondo y padding — da "color detrás de los párrafos"
(p. ej. Misión / Visión). Combinable con `.mitsa-grid--2` para ponerlos en
tarjetas lado a lado.

| Clase | Rol |
|---|---|
| `.mitsa-panel` | Panel base: superficie blanca, borde, radio, sombra suave. |
| `.mitsa-panel--alt` | Superficie alterna slate-050 (sin sombra), para alternar ritmo. |
| `.mitsa-panel--accent` | Superficie teal suave con borde teal fino (énfasis). |
| `.mitsa-panel__title` | Título del panel (margen superior a cero). |

```html
<div class="mitsa-grid mitsa-grid--2">
  <div class="mitsa-panel mitsa-panel--accent">
    <h2 class="mitsa-panel__title">Misión</h2>
    <p>Representar y comercializar tecnología de tratamiento de aguas…</p>
  </div>
  <div class="mitsa-panel mitsa-panel--alt">
    <h2 class="mitsa-panel__title">Visión</h2>
    <p>Ser el referente técnico regional…</p>
  </div>
</div>
```

---

## 6. Representadas

Grid interactivo de logos de marcas representadas. En reposo el logo va en gris
atenuado; al pasar el mouse **o recibir foco** recupera color, sube y realza el
borde en teal (se siente vivo). Alternativa ligera a `.mitsa-card--representada`
cuando solo se quiere el logo enlazado, sin cuerpo de texto.

| Clase | Rol |
|---|---|
| `.mitsa-repr-grid` | Grid auto-fill de baldosas (mín. 150px). |
| `.mitsa-repr-logo` | Baldosa de logo interactiva (hover/focus = color + elevación + borde teal). |

```html
<div class="mitsa-repr-grid">
  <a class="mitsa-repr-logo" href="/representadas/marca/">
    <img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( $marca ); ?>">
  </a>
  <!-- repetir por cada marca -->
</div>
```

> Si se necesita nombre + descripción además del logo, usar la card completa
> `.mitsa-card mitsa-card--representada` (ya existente, con su hover pulido).

---

## 7. `.mitsa-reveal`

Scroll-reveal: el elemento aparece (fade + subida de 16px) al entrar al
viewport. `theme.js` añade `.is-visible` vía `IntersectionObserver`.

Comportamiento garantizado (no requiere nada en la plantilla):

- **Sin JS / JS deshabilitado:** el contenido se muestra sin animar
  (`@media (scripting: none)`), nunca queda oculto.
- **`prefers-reduced-motion: reduce`:** aparece de inmediato, sin desplazamiento.
- **Fallo del observer:** fallback revela todo.

Uso: añadir `.mitsa-reveal` a cualquier elemento. **Stagger opcional** con la
variable `--i` en el `style` (retardo = `--i * 70ms`).

```html
<div class="mitsa-grid mitsa-grid--3">
  <article class="mitsa-card mitsa-reveal" style="--i:0"> … </article>
  <article class="mitsa-card mitsa-reveal" style="--i:1"> … </article>
  <article class="mitsa-card mitsa-reveal" style="--i:2"> … </article>
</div>
```

> Recomendación: aplicar `.mitsa-reveal` a bloques de sección o a ítems de grid,
> no a cada palabra. Mantener el efecto sobrio.

---

## 8. Contacto

Layout de la página de contacto y lista de datos (teléfono, email, dirección).

| Clase | Rol |
|---|---|
| `.mitsa-contacto-layout` | Grid: 1 columna (móvil) → 2 columnas `1.15fr / 0.85fr` (≥900px). Formulario + datos/mapa. |
| `.mitsa-datos` | Lista vertical de ítems de contacto (sin viñetas). |
| `.mitsa-dato` | Ítem: icono + (label + valor). |
| `.mitsa-dato__icon` | Caja de icono (teal-050 / acento). Acepta `<svg>` 20×20 inline. |
| `.mitsa-dato__label` | Etiqueta corta en mayúsculas (p. ej. "Teléfono"). |
| `.mitsa-dato__value` | Valor; los `<a>` heredan color y se subrayan en hover. |

```html
<div class="mitsa-contacto-layout">
  <div class="mitsa-form"> <?php /* Contact Form 7 o markup propio */ ?> </div>

  <aside>
    <ul class="mitsa-datos">
      <li class="mitsa-dato">
        <span class="mitsa-dato__icon" aria-hidden="true"><svg …></svg></span>
        <span>
          <span class="mitsa-dato__label"><?php esc_html_e( 'Teléfono', 'mitsa' ); ?></span>
          <span class="mitsa-dato__value"><a href="tel:+56322000000">+56 32 200 0000</a></span>
        </span>
      </li>
      <li class="mitsa-dato">
        <span class="mitsa-dato__icon" aria-hidden="true"><svg …></svg></span>
        <span>
          <span class="mitsa-dato__label"><?php esc_html_e( 'Dirección', 'mitsa' ); ?></span>
          <span class="mitsa-dato__value">Reñaca, Viña del Mar</span>
        </span>
      </li>
    </ul>
  </aside>
</div>
```

---

## 9. Noticias

### Listado (grid + card)

| Clase | Rol |
|---|---|
| `.mitsa-noticias-grid` | Grid 1 → 2 → 3 columnas (mobile-first). |
| `.mitsa-noticia-card` | Tarjeta: imagen arriba, cuerpo con padding, meta, botón al pie. Hover = elevación + borde teal + zoom sutil de imagen. |
| `.mitsa-noticia-card__media` | Contenedor de imagen 16/9 (overflow oculto). |
| `.mitsa-noticia-card__body` | Cuerpo flex; empuja el botón al pie. |
| `.mitsa-noticia-card__meta` | Fecha / categoría (texto atenuado). |
| `.mitsa-noticia-card__title` | Título (usar `<a>` interno). |
| `.mitsa-noticia-card__excerpt` | Extracto breve. |

```html
<div class="mitsa-noticias-grid">
  <article class="mitsa-noticia-card mitsa-reveal" style="--i:0">
    <a class="mitsa-noticia-card__media" href="<?php the_permalink(); ?>">
      <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>">
    </a>
    <div class="mitsa-noticia-card__body">
      <p class="mitsa-noticia-card__meta"><?php echo esc_html( get_the_date() ); ?></p>
      <h3 class="mitsa-noticia-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
      <p class="mitsa-noticia-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
      <a class="mitsa-btn mitsa-btn--outline mitsa-btn--sm" href="<?php the_permalink(); ?>">
        <?php esc_html_e( 'Leer más', 'mitsa' ); ?>
      </a>
    </div>
  </article>
</div>
```

### Single (detalle de la noticia)

| Clase | Rol |
|---|---|
| `.mitsa-single` | Contenedor del artículo (ancho `--mitsa-content-narrow`, centrado). |
| `.mitsa-single__media` | Imagen destacada (radio + overflow oculto). |
| `.mitsa-single__meta` | Fila de meta (fecha, autor, categoría). |
| `.mitsa-single__title` | Título del artículo. |
| `.mitsa-single__content` | Cuerpo legible: medida ~70ch, ritmo vertical, tipografía de prosa. Estiliza `h2/h3`, `img`, `a`, `blockquote`. |

```html
<article class="mitsa-single">
  <header>
    <div class="mitsa-single__meta">
      <span><?php echo esc_html( get_the_date() ); ?></span>
      <span><?php the_category( ', ' ); ?></span>
    </div>
    <h1 class="mitsa-single__title"><?php the_title(); ?></h1>
  </header>

  <?php if ( has_post_thumbnail() ) : ?>
    <figure class="mitsa-single__media"><?php the_post_thumbnail( 'large' ); ?></figure>
  <?php endif; ?>

  <div class="mitsa-single__content">
    <?php the_content(); ?>
  </div>
</article>
```

---

## Presupuesto y verificación

- `style.css` ≈ 56 KB (límite < 75 KB). ✓
- `assets/js/theme.js` ≈ 4.7 KB (límite < 12 KB). ✓
- Mobile-first, foco visible (heredado de §5), contraste AA en todos los pares
  texto/fondo usados.
- Sin dependencias externas ni CDN.
