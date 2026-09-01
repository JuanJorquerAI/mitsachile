import { defineConfig } from 'astro/config';
import sitemap from '@astrojs/sitemap';

export default defineConfig({
  site: 'https://mitsachile.com',
  output: 'static',
  integrations: [sitemap({
    filter: (page) => !page.includes('/admin') && !page.includes('/preview'),
    changefreq: 'weekly',
    priority: 0.8,
    lastmod: new Date(),
  })],
  build: {
    format: 'directory'
  }
});
