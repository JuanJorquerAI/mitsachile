---
name: mitsa-content-optimizer
description: Audita, investiga y reescribe contenido tecnico de MITSA para que sea util, natural, verificable y apto para SEO, GEO y AEO. Usar al crear o editar articulos, paginas de servicio, fichas de producto y contenidos regulatorios de mitsachile.com; al pedir un humanizador; o antes de pasar un borrador de WordPress a revision o publicacion.
---

# Optimizacion de contenido MITSA

Convertir cada pagina en la mejor respuesta disponible para una necesidad real del mercado naval chileno. No prometer rankings, no escribir para detectores de IA y no fingir experiencia de primera mano.

## Flujo obligatorio

1. Leer el borrador, `content/seo-keywords.md`, `docs/DECISIONS.md` y las paginas de producto o marca relacionadas.
2. Definir una sola intencion primaria por URL: informativa, regulatoria, comparativa, navegacional o transaccional. Detectar solapamientos con otras URLs antes de reescribir.
3. Investigar la SERP actual y la normativa vigente. Priorizar fuentes primarias: OMI, DIRECTEMAR, fabricante, sociedad clasificadora y documentacion validada por MITSA. Leer `references/evidence-basis.md` para las reglas que no deben negociarse.
4. Crear un registro mental de afirmaciones: fuente, fecha, alcance y nivel de certeza. Eliminar o marcar para validacion toda afirmacion comercial que no tenga respaldo.
5. Aportar valor no intercambiable: un criterio de seleccion, una matriz de decision, un error frecuente, una secuencia de inspeccion o una consecuencia operacional. No resumir solamente fuentes externas.
6. Redactar la respuesta principal al comienzo. Usar encabezados descriptivos, lenguaje tecnico claro, tablas solo cuando ayuden a decidir y preguntas frecuentes que respondan dudas reales.
7. Vincular el articulo con una pagina comercial pertinente mediante un CTA sobrio. No presentar a MITSA como instalador, certificador, representante o proveedor de un modelo sin confirmacion documental.
8. Ejecutar una pasada de `article-writing` y luego `humanizer` en modo embebido o archivo, si esas habilidades estan disponibles. Conservar datos, citas, enlaces, metadatos y advertencias. Variar el ritmo sin introducir anecdotas, opiniones o experiencia inventada.
9. Ejecutar `python3 .agents/skills/mitsa-content-optimizer/scripts/audit_content.py <archivo...>` y corregir los bloqueos.
10. Mantener el contenido nuevo como borrador. Publicar solo con aprobacion explicita del cliente o del usuario y con los gates editoriales completos.

## Jerarquia de evidencia

- Nivel A: normativa oficial, documento del fabricante, sociedad clasificadora o dato entregado y validado por MITSA. Puede sostener una afirmacion factual.
- Nivel B: brochure o sitio vigente de MITSA, siempre respetando sus notas de validacion. Puede sostener lo que el documento dice, no inferencias comerciales adicionales.
- Nivel C: competidores, snippets, articulos secundarios y borradores de agencia. Sirven para descubrir preguntas o contrastar enfoques; no prueban capacidades de MITSA.

Cuando dos fuentes discrepen, usar la mas autoritativa y reciente, explicar el alcance y dejar trazabilidad. No actualizar una fecha para simular frescura.

## Reglas de escritura

- Escribir para armadores, astilleros, responsables tecnicos, mantenimiento y cumplimiento, no para un publico abstracto.
- Abrir con la decision o consecuencia concreta, no con historia general ni una definicion escolar.
- Preferir verbos y sujetos claros. Eliminar grandilocuencia, superlativos, transiciones genericas, grupos forzados de tres y conclusiones optimistas vacias.
- Usar la keyword en title, H1 y texto solo cuando sea natural. No usar densidad objetivo ni repetir variaciones para cubrir todas las consultas.
- Citar fuentes junto a las afirmaciones que sustentan. Una lista final no corrige un parrafo ambiguo o sin respaldo.
- No inventar citas de expertos, clientes, casos, anos de experiencia, cobertura, disponibilidad, certificaciones, tiempos de respuesta ni soporte local.
- No afirmar que el texto es humano o que supera detectores. La calidad se demuestra con utilidad, evidencia y revision experta.
- No convertir cada pregunta relacionada en una URL. Consolidar intenciones cercanas para evitar contenido escalado y canibalizacion.

## Gates editoriales

Un borrador puede pasar a revision cuando:

- la intencion y el lector estan claros;
- las afirmaciones regulatorias y tecnicas tienen fuentes primarias;
- contiene un aporte propio verificable o una solicitud concreta para obtenerlo;
- diferencia requisitos vigentes, recomendaciones y propuestas futuras;
- incluye title SEO, meta description, slug y enlaces internos propuestos;
- el auditor no reporta bloqueos estructurales.

No recomendar publicacion hasta contar con:

- nombre y perfil del autor o revisor tecnico real;
- validacion de las capacidades, marcas y modelos mencionados;
- imagenes propias o autorizadas con contexto y texto alternativo;
- fecha de publicacion y actualizacion honestas;
- `Article` o `BlogPosting`, canonical, sitemap y pagina indexable verificados;
- revision humana final del cliente.

## Medicion

Medir por URL e intencion: indexacion, consultas e impresiones en Search Console; clics y conversiones; enlaces y menciones; citas en Bing AI Performance u otras plataformas cuando exista acceso. Comparar contra una linea base y revisar trimestralmente. Un articulo no garantiza primeros lugares: el contenido es una parte de autoridad, tecnica, enlaces, experiencia de pagina y reconocimiento de entidad.
