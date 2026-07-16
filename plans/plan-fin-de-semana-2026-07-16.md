# Plan de trabajo — Jue 16 a Lun 20 jul 2026 (feriados 17 y 18)

Objetivo: producir avances **visibles para el cliente** en un tramo de feriados,
de modo que MITSA vea acción concreta de AplicacionesWeb. No es trabajo interno
más — es lo que Francisco puede abrir y juzgar.

## Los tres frentes

### Track A — SEO de producción (impacto inmediato, alta visibilidad) ✅ preparado
El gancho: el sitio actual está **invisible en Google** por un `robots.txt` con
`Disallow: /`. Paquete de corrección listo en `docs/entregables/seo-produccion/`
(robots.txt, sitemap.xml, metas por página, guía GA4/GTM/GSC, instrucciones).
- [x] Auditoría de producción (curl crudo) y hallazgos en DECISIONS.md
- [x] Paquete de corrección redactado y commiteado
- [ ] **Aplicar en producción** — requiere credenciales por canal seguro
      (`.env` local gitignoreado, NO el PDF comprometido)
- [ ] Verificar checklist post-aplicación (robots abierto, https redirige,
      sitemap 200, GSC con sitemap, GA4 recibiendo)

### Track B — Sitio nuevo navegable (profundidad: Home + Nosotros + Productos)
Meta: una URL privada que el cliente abre desde el teléfono y ve el sitio nuevo
tomando forma, con diseño real y contenido real en las 3 secciones validadas.
- [~] P2 — sistema de diseño + CSS + catálogo de componentes (agente en curso)
- [x] Copy de Home redactado (`content/01-home.md`, borrador)
- [ ] Integrar Home en `front-page.php` con el diseño de P2
- [ ] Nosotros con contenido real (`content/02-nosotros.md` 🟢)
- [ ] Productos: landing + categorías + al menos las fichas estrella (BWTS)
- [ ] Export estático del WP local → URL privada compartible
- [ ] (si hay acceso a producción) o staging; si no, export estático

### Track C — Desbloquear cathelco.cl 🔄 en curso
Resolver la decisión abierta #7 (bloquea el SEO de las marcas principales).
- [~] Investigación técnica WHOIS/DNS/hosting/contenido (agente en curso)
- [ ] Veredicto + preguntas concretas para Francisco en DECISIONS.md

### Entregable ancla — Informe para el cliente
Documento de 1 página (HTML/PDF, estilo del avance del 12-jul): "esto
encontramos, esto arreglamos, esto viene". Es lo que se le manda a Francisco.
- [ ] Redactar con resultados reales de A/B/C
- [ ] Exportar a PDF

## Autonomía y git
- Rama por frente; merge a master tras verificación (`php -l` + smoke test).
- Todo reversible con `git revert`. El cliente no ve nada roto porque no se toca
  producción sin credenciales y el sitio nuevo vive en local/staging.

## Estado de verificación
- "Verificado" = `php -l` en cada PHP tocado + repaso de invariantes del blueprint
  + (cuando aplique) el sitio local responde 200 en las páginas tocadas.
