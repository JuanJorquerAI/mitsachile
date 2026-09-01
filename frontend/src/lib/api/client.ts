import type { PageSectionsResponse } from './types.ts';
import { HOME_FALLBACK_DATA } from './fallbacks.ts';

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
