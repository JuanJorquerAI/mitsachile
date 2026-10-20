# Estado de la migración SEO MITSA

**La migración técnica está activa y verificada. Queda pendiente enviar el Cambio de dirección en Search Console: su formulario abre en blanco en la sesión disponible.**

Origen: **https://mitsachile.com/** → destino canónico: **https://mitsa.org/**.

Corte aplicado el **20 de octubre de 2026, 18:56:47 America/Santiago (21:56:47 UTC)**, tras la aprobación explícita de Juan. No se cambiaron DNS ni correo corporativo.

## Lo implementado y comprobado

| Componente | Estado y evidencia |
|---|---|
| Redirecciones de páginas | 42 rutas con 301 al destino correspondiente, incluidas las URLs históricas de Productos, Representaciones, Noticias y sectores. Las variantes sin barra final se normalizan directamente. |
| Rutas retiradas | `/hello-world/` y `/a-sample-blog-post/` devuelven 410. `/trituradores-organicos/` conserva 404 al no existir un equivalente confirmado. Las rutas desconocidas también conservan un 404 real. |
| Recursos | 108 parejas de archivos comprobadas: 301 del origen y 200 en destino. Las 34 imágenes históricas recuperadas coinciden por SHA256 con la réplica local. El PDF SMM coincide por SHA256 con el original. |
| SMM 2026 | Landing, brochure y vCard recuperados en mitsa.org. Canonical, Open Graph, vínculos web y URL de la vCard actualizados. El correo del contacto conserva su dominio corporativo. |
| Indexación | Eliminado el bloqueo global de WordPress en mitsa.org. Hay 34 URLs indexables en el sitemap, con canonical correcto; se excluyen muestras, autores y Uncategorized. |
| Metadatos | Completadas las descripciones faltantes de cinco publicaciones, dos proyectos y la categoría de noticias. |
| Search Console | mitsa.org verificado; conservado el acceso de Juan, que ya era propietario del origen. Site Kit del destino utiliza la propiedad nueva. Sitemap enviado el 20/oct a las 21:57:32 UTC; Google lo dejó pendiente de procesamiento, sin errores reportados en el envío. |
| GA4 | Se conserva la propiedad `546711733`, el flujo `15305402446` y la medición `G-BNP4L272V2`. URL del flujo actualizada a mitsa.org. Google recibió **1 evento `seo_migration_check`** emitido desde el navegador en el dominio nuevo. |
| Formulario | Petición real con nonce, guardado de consulta y página de confirmación comprobados. Correo interceptado antes del transporte; no se probó entrega externa. Registro sintético, filtro y clave de prueba eliminados. |
| Operación del origen | Login, REST API, robots y sitemap siguen disponibles. Se conserva la instalación de WordPress para administración y reversión. |
| Monitoreo | Cron Hostinger `eV1MTMFDzg`, todos los días a las 11:30 UTC / 08:30 America/Santiago. Primer control y wrapper del cron: **51 comprobaciones aprobadas, cero fallos; GSC de ambos dominios accesible**. |
| Respaldos | Copias completas de archivos y bases de datos en servidor y equipo local, fuera del directorio público y de Git. SHA256 verificados. Reversión de enrutamiento preparada y probada en una ruta aislada. |

La aceptación del corte terminó con **292 comprobaciones aprobadas y cero fallos**. Abarca todas las rutas del mapa ampliado, las 108 parejas de recursos, destinos del sitemap, metadatos, parámetros, errores HTTP, variantes de dominio y accesos operativos. No demuestra que Google ya haya terminado de indexar ni garantiza posiciones futuras.

## Línea base de posicionamiento

Se exportó Search Console usando su conexión existente de Site Kit, sin extraer ni publicar credenciales. Se obtuvieron páginas, consultas y fechas para 16 meses, 90 días y 28 días, con fecha final **17/oct/2026** para dejar margen de procesamiento.

| Ventana | Clics, suma del informe diario | Impresiones, suma del informe diario |
|---|---:|---:|
| 90 días: 20/jul–17/oct | 76 | 883 |
| 28 días: 20/sep–17/oct | 41 | 328 |

El informe de páginas contiene 13 URLs históricas. En 90 días destacan la portada (70 clics), `/marina-e-industrial/` (5), `/nosotros/` (3) y `/productos/` (1). Se incorporaron al traslado las URLs que no aparecían en el sitemap vigente.

**Las agrupaciones no se reemplazaron entre sí:** la suma por páginas da 79 clics/1.468 impresiones en 90 días y 44/715 en 28 días. Para la línea base agregada se usa el informe diario; para priorizar URLs se conserva el informe por página. Los datos completos de Google y la exportación GA4 por hostname/canal/landing se mantienen en los respaldos privados. `linea-base-gsc-paginas.csv` contiene únicamente las URLs de MITSA y sus métricas.

El panel de GSC del origen mostraba 13 páginas indexadas antes del traslado. Ese dato es histórico y no representa páginas ya indexadas en el dominio nuevo.

## Corrección de la detección inicial de analítica

La auditoría previa buscaba identificadores `G-…` y `GTM-…`, y no detectaba el formato **Google tag `GT-…`**. Se comprobó la etiqueta `GT-577M5DL3` de Site Kit y su destino GA4 existente. Por tanto, no se concluye que faltara analítica: **se conservó la medición que ya existía**. La landing estática SMM recibió la misma etiqueta y la recepción del evento controlado se confirmó posteriormente con la API de Analytics.

## Pendiente para cerrar la declaración a Google

Está abierta la página:

[Search Console → Cambio de dirección de mitsachile.com](https://search.google.com/search-console/settings/change-address?resource_id=https%3A%2F%2Fmitsachile.com%2F).

En la sesión de Juan se pudo añadir mitsa.org como propiedad verificada y comprobar que Google no informa acciones manuales ni problemas de seguridad. Sin embargo, el formulario de Cambio de dirección queda completamente en blanco, incluso después de una recarga nativa. No se seleccionó un destino ni se envió una solicitud de traslado; **no existe confirmación de aceptación de ese trámite**.

Cuando cargue el formulario, falta seleccionar `https://mitsa.org/`, ejecutar sus comprobaciones y confirmar el traslado. Las redirecciones y los destinos ya están preparados. La revisión de retiradas y el inventario de enlaces externos del panel tampoco se completaron en esta sesión de navegador; conviene incorporarlos a esa revisión final. El objetivo permanece abierto por ese trabajo pendiente.

## Seguimiento y reversión

El monitoreo diario revisa 45 rutas del origen, seis destinos prioritarios y rendimiento GSC de ambos dominios. Guarda informes privados en `/home/u549101671/mitsa-seo-migration-20261020/daily/YYYY-MM-DD.json`; el resumen más reciente está en `monitor-last.log`. No envía mensajes ni altera automáticamente el sitio.

Revisiones de evolución previstas: **27/oct, 3/nov, 19/nov y 19/dic de 2026; 18/ene de 2027**. Comparar el rendimiento combinado de ambos dominios durante la transición. Después del día 90 se deben revisar los resultados y retirar el cron; el script deja de consultar sitios y Google a partir del día 91.

Mantener dominio antiguo, HTTPS y 301 al menos hasta **20/oct/2027**, preferiblemente de forma permanente por enlaces y material comercial existente.

La reversión puntual es `bash scripts/seo-migration/rollback-redirects.sh --apply`. Restablece el `.htaccess` previo, preservando las bases de datos actuales. No restaurar un dump antiguo para revertir únicamente el enrutamiento. Si posteriormente se envía Cambio de dirección, incluir su posible cancelación al evaluar una reversión.

## Evidencia entregada

- `verificacion-post-corte.json`: 292 pruebas, cero fallos.
- `preflight.json`: 52 pruebas de reglas aisladas.
- `destino-preparado.json`: 236 controles finales del destino; el primer resultado, con una descripción pendiente, se conserva en `destino-preparado-inicial.json`.
- `prueba-reversion.json`: cambio del destino aislado antiguo → nuevo después de restituir las reglas.
- `prueba-formulario.json` y `prueba-analytics.json`: comprobaciones del formulario y recepción real de Analytics.
- `linea-base-gsc-paginas.csv`: métricas por URL y ventana.
- `google-acciones-manuales.png` y `google-seguridad.png`: comprobaciones del destino en GSC.
- `../../../scripts/seo-migration/README.md`: herramientas, cron, respaldo y comandos operativos.

Los respaldos y exportaciones privadas están excluidos de Git. No se desplegó el frontend Astro, no se sustituyó el tema remoto `mitsa-v2` y no se publicaron los cinco artículos regulatorios pendientes de aprobación.
