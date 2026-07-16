# Analítica en producción — GA4 + GTM + Search Console

El sitio actual **no tiene ninguna herramienta de medición instalada** (verificado:
cero ocurrencias de `gtag`, `googletagmanager` o `GTM-` en el HTML de la home).
Esto estaba comprometido en la propuesta "desde el día 1". Hoy no hay datos de
tráfico, ni de dónde vienen los visitantes, ni de qué páginas ven.

## Enfoque recomendado: Google Tag Manager como contenedor único

Instalar **un solo** contenedor GTM y, dentro de GTM, disparar GA4. Ventaja:
todo cambio futuro de medición se hace desde la interfaz de GTM sin volver a
tocar el código del sitio.

### Paso 1 — Crear las cuentas (requiere cuenta Google del cliente)

1. **GA4**: crear propiedad en https://analytics.google.com → obtener el
   *Measurement ID* con formato `G-XXXXXXXXXX`.
2. **GTM**: crear contenedor en https://tagmanager.google.com → obtener el
   *Container ID* con formato `GTM-XXXXXXX`.
3. **Search Console**: verificar la propiedad `https://mitsachile.com` en
   https://search.google.com/search-console — método recomendado: etiqueta HTML
   (una meta que se pega en el `<head>`) o registro DNS. Una vez abierta la
   indexación, **enviar el sitemap** (`https://mitsachile.com/sitemap.xml`) desde
   Search Console → Sitemaps.

> Estos IDs deben salir de la cuenta Google del **cliente** (los activos son de
> MITSA, decisión ya tomada). Pedírselos a Francisco, o crear las cuentas bajo un
> Google del cliente y entregarle el acceso.

### Paso 2 — Snippet GTM (reemplazar los `GTM-XXXXXXX` por el ID real)

**En el `<head>`, lo más arriba posible:**

```html
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-XXXXXXX');</script>
<!-- End Google Tag Manager -->
```

**Justo después de abrir el `<body>`:**

```html
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-XXXXXXX"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
```

### Paso 3 — Conectar GA4 dentro de GTM

En GTM: **Nueva etiqueta → Google Analytics: configuración de GA4** → pegar el
`G-XXXXXXXXXX` → activador **All Pages** → Guardar → **Enviar/Publicar** el
contenedor. Con eso GA4 empieza a recibir pageviews.

## Cómo instalar el snippet en el sitio actual (tema logiscargo)

El sitio corre el tema comercial `logiscargo`. **No editar `header.php` del tema
directamente** — un update del tema borraría el cambio. Dos vías limpias:

- **Plugin gratuito** tipo "Insert Headers and Footers" (WPCode / oficial de
  WPBeginner): pegar el snippet del `<head>` en su campo de header y el `noscript`
  no siempre es soportado — para el `<body>` usar la variante de GTM que funciona
  solo con el snippet del head (aceptable, pierde el fallback sin-JS).
- **GTM oficial**: el plugin "GTM4WP" pide solo el Container ID y coloca ambos
  snippets en la posición correcta automáticamente. **Es la opción recomendada.**

## En el sitio NUEVO (tema `mitsa`)

Ya está preparado: `wp-content/themes/mitsa/inc/analytics.php` tiene los hooks de
GA4/GTM comentados. En el relanzamiento se activa ahí con los IDs reales; no se
necesita plugin. (Paso P9a del blueprint.)
