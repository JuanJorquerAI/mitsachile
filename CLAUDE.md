# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

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
- GA4 + Google Search Console + Google Tag Manager instalados desde el lanzamiento.
- Biblioteca técnica / centro de descargas (fichas técnicas, catálogos, certificados, manuales, brochures) — algunas descargas de alto valor comercial deben ir tras formulario de contacto, otras de acceso libre (a definir por sección).
- Sección de casos de éxito / proyectos destacados, estructurada por: cliente/tipo, industria, problema, solución, producto/tecnología, resultado. Si no se puede nombrar cliente por confidencialidad, usar "casos representativos" por industria (Armada, astilleros, salmoneras, navieras, proyectos internacionales).
- SEO inicial: estructura, títulos/metadescripciones, jerarquía de encabezados, URLs amigables, sitemap.xml, optimización de imágenes.
- **Fuera de alcance inicial** (no construir sin cotización aparte): traducción/versión en inglés completa, multilenguaje implementado, producción fotográfica/audiovisual, rediseño de logo, compra de dominios, integraciones ERP/CRM, funcionalidades no mencionadas en la propuesta.

## Estrategia SEO (ver `content/seo-keywords.md`)

Basado en análisis competitivo vs. IMPOMAR/EQUIMAR (`docs/MITSA_Mapa_Sitio_Palabras_Clave.pdf`). Priorizar términos donde MITSA tiene ventaja técnica real y sin competencia directa: BWTS/tratamiento agua de lastre, protección catódica ICCP, antifouling naval/ánodos de sacrificio, ósmosis inversa marina, fluidos anticorrosión para buques. No competir en términos genéricos fuera del rubro (anclas y cadenas, grilletes, señalización marítima, equipos de seguridad SOLAS — son core de IMPOMAR, no de MITSA).

## Seguridad: credenciales

`docs/Correo de AplicacionesWeb - Inicio proyecto MITSA.pdf` contiene credenciales en texto plano de cPanel, GoDaddy, BlueHosting y NIC Chile del cliente. Ese archivo está en `.gitignore` — **nunca quitarlo del gitignore ni commitearlo**. Si se necesitan esas credenciales para trabajar, moverlas a un gestor de secretos o `.env` local (también gitignoreado), nunca a un archivo versionado ni a `content/` ni a `docs/DECISIONS.md`.

## Estructura del repo

- `docs/` — material fuente entregado por el cliente (PDFs: brochure, propuesta, mapas de sitio, correos). No editar, son insumo.
- `content/` — contenido estructurado en markdown, listo para cargar a WordPress, derivado de `docs/` + copy nuevo. Fuente de verdad para lo que entra al sitio.
- `wp-content/themes/mitsa/` — tema WordPress custom (PHP clásico, sin page builder). Sin plugins de arrastrar-soltar; usar ACF si se necesitan campos custom.
- `docs/DECISIONS.md` — log de decisiones pendientes/tomadas (dominio, marca "MITSA" vs "MITSA Chile", fee mensual 9 vs 12 UF, etc.) para no perder contexto entre sesiones.

## Decisiones ya tomadas por el cliente

- Marca: proyectar como **"MITSA"** (no "MITSA Chile") para expansión regional a Latinoamérica.
- Cliente es propietario de todos los activos digitales (dominio, hosting, sitio WordPress, base de datos, contenidos, material gráfico). Hosting puede quedar administrado por AplicacionesWeb dentro del servicio mensual, pero portable — se debe poder entregar copia completa sin pagos pendientes.
- Analítica: GA4 + GSC + GTM instalados desde el día 1 del lanzamiento.

## Decisiones abiertas (no asumir, ver `docs/DECISIONS.md`)

- Fee mensual de mantención: propuesta original 12 UF/mes, cliente propuso 9 UF/mes o 12 UF atadas a entregables — sin cerrar en el último correo del hilo.
- Dominio final a usar.
- Validación final de secciones Representadas, Sectores, Servicios, Contacto contra el "documento maestro" que el cliente prometió entregar (aún no llegó en los correos disponibles).
