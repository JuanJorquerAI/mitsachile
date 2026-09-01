/**
 * Cliente para consumir WordPress REST API (LocalWP o Producción)
 * con fallback automático a los contenidos locales en markdown.
 */

const WP_URL = import.meta.env.PUBLIC_WP_URL || 'http://mitsa.local';

export async function fetchWpEndpoint<T>(endpoint: string): Promise<T | null> {
  try {
    const res = await fetch(`${WP_URL.replace(/\/$/, '')}/wp-json/wp/v2/${endpoint.replace(/^\//, '')}`, {
      headers: {
        'User-Agent': 'Mitsa-Astro-Frontend/1.0'
      },
      signal: AbortSignal.timeout(3000)
    });
    if (!res.ok) return null;
    return await res.json() as T;
  } catch {
    // Si LocalWP está apagado o no responde, devuelve null para usar fallback local
    return null;
  }
}

export async function getWpPosts() {
  return await fetchWpEndpoint<any[]>('posts?_embed&per_page=20');
}

export async function getWpPages() {
  return await fetchWpEndpoint<any[]>('pages?per_page=50');
}
