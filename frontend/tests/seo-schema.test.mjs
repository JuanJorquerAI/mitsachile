import { test, describe } from 'node:test';
import assert from 'node:assert/strict';
import { generateSchemaGraph, buildPageSeo } from '../src/lib/seo/schema.ts';
import { HOME_FALLBACK_DATA } from '../src/lib/api/fallbacks.ts';

describe('Enterprise SEO & Schema.org JSON-LD Suite', () => {
  test('genera un grafo JSON-LD válido (@graph) con Organization, WebSite y WebPage', () => {
    const graphResult = generateSchemaGraph({
      url: 'https://mitsachile.com/',
      title: 'MITSA — Integramos tecnología. Resolvemos desafíos.',
      description: 'Ingeniería de aplicación, suministro, retrofit y puesta en marcha.',
      image: 'https://mitsachile.com/images/plataforma-offshore-8886341c.jpg',
    });

    assert.equal(graphResult['@context'], 'https://schema.org');
    assert.ok(Array.isArray(graphResult['@graph']));

    const types = graphResult['@graph'].map((item) => item['@type']);
    assert.ok(types.includes('Organization'), 'Debe incluir entidad Organization');
    assert.ok(types.includes('WebSite'), 'Debe incluir entidad WebSite');
    assert.ok(types.includes('WebPage'), 'Debe incluir entidad WebPage');
  });

  test('agrega entidad FAQPage cuando la sección contiene preguntas frecuentes', () => {
    const faqs = [
      { question: '¿Cómo funciona ICCP?', answer: 'Protección catódica por corriente impresa.' },
    ];

    const graphResult = generateSchemaGraph({
      url: 'https://mitsachile.com/',
      title: 'MITSA',
      description: 'Tecnología marina',
      faqs,
    });

    const faqEntity = graphResult['@graph'].find((item) => item['@type'] === 'FAQPage');
    assert.ok(faqEntity, 'Debe existir la entidad FAQPage');
    assert.equal(faqEntity.mainEntity.length, 1);
    assert.equal(faqEntity.mainEntity[0].name, '¿Cómo funciona ICCP?');
    assert.equal(faqEntity.mainEntity[0].acceptedAnswer.text, 'Protección catódica por corriente impresa.');
  });

  test('buildPageSeo genera metadatos completos y canónicos correctos', () => {
    const seoMeta = buildPageSeo(HOME_FALLBACK_DATA, 'https://mitsachile.com/');

    assert.ok(seoMeta.title.includes('MITSA'));
    assert.ok(seoMeta.description.length >= 50);
    assert.equal(seoMeta.canonicalUrl, 'https://mitsachile.com/');
    assert.equal(seoMeta.type, 'website');
    assert.ok(seoMeta.jsonLd);
  });
});
