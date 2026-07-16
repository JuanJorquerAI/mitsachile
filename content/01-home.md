# Home 🟡 BORRADOR — pendiente de validación del cliente

Copy nuevo redactado por la agencia (no existía `content/01-home.md`). Nace como
borrador: entra a WordPress como `draft` hasta el hito de validación con el cliente
(ver `plans/mitsachile-rediseno-web.md` P10 y `docs/DECISIONS.md`).

Fuentes usadas (solo material validado): tagline, misión y visión del brochure
(`content/02-nosotros.md` 🟢); categorías de producto reales (`content/03-productos.md` 🟢);
prioridad SEO de BWTS/regulatorio (`content/seo-keywords.md` v2). **No** se inventan
marcas, cifras de proyectos, ni clientes nombrados.

---

## Hero

**Antetítulo:** Tecnología para el cuidado del medio ambiente acuático

**Título (H1):** Soluciones técnicas en tratamiento de aguas y equipos marinos

**Bajada:** Representamos a fabricantes líderes mundiales en tecnología sanitaria,
marina y ambiental. Desde 1982 llevamos ingeniería especializada a la industria
naval, acuícola, minera e industrial de Chile y Latinoamérica.

**CTA primario:** Ver productos → `/productos/`
**CTA secundario:** Contáctanos → `/contacto/`

> Tagline de marca (del brochure, usar en el hero o cerca del logo):
> *"Todos tenemos una especialidad, la nuestra es servir."*

---

## Bloque 1 — Qué hacemos (3–4 tarjetas de categoría)

Introducción breve (H2): **Tecnología especializada, por línea de negocio**

Bajada: Representamos y damos soporte técnico a equipos para el tratamiento de
aguas, la operación marina y la protección ambiental.

Tarjetas (usar `.mitsa-card` variante producto/categoría, enlazan a la categoría):

1. **Aguas y sanitarios** — Plantas de tratamiento de aguas servidas, ósmosis
   inversa, sistemas de vacío y tratamiento de agua de lastre (BWTS).
   → `/productos/categoria/aguas-y-sanitarios/`
2. **Bombas y fluidos** — Bombas marinas e industriales, compresores,
   intercambiadores de calor y accesorios.
   → `/productos/categoria/bombas-y-fluidos/`
3. **Propulsión y confort a bordo** — Propulsión y maniobra, grúas hidráulicas
   marinas, refrigeración y equipos de confort.
   → `/productos/categoria/propulsion/`
4. **Protección de casco** — Sistemas anticorrosión / ICCP, antifouling y ánodos
   de sacrificio.
   → `/productos/categoria/proteccion-casco/`

---

## Bloque 2 — Destacado regulatorio (BWTS)

Es el diferenciador comercial más fuerte del proyecto (ver `seo-keywords.md`: único
término sin competidor local/regional confirmado, con driver regulatorio vigente).

**Título (H2):** ¿Su flota cumple la norma D-2 de agua de lastre?

**Texto:** El Convenio BWM de la OMI exige que todo Plan de Gestión de Agua de
Lastre cumpla el estándar D-2, y DIRECTEMAR ya fiscaliza en terreno en puertos
chilenos. Representamos sistemas de tratamiento de agua de lastre (BWTS)
certificados para poner su operación en regla.

**CTA:** Conocer BWTS → `/productos/tratamiento-agua-de-lastre-bwts/`

> Nota de implementación: no publicar cifras ni prometer marcas específicas más
> allá de las confirmadas en el brochure (Erma First). Verificar con el cliente.

---

## Bloque 3 — Marcas representadas (franja de logos)

**Título (H2):** Representamos a los líderes de cada especialidad

**Texto:** Desde 1982 traemos a Chile y Latinoamérica a las compañías inventoras
y líderes del mercado mundial en su rubro, con respaldo técnico local.

**CTA:** Ver representadas → `/representadas/`

> Implementación: franja/grid de logos de marcas. **Solo publicar marcas
> confirmadas.** No incluir Ervor ni EGGE hasta resolver DECISIONS #5. No destacar
> Cathelco/Evac/Uson Marine hasta resolver DECISIONS #7 (cathelco.cl).

---

## Bloque 4 — Sectores que atendemos

**Título (H2):** Al servicio de las industrias que mueven a Chile

**Texto:** Naval y marino, acuícola, pesquero, minero, industrial y municipal.
Adaptamos tecnología probada a las exigencias de cada operación.

Chips/íconos de sector (enlazan a Sectores cuando esa sección se valide):
Naval · Acuícola · Pesquero · Minero · Industrial · Municipal

**CTA:** Ver sectores → `/sectores/`

---

## Bloque 5 — Por qué MITSA (confianza)

**Título (H2):** Cuatro décadas de especialización técnica

Tres a cuatro puntos (usar solo lo verificable del brochure, sin inventar cifras):

- **Desde 1982** — más de 40 años representando tecnología de punta en el rubro.
- **Representación de líderes mundiales** — fabricantes inventores en su especialidad.
- **Soporte técnico local** — no solo vendemos equipos, acompañamos la operación.
- **Foco ambiental** — tecnología para el cuidado del medio ambiente acuático.

---

## Bloque 6 — Cierre / CTA de contacto

**Título (H2):** ¿Necesita una solución técnica para su operación?

**Texto:** Cuéntenos su requerimiento y nuestro equipo lo orientará hacia el equipo
o sistema adecuado.

**CTA:** Contáctanos → `/contacto/`

Dato de contacto (confirmado en el sitio actual, revalidar con cliente):
Av. Vicuña Mackenna 882, Viña del Mar (Reñaca) · +56 32 2834052 · info@mitsachile.com

---

## Metadatos SEO de la Home

- **Title:** `MITSA: Tratamiento de Aguas y Equipos Marinos` (46)
- **Meta description:** `Representantes de marcas líderes en tratamiento de aguas y equipos marinos y ambientales. Soluciones técnicas para el sector naval e industrial en Chile desde 1982.` (160)
- **H1 único:** el título del hero.
