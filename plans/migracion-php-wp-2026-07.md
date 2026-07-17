# Plan de migración PHP + WordPress — mitsachile.com (sitio actual)

**Fecha:** 2026-07-16
**Autor:** Arquitectura de migraciones (AplicacionesWeb)
**Alcance:** Mantener vivo y seguro el sitio ACTUAL (mitsachile.com, WordPress legacy) durante la transición al sitio nuevo, migrando su stack de PHP 5.4.45 a PHP 8.x con WordPress + plugins actualizados a versiones compatibles.
**NO cubre:** el sitio NUEVO (tema custom `mitsa`, servido con `php -S` en `localhost:8891` sobre `mitsa_dev`). Ese entorno NO se toca en ninguna fase de este plan.

> **Convención de bloqueo usada en todo el documento:**
> 🟢 = se puede hacer YA (local / sin producción).
> 🔴 = BLOQUEADO hasta tener credenciales de producción (cPanel/BlueHosting/phpMyAdmin) y OK explícito de Juan.
> ⚠️ = paso de alto riesgo, requiere respaldo previo.

---

## 1. Contexto y por qué

El sitio actual de mitsachile.com corre sobre **PHP 5.4.45**, una versión que llegó a **fin de vida (EOL) en septiembre de 2015**. Desde entonces no recibe parches de seguridad del propio intérprete PHP: más de 10 años sin correcciones a nivel de lenguaje. Sobre esa base corre **WordPress 4.9.26** (rama de 2017, sin soporte) más un stack de plugins de 2018-2019 con CVEs críticos conocidos (ver §4). El resultado es un sitio corporativo B2B expuesto públicamente, con REST API abierto y superficie de ataque grande.

El problema es doble:

1. **Deuda de seguridad activa.** No es teórico: Slider Revolution embebido en la versión que probablemente trae el tema es vulnerable a cadenas de CVEs de path traversal / RCE (CVE-2025-9217 afectó ~4M de sitios). Un atacante con acceso mínimo puede leer archivos o ejecutar código.
2. **El sitio viejo debe seguir vivo hasta que lance el nuevo.** No se puede simplemente apagarlo: es la presencia digital actual del cliente y debe mantenerse operativo y, sobre todo, **seguro**, durante todo el período de transición al rediseño.

Por eso hay que actualizar el stack del sitio viejo — no como fin en sí mismo, sino como **medida de contención** mientras se construye y lanza el sitio nuevo. Esto plantea también una decisión estratégica legítima (¿vale la pena migrar el viejo o conviene acelerar el nuevo?) que se eleva sin resolver en §8.

---

## 2. Estado detectado

### 2.1 Producción (mitsachile.com) — confirmado por reconocimiento HTTP

| Componente | Versión detectada | Estado |
|---|---|---|
| **PHP** | **5.4.45** | EOL 2015. No expuesto por HTTP; confirmado por vía hosting/inventario. |
| **WordPress core** | **4.9.26** | Confirmado por triple fuente (meta generator, feed, `?ver=` en assets). readme.html accesible. |
| **Tema activo** | **LogisCargo 1.92** (DesignArc / Templatation, ThemeForest #15010564, ~2016) | Comercial, NO custom. Empaqueta WPBakery + RevSlider como plugins bundled. |
| **WPBakery Page Builder** (js_composer) | **5.4.2** | Antiguo. PHP 8 recién soportado desde 6.5 / resuelto en 6.7.0. |
| **Slider Revolution** (revslider) | **5.4.5.1** | Antiguo. PHP 8.0 desde 6.3.4; PHP 8.2 desde 6.6.15. Cadena de CVEs críticos. |
| **Contact Form 7** | **5.0.4** | Antiguo (CVE de subida de archivos <5.3.2). PHP 8.2 OK en versión actual. |
| **Breeze** (caché Cloudways) | Activo, versión no determinable por HTTP | PHP 8.2 "fully compatible" en versión actual. |
| **jQuery** | 1.12.4 + migrate 1.4.1 | Legacy propio de WP 4.9.x (se moderniza al subir core). |
| **Servidor** | Apache, HSTS activo | Fuerza HTTPS; responde 406 a UA no-navegador. |
| **REST API** | `/wp-json/` abierto sin auth | Permite enumeración de usuarios/contenido. Endurecer. |
| **Hosting** | BlueHosting / cPanel, **sin SSH** | Todo vía File Manager / phpMyAdmin / MultiPHP Manager. |

Bug de contenido conocido (NO migrar sin revisar): menú "Contenedores para Supermercados" → `/trituradores-organicos/` (ver CLAUDE.md).

### 2.2 Entorno local disponible (esta Mac)

- **Local by WP Engine** instalado y operativo (`/Applications/Local.app`). Ya hay 5 sitios; uno corriendo. **Este es el entorno de trabajo de la migración.**
  - Versiones PHP descargadas hoy en Local: **8.2.29, 8.3.30, 8.4.4**. **NO** hay 5.6/7.x descargados (ver riesgo en §4/§5).
  - MySQL bundled por sitio: mysql-8.0.35 / 8.4.0 / mariadb-10.6.23. Aislado por sitio.
- **Sistema (referencia, NO usado por Local):** PHP 8.5.8 (Homebrew), wp-cli 2.12.0, MariaDB 12.3.2 vía brew services.
- **Sitio NUEVO — NO TOCAR:** `php -S localhost:8891` (PID vivo), DB `mitsa_dev` en el MariaDB de sistema. `scripts/provision.sh`, `setup-wp.sh`, `router.php`, `wpcli.sh` son del sitio nuevo.
- **Aislamiento natural:** Local usa su propio MySQL bundled por sitio → la copia de producción montada en Local **no puede pisar** `mitsa_dev` ni el server 8891. Motores y puertos distintos.
- **Disco: CRÍTICO.** Solo **~11 GB libres** (volumen al 98%). Liberar espacio ANTES de importar (ver §5).

---

## 3. Estrategia y ORDEN de ejecución

### Principio rector (la regla de oro, no negociable)

> **Actualizar el software (WP + plugins) a versiones compatibles con el PHP destino ANTES de subir la versión de PHP. Nunca al revés.**

Motivo: WordPress viejo hace *fatal error* / pantalla blanca en PHP 8. Y para actualizar el core, WordPress **tiene que poder ejecutarse**. Si subes PHP primero, se cae wp-admin y — sin SSH en BlueHosting — quedas sin consola para revertir, solo File Manager/phpMyAdmin. Por eso: primero se moderniza el sitio (con PHP en su versión vieja), y el salto de PHP es el ÚLTIMO paso.

Segundo principio: **todo el trabajo pesado se hace en LOCAL (app Local by WP Engine), en un sitio aislado**, no en producción. Producción queda intacta en 5.4 hasta el cutover final. El montaje/pruebas NO se hacen con el `php -S` del repo (ese corre el sitio nuevo).

### Fases

#### FASE 0 — Preparación local 🟢 (se puede hacer YA, sin producción)
0.1. Liberar disco: bajar de 98% de ocupación. Revisar tamaño estimado del backup de producción primero; si el margen no alcanza, mover `~/Local Sites` (o solo el sitio de la copia) a disco externo desde la UI de Local, o purgar sitios Local sin uso.
0.2. En la UI de Local, verificar en **"Add PHP version"** si aún es posible descargar una versión 7.x (idealmente 7.0/7.4) para reproducir producción. Si el piso real es 8.2, **documentar la discrepancia** en `docs/DECISIONS.md` y planificar arrancar en 8.2 (asumiendo el riesgo de que el código viejo falle antes de tiempo).
0.3. Dejar listo el checklist de pruebas (§5) y este plan a mano.

#### FASE 1 — Descarga de producción (archivos + BD) 🔴⚠️ BLOQUEADO
1.1. **Respaldo dorado** en cPanel: Backup Wizard → copia completa (archivos + todas las BD). Guardar como punto de rollback intocable.
1.2. Exportar BD vía phpMyAdmin (SQL con gzip) o Backup Wizard.
1.3. Descargar `public_html` completo (o al menos `wp-content` + `wp-config.php`) vía File Manager (comprimir a .zip y bajar).
1.4. Registrar inventario: versión WP, lista+versiones de plugins/tema, versión PHP (5.4.45), tamaño de BD.

#### FASE 2 — Montaje en LOCAL (sitio aislado) 🟢 (tras recibir 1.x)
2.1. En Local: **New Site** → nombre p.ej. `mitsa-produccion-copia`, opción **Custom** para fijar versión de PHP.
   - Fijar PHP **igual a producción** (idealmente 7.x). **Si Local solo ofrece 8.2+, arrancar en 8.2** y dejar constancia — asumiendo que el arranque inicial puede fallar (justo el síntoma que la migración busca resolver).
2.2. Importar el dump SQL + copiar `wp-content` de producción al sitio Local.
2.3. Search-replace de URLs con el wp-cli **embebido de Local** (Site Shell), NUNCA REPLACE SQL crudo (corrompe datos serializados):
   `wp search-replace "https://mitsachile.com" "http://mitsa-produccion-copia.local" --all-tables --precise --report-changes`
2.4. Confirmar que el sitio viejo carga en Local. Si no arranca por incompatibilidad de PHP, ese es el punto de partida de la modernización.
2.5. Higiene / antimalware ANTES de propagar nada: `wp core verify-checksums` y `wp plugin verify-checksums --all` para detectar archivos alterados. Activar `WP_DEBUG` + `WP_DEBUG_LOG` en el wp-config local.

#### FASE 3 — Actualizar WP core (escalonado) en Local 🟢⚠️
3.1. Subir WordPress por **peldaños de versión mayor**, no de un salto. Escalera sugerida desde 4.9.x:
   `4.9.x → 5.9.x → última 6.x`
3.2. En cada peldaño, en este orden exacto:
   - `wp core update --version=X.Y.Z --force`
   - `wp core update-db` (corre migraciones incrementales de BD)
   - actualizar plugins
   - probar (§5)
   - respaldo/export de la BD local antes del siguiente peldaño.

#### FASE 4 — Actualizar plugins y auditar tema en Local 🟢⚠️
4.1. `wp plugin update --all` a la última versión compatible con PHP 8.2.
   - **CF7 y Breeze:** simple update, sin acción especial (ver §4).
   - **WPBakery → ≥6.7.0** (idealmente última). **RevSlider → ≥6.6.15**, idealmente **≥6.7.37** (por CVE-2025-9217) o 7.0.11+.
4.2. **Punto crítico de decisión (ver §4):** WPBakery y RevSlider vienen **bundled** dentro de LogisCargo, sin licencia propia → no se actualizan desde wp-admin sin una actualización del TEMA por DesignArc. Evaluar aquí:
   - (a) ¿DesignArc publicó una versión de LogisCargo compatible con PHP 8? → actualizar el tema.
   - (b) ¿Tema abandonado? → comprar licencias directas de WPBakery/RevSlider, **o** aceptar que el sitio viejo no es migrable con seguridad y **acelerar el sitio nuevo** (elevar a §8).
4.3. Auditar el código propio de LogisCargo (functions/widgets/shortcodes era PHP 5.x) con PHPCompatibility / PHP Compatibility Checker antes de subir PHP.

#### FASE 5 — Subir PHP en Local y probar 🟢
5.1. Con el sitio ya en WP 6.x + plugins actualizados, usar el **selector de PHP por sitio de Local** para subir escalonadamente: 8.2 → 8.3 (→ 8.4 opcional). Este es exactamente el caso de uso que justifica usar Local.
5.2. Ejercitar el checklist completo (§5). Revisar `debug.log`: objetivo **cero fatales**, idealmente cero deprecados críticos. Iterar hasta limpio.

#### FASE 6 — (Opcional) Mostrar al cliente con Live Link de Local 🟢
6.1. Usar **"Live Link"** de Local para compartir un preview de la copia ya migrada con Francisco/Francisca, sin exponer localhost ni tocar mitsachile.com en vivo. Útil como validación previa al cutover si se quiere el visto bueno del cliente.

#### FASE 7 — Respaldo fresco de producción (rollback listo) 🔴⚠️
7.1. Inmediatamente antes del cutover, respaldo COMPLETO y fresco de producción (archivos + BD). Este es el respaldo de rollback del cutover, distinto del dorado de FASE 1.
7.2. Elegir ventana de baja actividad.

#### FASE 8 — Ejecutar en producción 🔴⚠️ (WP+plugins PRIMERO, PHP DESPUÉS)
8.1. Subir a `public_html` los archivos ya actualizados (WP 6.x + plugins/tema) y la BD ya modernizada. Search-replace a la URL final del dominio (con Better Search Replace / WP Migrate, ya que no hay SSH; **nunca** REPLACE SQL crudo).
   - Alternativa más segura si se prefiere no clonar en caliente: hacer las actualizaciones directamente en producción vía wp-admin (con PHP aún en 5.4/7.x), replicando lo validado en local. Local es el ensayo; producción sigue el mismo guion probado.
8.2. Ajustar límites en **MultiPHP INI Editor**: `memory_limit` a 256M/512M, `max_execution_time`, `upload_max_filesize` (WP moderno consume más que el viejo; el default 128M puede quedar corto).
8.3. **RECIÉN AHORA cambiar PHP:** cPanel → Software → **MultiPHP Manager** → dominio principal → seleccionar `ea-php82` (o `alt-php82`) → Apply.
   - Confirmar antes en MultiPHP Manager que BlueHosting realmente ofrece 8.1/8.2 y qué sub-versión.

#### FASE 9 — Verificar en producción 🔴
9.1. Subir `phpinfo.php` temporal, verificar versión activa, **borrarlo**.
9.2. wp-admin → Herramientas → **Salud del sitio** (Site Health): PHP, extensiones, módulos. Opcional: plugin "Health Check & Troubleshooting".
9.3. `WP_DEBUG_LOG` a `wp-content/debug.log`: revisar fatales.
9.4. Recorrido manual del checklist §5 en el dominio real.
9.5. Endurecer seguridad: ocultar meta generator, bloquear `/readme.html` y `/wp-links-opml.php`, restringir enumeración vía REST API.
9.6. Monitorear estabilidad 24-48h manteniendo el respaldo de FASE 7 a mano.

#### FASE 10 — SEO + Analytics 🔴 (SOLO después de verificar estabilidad)
10.1. Recién con el sitio estable en PHP 8.x se ejecuta SEO/Analytics. No antes: cambios de SEO/tracking sobre un sitio que aún puede requerir rollback generan ruido y trabajo perdido.
10.2. Existe `scripts/aplicar-seo-produccion.sh` en el repo como punto de partida (revisar aplicabilidad al sitio viejo vs. nuevo).

> **Nota:** las fases 0-6 son 100% locales y desbloqueadas (salvo que 2.x depende de recibir la descarga de 1.x). Las fases 1, 7, 8, 9, 10 requieren acceso a producción y OK de Juan.

---

## 4. Matriz de riesgos por componente

| Componente | Versión prod | Riesgo en PHP 8 | Mitigación | ¿Puede obligar a reemplazar? |
|---|---|---|---|---|
| **Tema LogisCargo 1.92** | 1.92 (2016) | Código propio era PHP 5.x: candidato a usar `each()`, `create_function()`, `mysql_*`, ternarios sin paréntesis → **fatal error / pantalla blanca**. Sin evidencia pública de test en PHP 8. | Auditar con PHPCompatibility en local. Buscar update del tema en DesignArc. | **SÍ** — si DesignArc lo abandonó y el código no pasa PHP 8, hay que reemplazar tema o descartar la migración del viejo. |
| **WPBakery 5.4.2** (bundled) | 5.4.2 | <6.5 en PHP 8.0 = fatal por ternario anidado sin paréntesis + `__wakeup()` visibility. Tumba todo el sitio. | Actualizar a ≥6.7.0. Pero está **bundled sin licencia** → depende de update del tema. | **SÍ (condicional)** — si el tema no trae la versión nueva y no hay licencia directa, hay que comprar licencia WPBakery o reemplazar. |
| **Slider Revolution 5.4.5.1** (bundled) | 5.4.5.1 | <6.3.4 = fatal en PHP 8.0 (`ArgumentCountError` en `strrpos`). Además **cadena de CVEs críticos** (LFI 2014, RCE ≤6.6.12, path traversal ≤6.7.36). Vector ya potencialmente explotado. | Actualizar a ≥6.6.15 (idealmente ≥6.7.37). Escanear producción por archivos maliciosos antes de clonar (skill `cpanel-malware-cleanup`). Bundled sin licencia. | **SÍ (condicional)** — mismo problema de bundling que WPBakery. Prioridad de seguridad máxima. |
| **Contact Form 7 5.0.4** | 5.0.4 | Bajo. CF7 <5.3.2 tiene CVE de subida de archivos, pero la versión actual corre bien en PHP 8.2 (solo deprecations menores en 8.1). | Simple `wp plugin update`. Vigilar: CF7 6.2 exigirá PHP 8.3+ a futuro. | No. |
| **Breeze** (caché) | ? | Bajo. Versión actual "fully compatible" con PHP 8.2. Mantenido por Cloudways. | Simple update. Requiere WP 6.0+. Limpiar caché tras cada cambio. | No. |

**Lectura clave:** los tres componentes de mayor riesgo (LogisCargo + los dos plugins bundled) están **acoplados** — su actualización depende de una sola cosa: que DesignArc haya publicado un LogisCargo compatible con PHP 8. Si no lo hizo, la migración del sitio viejo se vuelve cara (licencias directas) o inviable, lo que refuerza la decisión de §8.

---

## 5. Checklist de pruebas en local

Ejecutar tras FASE 3, FASE 4 y (exhaustivamente) FASE 5. Marcar página por página.

**Front-end, página por página:**
- [ ] Home carga sin pantalla blanca ni errores en consola.
- [ ] Menú principal completo, incluido el ítem buggy "Contenedores para Supermercados" (verificar a dónde apunta; NO arreglar aún, solo constatar).
- [ ] Nosotros / Empresa.
- [ ] Productos (y subcategorías).
- [ ] Representadas / Sectores / Servicios (según existan).
- [ ] Contacto.
- [ ] Footer, enlaces sociales, teléfonos/direcciones.

**Sliders (RevSlider):**
- [ ] Cada slider renderiza (no queda en blanco ni tira JS error).
- [ ] Transiciones/animaciones funcionan.
- [ ] Imágenes de fondo y capas cargan.

**WPBakery (layouts):**
- [ ] Filas/columnas se ven bien (no colapsan).
- [ ] Shortcodes del tema renderizan (no aparecen `[vc_...]` crudos).
- [ ] Responsive: móvil, tablet, desktop.

**Formularios (CF7):**
- [ ] Formulario de contacto se muestra.
- [ ] Envío de prueba → llega a Mailpit / no da fatal.
- [ ] Validación de campos requeridos.
- [ ] Confirmación de éxito / mensajes de error.

**Admin (wp-admin):**
- [ ] Login funciona.
- [ ] Dashboard sin errores fatales.
- [ ] Editor de páginas (WPBakery backend) abre.
- [ ] Editor de RevSlider abre.
- [ ] Subida de imágenes a Media Library funciona.
- [ ] Site Health revisa PHP/extensiones sin errores rojos.

**Logs:**
- [ ] `wp-content/debug.log`: **cero fatales**, idealmente cero deprecados críticos.

---

## 6. Plan de respaldo y ROLLBACK

### Qué respaldar (siempre archivos + BD, juntos)
1. **Respaldo dorado** (FASE 1): estado pre-migración de producción. Intocable. Guardado fuera del servidor.
2. **Respaldos por peldaño** (FASE 3/4): export de BD local entre cada salto de versión.
3. **Respaldo fresco de cutover** (FASE 7): inmediatamente antes de tocar producción.

Herramientas cPanel (sin SSH): **Backup Wizard** (archivos + MySQL), **phpMyAdmin** (export SQL gzip), **File Manager** (zip de `public_html`).

### Rollback concreto en producción (orden según el síntoma)
1. **Si el sitio cae al cambiar PHP:** cPanel → MultiPHP Manager → reelegir la versión antigua (5.4/7.x) → Apply. Revierte en segundos. **Probar esto primero**, es lo más rápido.
2. **Si el problema es de archivos** (tema/plugin roto): File Manager → borrar el set roto → subir y extraer el .zip de respaldo. O Backup Wizard → Restore.
3. **Si el problema es la BD:** phpMyAdmin → DROP de las tablas afectadas → Import del `.sql` de respaldo. O Backup Wizard → restore MySQL.
4. **Red de seguridad:** mantener una copia del sitio viejo intacta en un subdirectorio/subdominio para poder re-apuntar rápido durante 24-48h.

### Criterios de ABORTO del cutover
Abortar y revertir si, tras el cambio a PHP 8 en producción:
- Aparece pantalla blanca / fatal en cualquier página pública principal, y no se resuelve en la ventana de mantenimiento acordada.
- El formulario de contacto deja de enviar (es el canal comercial del sitio B2B).
- wp-admin queda inaccesible.
- Se detectan errores que en local no aparecieron (diferencia de entorno MariaDB/MySQL, extensiones, memory_limit) y no hay fix inmediato.
- El tiempo de la ventana de mantenimiento se agota sin sitio estable.

Regla: ante la duda, **revertir PHP primero** (paso 1, segundos) y diagnosticar con calma, no dejar el sitio caído mientras se investiga.

---

## 7. Qué se necesita de cada parte

### De Juan (AplicacionesWeb) — desbloquea las fases 🔴
- **Credenciales de cPanel/BlueHosting** (viven en `docs/Correo de AplicacionesWeb - Inicio proyecto MITSA.pdf`, gitignoreado — moverlas a `.env` local/gestor de secretos, nunca versionar).
- **OK explícito** para descargar producción (FASE 1) y para el cutover (FASE 8), con ventana horaria acordada.
- Confirmar la **versión de PHP real** de producción (5.4.45) directamente en MultiPHP Manager, y qué versiones 8.x ofrece BlueHosting.
- Decisión sobre §8 (migrar viejo vs. acelerar nuevo).
- Presupuesto/autorización si se requieren **licencias directas** de WPBakery/RevSlider (ver §4).

### Del cliente (MITSA)
- **Ventana de mantenimiento** aprobada (aviso de posible breve indisponibilidad).
- (Opcional) Revisar el **Live Link** de Local (FASE 6) y dar visto bueno antes del cutover.
- Confirmar que no hay campañas/tráfico crítico programado en la ventana elegida.

### Autorizaciones y avisos
- Aviso al cliente antes de la ventana de cutover.
- Registrar en `docs/DECISIONS.md`: versión PHP de producción a igualar, que la copia vive en Local aislada, plan de subida escalonada, y la resolución de §8.
- **No commitear credenciales** en ninguna fase (regla de CLAUDE.md).

---

## 8. Decisión abierta a elevar: ¿migrar el viejo o acelerar el nuevo?

**No se resuelve aquí. Se eleva a Juan (y, si aplica, al cliente) con el trade-off explícito.**

El contexto crea una tensión real: el sitio nuevo (tema custom `mitsa`, WP 6.x, PHP 8.2 desde cero) **va a reemplazar** al viejo. Migrar el viejo a PHP 8 tiene costo y riesgo no triviales — sobre todo por LogisCargo + plugins bundled (§4), que podrían exigir comprar licencias o incluso ser inviables. Cabe preguntarse si ese esfuerzo se justifica para un sitio que morirá pronto.

**Opción A — Migrar el sitio viejo (este plan completo).**
- *A favor:* cierra la exposición de seguridad activa ya (PHP 5.4 EOL + CVEs de RevSlider) independientemente de cuándo lance el nuevo; no queda un sitio hackeable "por unas semanas más".
- *En contra:* costo/riesgo alto concentrado en LogisCargo bundled; podría requerir licencias pagadas; es trabajo sobre software desechable.

**Opción B — Acelerar el lanzamiento del sitio nuevo y saltar la migración del viejo.**
- *A favor:* evita gastar en modernizar software que se va a botar; el sitio nuevo ya nace en PHP 8.2 limpio.
- *En contra:* deja el sitio viejo vulnerable durante toda la aceleración; si el nuevo se atrasa (contenido "propuesto" aún sin validar por el cliente — ver CLAUDE.md), la ventana de exposición se alarga sin techo.

**Opción C — Mitigación mínima del viejo + acelerar el nuevo (híbrido).**
- En vez de migrar PHP completo, aplicar solo contención de seguridad barata al viejo (WAF/reglas, bloquear/actualizar SOLO RevSlider al mínimo parcheado, ocultar generator, cerrar readme/REST) y poner el foco en lanzar el nuevo.
- *A favor:* reduce el riesgo peor (RCE de RevSlider) sin el costo de la migración full de PHP.
- *En contra:* no elimina la deuda de PHP 5.4; es un puente, no una solución.

**Criterios para decidir (a responder por Juan/cliente):**
1. **¿Cuándo lanza realmente el sitio nuevo?** Si es en semanas y el contenido está encaminado → B/C ganan peso. Si es incierto (>1-2 meses) → A gana peso.
2. **¿LogisCargo tiene update PHP8 de DesignArc?** (resultado de FASE 4.2). Si sí y es barato → A es viable. Si no y exige licencias → empuja a B/C.
3. **¿Cuál es la tolerancia al riesgo de seguridad del cliente** para un sitio corporativo B2B con su nombre expuesto?
4. **¿Cuánto tráfico/valor comercial** tiene hoy el sitio viejo (¿genera leads reales o es placa?).

**Recomendación de proceso:** ejecutar las fases 0-4 en local de todos modos (son baratas y desbloqueadas), porque **el resultado de FASE 4.2 es justamente el dato que decide** entre A y B/C. No comprometer la decisión antes de saber si LogisCargo es migrable.

---

## Resumen operativo

- **Fases 0-6 (locales) están desbloqueadas hoy**; solo FASE 2 depende de recibir la descarga de producción. Las fases 1, 7, 8, 9, 10 están **BLOQUEADAS hasta credenciales de cPanel + OK de Juan**.
- **Orden inviolable:** actualizar WP + plugins primero, cambiar PHP en cPanel de último; todo ensayado antes en la app Local (sitio aislado), nunca en el `php -S` del repo (sitio nuevo).
- **El mayor riesgo es LogisCargo + WPBakery/RevSlider bundled**: pueden causar pantalla blanca en PHP 8 y quizá obliguen a comprar licencias o reemplazar componentes.
- **Rollback más rápido: revertir la versión de PHP en MultiPHP Manager (segundos)**; respaldo dorado + fresco de cutover cubren archivos y BD.
- **FASE 4.2 es el punto de decisión de §8** (migrar viejo vs. acelerar nuevo): correr las fases locales primero da el dato que resuelve el trade-off.
