# Preview de la réplica para el cliente — Local by WP Engine (Live Link)

Montar la **réplica** (hoy en `wpactual/`, servida con `php -S` en `localhost:8892`)
dentro de **Local by WP Engine** para exponerla al cliente por **Live Link**, sin
tocar producción ni depender de `php -S`.

> **Por qué Local y no un túnel directo:** el dev server `php -S` no atiende bien el
> tráfico proxiado de un túnel (abre y cierra las conexiones sin servir el request →
> 404). Local corre **nginx + php-fpm reales**, que sí manejan el proxy; su Live Link
> está hecho exactamente para esto (es la Fase 6 de `plans/migracion-php-wp-2026-07.md`).

## Artefactos ya preparados (en `staging/`, gitignoreado)

| Archivo | Qué es |
|---|---|
| `staging/mitsa-replica.sql` | Dump completo de la BD `mitsa_actual` (172 KB). |
| `staging/mitsa-replica-wp-content.tgz` | `wp-content/themes/mitsa` + `wp-content/uploads` (8.1 MB). |

Assets clave verificados en el dump: hero (attachment 58 `mitza-1.jpg`), cards de
Productos (61/62), logos de representadas (17…). Plugins: ninguno activo (solo
akismet/hello inactivos → no hay que instalar nada).

---

## Pasos (los ejecutas tú en la app Local)

### 1. Crear el sitio en Local
- Local → **+** (Create a new site) → nombre: **`mitsa-replica`**.
- Entorno **Custom** → **PHP 8.x** (la réplica es WP 7.0.1 / PHP 8) → web server
  **nginx** (default) → MySQL el que sugiera.
- Usuario/clave admin cualquiera (se sobrescribe con el dump).
- Local levanta el sitio en un dominio local, p. ej. `http://mitsa-replica.local`.
  **Anota ese dominio** — lo usas en el paso 4.

### 2. Volcar los archivos (tema + uploads)
- Clic derecho sobre el sitio → **Reveal in Finder** → entra a `app/public/`.
- Descomprime el bundle dentro de `app/public/wp-content/`:
  ```bash
  tar -xzf "<ruta-al-repo>/staging/mitsa-replica-wp-content.tgz" \
      -C "<ruta-Local>/mitsa-replica/app/public/wp-content/"
  ```
  Debe quedar `app/public/wp-content/themes/mitsa/` y `app/public/wp-content/uploads/…`.
- **No copies** el `wp-config.php` de `wpactual/` — se queda el de Local (tiene las
  credenciales de la BD de Local).

### 3. Importar la base de datos
- En Local, sitio `mitsa-replica` → **Open site shell** (trae wp-cli incluido):
  ```bash
  wp db import "<ruta-al-repo>/staging/mitsa-replica.sql"
  ```
- Activa el tema por si acaso: `wp theme activate mitsa`.

### 4. Apuntar las URLs al dominio de Local
El dump trae URLs `http://localhost:8892`. En el **site shell** de Local:
```bash
wp search-replace 'http://localhost:8892' 'http://mitsa-replica.local' --all-tables --skip-columns=guid
wp cache flush
```
> Reemplaza `mitsa-replica.local` por el dominio EXACTO que te dio Local en el paso 1.

Abre el sitio (**Open site**) y verifica que carga con logo, hero y las páginas
(Nosotros, Productos, Representaciones, Contacto, Noticias). Si el admin pide
actualizar la BD, dale **"Actualizar base de datos de WordPress"** (salto de versión de core).

### 5. Compartir con el cliente (Live Link)
- Con el sitio corriendo → botón **Live Link** (arriba a la derecha) → **Enable**.
- Local genera una URL pública temporal (y opcional usuario/clave básica). Esa es la
  que le pasas a Francisco/Francisca.
- Live Link reescribe el Host automáticamente → no hay que tocar `WP_HOME` a mano.
- **Deshabilita** el Live Link al terminar la revisión (es un túnel temporal, no hosting).

---

## Notas
- Es un preview de revisión, no producción. La ruta a producción real (subir PHP en
  cPanel + WP limpio + cargar este contenido) sigue en `plans/migracion-php-wp-2026-07.md`.
- El `php -S` de `wpactual/` en `localhost:8892` puede seguir corriendo en paralelo; Local
  es un entorno aislado (nginx/php-fpm + su propia BD), no choca.
- Si prefieres una URL **estable** (no temporal) para que el cliente la abra varios días,
  hay que ir a un named tunnel con dominio propio o a staging en el hosting — avísame.
