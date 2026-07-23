---
name: mitsa-content-optimizer
description: Audita, investiga y reescribe contenido técnico de MITSA para que sea útil, natural, verificable y apto para SEO, GEO y AEO. Usar al crear o editar artículos, páginas de servicio, fichas de producto y contenidos regulatorios de mitsachile.com; al pedir un humanizador; o antes de pasar un borrador de WordPress a revisión o publicación.
---

# Optimización de contenido MITSA

Convertir cada página en la mejor respuesta disponible para una necesidad real del mercado naval chileno. No prometer rankings, no escribir para detectores de IA y no fingir experiencia de primera mano.

## Flujo obligatorio

1. Leer el borrador, `content/seo-keywords.md`, `docs/DECISIONS.md` y las páginas de producto o marca relacionadas.
2. Definir una sola intención primaria por URL: informativa, regulatoria, comparativa, navegacional o transaccional. Detectar solapamientos con otras URLs antes de reescribir.
3. Investigar la SERP actual y la normativa vigente. Priorizar fuentes primarias: OMI, DIRECTEMAR, fabricante, sociedad clasificadora y documentación validada por MITSA. Leer `references/evidence-basis.md` para las reglas que no deben negociarse.
4. Crear un registro mental de afirmaciones: fuente, fecha, alcance y nivel de certeza. Eliminar o marcar para validación toda afirmación comercial que no tenga respaldo.
5. Aportar valor no intercambiable: un criterio de selección, una matriz de decisión, un error frecuente, una secuencia de inspección o una consecuencia operacional. No resumir solamente fuentes externas.
6. Redactar la respuesta principal al comienzo. Usar encabezados descriptivos, lenguaje técnico claro, tablas solo cuando ayuden a decidir y preguntas frecuentes que respondan dudas reales.
7. Vincular el artículo con una página comercial pertinente mediante un CTA sobrio. No presentar a MITSA como instalador, certificador, representante o proveedor de un modelo sin confirmación documental.
8. Ejecutar una pasada de `article-writing` y luego `humanizer` en modo embebido o archivo, si esas habilidades están disponibles. Conservar datos, citas, enlaces, metadatos y advertencias. Variar el ritmo sin introducir anécdotas, opiniones o experiencia inventada.
9. Ejecutar `python3 scripts/audit_content.py <archivo...>` usando la ruta del directorio base de esta skill (el runtime la informa al invocarla) y corregir los bloqueos.
10. Mantener el contenido nuevo como borrador. Publicar solo con aprobación explícita del cliente o del usuario y con los gates editoriales completos.

## Jerarquía de evidencia

- Nivel A: normativa oficial, documento del fabricante, sociedad clasificadora o dato entregado y validado por MITSA. Puede sostener una afirmación factual.
- Nivel B: brochure o sitio vigente de MITSA, siempre respetando sus notas de validación. Puede sostener lo que el documento dice, no inferencias comerciales adicionales.
- Nivel C: competidores, snippets, artículos secundarios y borradores de agencia. Sirven para descubrir preguntas o contrastar enfoques; no prueban capacidades de MITSA.

Cuando dos fuentes discrepen, usar la más autoritativa y reciente, explicar el alcance y dejar trazabilidad. No actualizar una fecha para simular frescura.

## Reglas de escritura

- Escribir para armadores, astilleros, responsables técnicos, mantenimiento y cumplimiento, no para un público abstracto.
- Abrir con la decisión o consecuencia concreta, no con historia general ni una definición escolar.
- Preferir verbos y sujetos claros. Eliminar grandilocuencia, superlativos, transiciones genéricas, grupos forzados de tres y conclusiones optimistas vacías.
- Usar la keyword en title, H1 y texto solo cuando sea natural. No usar densidad objetivo ni repetir variaciones para cubrir todas las consultas.
- Citar fuentes junto a las afirmaciones que sustentan. Una lista final no corrige un párrafo ambiguo o sin respaldo.
- No inventar citas de expertos, clientes, casos, años de experiencia, cobertura, disponibilidad, certificaciones, tiempos de respuesta ni soporte local.
- No afirmar que el texto es humano o que supera detectores. La calidad se demuestra con utilidad, evidencia y revisión experta.
- No convertir cada pregunta relacionada en una URL. Consolidar intenciones cercanas para evitar contenido escalado y canibalización.

## Gates editoriales

Un borrador puede pasar a revisión cuando:

- la intención y el lector están claros;
- las afirmaciones regulatorias y técnicas tienen fuentes primarias;
- contiene un aporte propio verificable o una solicitud concreta para obtenerlo;
- diferencia requisitos vigentes, recomendaciones y propuestas futuras;
- incluye title SEO, meta description, slug y enlaces internos propuestos;
- el auditor no reporta bloqueos estructurales.

No recomendar publicación hasta contar con:

- nombre y perfil del autor o revisor técnico real;
- validación de las capacidades, marcas y modelos mencionados;
- imágenes propias o autorizadas con contexto y texto alternativo;
- fecha de publicación y actualización honestas;
- `Article` o `BlogPosting`, canonical, sitemap y página indexable verificados;
- revisión humana final del cliente.

## Medición

Medir por URL e intención: indexación, consultas e impresiones en Search Console; clics y conversiones; enlaces y menciones; citas en Bing AI Performance u otras plataformas cuando exista acceso. Comparar contra una línea base y revisar trimestralmente. Un artículo no garantiza primeros lugares: el contenido es una parte de autoridad, técnica, enlaces, experiencia de página y reconocimiento de entidad.
