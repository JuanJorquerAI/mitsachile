<?php
/**
 * Agrega callouts B2B y enlaces bidireccionales en los 5 artículos del Centro Técnico.
 * Uso: wp eval-file apply-article-ctas.php
 */
if (!defined('WP_CLI') || !WP_CLI) {
    exit(1);
}

$articles_cta = [
    143 => [
        'badge' => 'Soporte y Cumplimiento Normativo en Chile',
        'title' => '¿Requiere implementar o evaluar un sistema BWTS bajo la Norma D-2?',
        'desc'  => 'MITSA representa en Chile a <strong>ERMA FIRST</strong>, fabricante líder de sistemas de tratamiento de agua de lastre certificados por la OMI y la USCG. Apoyamos a armadores y astilleros con ingeniería de integración, evaluación técnica y suministro de repuestos.',
        'btn1'  => 'Conocer Solución BWTS Erma First',
        'url1'  => '/soluciones/agua-de-lastre-bwts/',
        'btn2'  => 'Solicitar Evaluación Técnica',
        'url2'  => '/contacto/?puerta=evaluacion&solucion=agua-de-lastre-bwts#formulario',
    ],
    67 => [
        'badge' => 'Ingeniería Naval & Prevención de Corrosión',
        'title' => '¿Necesita cumplir la Circular A-52/007 o proteger circuitos de agua de mar?',
        'desc'  => 'Disponemos de sistemas antiincrustantes <strong>ICAF / MGPS</strong> y protección catódica por corriente impresa (<strong>ICCP</strong>) para prevenir bioincrustaciones y corrosión en cascos y tomas de mar según la reglamentación marítima chilena.',
        'btn1'  => 'Ver Sistemas ICAF / MGPS',
        'url1'  => '/soluciones/bioincrustaciones-icaf/',
        'btn2'  => 'Ver Protección Catódica ICCP',
        'url2'  => '/soluciones/proteccion-catodica-iccp/',
    ],
    66 => [
        'badge' => 'Asistencia Técnica en Dique Seco y Carena',
        'title' => '¿Evaluando la protección catódica óptima para su buque o artefacto naval?',
        'desc'  => 'En MITSA calculamos y suministramos sistemas <strong>ICCP</strong> con electrodos de referencia y ánodos de titanio MMO, así como líneas completas de <strong>ánodos de sacrificio galvánicos</strong> para faenas en astilleros chilenos.',
        'btn1'  => 'Ver Solución de Protección Catódica',
        'url1'  => '/soluciones/proteccion-catodica-iccp/',
        'btn2'  => 'Cotizar Ánodos o Sistema ICCP',
        'url2'  => '/contacto/?puerta=evaluacion&solucion=proteccion-catodica-iccp#formulario',
    ],
    65 => [
        'badge' => 'Autonomía y Desalinización Marina',
        'title' => '¿Buscando una planta de ósmosis inversa para buques o wellboats?',
        'desc'  => 'Suministramos plantas desalinizadoras por ósmosis inversa (SWRO) marinas de alta confiabilidad y eficiencia energética, con soporte local para suministro de membranas, bombas de alta presión y filtros de recambio.',
        'btn1'  => 'Ver Solución de Ósmosis Inversa',
        'url1'  => '/soluciones/generacion-de-agua-dulce/',
        'btn2'  => 'Cotizar Planta o Repuestos SWRO',
        'url2'  => '/contacto/?puerta=evaluacion&solucion=generacion-de-agua-dulce#formulario',
    ],
    64 => [
        'badge' => 'Cumplimiento MARPOL Anexo IV',
        'title' => '¿Requiere renovar o certificar la planta de tratamiento de aguas servidas?',
        'desc'  => 'MITSA suministra plantas de tratamiento biológico/físico-químico homologadas bajo la resolución MEPC.227(64) de la OMI y sistemas sanitarios al vacío de bajo consumo de agua para embarcaciones marítimas y proyectos navales.',
        'btn1'  => 'Ver Plantas de Aguas Residuales',
        'url1'  => '/soluciones/tratamiento-de-aguas-residuales/',
        'btn2'  => 'Ver Sanitarios al Vacío',
        'url2'  => '/soluciones/sistemas-sanitarios-al-vacio/',
    ],
];

foreach ($articles_cta as $post_id => $data) {
    $post = get_post($post_id);
    if (!$post) {
        WP_CLI::warning("Post $post_id no existe.");
        continue;
    }

    $content = $post->post_content;

    // Remover CTA anterior si existe
    $content = preg_replace('/<div class="mitsa-article-cta".*?<\/div>\s*<\/div>/s', '', $content);

    $cta_html = sprintf(
        '<div class="mitsa-article-cta" style="background:#0D1B2A;color:#F8F6F0;padding:32px 36px;border-radius:12px;margin:40px 0 24px">
  <div style="font:600 12px/1 \'Geist Mono\',monospace;color:#38BDF8;text-transform:uppercase;letter-spacing:1px;margin-bottom:10px">%s</div>
  <h3 style="color:#FFFFFF;margin:0 0 12px;font-size:22px;font-weight:700">%s</h3>
  <p style="color:rgba(248,246,240,0.85);font-size:15px;line-height:1.65;margin:0 0 20px">%s</p>
  <div style="display:flex;gap:14px;flex-wrap:wrap;align-items:center">
    <a href="%s" style="background:#0F766E;color:#FFFFFF;padding:11px 20px;border-radius:6px;text-decoration:none;font-weight:600;font-size:14px;display:inline-block">%s →</a>
    <a href="%s" style="background:transparent;color:#38BDF8;border:1px solid #38BDF8;padding:11px 20px;border-radius:6px;text-decoration:none;font-weight:600;font-size:14px;display:inline-block">%s</a>
  </div>
</div>',
        esc_html($data['badge']),
        esc_html($data['title']),
        $data['desc'],
        esc_url(home_url($data['url1'])),
        esc_html($data['btn1']),
        esc_url(home_url($data['url2'])),
        esc_html($data['btn2'])
    );

    $updated_content = rtrim($content) . "\n\n" . $cta_html;

    wp_update_post([
        'ID'           => $post_id,
        'post_content' => $updated_content,
    ]);

    WP_CLI::success("CTA B2B inyectado en Post $post_id ({$post->post_name})");
}
