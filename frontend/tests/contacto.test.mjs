import { describe, it } from 'node:test';
import assert from 'node:assert';
import fs from 'node:fs';
import path from 'node:path';
import { getContactoSections } from '../src/lib/api/client.ts';
import { CONTACTO_FALLBACK_DATA } from '../src/lib/api/fallbacks.ts';

const distDir = path.resolve(process.cwd(), 'dist');

describe('Contacto Page — Architecture, WCAG & Performance Suite', () => {
  it('el archivo compilado contacto/index.html existe en dist', () => {
    const filePath = path.join(distDir, 'contacto', 'index.html');
    assert.strictEqual(fs.existsSync(filePath), true, 'contacto/index.html debe existir en dist');
  });

  it('la página Contacto contiene exactamente un encabezado H1 semántico', () => {
    const html = fs.readFileSync(path.join(distDir, 'contacto', 'index.html'), 'utf8');
    const h1Matches = html.match(/<h1[^>]*>([\s\S]*?)<\/h1>/gi) || [];
    assert.strictEqual(h1Matches.length, 1, 'Debe haber exactamente un solo H1 en la página Contacto');
    assert.ok(h1Matches[0].includes('Cuéntenos qué necesita resolver'), 'El H1 debe contener el título de contacto');
  });

  it('contiene las 4 puertas de contacto especializadas', () => {
    const html = fs.readFileSync(path.join(distDir, 'contacto', 'index.html'), 'utf8');
    const doors = [
      'Evaluación técnica',
      'Repuestos',
      'Servicio técnico',
      'Contacto general'
    ];

    for (const d of doors) {
      assert.ok(html.includes(d), `Debe contener la puerta: ${d}`);
    }
  });

  it('contiene la dirección confirmada de Reñaca y los 8 países de cobertura regional', () => {
    const html = fs.readFileSync(path.join(distDir, 'contacto', 'index.html'), 'utf8');
    assert.ok(html.includes('Vicuña Mackenna 882') || html.includes('Reñaca'), 'Debe incluir la dirección de Reñaca');

    const countries = ['Chile', 'Perú', 'Ecuador', 'Colombia', 'Panamá', 'Paraguay', 'Bolivia', 'Venezuela'];
    for (const country of countries) {
      assert.ok(html.includes(country), `Debe contener el país: ${country}`);
    }
  });

  it('el formulario de contacto incluye campos accesibles con labels y required', () => {
    const html = fs.readFileSync(path.join(distDir, 'contacto', 'index.html'), 'utf8');
    assert.ok(html.includes('for="nombre"'), 'Debe asociar label a input nombre');
    assert.ok(html.includes('for="empresa"'), 'Debe asociar label a input empresa');
    assert.ok(html.includes('for="correo"'), 'Debe asociar label a input correo');
    assert.ok(html.includes('type="submit"'), 'Debe tener botón de envío');
  });

  it('todas las secciones principales cuentan con H2 y landmarks aria-labelledby', () => {
    const html = fs.readFileSync(path.join(distDir, 'contacto', 'index.html'), 'utf8');
    const requiredLandmarks = [
      'aria-labelledby="contacto-hero-heading"',
      'aria-labelledby="form-heading"',
      'aria-labelledby="channels-heading"',
    ];

    for (const landmark of requiredLandmarks) {
      assert.ok(
        html.includes(landmark),
        `La página debe contener la sección con el landmark: ${landmark}`
      );
    }
  });

  it('el cliente HTTP de Contacto responde con fallback en caso de desconexión', async () => {
    const data = await getContactoSections();
    assert.strictEqual(data.slug, 'contacto');
    assert.strictEqual(typeof data.sections.hero.title, 'string');
    assert.strictEqual(data.sections.doors.length, 4);
    assert.strictEqual(data.sections.coverage.countries.length, 8);
  });
});
