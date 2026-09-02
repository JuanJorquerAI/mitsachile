import { describe, it } from 'node:test';
import assert from 'node:assert';
import fs from 'node:fs';
import path from 'node:path';
import { getIndustriasSections } from '../src/lib/api/client.ts';
import { INDUSTRIAS_FALLBACK_DATA } from '../src/lib/api/fallbacks.ts';

const distDir = path.resolve(process.cwd(), 'dist');

describe('Industrias Page — Architecture, WCAG & Performance Suite', () => {
  it('el archivo compilado industrias/index.html existe en dist', () => {
    const filePath = path.join(distDir, 'industrias', 'index.html');
    assert.strictEqual(fs.existsSync(filePath), true, 'industrias/index.html debe existir en dist');
  });

  it('la página Industrias contiene exactamente un encabezado H1 semántico', () => {
    const html = fs.readFileSync(path.join(distDir, 'industrias', 'index.html'), 'utf8');
    const h1Matches = html.match(/<h1[^>]*>([\s\S]*?)<\/h1>/gi) || [];
    assert.strictEqual(h1Matches.length, 1, 'Debe haber exactamente un solo H1 en la página Industrias');
    assert.ok(h1Matches[0].includes('Cada industria exige'), 'El H1 debe contener el título de industrias');
  });

  it('contiene los 6 sectores con sus IDs de ancla y descripciones correspondientes', () => {
    const html = fs.readFileSync(path.join(distDir, 'industrias', 'index.html'), 'utf8');
    const sectorIds = ['id="naval"', 'id="acuicultura"', 'id="offshore"', 'id="astilleros"', 'id="carga"', 'id="tierra"'];

    for (const sid of sectorIds) {
      assert.ok(html.includes(sid), `Debe contener el anchor del sector: ${sid}`);
    }

    assert.ok(html.includes('Naval y defensa'), 'Debe incluir Naval y defensa');
    assert.ok(html.includes('Acuicultura y pesca'), 'Debe incluir Acuicultura y pesca');
    assert.ok(html.includes('Instalaciones en tierra y minería'), 'Debe incluir Instalaciones en tierra');
  });

  it('la primera imagen del grid cuenta con loading="eager" y fetchpriority="high"', () => {
    const html = fs.readFileSync(path.join(distDir, 'industrias', 'index.html'), 'utf8');
    assert.ok(
      html.includes('fetchpriority="high"') && html.includes('loading="eager"'),
      'La primera imagen del grid debe tener fetchpriority="high" y loading="eager"'
    );
  });

  it('todas las secciones principales cuentan con H2 y landmarks aria-labelledby', () => {
    const html = fs.readFileSync(path.join(distDir, 'industrias', 'index.html'), 'utf8');
    const requiredLandmarks = [
      'aria-labelledby="industrias-heading"',
      'aria-labelledby="sectors-heading"',
      'aria-labelledby="criteria-heading"',
      'aria-labelledby="industrias-cta-heading"',
    ];

    for (const landmark of requiredLandmarks) {
      assert.ok(
        html.includes(landmark),
        `La página debe contener la sección con el landmark: ${landmark}`
      );
    }
  });

  it('el cliente HTTP de Industrias responde con fallback en caso de desconexión', async () => {
    const data = await getIndustriasSections();
    assert.strictEqual(data.slug, 'industrias');
    assert.strictEqual(typeof data.sections.hero.title, 'string');
    assert.strictEqual(data.sections.industries.length, 6);
    assert.strictEqual(data.sections.criteria.items.length, 4);
  });
});
