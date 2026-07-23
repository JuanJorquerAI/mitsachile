---
name: mitsa-status
description: Genera un resumen del estado actual del proyecto MITSA (rediseño web mitsachile.com) — qué contenido está validado, qué falta, qué decisiones siguen abiertas. Usar cuando el usuario pregunte "cómo va el proyecto MITSA", "estado de MITSA", "en qué está el proyecto MITSA", "resumen del proyecto MITSA", o variantes equivalentes sobre el avance/status de este proyecto.
---

# Estado del proyecto MITSA

Genera un informe de estado leyendo el estado real de los archivos del repo — no lo infieras de memoria ni de conversaciones previas. Sigue estos pasos en orden:

## 1. Leer el contexto base

- Lee `AGENTS.md` en la raíz del repo — extrae el alcance del proyecto, la regla de oro de contenido, y la lista de "Decisiones ya tomadas" / "Decisiones abiertas" que trae al final.
- Lee `docs/DECISIONS.md` completo — es el log vivo de decisiones. Extrae la tabla de "Tomadas" y la lista numerada de "Abiertas".
- Lee `content/00-sitemap.md` — extrae el árbol de secciones con su estado (🟢 validado, 🟡 propuesto/pendiente de validar, 🔴 nuevo/no existe hoy).

## 2. Revisar el estado real de `content/*.md`

- Lista todos los archivos `.md` que existen hoy en `content/`.
- Para cada sección esperada según el sitemap (Nosotros, Productos, Representadas, Sectores, Servicios, Contacto, y cualquier otra referenciada como `content/NN-nombre.md` dentro de `00-sitemap.md`), determina:
  - Si el archivo existe o no.
  - Si existe, léelo y busca su marcador de estado en el encabezado (🟢 VALIDADO, 🟡 BORRADOR — pendiente de validación, o equivalente) y cualquier sección "Pendiente de completar" que traiga al final — esos son gaps documentados por el propio contenido.
  - Si no existe, márcalo como "no creado todavía".
- No asumas contenido que no está escrito. Si un archivo no existe, repórtalo como faltante, no como "pendiente" genérico.

## 3. Producir el resumen

Estructura el resumen en estas secciones, en español:

**✅ Validado** — qué contenido/decisión está confirmado y listo para usar (ej. secciones 🟢 del sitemap con su archivo `content/` correspondiente ya escrito; decisiones de la tabla "Tomadas" de DECISIONS.md).

**🟡 Pendiente de validación** — secciones con contenido borrador (archivos existentes marcados 🟡 o con notas editoriales de "no está confirmado"), y qué haría falta para cerrarlas (ej. "documento maestro" del cliente, confirmación de Luis/Francisco).

**🔴 Falta contenido / no creado** — secciones del sitemap que aún no tienen archivo en `content/`, o secciones nuevas (🔴 en el sitemap) sin desarrollo todavía.

**Decisiones abiertas** — lista numerada tomada directamente de `docs/DECISIONS.md`, sin resumir ni opinar sobre cuál debería ganar; si alguna decisión abierta bloquea contenido o desarrollo, señala esa dependencia explícitamente (ej. "la decisión de dominio final bloquea la config final de URLs canónicas").

**Próximos pasos sugeridos** — 2-4 acciones concretas y accionables basadas en los gaps detectados (ej. "confirmar con Francisco si llegó el documento maestro de contenidos", "crear content/04-representadas.md una vez validado el directorio de marcas"). No inventes plazos ni compromisos que no estén en las fuentes leídas.

## Reglas

- No inventes ni asumas datos que no estén en `AGENTS.md`, `docs/DECISIONS.md`, `content/00-sitemap.md` o los archivos `content/*.md` existentes.
- Si alguno de los archivos base (`AGENTS.md`, `docs/DECISIONS.md`, `content/00-sitemap.md`) no existe o no se puede leer, dilo explícitamente al inicio del resumen en vez de omitirlo en silencio.
- Mantén el resumen accionable y conciso — es un check-in de estado, no una reescritura completa del proyecto.
