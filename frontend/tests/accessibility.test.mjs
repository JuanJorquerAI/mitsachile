import { test, describe } from 'node:test';
import assert from 'node:assert/strict';
import { readFileSync, existsSync, readdirSync } from 'node:fs';
import { join } from 'node:path';

describe('WCAG 2.1 AA Accessibility & Heading Hierarchy Suite', () => {
  const distHtmlPath = join(process.cwd(), 'dist', 'index.html');
  const distAstroDir = join(process.cwd(), 'dist', '_astro');

  // Función helper para obtener todo el contenido HTML + CSS compilado
  const getCompiledBundleContent = () => {
    let combined = '';
    if (existsSync(distHtmlPath)) {
      combined += readFileSync(distHtmlPath, 'utf-8');
    }
    if (existsSync(distAstroDir)) {
      const files = readdirSync(distAstroDir);
      for (const file of files) {
        if (file.endsWith('.css')) {
          combined += readFileSync(join(distAstroDir, file), 'utf-8');
        }
      }
    }
    return combined;
  };

  test('el archivo compilado index.html existe en dist', () => {
    assert.ok(existsSync(distHtmlPath), 'El build estático debe existir en dist/index.html');
  });

  test('la página contiene exactamente un solo encabezado H1 semántico', () => {
    const html = readFileSync(distHtmlPath, 'utf-8');
    const h1Matches = html.match(/<h1[\s\S]*?<\/h1>/gi) || [];
    assert.equal(h1Matches.length, 1, `Debe haber exactamente un H1. Encontrados: ${h1Matches.length}`);
    assert.ok(h1Matches[0].includes('Toda su ingeniería resuelta'), 'El H1 debe contener el texto principal de ingeniería');
  });

  test('los formularios y controles interactivos tienen etiquetas y aria-labels accesibles', () => {
    const html = readFileSync(distHtmlPath, 'utf-8');
    assert.ok(html.includes('aria-label="Enviar consulta o buscar solución"'), 'El botón submit debe tener aria-label descriptivo');
    assert.ok(html.includes('for="hero-search-input"'), 'El input de búsqueda debe tener label asociado para lectores de pantalla');
  });

  test('la región de texto rotativo incluye texto accesible para lectores de pantalla', () => {
    const html = readFileSync(distHtmlPath, 'utf-8');
    assert.ok(html.includes('class="sr-only"'), 'Debe incluir texto alternativo invisible para lectores de pantalla');
    assert.ok(html.includes('aria-hidden="true"'), 'El contenedor visual de rotación debe ocultarse para evitar lecturas duplicadas');
  });

  test('respeta las preferencias de accesibilidad de movimiento reducido (prefers-reduced-motion)', () => {
    const bundle = getCompiledBundleContent();
    assert.ok(
      bundle.includes('prefers-reduced-motion:reduce') || bundle.includes('prefers-reduced-motion: reduce'),
      'Debe incluir media query prefers-reduced-motion en el bundle compilado'
    );
  });

  test('todas las secciones principales cuentan con encabezados H2 accesibles y landmarks aria-labelledby', () => {
    const html = readFileSync(distHtmlPath, 'utf-8');
    assert.ok(html.includes('id="pain-points-heading"'), 'Debe existir id en H2 de Pain Points');
    assert.ok(html.includes('id="brands-heading"'), 'Debe existir id en H2 de Brands');
    assert.ok(html.includes('id="solutions-heading"'), 'Debe existir id en H2 de Soluciones');
    assert.ok(html.includes('id="why-mitsa-heading"'), 'Debe existir id en H2 de Por qué MITSA');
    assert.ok(html.includes('id="cta-heading"'), 'Debe existir id en H2 de CTA Banner');
    assert.ok(html.includes('id="faqs-heading"'), 'Debe existir id en H2 de FAQs');
  });

  test('las preguntas frecuentes utilizan elementos interactivos nativos details y summary', () => {
    const html = readFileSync(distHtmlPath, 'utf-8');
    const detailsMatches = html.match(/<details[\s\S]*?<\/details>/gi) || [];
    assert.equal(detailsMatches.length, 4, 'Debe haber 4 elementos details');
    assert.ok(html.includes('summary class="faq-summary"'), 'Debe contener elementos summary con clase faq-summary');
  });
});
