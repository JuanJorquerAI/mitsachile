# Blueprint — Rediseño web mitsachile.com (MITSA SpA)

> Plan de construcción ejecutable en frío. Cada paso incluye un *context brief* autocontenido:
> un agente nuevo puede ejecutar cualquier paso sin leer los anteriores.
> Generado: 2026-07-14 · v2 (post-review adversarial, 20 hallazgos corregidos) · Modo: git + GitHub CLI (branch/PR por paso) · Repo: `JuanJorquerAI/mitsachile`

---

## 0. Contexto global (leer siempre antes de cualquier paso)

**Proyecto.** Rediseño + posicionamiento digital de mitsachile.com para MITSA SpA (representante de marcas de tratamiento de aguas y equipos marinos/ambientales, sede Reñaca, Viña del Mar, opera desde 1982). Ejecuta la agencia AplicacionesWeb. Alcance contratado: 45 UF + IVA (ver `CLAUDE.md` § "Alcance técnico"). Todo lo no mencionado en la propuesta es adicional a cotizar — no construirlo.

**Stack decidido (no discutir).** WordPress con tema custom clásico en `wp-content/themes/mitsa/` — PHP plano, sin page builder, sin build tools. **ACF versión FREE** (sin repeater ni flexible content — no asumir campos PRO; si un paso necesita listas estructuradas, usar textarea línea-por-línea `clave|valor` parseada en el template). Contact Form 7 para formularios. Yoast SEO en producción.

**Reglas invariantes (verificar al cierre de CADA paso):**
1. Brochure (`docs/Brochure MITSA SPA - Extracto..pdf`) manda sobre el sitio actual en conflictos de contenido.
2. Contenido no validado por el cliente entra a WordPress como **draft/pending**, nunca `publish`. Lo único validado 🟢 es la estructura de menú de Nosotros y Productos y el copy de `content/02-nosotros.md` / `content/03-productos.md`; el copy nuevo redactado por la agencia (fichas de producto, Home, casos) también nace draft hasta hito de validación (ver P10).
3. Marcas Ervor y EGGE: no publicar (DECISIONS.md abierta #5).
4. **No crear contenido nuevo para Cathelco, Evac ni Uson Marine** hasta resolver la contradicción de `cathelco.cl` (DECISIONS.md #7). El contenido estructural (categorías, templates) sí puede existir.
5. `docs/Correo de AplicacionesWeb - Inicio proyecto MITSA.pdf` (credenciales) sigue en `.gitignore`. Jamás commitear credenciales; constantes en `wp-config.php` local (fuera del repo).
6. Convenciones de código: prefijo `mitsa_`, textdomain `mitsa`, todo output escapado (`esc_html`/`esc_url`/`esc_attr`), `functions.php` corto que solo hace `require` de `inc/`, un archivo por responsabilidad, archivos <800 líneas, funciones <50.
7. **Campos ACF: un archivo por dominio** — `inc/acf-producto.php`, `inc/acf-representada.php`, `inc/acf-caso.php`, `inc/acf-documento.php` — cada uno con su propio `require` en `functions.php`. Nunca un archivo ACF compartido entre pasos (evita conflictos de merge entre ramas paralelas). Todos los templates degradan sin fatal si ACF no está activo (`function_exists('get_field')`).
8. Idioma del sitio: español. Inglés fuera de alcance (solo dejar el tema i18n-ready).
9. Sin secretos hardcodeados; formularios con nonce + validación server-side; datos personales solo en estructuras privadas (`public => false`, `show_in_rest => false`).

**Estado al momento de generar este plan (commit `6784687`):**
- Tema: scaffold funcional — `functions.php`, `header/footer/index/page/front-page.php`, 5 page templates (nosotros, productos, sectores, servicios, contacto), CPTs `producto` (+tax `categoria-producto` con 5 términos seed, `marca`) y `representada`, `inc/seo.php` (fallback title/meta que se autodesactiva con Yoast/Rank Math), `inc/analytics.php` (hooks GA4/GTM comentados). `style.css` = reset + variables placeholder. **No hay diseño visual, ni singles/archives de CPTs, ni biblioteca técnica, ni casos de éxito, ni formulario funcional.**
- Contenido: `content/02-...07-*.md` redactados (Nosotros y Productos validados 🟢; Representadas/Sectores/Servicios/Contacto borrador 🟡). **No existe `content/01-home.md`** (se crea en P10). SEO: `content/seo-keywords.md` v2 + 4 investigaciones en `content/research/`.
- Repo NO incluye WordPress; no hay ambiente local montado. En la máquina actual existen `pandoc`, `pdftotext`, `gh` autenticado; **wp-cli NO está instalado** (P1 lo instala).
- Conflicto conocido: `inc/cpt-producto.php` registra `has_archive => 'productos'` y una página "Productos" viviría en la misma URL — P3 lo resuelve (ver P3 tarea 1).

**Flujo git por paso.** Rama `paso-NN-slug` desde `master`, commits atómicos en español (conventional), PR contra `master` con `gh pr create`, merge tras verificación. Paso abandonado → cerrar PR y documentar en `docs/DECISIONS.md`.

**Definición de "verificado".** Verificación mínima universal: `php -l` sobre cada PHP tocado + repaso de invariantes. Verificación funcional requiere el ambiente del P1.

---

## 1. Grafo de dependencias y paralelismo

```
P1 (entorno local WP completo)
├── P2 (sistema de diseño + catálogo de componentes) ─┐
├── P3 (catálogo productos)                            │ P2..P6a paralelos entre sí
├── P4 (representadas)                                 │ (archivos disjuntos; en functions.php
├── P5 (casos de éxito)                                │  cada paso agrega SOLO su línea require)
├── P6a (biblioteca técnica, descarga libre)          ─┘
├── P7 (formulario contacto)    ← también requiere P2 (estilos de form)
└── P9a (snippets GA4/GTM/GSC)  ← solo depende de P1

P6b (gating + leads)     ← P6a
P8 (SEO técnico)         ← P3, P4, P5, P6a
P9b (eventos dataLayer)  ← P6b, P7, P9a
P10 (contenido + Home + integración visual) ← P2..P7
P11 (i18n-ready)         ← P2..P10
P12 (QA + lanzamiento)   ← todos
```

| Paso | Título | Depende de | Modelo sugerido |
|---|---|---|---|
| P1 | Entorno local WordPress reproducible | — | default |
| P2 | Sistema de diseño + catálogo de componentes | P1 | **fuerte** |
| P3 | Catálogo de productos (singles/archives) | P1 | default |
| P4 | Representadas (ACF + templates) | P1 | default |
| P5 | Casos de éxito (CPT + templates) | P1 | default |
| P6a | Biblioteca técnica — CPT, templates, descarga libre | P1 | default |
| P6b | Biblioteca técnica — gating, descargas firmadas, leads | P6a | **fuerte** |
| P7 | Formulario de contacto funcional | P1, P2 | default |
| P8 | SEO técnico (metas, schema, sitemap, 301) | P3–P6a | **fuerte** |
| P9a | Analítica — snippets GA4 + GTM + doc GSC | P1 | default |
| P9b | Analítica — eventos dataLayer | P6b, P7, P9a | default |
| P10 | Carga de contenido, Home e integración visual | P2–P7 | default |
| P11 | i18n-ready (.pot + barrido) | P2–P10 | default |
| P12 | QA, performance y lanzamiento | todos | **fuerte** |

Rollback general: cada paso vive en su rama; revertir = no mergear o `git revert` del merge commit. Pasos que instalan plugins o tocan BD local documentan su reversa.

---

## P1 — Entorno local WordPress reproducible

**Context brief.** El repo contiene solo el tema (`wp-content/themes/mitsa/`) y contenido markdown; no hay WordPress ni wp-cli en la máquina. Todo paso posterior necesita un WP local para verificar. `wp-content/themes/mitsa/README.md` documenta activación manual. Objetivo: scripts idempotentes que monten el ambiente completo desde cero.

**Tareas.**
1. `scripts/setup-wp.sh` (bash, `set -euo pipefail`): instala wp-cli si falta (`curl` del `.phar` oficial + verificación, o `brew install wp-cli`), hace `wp core download --locale=es_ES`, `wp config create` (credenciales MySQL por variables de entorno, BD local `mitsa_dev`), `wp core install` en un directorio `wp/` **gitignoreado**, y symlinkea el tema a `wp/wp-content/themes/mitsa`.
2. `scripts/provision.sh` (idempotente, re-ejecutable):
   - `wp theme activate mitsa`;
   - instala plugins base: `advanced-custom-fields` (free) y `contact-form-7` (`wp plugin install --activate`);
   - crea páginas Nosotros/Sectores/Servicios/Contacto con su `_wp_page_template`, página "Productos" con `template-productos.php` (ver nota de URL en P3) y Home estática (`show_on_front=page`);
   - crea menús `primary` y `footer`, los asigna, e incluye ítems para `/casos/` y `/biblioteca/` (custom links — los archives los crean P5/P6a; el link puede existir antes);
   - si la página/menú/plugin ya existe, no duplica.
3. Mail local: instalar y documentar **Mailpit** (`brew install mailpit`) + plugin/mu-plugin que enrute `wp_mail` por SMTP `localhost:1025`, para que P6b/P7 tengan criterio de verificación de correo comprobable.
4. `scripts/README.md`: prerrequisitos (PHP ≥ 8.0, MySQL/MariaDB corriendo, brew), uso de ambos scripts, alternativa manual LocalWP, troubleshooting.
5. `.gitignore`: confirmar/añadir `wp/`, `*.sql`, `.env`.
6. Smoke test: `curl -s http://localhost:PORT/ | grep -q "MITSA"` y las 6 páginas responden 200.

**Entradas.** `wp-content/themes/mitsa/README.md`, `content/00-sitemap.md`.
**Salidas.** `scripts/setup-wp.sh`, `scripts/provision.sh`, `scripts/README.md`, `.gitignore` actualizado.
**Criterios de aceptación.**
- [ ] Desde máquina limpia (sin wp-cli): `setup-wp.sh && provision.sh` deja el sitio navegable.
- [ ] Ejecutar `provision.sh` dos veces no produce error ni duplicados.
- [ ] Las 6 páginas existen con template correcto y responden 200; menús asignados.
- [ ] Mailpit captura un `wp mail test`; nada de `wp/` queda trackeado en git.

**Rollback.** `rm -rf wp/` + `wp db drop`; el repo solo gana `scripts/` y `.gitignore`.

---

## P2 — Sistema de diseño, CSS del tema y catálogo de componentes

**Context brief.** `style.css` hoy es reset + variables placeholder con `TODO`. No existe logo digital aprobado (el tema cae a texto si no hay `custom_logo`). Marca a proyectar: **"MITSA"** (no "MITSA Chile"). Audiencia B2B técnica: Armada, astilleros, salmoneras, navieras, minería, industria — el diseño debe comunicar solidez técnica industrial-marina. Estructura HTML existente: `header.php` (nav `primary`), `footer.php`, `front-page.php` (hero + bloques), templates en `page-templates/`. **Importante:** los templates de CPTs (P3–P6a) se desarrollan en paralelo; este paso debe publicar un catálogo de componentes con markup de referencia que esos pasos copien, y P10 hace la reconciliación visual final.

**Tareas.**
1. Tokens en `:root` de `style.css`: paleta (azul marino profundo + acento técnico + neutros fríos; contraste AA mínimo), escala tipográfica (system stack o Google Fonts **self-hosted** en `assets/fonts/` — nada desde CDN), espaciado, radios, sombras.
2. Componentes con clases documentadas: header sticky + nav responsive (hamburguesa móvil vía `assets/js/theme.js`, vanilla), footer 3 columnas, hero, **card genérica `.mitsa-card` con variantes** (producto/representada/caso/documento), botones, tabla de especificaciones, formularios (incluye clases compatibles con markup CF7), breadcrumbs `.mitsa-breadcrumbs`, badges, paginación.
3. **`docs/componentes.md`: catálogo de componentes** — para cada componente, el bloque HTML de referencia con sus clases. Contrato para P3–P6a: sus templates deben usar exactamente este markup.
4. Layout: grid fluido mobile-first, contenedor máx ~1200px, `max-width:100%` en imágenes, `overflow-x:auto` en tablas.
5. Estados: focus visible, hover, `prefers-reduced-motion`.
6. Aplicar clases a los templates ya existentes (header, footer, front-page, page, 5 page templates) sin cambiar su lógica PHP.
7. Presupuesto: CSS único < 60 KB sin minificar, JS < 10 KB, cero librerías externas.

**Entradas.** Templates existentes; `CLAUDE.md` (identidad); brochure para tono visual.
**Salidas.** `style.css` completo, `assets/js/theme.js`, `assets/fonts/` (si aplica), `docs/componentes.md`, templates existentes con clases.
**Criterios de aceptación.**
- [ ] Home, página interna y nav móvil coherentes en 360/768/1280px (verificación visual en ambiente P1).
- [ ] Contraste AA verificado en los pares token texto/fondo.
- [ ] `docs/componentes.md` cubre como mínimo: card (4 variantes), tabla specs, breadcrumbs, form, paginación.
- [ ] Navegación completa operable solo con teclado; `php -l` limpio; cero requests a dominios externos (verificar con DevTools/network).

**Rollback.** Revert del merge; no toca `inc/` ni BD.

---

## P3 — Catálogo de productos: singles, archives y ficha técnica

**Context brief.** CPT `producto` y taxonomías `categoria-producto` (5 términos seed: aguas y sanitarios, bombas y fluidos, propulsión, confort a bordo, protección casco) y `marca` existen en `inc/cpt-producto.php`. Existe `page-templates/template-productos.php` (landing) pero no hay singles/archives. Jerarquía objetivo en `content/00-sitemap.md`. **Conflicto de URL a resolver aquí:** el CPT registra `has_archive => 'productos'` y la página landing "Productos" (P1) vive en `/productos/` — las rewrite rules chocarían.

**Decisión de URLs (implementar así, no re-discutir).**
- Página landing "Productos" conserva `/productos/` con `template-productos.php`.
- CPT `producto`: cambiar a `has_archive => false`; singles en `/producto/{slug}/` (rewrite slug `producto`).
- Taxonomía `categoria-producto`: rewrite `productos/categoria` → URLs `/productos/categoria/{term}/`.
- Documentar en comentario del código + `wp rewrite flush` en provision.

**Tareas.**
1. Aplicar la decisión de URLs en `inc/cpt-producto.php`.
2. Sembrar subcategorías (hijos) según sitemap **en el hook `after_switch_theme` existente**, junto a los 5 términos padre (no en provision.sh — evita tocar archivo de P1 en paralelo).
3. `taxonomy-categoria-producto.php` + `taxonomy-marca.php`: grid de cards (markup de `docs/componentes.md` si P2 ya mergeó; si no, markup semántico simple y P10 reconcilia), enlaces a subcategorías hermanas, paginación.
4. `single-producto.php`: imagen destacada, marca (term `marca`), descripción, tabla de especificaciones, enlace a ficha PDF (attachment simple; la biblioteca P6 es independiente), productos relacionados por categoría, breadcrumbs.
5. `inc/acf-producto.php` (`acf_add_local_field_group`): imagen secundaria, **specs como textarea línea-por-línea `clave|valor`** (ACF free — sin repeater) parseada en el template con guard `function_exists('get_field')`, PDF ficha (attachment), texto destacado. Añadir su `require` en `functions.php`.
6. Actualizar `template-productos.php` para listar los 5 términos padre con conteo y enlace.

**Entradas.** `inc/cpt-producto.php`, `content/00-sitemap.md`, `content/03-productos.md`.
**Salidas.** 3 templates nuevos, `inc/acf-producto.php`, CPT ajustado, seed de subcategorías.
**Criterios de aceptación.**
- [ ] `/productos/` muestra la landing (página), `/productos/categoria/aguas-y-sanitarios/` lista productos, `/producto/{slug}/` renderiza single — los tres sin 404 tras `wp rewrite flush`.
- [ ] Con 3 productos de prueba en 2 categorías: filtros, relacionados y breadcrumbs correctos.
- [ ] Sin ACF activo: ninguna pantalla blanca (probar con `wp plugin deactivate advanced-custom-fields`).
- [ ] `php -l` limpio; specs `clave|valor` malformadas no rompen el render.

**Rollback.** Revert; subcategorías seed se limpian con `wp term delete`.

---

## P4 — Representadas: campos ACF, archive y single

**Context brief.** CPT `representada` existe en `inc/cpt-representada.php` con TODO de campos ACF. Contenido fuente: `content/04-representadas.md` — **18 marcas base + 2 "por confirmar" (Ervor y EGGE, cargar siempre como draft)**. **Cathelco/Evac/Uson Marine: solo entrada básica (nombre, logo, categoría), sin contenido nuevo** (invariante #4). No existe template de listado ni single.

**Tareas.**
1. `inc/acf-representada.php` (archivo propio, invariante #7): logo (imagen), descripción corta, URL sitio oficial, país de origen, relación con términos `categoria-producto`. `require` propio en `functions.php`.
2. `archive-representada.php`: grid de logos/cards alfabético (markup `docs/componentes.md`), cada card al single.
3. `single-representada.php`: logo, país, descripción, productos de la marca (query por term `marca` cuyo slug coincida con el post — documentar la convención en el código), enlace externo `rel="noopener noreferrer"`.
4. Ítem "Representadas" del menú apunta al archive del CPT (ajustar en provision o documentar en el PR).

**Entradas.** `inc/cpt-representada.php`, `content/04-representadas.md`.
**Salidas.** 2 templates, `inc/acf-representada.php`, ajuste de menú.
**Criterios de aceptación.**
- [ ] Con 3 representadas de prueba: archive y single renderizan; sin ACF no hay fatal.
- [ ] Ervor/EGGE documentadas en código/seed como draft-only.
- [ ] `php -l` limpio; output escapado; link externo con `noopener`.

**Rollback.** Revert del merge.

---

## P5 — Casos de éxito: CPT + templates

**Context brief.** La propuesta contratada exige casos de éxito estructurados por: cliente/tipo, industria, problema, solución, producto/tecnología, resultado; con "casos representativos" por industria cuando haya confidencialidad (Armada, astilleros, salmoneras, navieras, proyectos internacionales) — ver `CLAUDE.md`. Nada existe en el tema ni hay contenido real: este paso construye estructura + 2 demos draft.

**Tareas.**
1. `inc/cpt-caso.php`: CPT `caso` (slug `/casos/`, `has_archive => 'casos'`), soporte title/editor/thumbnail/excerpt, taxonomía `industria` (seed en `after_switch_theme` propio: naval-defensa, astilleros, acuicultura, pesquero, minería, industrial-comercial). `require` en `functions.php`.
2. `inc/acf-caso.php`: cliente o tipo de cliente, problema, solución, productos/tecnología (post object → CPT `producto`, campo múltiple), resultado, flag "confidencial" (true → front muestra tipo de cliente, nunca nombre).
3. `archive-caso.php` (filtro por término `industria`) + `single-caso.php` (estructura problema→solución→resultado, productos relacionados, breadcrumbs).
4. 2 casos demo **draft** con placeholder `[DEMO — reemplazar con caso real validado]` (uno confidencial, uno con nombre).

**Entradas.** `CLAUDE.md` § alcance, `content/05-sectores.md` (industrias).
**Salidas.** `inc/cpt-caso.php`, `inc/acf-caso.php`, 2 templates, seed de términos, 2 demos draft.
**Criterios de aceptación.**
- [ ] Caso demo confidencial no muestra nombre de cliente en el HTML (curl + grep).
- [ ] Filtro por industria funciona; `/casos/` responde 200 (el link de menú ya existe desde P1).
- [ ] `php -l` limpio; demos en estado draft verificable con `wp post list --post_type=caso`.

**Rollback.** Revert; `wp post delete` de demos; `wp term delete` de términos.

---

## P6a — Biblioteca técnica: CPT, taxonomías, templates, descarga libre

**Context brief.** La propuesta exige biblioteca de fichas técnicas, catálogos, certificados, manuales y brochures. Algunas descargas irán tras formulario (**eso es P6b** — este paso deja todo como descarga libre y el campo `gated` ya definido pero inerte). Nada existe aún. Restricción: sin plugins de membresía.

**Tareas.**
1. `inc/cpt-documento.php`: CPT `documento` (slug `/biblioteca/`, `has_archive => 'biblioteca'`), taxonomía `tipo-documento` (seed: ficha técnica, catálogo, certificado, manual, brochure) + relación opcional a `categoria-producto` y `marca` (taxonomías existentes compartidas). `require` en `functions.php`.
2. `inc/acf-documento.php`: archivo (attachment PDF), checkbox `gated` (P6b lo activa), descripción corta, marca/categoría asociada.
3. `archive-documento.php`: filtros por `tipo-documento` y `categoria-producto` (enlaces de términos), cards con badge "descarga libre" / "requiere registro" según flag.
4. `single-documento.php`: metadatos + botón de descarga directa (los gated muestran el badge; el bloqueo real llega en P6b).
5. Seed: 2–3 documentos demo con PDF dummy (no subir el brochure interno sin autorización del cliente).

**Entradas.** `CLAUDE.md` § alcance.
**Salidas.** 2 archivos `inc/`, 2 templates, seed demo.
**Criterios de aceptación.**
- [ ] `/biblioteca/` lista y filtra por tipo; single descarga el PDF demo.
- [ ] Flag `gated` visible en admin y reflejado como badge en front (sin bloquear aún).
- [ ] Sin ACF activo no hay fatal; `php -l` limpio.

**Rollback.** Revert; `wp post delete` de demos.

---

## P6b — Biblioteca técnica: gating, descargas firmadas y leads

**Context brief.** Continúa P6a (CPT `documento` con flag `gated` ya existe). Objetivo: documentos gated exigen formulario (nombre, email, empresa) antes de entregar el archivo; el lead queda registrado. Riesgo clave detectado en review: si el PDF vive en `uploads/` normal, su URL es pública aunque no se imprima — el gating debe proteger el archivo de verdad. La clasificación libre/gated por documento la decide el admin con el checkbox (DECISIONS.md #3 sigue abierta; el mecanismo debe ser editable).

**Diseño (implementar así).**
- **Almacenamiento protegido:** los PDF gated se mueven a `wp-content/uploads/mitsa-gated/` con `.htaccess` `Deny from all` (generarlo al activar; hosting destino es Apache/cPanel). El attachment se excluye del sitemap y de la página de attachment (`wp_robots` noindex + filtro Yoast).
- **Formulario gate** en `single-documento.php` para gated: nombre, email, empresa; nonce + honeypot + rate-limit por transient/IP (máx 5/hora).
- **POST válido →** registrar lead + responder con enlace firmado: `home_url('/descarga/')` + query `doc`, `expira`, `firma = hash_hmac('sha256', "{$attachment_id}|{$expira}", wp_salt('auth'))`. Expiración 24 h.
- **Endpoint** (`init` rewrite `/descarga/` + `template_redirect` en `inc/descargas.php`): valida firma/expiración (403 si falla), y sirve el archivo con `Content-Type`, `Content-Length`, `Content-Disposition` y **lectura por chunks** (`while (ob_get_level()) ob_end_clean();` + `fopen`/`fread` de 8 KB + `flush`) — nunca `readfile()` directo con buffers activos (PDFs de decenas de MB).
- **Leads:** CPT `lead` con `public => false`, `show_in_rest => false`, `exclude_from_search => true`; guarda nombre/email/empresa/documento/fecha; además `wp_mail` al admin (Mailpit lo captura en local). El formulario incluye texto de consentimiento de tratamiento de datos (Ley 21.719); registrar en `docs/DECISIONS.md` la política de retención pendiente de definir con el cliente.

**Tareas.** Implementar el diseño anterior en `inc/descargas.php` + ajustes a `single-documento.php` y `inc/cpt-documento.php` (CPT `lead`).
**Entradas.** P6a mergeado.
**Salidas.** `inc/descargas.php`, CPT `lead`, single actualizado, texto de consentimiento.
**Criterios de aceptación (todos comprobables con curl en ambiente P1).**
- [ ] Documento gated: URL directa del PDF en `mitsa-gated/` responde 403; el HTML del single no contiene la ruta del archivo.
- [ ] Firma alterada → 403; enlace expirado → 403; documento libre → descarga directa 200.
- [ ] POST válido crea post `lead` (verificar `wp post list --post_type=lead`) y Mailpit recibe el correo.
- [ ] `wp-json/wp/v2/lead` responde 404 (CPT fuera de REST).
- [ ] Rate-limit: sexto POST en una hora desde la misma IP es rechazado.

**Rollback.** Revert; documentos vuelven a descarga libre (P6a); `wp post delete` de leads.

---

## P7 — Formulario de contacto funcional

**Context brief.** `page-templates/template-contacto.php` tiene HTML estático sin lógica. Decisión vigente (DECISIONS.md, 2026-07-12): página Contacto lleva **solo formulario + dirección confirmada (Reñaca, Viña del Mar)** — sin teléfono ni email visibles hasta que el cliente los entregue. Plugin: Contact Form 7 (ya instalado por provision en P1). Mailpit (P1) captura correo local.

**Tareas.**
1. Crear el formulario CF7 **por código** en provision o mu-plugin (CF7 guarda forms como post `wpcf7_contact_form` — crearlo vía `wp post create`/función idempotente con el markup versionado en `scripts/cf7-contacto.txt`): nombre, email, empresa, teléfono (opcional), mensaje.
2. Destino del mail: constante `MITSA_CONTACT_EMAIL` en `wp-config.php` (documentar; fallback `get_option('admin_email')`). Nunca hardcodear un email real en el repo.
3. Antispam: honeypot (campo CSS-hidden custom o plugin CF7 honeypot) — **no** reCAPTCHA en esta etapa.
4. Integrar shortcode en `template-contacto.php` reemplazando el HTML estático; conservar dirección; sin teléfono/email corporativo.
5. Mensaje de éxito CF7 + push a `dataLayer` (`{'event':'form_submit'}`) — P9b lo conecta a GTM.
6. Ajustar clases CF7 a los estilos de form de P2 (`docs/componentes.md`).

**Entradas.** `template-contacto.php`, `content/07-contacto.md`, `docs/componentes.md` (P2).
**Salidas.** Template actualizado, `scripts/cf7-contacto.txt`, form CF7 creado idempotentemente, honeypot.
**Criterios de aceptación.**
- [ ] Envío válido aparece en Mailpit; envío con honeypot lleno se descarta.
- [ ] `curl -X POST` saltándose validación HTML5 es rechazado server-side (CF7 valida).
- [ ] El HTML de /contacto/ no contiene teléfono ni email corporativo (curl + grep).
- [ ] Re-ejecutar provision no duplica el form CF7.

**Rollback.** Revert + `wp plugin deactivate contact-form-7`.

---

## P8 — SEO técnico: metas, schema, sitemap, redirecciones

**Context brief.** Estrategia en `content/seo-keywords.md` (v2, respaldada por `content/research/*`): priorizar BWTS/agua de lastre, protección catódica ICCP, antifouling/ánodos, ósmosis inversa marina, anticorrosión; no competir en términos core de IMPOMAR/EQUIMAR. `inc/seo.php` trae fallback title/meta que se autodesactiva si detecta Yoast/Rank Math. **Invariante #4: nada de contenido/metas nuevos sobre exclusividad Cathelco/Evac/Uson.** Bug conocido del sitio actual: menú "Contenedores para Supermercados" apunta a `/trituradores-organicos/`.

**Tareas.**
1. Instalar **Yoast SEO** (elegido: sitemap sólido, exclusión por post/CPT, gratis cubre lo necesario; documentar en el PR) vía provision. Verificar que `inc/seo.php` se autodesactiva.
2. Cargar titles/meta descriptions por página/categoría desde `content/seo-keywords.md` (script wp-cli sobre metas `_yoast_wpseo_title`/`_yoast_wpseo_metadesc`; las páginas draft las reciben igual).
3. `inc/schema.php` (JSON-LD custom): `Organization` + `LocalBusiness` (sede Reñaca; **sin teléfono/email** hasta que existan), `Product` en singles (sin precio; `brand` desde tax `marca`), `BreadcrumbList`. Excluir CPTs `lead` y attachments gated del sitemap Yoast.
4. Redirecciones 301: **crawl del sitio vivo con `wget --spider -r -np https://mitsachile.com -o crawl.log`** + sitemap actual si existe → tabla vieja→nueva en `docs/redirects-301.md` (cubrir 100% de las URLs del crawl, incluido `/trituradores-organicos/`). Implementación: bloque generado para `.htaccess` (hosting cPanel/Apache) versionado en `docs/redirects-301.md`, se aplica recién en P12.
5. Robots.txt correcto; verificar que URLs draft y `mitsa-gated/` no aparecen en `sitemap_index.xml`.

**Entradas.** `content/seo-keywords.md`, `content/research/*`, sitio actual en vivo.
**Salidas.** `inc/schema.php`, `docs/redirects-301.md`, script de metas, config Yoast documentada.
**Criterios de aceptación.**
- [ ] `sitemap_index.xml` accesible, sin URLs draft ni attachments gated.
- [ ] JSON-LD de Home, un single producto y un single caso valida sin errores en validator.schema.org.
- [ ] `docs/redirects-301.md` cubre el 100% de URLs del crawl (`grep -c` sobre crawl.log vs tabla).
- [ ] `grep -ri "exclusiv" ` sobre metas/schema no menciona Cathelco/Evac/Uson.

**Rollback.** Revert código; `wp plugin deactivate wordpress-seo` (el fallback `inc/seo.php` se reactiva solo); 301 nunca se aplicaron.

---

## P9a — Analítica: snippets GA4 + GTM + documentación GSC

**Context brief.** Compromiso contractual: GA4 + Search Console + Tag Manager desde el lanzamiento. `inc/analytics.php` tiene los hooks comentados esperando `MITSA_GA4_ID` y `MITSA_GTM_ID` en `wp-config.php`. IDs reales se crean en cuentas del cliente (dueño de todos los activos). **Nota de alcance:** banner de cookies NO está en la propuesta — no construirlo aquí; queda registrado en DECISIONS.md como adicional a cotizar (Ley 21.719).

**Tareas.**
1. Activar la lógica de `inc/analytics.php` condicionada a constantes (sin constantes → HTML limpio; jamás IDs hardcodeados).
2. Snippet GTM (head + noscript en body) y regla anti doble-tracking: si `MITSA_GTM_ID` existe, GA4 va solo vía GTM; `MITSA_GA4_ID` directo solo si no hay GTM (documentar en el código).
3. Documentar en `scripts/README.md` los pasos manuales para Juan/Luis: crear propiedad GA4 + contenedor GTM en cuenta del cliente, definir constantes en `wp-config.php` de producción, verificación GSC (meta tag o DNS).
4. Añadir a `docs/DECISIONS.md`: "Banner/gestión de consentimiento de cookies: fuera de alcance contratado, cotizar aparte (Ley 21.719)".

**Salidas.** `inc/analytics.php` activo, doc de setup, entrada en DECISIONS.md.
**Criterios de aceptación.**
- [ ] Sin constantes: `curl -s home | grep -c "googletagmanager\|gtag"` = 0.
- [ ] Con constantes dummy (`GTM-XXXX`): snippet head + noscript presentes, sin gtag directo duplicado.
- [ ] Ningún ID real en el repo (`git grep -E "G-[A-Z0-9]{6,}|GTM-[A-Z0-9]+"` solo encuentra dummies/documentación).

**Rollback.** Revert; vuelve a hooks comentados.

---

## P9b — Analítica: eventos dataLayer

**Context brief.** Requiere P9a (snippets), P7 (form contacto ya empuja `form_submit`) y P6b (descargas gated). Objetivo: instrumentar eventos de negocio en dataLayer para configurarlos luego en GTM.

**Tareas.**
1. `descarga_documento` en biblioteca (P6b): tipo de documento, gated sí/no, slug — push en la entrega del enlace firmado y en descarga libre (onclick delegado en `theme.js`).
2. `clic_representada` (outbound a sitios oficiales, delegado en `theme.js`).
3. Verificar `form_submit` de P7 llega al dataLayer.
4. Documentar los 3 eventos y sus parámetros en `scripts/README.md` (para configurar tags/triggers en GTM al lanzamiento).

**Criterios de aceptación.**
- [ ] Con constantes dummy: los 3 eventos visibles en `window.dataLayer` (consola browser) al ejecutar cada acción.
- [ ] JS sigue < 10 KB, sin dependencias.

**Rollback.** Revert.

---

## P10 — Carga de contenido, Home e integración visual

**Context brief.** Contenido en `content/*.md` (derivado del brochure, que manda sobre el sitio actual): `02-nosotros` 🟢, `03-productos` 🟢 (validados: copy de esas páginas y estructura de menú), `04-representadas`/`05-sectores`/`06-servicios`/`07-contacto` 🟡 (borrador). **No existe contenido de Home** — se redacta aquí. Regla dura (invariante #2): 🟢 → `publish`; 🟡 → `draft`; **todo copy nuevo redactado por la agencia (fichas de producto, Home, casos) → `draft`/`pending` hasta hito de validación con el cliente** — registrar el hito en DECISIONS.md. Ervor/EGGE draft; Cathelco/Evac/Uson solo entrada mínima (nombre/logo/categoría).

**Tareas.**
1. Redactar `content/01-home.md`: hero (propuesta de valor MITSA: representante de marcas líderes en tratamiento de aguas y equipos marinos desde 1982), bloques de categorías destacadas, sectores, CTA contacto — apoyado en brochure y `content/seo-keywords.md`. Estado: borrador a validar.
2. `scripts/import-content.sh` (wp-cli + pandoc `markdown→html`, ambos disponibles): convierte cada `content/NN-*.md` al `post_content` de su página respetando el mapa de estados; idempotente (actualiza si existe, no duplica). La Home se puebla en la página de portada.
3. Poblar CPT `producto`: un post por producto/subcategoría del sitemap, descripción redactada propia usando `pdftotext` del brochure como referencia (nunca OCR crudo). **Estado: todos `draft`** hasta validación de fichas.
4. Poblar CPT `representada` desde `content/04-representadas.md` (18 base draft + Ervor/EGGE draft marcadas "por confirmar"; recordar que TODO nace draft).
5. **Integración visual** (cierre del paralelismo P2 ∥ P3–P6a): recorrer archives/singles de producto, representada, caso y documento verificando que usan el markup de `docs/componentes.md`; corregir divergencias.
6. Actualizar `docs/DECISIONS.md`: hito "validación de fichas de producto y Home con el cliente antes de publish" + lista de qué quedó draft y por qué.

**Entradas.** `content/*.md`, brochure, CPTs de P3–P6a, `docs/componentes.md`.
**Salidas.** `content/01-home.md`, `scripts/import-content.sh`, contenido cargado, DECISIONS.md actualizado.
**Criterios de aceptación.**
- [ ] `wp post list --post_type=page --fields=post_title,post_status` refleja el mapa 🟢/🟡 exacto.
- [ ] `wp post list --post_type=producto --post_status=publish` está vacío (todo draft).
- [ ] Ningún producto Cathelco/Evac/Uson con contenido más allá de nombre+categoría+logo.
- [ ] Import corre dos veces sin duplicar.
- [ ] Las 4 vistas de CPT usan las clases del catálogo de componentes (revisión visual + grep de clases).

**Rollback.** `wp post delete` por tipo; scripts re-ejecutables.

---

## P11 — i18n-ready: .pot y barrido de strings

**Context brief.** Alcance: tema preparado para inglés futuro **sin implementarlo**. Textdomain `mitsa` ya en uso, pero no existe `.pot` y P2–P10 pueden haber introducido strings sin envolver.

**Tareas.**
1. Barrido: todo string de UI en PHP pasa por `__()`/`esc_html__()`/etc. con textdomain `mitsa` (grep de literales en templates e `inc/`).
2. `languages/mitsa.pot` con `wp i18n make-pot wp-content/themes/mitsa wp-content/themes/mitsa/languages/mitsa.pot`.
3. Verificar `load_theme_textdomain('mitsa', ...)` en `functions.php` (agregar si falta).
4. **No** crear `.po/.mo` en inglés ni instalar plugin multilenguaje.

**Salidas.** `languages/mitsa.pot`, strings corregidos.
**Criterios de aceptación.**
- [ ] `wp i18n make-pot` corre sin warnings de textdomain.
- [ ] Grep no encuentra strings de UI hardcodeados sin función de traducción.

**Rollback.** Revert.

---

## P12 — QA, performance y lanzamiento

**Context brief.** Último paso. Hosting destino: cPanel (BlueHosting) del cliente — credenciales SOLO en gestor de secretos local, jamás en el repo (fueron expuestas por correo; recomendar rotación — DECISIONS.md § seguridad). Dominio asumido: mitsachile.com (decisión 2026-07-12). El cliente es dueño de todo: dejar entrega portable (export completo posible).

**Tareas.**
1. QA funcional: checklist por página/CPT (render, links internos, breadcrumbs, form contacto, gating de biblioteca, 404).
2. Accesibilidad: navegación por teclado completa, `alt` en imágenes, jerarquía de encabezados única (un h1 por página), contraste — objetivo WCAG 2.1 AA en plantillas principales.
3. Performance: imágenes WebP + `srcset`, lazy loading nativo, medición **lab con Lighthouse móvil** (`npx lighthouse --preset=mobile`) sobre staging accesible — objetivo: performance ≥ 85, LCP lab < 2.5 s, CLS lab < 0.1 en Home + un single producto. (Field data/CrUX no existe al lanzamiento; no usarla como criterio.)
4. Staging en subdominio del hosting del cliente; migración con export BD + `wp search-replace 'http://localhost:PORT' 'https://staging.dominio'` + subir tema/uploads.
5. Lanzamiento: aplicar bloque 301 de `docs/redirects-301.md` al `.htaccess`, definir constantes reales GA4/GTM (P9a doc), verificar GSC, enviar sitemap, smoke test post-DNS (curl de las 10 URLs viejas principales → 301 → 200).
6. Backups automáticos en cPanel + export inicial completo (BD + files) archivado.
7. Actualizar `docs/entregables/` con resumen de lanzamiento para el cliente.

**Criterios de aceptación.**
- [ ] Checklist QA 100% en staging antes del cambio de DNS.
- [ ] Lighthouse móvil ≥ 85 con LCP/CLS lab dentro de objetivo en Home + single producto (reporte adjunto al PR).
- [ ] `curl -I` de las 10 URLs viejas principales: 301 → destino 200.
- [ ] GA4 (DebugView) recibe `form_submit` y `descarga_documento` reales; GSC verificado y sitemap enviado.
- [ ] `wp post list --post_status=publish` no contiene nada 🟡/no-validado sin registro de validación en DECISIONS.md.

**Rollback.** DNS de vuelta al sitio antiguo (mantener hosting anterior vivo 30 días); staging intacto.

---

## Protocolo de mutación del plan

- **Split**: si un paso supera 1 PR razonable, dividir en `PN-a`, `PN-b` heredando el context brief.
- **Insertar**: nuevos pasos con ID `PN.5`, motivo registrado abajo.
- **Saltar/abandonar**: marcar con fecha y motivo; nunca borrar el paso.
- **Bloqueos externos** (validación cliente, credenciales, respuesta sobre cathelco.cl): ejecutar el paso hasta donde no dependa del bloqueo; lo pendiente queda como checkbox abierto en el PR + entrada en `docs/DECISIONS.md`.

| Fecha | Mutación | Motivo |
|---|---|---|
| 2026-07-14 | v2: P6→P6a/P6b, P9→P9a/P9b; fixes de review adversarial (20 hallazgos: URLs /productos/, ACF free, gating real de archivos, privacidad leads, Home sin dueño, criterios no verificables, etc.) | Review pre-ejecución |

## Criterios de éxito globales (contrato)

1. Sitio WordPress administrable y responsive con tema custom sin page builder. (P1–P7)
2. Biblioteca técnica con gating configurable por documento y archivos realmente protegidos. (P6a/P6b)
3. Casos de éxito estructurados con opción de confidencialidad. (P5)
4. SEO inicial completo: estructura, metas, encabezados, URLs, sitemap, 301, imágenes optimizadas. (P8, P12)
5. GA4 + GSC + GTM operativos desde el lanzamiento, con eventos de negocio. (P9a/P9b, P12)
6. Multilenguaje-ready sin inglés implementado. (P11)
7. Todo contenido no validado por el cliente permanece en draft, trazado en DECISIONS.md. (P10, P12)
