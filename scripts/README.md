# Scripts — ambiente local mitsachile

Automatiza el ambiente WordPress local descrito en
`wp-content/themes/mitsa/README.md`. Todo vive fuera del control de versiones
salvo estos scripts: WordPress core, `wp-config.php`, la base de datos y los
plugins se recrean en `wp/` (gitignoreado) cada vez que hace falta.

## Prerrequisitos

- macOS con Homebrew.
- PHP >= 8.0 (`brew install php`) — probado con PHP 8.5.
- MariaDB o MySQL (`brew install mariadb`).
- Autenticación por socket Unix habilitada para el usuario del sistema en
  MariaDB (comportamiento por defecto de `brew install mariadb`: el usuario
  del SO conecta como admin sin password vía `mysql`). Si tu instalación
  pide password para `root`, usa tu propio usuario del sistema — el script
  no usa `root`, solo crea un usuario `mitsa_dev` dedicado.
- `wp-cli` y `mailpit` — los instala `setup-wp.sh` si faltan.

**Nota bash 3.2**: macOS trae `/bin/bash` 3.2 de serie (sin arrays
asociativos). Los scripts están escritos a propósito para ser compatibles
con esa versión — no asumir Homebrew bash instalado.

**Nota memory_limit**: el PHP CLI por defecto (128M) no alcanza para que
`wp-cli` extraiga el tarball de WordPress 7.x. Por eso existe
`scripts/wpcli.sh`, un wrapper que sube `memory_limit` a 512M. Usar siempre
ese wrapper, nunca `wp` directo, dentro de estos scripts.

## Uso

```bash
# Una sola vez (o si se borró wp/): instala herramientas, crea la BD,
# descarga e instala WordPress.
bash scripts/setup-wp.sh

# Cada vez que se quiera dejar el sitio al día: activa el tema, instala
# plugins (ACF free, Contact Form 7), crea páginas/menús del sitemap,
# configura permalinks, levanta el servidor PHP local y Mailpit.
# Idempotente — se puede correr tantas veces como se quiera.
bash scripts/provision.sh
```

Tras `provision.sh`:

- Sitio: http://localhost:8891/
- wp-admin: usuario `admin`, password `mitsa_admin_local`
- Mailpit (bandeja de correo local, captura todo `wp_mail`): http://localhost:8025/

Variables de entorno opcionales (mismas en ambos scripts):

| Variable | Default | Uso |
|---|---|---|
| `MITSA_DB_NAME` | `mitsa_dev` | Nombre de la base de datos local |
| `MITSA_DB_USER` | `mitsa_dev` | Usuario MySQL dedicado (no es root) |
| `MITSA_DB_PASS` | `mitsa_dev_local_pw` | Password local — **no es un secreto real**, solo protege un usuario MySQL restringido a `localhost` en una BD de desarrollo descartable |
| `MITSA_SITE_PORT` | `8891` | Puerto del servidor PHP embebido. Elegido para no chocar con otros proyectos del Mac Mini (ver `CLAUDE.md` — puertos ya en uso: 3000, 4000/4001, 5678, 5998/5999, etc.) |

## Cómo funciona cada pieza

- **`wpcli.sh`** — wrapper de `wp-cli` con `memory_limit=512M`. Todo el resto
  de los scripts lo usa en vez de invocar `wp` directo.
- **`router.php`** — router estándar de la comunidad WP para que
  `php -S` sirva permalinks bonitos sin `.htaccess`/Apache (el servidor
  embebido de PHP no lee `.htaccess`).
- **`mu-mitsa-mailpit.php`** — mu-plugin que enruta `wp_mail()` a Mailpit
  (SMTP local `127.0.0.1:1025`, sin auth) y fija un remitente válido
  (`wordpress@localhost` es rechazado por PHPMailer al no tener TLD).
  `provision.sh` lo copia a `wp/wp-content/mu-plugins/` en cada corrida.
- **`setup-wp.sh`** — bootstrap de una sola vez: instala `wp-cli`/`mailpit`
  vía Homebrew si faltan, arranca MariaDB y Mailpit como servicios de
  `brew services`, crea la BD/usuario, descarga WordPress y lo instala.
  Todo con checks de "si ya existe, omitir" — seguro de re-correr.
- **`provision.sh`** — deja el sitio al día: symlink del tema, plugins,
  páginas + templates del sitemap, home estática, menús `primary`/`footer`
  con sus items (incluye enlaces custom a `/casos/` y `/biblioteca/` hasta
  que esos CPTs tengan su propio archive), permalinks, arranque del
  servidor y smoke test final. **Idempotente** — verificado corriéndolo 3
  veces seguidas sin duplicar páginas ni items de menú.

## Troubleshooting

- **`Access denied for user 'root'@'localhost'`**: no uses `mysql -u root`.
  Con Homebrew MariaDB, el usuario del sistema operativo ya es admin vía
  socket Unix — el script usa `mysql` sin `-u` para las tareas de setup.
- **`Allowed memory size exhausted` al correr `wp core download`**: síntoma
  de usar `wp` directo en vez de `scripts/wpcli.sh`.
- **`unbound variable` en bash**: revisar que no se haya reintroducido
  `declare -A` — no es portable en el bash 3.2 de macOS.
- **Server ya corriendo pero páginas no cargan**: revisar
  `/tmp/mitsa-wp-server.log` y que el puerto en `MITSA_SITE_PORT` no choque
  con otro proceso (`lsof -iTCP -sTCP:LISTEN -P`).
- **Parar todo**: `kill $(cat /tmp/mitsa-wp-server.pid)`,
  `brew services stop mariadb mailpit`.
- **Reset completo**: `rm -rf wp/` y `mysql -e "DROP DATABASE mitsa_dev;"`,
  luego volver a correr `setup-wp.sh` + `provision.sh`.

## Formulario de contacto (Contact Form 7)

`scripts/cf7-contacto.txt` (creado en el paso P7 del blueprint) documenta el
markup del formulario CF7 versionado, ya que CF7 guarda su configuración en
la base de datos y no tiene export nativo a archivo.

## Plan de construcción

El plan completo de los siguientes pasos (P2–P12) vive en
`plans/mitsachile-rediseno-web.md`. El progreso vivo de cada paso se
trackea en `plans/mitsachile-progreso.md`.
