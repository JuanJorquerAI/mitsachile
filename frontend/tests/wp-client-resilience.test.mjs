import { test, describe } from 'node:test';
import assert from 'node:assert/strict';
import { HOME_FALLBACK_DATA } from '../src/lib/api/fallbacks.ts';
import { fetchWithResilience } from '../src/lib/api/client.ts';

describe('WordPress REST API Resilient Client & Fallback Suite', () => {
  test('debe retornar datos estáticos cuando el servidor de WordPress está apagado o falla por timeout', async () => {
    const invalidEndpoint = 'http://127.0.0.1:9999/wp-json/mitsa/v1/sections/home';
    
    const result = await fetchWithResilience(invalidEndpoint, HOME_FALLBACK_DATA, {
      timeoutMs: 300,
      retries: 0,
    });

    assert.ok(result, 'El resultado no debe ser nulo');
    assert.equal(result.slug, 'home');
    assert.ok(result.sections.hero, 'Debe contener la sección Hero');
    assert.equal(result.sections.hero.title_prefix, 'Toda su ingeniería resuelta, del proyecto a la operación:');
  });

  test('el dataset de fallback contiene todos los campos requeridos por el contrato', () => {
    assert.ok(HOME_FALLBACK_DATA.slug);
    assert.ok(HOME_FALLBACK_DATA.title);
    assert.ok(HOME_FALLBACK_DATA.seo.meta_title);
    assert.ok(HOME_FALLBACK_DATA.seo.meta_description);
    assert.ok(HOME_FALLBACK_DATA.seo.canonical_url);
    assert.ok(HOME_FALLBACK_DATA.sections.hero);
    assert.ok(Array.isArray(HOME_FALLBACK_DATA.sections.hero.rotating_words));
    assert.ok(HOME_FALLBACK_DATA.sections.hero.triage.options.length >= 3);
    assert.ok(Array.isArray(HOME_FALLBACK_DATA.sections.visual_cards));
    assert.equal(HOME_FALLBACK_DATA.sections.visual_cards.length, 4);
    assert.ok(HOME_FALLBACK_DATA.sections.pain_points);
    assert.equal(HOME_FALLBACK_DATA.sections.pain_points.resolutions.length, 5);
    assert.ok(Array.isArray(HOME_FALLBACK_DATA.sections.metrics));
    assert.equal(HOME_FALLBACK_DATA.sections.metrics.length, 3);
    assert.ok(HOME_FALLBACK_DATA.sections.brands);
    assert.equal(HOME_FALLBACK_DATA.sections.brands.items.length, 5);
    assert.ok(HOME_FALLBACK_DATA.sections.solutions);
    assert.equal(HOME_FALLBACK_DATA.sections.solutions.items.length, 8);
    assert.ok(HOME_FALLBACK_DATA.sections.why_mitsa);
    assert.equal(HOME_FALLBACK_DATA.sections.why_mitsa.cards.length, 6);
    assert.ok(HOME_FALLBACK_DATA.sections.cta_banner);
    assert.ok(HOME_FALLBACK_DATA.sections.cta_banner.primary_button.url);
    assert.ok(HOME_FALLBACK_DATA.sections.faqs);
    assert.equal(HOME_FALLBACK_DATA.sections.faqs.items.length, 4);
  });

  test('todas las tarjetas visuales tienen alt text descriptivo y no genérico', () => {
    for (const card of HOME_FALLBACK_DATA.sections.visual_cards) {
      assert.ok(card.alt, `La tarjeta ${card.title} debe tener atributo alt`);
      assert.ok(card.alt.length > 10, `El alt text de ${card.title} debe ser descriptivo`);
      assert.ok(!card.alt.toLowerCase().startsWith('imagen de'), 'No debe incluir "imagen de"');
    }
  });
});
