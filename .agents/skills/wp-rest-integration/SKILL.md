---
name: wp-rest-integration
description: Guía y estándares para la integración entre WordPress REST API y el frontend desacoplado (Astro). Gobierna endpoints personalizados, serialización de ACF, contratos tipados en TypeScript/Zod, manejo de errores de red, timeouts y fallback resiliente sin caída de servicio.
---

# WP REST Integration Skill

Esta skill define la arquitectura de comunicación entre el backend WordPress (Headless/REST API) y el frontend desacoplado de MITSA (Astro SSG/SSR).

## Principios Fundamentales

1. **Desacoplamiento Resiliente**: El frontend jamás debe fallar o mostrar pantalla blanca si la API de WordPress está temporalmente inaccesible, lenta o devuelve datos corruptos.
2. **Contrato de Datos Estricto**: Todo endpoint expuesto en WordPress debe cumplir con un esquema tipado en TypeScript/Zod en el frontend.
3. **Administrabilidad Total**: Cada texto, imagen, enlace y configuración visual debe provenir de campos REST/ACF de WordPress.
4. **Caché y Rendimiento**: Las respuestas de la API deben incluir cabeceras de caché (`Cache-Control: public, max-age=300, stale-while-revalidate=86400`) y permitir generación estática (SSG) ultra-rápida.

## Estructura de Endpoints de MITSA

### Endpoint de Secciones Modulares
- **Ruta**: `GET /wp-json/mitsa/v1/sections/{page_slug}`
- **Descripción**: Devuelve la estructura modular completa de una página con todos sus bloques y metadatos SEO.
- **Campos devueltos**:
  - `page`: Identificador y título de la página.
  - `seo`: Metadatos SEO, Open Graph y Graph Schema.org JSON-LD.
  - `sections`: Array de secciones (`hero`, `triage`, `grid_proyectos`, `propuesta_valor`, `faqs`, etc.).

### Fallback y Manejo de Errores en Frontend

```typescript
export async function fetchSectionData<T>(endpoint: string, fallbackData: T): Promise<T> {
  const WP_URL = import.meta.env.PUBLIC_WP_URL || 'http://mitsa.local';
  const controller = new AbortController();
  const timeoutId = setTimeout(() => controller.abort(), 4000); // 4s timeout

  try {
    const res = await fetch(`${WP_URL}/wp-json/mitsa/v1/${endpoint}`, {
      headers: { 'User-Agent': 'Mitsa-Astro-Frontend/2.0' },
      signal: controller.signal
    });
    clearTimeout(timeoutId);

    if (!res.ok) {
      console.warn(`[WP-API Warning] HTTP ${res.status} al consultar ${endpoint}. Usando fallback local.`);
      return fallbackData;
    }

    const json = await res.json();
    return json as T;
  } catch (err) {
    clearTimeout(timeoutId);
    console.warn(`[WP-API Offline] No se pudo conectar con WordPress para ${endpoint}. Usando fallback estático.`);
    return fallbackData;
  }
}
```
