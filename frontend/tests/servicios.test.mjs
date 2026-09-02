import { describe, it } from 'node:test';
import assert from 'node:assert';
import fs from 'node:fs';
import path from 'node:path';
import { getServiciosSections } from '../src/lib/api/client.ts';
import { SERVICIOS_FALLBACK_DATA } from '../src/lib/api/fallbacks.ts';

const distDir = path.resolve(process.cwd(), 'dist');

describe('Servicios Page — Architecture, WCAG & Performance Suite', () => {
  it('el archivo compilado servicios/index.html existe en dist', () => {
    const filePath = path.join(distDir, 'servicios', 'index.html');
    assert.strictEqual(fs.existsSync(filePath), true, 'servicios/index.html debe existir en dist');
  });

  it('la página Servicios contiene exactamente un encabezado H1 semántico', () => {
    const html = fs.readFileSync(path.join(distDir, 'servicios', 'index.html'), 'utf8');
    const h1Matches = html.match(/<h1[^>]*>([\s\S]*?)<\/h1>/gi) || [];
    assert.strictEqual(h1Matches.length, 1, 'Debe haber exactamente un solo H1 en la página Servicios');
    assert.ok(h1Matches[0].includes('El equipo llega'), 'El H1 debe contener el título de servicios');
  });

  it('contiene los 6 servicios y el proceso de 4 etapas confirmado por el brochure', () => {
    const html = fs.readFileSync(path.join(distDir, 'servicios', 'index.html'), 'utf8');
    assert.ok(html.includes('Ingeniería y dimensionamiento'), 'Debe incluir el servicio 01');
    assert.ok(html.includes('Suministro e importación oficial'), 'Debe incluir el servicio 02');
    assert.ok(html.includes('Montaje y supervisión'), 'Debe incluir el servicio 03');
    assert.ok(html.includes('Puesta en marcha y comisionamiento'), 'Debe incluir el servicio 04');
    assert.ok(html.includes('Repuestos originales y retrofit'), 'Debe incluir el servicio 05');
    assert.ok(html.includes('Soporte y continuidad operacional'), 'Debe incluir el servicio 06');
    assert.ok(html.includes('Proceso de asesoramiento y cotización técnica'), 'Debe incluir el proceso de 4 etapas');
    assert.ok(html.includes('1. Requerimiento') && html.includes('2. Evaluación'), 'Debe incluir los pasos del proceso');
  });

  it('la imagen corporativa principal (LCP) cuenta con loading="eager" y fetchpriority="high"', () => {
    const html = fs.readFileSync(path.join(distDir, 'servicios', 'index.html'), 'utf8');
    assert.ok(
      html.includes('fetchpriority="high"') && html.includes('loading="eager"'),
      'La imagen de Hero debe tener fetchpriority="high" y loading="eager" para optimizar LCP'
    );
  });

  it('todas las secciones principales cuentan con H2 y landmarks aria-labelledby', () => {
    const html = fs.readFileSync(path.join(distDir, 'servicios', 'index.html'), 'utf8');
    const requiredLandmarks = [
      'aria-labelledby="servicios-heading"',
      'aria-labelledby="catalog-heading"',
      'aria-labelledby="process-heading"',
      'aria-labelledby="servicios-cta-heading"',
    ];

    for (const landmark of requiredLandmarks) {
      assert.ok(
        html.includes(landmark),
        `La página debe contener la sección con el landmark: ${landmark}`
      );
    }
  });

  it('el cliente HTTP de Servicios responde con fallback en caso de desconexión', async () => {
    const data = await getServiciosSections();
    assert.strictEqual(data.slug, 'servicios');
    assert.strictEqual(typeof data.sections.hero.title, 'string');
    assert.strictEqual(data.sections.catalog.length, 6);
    assert.strictEqual(data.sections.process.steps.length, 4);
  });
});
