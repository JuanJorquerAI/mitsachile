# Decisiones — proyecto MITSA

Log vivo. Actualizar cuando se resuelva algo o llegue el "documento maestro" del cliente.

## Tomadas

| Fecha | Decisión | Fuente |
|---|---|---|
| 2026-06-30 | Contenido: brochure prioridad sobre sitio actual en caso de conflicto | Reunión inicial + MITSA_Mapa_del_sitio.pdf |
| 2026-07-08 | Marca a proyectar: "MITSA" (no "MITSA Chile") | Hilo "Inicio proyecto MITSA" |
| 2026-06-18/22 | Cliente propietario de todos los activos digitales | Hilo "Ideas para potenciar..." |
| 2026-06-18 | GA4 + GSC + GTM desde el lanzamiento | Hilo "Ideas para potenciar..." |
| — | Stack: WordPress, tema custom sin page builder | Propuesta de rediseño |
| 2026-07-12 | Fee mensual de mantención: parte comercial zanjada directamente por Juan (fuera de este repo) | Juan, sesión 2026-07-12 |
| 2026-07-12 | Sin documento maestro: seguir construyendo sobre contenido borrador ya generado, ajustar cuando llegue | Juan, sesión 2026-07-12 |
| 2026-07-12 | Página Contacto: solo formulario + dirección confirmada, sin teléfono/email hasta que el cliente los entregue | Juan, sesión 2026-07-12 |
| 2026-07-12 | Dominio: asumir mitsachile.com hasta aviso contrario del cliente | Juan, sesión 2026-07-12 |

## Abiertas — requieren decisión del cliente o de Juan/Luis (NO resolver solo)

1. **Secciones pendientes de validar con Luis/cliente**: Representadas (directorio de marcas), Sectores, Servicios, Contacto — hoy son hipótesis de Luis Silva más borrador generado en esta sesión, no contenido confirmado por el cliente.
2. **Nombre de categoría "Contenedores para Supermercados / trituradores orgánicos"**: bug de URL detectado (`/trituradores-organicos/`), revisar en CMS actual antes de migrar.
3. **Biblioteca técnica**: qué documentos van con gate de formulario de contacto vs. acceso libre — pendiente de definir por sección.
4. **Casos de éxito**: nombrar clientes reales (Armada de Chile, ASMAR, astilleros privados, salmoneras, navieras) cuando sea posible; usar "casos representativos" por industria solo si hay problema de confidencialidad puntual (acordado en el hilo de correo del 18-jun).
5. **Marcas "Ervor" (Finlandia) y "EGGE" (Suiza)**: aparecen en el brochure pero no estaban en la lista original de representadas del cliente — incluidas en `content/04-representadas.md` marcadas "por confirmar", validar antes de publicar.
6. **Teléfono/email corporativo de MITSA**: no existe en ninguna fuente disponible (brochure, correos, mapas). Página de Contacto sale solo con formulario hasta que el cliente lo entregue (ver decisión arriba).

## Notas de seguridad

- Credenciales de hosting (cPanel, GoDaddy, BlueHosting, NIC Chile) llegaron en texto plano por correo (`docs/Correo de AplicacionesWeb - Inicio proyecto MITSA.pdf`). Ese PDF está en `.gitignore`. Recomendar al cliente/agencia rotar esas contraseñas y moverlas a un gestor de secretos — quedaron expuestas en un hilo de correo con múltiples destinatarios.
