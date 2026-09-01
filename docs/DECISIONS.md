# Decisiones — proyecto MITSA

Log vivo. Actualizar cuando se resuelva algo o llegue el "documento maestro" del cliente.

## Tomadas

| Fecha | Decisión | Fuente |
|---|---|---|
| 2026-06-30 | Contenido: brochure prioridad sobre sitio actual en caso de conflicto | Reunión inicial + MITSA_Mapa_del_sitio.pdf |
| 2026-07-08 | Marca a proyectar: "MITSA" (no "MITSA Chile") | Hilo "Inicio proyecto MITSA" |
| 2026-06-18/22 | Cliente propietario de todos los activos digitales | Hilo "Ideas para potenciar..." |
| 2026-06-18 | GA4 + GSC + GTM desde el lanzamiento | Hilo "Ideas para potenciar..." |
| — | Stack: WordPress, tema custom sin page builder | Propuesta de rediseño |
| 2026-07-12 | Fee mensual de mantención: parte comercial zanjada directamente por Juan (fuera de este repo) | Juan, sesión 2026-07-12 |
| 2026-07-12 | Sin documento maestro: seguir construyendo sobre contenido borrador ya generado, ajustar cuando llegue | Juan, sesión 2026-07-12 |
| 2026-07-12 | Página Contacto: solo formulario + dirección confirmada, sin teléfono/email hasta que el cliente los entregue | Juan, sesión 2026-07-12 |
| 2026-07-12 | Dominio: asumir mitsachile.com hasta aviso contrario del cliente | Juan, sesión 2026-07-12 |
| 2026-07-14 | Plan de construcción del sitio: `plans/mitsachile-rediseno-web.md` (14 pasos, v2 post-review adversarial) es la guía de ejecución | Sesión 2026-07-14 |
| 2026-07-14 | ACF versión FREE (sin repeater); specs de producto como textarea `clave\|valor` | Blueprint v2 |
| 2026-07-14 | Plugin SEO: Yoast; formularios: Contact Form 7; sin reCAPTCHA (honeypot) | Blueprint v2 |
| 2026-07-14 | URLs: página landing en `/productos/`, CPT sin archive, singles en `/producto/{slug}/`, taxonomía en `/productos/categoria/{term}/` | Blueprint v2 (resuelve colisión rewrite) |
| 2026-07-14 | Banner/gestión de consentimiento de cookies: fuera de alcance contratado, cotizar aparte (Ley 21.719) | Review del blueprint |
| 2026-08-26 | Landing SMM Hamburgo 2026 en `/smm2026/`: landing específica en inglés, móvil-first, con vCard de Francisco De la Iglesia, subida a producción en Hostinger (`domains/mitsachile.com/public_html/smm2026/`) y validada con Playwright | Solicitud cliente Francisco De la Iglesia (kit comercial SMM 2026) |
| 2026-08-26 | SSL & Redirección canónica 301: SSL reinstalado en Hostinger para cubrir `mitsachile.com` y `www.mitsachile.com`; `.htaccess` actualizado para forzar HTTPS y redirigir `www` a sin-`www` (`https://mitsachile.com/`) | Corrección bug certificado SSL / consolidación canónica |
| 2026-09-01 | Arquitectura Headless + Monorepo: Nueva web 2026 construida en `frontend/` con Astro SSG consumiendo WordPress como backoffice puro (REST API), manteniendo el monorepo unificado para centralizar la estrategia y fee de SEO. | Juan Jorquera, sesión 2026-09-01 |

## Abiertas — requieren decisión del cliente o de Juan/Luis (NO resolver solo)

1. **Secciones pendientes de validar con Luis/cliente**: Representadas (directorio de marcas), Sectores, Servicios, Contacto — hoy son hipótesis de Luis Silva más borrador generado en esta sesión, no contenido confirmado por el cliente.
2. **Nombre de categoría "Contenedores para Supermercados / trituradores orgánicos"**: bug de URL detectado (`/trituradores-organicos/`), revisar en CMS actual antes de migrar.
3. **Biblioteca técnica**: qué documentos van con gate de formulario de contacto vs. acceso libre — pendiente de definir por sección.
4. **Casos de éxito**: nombrar clientes reales (Armada de Chile, ASMAR, astilleros privados, salmoneras, navieras) cuando sea posible; usar "casos representativos" por industria solo si hay problema de confidencialidad puntual (acordado en el hilo de correo del 18-jun).
5. **Marcas "Ervor" (Finlandia) y "EGGE" (Suiza)**: aparecen en el brochure pero no estaban en la lista original de representadas del cliente — incluidas en `content/04-representadas.md` marcadas "por confirmar", validar antes de publicar.
6. **Teléfono/email corporativo de MITSA** — ✏️ CORREGIDO 2026-07-16: sí existen, publicados en el propio sitio actual (auditoría de producción). Teléfono **+56 32 2834052**, emails **info@mitsachile.com** y **evacequips@mitsachile.com**, dirección **Av. Vicuña Mackenna 882, Viña del Mar (Reñaca)**. Confirmar con el cliente que siguen vigentes antes de publicarlos en el sitio nuevo; la página de Contacto ya puede incluirlos.

## Notas de seguridad

- Credenciales de hosting (cPanel, GoDaddy, BlueHosting, NIC Chile) llegaron en texto plano por correo (`docs/Correo de AplicacionesWeb - Inicio proyecto MITSA.pdf`). Ese PDF está en `.gitignore`. Recomendar al cliente/agencia rotar esas contraseñas y moverlas a un gestor de secretos — quedaron expuestas en un hilo de correo con múltiples destinatarios. **No usar ese PDF como fuente de credenciales para intervenir producción**; pasar por `.env` local (gitignoreado) o canal seguro.

## Auditoría de producción (2026-07-16) — hallazgos verificados con curl crudo

⚠️ **CRÍTICO — el sitio actual está invisible en buscadores.** `https://mitsachile.com/robots.txt` contiene `User-agent: * / Disallow: /` (HTTP 200 confirmado): ordena a todos los buscadores no indexar ninguna página. Búsqueda de "Mitsa Chile tratamiento de aguas" NO devuelve el sitio propio (aparece un blogspot de 2011 y el Facebook). Otros hallazgos: sin `sitemap.xml` (404 en las 3 rutas estándar), sin GA4/GTM/analítica (cero en el HTML — contratado desde el día 1), `http://` no redirige a `https://` (responde 200), tema comercial `logiscargo` + WPBakery + RevSlider (CVEs históricos). Paquete de corrección listo en `docs/entregables/seo-produccion/`. Aplicar en producción requiere credenciales por canal seguro (NO el PDF comprometido).
- Bug de menú del `CLAUDE.md` confirmado: `/trituradores-organicos/` responde 200.
- `cathelco.cl` (decisión abierta #7): investigación técnica en curso, ver `content/research/cathelco-investigacion.md`.

## Hallazgos de la investigación SEO (2026-07-12) — requieren validación urgente con el cliente

7. **✅ RESUELTA 2026-07-16 (investigación técnica, confianza ~95%): `cathelco.cl` es de ESVA Solutions, NO de MITSA.** No hay canibalización de dominios entre activos propios. ESVA Solutions (distribuidor oficial Evac/Cathelco para México y LatAm, GM Edgar Esqueda, Guadalajara) publica en `cathelco.cl` un directorio de contactos por país; la ficha de Chile lista a "Mitsa Chile, Av. Vicuña Mackenna 882, Reñaca, contacto Francisco De la Iglesia" — por eso aparecía el nombre/dirección de MITSA: es un **dato dentro** del sitio de ESVA, no el dueño. Evidencia: cathelco.cl aloja en Dallas TX (IP 72.9.158.35, PTR mail.esvasolutions.com, comparte NS jetthost.net con esvasolutions.com) mientras MITSA aloja en Chile (186.64.114.205, NS pymedns.net); MX/SPF/teléfono distintos (cathelco.cl trae teléfono mexicano de Esqueda). Detalle completo en `content/research/cathelco-investigacion.md`. **Limitación:** no se obtuvo el registrante `.cl` textual (NIC Chile puerto 43 con timeout); veredicto sostenido en DNS+hosting+correo+contenido+web convergentes. **Implicancia SEO:** Uson Marine y keywords técnicas propias (BWTS, ICCP, antifouling naval, ósmosis marina) — avanzar YA, sin solapamiento. Cathelco/Evac como marca — técnicamente desbloqueado, pero cathelco.cl (de tu socio ESVA) ya rankea esos términos: **validar la relación comercial con Francisco antes de competir de frente por "Cathelco Chile / Evac Chile"** para no chocar con un partner en la SERP. Cerrar el registrante `.cl` al 100% desde un navegador (NIC Chile) cuando se pueda.
8. **SIHI**: existe "SIHI Chile S.A." establecida desde 1988, con presencia propia — validar si MITSA compite con un distribuidor de marca ya asentado en el término genérico "SIHI Chile".
9. **Meclube**: "Electrohidráulica" se declara representante exclusivo — mismo tipo de conflicto que Cathelco/Evac, menor escala.
10. **EQUIMAR tendría sucursales en Iquique y Talcahuano** (hallazgo de agente de investigación, sin verificación cruzada por Juan/Luis) — si se confirma, cambia la prioridad de SEO local (MITSA solo tiene sede en Reñaca).
11. **Ancora Chile (marca Norwater)**: competidor directo en ósmosis inversa marina y tratamiento de aguas, 30+ años en el mercado — el análisis original (`content/seo-keywords.md` v1) marcaba esa categoría como "sin competencia"; ya no es así, corregir prioridad en v2.
12. Otros competidores nuevos detectados sin analizar en profundidad: LLALCO (España), Corroxión, Harbor Marine (Perú) — ver `content/research/seo-competencia.md`.

Ver `content/research/` para el detalle completo de las 4 investigaciones (regulatorio, competencia en vivo, marcas+geo, sectorial/local) que sustentan `content/seo-keywords.md` v2.
