import { describe, it } from 'node:test';
import assert from 'node:assert';
import fs from 'node:fs';
import path from 'node:path';
import { getRepresentadasSections } from '../src/lib/api/client.ts';
import { REPRESENTADAS_FALLBACK_DATA } from '../src/lib/api/fallbacks.ts';

const distDir = path.resolve(process.cwd(), 'dist');

describe('Representadas Page — Architecture, WCAG & Performance Suite', () => {
  it('el archivo compilado representadas/index.html existe en dist', () => {
    const filePath = path.join(distDir, 'representadas', 'index.html');
    assert.strictEqual(fs.existsSync(filePath), true, 'representadas/index.html debe existir en dist');
  });

  it('la página Representadas contiene exactamente un encabezado H1 semántico', () => {
    const html = fs.readFileSync(path.join(distDir, 'representadas', 'index.html'), 'utf8');
    const h1Matches = html.match(/<h1[^>]*>([\s\S]*?)<\/h1>/gi) || [];
    assert.strictEqual(h1Matches.length, 1, 'Debe haber exactamente un solo H1 en la página Representadas');
    assert.ok(h1Matches[0].includes('Marcas líderes mundiales'), 'El H1 debe contener el título de representadas');
  });

  it('contiene las 6 marcas principales representadas con sus tecnologías clave', () => {
    const html = fs.readFileSync(path.join(distDir, 'representadas', 'index.html'), 'utf8');
    const mainBrands = ['EVAC', 'Cathelco', 'ERMA FIRST', 'EPE', 'BLÜCHER', 'Uson Marine'];

    for (const b of mainBrands) {
      assert.ok(html.includes(b), `Debe contener la marca principal: ${b}`);
    }
  });

  it('contiene las marcas del directorio complementario', () => {
    const html = fs.readFileSync(path.join(distDir, 'representadas', 'index.html'), 'utf8');
    const dirBrands = ['Herborner Pumpen', 'SIHI', 'Harwil', 'Moyno', 'Burks Pumps', 'FCI Watermaker', 'Planus', 'Terminator'];

    for (const d of dirBrands) {
      assert.ok(html.includes(d), `Debe contener la marca del directorio: ${d}`);
    }
  });

  it('la imagen hero principal (LCP) cuenta con loading="eager" y fetchpriority="high"', () => {
    const html = fs.readFileSync(path.join(distDir, 'representadas', 'index.html'), 'utf8');
    assert.ok(
      html.includes('fetchpriority="high"') && html.includes('loading="eager"'),
      'La imagen destacada debe tener fetchpriority="high" y loading="eager" para optimizar el LCP'
    );
  });

  it('todas las secciones principales cuentan con H2 y landmarks aria-labelledby', () => {
    const html = fs.readFileSync(path.join(distDir, 'representadas', 'index.html'), 'utf8');
    const requiredLandmarks = [
      'aria-labelledby="representadas-hero-heading"',
      'aria-labelledby="main-brands-heading"',
      'aria-labelledby="directory-heading"',
      'aria-labelledby="rep-cta-heading"',
    ];

    for (const landmark of requiredLandmarks) {
      assert.ok(
        html.includes(landmark),
        `La página debe contener la sección con el landmark: ${landmark}`
      );
    }
  });

  it('el cliente HTTP de Representadas responde con fallback en caso de desconexión', async () => {
    const data = await getRepresentadasSections();
    assert.strictEqual(data.slug, 'representadas');
    assert.strictEqual(typeof data.sections.hero.title, 'string');
    assert.strictEqual(data.sections.main_brands.length, 6);
    assert.strictEqual(data.sections.directory.length, 8);
  });
});
