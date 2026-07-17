# Guía: montar el sitio legacy de mitsachile.com en Local by WP Engine

Esta guía describe cómo levantar una **copia del sitio WordPress ACTUAL de
producción** (`mitsachile.com`, el sitio viejo) dentro de la app **Local by WP
Engine**, para inspeccionarlo, probar su compatibilidad con PHP 8.x y compartir
un preview con el cliente — todo **sin tocar producción**.

> **Estado de esta guía:** esqueleto funcional. Los pasos están listos para
> ejecutarse en cuanto haya acceso (credenciales FTP/cPanel en `.env`). Nada
> aquí se ejecuta automáticamente contra producción.

---

## Regla de aislamiento (leer primero)

- El sitio legacy migrado vive **SOLO dentro de Local by WP Engine**. Local
  gestiona su propio nginx/Apache + PHP + MySQL en un entorno aislado.
- **NO se mezcla** con el sitio NUEVO del repo, que corre con `php -S` en el
  puerto **8891** (ver `scripts/setup-wp.sh` / `scripts/provision.sh`). Ese
  puerto y ese entorno **no se tocan**.
- No montamos la base de datos "a mano" con `mysql` local del repo: usamos el
  importador de BD que trae **Local** (Adminer / Open site shell), para no
  contaminar el entorno del sitio nuevo.
- Los archivos descargados quedan en `staging/legacy-download/` (gitignoreado)
  y de ahí se copian al sitio de Local. El repo nunca versiona el sitio viejo.

---

## Paso 0 — Descargar los archivos de producción

Usa el script del repo (documentación en su cabecera):

```bash
# 1) Validar configuración sin conectar a producción:
bash scripts/legacy-descarga.sh --dry-run

# 2) Descarga real (a staging/legacy-download/):
bash scripts/legacy-descarga.sh
```

Requiere `.env` con `MITSA_FTP_*` o, en su defecto, las `MITSA_CPANEL_*` ya
presentes. Necesita `lftp` (`brew install lftp`).

Al terminar tendrás en `staging/legacy-download/` el docroot completo:
`wp-config.php`, `wp-content/` (temas, plugins, **uploads**), `.htaccess`, etc.

---

## Paso 1 — Obtener el DUMP de la base de datos de producción

La BD **no** viaja por FTP; hay que exportarla aparte. Dos caminos, en orden de
preferencia por riesgo:

### Opción A (recomendada, bajo riesgo): phpMyAdmin de cPanel → Export SQL

1. Entra a cPanel de `mitsachile.com` (`MITSA_CPANEL_URL`, p. ej.
   `https://mitsachile.com:2083`) → **Bases de datos → phpMyAdmin**.
2. En el panel izquierdo, selecciona la base de datos de WordPress (su nombre
   está en `wp-config.php`, variable `DB_NAME`, dentro de
   `staging/legacy-download/wp-config.php`).
3. Pestaña **Export** → método **Custom** →
   - Formato: **SQL**.
   - Marca **Add DROP TABLE / VIEW / PROCEDURE...** (para que el import sea
     re-ejecutable).
   - Compresión: **gzip** (si la BD es grande) o **None**.
4. **Go** → se descarga un `.sql` (o `.sql.gz`).
5. Guárdalo en `staging/` del repo (p. ej. `staging/mitsa-legacy.sql`).
   Ese `.sql` **está gitignoreado** (`*.sql` y `staging/` en `.gitignore`) — no
   se commitea.

> Nota: phpMyAdmin es lo más seguro porque **solo lee** la BD y no instala nada
> en producción.

### Opción B (evaluar riesgo): plugin de migración en producción

All-in-One WP Migration o Duplicator generan un paquete único (archivos + BD).
**Riesgo real a evaluar antes de usarlos:**

- **PHP 5.4 en producción.** Producción muy probablemente corre una versión de
  PHP antigua (5.4/5.6). Las versiones ACTUALES de estos plugins **requieren
  PHP 7.x+** y fallarán o romperán el panel al activarse. Si se usa esta vía,
  hay que instalar una **versión antigua compatible** del plugin, lo que suma
  riesgo y superficie de ataque en un WordPress viejo.
- **Recursos del hosting.** Duplicator empaqueta todo el sitio en el servidor;
  en hosting compartido puede agotar memoria/tiempo y **tumbar el sitio** o
  dejar archivos temporales pesados.
- **Instalar un plugin en producción es intrusivo** (modifica la BD, deja
  rastros). Va en contra del principio "no tocar producción".

**Recomendación:** usar **Opción A (phpMyAdmin + FTP)** salvo que phpMyAdmin no
esté disponible o la BD sea inmanejable por su tamaño. Si se opta por B,
documentar la versión exacta del plugin instalada y desinstalarla al terminar.

---

## Paso 2 — Averiguar la versión de PHP de producción

Para que el sitio **arranque igual que en producción**, el sitio de Local debe
empezar con la **misma major de PHP**. Cómo averiguarla:

- cPanel → **Software → Select PHP Version** (o **MultiPHP Manager**): muestra
  la versión asignada al dominio (p. ej. 5.6 / 7.0).
- O revisa `staging/legacy-download/` en busca de un `.htaccess` / `php.ini`
  con handlers tipo `ea-php56`.
- O, si el sitio sigue vivo, sube un `phpinfo()` temporal (y bórralo enseguida).

Anota esa versión; la usarás en el Paso 3.

---

## Paso 3 — Crear un sitio NUEVO en Local con esa versión de PHP

1. Abre **Local by WP Engine** → botón **+** (Create a new site).
2. Nombre: `mitsa-legacy` (queda claro que es el sitio viejo).
3. Elige **Custom** como entorno (no "Preferred") para poder fijar la versión.
4. **PHP version:** selecciona la major **igual a producción** (Paso 2). Si
   Local no ofrece exactamente 5.4/5.6, elige la más cercana disponible
   (normalmente 7.4) y anótalo: puede que haya que ajustar código legacy.
5. Web server: **nginx** o **Apache** (Apache es más parecido a cPanel y respeta
   `.htaccess`; si el sitio depende de reglas `.htaccess`, elige Apache).
6. MySQL: la versión que Local sugiera está bien.
7. Crea el sitio con usuario/clave de admin cualquiera (lo sobrescribiremos con
   la BD de producción de todos modos).

Local levanta un WordPress limpio en su propio dominio local
(p. ej. `http://mitsa-legacy.local`), **aislado** del `php -S` del repo.

---

## Paso 4 — Volcar los archivos descargados en `app/public/`

Cada sitio de Local tiene una carpeta. En Local: clic derecho sobre el sitio →
**Reveal in Finder** → entra a `app/public/`.

1. **Vacía** `app/public/` del WordPress limpio que creó Local (borra su
   contenido) para no mezclar versiones de core.
2. Copia **todo** el contenido de `staging/legacy-download/` (lo que era el
   docroot de producción) dentro de `app/public/`.
   - Debe quedar `app/public/wp-config.php`, `app/public/wp-content/…`, etc.
3. Ajusta `app/public/wp-config.php` con los datos de BD **de Local** (no los de
   producción). Los valores locales están en Local → pestaña **Database** del
   sitio, o usa los que Local inyecta por defecto (`DB_NAME`, `DB_USER=root`,
   `DB_PASSWORD=root`, `DB_HOST=localhost`). Deja `WP_HOME`/`WP_SITEURL` sin
   forzar por ahora (los corrige el search-replace del Paso 6).

---

## Paso 5 — Importar la BD con el importador de Local (Adminer)

**No** uses el `mysql` del sistema ni el del sitio nuevo del repo. Usa el que
trae Local:

1. En Local, selecciona el sitio `mitsa-legacy` → pestaña **Database** →
   **Open Adminer** (Local incluye Adminer embebido).
2. En Adminer, selecciona la base de datos del sitio (Local ya la creó).
3. **Import** → elige tu dump `staging/mitsa-legacy.sql` (descomprime el `.gz`
   antes si aplica) → ejecutar.
   - Alternativa por consola de Local: clic derecho en el sitio → **Open site
     shell**, y ahí `wp db import /ruta/al/dump.sql` (WP-CLI viene incluido en
     el shell de Local). Esto también queda **dentro** del entorno de Local.

---

## Paso 6 — Corregir URLs (search-replace)

La BD trae las URLs de producción (`https://mitsachile.com`). Hay que
apuntarlas al dominio de Local. Desde **Open site shell** de Local:

```bash
wp search-replace 'https://mitsachile.com' 'http://mitsa-legacy.local' --all-tables --skip-columns=guid
wp cache flush
```

Ajusta el dominio destino al que Local le haya asignado al sitio. Tras esto,
abre el sitio desde Local (**Open site**) y verifica que carga.

---

## Paso 7 — Probar la subida de PHP a 8.x (dentro de Local)

Una vez el sitio arranca en su PHP original, prueba la compatibilidad con PHP
moderno **sin salir de Local**:

1. Selecciona el sitio en Local → en la vista del sitio, la **versión de PHP se
   cambia desde la pestaña/campo del sitio** (Local permite cambiar la PHP
   version del sitio ya creado). Cambia a **8.1 / 8.2 / 8.3**.
2. Local reinicia el servicio; recarga el sitio y navega admin + frontend.
3. Anota errores/deprecations (plugins/tema legacy que rompen en PHP 8). Esto
   informa cuánto trabajo de compatibilidad implica migrar el contenido al
   sitio nuevo.
4. Si algo rompe, **vuelve a bajar la versión de PHP** desde el mismo control;
   el sitio es desechable y aislado, no pasa nada.

> Este experimento de PHP 8.x es **solo diagnóstico**. El sitio productivo real
> será el NUEVO (repo, tema `mitsa`), no esta copia legacy.

---

## Paso 8 — Compartir preview con el cliente (Live Link de Local)

Local ofrece **Live Link** (túnel ngrok integrado) para exponer el sitio local
por una URL pública temporal:

1. En Local, con el sitio corriendo, botón **Live Link** (arriba a la derecha) →
   **Enable**.
2. Local genera una URL pública (`https://algo.tunnel.wpengine.com` o similar) y
   opcionalmente usuario/clave básica. Compártela con Francisco/Francisca para
   que revisen la copia.
3. **Deshabilita** el Live Link cuando termines la sesión de revisión (es un
   túnel temporal; no es hosting permanente).

> Live Link es ideal para "mira cómo se ve hoy el sitio viejo" sin subir nada a
> ningún servidor. Para el preview del sitio NUEVO existe además
> `scripts/export-estatico.sh` (copia estática) — no confundir ambos flujos.

---

## Resumen de aislamiento (recordatorio final)

| Entorno | Qué es | Cómo corre | Puerto/dominio |
|---|---|---|---|
| Sitio NUEVO (repo) | Rediseño MITSA, tema `mitsa` | `php -S` (`setup-wp.sh`) | `localhost:8891` |
| Sitio LEGACY (esta guía) | Copia del `mitsachile.com` actual | Local by WP Engine | `*.local` / Live Link |

Los dos entornos son independientes. Nada de esta guía toca el puerto 8891 ni
la BD del sitio nuevo, y nada toca producción salvo **lecturas** (FTP de solo
descarga + export de phpMyAdmin).
