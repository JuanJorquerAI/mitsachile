# Migración SEO de mitsachile.com a mitsa.org

**Informe de revisión y plan para aprobación · 20 de octubre de 2026 · America/Santiago**

**Dictamen: la migración es viable, pero el destino todavía no está preparado para recibir tráfico orgánico.** Hay equivalencia comprobada para las 36 URLs de los sitemaps actuales. El bloqueo principal es que ambos sitios entregan `noindex, nofollow`. También deben resolverse URLs históricas y recursos ausentes antes de activar redirecciones.

Se realizaron únicamente consultas públicas y lecturas mediante MCP de Hostinger. No se modificaron sitios, WordPress, archivos remotos, DNS ni redirecciones. Este documento propone trabajo; no constituye autorización de implementación.

## 1. Qué se verificó

| Revisión | Resultado |
|---|---|
| Hostinger MCP | Ambos dominios activos, WordPress, misma cuenta y orden de hosting; directorios separados |
| Sitemaps | 7 sitemaps hijos por dominio; 36 URLs únicas por sitio |
| Páginas | 72 respuestas HTML revisadas; todas HTTP 200, un H1 por página |
| Equivalencia | Las 36 parejas tienen la misma ruta y el mismo texto principal extraído del HTML |
| Inventario público WordPress | Por dominio: 10 páginas, 6 entradas, 9 soluciones, 6 industrias y 2 proyectos; una sola página de resultados por tipo |
| URLs adicionales | 7 rutas históricas o fuera del sitemap, comprobadas en ambos dominios |
| Recursos | 108 parejas de URLs: 72 recursos del sitio actual, 34 imágenes históricas y 2 descargas SMM |
| Variantes de dominio | HTTP/HTTPS y con/sin www en ambos dominios |
| Configuración | Lectura de ambos `.htaccess`; contienen bloques de LiteSpeed y WordPress, sin traslado de dominio explícito |

Las equivalencias se apoyan en estado HTTP, ruta, título, H1 y comparación exacta del texto de `main` (o su alternativa). No equivalen a una comparación visual, funcional o binaria completa. Para recursos se comprobó HTTP y tipo mediante HEAD, no identidad de archivos. El inventario no incluye todas las variantes `srcset`, fondos CSS ni URLs huérfanas desconocidas.

## 2. Hallazgos que condicionan la migración

### P0 — Indexación bloqueada en los dos sitios

Las 36 páginas de cada dominio contienen `<meta name='robots' content='noindex, nofollow'>`. Ninguna de estas 72 páginas contiene `rel="canonical"`. El resultado se confirmó además en ambas portadas con una URL de comprobación y respuesta de caché **miss**.

Los dos `robots.txt` permiten el rastreo y anuncian su propio sitemap. Esto no anula `noindex`: Google puede leer la página y excluirla de los resultados. [Documentación de Google sobre noindex](https://developers.google.com/search/docs/crawling-indexing/block-indexing).

**Trabajo propuesto:** identificar el origen en visibilidad de WordPress, tema o filtros SEO; habilitar indexación únicamente en contenidos aprobados; verificar canonical autorreferente en mitsa.org y coherencia con sitemap, Open Graph y schema. Mientras se prepara el traslado, decidir si corresponde retirar también el bloqueo del sitio actual. No puede determinarse desde este rastreo cuándo comenzó ni cuánto posicionamiento se perdió.

### P0 — Landing SMM y descargas sin destino

| Recurso | mitsachile.com | mitsa.org |
|---|---:|---:|
| `/smm2026/` | 200 | 404 |
| `/smm2026/MITSA-Company-Profile-2026.pdf` | 200 | 404 |
| `/smm2026/francisco-de-la-iglesia.vcf` | 200 | 404 |

**Propuesta preferida:** conservar la landing y copiar sus recursos al mismo path en mitsa.org antes del traslado. Así se conservan enlaces comerciales y códigos QR. Si se decide retirarla, definir una alternativa comercial realmente equivalente; no enviar automáticamente todo a la portada.

### P1 — URLs históricas que requieren reglas específicas

| Origen en mitsachile.com | Estado actual | Destino propuesto en mitsa.org | Criterio |
|---|---|---|---|
| `/representaciones/` | 301 → `/soluciones/` | `/representadas/` | El contenido histórico es un directorio de fabricantes; corregir la equivalencia semántica |
| `/tt-service/productos/` | 404 | `/soluciones/` | Recuperar la antigua entrada al catálogo; validar cobertura de productos |
| `/noticias/` | 301 → `/centro-tecnico/` | `/centro-tecnico/` | Archivo de publicaciones |
| `/marina-e-industrial/` | 301 → `/industrias/` | `/industrias/` | Equivalencia amplia; comprobar si requiere landing marina específica |
| `/terrestre-y-construccion/` | 301 → `/industrias/instalaciones-en-tierra/` | `/industrias/instalaciones-en-tierra/` | Continuidad temática |
| `/trituradores-organicos/` | 404 | **Sin homólogo confirmado** | Recuperar contenido histórico y confirmar oferta; había inconsistencia de nombre en el menú |
| `/smm2026/` | 200 | `/smm2026/`, después de migrarla | No activar regla hacia un 404 |

Las cuatro redirecciones históricas existentes también se reproducen dentro de mitsa.org. Las reglas del traslado deben apuntar directamente al destino final aprobado.

### P1 — Recursos históricos ya perdidos

Los 72 recursos actuales comprobados responden 200 en ambos dominios. Las 34 imágenes de rutas históricas de 2016–2018 devuelven 404 en ambos. El problema ya existe antes del cambio de dominio.

Recuperar originales desde respaldos o réplica antigua y contrastar imágenes equivalentes antes de decidir su nueva ruta. Hay candidatos por nombre, como `foto-770x310.png` y `orca4-770x310.png`, pero no se verificó equivalencia visual: no están aprobados como sustitutos. Priorizar recuperación según enlaces y tráfico de imágenes cuando se obtenga Search Console.

### P1 — Falta línea base de posicionamiento

El conector OpenSEO accesible solo contiene el proyecto aplicacionesweb.cl; no hay un proyecto MITSA conectado allí. No se obtuvieron datos privados de Search Console, GA4 ni logs HTTP históricos. La búsqueda de operaciones de hosting no proporcionó un endpoint de logs HTTP aplicable a estos WordPress.

**No se puede afirmar cuántas visitas, posiciones o enlaces se conservarán.** Antes del lanzamiento: obtener propiedades verificadas de ambos dominios; exportar rendimiento por página y consulta de los últimos 16 meses disponibles, con comparación reciente de 90 y 28 días; revisar indexación, enlaces externos, acciones manuales y retiradas. Complementar el mapa con URLs de esos informes y logs. La ausencia del proyecto en OpenSEO no demuestra que Search Console o Site Kit estén desactivados.

### P2 — Limpieza editorial y medición

- `/hello-world/` es la entrada de ejemplo de WordPress y está incluida en el sitemap. Proponer retirada y 404/410 después de revisar enlaces; no indexarla por habilitar el sitio globalmente.
- Revisar la utilidad de `/category/uncategorized/` y del archivo `/author/juanaplicacionesweb-cl/`. El autor visible es una cuenta de la agencia. La equivalencia técnica no implica que deban indexarse.
- Faltan metadescripciones en 11 páginas por dominio: archivos, entradas y los dos proyectos. Redactarlas para las páginas que deban indexarse.
- No se detectaron identificadores GA4/GTM en el HTML revisado. Confirmar medición real con navegador y eventos antes del lanzamiento; el HTML por sí solo no prueba ausencia total de analítica.
- En mitsa.org los enlaces HTTP extraídos no apuntan a mitsachile.com. Sí se conserva `mailto:info@mitsachile.com`: es correo corporativo, no un error de migración. Mantener correo, MX y servicios asociados salvo instrucción independiente.
- El contenido en vivo habla de 1984 y títulos “MITSA Chile”; contrastarlo con las fuentes aprobadas del cliente antes de cambios editoriales. Evitar mezclar el traslado técnico con reescrituras generales.

## 3. Mapa de equivalencias

Se entrega **`mapa-redirecciones.csv` con 43 filas**: 36 parejas actuales y 7 excepciones. Incluye origen, destino propuesto, estado HTTP, evidencia temática y decisión pendiente. **Es un documento de revisión, no un archivo importable de reglas.**

Las 36 rutas actuales coinciden: portada; Nosotros, Contacto, Representadas, Servicios, Recursos, Soluciones, Industrias, Proyectos y Centro Técnico; 9 soluciones; 6 industrias; 2 proyectos; 6 entradas; 2 categorías y un archivo de autor. Los detalles completos están en `tabla-equivalencias.md` y en el CSV. Las entradas de ejemplo y archivos tienen un tratamiento editorial separado.

La propuesta central es conservar las rutas actuales en mitsa.org. La igualdad del texto principal entre dominios reduce el cambio necesario; no es preciso inventar una estructura nueva para realizar este traslado.

## 4. Plan de trabajo propuesto

| Fase | Trabajo concreto | Entregable / condición de salida | Estimación orientativa |
|---|---|---|---|
| 1. Línea base y aprobación del mapa | Obtener GSC/GA4 y URLs históricas; decidir SMM, trituradores y archivos; priorizar por tráfico y enlaces | Mapa final sin URLs relevantes sin tratamiento | 0,5–1 jornada, sujeto a accesos |
| 2. Preparar mitsa.org | Corregir indexación/canonical, migrar SMM y recursos aprobados, limpiar sitemap y comprobar medición | Destinos aprobados con 200, contenido correcto e indexación permitida | 1–2 jornadas; recuperación histórica aparte si falta respaldo |
| 3. Preparar traslado | Respaldar archivos/BD/configuración; generar y revisar reglas; probar copia aislada | Matriz de pruebas completa y reversión preparada | 0,5–1 jornada |
| 4. Ejecutar tras aprobación | Activar reglas, purgar caché, comprobar rutas, actualizar señales y solicitar cambio de dirección | Verificación técnica y registro horario del corte | Ventana de 1–2 horas |
| 5. Seguimiento | Revisar errores, rastreo, indexación y rendimiento combinado de ambos dominios | Reportes a 7, 14, 30, 60 y 90 días | Seguimiento; no plazo garantizado de recuperación |

Son estimaciones de trabajo, no cotización ni promesa de posicionamiento. La corrección de indexación del dominio actual podría aprobarse como intervención urgente separada si la migración completa se posterga.

### Diseño de redirecciones y operación

Proponer **301 de servidor**, restringidas a los hosts antiguos, con excepciones históricas explícitas antes de reglas generales. Las permanentes señalan el destino preferido a Google. [Google: redirecciones](https://developers.google.com/search/docs/crawling-indexing/301-redirects).

Para este hosting, evaluar reglas fuera de los bloques autogenerados de WordPress/LiteSpeed. No instalar todavía una regla global que arrastre las excepciones a páginas inexistentes. Contemplar las variantes www, HTTP y HTTPS: hoy HTTP+www recorre dos saltos dentro de cada dominio. Procurar un salto directo al destino HTTPS sin www; verificar si las normalizaciones previas ocurren en hPanel.

Conservar parámetros de contacto (`puerta`, `solucion`, `sol`, `mensaje`) y atribución. Definir tratamiento propio para robots, sitemaps, verificaciones de propiedad, administración y API; evitar que una redirección indiscriminada interrumpa el backoffice. Las rutas desconocidas deben conservar un 404/410 real, sin convertirse en portada con 200.

Mantener el dominio antiguo, HTTPS válido y redirecciones durante **al menos un año**, preferiblemente de forma indefinida por enlaces y materiales impresos. Preparar sitemap del destino con URLs canónicas indexables y mantener inventario del origen para seguimiento. Google recomienda mapear URLs, trasladar recursos y monitorizar ambos sitios; puede haber fluctuaciones temporales. [Google: traslado con cambio de URL](https://developers.google.com/search/docs/crawling-indexing/site-move-with-url-changes).

Después de verificar las redirecciones y la titularidad de ambos sitios con la misma cuenta, solicitar **Cambio de dirección** desde la propiedad antigua en Search Console. Este paso se realiza después del traslado, no lo sustituye. [Google: herramienta de cambio de dirección](https://support.google.com/webmasters/answer/9370220).

### Pruebas y reversión

Antes del corte deben estar aprobadas todas las filas relevantes y existir respaldo recuperable. Tras el corte comprobar el 100% del mapa y los recursos seleccionados: 301 correcto, destino 200, ausencia de bucles y de noindex en páginas prioritarias, canonical, sitemap y equivalencia de contenido. Probar con/sin barra, www/HTTPS, rutas inexistentes y parámetros de contacto. Verificar formularios y eventos con un envío de prueba acordado durante la implementación.

Si aparecen bucles, errores 5xx, 404 masivos o falla de contacto, restaurar configuración previa y caché; preservar nuevas consultas recibidas, sin restaurar indiscriminadamente una BD antigua. Si ya se envió Cambio de dirección, evaluar su cancelación junto con la reversión. La reversión técnica no garantiza una reversión instantánea de lo procesado por Google.

Seguimiento diario la primera semana. Comparar clics e impresiones **sumando ambos dominios** durante la transición y segmentar páginas/consultas importantes; la caída aislada del dominio antiguo es esperable. Investigar cualquier nueva exclusión por noindex, destino roto o caída sostenida frente a la línea base, considerando estacionalidad y retraso de GSC.

## 5. Aprobación que habilitaría el trabajo

Aprobar la migración hacia `https://mitsa.org/` con conservación de rutas; las correcciones técnicas previas; recuperación del catálogo histórico y cambio de `/representaciones/` hacia `/representadas/`; conservación de SMM con sus descargas; y las decisiones editoriales pendientes del CSV. Resolver `/trituradores-organicos/` según contenido real antes de cerrar sus reglas.

El lanzamiento queda condicionado a línea base, destinos comprobados, mapa aprobado, respaldo y pruebas. **No se ha ejecutado ninguna de estas modificaciones.**

## Evidencia y límites

- `crawl.json`: HTML analizado, texto, metadatos, enlaces y sitemaps de ambos sitios.
- `inventario-seo.csv`: 72 páginas para revisión tabular.
- `mapa-redirecciones.csv` y `tabla-equivalencias.md`: correspondencias y excepciones.
- `supplement.json`: variantes, rutas históricas y tipos de contenido públicos de WordPress. Endpoints administrativos respondieron 401/404; no se intentó acceder a ellos autenticadamente.
- `assets.json` e `inventario-recursos.csv`: 108 parejas de recursos y cadenas históricas.
- `home-*.html` y `recheck.json`: confirmación adicional de noindex sin hit de caché.
- `htaccess-*.txt`: configuración leída por MCP, sin secretos.

Captura puntual del 20/10/2026. Se revisó el sitio público realmente servido, que actualmente usa WordPress y tema `mitsa-v2`, sin asumir que el frontend Astro del repositorio sea producción. Los hallazgos antiguos del repo sobre robots, DNS y hosting no se trataron como estado vigente. Falta cobertura de URLs solo presentes en GSC, backlinks o logs, y no se auditó rendimiento visual/Core Web Vitals ni funcionamiento completo del formulario en esta fase de lectura.
