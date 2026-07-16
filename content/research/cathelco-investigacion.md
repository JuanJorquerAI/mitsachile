# Investigación: ¿Qué es cathelco.cl? (resolución de contradicción)

**Fecha:** 2026-07-16
**Autor:** Investigación técnica de infraestructura (Claude Code)
**Motivo:** Dos investigaciones previas se contradecían sobre la propiedad de `cathelco.cl`. Esto bloqueaba decidir si trabajar SEO de las marcas Cathelco / Evac / Uson Marine para mitsachile.com.
**Método:** Evidencia dura de terminal — WHOIS, DNS (`dig`), geolocalización de IP (ipinfo.io), descarga y parseo del HTML de la home, y triangulación web. Todos los datos abajo son textuales de los comandos, no inferencias.

---

## Veredicto (confianza ALTA, ~95%)

**`cathelco.cl` es un activo digital de ESVA Solutions, NO de MITSA.** ESVA Solutions es el distribuidor oficial de las marcas Evac® y Cathelco® para México y Latinoamérica (Argentina, Chile, Colombia, México, Panamá, Perú, Venezuela). Su General Manager es **Edgar Esqueda** (edgar.esqueda@esvasolutions.com, +521 333 482 8401).

**La Versión 1 es la correcta.** La Versión 2 (que cathelco.cl sería de MITSA porque comparte contacto/dirección) partió de una observación real pero mal interpretada: cathelco.cl **lista a MITSA como su contacto/subdistribuidor en Chile** dentro de un directorio de contactos por país. Por eso aparecen "Francisco De la Iglesia" y la dirección de Reñaca — pero el correo de control asociado a esa ficha es `info@esvasolutions.com`, no un correo `@mitsachile.com`. MITSA es un dato *dentro* del sitio de ESVA, no el dueño del sitio.

**No hay canibalización de dominios entre activos propios de MITSA.** `mitsachile.com` y `cathelco.cl` son de entidades distintas, en hostings distintos, países distintos, con nameservers distintos. No comparten NADA a nivel de infraestructura.

---

## (a) Tabla comparativa: cathelco.cl vs mitsachile.com

| Atributo | **cathelco.cl** | **mitsachile.com** | ¿Coinciden? |
|---|---|---|---|
| IP (registro A) | `72.9.158.35` | `186.64.114.205` | ❌ No |
| PTR / hostname de la IP | `mail.esvasolutions.com` | `pyme108.pymedns.net` | ❌ No |
| Ubicación del hosting | Dallas, Texas, EE.UU. (AS30277 DFW Datacenter) | Curicó, Chile (AS52368 ZAM LTDA.) | ❌ No |
| Nameservers | `ns1.jetthost.net`, `ns2.jetthost.net` | `ns1/ns2/ns3.pymedns.net` | ❌ No |
| Registro MX (correo) | `cathelco.cl` (self, → 72.9.158.34/35, mail.esvasolutions.com) | `mail.mitsachile.com` | ❌ No |
| SPF (TXT) | `v=spf1 +a +mx +ip4:72.9.158.34 ~all` | `v=spf1 a mx ip4:186.64.114.205 ...186.64.117.131 ip6:2803:2800:c1c9::/48 ~all` | ❌ No |
| Registrante / operador | ESVA Solutions (México) | MITSA SpA (Chile) | ❌ No |
| Correo de contacto real del sitio | `info@esvasolutions.com`, `info@cathelco.cl`, `antonio.goicochea@esvasolutions.com` | `info@mitsachile.com`, `evacequips@mitsachile.com` | ❌ No |
| CMS | WordPress (plugin AIOSEO 4.8.7.2) | WordPress | ➖ Ambos WP, sin relación entre instalaciones |
| Título de la home | "Evac Cathelco Chile" | (sitio corporativo MITSA) | — |
| Teléfono destacado en meta | `+52(1)3334828401` (México) | `+56-32-2834052` (Viña) | ❌ No |

**Nota sobre WHOIS de `.cl`:** el `whois cathelco.cl` por puerto 43 (`whois.nic.cl`) dio *connection timed out* repetidamente desde esta red (NIC Chile restringe/limita ese acceso), y el scraper web de `nic.cl/registry/Whois.do` sólo devolvió CSS de la página, no la ficha. Por tanto **no obtuve el registrante formal de `.cl` textualmente** — es la única pieza que no pude confirmar por WHOIS directo. Se compensa con evidencia convergente muy fuerte (ver abajo). Para `esvasolutions.com` el WHOIS sí resolvió: creado 2018-10-25, registrador **Akky Online Solutions S.A. de C.V.** (México), Registrant State **Jalisco**, nameservers **NS1/NS2.JETTHOST.NET** — los mismos de cathelco.cl.

---

## Evidencia que sostiene el veredicto

1. **La IP de cathelco.cl (72.9.158.35) resuelve a `mail.esvasolutions.com`.** El dominio vive literalmente en infraestructura de correo de ESVA Solutions.
2. **cathelco.cl y esvasolutions.com comparten nameservers** (`jetthost.net`). Misma administración DNS.
3. **El correo de contacto del sitio es `info@esvasolutions.com`** en casi todas las fichas de país (incluida la de Chile/MITSA). El sitio también expone `antonio.goicochea@esvasolutions.com`.
4. **El teléfono de la meta description es mexicano** (`+52(1)3334828401`) — coincide con el de Edgar Esqueda, GM de ESVA (`+521 333 482 8401`).
5. **El footer dice "Diseño de Web-Gdl"** (Guadalajara, México).
6. **La home es un directorio de distribuidores LatAm.** Bloques textuales extraídos del HTML:
   - Colombia: `KHALELA S.A.S ... Cartagena` → `info@cathelco.co`
   - México: `Av Enrique Díaz de León Nte 2221, ... Guadalajara Jalisco` → `info@esvasolutions.com`, Contacto: Fabio Zapata
   - **Chile: `Mitsa Chile, Avda. Vicuña Mackenna 882, Reñaca, Viña del Mar` → `info@esvasolutions.com`, Contacto: Francisco De la Iglesia, Teléfono: +56985526282`**
   - Perú: `Condominio Hanaq- H04 Huaral Lima`
   - Panamá: `24 Marine ... Arraiján Panamá Oeste` → `info@esvasolutions.com`
7. **Triangulación web (evac.com / esvasolutions.com / LinkedIn):** ESVA Solutions es "the only authorized entity in the region to provide genuine Cathelco® and Evac® spare parts and on-board services"; distribuidor oficial para Argentina, Chile, Colombia, México, Panamá, Perú y Venezuela; Edgar Esqueda es su General Manager.

**Reconciliación de las dos versiones:** la Versión 2 vio el nombre "Francisco De la Iglesia" y la dirección de Reñaca en cathelco.cl y concluyó "es de MITSA". En realidad esos datos aparecen porque **MITSA es el contacto chileno listado por ESVA** en su propia web. El dueño/operador del dominio es ESVA (Versión 1).

---

## (b) Preguntas concretas para Francisco De la Iglesia

1. **"¿MITSA administra, paga o tiene acceso al dominio y sitio `cathelco.cl`, o ese sitio lo opera enteramente ESVA Solutions (Edgar Esqueda, Guadalajara)?"** — Confirma de raíz quién controla el activo. Nuestra evidencia dice ESVA, pero conviene oírlo del cliente.
2. **"En cathelco.cl aparece MITSA (con tu nombre y la dirección de Reñaca) como contacto de Chile, pero el correo publicado es `info@esvasolutions.com` y el teléfono +56 9 8552 6282. ¿Ese teléfono es de MITSA? ¿Los leads de Cathelco/Evac generados por ese sitio te llegan a ti o a ESVA en México?"** — Define si cathelco.cl te está quitando o entregando leads.
3. **"¿Cuál es exactamente la relación comercial y contractual MITSA–ESVA para Cathelco y Evac en Chile: eres representante exclusivo de esas marcas en el país, o ESVA vende directo y tú eres uno de varios contactos?"** — Determina si MITSA puede posicionarse legítimamente como "Cathelco Chile / Evac Chile" o si ESVA reclama ese territorio.
4. **"¿Hay acuerdo (o problema) con que mitsachile.com compita en Google por términos como 'Cathelco Chile', 'Evac Chile', 'tratamiento aguas grises barco Chile' frente a cathelco.cl? ¿ESVA lo vería como conflicto?"** — Antes de invertir SEO en esas marcas, hay que saber si pisamos un socio.

---

## (c) Recomendación SEO: Cathelco / Evac / Uson Marine

**Estado: DESBLOQUEADO a nivel técnico, con una condición comercial pendiente (pregunta 4).**

- **No hay riesgo de canibalización de dominios propios.** cathelco.cl NO es de MITSA; son entidades e infraestructuras separadas. Trabajar contenido Cathelco/Evac/Uson Marine en mitsachile.com no compite contra "otro sitio de MITSA".
- **PERO cathelco.cl SÍ ocupa el real estate de búsqueda "Cathelco Chile / Evac Chile".** Es un WordPress con AIOSEO, títulos optimizados ("Evac Cathelco Chile", fichas por producto: Evac MBR, Optima 5, OnlineMax R, MGPS antifouling, etc.) y ya rankea para esas consultas. Es un competidor SEO real — operado por tu propio socio/proveedor de marca (ESVA).
- **Implicancia estratégica:** MITSA y ESVA no son rivales, son parte de la misma cadena de distribución. Competir de frente contra cathelco.cl por "Cathelco Chile" podría generar fricción con ESVA. **Recomendación: validar con Francisco (pregunta 4) antes de atacar de lleno los términos de marca Cathelco/Evac.**
- **Mientras se resuelve, avanzar sin riesgo por la vía de MITSA con contenido donde MITSA tiene ventaja propia** (alineado con `content/seo-keywords.md`): BWTS/agua de lastre, protección catódica ICCP, antifouling naval/ánodos, ósmosis inversa marina, fluidos anticorrosión. Ahí NO hay solapamiento con cathelco.cl y MITSA compite con activo propio.
- **Sobre Uson Marine:** no apareció en cathelco.cl (ESVA se centra en Evac/Cathelco). Es un frente **totalmente libre** para MITSA — sin competencia de ESVA. Se puede trabajar SEO de Uson Marine de inmediato, sin condición.

**Resumen de una línea:** trabajar YA Uson Marine y las keywords técnicas propias de MITSA; para las marcas Cathelco/Evac, técnicamente libre pero **confirmar primero con Francisco la relación con ESVA** para no chocar con un socio en la SERP.

---

## Anexo: comandos ejecutados (reproducibilidad)

```
dig +short cathelco.cl A NS MX TXT      # 72.9.158.35 / ns1,ns2.jetthost.net / self MX / spf +ip4:72.9.158.34
dig +short mitsachile.com A NS MX TXT   # 186.64.114.205 / ns1-3.pymedns.net / mail.mitsachile.com
curl -s https://ipinfo.io/72.9.158.35   # hostname mail.esvasolutions.com, Dallas TX, AS30277 DFW Datacenter
curl -s https://ipinfo.io/186.64.114.205# hostname pyme108.pymedns.net, Curicó CL, AS52368 ZAM LTDA.
curl -sL --compressed -A "<Chrome UA>" https://cathelco.cl/   # HTTP 200, WordPress, title "Evac Cathelco Chile"
whois esvasolutions.com                 # Akky (MX), Jalisco, NS1/NS2.JETTHOST.NET (mismos que cathelco.cl)
```

**Limitación declarada:** el registrante formal `.cl` de cathelco.cl no se obtuvo por WHOIS (NIC Chile puerto 43 dio timeout; el WHOIS web devolvió sólo CSS). El veredicto se basa en evidencia convergente de DNS, hosting, correo, contenido y triangulación web, no en el WHOIS `.cl` textual. Para cerrar al 100% se puede consultar manualmente https://www.nic.cl/registry/Whois.do?d=cathelco.cl desde un navegador.
