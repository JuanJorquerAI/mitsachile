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
- [x] P2 — sistema de diseño + CSS (40KB) + catálogo de componentes (`docs/componentes.md`)
- [x] Copy de Home redactado (`content/01-home.md`, borrador)
- [x] Home maquetada en `front-page.php`: hero + 5 categorías + destacado BWTS + marcas + sectores + confianza + CTA
- [x] Nosotros con contenido real (`content/02-nosotros.md` 🟢, publish)
- [x] Productos: landing como catálogo de categorías (fix routing CPT sin archive)
- [x] Footer limpio (widgets por defecto fuera, menú footer poblado), title "MITSA"
- [x] Responsive verificado (desktop 1280 + móvil 390) con screenshots
- [x] Export estático del WP local → `export/` (26 páginas, `scripts/export-estatico.sh`)
- [ ] Publicar export en staging/URL para el cliente (pendiente decisión de hosting)
- [ ] Fichas de producto individuales (BWTS Erma First) — próxima etapa

### Track C — Desbloquear cathelco.cl 🔄 en curso
Resolver la decisión abierta #7 (bloquea el SEO de las marcas principales).
- [~] Investigación técnica WHOIS/DNS/hosting/contenido (agente en curso)
- [ ] Veredicto + preguntas concretas para Francisco en DECISIONS.md

### Entregable ancla — Informe para el cliente ✅
Documento visual con el hallazgo SEO, la tabla de auditoría, los screenshots del
sitio nuevo y "qué viene". `docs/entregables/informe-avance-2026-07-16.{html,pdf}`.
- [x] Redactado con resultados reales de A/B/C
- [x] Screenshots del sitio nuevo embebidos (portada, productos, nosotros, móvil)
- [x] Exportado a PDF (1.1M, autocontenido)
- [ ] Juan revisa y envía a Francisco

## Autonomía y git
- Rama por frente; merge a master tras verificación (`php -l` + smoke test).
- Todo reversible con `git revert`. El cliente no ve nada roto porque no se toca
  producción sin credenciales y el sitio nuevo vive en local/staging.

## Estado de verificación
- "Verificado" = `php -l` en cada PHP tocado + repaso de invariantes del blueprint
  + (cuando aplique) el sitio local responde 200 en las páginas tocadas.
