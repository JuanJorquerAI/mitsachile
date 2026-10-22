<?php
/**
 * Plugin Name: MITSA SEO & Lead Generation Engine
 * Description: Optimización integral de metadatos SEO, Schema.org JSON-LD (Service, Organization, FAQ) y conversión B2B para mitsa.org.
 * Author: AplicacionesWeb SpA
 * Version: 1.1.0
 */
defined('ABSPATH') || exit;

if (wp_parse_url(home_url(), PHP_URL_HOST) !== 'mitsa.org') {
    return;
}

/* ─────────────────────────────────────────────────────────────
   1. MAPEO DE TÍTULOS Y DESCRIPCIONES DE ALTA CONVERSIÓN B2B
───────────────────────────────────────────────────────────── */
function mitsa_leadgen_page_meta(): array {
    return [
        'inicio' => [
            'title' => 'MITSA | Equipamiento Naval, Tratamiento de Aguas e Ingeniería Marítima',
            'desc'  => 'Suministro e ingeniería de sistemas navales e industriales en Chile: plantas BWTS norma D-2, tratamiento de aguas servidas, vacío y protección catódica.',
        ],
        'soluciones' => [
            'title' => 'Soluciones Navales de Tratamiento de Aguas, Fluidos e ICCP | MITSA',
            'desc'  => 'Ingeniería naval en Chile: sistemas BWTS agua de lastre, plantas de aguas servidas, vacío sanitario, ósmosis marina, protección catódica y drenajes.',
        ],
        'representadas' => [
            'title' => 'Representadas Oficiales y Fabricantes Marítimos en Chile | MITSA',
            'desc'  => 'Representante autorizado en Chile: sistemas BWTS Erma First, bombas Herborner, drenajes BLÜCHER, compresores ERVOR, sistemas Evac y EPE.',
        ],
        'industrias' => [
            'title' => 'Sectores Naval, Astilleros, Acuicultura y Transporte | MITSA',
            'desc'  => 'Soluciones técnicas para buques de defensa, astilleros ASMAR, flota mercante, wellboats en Puerto Montt y faenas industriales en Chile.',
        ],
        'centro-tecnico' => [
            'title' => 'Centro Técnico: Normativa Naval, BWM D-2 y MARPOL en Chile | MITSA',
            'desc'  => 'Guías técnicas de ingeniería naval: fiscalización DIRECTEMAR, Convenio BWM Norma D-2, Circular A-52/007, protección catódica y MARPOL Anexo IV.',
        ],
        'contacto' => [
            'title' => 'Contacto Comercial & Cotización de Ingeniería Naval | MITSA',
            'desc'  => 'Solicite evaluación técnica para proyectos mayores o cotice repuestos originales con el equipo de MITSA. Atención en Valparaíso, Talcahuano y Puerto Montt.',
        ],
    ];
}

function mitsa_leadgen_current(): ?array {
    if (is_admin() || is_feed() || is_search() || is_404()) {
        return null;
    }
    if (is_front_page()) {
        $key = 'inicio';
    } elseif (is_home() && !is_paged()) {
        $key = 'centro-tecnico';
    } elseif (is_page()) {
        $key = (string) get_post_field('post_name', get_queried_object_id());
    } else {
        return null;
    }

    $all = mitsa_leadgen_page_meta();
    return $all[$key] ?? null;
}

// Filtros prioritarios (prioridad 99 gana sobre priority 20 de temas)
foreach (['wpseo_title', 'wpseo_opengraph_title', 'wpseo_twitter_title'] as $hook) {
    add_filter($hook, static function ($title) {
        $p = mitsa_leadgen_current();
        return $p ? $p['title'] : $title;
    }, 99);
}

foreach (['wpseo_metadesc', 'wpseo_opengraph_desc', 'wpseo_twitter_description'] as $hook) {
    add_filter($hook, static function ($desc) {
        $p = mitsa_leadgen_current();
        return $p ? $p['desc'] : $desc;
    }, 99);
}

add_filter('pre_get_document_title', static function ($title) {
    $p = mitsa_leadgen_current();
    return $p ? $p['title'] : $title;
}, 99);


/* ─────────────────────────────────────────────────────────────
   2. SCHEMA.ORG JSON-LD (Service, Organization, Lead Action)
───────────────────────────────────────────────────────────── */
add_action('wp_head', static function (): void {
    if (is_singular(['solucion', 'industria'])) {
        $id    = (int) get_the_ID();
        $title = get_the_title($id);
        $url   = get_permalink($id);
        $desc  = get_post_meta($id, '_yoast_wpseo_metadesc', true) ?: get_the_excerpt($id);
        $slug  = get_post_field('post_name', $id);

        $eval_url = function_exists('mitsa_contact_url') 
            ? mitsa_contact_url('evaluacion', ['solucion' => $slug])
            : home_url('/contacto/?puerta=evaluacion&solucion=' . urlencode($slug) . '#formulario');

        $schema = [
            '@context'    => 'https://schema.org',
            '@type'       => is_singular('solucion') ? 'Service' : 'SpecializedService',
            '@id'         => $url . '#service',
            'name'        => $title,
            'description' => $desc,
            'url'         => $url,
            'serviceType' => is_singular('solucion') ? 'Ingeniería y Equipamiento Marítimo-Naval' : 'Solución Sectorial Industrial y Naval',
            'provider'    => [
                '@type'     => 'Corporation',
                '@id'       => home_url('/#organization'),
                'name'      => 'MITSA SpA',
                'legalName' => 'MITSA SpA',
                'url'       => home_url('/'),
                'logo'      => home_url('/wp-content/themes/mitsa-v2/screenshot.jpg'),
                'telephone' => '+56985526282',
                'email'     => 'info@mitsachile.com',
                'address'   => [
                    '@type'           => 'PostalAddress',
                    'streetAddress'   => 'Av. Vicuña Mackenna 882',
                    'addressLocality' => 'Reñaca, Viña del Mar',
                    'addressRegion'   => 'Valparaíso',
                    'addressCountry'  => 'CL',
                ],
            ],
            'areaServed' => [
                ['@type' => 'Country', 'name' => 'Chile'],
                ['@type' => 'Country', 'name' => 'Perú'],
                ['@type' => 'Country', 'name' => 'Colombia'],
            ],
            'potentialAction' => [
                '@type'  => 'CommunicateAction',
                'name'   => 'Solicitar Evaluación Técnica y Cotización',
                'target' => $eval_url,
            ],
        ];

        echo "\n<!-- MITSA Schema.org B2B Lead Engine -->\n";
        echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "</script>\n";
    }
}, 30);

add_filter('wpseo_schema_organization', static function (array $data): array {
    $data['telephone'] = '+56 9 8552 6282';
    $data['email']     = 'info@mitsachile.com';
    $data['address']   = [
        '@type'           => 'PostalAddress',
        'streetAddress'   => 'Av. Vicuña Mackenna 882',
        'addressLocality' => 'Reñaca, Viña del Mar',
        'addressRegion'   => 'Valparaíso',
        'addressCountry'  => 'CL',
    ];
    return $data;
});


/* ─────────────────────────────────────────────────────────────
   3. BOTÓN FLOTANTE DE WHATSAPP B2B CON MENSAJE CONTEXTUAL
───────────────────────────────────────────────────────────── */
add_action('wp_footer', static function (): void {
    if (is_admin()) {
        return;
    }

    $title = is_singular() ? get_the_title() : 'soluciones navales';
    $msg   = 'Hola MITSA, requiero cotización y asesoría técnica sobre: ' . $title;
    $wa_url = 'https://wa.me/56985526282?text=' . rawurlencode($msg);
    ?>
    <style>
      .mitsa-wa-float {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 10px;
        background: #25D366;
        color: #ffffff;
        padding: 12px 18px;
        border-radius: 999px;
        box-shadow: 0 4px 16px rgba(37, 211, 102, 0.4);
        text-decoration: none;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        font-size: 14px;
        font-weight: 600;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
      }
      .mitsa-wa-float:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 211, 102, 0.5);
        color: #ffffff;
      }
      .mitsa-wa-float svg {
        width: 22px;
        height: 22px;
        fill: currentColor;
      }
      @media (max-width: 600px) {
        .mitsa-wa-float span {
          display: none;
        }
        .mitsa-wa-float {
          padding: 14px;
          bottom: 20px;
          right: 20px;
        }
        .mitsa-wa-float svg {
          width: 26px;
          height: 26px;
        }
      }
    </style>
    <a href="<?php echo esc_url($wa_url); ?>" 
       class="mitsa-wa-float" 
       target="_blank" 
       rel="noopener" 
       aria-label="Contactar a Ingeniería MITSA por WhatsApp"
       onclick="if(window.dataLayer){dataLayer.push({'event':'click_whatsapp_naval', 'page_title':'<?php echo esc_js($title); ?>'});}">
      <svg viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.634.075-1.928-.46-1.503-.623-2.476-2.146-2.55-2.247-.075-.101-.606-.807-.606-1.539 0-.733.385-1.094.521-1.242.136-.148.298-.185.398-.185.1 0 .199.001.285.006.091.005.212-.034.331.252.123.298.423 1.031.46 1.106.037.075.062.164.013.264-.05.101-.075.163-.15.25-.075.088-.158.196-.226.264-.075.074-.154.154-.066.304.088.151.391.644.839 1.042.577.513 1.063.672 1.214.747.151.075.24.063.329-.04.089-.102.381-.444.482-.596.101-.151.202-.126.339-.075.138.05 874.412 1.023.487.15.075.25.112.288.212.037.1.037.581-.107.986z"/></svg>
      <span>WhatsApp Asesoría Naval</span>
    </a>
    <?php
}, 100);
