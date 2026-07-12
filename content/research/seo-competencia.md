# Auditoría de competencia SEO en vivo — mitsachile.com

Fecha de investigación: 2026-07-12. Realizada con WebSearch/WebFetch en vivo (no es texto genérico ni reciclado del análisis original).

## 0. Cómo leer este documento

Este informe **amplía y corrige** `content/seo-keywords.md` v1 (análisis manual del diseñador del cliente, julio 2026, basado en 20 keywords contra IMPOMAR/EQUIMAR). No lo reemplaza — es insumo para que alguien (Luis/Francisco/Juan) decida si actualiza la v1.

**Limitaciones honestas, léanse antes de usar estos datos:**

- No tengo acceso a herramientas de keyword research (Search Console, SEMrush, Ahrefs, Google Keyword Planner). **Cero cifras de volumen de búsqueda, dificultad de keyword o tráfico en este documento** — donde el análisis original tampoco las tenía, esta auditoría tampoco las inventa.
- WebFetch no siempre entrega el HTML crudo (title/meta tags exactos); en varios casos devuelve un resumen generado por un modelo pequeño a partir del texto visible de la página. Donde no pude confirmar un `<title>` o `<meta description>` literal, lo digo explícitamente en vez de inventarlo.
- Un dominio (`ancorachile.cl`) no pudo ser accedido directamente por WebFetch (la página cargó como 404, probablemente por ser un sitio con mucho JavaScript); esa sección se reconstruyó con snippets de búsqueda, que son menos confiables que un fetch directo.
- No verifiqué posiciones de ranking real en Google para ningún término — solo qué contenido existe y qué términos usa cada sitio.

---

## 1. Resumen ejecutivo

1. **IMPOMAR y EQUIMAR se confirman en líneas generales**, pero con matices: IMPOMAR es más genérico de lo que sugiere el análisis original (portada muy pobre en contenido, casi sin texto indexable más allá de "Importaciones y Representaciones de Equipos Marítimos - Portuarios - Industriales - Seguridad"). EQUIMAR se confirma 100% como jugador de motores/bombas/repuestos para pesca industrial y artesanal (Lister-Petter, Beta Marine, Desmi, Steyr Motors, Alamarin-Jet) — no compite en ningún término de "protección casco" ni tratamiento de aguas.

2. **Hallazgo crítico que obliga a corregir la premisa central del análisis original**: el dominio `cathelco.cl` ("Cathelco Evac Chile"), operado por **ESVA Solutions** — distribuidor regional oficial de Cathelco y Evac para LATAM —, lista como contacto en Chile a **Francisco De la Iglesia**, el mismo contacto de Gerencia de Operaciones de MITSA (`fjdelaiglesia@mitsachile.com`), en la misma dirección (Av. Vicuña Mackenna 882, Reñaca, Viña del Mar). Es decir: **MITSA ya es el representante local de Cathelco/Evac y ya tiene contenido en vivo, indexable, en español, sobre protección catódica ICCP, antifouling y tratamiento de aguas residuales — pero en un dominio distinto a mitsachile.com.** Esto no es competencia externa, es un activo del propio grupo/cliente que el proyecto de rediseño no está considerando. Ver sección 3 para detalle y la pregunta abierta que esto genera.

3. **Encontré 5 competidores adicionales no cubiertos por el análisis original**, el más relevante de los cuales es **Ancora Chile** (`ancorachile.cl`) — representante de 14 marcas en el mercado naval/acuícola, con más de 30 años de trayectoria, que sí compite directamente en ósmosis inversa marina (marca Norwater) y plantas de tratamiento de aguas, dos de las categorías que el análisis original marcó como "sin competencia directa". Ver sección 4.

4. **La línea base del sitio actual de mitsachile.com confirma lo que ya se sabía**: SEO débil, sin términos técnicos, sin jerarquía de encabezados clara, sin schema. Ver sección 6.

5. Con esta información, la oportunidad "sin competencia directa" de `seo-keywords.md` v1 sigue siendo válida para **BWTS** y, parcialmente, para **fluidos anticorrosión (Cortec)** e **intercambiadores de calor** — pero ya no es 100% cierta para **protección catódica/ICCP/antifouling** (compite con el propio activo cathelco.cl del cliente, y con LLALCO a nivel de contenido internacional) ni para **ósmosis inversa marina** (compite con Ancora Chile/Norwater). Ver sección 5 para la matriz corregida.

---

## 2. Competidores originales: confirmación en vivo

### 2.1 IMPOMAR (impomar.cl)

- **Dirección/naturaleza confirmada**: Calle Limache 3405, Oficina 73, Viña del Mar. Título de portada detectado: "IMPOMAR, IMPORTACIONES MARITIMAS E INDUSTRIALES".
- El WebFetch no devolvió una meta description explícita ni un menú de navegación estructurado con categorías — la portada es principalmente una galería de imágenes sin mucho texto indexable. Esto es distinto a la imagen de "sitio con 16/20 términos dominados" que sugiere `seo-keywords.md` v1: si la portada tiene poco contenido textual, es más probable que ese dominio gane esos términos por páginas internas de producto, no por fuerza de homepage. No pude confirmar el detalle de esas páginas internas de categoría (`/productos/` devolvió 403 Forbidden al fetch).
- Términos repetidos confirmados en portada: "Importaciones", "Marítimos/Marítimas", "Industriales", "Representaciones", "Equipos".
- **Conclusión**: confirma la lista de "no competir" del análisis original (anclas, grilletes, señalización, motores/repuestos genéricos, seguridad SOLAS) es razonable — es el posicionamiento de marca explícito de IMPOMAR ("Importaciones y Representaciones"). No pude verificar en vivo cada una de las 16 keywords específicas del PDF original; esta auditoría no reemplaza esa verificación palabra por palabra.

### 2.2 EQUIMAR (equimar.cl)

- **Confirmado 100%**: "Equimar Spa", tagline "Desde 1982". Menú: Inicio, Catálogo, Accesorios, Servicio Técnico, Nosotros, Contacto, Carrito (tiene tienda online).
- Marcas destacadas en portada: **Lister-Petter** (motores industriales/generadores), **Beta Marine** (motores marinos), **Desmi** (bombas marinas e industriales), **Steyr Motors** (motores marinos SE6), **Alamarin-Jet** (propulsión waterjet), redes de pesca de monofilamento.
- **Conclusión**: EQUIMAR es 100% motores + bombas + repuestos + redes para pesca industrial/artesanal. No hay overlap con protección casco, BWTS, ósmosis inversa ni tratamiento de aguas — el análisis original acertó en descartarlo para esas categorías. Sí hay overlap parcial en **bombas marinas** (Desmi) con la categoría "Bombas y fluidos" de MITSA — coincide con el término "en disputa" que ya señalaba `seo-keywords.md` v1.

---

## 3. Hallazgo crítico: cathelco.cl es un activo afiliado a MITSA, no un competidor externo

Esto requiere que el equipo del proyecto tome una decisión — no la tomo yo aquí.

**Lo que encontré:**

- `cathelco.cl` se presenta como "Cathelco Evac Chile", operado por **ESVA Solutions**, distribuidor oficial de Cathelco® y Evac® para Argentina, Chile, Colombia, México, Panamá, Perú y Venezuela (confirmado también en `evac.com` y `cathelco.com.mx`).
- En la página de contacto/empresa de ESVA Solutions, **Chile aparece representado por "Mitsa Chile"**, en "Avda. Vicuña Mackenna 882, Reñaca, Viña del Mar", contacto **Francisco De la Iglesia**, +56985526282 — mismos datos que el contacto de Gerencia de Operaciones de MITSA en `CLAUDE.md`.
- `cathelco.cl` tiene contenido activo, en español, con URLs y encabezados propios, por ejemplo `/evac-oy/tratamiento-de-aguas-residuales/`:
  - H1: "Tratamiento de Aguas Residuales"
  - H2s: "¿Qué es el tratamiento de aguas residuales de Evac?", "¿Cómo funcionan los sistemas de tratamiento de aguas residuales?", "¿Por qué elegir las soluciones de tratamiento de aguas residuales de Evac®?", "Nuestro producto estrella en sostenibilidad: Evac MBR", "Evac MBR Mid-range"
  - Términos usados: biorreactores de membrana (MBR), biorreactores de lecho móvil (MBBR), aguas negras y grises, separadores de grasas, plantas de tratamiento biológico y electrolítico, Áreas Marinas Sensibles, normativa IMO MEPC.227(64) / USCG / Río Rin.
  - También tiene páginas dedicadas a protección catódica por corriente impresa (ICCP), aisladores galvánicos, ánodos, y sistemas antiincrustante/prevención de crecimiento marino.
- Una búsqueda de `site:mitsachile.com` devolvió un rastro histórico (blog 2011, directorio de representantes Evac worldwide) confirmando que MITSA lleva representando EVAC/Cathelco desde hace más de una década bajo el correo `evacequips@mitsachile.com`.

**Por qué esto importa para el proyecto:**

Este hallazgo contradice, en parte, la premisa de "sin competencia directa" que usa `seo-keywords.md` v1 para justificar la prioridad máxima de protección catódica/ICCP/antifouling: si el propio MITSA (a través de ESVA Solutions/Cathelco) ya tiene contenido indexado sobre esos términos en `cathelco.cl`, entonces:

- No es "sin competencia" — es contenido duplicado potencial entre dos dominios del mismo grupo, lo que puede diluir autoridad en vez de sumarla si ambos sitios apuntan a las mismas keywords sin coordinación.
- Es una pregunta de arquitectura de sitio que **no me corresponde resolver a mí solo**: ¿mitsachile.com debe tener contenido propio y diferenciado sobre ICCP/antifouling que enlace a cathelco.cl como "más detalle técnico", o debe evitar competir consigo mismo y limitarse a mencionar la representación con un enlace saliente?

**Recomendación**: señalar esto explícitamente a Francisco/Luis antes de redactar contenido nuevo para "Protección casco" en `content/`. No lo he tratado como una decisión tomada — lo dejo como hallazgo abierto.

---

## 4. Competidores nuevos identificados (no cubiertos por el análisis original)

| Competidor | Dominio | Qué es | Overlap real con MITSA |
|---|---|---|---|
| **Ancora Chile** | ancorachile.cl | Representante exclusivo de 14 marcas en mercado naval/acuícola, 30+ años, oficinas en Concepción y Puerto Montt, cobertura Arica-Punta Arenas. Representa **Norwater** (plantas de agua dulce/desalinización marina) y **CanaVac** (bombeo de peces), entre otras. Servicio técnico de plantas de tratamiento de aguas residuales, bombas hidráulicas, sistemas de propulsión. | **Alto** — compite directamente en ósmosis inversa marina/agua dulce a bordo (Norwater) y en plantas de tratamiento de aguas, dos categorías que `seo-keywords.md` v1 marcaba sin competencia. También overlap parcial en bombas. |
| **LLALCO Fluid Technology** | llalco.com | Empresa española (Madrid), 25+ años, división naval especializada en protección catódica ICCP, antifouling, BWT, tratamiento de aguas residuales (STP), monitoreo de sentinas, tecnología de vacío. Clientes: Navantia, Maersk, Acciona. | **Medio, pero solo a nivel de contenido/SEO internacional** — no encontré presencia comercial en Chile/LATAM, pero su sitio rankea en búsquedas genéricas en español ("protección catódica anticorrosión barcos, ánodos sacrificio") que un usuario chileno también podría hacer. Compite por visibilidad de contenido, no por venta local. |
| **Corroxión** | corroxion.cl | Empresa chilena (Providencia, Santiago) de soluciones anticorrosivas: epóxicos líquidos, cintas de petrolatum, sistema "Seashield" marino, cintas bituminosas, convertidor de óxido. | **Bajo-medio** — su línea "Sistemas Marinos Seashield" sugiere aplicación naval, pero el sitio no menciona explícitamente protección catódica, ICCP ni ánodos de sacrificio en la portada. Posible competidor parcial en "fluidos/recubrimientos anticorrosión para buques", no confirmado en profundidad. |
| **Harbor Marine (Perú)** | harbormarine.com.pe | Tienda náutica minorista en Callao/Perú, con categoría "Sanitarios Marinos" (41 productos) y "Accesorios para sistemas marinos". Enfoque recreativo/pesca artesanal, no B2B industrial. | **Bajo** — es retail regional (Perú, no Chile), enfoque recreativo/artesanal, no el segmento B2B industrial/naval/acuícola de MITSA. Relevante solo como referencia de cómo un competidor regional estructura la categoría "sanitarios marinos". |
| **ESVA Solutions / Cathelco Evac Chile** | cathelco.cl / esvasolutions.com | Ver sección 3 — **no es competencia externa, es un activo afiliado a MITSA.** Lo incluyo en esta tabla porque aparece en las búsquedas de keyword como si fuera un competidor, y alguien que repita esta investigación sin el contexto de `CLAUDE.md` lo clasificaría erróneamente como rival. | **N/A — mismo grupo.** |

**Cluster adicional detectado, de relevancia baja:** varias empresas chilenas de tratamiento de aguas industriales/municipales (Synertech Chile, Wetland S.A., Aguas Sipra, Hidrofresh, Ecopreneur, Aquavant) aparecen en búsquedas genéricas de "tratamiento de aguas Chile", pero **ninguna es marino/naval** — son plantas industriales o sanitarias terrestres (minería, alimentos, RILES municipales). No compiten por "tratamiento de aguas servidas para buques" específicamente, pero sí diluyen el término genérico "tratamiento de aguas" sin calificador naval — otro argumento para que MITSA nunca ataque el término genérico sin el calificador "naval/marino/a bordo/buques".

No encontré ningún competidor local o regional adicional específicamente para **BWTS** (los únicos nombres que aparecen — Alfa Laval, Optimarin, ERMA FIRST, Wilhelmsen, BIO-UV/TECO, DESMI Ocean Guard — son fabricantes globales, sin representación local confirmada en Chile en las búsquedas realizadas). Esto confirma la oportunidad "sin competencia directa" de `seo-keywords.md` v1 para BWTS específicamente.

---

## 5. Matriz corregida: quién domina, quién disputa, dónde hay oportunidad pura

| Término | Domina claramente | En disputa | Oportunidad pura (nadie lo ataca bien) |
|---|---|---|---|
| BWTS / tratamiento de agua de lastre | — | — | ✅ Confirmado. Ningún competidor local/regional encontrado; solo fabricantes globales sin presencia web en Chile. |
| Protección catódica / ICCP | — | **LLALCO** (contenido internacional en español) + **cathelco.cl** (activo del propio MITSA, ver sección 3) | Parcial — corregido respecto a v1. Ya no es "sin competencia": hay contenido existente, pero es del propio grupo. Requiere decisión de arquitectura, no de keyword. |
| Antifouling naval / ánodos de sacrificio | — | cathelco.cl (mismo caso que ICCP) | Parcial, mismo matiz que ICCP. |
| Ósmosis inversa marina / agua dulce a bordo | — | **Ancora Chile (Norwater)** — competidor real, regional, con trayectoria | Ya no es oportunidad pura — corregido respecto a v1. Ancora tiene 30+ años y cobertura nacional Arica-Punta Arenas. MITSA debería diferenciarse con contenido técnico propio, no asumir cancha libre. |
| Fluidos anticorrosión para buques (Cortec) | — | Corroxión (parcial, sin confirmar enfoque naval específico) | Mayormente confirmado como oportunidad — Cortec no tiene representación local confirmada distinta de MITSA/ESVA en las búsquedas realizadas. |
| Intercambiadores de calor | Varios distribuidores industriales genéricos (TermoEquipos/Alfa Laval, Pfenniger, Maestranza San Juan, Flowvalve) para el término genérico "intercambiadores de calor" | — | Confirmado como oportunidad **si se usa el calificador naval/marino** ("intercambiadores de calor navales", "intercambiadores de calor para buques") — el término genérico sin calificador está competido por proveedores industriales terrestres. |
| Plantas de tratamiento de aguas servidas (buques) | IMPOMAR (posicionamiento genérico) | cathelco.cl (mismo grupo), Ancora Chile (plantas de tratamiento de aguas, contexto acuícola/naval) | Sigue en disputa, como decía v1 — pero ahora con un competidor real adicional (Ancora) además de IMPOMAR. |
| Separador de agua-aceite | IMPOMAR | — | Sin cambios respecto a v1; no profundicé en un competidor nuevo específico para este término. |
| Bombas industriales y marinas | IMPOMAR / EQUIMAR | + Ancora Chile (bombas hidráulicas, servicio técnico) | En disputa, ahora con un tercer jugador confirmado. |
| Anclas, grilletes, señalización, SOLAS | IMPOMAR | — | Sin cambios — se confirma que es el core de marca de IMPOMAR ("Importaciones y Representaciones de Equipos... Seguridad"). No competir, como ya establece la estrategia del proyecto. |
| Motores, repuestos navales genéricos, redes de pesca | EQUIMAR | — | Sin cambios — confirmado 100% como core de EQUIMAR. No competir. |

---

## 6. Línea base SEO del sitio actual de mitsachile.com

WebFetch pudo acceder a `https://www.mitsachile.com` (a diferencia de algunos competidores). Hallazgos:

- **Navegación confirmada**: Nosotros, Productos, Representaciones, Noticias, Contáctanos. (Nota: el nombre actual es "Representaciones", singular/distinto de la propuesta "Representadas" del rediseño — solo lo señalo, no implica que haya que igualarlo.)
- **Title tag / meta description**: no se pudieron extraer de forma confiable con la herramienta disponible; el texto visible de portada es "Mitsa Chile – Tecnología de última generación". Esto en sí mismo es una señal de un title genérico y no optimizado (sin keyword de producto ni ubicación).
- **Debilidades confirmadas**:
  - Cero presencia de términos técnicos objetivo (BWTS, ICCP, protección catódica, antifouling, ósmosis inversa, intercambiadores de calor) en el contenido visible de portada.
  - Jerarquía de encabezados débil/inconsistente en secciones como "Productos Destacados" y "Nuestras Representaciones".
  - Lenguaje genérico ("tecnología de última generación", "personal altamente calificado") sin diferenciación de keyword.
  - Sin schema markup visible.
  - Páginas de categoría de producto ("Marina e Industrial", "Terrestre y Construcción") aparentan contenido delgado, sin descripciones expandidas.

Esto confirma, con evidencia en vivo y no solo por inferencia, que la línea base de SEO actual es efectivamente débil — consistente con la premisa del proyecto.

---

## 7. Recomendaciones priorizadas

Prioridad basada en "oportunidad sin competencia directa confirmada", que sigue siendo el eje de la estrategia del proyecto (ver `CLAUDE.md`), ajustada con la evidencia nueva de esta auditoría.

1. **Máxima prioridad, sin cambios respecto a v1: BWTS.** Es el único término de los cinco "prioritarios" que sigue sin ningún competidor local o regional confirmado. Construir la página nueva de Productos > Aguas y sanitarios > Tratamiento de agua de lastre (BWTS) 🔴 cuanto antes.

2. **Antes de escribir contenido de "Protección casco" (ICCP/antifouling/ánodos), resolver con Francisco/Luis la relación entre mitsachile.com y cathelco.cl.** Esto no es una tarea de copywriting ni de keyword — es una decisión de arquitectura de sitio y de grupo. Si no se resuelve, hay riesgo de duplicar contenido entre dos dominios del mismo cliente, lo que puede perjudicar a ambos en vez de ayudar. Sugerencia (a validar, no impuesta): mitsachile.com podría tener una página de categoría con overview + diferenciación de por qué MITSA/Cathelco es la opción técnica, enlazando a cathelco.cl para detalle de producto, en vez de duplicar el contenido técnico completo.

3. **Ósmosis inversa marina ya no es "cancha libre" — hay que diferenciarse de Ancora Chile/Norwater, no asumir que se gana por default.** Recomendación: el contenido de esta página debe apoyarse en casos de uso reales y en las marcas específicas que representa MITSA (a verificar contra el brochure), no solo en la keyword genérica.

4. **Intercambiadores de calor**: usar siempre el calificador naval/marino en title, H1 y URL (ej. "intercambiadores de calor para buques", no "intercambiadores de calor" a secas) — el término genérico está claramente competido por proveedores industriales terrestres (TermoEquipos/Alfa Laval y similares) que MITSA no puede ni debe intentar superar en ese term genérico.

5. **Fluidos anticorrosión para buques (Cortec) sigue siendo de baja competencia confirmada** — segunda prioridad razonable después de BWTS, ya que ningún representante local distinto de MITSA/ESVA apareció en las búsquedas.

6. **No tocar la lista de "no competir"** (anclas, grilletes, señalización, SOLAS, motores/repuestos genéricos) — esta auditoría la reconfirma con evidencia en vivo, no solo la mantiene por inercia del análisis original.

---

## 8. Qué falta para cerrar esta auditoría (fuera de mi alcance en esta sesión)

- Verificación con Search Console/herramienta de keyword research real de volumen de búsqueda para cada término — no disponible en esta sesión, no se debe estimar.
- Revisión palabra por palabra de las 16 keywords que `seo-keywords.md` v1 atribuye a IMPOMAR contra las páginas internas de `impomar.cl` — el fetch de `/productos/` devolvió 403 Forbidden; requeriría otro método de acceso (browser real, no WebFetch).
- Confirmación directa con Francisco De la Iglesia de la relación formal entre MITSA y ESVA Solutions/Cathelco (¿es la misma entidad legal, una alianza comercial, o una marca dentro del mismo holding?) — esto lo infiero de datos de contacto coincidentes, no de una fuente que lo declare explícitamente.
