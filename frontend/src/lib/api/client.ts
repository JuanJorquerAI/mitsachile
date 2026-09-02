import type { PageSectionsResponse, NosotrosSectionsResponse, ServiciosSectionsResponse, IndustriasSectionsResponse, ProyectosSectionsResponse, RecursosSectionsResponse, ContactoSectionsResponse, RepresentadasSectionsResponse, SiteOptionsData } from './types.ts';
import { HOME_FALLBACK_DATA, NOSOTROS_FALLBACK_DATA, SERVICIOS_FALLBACK_DATA, INDUSTRIAS_FALLBACK_DATA, PROYECTOS_FALLBACK_DATA, RECURSOS_FALLBACK_DATA, CONTACTO_FALLBACK_DATA, REPRESENTADAS_FALLBACK_DATA, SITE_OPTIONS_FALLBACK_DATA } from './fallbacks.ts';

/**
 * URL base de WordPress REST API
 */
const getWpApiBase = () => {
  if (typeof process !== 'undefined' && process.env?.PUBLIC_WP_URL) {
    return process.env.PUBLIC_WP_URL.replace(/\/$/, '');
  }
  // @ts-ignore
  if (typeof import.meta !== 'undefined' && import.meta.env?.PUBLIC_WP_URL) {
    // @ts-ignore
    return import.meta.env.PUBLIC_WP_URL.replace(/\/$/, '');
  }
  return 'http://mitsa.local';
};

const DEFAULT_TIMEOUT_MS = 3500;

interface FetchOptions {
  timeoutMs?: number;
  retries?: number;
}

/**
 * Cliente HTTP resiliente con timeout, reintentos y fallback automático.
 */
export async function fetchWithResilience<T>(
  url: string,
  fallback: T,
  options: FetchOptions = {}
): Promise<T> {
  const { timeoutMs = DEFAULT_TIMEOUT_MS, retries = 1 } = options;

  for (let attempt = 0; attempt <= retries; attempt++) {
    const controller = new AbortController();
    const timer = setTimeout(() => controller.abort(), timeoutMs);

    try {
      const response = await fetch(url, {
        headers: {
          'User-Agent': 'Mitsa-Astro-Frontend/2.0',
          'Accept': 'application/json',
        },
        signal: controller.signal,
      });

      clearTimeout(timer);

      if (response.ok) {
        const json = await response.json();
        return json as T;
      }

      if (attempt === retries) {
        console.warn(`[WP-API Warning] HTTP ${response.status} al consultar ${url}. Usando fallback estático.`);
        return fallback;
      }
    } catch (err: any) {
      clearTimeout(timer);
      if (attempt === retries) {
        const reason = err?.name === 'AbortError' ? `Timeout (${timeoutMs}ms)` : (err?.message || 'Error de red');
        console.warn(`[WP-API Offline] Falló conexión a ${url} (${reason}). Activando fallback local.`);
        return fallback;
      }
    }
  }

  return fallback;
}

/**
 * Obtiene las secciones modulares de una página desde WordPress REST API con fallback.
 */
export async function getPageSections(slug: string): Promise<PageSectionsResponse> {
  const fallback = slug === 'home' || slug === 'inicio' ? HOME_FALLBACK_DATA : {
    slug,
    title: 'MITSA',
    seo: {
      meta_title: 'MITSA',
      meta_description: 'Tecnología marina y tratamiento de aguas.',
      canonical_url: `https://mitsachile.com/${slug}/`,
      og_image: 'https://mitsachile.com/images/plataforma-offshore-8886341c.jpg',
      og_type: 'website' as const,
    },
    sections: {},
  };

  const endpoint = `${getWpApiBase()}/wp-json/mitsa/v1/sections/${slug}`;
  return await fetchWithResilience<PageSectionsResponse>(endpoint, fallback);
}

/**
 * Helper para obtener los datos de la Home
 */
export async function getHomeSections(): Promise<PageSectionsResponse> {
  return await getPageSections('home');
}

/**
 * Helper para obtener los datos de la página Nosotros con tipado estricto
 */
export async function getNosotrosSections(): Promise<NosotrosSectionsResponse> {
  const endpoint = `${getWpApiBase()}/wp-json/mitsa/v1/sections/nosotros`;
  return await fetchWithResilience<NosotrosSectionsResponse>(endpoint, NOSOTROS_FALLBACK_DATA as NosotrosSectionsResponse);
}

/**
 * Helper para obtener los datos de la página Servicios con tipado estricto
 */
export async function getServiciosSections(): Promise<ServiciosSectionsResponse> {
  const endpoint = `${getWpApiBase()}/wp-json/mitsa/v1/sections/servicios`;
  return await fetchWithResilience<ServiciosSectionsResponse>(endpoint, SERVICIOS_FALLBACK_DATA as ServiciosSectionsResponse);
}

/**
 * Helper para obtener los datos de la página Industrias / Sectores con tipado estricto
 */
export async function getIndustriasSections(): Promise<IndustriasSectionsResponse> {
  const endpoint = `${getWpApiBase()}/wp-json/mitsa/v1/sections/industrias`;
  return await fetchWithResilience<IndustriasSectionsResponse>(endpoint, INDUSTRIAS_FALLBACK_DATA as IndustriasSectionsResponse);
}

/**
 * Helper para obtener los datos de la página Proyectos con tipado estricto
 */
export async function getProyectosSections(): Promise<ProyectosSectionsResponse> {
  const endpoint = `${getWpApiBase()}/wp-json/mitsa/v1/sections/proyectos`;
  return await fetchWithResilience<ProyectosSectionsResponse>(endpoint, PROYECTOS_FALLBACK_DATA as ProyectosSectionsResponse);
}

/**
 * Helper para obtener los datos de la página Recursos con tipado estricto
 */
export async function getRecursosSections(): Promise<RecursosSectionsResponse> {
  const endpoint = `${getWpApiBase()}/wp-json/mitsa/v1/sections/recursos`;
  return await fetchWithResilience<RecursosSectionsResponse>(endpoint, RECURSOS_FALLBACK_DATA as RecursosSectionsResponse);
}

/**
 * Helper para obtener los datos de la página Contacto con tipado estricto
 */
export async function getContactoSections(): Promise<ContactoSectionsResponse> {
  const endpoint = `${getWpApiBase()}/wp-json/mitsa/v1/sections/contacto`;
  return await fetchWithResilience<ContactoSectionsResponse>(endpoint, CONTACTO_FALLBACK_DATA as ContactoSectionsResponse);
}

/**
 * Helper para obtener los datos de la página Representadas con tipado estricto
 */
export async function getRepresentadasSections(): Promise<RepresentadasSectionsResponse> {
  const endpoint = `${getWpApiBase()}/wp-json/mitsa/v1/sections/representadas`;
  return await fetchWithResilience<RepresentadasSectionsResponse>(endpoint, REPRESENTADAS_FALLBACK_DATA as RepresentadasSectionsResponse);
}

/**
 * Helper para obtener las opciones globales del sitio (Marca, Header, Footer, Contacto, Redes)
 */
export async function getSiteOptions(): Promise<SiteOptionsData> {
  const endpoint = `${getWpApiBase()}/wp-json/mitsa/v1/options`;
  return await fetchWithResilience<SiteOptionsData>(endpoint, SITE_OPTIONS_FALLBACK_DATA as SiteOptionsData);
}
