# Migración SEO MITSA — 20 de octubre de 2026

Producción canónica: **https://mitsa.org/**. El origen mantiene WordPress y sus accesos administrativos; las páginas migradas responden 301 antes de cargar WordPress. El tema real es `mitsa-v2` en Hostinger. Este trabajo no desplegó el tema local antiguo ni el frontend Astro.

## Componentes

- `../../wp-content/mu-plugins/mitsa-seo-migration.php`: equivalencias históricas en el destino, política de archivos, respuestas 410 para muestras retiradas e incorporación del sitemap SMM.
- `build-redirects.php` / `redirects.htaccess`: genera el bloque del origen a partir del mapa aprobado y añade `/productos/`, detectada en GSC. Solo actúa sobre el host antiguo y GET/HEAD. Conserva query strings. Los archivos solo se trasladan si existen en el destino; las rutas desconocidas conservan la respuesta de WordPress.
- `prepare-site.php`: preparación de visibilidad y metadatos con estado previo guardado. Es de ejecución única y rechaza otro dominio o la ausencia de respaldos.
- `sitekit-export.php`: exportación GSC por página, consulta y fecha con la autorización existente; no expone credenciales.
- `google-services.php`: operaciones acotadas de verificación, sitemap y continuidad de GA4. Se ejecuta en el WordPress antiguo como usuario 1; mantiene su propiedad GSC antigua. El Site Kit de mitsa.org quedó asociado a la propiedad nueva.
- `recovered-resources.json`: procedencia y SHA256 de las 34 imágenes históricas recuperadas de la réplica local.
- `verify.py`: aceptación externa de reglas aisladas, destino y estado posterior al corte. Ejecutar con `uv run`.
- `cutover.sh`: comprueba las puertas de aceptación y los respaldos, detecta cambios concurrentes y cambia `.htaccess` de forma atómica. Comprueba portada y Nosotros desde fuera del servidor y revierte si fallan.
- `rollback-redirects.sh`: restituye solo el enrutamiento anterior, sin restaurar una base antigua sobre consultas nuevas.
- `monitor.php` / `monitor-map.json` / `run-monitor.sh`: monitoreo diario de 45 rutas, seis destinos prioritarios y GSC de ambos dominios. La ventana de consulta es de 28 días, termina tres días antes y usa datos finales. Los informes se guardan fuera del directorio público.

## Evidencia y respaldos

Informe y comprobaciones: `docs/entregables/migracion-seo-mitsa-org-2026-10-20/`.

Los archivos completos y dumps **contienen secretos y datos del sitio**: permanecen en la ruta local ignorada por Git **`<repositorio>/.seo-backups/migration-20261020/`**. En el servidor están en **`/home/u549101671/mitsa-seo-migration-20261020/`**, fuera de `public_html`. Se verificaron SHA256 de los cuatro archivos comprimidos descargados. No incorporar estos respaldos a Git ni publicarlos.

El corte ocurrió a las **2026-10-20 21:56:47 UTC = 18:56:47 America/Santiago**. El snapshot de enrutamiento inmediatamente anterior es `mitsachile.com.pre-cutover.htaccess`.

## Aceptación

```sh
uv run scripts/seo-migration/verify.py --mode after \
  --output docs/entregables/migracion-seo-mitsa-org-2026-10-20/verificacion-post-corte.json
```

La aceptación inicial pasó 52 pruebas de reglas; el destino pasó 236. La aceptación posterior pasó 292. El primer examen del destino tuvo una descripción de categoría ausente; se conserva ese resultado como `destino-preparado-inicial.json`. Se corrigió el índice de término de Yoast mediante el hook normal de actualización de WordPress y se comprobó la salida sin y con bypass de caché.

El formulario se verificó con una petición real, nonce público, guardado de consulta y confirmación. Un filtro temporal y autenticado interceptó el correo antes del transporte. Se comprobó el registro capturado y luego se eliminó únicamente la consulta sintética. No es una prueba de entrega externa de correo. El mu-plugin de prueba y su clave se retiraron.

## Monitoreo

Hostinger cron UID **`eV1MTMFDzg`**: `30 11 * * *` UTC, **08:30 America/Santiago** durante esta ventana de seguimiento. Comando:

```text
/bin/sh /home/u549101671/mitsa-seo-migration-20261020/run-monitor.sh
```

Usa `flock`, permisos privados y la autorización existente de Site Kit. No envía correos ni cambia configuraciones automáticamente. Último resumen: `monitor-last.log`; snapshots: `daily/YYYY-MM-DD.json`. El primer control tuvo **51 pruebas aprobadas y cero fallos**, con lecturas GSC de ambos dominios correctas. La ejecución del wrapper exacto del cron también fue comprobada.

Revisiones de evolución: 27/oct, 3/nov, 19/nov y 19/dic de 2026; 18/ene de 2027 (días 7, 14, 30, 60 y 90). Comparar clics e impresiones combinados de ambos dominios, consultas importantes y nuevas exclusiones. Desde el día 91 el script deja de consultar sitios y Google; retirar el cron documentado al cerrar ese seguimiento. Los snapshots diarios no sustituyen la revisión profesional ni constituyen una promesa de posiciones.

Conservar `mitsachile.com`, SSL y las redirecciones al menos hasta el 20/oct/2027; preferiblemente indefinidamente por enlaces y materiales comerciales existentes.

## Reversión del enrutamiento

```sh
bash scripts/seo-migration/rollback-redirects.sh --apply
```

Está preparada con el snapshot real y el mecanismo atómico fue probado en la ruta aislada: al retirar el bloque, la ruta volvió al destino WordPress del dominio antiguo; al restituirlo, volvió el 301 hacia mitsa.org. No usar el dump previo para deshacer redirecciones, porque sobrescribiría consultas posteriores. Si Google ya aceptó el Cambio de dirección, evaluar también su cancelación en Search Console durante una reversión real.

No repetir `cutover.sh` sobre un origen que ya contiene el bloque. No repetir `prepare-site.php` ignorando su guardia de estado. Los cinco artículos regulatorios de `content/08`–`12` conservan su flujo independiente de aprobación: esta migración no los publicó.
