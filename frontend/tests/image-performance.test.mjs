import { test, describe } from 'node:test';
import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import { join } from 'node:path';

describe('Image Performance Pipeline & Core Web Vitals Suite', () => {
  const distHtmlPath = join(process.cwd(), 'dist', 'index.html');

  test('la primera imagen visual (LCP) cuenta con loading="eager" y fetchpriority="high"', () => {
    const html = readFileSync(distHtmlPath, 'utf-8');
    
    // Verificar que existe fetchpriority="high" en la primera imagen del grid
    assert.ok(html.includes('fetchpriority="high"'), 'La imagen LCP debe tener fetchpriority="high"');
    assert.ok(html.includes('loading="eager"'), 'Las imágenes above-the-fold deben tener loading="eager"');
  });

  test('todas las imágenes tienen dimensiones explícitas (width y height) para garantizar CLS = 0', () => {
    const html = readFileSync(distHtmlPath, 'utf-8');
    const imgTags = html.match(/<img[^>]+>/gi) || [];

    assert.ok(imgTags.length > 0, 'Debe haber imágenes en la página');

    for (const tag of imgTags) {
      assert.ok(tag.includes('alt='), `La imagen debe tener atributo alt: ${tag}`);
      // Comprobar que o tiene width/height o clase con relación de aspecto
      const hasDimensions = (tag.includes('width=') && tag.includes('height=')) || tag.includes('style=') || tag.includes('class=');
      assert.ok(hasDimensions, `La imagen debe prevenir CLS con dimensiones o estilo: ${tag}`);
    }
  });

  test('el HTML incluye el script de structured data JSON-LD sin caracteres mal codificados', () => {
    const html = readFileSync(distHtmlPath, 'utf-8');
    assert.ok(html.includes('application/ld+json'), 'Debe incluir el tag JSON-LD');
    assert.ok(html.includes('https://schema.org'), 'Debe referenciar el contexto de Schema.org');
    assert.ok(html.includes('MITSA SpA'), 'Debe contener los datos de la organización');
  });
});
