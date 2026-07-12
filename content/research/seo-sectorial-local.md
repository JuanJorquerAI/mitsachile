# Investigación SEO sectorial y local — mitsachile.com

🟡 **Investigación de apoyo, no fuente de verdad.** La fuente de verdad de la estrategia de keywords sigue siendo `content/seo-keywords.md` (análisis competitivo MITSA vs. IMPOMAR/EQUIMAR). Este documento complementa esa estrategia con tres ejes que el análisis original no cubría: normativa ambiental sectorial (salmonicultura/minería), evaluación de sobre-extensión hacia minería, y SEO local por ciudad portuaria. No reemplaza ni reordena las prioridades ya fijadas en `seo-keywords.md` — donde hay tensión con esa priorización, se señala explícitamente.

**Dependencia abierta:** la sección Sectores del sitio sigue en 🟡 borrador, pendiente de validación con el cliente (`content/05-sectores.md`, `docs/DECISIONS.md` #1). Las recomendaciones de este documento sobre qué sector merece página propia asumen que esos 7 sectores se mantienen, pero cualquier página nueva de sector/ciudad debe esperar esa validación antes de publicarse.

**Nota metodológica:** toda la evidencia aquí viene de búsquedas web (julio 2026), no de herramientas de keyword research ni de Google Search Console (el sitio aún no está en producción). No hay cifras de volumen de búsqueda, dificultad de keyword ni tráfico estimado — donde no hay dato real, se dice explícitamente "sin dato" en vez de estimar un número. Esto es una evaluación cualitativa de intención de búsqueda y panorama competitivo, pensada para informar prioridades, no para sustituir un keyword research cuantitativo posterior (recomendado como siguiente fase, igual que señala `seo-keywords.md` §6).

---

## 1. Resumen del hallazgo central

El eje "oportunidad sin competencia directa" de `seo-keywords.md` se sostiene y se refuerza con esta investigación en el caso de **BWTS** (hay presión regulatoria internacional real y creciente — ver §2). Pero aparece una advertencia importante: al extender el catálogo de MITSA hacia **minería** (bombas, tratamiento de aguas, protección catódica), el mercado deja de ser "sin competencia" y pasa a ser un mercado terrestre/industrial ya ocupado por especialistas dedicados (CathPro, Corrotek, ONIX en protección catódica; Synertech, Ecopreneur, SGS, EBI en tratamiento de aguas; PGIC, ProMinent, Xylem, KSB en bombeo minero). Esto no invalida mencionar minería como sector — MITSA sí tiene producto real ahí (ver `content/05-sectores.md`) — pero SEO-atacar minería con los mismos términos "sin competencia" que funcionan en el nicho marino sería una lectura incorrecta del panorama competitivo: en marino MITSA es first-mover, en minería es un jugador más entrando a un mercado consolidado.

En SEO local, el hallazgo más relevante es que **EQUIMAR (competidor directo) ya tiene sucursales físicas en Iquique y Talcahuano**, además de la red de agentes marítimos (Marval, Chile Ships Services) presente en prácticamente todos los puertos del litoral (Arica, Iquique, Mejillones, Antofagasta, Coquimbo, San Antonio, Valparaíso, Talcahuano). MITSA, en cambio, no tiene evidencia documental de sucursales fuera de Reñaca/Viña del Mar. Esto cambia la recomendación: páginas locales por ciudad sin presencia física real detrás corren riesgo de leer como contenido inflado (contradice la regla del proyecto de no forzar contenido delgado).

---

## 2. Salmonicultura / acuícola Chile

### Marco normativo confirmado

| Norma / organismo | Rol | Relevancia para MITSA |
|---|---|---|
| RAMA — Reglamento Ambiental para la Acuicultura (D.S. N°320/2001, Ministerio de Economía) | Regula protección ambiental en concesiones acuícolas; exige sistemas de tratamiento para mortalidad, monitoreo de fondo marino | Marco que sustenta la necesidad de tratamiento de aguas/efluentes en centros de cultivo — contexto, no keyword en sí |
| SERNAPESCA | Agencia técnica sectorial; fiscaliza RAMA, exige planes de acción reforzados desde modificación reciente al reglamento | Autoridad de referencia citable en contenido de la sección salmonicultura, no un término de búsqueda |
| SMA (Superintendencia del Medio Ambiente) | Fiscalización y sanción ambiental; describe la salmonicultura como sector bajo creciente "compliance ambiental" | Refuerza el argumento de negocio (más exigencia regulatoria → más demanda de equipos de tratamiento), útil como contexto editorial |
| NCh 2.313/2006 "Aguas Residuales — Métodos de Análisis" y D.S. 90/2000 art. 6.5 | Estándares técnicos de descarga | Dato técnico citable en fichas o página de sector, no keyword de alto tráfico esperable |

### Evaluación de intención de búsqueda

- Hay bastante contenido informativo/legal indexado sobre RAMA y normativa ambiental salmonera (portales de gobierno, ONGs como Terram, medios especializados como Mongabay/aqua.cl/infosalmon.cl) — es un tema con audiencia real, pero esa audiencia busca información regulatoria y de compliance, no necesariamente "comprar equipo de tratamiento de agua". Son búsquedas de researchers, abogados ambientales y gerentes de compliance, un público adyacente al comprador técnico de MITSA.
- Para "separador agua-aceite plantas pesqueras" sí hay competidores directos activos y posicionados: Aguamarket, Synertech, FibraNov (fibra.cl) ya tienen páginas de producto específicas para este término. No es un término "sin competencia" como BWTS — es un término donde MITSA competiría con proveedores de tratamiento de aguas generalistas, no con IMPOMAR/EQUIMAR.
- Sin datos de volumen de búsqueda real para ninguno de estos términos.

### Recomendación

Sí justifica una **mención sólida dentro de la página de sector Pesquero-acuícola** (ya contemplada en `content/05-sectores.md`), citando RAMA/SERNAPESCA/SMA como contexto regulatorio que valida por qué MITSA es relevante ahí — esto además cumple con la regla del proyecto de no inventar contenido de relleno, porque son datos verificables. No amerita páginas nuevas de producto por este hallazgo: los productos que resuelven esto (separadores agua-aceite, tratamiento de aguas) ya están cubiertos por la categoría "Aguas y sanitarios" del sitemap. "Separador agua-aceite" puede quedar como término long-tail secundario dentro de esa categoría, tal como ya lo señala `seo-keywords.md` §3/§5 — este hallazgo lo confirma, no lo cambia.

---

## 3. Minería Chile

### Panorama competitivo (evaluación de sobre-extensión)

| Término | Competidores activos encontrados | Lectura |
|---|---|---|
| Tratamiento de aguas industriales minería | Synertech, Ecopreneur (350 proyectos en Chile/Perú/Colombia), Air Liquide, Grupo EBI, SGS, Hydro Solution | Mercado maduro y consolidado, con jugadores de escala regional. Competir de frente en este término genérico sería replicar el mismo error que IMPOMAR "gana" en el mercado marino: MITSA entraría como jugador chico contra especialistas dedicados. |
| Bombas industriales minería | PGIC (30+ años, especializado en bombas de pulpa minera), ProMinent, Xylem, KSB, IndusCo/Cornell Pump, Fluintek | Igual de consolidado. MITSA representa Herborner/SIHI/Moyno (ver `content/04-representadas.md`) pero esas marcas no tienen el mismo peso de marca en minería que en el nicho marino. |
| Protección catódica / anticorrosión industria minera | CathPro (desde 2012, especializado en minería y sectores críticos), Corrotek (40+ años, "líder en Latinoamérica"), ONIX (minería y portuaria) | Este es el hallazgo más importante: la protección catódica es uno de los 5 términos de "oportunidad máxima" de `seo-keywords.md`, pero **esa oportunidad existe específicamente en el nicho naval (protección de casco/ICCP a bordo)**. En tierra, para tuberías e infraestructura minera, ya hay especialistas consolidados y reconocidos. Usar "protección catódica" como keyword genérico sin anclarlo a "naval"/"buques"/"casco" haría que MITSA compita sin ventaja contra CathPro/Corrotek/ONIX en vez de dominar el nicho sin competencia que sí tiene. |

### Recomendación

Minería es un **sector real del catálogo** (`content/05-sectores.md` ya lo incluye con bombas y tratamiento de agua) y merece la mención que ya tiene en esa página — pero no debería llevar los mismos términos de "prioridad máxima sin competencia" de `seo-keywords.md`. Recomendación concreta: en cualquier metadato o encabezado para contenido de minería, mantener el calificador naval/marino explícito (ej. "protección catódica de casco para buques" en vez de "protección catódica industrial" a secas) para no diluir la ventaja competitiva real de MITSA compitiendo en un término donde ya hay tres actores especializados y establecidos. Esto no es una keyword nueva a agregar a la lista de prioridad — es una advertencia de alcance para cuando se redacte contenido de sector Minero o Industrial.

---

## 4. SEO local por ciudades portuarias

### Hallazgos por ciudad

| Ciudad | Presencia de competidores/actores relevantes | Evidencia de MITSA en la zona |
|---|---|---|
| Valparaíso / Viña del Mar / Reñaca | Marval (agente marítimo con red nacional), ASMAR Valparaíso (uno de sus 3 astilleros principales) | Sede real de MITSA — esta es la única ciudad con presencia física confirmada |
| San Antonio | Rectificaciones/talleres navales locales (30+ años), Marval, Chile Ships Services | Sin evidencia de presencia local de MITSA |
| Iquique | **EQUIMAR tiene sucursal propia** (`iquique@equimar.cl`), Finning (motores marinos/mineros), Marval | Sin evidencia de presencia local de MITSA — competidor directo ya está instalado ahí |
| Antofagasta / Mejillones | Marval, Chile Ships Services, SERVMARMG, Fucer Ingeniería (bombas) | Sin evidencia de presencia local de MITSA |
| Coquimbo | Puerto Coquimbo/TPC (terminal), Marval, SERVMARMG | Sin evidencia de presencia local de MITSA |
| Talcahuano / Concepción | **EQUIMAR tiene sucursal propia**, ASMAR Talcahuano (astillero principal, base de la Armada), Maestranza Maranta | Sin evidencia de presencia local de MITSA — competidor directo ya está instalado ahí |
| Puerto Montt | Maestranza Maranta (40+ años en mantención de naves), Oxxean, Astecmar | Sin evidencia de presencia local de MITSA |
| Punta Arenas | ASMAR Punta Arenas (tercer astillero principal de ASMAR), SAAM, agentes navieros | Sin evidencia de presencia local de MITSA |

### Evaluación: ¿página por ciudad o página nacional única?

No hay evidencia de que exista intención de búsqueda local diferenciada y de alto valor tipo "repuestos marinos Iquique" — lo que aparece en esas búsquedas son directorios de empresas y páginas de agentes marítimos generalistas (Marval, Chile Ships Services) que cubren *todos* los puertos desde una sola web, no páginas dedicadas por ciudad. Es decir: **ni siquiera los actores con presencia física real en cada puerto están construyendo páginas SEO por ciudad** — resuelven la cobertura nacional con una sola página de "cobertura" o "sucursales" y listos.

Combinado con que MITSA no tiene sucursales fuera de Reñaca (a diferencia de EQUIMAR, que sí las tiene en Iquique y Talcahuano), construir 7-8 páginas locales por ciudad sin base física real detrás:

1. Contradice la regla del proyecto de no forzar contenido delgado para tener dónde poner keywords.
2. Sería contenido duplicado/plantilla que Google normalmente no premia sin señales reales de negocio local (NAP, reseñas, Google Business Profile por sede) — y MITSA no tiene esas señales fuera de Reñaca.
3. El propio panorama competitivo muestra que la cobertura de servicio nacional se comunica con una página de alcance/cobertura, no con SEO local por ciudad.

### Recomendación

**No construir páginas SEO dedicadas por ciudad.** En su lugar:
- Una sola sección "Cobertura" o "Dónde operamos" (puede vivir dentro de Nosotros, Servicios o Contacto — sección aún 🟡 sin validar, ver `docs/DECISIONS.md` #1) que liste el litoral que MITSA atiende, mencionando de forma natural los puertos/ciudades clave (Valparaíso, San Antonio, Iquique, Antofagasta, Coquimbo, Talcahuano, Puerto Montt, Punta Arenas) para capturar variantes long-tail sin crear 8 páginas delgadas.
- Schema `LocalBusiness` con la sede real de Reñaca/Viña del Mar y un `areaServed` que declare el alcance nacional — esto es más honesto y más efectivo en SEO local que páginas ciudad por ciudad sin sustento.
- Si en el futuro MITSA abre una sucursal física o firma un representante técnico local en algún puerto (p. ej. si igualara la jugada de EQUIMAR en Iquique/Talcahuano), ahí sí se justifica una página local dedicada con NAP propio — no antes.

---

## 5. Industrial / Comercial / Residencial

Confirmación breve, sin sorpresas respecto a lo ya asumido en el proyecto:

- **Ósmosis inversa industrial**: mercado de proveedores genéricos muy poblado (Avalco, Texpro, Aquacenter, Global Vital, Simtech, Soecol, Synertech) orientado a laboratorios, embotelladoras, farmacéutica — no es un nicho de MITSA, es un mercado de commodity técnico. La variante "**ósmosis inversa marina**" (a bordo de buques) sigue siendo el término de oportunidad real ya identificado en `seo-keywords.md` §4 — este hallazgo confirma que diferenciar el calificador "marina" es lo que evita caer en ese mercado saturado.
- **Plantas de tratamiento de aguas servidas comercial/residencial**: hay marco normativo claro (SISS, NCh 1333, D.S. 90/2000, D.S. 46/2002, D.S. 609/1998) pero también proveedores locales establecidos (Inprotratamientos y similares) atendiendo ese mercado día a día. Es un sector real para MITSA vía la línea terrestre de Evac (ver `content/05-sectores.md`, sectores Comercial/Residencial) pero de menor prioridad SEO — confirma la lectura ya asumida en el proyecto.

**Recomendación**: mantener Industrial, Comercial y Residencial como páginas de sector con mención de producto (ya contempladas en el sitemap vía Sectores), sin inversión SEO adicional prioritaria más allá de eso. No ameritan investigación de keyword propia en esta fase.

---

## 6. Aviación

La búsqueda no encontró evidencia de demanda de búsqueda en español para "sistemas sanitarios aviación Chile" ni variantes cercanas — los resultados devueltos fueron sobre ambulancias aéreas, seguridad aeroportuaria (DGAC/AVSEC) y certificación de edificios aeroportuarios sustentables, nada relacionado con equipos sanitarios de aeronaves.

En inglés, el mercado de "aircraft lavatory servicing" / "vacuum toilet aircraft" sí existe como categoría técnica reconocida (sistemas de vacío similares en principio a los sistemas marinos que MITSA representa), pero es una cadena de suministro distinta: vehículos de servicio en tierra ("honey wagons"), fabricantes de equipos de soporte en tierra (GSE) especializados en aeropuertos — no encontré evidencia de que las marcas que representa MITSA (Evac y similares, ver `content/04-representadas.md`) participen en ese mercado específico de aviación en Chile.

Esto confirma la lectura que ya tenía `content/05-sectores.md`: aviación es el sector con menos evidencia documental y, ahora también, el de menor intención de búsqueda detectable. No hay base para invertir en SEO de aviación en esta etapa.

**Recomendación**: mantener aviación como mención histórica/de posicionamiento (ya redactado así en `content/05-sectores.md`: "empresa pionera... segmento sanitario para uso marino, aviación, pesquero...") sin página ni metadatos dedicados. Si el cliente confirma en el documento maestro pendiente (`docs/DECISIONS.md` #1) que existe producto real para aviación, se reevalúa — hasta entonces, no justifica inversión SEO.

---

## 7. Priorización recomendada (síntesis)

| Prioridad | Sector / eje | Acción SEO |
|---|---|---|
| 1 | Marino/naval — BWTS, ICCP naval, antifouling, ósmosis inversa marina | Ya cubierto como prioridad máxima en `seo-keywords.md` — este documento no cambia esa prioridad, la reafirma con evidencia de presión regulatoria IMO/MEPC creciente sobre BWTS |
| 2 | Pesquero-acuícola | Mención sólida con contexto regulatorio verificable (RAMA/SERNAPESCA/SMA) dentro de la página de sector; términos de producto (separador agua-aceite) quedan como long-tail secundario dentro de Aguas y sanitarios, sin página propia |
| 3 | Cobertura nacional / litoral (en vez de SEO local por ciudad) | Una sección de cobertura con `LocalBusiness` + `areaServed`, no 8 páginas de ciudad — evita contenido delgado y refleja que ni los competidores con sucursales reales (EQUIMAR) hacen SEO por ciudad |
| 4 | Minero / Industrial | Mención de sector sin términos "sin competencia" — en minería esos términos genéricos (protección catódica, tratamiento de aguas, bombas) ya tienen especialistas consolidados; mantener calificador naval/marino en cualquier contenido compartido |
| 5 | Comercial / Residencial | Mención de sector únicamente, sin inversión SEO adicional |
| 6 | Aviación | Mención histórica de posicionamiento, sin página ni metadatos — sector más débil en evidencia documental y en intención de búsqueda detectada |

---

## Fuentes consultadas

- SMA — portal.sma.gob.cl, snifa.sma.gob.cl
- SERNAPESCA — sernapesca.cl (RAMA, fiscalización)
- Terram, Mongabay, aqua.cl, infosalmon.cl (contexto regulatorio salmonicultura)
- OMI/IMO — imo.org (Convenio BWM, resolución MEPC.123/53)
- SYM Naval, Alfa Laval, LLALCO (contexto BWTS)
- Synertech, Ecopreneur, SGS Chile, Grupo EBI, Air Liquide, Hydro Solution (tratamiento de aguas minería)
- PGIC, ProMinent, Xylem, KSB, IndusCo, Fluintek, Insumin (bombas minería)
- CathPro, Corrotek, ONIX (protección catódica Chile)
- Marval, Chile Ships Services, SERVMARMG, ASMAR, EQUIMAR, Maestranza Maranta (cobertura portuaria y presencia de competidores por ciudad)
- SISS (siss.gob.cl), BCN/LeyChile (normativa tratamiento aguas servidas)
- DGAC Chile, AeroExpo, AviationLearnings, SofemaOnline (evaluación sector aviación)

Búsquedas realizadas vía WebSearch, julio 2026. No incluye datos de Google Keyword Planner, Search Console, SEMrush ni herramientas similares — recomendado como siguiente fase una vez el sitio esté en producción y se pueda cruzar con datos reales de Search Console.
