import { describe, it } from 'node:test';
import assert from 'node:assert';
import fs from 'node:fs';
import path from 'node:path';
import { getNosotrosSections } from '../src/lib/api/client.ts';
import { NOSOTROS_FALLBACK_DATA } from '../src/lib/api/fallbacks.ts';

const distDir = path.resolve(process.cwd(), 'dist');

describe('Nosotros Page — Architecture, WCAG & Performance Suite', () => {
  it('el archivo compilado nosotros/index.html existe en dist', () => {
    const filePath = path.join(distDir, 'nosotros', 'index.html');
    assert.strictEqual(fs.existsSync(filePath), true, 'nosotros/index.html debe existir en dist');
  });

  it('la página Nosotros contiene exactamente un encabezado H1 semántico', () => {
    const html = fs.readFileSync(path.join(distDir, 'nosotros', 'index.html'), 'utf8');
    const h1Matches = html.match(/<h1[^>]*>([\s\S]*?)<\/h1>/gi) || [];
    assert.strictEqual(h1Matches.length, 1, 'Debe haber exactamente un solo H1 en la página Nosotros');
    assert.ok(h1Matches[0].includes('Cuatro décadas'), 'El H1 debe contener el título de trayectoria');
  });

  it('contiene la Misión y Visión oficiales validadas del brochure', () => {
    const html = fs.readFileSync(path.join(distDir, 'nosotros', 'index.html'), 'utf8');
    assert.ok(
      html.includes('medio ambiente acuático'),
      'Debe contener la misión/visión de cuidado del medio ambiente acuático oficial del brochure'
    );
    assert.ok(
      html.includes('Todos tenemos una especialidad, la nuestra es servir'),
      'Debe incluir el tagline oficial de MITSA'
    );
  });

  it('la imagen corporativa principal (LCP) cuenta con loading="eager" y fetchpriority="high"', () => {
    const html = fs.readFileSync(path.join(distDir, 'nosotros', 'index.html'), 'utf8');
    assert.ok(
      html.includes('fetchpriority="high"') && html.includes('loading="eager"'),
      'La imagen de Hero debe tener fetchpriority="high" y loading="eager" para optimizar LCP'
    );
  });

  it('todas las secciones principales cuentan con H2 y landmarks aria-labelledby', () => {
    const html = fs.readFileSync(path.join(distDir, 'nosotros', 'index.html'), 'utf8');
    const requiredLandmarks = [
      'aria-labelledby="nosotros-heading"',
      'aria-labelledby="mv-heading"',
      'aria-labelledby="timeline-heading"',
      'aria-labelledby="pillars-heading"',
      'aria-labelledby="coverage-heading"',
      'aria-labelledby="about-cta-heading"',
    ];

    for (const landmark of requiredLandmarks) {
      assert.ok(
        html.includes(landmark),
        `La página debe contener la sección con el landmark: ${landmark}`
      );
    }
  });

  it('el cliente HTTP de Nosotros responde con fallback en caso de desconexión', async () => {
    const data = await getNosotrosSections();
    assert.strictEqual(data.slug, 'nosotros');
    assert.strictEqual(typeof data.sections.hero.title, 'string');
    assert.strictEqual(data.sections.story.milestones.length, 4);
    assert.strictEqual(data.sections.pillars.items.length, 4);
  });
});
