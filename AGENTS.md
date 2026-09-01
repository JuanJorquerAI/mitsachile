# AGENTS.md

This file provides guidance to Codex when working with code in this repository.

## Proyecto

Rediseño web + posicionamiento digital de **mitsachile.com** (MITSA SpA) para el cliente MITSA, ejecutado por **AplicacionesWeb** (agencia — este repo es de la agencia, no del cliente final). Sitio corporativo en **WordPress**, foco B2B: representación de marcas líderes mundiales en tecnología de tratamiento de aguas y equipos marinos/ambientales (sanitario marino, aviación, pesquero, acuícola, minero, industrial, comercial, residencial). Cliente opera desde 1982, sede en Reñaca, Viña del Mar.

Contactos:
- Cliente: Francisco De la Iglesia (Gerencia de Operaciones, fjdelaiglesia@mitsachile.com), Francisca De la Iglesia (Finanzas, francisca@mitsachile.com)
- Agencia: Juan Jorquera (CEO, juan@aplicacionesweb.cl), Luis Silva (Jefe de Diseño y Nuevos Negocios, luis@aplicacionesweb.cl)

## Regla de oro: fuente de verdad del contenido

**El brochure corporativo (`docs/Brochure MITSA SPA - Extracto..pdf`) tiene prioridad sobre el sitio actual en caso de conflicto.** Esto es una decisión explícita del cliente (ver `docs/MITSA_Mapa_del_sitio.pdf`, nota sobre Misión/Visión). El sitio actual (mitsachile.com) sirve solo para: (a) estructura de menú real validada, (b) referencia de qué NO repetir (errores, enlaces rotos, bugs de contenido).

Bug de contenido conocido en el sitio actual: el ítem de menú "Contenedores para Supermercados" apunta a `/trituradores-organicos/` — no migrar esa inconsistencia sin revisar antes.

## Estado del sitemap (ver `content/00-sitemap.md`)

- **Validado** (usar contenido real): Nosotros, Productos.
- **Propuesto / por validar con el cliente** (Luis/Francisco deben confirmar): Representadas, Sectores, Servicios, Contacto.
- **Nuevo, no existe hoy**: categoría "Protección casco" (anticorrosión/ICCP, antifouling, ánodos de sacrificio), "Intercambiadores de calor", BWTS.

No tratar contenido "propuesto" como final. Cuando se genere copy para esas secciones, marcarlo explícitamente como borrador pendiente de validación del cliente.

## Alcance técnico (propuesta aceptada, 45 UF + IVA desarrollo)

- Sitio WordPress administrable y responsive.
- Estructura preparada desde el inicio para versión en inglés futura (multilenguaje-ready), pero **sin implementar inglés en esta etapa**.
- Analítica **ya activa en producción (jul 2026)** vía plugin Site Kit: GA4 + GSC operativos; GTM lo gestiona Site Kit automáticamente. Pendiente: Bing Webmaster Tools.
- Biblioteca técnica / centro de descargas (fichas técnicas, catálogos, certificados, manuales, brochures) — algunas descargas de alto valor comercial deben ir tras formulario de contacto, otras de acceso libre (a definir por sección).
- Sección de casos de éxito / proyectos destacados, estructurada por: cliente/tipo, industria, problema, solución, producto/tecnología, resultado. Si no se puede nombrar cliente por confidencialidad, usar "casos representativos" por industria (Armada, astilleros, salmoneras, navieras, proyectos internacionales).
- SEO inicial: estructura, títulos/metadescripciones, jerarquía de encabezados, URLs amigables, sitemap.xml, optimización de imágenes.
- **Fuera de alcance inicial** (no construir sin cotización aparte): traducción/versión en inglés completa, multilenguaje implementado, producción fotográfica/audiovisual, rediseño de logo, compra de dominios, integraciones ERP/CRM, funcionalidades no mencionadas en la propuesta.

## Estrategia SEO (ver `content/seo-keywords.md`)

Basado en análisis competitivo vs. IMPOMAR/EQUIMAR (`docs/MITSA_Mapa_Sitio_Palabras_Clave.pdf`). Priorizar términos donde MITSA tiene ventaja técnica real y sin competencia directa: BWTS/tratamiento agua de lastre, protección catódica ICCP, antifouling naval/ánodos de sacrificio, ósmosis inversa marina, fluidos anticorrosión para buques. No competir en términos genéricos fuera del rubro (anclas y cadenas, grilletes, señalización marítima, equipos de seguridad SOLAS — son core de IMPOMAR, no de MITSA).

## Blog / artículos SEO (cluster regulatorio)

5 artículos en `content/08`–`12` (norma D-2/BWTS, Circular A-52/007, ICCP vs ánodos, ósmosis inversa a bordo, MARPOL Anexo IV). Workflow: markdown en `content/` → borrador (draft) en WordPress → aprobación del cliente **antes** de publicar. Nunca publicar directo. PDFs de revisión para el cliente en `docs/entregables/revision-contenidos-tecnicos-*`.

## Seguridad: credenciales

`docs/Correo de AplicacionesWeb - Inicio proyecto MITSA.pdf` contiene credenciales en texto plano de cPanel, GoDaddy, BlueHosting y NIC Chile del cliente. Ese archivo está en `.gitignore` — **nunca quitarlo del gitignore ni commitearlo**.

Las credenciales operativas ya viven en `.env` en la raíz (gitignoreado): cPanel, GoDaddy, BlueHosting, NIC Chile, Hostinger (`HOSTINGER_DB_*`) y WP application password (`MITSA_WP_APPPASS`). `.env` es la fuente de secretos — nunca copiarlos a archivos versionados, ni a `content/`, ni a `docs/DECISIONS.md`.

## Hosting / PHP

Producción actual corre en **Hostinger con PHP 8.4** — tanto el sitio intermedio (armado rápido para partir con SEO) como el nuevo. El sitio antiguo (BlueHosting, PHP 5.4) está **deprecado**; su plan de migración quedó en `plans/migracion-php-wp-2026-07.md` como referencia histórica. Se puede usar PHP moderno sin restricciones.

## Estructura del repo

- `docs/` — material fuente entregado por el cliente (PDFs: brochure, propuesta, mapas de sitio, correos). No editar, son insumo.
- `docs/DECISIONS.md` — log de decisiones pendientes/tomadas (dominio, marca "MITSA" vs "MITSA Chile", fee mensual 9 vs 12 UF, etc.) para no perder contexto entre sesiones.
- `docs/entregables/` — informes y entregables ya enviados/preparados para el cliente (HTML, PDF, previews).
- `content/` — contenido estructurado en markdown, listo para cargar a WordPress, derivado de `docs/` + copy nuevo. Fuente de verdad para lo que entra al sitio. Incluye `content/research/` (investigación SEO/técnica), `content/sitio-actual/` (referencia del sitio viejo) y artículos de blog `08`–`12`.
- `wp-content/themes/mitsa/` — tema WordPress custom (PHP clásico, sin page builder, **sin build tools ni linters** — PHP/CSS/JS plano). Sin plugins de arrastrar-soltar; usar ACF si se necesitan campos custom.
- `frontend/` — frontend desacoplado (Astro SSG) para la nueva web de producción (basada en la Maqueta 2026), 100% estático, ultra-rápido (Core Web Vitals 100/100, TTFB < 50ms), preparado para consumir WordPress Headless vía REST API.
- `scripts/` — shell scripts operativos (ver su README): `setup-wp.sh` (bootstrap WP local), `provision.sh` (páginas/menús idempotente), `wpcli.sh` (wrapper WP-CLI), `build-frontend.sh` (compila Astro SSG y sincroniza a `export/`), `aplicar-seo-produccion.sh` (sube robots/sitemap por SFTP, requiere `MITSA_SFTP_*` en `.env`), `export-estatico.sh` (espejo estático a `export/`).
- `smm2026/` — landing page específica para la feria marítima **SMM Hamburgo 2026** (kit comercial para Francisco De la Iglesia: inglés, mobile-first, vCard, 100% estático y optimizado). Desplegado en producción en Hostinger bajo `/home/u549101671/domains/mitsachile.com/public_html/smm2026/`.
- `plans/` — planes de trabajo (rediseño, migración PHP, planes de fin de semana).
- Gitignoreados locales: `wp/` (WordPress local), `wpactual/` (réplica del sitio actual, servida con Caddy en `:8894`), `staging/`, `export/`.

## Sincronía multi-agente

CLAUDE.md es la fuente de verdad de instrucciones. `AGENTS.md` (Codex) es espejo manual — tras editar CLAUDE.md, replicar el cambio en AGENTS.md. `.codex/agents/` espeja `.claude/agents/`, y `.agents/skills/` espeja `.claude/skills/` (las copias de `.agents/` referencian AGENTS.md en vez de CLAUDE.md — es intencional, no drift). Tras editar una skill en `.claude/skills/`, replicar en `.agents/skills/`.

## Decisiones ya tomadas por el cliente

- Marca: proyectar como **"MITSA"** (no "MITSA Chile") para expansión regional a Latinoamérica.
- Cliente es propietario de todos los activos digitales (dominio, hosting, sitio WordPress, base de datos, contenidos, material gráfico). Hosting puede quedar administrado por AplicacionesWeb dentro del servicio mensual, pero portable — se debe poder entregar copia completa sin pagos pendientes.
- Analítica: GA4 + GSC + GTM desde el día 1 — ya implementado en producción vía Site Kit (jul 2026).

## Decisiones abiertas (no asumir, ver `docs/DECISIONS.md`)

- Fee mensual de mantención: propuesta original 12 UF/mes, cliente propuso 9 UF/mes o 12 UF atadas a entregables — sin cerrar en el último correo del hilo.
- Dominio final a usar.
- Validación final de secciones Representadas, Sectores, Servicios, Contacto contra el "documento maestro" que el cliente prometió entregar (aún no llegó en los correos disponibles).
