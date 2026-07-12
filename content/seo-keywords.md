# Estrategia de palabras clave — mitsachile.com (v2)

Fuente de verdad de la estrategia SEO del proyecto. Reemplaza la v1 (julio 2026, análisis manual de Luis Silva sobre `docs/MITSA_Mapa_Sitio_Palabras_Clave.pdf`, un PDF de 2 páginas). La v1 queda disponible en el historial de git.

Esta v2 incorpora cuatro investigaciones adicionales en vivo (WebSearch, 2026-07-12) que confirman parte de la v1, corrigen otra parte, y añaden un eje regulatorio que la v1 no cubría: `content/research/seo-regulatorio.md`, `content/research/seo-competencia.md`, `content/research/seo-marcas-geo.md`, `content/research/seo-sectorial-local.md`. Ver sección "Fuentes" al final.

---

## 1. Resumen ejecutivo

La ventaja competitiva más defendible de MITSA no es de marca ni de precio: es **regulatoria**. El Convenio BWM de la OMI exige que todo Plan de Gestión de Agua de Lastre (BWMP) elaborado desde el 8-sep-2024 cumpla el estándar D-2, y DIRECTEMAR ya fiscaliza en terreno en Valparaíso y San Antonio con fluorómetros. MITSA representa a Erma First (BWTS) y no tiene ningún competidor local o regional detectado en ese término — es el único de los cinco términos "sin competencia" de la v1 que sigue siéndolo tras la investigación en vivo, y debería ser la prioridad número uno del proyecto, sin discusión.

El resto del marco de la v1 (competir donde IMPOMAR/EQUIMAR no juegan) sigue siendo la lógica correcta, pero la investigación en vivo encontró competidores fuera de ese marco original que obligan a corregir dos categorías: **ósmosis inversa marina** ya no es "cancha libre" (Ancora Chile, marca Norwater, 30+ años de trayectoria y cobertura nacional) y **protección catódica/ICCP/antifouling** tampoco (LLALCO tiene contenido internacional en español, y — más importante — apareció un hallazgo que requiere decisión del cliente antes de avanzar, ver abajo). Ambas categorías bajan de Tier 1 a Tier 2 en esta versión.

**Dos riesgos requieren decisión del cliente antes de publicar contenido de "Protección casco":**

1. **`cathelco.cl`** — dos investigaciones independientes encontraron datos contradictorios: una lo identifica como sitio de ESVA Solutions (representante exclusivo de Cathelco/Evac en 7 países de LatAm, competidor externo); la otra encontró que ese mismo dominio lista como contacto a Francisco De la Iglesia con la misma dirección de MITSA en Reñaca — es decir, podría ser un activo del propio cliente. Mientras esto no se aclare, no se debe invertir en contenido SEO de ICCP/antifouling/ósmosis vía Cathelco (`docs/DECISIONS.md` #7).
2. **Ancora Chile (Norwater)** — competidor real y establecido en ósmosis inversa marina que la v1 no detectó (`docs/DECISIONS.md` #11). No es un motivo para abandonar la categoría (MITSA tiene producto real), pero sí para no tratarla como oportunidad sin esfuerzo.

Metodológicamente, todo esto es cualitativo: no hay volumen de búsqueda real detrás de ninguna cifra de este documento (ver sección 9).

---

## 2. Tier 1 — Prioridad máxima

Oportunidad alta, sin competencia local/regional fuerte confirmada, alta intención comercial o regulatoria. Un title/meta por **página** (no por keyword aislada) para no duplicar metadatos entre filas que comparten destino.

| Página (sitemap) | Keyword(s) objetivo | Intención de búsqueda | Por qué es prioridad |
|---|---|---|---|
| Productos > Aguas y sanitarios > Tratamiento de agua de lastre (BWTS) 🔴 | BWTS / sistema de tratamiento de agua de lastre · norma D-2 IMO · Erma First Chile · Plan de Gestión de Agua de Lastre (BWMP) | Transaccional/compliance — armador, naviera o astillero con obligación normativa vigente | Único término de los 5 originales de la v1 que sigue sin ningún competidor local o regional confirmado tras la investigación en vivo (`seo-competencia.md` §4, §7). Driver regulatorio verificable y reciente: todos los BWMP desde sep-2024 deben ser D-2; DIRECTEMAR fiscaliza activamente (`seo-regulatorio.md` §2-3). MITSA representa a Erma First. |
| Productos > Bombas y fluidos > Intercambiadores de calor 🔴 | intercambiadores de calor navales / para buques | Transaccional técnico | Categoría nueva, sin entrada en el sitio actual. El término genérico ("intercambiadores de calor" a secas) está copado por proveedores industriales terrestres (TermoEquipos/Alfa Laval, Pfenniger, Maestranza San Juan) — **el calificador naval/marino es obligatorio** en title, H1 y URL para no competir donde MITSA no tiene ventaja (`seo-competencia.md` §5, recomendación 4). |
| Productos > Protección casco 🔴 (fluidos anticorrosión) | fluidos anticorrosión para buques · recubrimientos anticorrosivos navales | Transaccional técnico — mantenimiento/astillero | Nicho sin competidor directo confirmado (Corroxión es solo parcial, sin foco naval explícito verificado). **Nota abierta**: el brochure/`content/04-representadas.md` no tiene hoy una marca específica asociada a este término — coordinar con mitsa-content-writer antes de publicar para no inventar respaldo de marca que no está confirmado. |
| Representadas > Erma First | Erma First Chile · Erma First FIT BWTS | Navegacional/marca — comprador que ya conoce al fabricante y busca representante local | Único caso de marca "limpio": sin competidor de nombre detectado y con el mayor respaldo de contenido del brochure (`seo-marcas-geo.md`, Nivel 1). |
| Representadas > Herborner Pumpen | Herborner Pumpen Chile · bombas industriales y marinas Herborner | Navegacional/marca técnica | Fabricante alemán reconocido sin distribuidor local detectado en ninguna búsqueda (`seo-marcas-geo.md`, Nivel 1). |
| Representadas > EPE | EPE protección ambiental marina Chile · EPE Triton FIT tratamiento de aguas residuales yates | Transaccional técnico | Sin competidor detectado bajo el nombre de marca; +45 años de trayectoria citable del brochure. Además, como EPE también cubre protección catódica, es una vía para sostener contenido de esa categoría **sin depender de Cathelco** mientras se resuelve la Alerta 1 (sección 5). |

### Title tags y meta descriptions sugeridos

| Página | Title (caracteres) | Meta description (caracteres) |
|---|---|---|
| BWTS | `BWTS Chile: Tratamiento de Agua de Lastre \| MITSA` (49) | `Sistemas BWTS Erma First para cumplir la norma D-2 de la OMI y la normativa DIRECTEMAR en Chile. Tratamiento de agua de lastre certificado para buques.` (151) |
| Intercambiadores de calor | `Intercambiadores de Calor Navales \| MITSA Chile` (47) | `Intercambiadores de calor para buques y aplicaciones navales e industriales. MITSA representa fabricantes líderes con respaldo técnico en Chile.` (146) |
| Protección casco — fluidos anticorrosión | `Fluidos Anticorrosión para Buques \| MITSA` (41) | `Recubrimientos y fluidos anticorrosivos para cascos y estructuras navales. Protección técnica contra la corrosión marina, representada por MITSA.` (147) |
| Representadas — Erma First | `Erma First Chile: Sistemas BWTS \| MITSA` (39) | `MITSA es representante de Erma First en Chile: sistemas BWTS FIT con monitoreo remoto por IA, certificados IMO, USCG y sociedades de clasificación.` (150) |
| Representadas — Herborner Pumpen | `Herborner Pumpen Chile: Bombas \| MITSA` (38) | `MITSA representa a Herborner Pumpen en Chile: bombas industriales y marinas alemanas de alta confiabilidad para faenas exigentes.` (131) |
| Representadas — EPE | `EPE Chile: Protección Ambiental Marina \| MITSA` (46) | `EPE, con más de 45 años en protección ambiental marina y equipos de respuesta ante emergencias, representada en Chile por MITSA.` (129) |

---

## 3. Tier 2 — Oportunidad media (en disputa)

MITSA tiene ventaja técnica real (marca representada, brochure de respaldo) pero la investigación en vivo confirmó competencia real — se puede ganar con mejor contenido y diferenciación, no por ausencia de rivales.

| Página (sitemap) | Keyword(s) objetivo | Intención de búsqueda | Por qué está en disputa |
|---|---|---|---|
| Protección casco > Sistemas anticorrosión / ICCP | protección catódica ICCP naval · certificación ICCP por sociedad clasificadora (DNV, ABS, Lloyd's Register, Bureau Veritas) | Transaccional técnico, alta intención | LLALCO (España) tiene contenido internacional en español sobre ICCP/antifouling/BWT. Más relevante: `cathelco.cl` ya tiene contenido activo e indexado sobre ICCP — pero su relación con MITSA es la Alerta 1 sin resolver (sección 5). Recomendación provisional: sostener este ángulo vía EPE en vez de Cathelco hasta resolver la alerta. |
| Protección casco > Antifouling / Ánodos de sacrificio | sistema antiincrustante naval · ánodos de sacrificio para buques | Transaccional técnico, alta intención | Mismo conflicto con `cathelco.cl` que ICCP. Además, `mares-chile.cl` ya está optimizado para "Circular A-52/007" en el ángulo de **servicio de limpieza de casco** — MITSA debe diferenciarse compitiendo en el ángulo de **producto** (sistema/ánodos), no de servicio (`seo-regulatorio.md` §6, `seo-competencia.md` §4). |
| Aguas y sanitarios > Osmosis inversa | ósmosis inversa marina · planta de agua dulce a bordo | Mixta — informacional (cómo funciona) + transaccional (comprador de flota) | Ancora Chile (marca Norwater) es competidor real, con 30+ años y cobertura nacional Arica-Punta Arenas (`docs/DECISIONS.md` #11). Ya no es "cancha libre" como decía la v1 — requiere contenido diferenciado con casos de uso reales y marcas específicas de MITSA, no solo la keyword genérica. |
| Aguas y sanitarios > Plantas de tratamiento de aguas servidas | plantas de tratamiento de aguas servidas para buques | Transaccional, intención media | IMPOMAR (posicionamiento genérico) + `cathelco.cl` (contenido activo sobre Evac MBR) + Ancora Chile compiten aquí. Sigue siendo la lectura de la v1, pero ahora con un tercer competidor confirmado. |
| Aguas y sanitarios > Plantas separadoras de agua sentina | separador de agua-aceite | Transaccional, intención media | IMPOMAR domina el término genérico; en el ángulo pesquero-acuícola también compiten Aguamarket, Synertech y FibraNov (`seo-sectorial-local.md` §2). |
| Bombas y fluidos > Bombas marinas | bombas industriales y marinas (término genérico, sin marca) | Transaccional, intención media | IMPOMAR/EQUIMAR (Desmi) + Ancora Chile ya compiten en el término genérico. Recomendación: usar siempre long-tail de marca (Herborner Pumpen Chile) en vez del término genérico sin calificar. |
| Representadas > Blucher | Blucher Chile drenaje acero inoxidable | Transaccional, intención media | Hay demanda visible en catálogos de arquitectura chilenos (Insytec, Canalinox) sin representante oficial claramente dominante — verificar si alguno de esos actores ya opera como distribuidor no declarado antes de invertir. |
| Representadas > Planus | Planus separador agua-aceite Chile | Transaccional, intención media | Sin competidor de nombre de marca, pero la categoría de producto (separador agua-aceite) ya está en disputa por su cuenta (fila de arriba). |
| Representadas > FCI Watermaker / Burks Pumps | FCI Watermaker Chile · Burks Pumps Chile | Transaccional, intención media | Posible conflicto sin confirmar: FCI tiene un dealer-map público que podría listar a otro distribuidor en Chile; Burks Pumps menciona "oficina en Santiago" en snippets sin confirmar si es propia o de un tercero. Verificar antes de priorizar (`seo-marcas-geo.md`, Nivel 3). |

---

## 4. Tier 3 — No competir / baja prioridad

| Término / categoría | Razón para no priorizar |
|---|---|
| Anclas y cadenas · grilletes · señalización marítima · equipos de seguridad SOLAS | Core de marca explícito de IMPOMAR ("Importaciones y Representaciones... Seguridad"); confirmado con evidencia en vivo, no solo por inercia de la v1. |
| Motores y repuestos navales genéricos · redes de pesca | Core de marca confirmado 100% de EQUIMAR (Lister-Petter, Beta Marine, Desmi, Steyr Motors, Alamarin-Jet). |
| Equipos portuarios · compactadores de basura · trituradores/maceradores genéricos | Fuera del catálogo ambiental central de MITSA; recordar el bug de URL conocido `/trituradores-organicos/` para "Contenedores para Supermercados" (`docs/DECISIONS.md` #2) si se toca esta categoría. |
| Protección catódica / tratamiento de aguas / bombas industriales para **minería**, sin calificador naval | Mercado terrestre consolidado con especialistas dedicados (CathPro, Corrotek, ONIX en protección catódica; Synertech, Ecopreneur, SGS, Grupo EBI en tratamiento de aguas; PGIC, ProMinent, Xylem, KSB en bombeo minero). MITSA sí tiene producto para el sector Minero, pero perdería si ataca estos términos genéricos — mantener siempre el calificador naval/marino (`seo-sectorial-local.md` §3). |
| Ósmosis inversa industrial (sin calificador "marina") | Mercado de commodity técnico saturado por proveedores genéricos (Avalco, Texpro, Aquacenter, Global Vital, Simtech, Soecol). |
| Páginas SEO dedicadas por ciudad (Iquique, Talcahuano, San Antonio, etc.) | Sin sustento de presencia física de MITSA fuera de Reñaca; ni siquiera los competidores con sucursales reales (EQUIMAR) construyen SEO por ciudad — resuelven cobertura nacional con una sola página. Ver sección 8. |
| Aviación (página o metadatos dedicados) | Sin evidencia de demanda de búsqueda en español ni de producto documentado más allá de la mención histórica de posicionamiento (`content/05-sectores.md`). |
| Moyno Chile | Categoría ya ocupada por múltiples distribuidores chilenos especializados y activos (Banff Bombas, Prime Pumps Chile, Tecfluid Chile). |
| Terminator (compactadoras/trituradoras) | Categoría genérica ya saturada por decenas de empresas chilenas y ya asignada a "no competir" en el marco del proyecto. |
| H2O · Hepworth (como nombres de marca) | Ambigüedad de nombre genéricamente inviable para SEO (H2O se satura con agua embotellada/purificadores; Hepworth con una marca británica no relacionada de plomería). |

---

## 5. Alertas — requieren decisión del cliente antes de publicar contenido

Detalle completo en `docs/DECISIONS.md`, sección "Hallazgos de la investigación SEO". Resumen operativo:

1. **`cathelco.cl` (DECISIONS #7)** — contradicción entre dos investigaciones independientes: podría ser un competidor externo (ESVA Solutions, representante exclusivo declarado en 7 países) o un activo del propio grupo MITSA (mismo contacto y dirección de Francisco De la Iglesia). **No construir contenido nuevo de Protección casco vía Cathelco/Evac/Uson Marine hasta que Francisco lo aclare.**
2. **SIHI Chile S.A. (DECISIONS #8)** — empresa establecida desde 1988 con el mismo nombre que la marca representada por MITSA según el brochure. Verificar si hay conflicto de representación antes de invertir en SEO de esa marca.
3. **Meclube (DECISIONS #9)** — "Electrohidráulica" se declara representante exclusivo en Chile. Conflicto confirmado, no solo potencial.
4. **EQUIMAR — sucursales en Iquique y Talcahuano (DECISIONS #10)** — hallazgo sin verificación cruzada. Si se confirma, refuerza (no cambia) la recomendación de cobertura nacional vía schema en vez de páginas por ciudad, porque MITSA seguiría sin presencia física fuera de Reñaca.
5. **Ancora Chile / Norwater (DECISIONS #11)** — competidor real en ósmosis inversa marina y tratamiento de aguas, 30+ años en el mercado. Ya incorporado como corrección en el Tier 2 de este documento.
6. **Uson Marine, Ervor, EGGE** — sin ficha de producto confirmada en el brochure y, en el caso de Ervor/EGGE, sin confirmar siquiera que sigan siendo representadas activas (`docs/DECISIONS.md` #5, `content/04-representadas.md`). No priorizar SEO para estas marcas hasta validación del cliente.
7. **Otros competidores detectados sin analizar en profundidad (DECISIONS #12)**: LLALCO (España), Corroxión, Harbor Marine (Perú) — no cambian la priorización de este documento, pero deben tenerse presentes si se profundiza el análisis en una fase posterior.

---

## 6. Mapeo página → keywords objetivo

| Página (sitemap) | Keywords objetivo (1-3) | Tier |
|---|---|---|
| Home | protección del medio ambiente marino (posicionamiento de marca) | — (branding, no competitivo) |
| Nosotros 🟢 | Sin término específico — página de autoridad/E-E-A-T (historia desde 1982, trayectoria) | — |
| Productos (hub) | Agregador — enlaza a subcategorías, sin keyword propia | — |
| Productos > Aguas y sanitarios > Tratamiento de agua de lastre (BWTS) 🔴 | BWTS · norma D-2 IMO · Erma First Chile | Tier 1 |
| Productos > Aguas y sanitarios > Osmosis inversa | ósmosis inversa marina · planta de agua dulce a bordo | Tier 2 |
| Productos > Aguas y sanitarios > Plantas de tratamiento de aguas servidas | plantas de tratamiento de aguas servidas para buques | Tier 2 |
| Productos > Aguas y sanitarios > Plantas separadoras de agua sentina | separador de agua-aceite | Tier 2 |
| Productos > Aguas y sanitarios > Toilet al vacío / Sistemas generadores de vacío | sistemas sanitarios marinos al vacío (sin datos de competencia propios; depende de Alerta Evac) | — |
| Productos > Bombas y fluidos > Bombas marinas | bombas industriales y marinas · Herborner Pumpen Chile | Tier 1/2 mixto |
| Productos > Bombas y fluidos > Intercambiadores de calor 🔴 | intercambiadores de calor navales / para buques | Tier 1 |
| Productos > Protección casco 🔴 > Sistemas anticorrosión / ICCP | protección catódica ICCP naval · certificación por sociedad clasificadora | Tier 2 |
| Productos > Protección casco 🔴 > Antifouling | sistema antiincrustante naval | Tier 2 |
| Productos > Protección casco 🔴 > Ánodos de sacrificio | ánodos de sacrificio para buques | Tier 2 |
| Productos > Protección casco 🔴 (general) | fluidos anticorrosión para buques | Tier 1 |
| Representadas 🟡 | Erma First Chile · Herborner Pumpen Chile · EPE Chile | Tier 1 |
| Sectores 🟡 > Marino/naval | BWTS · protección catódica naval (agregador de los términos de arriba) | Tier 1/2 |
| Sectores 🟡 > Pesquero-acuícola | separador agua-aceite (long-tail) + contexto RAMA/SERNAPESCA (informacional) | Tier 2 |
| Sectores 🟡 > Minero | protección catódica de casco para buques (mantener calificador naval, no atacar el término minero genérico) | Tier 3 en genérico / Tier 2 si se califica |
| Servicios 🟡 | Sin término específico confirmado — sección aún sin validar | — |
| Contacto 🟡 | cobertura nacional / dónde operamos (ángulo local, no keyword transaccional) | — |

---

## 7. Clusters de contenido recomendados (blog / biblioteca técnica)

Ideas de contenido largo para capturar intención informacional de alto valor antes de la compra — coherente con la "biblioteca técnica / centro de descargas" ya contemplada en el alcance del proyecto (`CLAUDE.md`). Ninguna de estas ideas está confirmada con el cliente; son propuestas a validar con mitsa-content-writer.

1. **"Guía: cómo cumplir con la norma D-2 de la OMI en Chile"** — keyword objetivo: *norma D-2 IMO Chile / Plan de Gestión de Agua de Lastre (BWMP)*. Ángulo: explicar el plazo (todos los BWMP desde sep-2024 deben ser D-2), qué exige DIRECTEMAR, y cómo Erma First resuelve el cumplimiento.
2. **"Circular DIRECTEMAR A-52/007: qué exige la nueva normativa de biofouling en Chile desde junio 2025"** — keyword objetivo: *Circular A-52/007 DIRECTEMAR*. Ángulo: framing regulatorio/de producto (sistemas antiincrustantes y ánodos), evitando competir de frente con el ángulo de servicio de limpieza de casco que ya ocupa mares-chile.cl.
3. **"Protección catódica ICCP vs. ánodos de sacrificio: qué exige tu sociedad clasificadora"** — keyword objetivo: *certificación ICCP DNV ABS Lloyd's Register Bureau Veritas*. Ángulo: mantenimiento/ingeniería naval, no solo cumplimiento legal — matiz que señala `seo-regulatorio.md` §5.
4. **"Ósmosis inversa a bordo: cómo elegir una planta de agua dulce para buques y pesqueros"** — keyword objetivo: *planta de ósmosis inversa marina*. Ángulo: diferenciación técnica frente a Ancora/Norwater con casos de uso reales.
5. **"MARPOL Anexo IV en Chile: qué exige DIRECTEMAR para el tratamiento de aguas sucias a bordo"** — keyword objetivo: *MARPOL Anexo IV Chile aguas sucias*. Ángulo: contexto regulatorio de respaldo para la página de plantas de tratamiento de aguas servidas (refuerza E-E-A-T, no es keyword de página propia).

---

## 8. SEO local

Recomendación de `content/research/seo-sectorial-local.md`: **no construir páginas SEO dedicadas por ciudad portuaria** (Valparaíso, San Antonio, Iquique, Antofagasta, Coquimbo, Talcahuano, Puerto Montt, Punta Arenas).

Razones:
- MITSA no tiene evidencia documental de presencia física fuera de Reñaca/Viña del Mar, mientras que EQUIMAR sí tendría sucursales en Iquique y Talcahuano (sin verificar, ver Alerta 4).
- Ni siquiera los actores con presencia física real en cada puerto (Marval, Chile Ships Services) construyen páginas SEO por ciudad — resuelven cobertura nacional con una sola página de alcance.
- Páginas locales sin sustento de negocio real (NAP, reseñas, Google Business Profile por sede) leerían como contenido delgado, en contra de la regla del proyecto de no forzar contenido de relleno.

**Recomendación concreta**: una sola sección "Cobertura" o "Dónde operamos" (dentro de Nosotros, Servicios o Contacto — secciones aún 🟡 sin validar) que mencione de forma natural los puertos que MITSA atiende, más schema `LocalBusiness` con la sede real de Reñaca y un `areaServed` que declare alcance nacional. Esto es multilenguaje-ready y no requiere hreflang activo en esta etapa (`CLAUDE.md`). Si en el futuro MITSA confirma una sucursal física o representante técnico local en algún puerto, ahí sí se justifica una página local dedicada con NAP propio — no antes.

---

## 9. Nota metodológica

Esta investigación se realizó mediante **WebSearch/WebFetch en vivo** el 12 de julio de 2026, sin acceso a ninguna herramienta de keyword research real (Google Keyword Planner, Ahrefs, SEMrush, DataForSEO) ni a Google Search Console (el sitio aún no está en producción). Toda etiqueta de prioridad, intención o volumen en este documento es **cualitativa**: se basa en presencia/ausencia de competidores visibles en resultados de búsqueda y en señales de intención (existencia de driver regulatorio, actividad de fiscalización, actores comerciales compitiendo por el término), no en cifras de tráfico o volumen de búsqueda mensual reales. Donde una investigación no encontró datos suficientes, se dice explícitamente "sin dato" en vez de estimar una cifra.

**Recomendación para la siguiente fase**: validar esta priorización con datos reales una vez el sitio esté publicado — Google Search Console (ya contemplado en el alcance del proyecto desde el lanzamiento) es el mínimo; una herramienta paga de keyword research (Ahrefs, SEMrush, o la extensión DataForSEO ya disponible en este entorno) permitiría confirmar o corregir esta priorización con volumen de búsqueda real antes de comprometer más presupuesto de contenido en los tiers 2 y 3.

---

## Fuentes

- `docs/MITSA_Mapa_Sitio_Palabras_Clave.pdf` — análisis original (v1), MITSA vs. IMPOMAR/EQUIMAR.
- `content/research/seo-regulatorio.md` — normativa OMI/IMO, DIRECTEMAR y clasificadoras navales.
- `content/research/seo-competencia.md` — auditoría de competencia en vivo (IMPOMAR, EQUIMAR, Ancora Chile, LLALCO, Corroxión, Harbor Marine, hallazgo cathelco.cl).
- `content/research/seo-marcas-geo.md` — long-tail marca + geografía/producto por representada.
- `content/research/seo-sectorial-local.md` — normativa sectorial (salmonicultura/minería), evaluación de sobre-extensión, y SEO local por ciudad.
- `docs/DECISIONS.md` — log de decisiones abiertas, secciones 7-12 (hallazgos de esta investigación SEO).
