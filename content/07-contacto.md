# Contacto 🟡 BORRADOR — pendiente de validación con el cliente (Francisco De la Iglesia / Luis Silva), salvo dirección y cobertura regional que están 🟢 CONFIRMADAS por el brochure

> Propuesta de la agencia para la estructura de la página. La dirección está confirmada por correo de Francisca De la Iglesia y además aparece impresa en el pie de cada una de las 40 diapositivas del brochure corporativo, por lo que se considera dato consolidado. Teléfonos, email y el resto de la estructura son propuesta de la agencia pendiente de validación.

## Formulario de contacto

Campos sugeridos:

- Nombre
- Empresa
- Email
- Teléfono
- Sector (selector con los 7 sectores de `content/05-sectores.md`: Marino/naval, Pesquero-acuícola, Minero, Industrial, Comercial, Residencial, Aviación)
- Mensaje

Los campos son propuesta de la agencia siguiendo buenas prácticas B2B para captación de leads técnicos. **No están confirmados por el cliente** — a validar si se requiere algún campo adicional (ej. país, tipo de consulta: cotización / repuesto / soporte técnico).

## Dirección 🟢 CONFIRMADO

**Av. Vicuña Mackenna 882, Reñaca, Viña del Mar, Chile.**

Fuente: confirmada por correo de Francisca De la Iglesia (Finanzas) y presente de forma consistente en el pie de página de las 40 diapositivas del brochure corporativo ("MITSA - Av.Vicuña Mackenna 882-Reñaca-Viña del Mar"). Es el dato de contacto más sólido de todo el proyecto.

## Teléfonos y email

**No se encontró ningún teléfono ni email corporativo de MITSA en ninguna de las fuentes disponibles** (brochure de 40 páginas, mapa del sitio, mapa de palabras clave). El brochure solo trae la dirección física en el pie de cada diapositiva, sin datos de contacto telefónico ni casillas de correo institucionales (`contacto@mitsachile.com` o similar).

Los únicos correos electrónicos conocidos en el proyecto son personales de los contactos de MITSA y de la agencia (ver `CLAUDE.md`), no líneas de contacto públicas para el sitio web — **no deben publicarse como email de contacto general del sitio sin autorización explícita del cliente**.

**No inventar teléfonos ni emails.** Este dato debe salir directamente del documento maestro pendiente o de una consulta directa a Francisco/Luis antes de construir esta sección.

## Cobertura regional 🟢 CONFIRMADO — 8 países

Fuente: diapositiva "PRESENTES EN" del brochure, que incluye un mapa de Sudamérica y las banderas de los 8 países. Confirma exactamente el dato que el mapa del sitio mencionaba como pendiente ("cobertura regional, 8 países"):

1. Ecuador
2. Colombia
3. Chile
4. Perú
5. Paraguay
6. Bolivia
7. Panamá
8. Venezuela

El brochure no aclara si en todos estos países MITSA tiene oficina/representación local propia o si es cobertura comercial desde Chile — **pendiente de confirmar con el cliente** antes de redactar el texto final de esta sección (por ejemplo, si corresponde decir "con oficinas en" o "con cobertura comercial en").

## Fuentes usadas

- Dirección: correo de Francisca De la Iglesia (referenciado en `CLAUDE.md`) + pie de página de las 40 diapositivas de `docs/Brochure MITSA SPA - Extracto..pdf`.
- Lista de 8 países de cobertura regional: brochure, diapositiva "PRESENTES EN" (Ecuador, Colombia, Chile, Perú, Paraguay, Bolivia, Panamá, Venezuela) — resuelve el dato que `docs/MITSA_Mapa_del_sitio.pdf` dejaba pendiente ("Cobertura regional (8 países)").
- Estructura de la sección Contacto y campos del formulario: `docs/MITSA_Mapa_del_sitio.pdf`, sección 7 "Contacto" (formulario, dirección, teléfonos/email, cobertura regional) — la agencia desarrolló el detalle de cada punto.

## Datos faltantes

- **Teléfono(s) de contacto de MITSA** — no aparece en ninguna fuente disponible.
- **Email corporativo de contacto** (ej. contacto@mitsachile.com) — no aparece en ninguna fuente disponible.
- Horario de atención.
- Si existen oficinas físicas o representantes locales en los otros 7 países de cobertura regional, o si toda la operación se gestiona desde Reñaca.
- Redes sociales / LinkedIn corporativo, si existen.
- Mapa embebido o coordenadas exactas para el sitio (la dirección textual está confirmada, pero no se validó geolocalización).
- Este archivo depende críticamente del "documento maestro" que Francisco prometió enviar (ver `docs/DECISIONS.md` #3) — no ha llegado. Los teléfonos y el email son, junto con eso, el dato de mayor prioridad a resolver antes de construir esta página en WordPress, porque sin ellos el formulario de contacto queda como único canal.
