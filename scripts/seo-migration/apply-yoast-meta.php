<?php
/**
 * Aplica los metadatos Yoast SEO optimizados para las 12 soluciones y 6 industrias en mitsa.org.
 * Uso con WP-CLI:
 *   wp eval-file apply-yoast-meta.php
 */
if (!defined('WP_CLI') || !WP_CLI) {
    echo "Debe ejecutarse mediante WP-CLI\n";
    exit(1);
}

$items = [
    // Soluciones
    [
        'id' => 50,
        'title' => 'Sistemas BWTS Chile: Tratamiento de Agua de Lastre Norma D-2 | MITSA',
        'desc' => 'Sistemas BWTS certificados IMO y USCG para cumplimiento de la norma D-2 de DIRECTEMAR en Chile. Equipos Erma First FIT, ingeniería de retrofit y repuestos.',
        'kw' => 'sistema bwts chile',
    ],
    [
        'id' => 51,
        'title' => 'Protección Catódica ICCP Naval y Ánodos de Sacrificio en Chile | MITSA',
        'desc' => 'Sistemas de protección catódica por corriente impresa (ICCP) y ánodos de sacrificio para buques, astilleros y plataformas marinas en Chile.',
        'kw' => 'protección catódica iccp naval',
    ],
    [
        'id' => 52,
        'title' => 'Sistemas ICAF / MGPS: Prevención de Bioincrustaciones en Buques | MITSA',
        'desc' => 'Sistemas antiincrustantes ICAF / MGPS para tomas de mar y tuberías navales. Cumplimiento de la Circular A-52/007 de DIRECTEMAR en Chile.',
        'kw' => 'sistemas icaf mgps naval',
    ],
    [
        'id' => 48,
        'title' => 'Sistemas Sanitarios al Vacío para Buques e Instalaciones | MITSA',
        'desc' => 'Sistemas de vacío sanitarios para recolección eficiente de aguas negras y grises en embarcaciones y faenas en tierra. Suministro y repuestos en Chile.',
        'kw' => 'sistemas sanitarios al vacio barcos',
    ],
    [
        'id' => 49,
        'title' => 'Plantas de Tratamiento de Aguas Servidas para Buques (STP) | MITSA',
        'desc' => 'Plantas de tratamiento de aguas residuales marinas certificadas bajo MARPOL Anexo IV y resolución MEPC.227(64) OMI. Suministro y postventa en Chile.',
        'kw' => 'planta de tratamiento de aguas servidas buques',
    ],
    [
        'id' => 53,
        'title' => 'Plantas de Ósmosis Inversa Marina y Generadores de Agua Dulce | MITSA',
        'desc' => 'Plantas desalinizadoras por ósmosis inversa para buques, wellboats e instalaciones costeras en Chile. Equipos de alta confiabilidad y repuestos.',
        'kw' => 'osmosis inversa marina chile',
    ],
    [
        'id' => 55,
        'title' => 'Drenajes de Acero Inoxidable Industriales y Navales BLÜCHER | MITSA',
        'desc' => 'Canaletas, sumideros y tuberías de acero inoxidable BLÜCHER para industria alimentaria, farmacéutica y aplicaciones marítimas en Chile.',
        'kw' => 'drenajes acero inoxidable blucher',
    ],
    [
        'id' => 54,
        'title' => 'Agua Caliente Sanitaria Marina para Buques y Plataformas | MITSA',
        'desc' => 'Calentadores de agua marinos, estanques de acumulación y sistemas integrados de agua caliente para habitabilidad a bordo. Soporte en Chile.',
        'kw' => 'agua caliente sanitaria buques',
    ],
    [
        'id' => 123,
        'title' => 'Intercambiadores de Calor y Compresores Navales de Arranque | MITSA',
        'desc' => 'Intercambiadores de calor navales, compresores de aire de arranque ERVOR y bombas industriales HERBORNER con servicio técnico y repuestos en Chile.',
        'kw' => 'intercambiadores de calor navales',
    ],
    [
        'id' => 122,
        'title' => 'Revestimientos Navales e Industriales Antideslizantes | MITSA',
        'desc' => 'Revestimientos técnicos de alto tráfico GERFLOR para cubiertas, espacios habitacionales marítimos e instalaciones industriales exigentes.',
        'kw' => 'revestimientos navales chile',
    ],
    [
        'id' => 56,
        'title' => 'Separadores de Agua y Aceite de Sentina Marinos (15 ppm) | MITSA',
        'desc' => 'Sistemas separadores de agua de sentina homologados OMI MARPOL para 15 ppm. Equipos de filtración, monitores de hidrocarburos y repuestos.',
        'kw' => 'separador agua de sentina 15 ppm',
    ],
    [
        'id' => 57,
        'title' => 'Repuestos Navales Oficiales y Retrofit de Sistemas a Bordo | MITSA',
        'desc' => 'Abastecimiento ágil de repuestos originales para bombas Herborner, sistemas Evac, Erma First y Blücher. Asistencia técnica en faenas de dique.',
        'kw' => 'repuestos navales chile',
    ],

    // Industrias
    [
        'id' => 42,
        'title' => 'Ingeniería y Equipamiento Naval para Buques de Defensa | MITSA',
        'desc' => 'Soluciones navales con certificaciones de sociedad clasificadora para fragatas, patrulleros y buques auxiliares de la Armada de Chile y astilleros.',
        'kw' => 'equipamiento naval defensa chile',
    ],
    [
        'id' => 43,
        'title' => 'Soluciones Sanitarias y Tratamiento de Aguas para Wellboats | MITSA',
        'desc' => 'Sistemas de vacío, bombas de alta resistencia y tratamiento de aguas para wellboats y centros de cultivo en Puerto Montt y la zona austral.',
        'kw' => 'tratamiento de aguas wellboats',
    ],
    [
        'id' => 46,
        'title' => 'Equipamiento para Naves Mercantes y Remolcadores en Chile | MITSA',
        'desc' => 'Sistemas de agua de lastre BWTS, plantas de aguas servidas y protección catódica para transporte marítimo y faenas portuarias en Chile.',
        'kw' => 'equipamiento naves mercantes chile',
    ],
    [
        'id' => 45,
        'title' => 'Proveedores para Astilleros Navales y Dique Seco en Chile | MITSA',
        'desc' => 'Ingeniería de retrofit, integración de equipos y repuestos para astilleros ASMAR y talleres de carena naval en Valparaíso, Talcahuano y Magallanes.',
        'kw' => 'proveedores astilleros chile',
    ],
    [
        'id' => 44,
        'title' => 'Sistemas Anticorrosión y Manejo de Fluidos Offshore | MITSA',
        'desc' => 'Protección catódica ICCP y equipamiento para plataformas, artefactos navales y proyectos de energía marina en condiciones extremas.',
        'kw' => 'sistemas anticorrosion offshore',
    ],
    [
        'id' => 47,
        'title' => 'Sistemas Sanitarios y Drenajes de Acero para Industria Terrestre | MITSA',
        'desc' => 'Drenajes higiénicos inoxidables y sistemas de vacío para plantas de alimentos, faenadoras, hospitales y minería en Chile.',
        'kw' => 'drenajes acero inoxidable industria',
    ],
];

WP_CLI::line("Iniciando actualización de metadatos Yoast SEO en mitsa.org...");

$updated = 0;
foreach ($items as $item) {
    $id = $item['id'];
    $post = get_post($id);
    if (!$post) {
        WP_CLI::warning("Post ID $id no encontrado.");
        continue;
    }

    update_post_meta($id, '_yoast_wpseo_title', $item['title']);
    update_post_meta($id, '_yoast_wpseo_metadesc', $item['desc']);
    update_post_meta($id, '_yoast_wpseo_focuskw', $item['kw']);
    
    // OpenGraph
    update_post_meta($id, '_yoast_wpseo_opengraph-title', $item['title']);
    update_post_meta($id, '_yoast_wpseo_opengraph-description', $item['desc']);

    WP_CLI::success("Actualizado ID $id ({$post->post_name}) -> {$item['kw']}");
    $updated++;
}

WP_CLI::success("Listo: $updated registros actualizados con metadatos Yoast SEO de alta conversión.");
