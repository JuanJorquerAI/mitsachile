# Protocolo de Resiliencia y Fallback Offline (Zero-Downtime Architecture)

Este documento detalla la estrategia de tolerancia a fallos del frontend ante caídas, reinicios o lentitud del servidor WordPress.

```mermaid
sequenceDiagram
    participant Front as Astro Frontend (SSG/SSR)
    participant Client as Resilient API Client
    participant WP as WordPress REST API
    participant Local as Static Fallback Store

    Front->>Client: Solicita datos de sección (ej. 'home-hero')
    Client->>WP: HTTP GET con timeout de 4000ms
    alt WordPress responde OK (200)
        WP-->>Client: Payload JSON válido
        Client->>Front: Datos normalizados de WordPress
    else Error de conexión, 500, o Timeout
        WP--xClient: Timeout o Error
        Client->>Local: Lee fallback tipado estático
        Local-->>Client: Objeto de datos por defecto (validado)
        Client-->>Front: Datos de fallback (Build continúa exitosamente)
    end
```

## Beneficios Clave

1. **Compilación Ininterrumpida**: Los deploys en CI/CD y las construcciones locales nunca fallan aunque el servidor local o remoto de WordPress esté temporalmente inactivo.
2. **Cero Degradación de Rendimiento**: El SSG genera el HTML completo independientemente del estado de la base de datos en tiempo real.
3. **Consistencia de Tipos**: Tanto los datos vivos de la API como los fallbacks comparten la misma interfaz de TypeScript, evitando excepciones por campos indefinidos en tiempo de ejecución.
