# Correo para el cliente — Aviso migración PHP

**Para:** Francisco De la Iglesia (Gerencia de Operaciones) — fjdelaiglesia@mitsachile.com
**CC:** Francisca De la Iglesia — francisca@mitsachile.com
**De:** Juan Jorquera — AplicacionesWeb
**Asunto:** MITSA · Hallazgo técnico importante en el sitio actual y plan de acción

---

Estimado Francisco:

Junto con saludar, quiero informarte de un hallazgo que detectamos mientras preparábamos el trabajo de rediseño, porque es relevante para la operación del sitio actual.

**El problema, en simple.** El sitio mitsachile.com está funcionando sobre una tecnología de base (el "motor" que hace correr la página) que quedó sin actualizar desde el año 2015. Al ser una versión tan antigua, hoy ya no recibe parches de seguridad ni soporte del fabricante. En la práctica esto significa dos cosas: primero, un riesgo de seguridad mayor al recomendable; y segundo, el riesgo de que, con el paso del tiempo, componentes del sitio dejen de funcionar correctamente. No es una emergencia que requiera actuar hoy mismo, pero sí es algo que conviene resolver de forma ordenada y sin demorarlo demasiado.

**La buena noticia: hay un plan y se hace con red de seguridad.** Nada de esto se toca directamente sobre el sitio en vivo. Todo el trabajo pesado se realiza primero en una copia del sitio en nuestro entorno de pruebas, con respaldo completo previo. Solo cuando la copia quede funcionando y probada, recién ahí aplicamos el cambio en el sitio real, en un horario de baja visita y con la posibilidad de volver atrás en minutos si algo no saliera como esperamos.

**Lo que haremos, en pasos:**

1. **Respaldo completo** del sitio actual (archivos y base de datos), guardado como punto de retorno seguro.
2. **Copia de prueba** del sitio en nuestro entorno local, sin tocar el sitio en vivo.
3. **Actualización ordenada** del sitio y sus componentes a versiones al día, probando en cada etapa que todo siga funcionando.
4. **Puesta al día del motor de base** a una versión moderna y con soporte, ya con todo validado en la copia.
5. **Publicación controlada** del cambio en el sitio real, con verificación final y respaldo listo para revertir ante cualquier imprevisto.

**Sobre el alcance.** Este trabajo de puesta al día y actualización de seguridad es adicional al rediseño que ya tenemos acordado: son dos frentes distintos, aunque relacionados. Antes de avanzar, quería ponerlo en tu conocimiento y consultarte si nos autorizas a proceder con este plan. Si te parece, te preparo el detalle de tiempos y valor asociado para tu aprobación.

Quedo atento a tus comentarios y disponible para conversarlo cuando prefieras.

Saludos cordiales,

**Juan Jorquera**
AplicacionesWeb
juan@aplicacionesweb.cl
