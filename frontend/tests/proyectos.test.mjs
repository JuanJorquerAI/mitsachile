import { describe, it } from 'node:test';
import assert from 'node:assert';
import fs from 'node:fs';
import path from 'node:path';
import { getProyectosSections } from '../src/lib/api/client.ts';
import { PROYECTOS_FALLBACK_DATA } from '../src/lib/api/fallbacks.ts';

const distDir = path.resolve(process.cwd(), 'dist');

describe('Proyectos Page — Architecture, WCAG & Performance Suite', () => {
  it('el archivo compilado proyectos/index.html existe en dist', () => {
    const filePath = path.join(distDir, 'proyectos', 'index.html');
    assert.strictEqual(fs.existsSync(filePath), true, 'proyectos/index.html debe existir en dist');
  });

  it('la página Proyectos contiene exactamente un encabezado H1 semántico', () => {
    const html = fs.readFileSync(path.join(distDir, 'proyectos', 'index.html'), 'utf8');
    const h1Matches = html.match(/<h1[^>]*>([\s\S]*?)<\/h1>/gi) || [];
    assert.strictEqual(h1Matches.length, 1, 'Debe haber exactamente un solo H1 en la página Proyectos');
    assert.ok(h1Matches[0].includes('Lo que ya está instalado'), 'El H1 debe contener el título de proyectos');
  });

  it('contiene los 6 casos de éxito representativos con sus descripciones', () => {
    const html = fs.readFileSync(path.join(distDir, 'proyectos', 'index.html'), 'utf8');
    const cases = [
      'Astillero — Construcción nueva',
      'Buque de apoyo (PSV) — Retrofit',
      'Plataforma offshore — Protección catódica',
      'Centro de cultivo — Pontón habitable',
      'Flota pesquera — Redes al vacío continuas',
      'Campamento minero — Evacuación sin pendiente'
    ];

    for (const c of cases) {
      assert.ok(html.includes(c), `Debe contener el caso: ${c}`);
    }
  });

  it('la imagen hero principal (LCP) cuenta con loading="eager" y fetchpriority="high"', () => {
    const html = fs.readFileSync(path.join(distDir, 'proyectos', 'index.html'), 'utf8');
    assert.ok(
      html.includes('fetchpriority="high"') && html.includes('loading="eager"'),
      'La imagen hero debe tener fetchpriority="high" y loading="eager"'
    );
  });

  it('todas las secciones principales cuentan con H2 y landmarks aria-labelledby', () => {
    const html = fs.readFileSync(path.join(distDir, 'proyectos', 'index.html'), 'utf8');
    const requiredLandmarks = [
      'aria-labelledby="proyectos-hero-heading"',
      'aria-labelledby="catalog-heading"',
      'aria-labelledby="method-heading"',
      'aria-labelledby="proyectos-cta-heading"',
    ];

    for (const landmark of requiredLandmarks) {
      assert.ok(
        html.includes(landmark),
        `La página debe contener la sección con el landmark: ${landmark}`
      );
    }
  });

  it('el cliente HTTP de Proyectos responde con fallback en caso de desconexión', async () => {
    const data = await getProyectosSections();
    assert.strictEqual(data.slug, 'proyectos');
    assert.strictEqual(typeof data.sections.hero.title, 'string');
    assert.strictEqual(data.sections.projects.length, 6);
    assert.strictEqual(data.sections.methodology.steps.length, 4);
  });
});
