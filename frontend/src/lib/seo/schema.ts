import type { PageSectionsResponse, FaqItemData } from '../api/types.ts';

export interface BreadcrumbItem {
  name: string;
  url: string;
}

/**
 * Genera el grafo unificado de Schema.org (@graph) para la página actual.
 */
export function generateSchemaGraph(options: {
  url: string;
  title: string;
  description: string;
  image?: string;
  faqs?: FaqItemData[];
  breadcrumbs?: BreadcrumbItem[];
}) {
  const { url, title, description, image, faqs = [], breadcrumbs = [] } = options;

  const orgId = 'https://mitsachile.com/#organization';
  const websiteId = 'https://mitsachile.com/#website';
  const webpageId = `${url}#webpage`;

  const graph: any[] = [
    {
      '@type': 'Organization',
      '@id': orgId,
      name: 'MITSA SpA',
      url: 'https://mitsachile.com',
      logo: {
        '@type': 'ImageObject',
        '@id': 'https://mitsachile.com/#logo',
        url: 'https://mitsachile.com/images/mitsa-27703545.svg',
        contentUrl: 'https://mitsachile.com/images/mitsa-27703545.svg',
        caption: 'MITSA SpA Logo',
      },
      foundingDate: '1982',
      description: 'Soluciones de tratamiento de aguas, ingeniería sanitaria marina, protección catódica ICCP y tecnologías ambientales.',
      address: {
        '@type': 'PostalAddress',
        addressLocality: 'Viña del Mar',
        addressRegion: 'Valparaíso',
        addressCountry: 'CL',
      },
      contactPoint: {
        '@type': 'ContactPoint',
        contactType: 'Ventas y Soporte Técnico',
        email: 'contacto@mitsachile.com',
        telephone: '+56-32-2835055',
        areaServed: ['CL', 'PE', 'AR', 'Latinoamérica'],
        availableLanguage: ['Spanish', 'English'],
      },
    },
    {
      '@type': 'WebSite',
      '@id': websiteId,
      url: 'https://mitsachile.com',
      name: 'MITSA',
      description: 'Tecnología marina y tratamiento de aguas para la industria naval, acuícola e industrial.',
      publisher: { '@id': orgId },
      inLanguage: 'es-CL',
    },
    {
      '@type': 'WebPage',
      '@id': webpageId,
      url: url,
      name: title,
      description: description,
      isPartOf: { '@id': websiteId },
      about: { '@id': orgId },
      inLanguage: 'es-CL',
      ...(image ? { primaryImageOfPage: { '@type': 'ImageObject', url: image } } : {}),
    },
  ];

  // Si hay FAQs, agregamos FAQPage entity
  if (faqs && faqs.length > 0) {
    graph.push({
      '@type': 'FAQPage',
      '@id': `${url}#faq`,
      isPartOf: { '@id': webpageId },
      mainEntity: faqs.map((faq) => ({
        '@type': 'Question',
        name: faq.question,
        acceptedAnswer: {
          '@type': 'Answer',
          text: faq.answer,
        },
      })),
    });
  }

  // Si hay Breadcrumbs, agregamos BreadcrumbList
  if (breadcrumbs && breadcrumbs.length > 0) {
    graph.push({
      '@type': 'BreadcrumbList',
      '@id': `${url}#breadcrumb`,
      itemListElement: breadcrumbs.map((crumb, index) => ({
        '@type': 'ListItem',
        position: index + 1,
        name: crumb.name,
        item: crumb.url,
      })),
    });
  }

  return {
    '@context': 'https://schema.org',
    '@graph': graph,
  };
}

/**
 * Normaliza y construye metadatos SEO completos a partir de la respuesta de secciones de WP.
 */
export function buildPageSeo(pageData: PageSectionsResponse, currentUrl: string) {
  const metaTitle = pageData.seo?.meta_title || pageData.title || 'MITSA';
  const metaDescription = pageData.seo?.meta_description || 'Tecnología marina y tratamiento de aguas.';
  const ogImage = pageData.seo?.og_image || 'https://mitsachile.com/images/plataforma-offshore-8886341c.jpg';
  const canonicalUrl = pageData.seo?.canonical_url || currentUrl;
  const faqs = Array.isArray(pageData.sections?.faqs)
    ? pageData.sections.faqs
    : (pageData.sections?.faqs?.items || []);

  const jsonLd = generateSchemaGraph({
    url: canonicalUrl,
    title: metaTitle,
    description: metaDescription,
    image: ogImage,
    faqs,
  });

  return {
    title: metaTitle,
    description: metaDescription,
    canonicalUrl,
    image: ogImage,
    type: pageData.seo?.og_type || 'website',
    jsonLd,
  };
}
