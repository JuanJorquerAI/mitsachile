# Plan de Ejecución con SPECs: Posicionamiento SEO & Lead Generation (mitsa.org)

> **Estado:** En ejecución  
> **Fecha:** 2026-10-21  
> **Cliente:** MITSA SpA (`mitsa.org`)  
> **Agencia:** AplicacionesWeb  
> **Objetivo:** Transformar `mitsa.org` en un motor de captación de leads B2B calificados mediante liderazgo en compliance regulatorio naval, especificación de sistemas mayores y abastecimiento ágil de repuestos.

---

## Índice de SPECs

| SPEC ID | Título | Alcance | Estado |
| :--- | :--- | :--- | :---: |
| **SPEC-SEO-01** | Optimización On-Page, Metadatos B2B y Schema.org | 12 Soluciones + 6 Industrias + Portada | **En Progreso** |
| **SPEC-SEO-02** | Activación y Enlace Interno del Clúster Regulatorio | 5 Artículos técnicos en Centro Técnico | **Staged (Drafts)** |
| **SPEC-SEO-03** | Arquitectura de Conversión & Lead Magnets B2B | Formularios Proyectos vs Repuestos + WhatsApp | **Por Ejecutar** |
| **SPEC-SEO-04** | Solución Ósmosis Inversa Marina & Marcas Representadas | Post 53 + Fichas Representadas | **Por Ejecutar** |
| **SPEC-SEO-05** | Medición de Conversiones B2B en GA4 & Reportabilidad | Eventos de Lead + Dashboard de Rankings | **Por Ejecutar** |

---

## SPEC-SEO-01: Optimización On-Page, Metadatos B2B y Schema.org

### 1. Problem Statement
Los metadatos actuales en `mitsa.org` son descriptivos pero carecen de intención de búsqueda transaccional/comercial. Los títulos no contienen los términos que digitan los inspectores de naves, astilleros ni jefes de flota (`norma D-2`, `Erma First`, `ICCP naval`, `sistemas de vacío para buques`). Además, falta marcado estructurado Schema.org específico para `Service` y `Product`.

### 2. User Stories
* **US-01.1:** *Como Superintendente Técnico*, quiero buscar en Google *"sistemas BWTS norma D-2 Chile"* y encontrar en los primeros resultados la solución de MITSA con indicación clara de certificación OMI/DIRECTEMAR para solicitar cotización antes de la recalada.
* **US-01.2:** *Como Proyectista de Astillero*, quiero ver snippets claros en las SERPs que mencionen tecnologías específicas (ICCP, ICAF, vacío) y soporte técnico en Chile.

### 3. Implementation Decisions
* **T01.1:** Aplicar a través de WP-CLI en producción los `_yoast_wpseo_title`, `_yoast_wpseo_metadesc` y `_yoast_wpseo_focuskw` optimizados para cada solución e industria.
* **T01.2:** Implementar Schema.org JSON-LD tipado para `Service` y `Product` con proveedor corporativo (`MITSA SpA`), área de servicio (`CL` y `LatAm`) y enlace directo al formulario de cotización.

---

## SPEC-SEO-02: Activación y Enlace Interno del Clúster Regulatorio

### 1. Problem Statement
MITSA cuenta con 5 artículos técnicos regulatorios de altísimo valor que ya fueron preparados y subidos como borradores (IDs 143, 67, 66, 65, 64), pero requieren la vinculación semántica cruzada con sus respectivas soluciones comerciales antes de pasar al hito de validación con el cliente.

### 2. User Stories
* **US-02.1:** *Como Jefe de Mantenimiento de Flota*, quiero leer un artículo sobre *"qué revisar antes de operar un BWTS bajo norma D-2"* y encontrar un llamado directo para contactar a MITSA por suministro del sistema Erma First o calibración de sensores.
* **US-02.2:** *Como Inspector Marítimo*, quiero consultar la normativa de la *Circular A-52/007* y acceder inmediatamente a la solución de sistemas antiincrustantes ICAF y protección ICCP.

### 3. Implementation Decisions
* **T02.1:** Asegurar que cada artículo en borrador contenga un módulo de cierre ("Soporte y Soluciones Relacionadas") con enlace interno hacia las soluciones comerciales correspondientes (`agua-de-lastre-bwts`, `proteccion-catodica-iccp`, `bioincrustaciones-icaf`, `tratamiento-de-aguas-residuales`).
* **T02.2:** Preparar el paquete de revisión para el cliente respetando la regla invariante de no publicar sin su visto bueno.

---

## SPEC-SEO-03: Arquitectura de Conversión & Lead Magnets B2B

### 1. Problem Statement
Actualmente las páginas de solución no cuentan con un mecanismo claro de captura de leads diferenciado por intención de compra. Una empresa que requiere un proyecto mayor de dique necesita entregar datos técnicos de la nave, mientras que un jefe de máquinas que necesita un repuesto urgente requiere subir una foto o número de parte.

### 2. User Stories
* **US-03.1:** *Como Armador*, quiero solicitar cotización de un sistema mayor indicando tipo de nave, caudal ($m^3/h$) y astillero para recibir una propuesta formal de ingeniería.
* **US-03.2:** *Como Encargado de Compras MRO*, quiero solicitar repuestos de bombas Herborner o sellos Evac adjuntando una foto de la placa de identificación o el P/N para cotización inmediata.
* **US-03.3:** *Como Usuario Móvil en Puerto*, quiero hacer clic en un botón de WhatsApp que abra una conversación con un mensaje precargado con la solución técnica que estoy viendo.

### 3. Implementation Decisions
* **T03.1:** Diseñar dos formularios en Contact Form 7:
  - Formulario A: *Cotización de Proyectos & Sistemas*.
  - Formulario B: *Abastecimiento Rápido de Repuestos y Servicio MRO*.
* **T03.2:** Integrar botón flotante de WhatsApp contextual por página técnica (`https://wa.me/569...`).

---

## SPEC-SEO-04: Solución Ósmosis Inversa Marina & Directorio de Marcas

### 1. Problem Statement
El post ID 53 (`Generación de agua dulce / Ósmosis Inversa`) se encuentra actualmente en borrador inactivo. La investigación reveló que Ancora Chile (Norwater) compite activamente en este segmento, por lo que MITSA debe presentar su oferta diferenciada para el sector marítimo y wellboats.

### 2. User Stories
* **US-04.1:** *Como Operador de Wellboat en Puerto Montt*, quiero cotizar una planta desalinizadora por ósmosis inversa de alta durabilidad para agua de mar.
* **US-04.2:** *Como Comprador Técnico*, quiero verificar en la sección `/representadas/` que MITSA es el canal oficial autorizado en Chile de Erma First, Herborner Pumpen y Blücher.

### 3. Implementation Decisions
* **T04.1:** Completar y estructurar el contenido de la solución 53 (`generacion-de-agua-dulce`) con especificaciones de plantas compactas para buques y embarcaciones menores.
* **T04.2:** Optimizar la ficha de cada marca representada para captar búsquedas de marca oficial en Chile.

---

## SPEC-SEO-05: Medición, GA4 & Reportabilidad de Resultados

### 1. Problem Statement
Para garantizar el cobro del fee mensual de mantención y justificar el retorno de inversión del cliente, es fundamental medir cada lead capturado y no solo visitas genéricas.

### 2. User Stories
* **US-05.1:** *Como Gerente de MITSA*, quiero recibir un reporte mensual que me muestre cuántas cotizaciones de proyectos, cuántos pedidos de repuestos y qué posiciones en Google obtuvimos este mes.

### 3. Implementation Decisions
* **T05.1:** Configurar en GA4 vía Google Tag Manager / Site Kit eventos personalizados:
  - `generate_lead_project`: Envío de formulario de proyecto.
  - `generate_lead_mro`: Envío de formulario de repuestos.
  - `click_whatsapp_naval`: Clic en contacto directo de ingeniería.
  - `download_datasheet`: Descarga de ficha técnica o guía regulatoria.
* **T05.2:** Establecer el cuadro de mando de monitoreo mensual de SERPs en Google Chile y LatAm.
