import { describe, it } from 'node:test';
import assert from 'node:assert';
import fs from 'node:fs';
import path from 'node:path';
import { getSiteOptions } from '../src/lib/api/client.ts';
import { SITE_OPTIONS_FALLBACK_DATA } from '../src/lib/api/fallbacks.ts';

const distDir = path.resolve(process.cwd(), 'dist');

describe('Site Options & Global Branding Suite', () => {
  it('el logo principal es un SVG válido y no está URL-encoded', () => {
    const logoPath = path.resolve(process.cwd(), 'public', 'images', 'mitsa-27703545.svg');
    assert.strictEqual(fs.existsSync(logoPath), true, 'El archivo de logo principal debe existir');
    const content = fs.readFileSync(logoPath, 'utf8');
    assert.ok(content.startsWith('<svg') || content.startsWith('<?xml'), 'El logo debe comenzar con tag SVG o XML');
    assert.strictEqual(content.includes('%3C'), false, 'El logo NO debe contener caracteres URL-encoded');
  });

  it('el logo blanco para footer es un SVG válido y legible sobre fondo oscuro', () => {
    const logoPath = path.resolve(process.cwd(), 'public', 'images', 'mitsa-0e284396.svg');
    assert.strictEqual(fs.existsSync(logoPath), true, 'El archivo de logo blanco debe existir');
    const content = fs.readFileSync(logoPath, 'utf8');
    assert.ok(content.startsWith('<svg') || content.startsWith('<?xml'), 'El logo blanco debe ser un SVG');
    assert.strictEqual(content.includes('%3C'), false, 'El logo blanco NO debe contener caracteres URL-encoded');
  });

  it('el cliente HTTP de Site Options responde correctamente con fallback tolerante', async () => {
    const options = await getSiteOptions();
    assert.strictEqual(typeof options.brand.name, 'string');
    assert.strictEqual(typeof options.brand.logo_main, 'string');
    assert.strictEqual(typeof options.header.btn_repuestos_label, 'string');
    assert.strictEqual(typeof options.footer.statement_prefix, 'string');
    assert.strictEqual(typeof options.contact.email_general, 'string');
    assert.strictEqual(typeof options.social.linkedin, 'string');
  });

  it('todas las páginas compiladas incluyen el logo principal con alt text en la cabecera', () => {
    const html = fs.readFileSync(path.join(distDir, 'index.html'), 'utf8');
    assert.ok(html.includes('alt="MITSA"') || html.includes('alt="MITSA SpA"'), 'El header debe contener el logo con alt text de marca');
    assert.ok(html.includes('mitsa-27703545.svg'), 'El header debe referenciar el logo principal');
  });

  it('el footer de las páginas compiladas incluye la declaración corporativa y el logo blanco', () => {
    const html = fs.readFileSync(path.join(distDir, 'index.html'), 'utf8');
    assert.ok(html.includes('mitsa-0e284396.svg'), 'El footer debe referenciar el logo blanco');
    assert.ok(html.includes('Integramos') && html.includes('tecnología.'), 'El footer debe contener la declaración de marca');
    assert.ok(html.includes('Reñaca, Viña del Mar'), 'El footer debe contener la ubicación');
  });
});
