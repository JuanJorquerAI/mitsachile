# Paquete de correcciones SEO para producción — mitsachile.com

**Fecha:** 2026-07-16 · **Preparado por:** AplicacionesWeb
**Estado:** listo para aplicar. Ninguna de estas correcciones toca el diseño ni
el contenido visible del sitio actual — son metadatos e infraestructura de
indexación y medición.

---

## Contexto en una línea

El sitio de MITSA lleva tiempo **invisible en Google**: su `robots.txt` ordena a
todos los buscadores no indexar ninguna página, no tiene sitemap ni analítica, y
el `http://` no redirige al `https://`. Este paquete lo corrige.

## Orden de aplicación (de mayor a menor impacto)

### 1. robots.txt — CRÍTICO, 2 minutos

El actual dice:
```
User-agent: *
Disallow: /
```
Eso bloquea TODO. Reemplazarlo por el archivo `robots.txt` de esta carpeta
(vía cPanel → Administrador de archivos → `public_html/robots.txt`, o por SFTP).

> ⚠️ Si `robots.txt` no es un archivo físico sino que lo genera un plugin (p. ej.
> Yoast o el propio WordPress), editarlo desde ahí en vez de subir el archivo.
> Verificar después: abrir `https://mitsachile.com/robots.txt` y confirmar que ya
> **no** aparece `Disallow: /`.

### 2. Redirección http → https — importante

Hoy `http://mitsachile.com` responde 200 (no redirige). Genera contenido
duplicado y una advertencia de "no seguro". Añadir al inicio del `.htaccess` en
`public_html/`:

```apache
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}/$1 [R=301,L]
</IfModule>
```

### 3. Sitemap.xml — importante

Dos opciones:
- **Rápida (este paquete):** subir el `sitemap.xml` de esta carpeta a
  `public_html/sitemap.xml`. Solo lista las 8 URLs verificadas hoy.
- **Recomendada (mejor a futuro):** instalar el plugin **Yoast SEO** (gratis),
  que genera y mantiene el sitemap solo, y además habilita los campos de título/
  meta de `metas-propuestas.md`. Si se instala Yoast, borrar el sitemap manual.

Tras subirlo o generarlo: enviar la URL del sitemap en **Search Console**.

### 4. Títulos y meta descriptions — ver `metas-propuestas.md`

Requiere Yoast (o similar) para editarlos sin tocar código del tema.

### 5. Analítica GA4 + GTM + Search Console — ver `analitica-gtm-ga4.md`

Requiere IDs de la cuenta Google del cliente. Es la única parte que necesita
input de Francisco (o crear las cuentas por él).

---

## Nota sobre el timing de indexación

Abrir el `robots.txt` indexará primero el sitio **actual** (títulos genéricos,
tema logiscargo). Es correcto y deseable: indexado con contenido mediocre supera
a invisible, y el dominio empieza a acumular historial y autoridad ANTES del
relanzamiento. Cuando lance el sitio nuevo, las URLs viejas se redirigen con 301
(paso P8 del blueprint del proyecto).

## Checklist de verificación post-aplicación

- [ ] `https://mitsachile.com/robots.txt` ya no contiene `Disallow: /`
- [ ] `http://mitsachile.com` redirige (301) a `https://mitsachile.com`
- [ ] `https://mitsachile.com/sitemap.xml` responde 200 y lista las páginas
- [ ] Propiedad verificada en Search Console y sitemap enviado
- [ ] GTM publicado y GA4 recibiendo pageviews (ver Tiempo real en GA4)
