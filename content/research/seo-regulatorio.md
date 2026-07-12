# Investigación SEO — términos regulatorios y de cumplimiento normativo

Fecha de investigación: 2026-07-12. Complementa `content/seo-keywords.md` (v1, fuente de verdad de la estrategia de keywords) con un cluster que esa versión no cubría en profundidad: normativa OMI/IMO, DIRECTEMAR y clasificadoras navales, por ser el eje de mayor intención de compra B2B para MITSA.

**Nota metodológica**: todo lo aquí reportado proviene de búsquedas web en vivo (WebSearch/WebFetch) realizadas el 2026-07-12, más las páginas oficiales de DIRECTEMAR y OMI/IMO cuando fue posible acceder a ellas. Las etiquetas de volumen (alto/medio/bajo) son cualitativas, basadas en cuántos resultados relevantes devolvió cada búsqueda, si hay actores comerciales/SEO activos compitiendo por el término, y si existe una página oficial dedicada al tema. **No se usó ninguna herramienta de keyword research (Search Console, SEMrush, Google Keyword Planner, etc.) — no hay cifras de volumen de búsqueda real.** Se recomienda validar con GSC una vez el sitio esté indexado, y opcionalmente con `seo-dataforseo` si el cliente adquiere esa capacidad.

## 1. Resumen del marco regulatorio encontrado

| Marco | Autoridad | Vigencia | Relevancia para MITSA |
|---|---|---|---|
| Convenio BWM (gestión agua de lastre) | OMI/IMO | En vigor desde 8-sep-2017; norma D-2 exigida en todos los planes de gestión elaborados desde 8-sep-2024 | Directa — ERMA FIRST (BWTS) |
| DIRECTEMAR — Aguas de Lastre | Armada de Chile | Circular A-51/002 (recambio de agua de lastre; excluye cabotaje) + exigencia de BWMP, Libro de Registro y Certificado Internacional | Directa — MITSA puede posicionarse como referente técnico local |
| DIRECTEMAR — Circular A-52/007 (biofouling / limpieza de casco) | Armada de Chile | Actualizada 4-abr-2025, vigente desde 24-jun-2025 (60 días tras publicación en Diario Oficial 24-abr-2025) | Directa — antifouling / protección de casco |
| MARPOL Anexo IV (aguas sucias) | OMI/IMO + DIRECTEMAR (Circular A-52/001) | Vigente, Chile es parte vía D.S. (RR.EE.) N° 1.689/1994 | Indirecta — EVAC sistemas sanitarios marinos |
| MARPOL Anexo V (basuras) | OMI/IMO | Vigente | Baja relevancia directa (MITSA no vende gestión de basuras como foco) |
| Convenio AFS 2001 (sistemas antiincrustantes) | OMI/IMO | En vigor desde 2008, prohíbe TBT | Indirecta — contexto normativo para antifouling |
| Certificación ICCP por clasificadoras | DNV, ABS, Lloyd's Register, Bureau Veritas, ClassNK | No es tratado internacional sino requisito de clase | Directa — Cathelco |

## 2. BWTS / Convenio BWM / norma D-2

**Queries usadas**: "sistema tratamiento agua de lastre D-2 IMO plazo cumplimiento 2026", "certificación BWTS Chile buques agua de lastre", "Convenio BWM OMI plazo cumplimiento buques 2024 2025", "plan de gestión de agua de lastre BWMP Chile naves requisito", "tratamiento agua de lastre Chile proveedor instalación empresa naviera".

| Hallazgo | Detalle |
|---|---|
| Estándar D-2 | Regula la eliminación/destrucción de organismos biológicos antes de la descarga. Exigido en todos los planes de gestión elaborados desde el 8-sep-2024 (fuente: OMI, MundoMaritimo). |
| Documentos exigidos a bordo | Plan de Gestión del Agua de Lastre (BWMP) aprobado por el registro de abanderamiento/sociedad clasificadora, Libro de Registro del Agua de Lastre, Certificado Internacional de Gestión del Agua de Lastre. |
| Chile — nivel normativo | Un artículo académico citado en los resultados señala que la normativa chilena específica se restringe a la Circular A-51/002, calificada como "instrumento de baja jerarquía" y que **excluye naves de cabotaje** — esto es una brecha regulatoria real que MITSA podría explicar en contenido (verificar el texto exacto de la circular antes de publicar esa afirmación, no se pudo acceder directamente al PDF). |
| Verificación en puerto | DIRECTEMAR/DIRINMAR ya realiza mediciones de diagnóstico a bordo con fluorómetros "Ballast Check 2" en Valparaíso y San Antonio — evidencia de fiscalización activa, no solo normativa en papel. |
| Competencia | IMPOMAR y EQUIMAR no aparecen en ningún resultado para estos términos (búsqueda `site:impomar.com OR site:equimar.cl` con estos términos no devolvió contenido de esos dominios). Confirma el análisis de `seo-keywords.md`: sin competencia directa detectada. |
| Proveedores/competencia técnica visible en Chile | DLC, Synertech Chile, Kopur aparecen como proveedores de tratamiento de aguas en general (no específicamente BWTS/ERMA FIRST) — no es competencia directa en el nicho BWTS, pero sí ocupan parte del espacio de "tratamiento de aguas" genérico. |

**Volumen (cualitativo)**: medio a nivel internacional (mucha cobertura de industria naval global — Alfa Laval, Optimarin, Krohne tienen páginas propias sobre BWTS), bajo-medio a nivel Chile específico (pocos resultados en español enfocados en Chile). **Intención**: alta — comprador técnico/armador buscando cumplimiento obligatorio, no informacional casual.

**Términos concretos identificados**:
- "sistema de tratamiento de agua de lastre" / "BWTS" — alto valor, MITSA tiene ventaja real (ERMA FIRST)
- "plan de gestión de agua de lastre" / "BWMP" — long-tail técnico, probablemente bajo volumen pero muy alta intención (compradores que ya saben que necesitan cumplir)
- "certificado internacional de gestión de agua de lastre" — long-tail informacional/transaccional
- "norma D-2 IMO" / "estándar D-2" — informacional, útil para contenido de blog/FAQ que capture búsquedas de comprensión regulatoria antes de la compra

**Página del sitio**: Productos > Aguas y sanitarios > Tratamiento de agua de lastre (BWTS) 🔴 (ver `content/00-sitemap.md`).

## 3. DIRECTEMAR — aguas de lastre y medio ambiente marino

**Queries usadas**: "normativa DIRECTEMAR tratamiento aguas de lastre Chile", "DIRECTEMAR requisitos aguas servidas naves protección medio ambiente marino", "circular DIRECTEMAR medio ambiente marino DGTM".

| Hallazgo | Detalle |
|---|---|
| Página oficial dedicada | `directemar.cl/directemar/intereses-maritimos/aguas-de-lastre/aguas-lastre` — existe una sección propia de DIRECTEMAR solo para aguas de lastre, señal de que es un tema con volumen de consultas suficiente para justificar una sección dedicada del sitio de la autoridad. |
| Reglamento marco | TM-067 "Reglamento para el Control de la Contaminación Acuática" — documento paraguas que cubre aguas de lastre, aguas sucias (MARPOL Anexo IV) y descargas prohibidas en general. |
| Plantas ITA | Naves con "Instalación para el Tratamiento de Aguas" (ITA) autorizada por la Autoridad Marítima Nacional pueden descargar aguas grises a 4 millas de costa — término técnico específico chileno ("planta ITA") que no aparece en el brochure de MITSA revisado hasta ahora; vale la pena verificar con mitsa-content-writer si EVAC encaja en esta categoría regulatoria. |
| Circulares serie A-52 | Múltiples circulares (A-52/001 aguas sucias, A-52/007 biofouling) bajo el mismo prefijo — sugiere que estructurar contenido por "Circular A-52/XXX" como ancla temática podría ser un patrón de búsqueda usado por gente del rubro (ver también sección 5, mares-chile.cl ya lo hace). |

**Volumen (cualitativo)**: bajo en términos absolutos (es un nicho regulatorio muy específico de un solo país), pero **alta intención de búsqueda transaccional** — quien busca "requisitos DIRECTEMAR aguas de lastre" es casi siempre un armador, agente naviero o astillero con una obligación de cumplimiento inminente, no un curioso. Es exactamente el perfil de comprador que MITSA quiere capturar.

**Página del sitio**: aplica tanto a Productos > Aguas y sanitarios > Tratamiento de agua de lastre (BWTS) 🔴 como, si se crea, a una futura página o sección de "Normativa" / recursos de cumplimiento (no existe hoy en el sitemap — evaluar con el cliente si vale la pena una sección de biblioteca técnica regulatoria, coherente con la "biblioteca técnica / centro de descargas" ya contemplada en el alcance del proyecto según `CLAUDE.md`).

## 4. MARPOL Anexo IV (aguas sucias) y Anexo V (basuras)

**Queries usadas**: "MARPOL Anexo IV aguas sucias buques Chile normativa", "MARPOL Anexo V basuras buques protección medio ambiente marino Latinoamérica".

| Hallazgo | Detalle |
|---|---|
| Marco legal Chile | Chile es parte de MARPOL 73/78 vía D.S. (RR.EE.) N° 1.689/1994, edición refundida 2011/2022. |
| Anexo IV | Regla 10 prohíbe descargas de aguas sucias en aguas interiores; DIRECTEMAR administra vía Circular A-52/001 la autorización de servicios de recepción de aguas sucias en puertos nacionales. |
| Anexo V | Prohibición total de vertido de plásticos; regla 8 obliga a instalaciones portuarias de recepción de basuras. Este anexo es menos relevante para el catálogo de MITSA (no vende gestión de basuras como foco; el ítem "trituradores/maceradores" del sitemap está fuera del rubro core según `content/seo-keywords.md`, sección "no competir"). |

**Volumen (cualitativo)**: medio (documentos legales y de consultoría ambiental aparecen con frecuencia, pero dominan resultados internacionales/genéricos, no específicos de Chile). **Intención**: mixta — mucho contenido es informacional/legal (abogados marítimos, consultoras ambientales), no necesariamente comprador de equipos. El ángulo de MITSA aquí es indirecto: MARPOL Anexo IV justifica la necesidad de las plantas de tratamiento de aguas servidas (EVAC) que MITSA ya representa — es contexto regulatorio de respaldo para la página de "Plantas de tratamiento de aguas servidas", no necesariamente un término de página propia.

**Página del sitio**: contexto/respaldo para Productos > Aguas y sanitarios > Plantas de tratamiento de aguas servidas (ya en sitemap, sin marca 🔴/🟡 explícita — confirmar estado).

## 5. Protección catódica / ICCP y clasificadoras navales

**Queries usadas**: "protección catódica ICCP buques clasificadora DNV ABS Lloyd's Register requisito", "sistema anticorrosión ICCP naval norma casco buque", "ánodos de sacrificio protección catódica buques Chile astilleros".

| Hallazgo | Detalle |
|---|---|
| No es un tratado OMI | A diferencia de BWM/MARPOL/AFS, no encontré un convenio internacional específico que exija ICCP — es un requisito de las **sociedades clasificadoras** (DNV, ABS, Lloyd's Register, Bureau Veritas, ClassNK), que certifican los sistemas ICCP como parte de sus reglas de clase, no la OMI directamente. |
| Ángulo de venta | El argumento técnico de MITSA (Cathelco) no es "cumple con la ley" sino "cumple con los requisitos de tu sociedad clasificadora" — matiz importante para el copy: la intención de búsqueda es más cercana a mantenimiento/ingeniería naval que a compliance regulatorio puro. |
| Investigación local | Hay estudio académico chileno (bahía de Valparaíso) sobre comportamiento de ánodos de sacrificio en aluminio naval — evidencia de interés técnico local en la Región de Valparaíso, coincidente con la sede de MITSA en Reñaca/Viña del Mar. |
| Competencia | Sin presencia de IMPOMAR/EQUIMAR en estos términos (confirmado por búsqueda `site:` combinada, sin resultados de esos dominios). Sí hay actores especializados no-competidores directos del segmento de MITSA: llalco.com, cpnaval.com, esvasolutions.com (distribuidor de Cathelco en España, no Chile) — confirma que el término tiene mercado real pero MITSA puede ser el actor chileno de referencia. |

**Volumen (cualitativo)**: bajo-medio — nicho técnico B2B, pero con oferta comercial visible (varias empresas especializadas tienen páginas propias sobre ICCP), lo que indica que sí hay demanda de búsqueda sostenida, aunque de nicho. **Intención**: alta — quien busca "sistema ICCP" o "protección catódica buque" ya sabe qué necesita.

**Página del sitio**: Productos > Protección casco 🔴 > Sistemas anticorrosión / ICCP.

## 6. Antifouling / Convenio AFS / biofouling

**Queries usadas**: "Convenio AFS OMI sistemas antiincrustantes buques pintura antifouling TBT prohibición", "DIRECTEMAR circular A-52/007 limpieza subacuática casco especies exóticas invasoras".

| Hallazgo | Detalle |
|---|---|
| Convenio AFS 2001 | En vigor desde 2008. Prohíbe compuestos organoestánnicos (TBT) en pinturas antiincrustantes. Es contexto histórico/regulatorio más que un término de búsqueda transaccional de alto volumen — la mayoría de resultados son textos legales o de investigación (EUR-Lex, artículos académicos), no comerciales. |
| DIRECTEMAR Circular A-52/007 — hallazgo importante | Regula específicamente la **limpieza subacuática de casco (biofouling)** en puertos y costa de Chile, para prevenir especies exóticas invasoras. Actualizada en 2025 (vigente desde 24-jun-2025). Esta circular es un término de búsqueda real y activo: la empresa **mares-chile.cl** ya tiene páginas propias optimizadas exactamente para "Circular A-52/007" y "Limpieza Casco ROV sin Dique Seco". |
| Matiz de competencia | mares-chile.cl no es IMPOMAR ni EQUIMAR (los competidores del marco de este proyecto), pero **sí es competencia real y activa** en el término específico "Circular A-52/007" / limpieza de casco — un segmento de servicio (limpieza física) distinto del de MITSA (venta/representación de sistemas antifouling y ánodos). Vale la pena que MITSA compita en el ángulo de "sistema antiincrustante" y "ánodos de sacrificio" (producto/equipo) más que en "limpieza de casco" (servicio), donde ya hay un actor posicionado. |

**Volumen (cualitativo)**: bajo en términos absolutos, pero **la existencia de un competidor de nicho activamente optimizado para el número exacto de la circular es la señal más fuerte de intención de compra real encontrada en toda esta investigación** — confirma que hay tráfico de búsqueda suficiente para justificar una página propia. **Intención**: alta, muy transaccional (armador con obligación normativa activa desde junio 2025).

**Página del sitio**: Productos > Protección casco 🔴 > Antifouling / Ánodos de sacrificio. Recomendación: mencionar la Circular A-52/007 explícitamente en el copy de esta página (citando la norma, no el servicio de limpieza) para capturar la intención de búsqueda regulatoria sin invadir el segmento de limpieza física de mares-chile.cl.

## 7. Ósmosis inversa marina

**Query usada**: «"ósmosis inversa" agua dulce buque planta a bordo norma marina».

No se encontró un driver regulatorio específico (ni OMI ni DIRECTEMAR) que exija plantas de ósmosis inversa a bordo — es una necesidad operacional (generación de agua dulce/potable), no de cumplimiento normativo. Hay oferta comercial visible (Illante, Kysearo, Pure Aqua, Ingeniero Marino) pero son actores internacionales, no IMPOMAR/EQUIMAR ni presencia chilena dominante detectada.

**Volumen (cualitativo)**: bajo-medio, informacional/comercial mixto. **Intención**: mixta — parte informacional ("cómo funciona"), parte transaccional (comprador de flota pesquera/mercante). No es un término regulatorio como los anteriores; se mantiene en la lista de oportunidad de `seo-keywords.md` por ausencia de competencia, no por driver normativo.

**Página del sitio**: Productos > Aguas y sanitarios > Osmosis inversa.

## 8. Términos de mayor oportunidad (priorizados)

Priorización basada en: (a) existencia de driver regulatorio real y verificable, (b) ausencia de competencia de IMPOMAR/EQUIMAR, (c) ventaja técnica real de MITSA vía marca representada, (d) señal de intención transaccional encontrada en la investigación.

| # | Término | Por qué prioridad | Página |
|---|---|---|---|
| 1 | Norma D-2 / Convenio BWM / sistema de tratamiento de agua de lastre | Plazo de cumplimiento reciente (todos los BWMP desde sep-2024 deben ser D-2), fiscalización activa de DIRECTEMAR/DIRINMAR con equipos en terreno, cero competencia de IMPOMAR/EQUIMAR, MITSA representa ERMA FIRST | Aguas y sanitarios > BWTS |
| 2 | Requisitos DIRECTEMAR aguas de lastre / Plan de Gestión de Agua de Lastre (BWMP) | Autoridad local con página dedicada; intención de búsqueda muy alta (comprador ya obligado); brecha regulatoria detectada (Circular A-51/002 no cubre cabotaje) es ángulo de contenido único | Aguas y sanitarios > BWTS (+ posible sección de recursos regulatorios) |
| 3 | Circular DIRECTEMAR A-52/007 / sistema antiincrustante / ánodos de sacrificio | Evidencia directa de competencia de nicho activamente optimizada para el número exacto de la circular — señal más fuerte de intención real encontrada; MITSA puede diferenciarse compitiendo en "producto" no en "servicio de limpieza" | Protección casco > Antifouling / Ánodos de sacrificio |
| 4 | Protección catódica ICCP / certificación por sociedad clasificadora (DNV, ABS, Lloyd's, BV) | Nicho B2B de alta intención, sin competencia de IMPOMAR/EQUIMAR, MITSA representa Cathelco, ángulo técnico verificable (certificación de clase, no solo cumplimiento legal) | Protección casco > Sistemas anticorrosión / ICCP |
| 5 | Planta ITA (Instalación para el Tratamiento de Aguas) DIRECTEMAR | Término técnico-regulatorio chileno específico, sin presencia de competencia detectada; requiere validar con brochure/cliente si EVAC encaja exactamente en esta categoría antes de usarlo en metadatos | Aguas y sanitarios > Plantas de tratamiento de aguas servidas |
| 6 | MARPOL Anexo IV Chile (aguas sucias) — como contexto de respaldo, no como keyword de página propia | Refuerza autoridad/E-E-A-T de la página de tratamiento de aguas servidas citando la norma que la origina; volumen bajo pero legitima el contenido | Aguas y sanitarios > Plantas de tratamiento de aguas servidas |
| 7 | Convenio AFS OMI / TBT (como contexto histórico-normativo, no keyword principal) | Útil para un párrafo de contexto/FAQ en la página de antifouling ("por qué existe esta categoría de producto"), no para title/H1 por ser de bajo volumen transaccional | Protección casco > Antifouling |

## 9. Advertencias y pendientes

- **No inventar cifras**: ninguna cifra de volumen de búsqueda mensual, CPC o dificultad de keyword aparece en este documento porque no se usó ninguna herramienta de keyword research real. Las etiquetas alto/medio/bajo son cualitativas y deben tratarse como hipótesis de priorización, no como dato duro.
- **Circular A-51/002 (recambio de agua de lastre, excluye cabotaje)**: la afirmación sobre esta circular proviene de un artículo académico citado en resultados de búsqueda, no del texto oficial de DIRECTEMAR (no se pudo acceder directamente al PDF de esa circular específica). Antes de publicar esta afirmación en el sitio, verificar contra el texto oficial en `directemar.cl`.
- **"Planta ITA"**: término encontrado en el reglamento TM-067 de DIRECTEMAR; no se verificó si corresponde exactamente a lo que EVAC/MITSA ofrece — coordinar con mitsa-content-writer y con el brochure antes de usarlo como keyword de página.
- **mares-chile.cl**: identificado como competidor de nicho en el término específico "Circular A-52/007" / limpieza de casco. No estaba en el análisis competitivo original (`seo-keywords.md`, que solo compara contra IMPOMAR/EQUIMAR) — no se recomienda expandir el marco competitivo del proyecto sin decisión del cliente/Juan, pero sí registrar el hallazgo para no chocar de frente con ese actor en el ángulo de "servicio de limpieza" en vez de "producto antifouling".
- **Sección de "biblioteca técnica" / recursos regulatorios**: el alcance del proyecto (`CLAUDE.md`) ya contempla una biblioteca técnica de fichas/catálogos/certificados. Esta investigación sugiere que un recurso tipo "guía de cumplimiento DIRECTEMAR/OMI" (FAQ o página de contexto regulatorio) podría capturar búsquedas informacionales de alta intención antes de la compra — es una idea nueva, no confirmada con el cliente, que debería proponerse como opción, no construirse directamente.
