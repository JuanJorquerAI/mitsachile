import { describe, it } from 'node:test';
import assert from 'node:assert';
import fs from 'node:fs';
import path from 'node:path';
import { getRecursosSections } from '../src/lib/api/client.ts';
import { RECURSOS_FALLBACK_DATA } from '../src/lib/api/fallbacks.ts';

const distDir = path.resolve(process.cwd(), 'dist');

describe('Recursos Page — Architecture, WCAG & Performance Suite', () => {
  it('el archivo compilado recursos/index.html existe en dist', () => {
    const filePath = path.join(distDir, 'recursos', 'index.html');
    assert.strictEqual(fs.existsSync(filePath), true, 'recursos/index.html debe existir en dist');
  });

  it('la página Recursos contiene exactamente un encabezado H1 semántico', () => {
    const html = fs.readFileSync(path.join(distDir, 'recursos', 'index.html'), 'utf8');
    const h1Matches = html.match(/<h1[^>]*>([\s\S]*?)<\/h1>/gi) || [];
    assert.strictEqual(h1Matches.length, 1, 'Debe haber exactamente un solo H1 en la página Recursos');
    assert.ok(h1Matches[0].includes('El criterio técnico, publicado'), 'El H1 debe contener el título de recursos');
  });

  it('contiene los 5 artículos técnicos del cluster regulatorio', () => {
    const html = fs.readFileSync(path.join(distDir, 'recursos', 'index.html'), 'utf8');
    const articles = [
      'Norma D-2 OMI en Chile',
      'Circular A-52/007 de DIRECTEMAR',
      'Protección Catódica ICCP vs. Ánodos de Sacrificio',
      'Ósmosis Inversa Marina',
      'MARPOL Anexo IV y Resolución MEPC.227(64)'
    ];

    for (const art of articles) {
      assert.ok(html.includes(art), `Debe contener el artículo: ${art}`);
    }
  });

  it('contiene los 5 documentos de la biblioteca de descargas técnicas', () => {
    const html = fs.readFileSync(path.join(distDir, 'recursos', 'index.html'), 'utf8');
    const downloads = [
      'Catálogo General de Soluciones MITSA 2026',
      'Ficha Técnica — Sistema Sanitario al Vacío EVAC',
      'Manual de Operación de Plantas de Tratamiento de Aguas Servidas',
      'Listado de Repuestos Críticos y Números de Parte (P/N)',
      'Protocolo de Comisionamiento y Pruebas de Puesta en Marcha'
    ];

    for (const doc of downloads) {
      assert.ok(html.includes(doc), `Debe contener el documento de descarga: ${doc}`);
    }
  });

  it('la imagen hero principal (LCP) cuenta con loading="eager" y fetchpriority="high"', () => {
    const html = fs.readFileSync(path.join(distDir, 'recursos', 'index.html'), 'utf8');
    assert.ok(
      html.includes('fetchpriority="high"') && html.includes('loading="eager"'),
      'La imagen hero debe tener fetchpriority="high" y loading="eager"'
    );
  });

  it('todas las secciones principales cuentan con H2 y landmarks aria-labelledby', () => {
    const html = fs.readFileSync(path.join(distDir, 'recursos', 'index.html'), 'utf8');
    const requiredLandmarks = [
      'aria-labelledby="recursos-hero-heading"',
      'aria-labelledby="articles-heading"',
      'aria-labelledby="downloads-heading"',
      'aria-labelledby="recursos-cta-heading"',
    ];

    for (const landmark of requiredLandmarks) {
      assert.ok(
        html.includes(landmark),
        `La página debe contener la sección con el landmark: ${landmark}`
      );
    }
  });

  it('el cliente HTTP de Recursos responde con fallback en caso de desconexión', async () => {
    const data = await getRecursosSections();
    assert.strictEqual(data.slug, 'recursos');
    assert.strictEqual(typeof data.sections.hero.title, 'string');
    assert.strictEqual(data.sections.articles.length, 5);
    assert.strictEqual(data.sections.downloads.length, 5);
  });
});
