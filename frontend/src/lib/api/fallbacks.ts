import type { PageSectionsResponse } from './types.ts';

/**
 * Dataset estático de fallback para MITSA.
 * Garantiza cero caídas en compilación y tiempo de ejecución si la API de WordPress
 * se encuentra apagada o no responde. Basado en el brochure y content/01-home.md.
 */
export const HOME_FALLBACK_DATA: PageSectionsResponse = {
  slug: 'home',
  title: 'MITSA — Integramos tecnología. Resolvemos desafíos.',
  seo: {
    meta_title: 'MITSA — Integramos tecnología. Resolvemos desafíos.',
    meta_description: 'Ingeniería de aplicación, suministro, retrofit, puesta en marcha y soporte. Cinco fabricantes representados, cuarenta años de proyectos en Chile y Latinoamérica.',
    canonical_url: 'https://mitsachile.com/',
    og_image: 'https://mitsachile.com/images/plataforma-offshore-8886341c.jpg',
    og_type: 'website',
  },
  sections: {
    hero: {
      title_prefix: 'Toda su ingeniería resuelta, del proyecto a la operación:',
      rotating_words: ['sanitaria', 'de tratamiento', 'de protección', 'de agua dulce'],
      description: 'Ingeniería de aplicación, suministro, retrofit, puesta en marcha y soporte. Cinco fabricantes representados de forma directa, cuarenta años de proyectos en Chile y Latinoamérica.',
      triage: {
        title: '¿Qué necesita resolver?',
        options: [
          { label: 'Evaluación técnica', url: '/contacto/?tipo=evaluacion', highlight: true },
          { label: 'Repuestos', url: '/contacto/?tipo=repuestos', highlight: false },
          { label: 'Servicio técnico', url: '/contacto/?tipo=servicio', highlight: false },
        ],
        placeholder: 'Describa su proyecto o nave...',
        button_text: '→',
        action_url: '/contacto/',
      },
    },
    visual_cards: [
      {
        title: 'Fragata FF-18 · ICCP',
        image: '/images/plataforma-offshore-8886341c.jpg',
        alt: 'Protección catódica por corriente impresa ICCP en Fragata FF-18',
        width: 800,
        height: 600,
        loading: 'eager',
      },
      {
        title: 'OPV Cabo Odger · Sanitarios',
        image: '/images/buque-de-apoyo-8d5d1037.jpg',
        alt: 'Sistemas sanitarios al vacío EVAC en buque patrullero OPV Cabo Odger',
        width: 800,
        height: 600,
        loading: 'eager',
      },
      {
        title: 'Magellan Discovery · Agua caliente',
        image: '/images/wellboat-en-centro-d-6ece81b5.jpg',
        alt: 'Sistemas de generación y distribución de agua caliente a bordo',
        width: 800,
        height: 600,
        loading: 'lazy',
      },
      {
        title: 'Wellboat · BWTS',
        image: '/images/astillero-636210b7.jpg',
        alt: 'Tratamiento de agua de lastre BWTS ERMA FIRST en wellboat',
        width: 800,
        height: 600,
        loading: 'lazy',
      },
    ],
    pain_points: {
      heading: 'Resolvemos lo que frena un proyecto naval',
      quote: '«Nos ofrecen el equipo, pero nadie se hace cargo de la puesta en marcha ni de los repuestos tres años después.»',
      author_initials: 'JP',
      author_role: 'Jefe de Proyecto · Astillero Naval',
      author_note: 'Caso representativo de la industria',
      resolutions: [
        'Especificaciones que calzan exactamente con la normativa aplicable',
        'Ingeniería de aplicación y dimensionamiento previo a la compra',
        'Trazabilidad de repuestos originales por número de parte oficial',
        'Puesta en marcha y comisionamiento ejecutado en terreno en Chile',
        'Alcance contractual y técnico claro entre astillero, armador y MITSA',
      ],
    },
    metrics: [
      { value: '40+', label: 'años integrando soluciones marítimas y ambientales en Chile', highlight: false },
      { value: '5', label: 'fabricantes representados de forma directa y oficial', highlight: false },
      { value: '100%', label: 'cobertura nacional con ingenieros especialistas en terreno', highlight: true },
    ],
    brands: {
      heading: 'Quién está detrás de cada solución',
      items: [
        { name: 'EVAC', tagline: 'Sanitarios al vacío', description: 'Tratamiento de aguas residuales y gestión de residuos a bordo.', url: '/representadas/' },
        { name: 'Cathelco', tagline: 'ICCP & ICAF', description: 'Protección catódica por corriente impresa y prevención de bioincrustaciones.', url: '/representadas/' },
        { name: 'ERMA FIRST', tagline: 'Agua de lastre (BWTS)', description: 'Sistemas certificados D-2 con tecnología de electrólisis y filtración.', url: '/representadas/' },
        { name: 'EPE', tagline: 'Tratamiento de efluentes', description: 'Plantas de tratamiento y separadores marinos de sentinas.', url: '/representadas/' },
        { name: 'BLÜCHER', tagline: 'Drenajes inoxidables', description: 'Sistemas de evacuación y tuberías de acero inoxidable AISI 316L.', url: '/representadas/' },
      ],
    },
    solutions: {
      heading: 'Soluciones tecnológicas especializadas',
      subheading: 'Sistemas marinos y terrestres integrados con ingeniería de aplicación, comisionamiento y respaldo técnico en terreno.',
      items: [
        { title: 'Sanitarios al vacío', brand: 'EVAC', img: '/images/sistemas-sanitarios--c457bd2a.jpg', desc: 'Sistemas sanitarios marinos y terrestres de alta eficiencia con ahorro de agua.' },
        { title: 'Aguas residuales', brand: 'EVAC · EPE', img: '/images/tratamiento-de-aguas-8ead4ece.jpg', desc: 'Plantas de tratamiento biológico y físico-químico según normativa MARPOL Anexo IV.' },
        { title: 'Agua de lastre (BWTS)', brand: 'ERMA FIRST', img: '/images/ingeniería-de-detall-616b7dfd.jpg', desc: 'Sistemas de tratamiento de agua de lastre bajo estándar D-2 de la OMI.' },
        { title: 'Corrosión (ICCP)', brand: 'Cathelco', img: '/images/datos-de-operación-y-92c78919.jpg', desc: 'Protección catódica por corriente impresa para cascos de buques e instalaciones.' },
        { title: 'Bioincrustaciones (ICAF)', brand: 'Cathelco', img: '/images/acuicultura-64fec532.jpg', desc: 'Sistemas anti-incrustaciones para tomas de mar y circuitos de refrigeración.' },
        { title: 'Generación de agua dulce', brand: 'Representadas oficiales', img: '/images/recursos-img-5-02ed53ff.jpg', desc: 'Plantas desalinizadoras por ósmosis inversa y evaporadores marinos.' },
        { title: 'Sistemas de agua caliente', brand: 'Ingeniería MITSA', img: '/images/recursos-img-6-2ffa0056.jpg', desc: 'Calderas, intercambiadores y acumuladores para habitabilidad a bordo.' },
        { title: 'Drenajes inoxidables', brand: 'BLÜCHER', img: '/images/recursos-img-7-8ead4ece.jpg', desc: 'Canaletas, sifones y tuberías de acero inoxidable AISI 316L para higiene naval.' },
      ],
    },
    why_mitsa: {
      heading: '¿Por qué MITSA?',
      subheading: 'Seis razones técnicas que sostienen un proyecto completo, de la especificación al soporte en operación.',
      cards: [
        { title: 'Años de experiencia', desc: 'Cuatro décadas resolviendo proyectos marítimos e industriales en Chile.', metric: '40+', is_dark: true },
        { title: 'Ingeniería especializada', desc: 'Ingeniería de aplicación propia: la solución se dimensiona, no se cotiza de catálogo.' },
        { title: 'Representantes oficiales', desc: 'Representación directa de cinco fabricantes internacionales, con respaldo y garantía de fábrica.' },
        { image: '/images/inspección-de-compon-94016740.jpg', caption: 'Equipo en terreno' },
        { title: 'Cobertura nacional y regional', desc: 'Presencia donde está la operación: puertos, astilleros, faenas y centros de cultivo.' },
        { title: 'Puesta en marcha y soporte', desc: 'Comisionamiento, capacitación a la tripulación y asistencia después de la entrega.' },
      ],
    },
    cta_banner: {
      heading: 'Evaluación técnica sin costo para dimensionar su proyecto',
      description: 'Revise requerimientos de caudal, normativa OMI / DIRECTEMAR, espacio disponible y tiempos de entrega con nuestros ingenieros de aplicación.',
      primary_button: {
        label: 'Solicitar evaluación técnica',
        url: '/contacto/?tipo=evaluacion',
      },
      secondary_button: {
        label: 'Contactar a ingeniería',
        url: '/contacto/?tipo=servicio',
      },
      background_image: '/images/index-img-7-85955fa0.jpg',
    },
    faqs: {
      heading: 'Preguntas frecuentes de ingeniería',
      items: [
        {
          question: '¿Cómo se determina si un buque requiere sistema ICCP o ánodos de sacrificio?',
          answer: 'Depende del perfil operativo, área mojada del casco, tiempo entre diques y costo de ciclo de vida. ICCP ofrece control regulable en tiempo real sin reposición física en cada carena.',
        },
        {
          question: '¿Qué certificaciones tienen las plantas de tratamiento de aguas servidas que suministran?',
          answer: 'Equipos certificados bajo la Resolución MEPC.227(64) de la OMI (MARPOL Anexo IV) y aprobados por las principales casas clasificadoras (DNV, Lloyd\'s Register, ABS, BV).',
        },
        {
          question: '¿MITSA realiza la puesta en marcha en cualquier puerto de Chile?',
          answer: 'Sí, nuestros ingenieros de servicio técnico operan en todo Chile (Arica a Punta Arenas) y en puertos de la región para comisionamiento, pruebas de mar y capacitación.',
        },
        {
          question: '¿Cómo solicito repuestos originales de marcas representadas?',
          answer: 'A través de nuestro portal de repuestos o contacto directo, indicando fabricante, modelo, número de serie y número de parte (P/N) de la placa del equipo.',
        },
      ],
    },
  },
};

/**
 * Dataset estático de fallback para la página "Nosotros".
 */
export const NOSOTROS_FALLBACK_DATA = {
  slug: 'nosotros',
  title: 'Nosotros · Trayectoria y Especialistas en Tecnología Marina | MITSA',
  seo: {
    meta_title: 'Nosotros · Trayectoria y Especialistas en Tecnología Marina | MITSA',
    meta_description: 'Pioneros en tecnología marina y ambiental en Chile desde 1982. Representantes oficiales de EVAC, Cathelco, ERMA FIRST, EPE y BLÜCHER.',
    canonical_url: 'https://mitsachile.com/nosotros/',
    og_image: 'https://mitsachile.com/images/oficina-mitsa-54b17efd.jpg',
    og_type: 'website' as const,
  },
  sections: {
    hero: {
      title: 'Cuatro décadas integrando ingeniería, tecnología y servicio especializado',
      tagline: '«Todos tenemos una especialidad, la nuestra es servir»',
      description: 'Pioneros en introducir tecnología avanzada en el segmento sanitario y ambiental para uso marino, industrial, pesquero, acuícola y minero en Chile y Latinoamérica desde 1982.',
      image: '/images/oficina-mitsa-54b17efd.jpg',
    },
    story: {
      title: 'Pioneros en tecnología marina y ambiental desde 1982',
      paragraphs: [
        'Fundada en 1982 en Reñaca, Viña del Mar, MITSA nació con la convicción de conectar a las industrias marítimas y productivas de Chile con los inventores y fabricantes de tecnología de mayor estándar mundial.',
        'A lo largo de más de cuatro décadas, hemos evolucionado de la provisión de equipos sanitarios al vacío hacia la ingeniería de aplicación integral, comisionamiento y respaldo operativo en terreno en todo el país.',
      ],
      milestones: [
        { year: '1982', title: 'Fundación en Reñaca, Viña del Mar', description: 'Inicio de operaciones representando tecnología pionera sanitaria marina.' },
        { year: '1995', title: 'Expansión a Flotas y Astilleros', description: 'Consolidación en buques de la Armada de Chile, marina mercante y salmonicultura.' },
        { year: '2010', title: 'Alianzas Globales de Fabricación', description: 'Representación directa y exclusiva de EVAC, Cathelco, ERMA FIRST, EPE y BLÜCHER.' },
        { year: '2026', title: 'Ingeniería y Presencia Regional', description: 'Proyectos de retrofit, BWTS D-2, protección ICCP y servicios en Chile y Latinoamérica.' },
      ],
    },
    mission_vision: {
      mission: {
        title: 'Nuestra Misión',
        text: 'Liderar el mercado chileno y latinoamericano en la provisión de tecnologías y equipos para el cuidado del medio ambiente acuático, manteniendo altos estándares de calidad y servicio.',
      },
      vision: {
        title: 'Nuestra Visión',
        text: 'Ofrecer soluciones integrales y especializadas para el cuidado del medio ambiente acuático, utilizando tecnologías avanzadas y representando a las compañías líderes a nivel mundial.',
      },
    },
    pillars: {
      heading: 'Los pilares que fundamentan nuestra propuesta',
      items: [
        { title: 'Representación Oficial Directa', description: 'Vínculo directo sin intermediarios con fabricantes líderes mundiales e inventores de la tecnología.' },
        { title: 'Ingeniería de Aplicación Propia', description: 'Dimensionamiento a medida, selección de materiales y cumplimiento estricto de normativas internacionales.' },
        { title: 'Servicio Técnico en Terreno', description: 'Ingenieros especialistas para puesta en marcha, pruebas de mar, mantenciones y capacitación.' },
        { title: 'Cuidado del Medio Ambiente Acuático', description: 'Tecnologías certificadas bajo normas OMI MARPOL Anexo IV y D-2 para cero impacto ambiental.' },
      ],
    },
    coverage: {
      title: 'Presencia estratégica en Chile y la región',
      description: 'Desde nuestra sede central en Reñaca, Viña del Mar, atendemos faenas, astilleros, puertos y centros acuícolas a lo largo de toda la costa de Chile y brindamos soporte para proyectos en Sudamérica.',
      headquarters: 'Reñaca, Viña del Mar, Región de Valparaíso, Chile',
      scope: 'Nacional (Arica a Punta Arenas) y Latinoamérica',
    },
    cta: {
      heading: 'Conozca cómo nuestros ingenieros pueden respaldar su próximo proyecto',
      description: 'Contáctenos para evaluar requerimientos técnicos, dimensionamiento de equipos o asistencia en terreno.',
      button: {
        label: 'Contactar al equipo de ingeniería',
        url: '/contacto/',
      },
    },
  },
};

/**
 * Dataset estático de fallback para la página "Servicios".
 */
export const SERVICIOS_FALLBACK_DATA = {
  slug: 'servicios',
  title: 'Servicios de Ingeniería Marina, Suministro y Puesta en Marcha | MITSA',
  seo: {
    meta_title: 'Servicios de Ingeniería Marina, Suministro y Puesta en Marcha | MITSA',
    meta_description: 'Servicios integrales de ingeniería marítima: dimensionamiento a bordo, suministro oficial, supervisión de montaje, comisionamiento, repuestos originales y soporte.',
    canonical_url: 'https://mitsachile.com/servicios/',
    og_image: 'https://mitsachile.com/images/montaje-y-supervisió-55f086a2.jpg',
    og_type: 'website' as const,
  },
  sections: {
    hero: {
      title: 'El equipo llega. Alguien tiene que responder por él.',
      description: 'Seis servicios que cubren el ciclo completo: desde el levantamiento a bordo hasta el repuesto que se necesita cinco años después de la entrega.',
      primary_button: {
        label: 'Solicitar servicio técnico',
        url: '/contacto/?tipo=servicio',
      },
      secondary_button: {
        label: 'Pedir repuestos',
        url: '/contacto/?tipo=repuestos',
      },
      image: '/images/montaje-y-supervisió-55f086a2.jpg',
    },
    metrics: [
      { value: '6', label: 'servicios sobre el mismo sistema' },
      { value: '5', label: 'fabricantes representados directamente' },
      { value: '100%', label: 'cobertura de puertos y astilleros en Chile' },
    ],
    catalog: [
      {
        num: '01',
        executor: 'Ejecuta MITSA',
        title: 'Ingeniería y dimensionamiento',
        desc: 'Levantamiento a bordo, cálculo de capacidad y definición del sistema antes de cotizar. El alcance queda formalizado por escrito para evitar sobrecostos en obra.',
        tags: ['Levantamiento a bordo', 'Memoria de cálculo', 'Planos de integración CAD'],
        image: '/images/ingeniería-y-dimensi-fcbfca32.jpg',
      },
      {
        num: '02',
        executor: 'Ejecuta MITSA',
        title: 'Suministro e importación oficial',
        desc: 'Equipos de las cinco representadas con garantía directa de fábrica, gestión aduanera e integración con la carta Gantt del astillero o armador.',
        tags: ['Importación directa', 'Garantía de fábrica', 'Coordinación de plazos'],
        image: '/images/suministro-832ba3a1.jpg',
      },
      {
        num: '03',
        executor: 'MITSA · Astillero',
        title: 'Montaje y supervisión',
        desc: 'Supervisión técnica de montaje mecánico, eléctrico e hidráulico durante la instalación, tanto en dique como con la nave en operación.',
        tags: ['Supervisión en obra', 'Protocolos de montaje', 'Registro fotográfico'],
        image: '/images/montaje-y-supervisió-55f086a2.jpg',
      },
      {
        num: '04',
        executor: 'MITSA + Fabricante',
        title: 'Puesta en marcha y comisionamiento',
        desc: 'Pruebas de mar, ajuste de parámetros, calibración de sensores, capacitación a la tripulación y emisión del acta de entrega oficial.',
        tags: ['Pruebas de mar', 'Capacitación tripulación', 'Acta de entrega'],
        image: '/images/puesta-en-marcha-b7442d66.jpg',
      },
      {
        num: '05',
        executor: 'Ejecuta MITSA',
        title: 'Repuestos originales y retrofit',
        desc: 'Identificación exacta por número de parte (P/N), reemplazo de componentes obsoletos y actualización de sistemas sanitarios o de tratamiento sin rehacer la red completa.',
        tags: ['N° de parte oficial', 'Stock crítico', 'Actualización normativa'],
        image: '/images/repuestos-y-retrofit-4936b635.jpg',
      },
      {
        num: '06',
        executor: 'Ejecuta MITSA',
        title: 'Soporte y continuidad operacional',
        desc: 'Diagnóstico remoto de alarmas, visitas técnicas de emergencia en puerto y programas de mantenimiento preventivo durante toda la vida útil del buque.',
        tags: ['Diagnóstico remoto', 'Visita en terreno', 'Plan de mantenimiento'],
        image: '/images/técnico-en-terreno-c-3f561914.jpg',
      },
    ],
    process: {
      heading: 'Proceso de asesoramiento y cotización técnica',
      subheading: 'Metodología estructurada de 4 etapas que asegura la compatibilidad exacta entre el requerimiento operativo y el diseño del fabricante.',
      steps: [
        { step: '01', title: '1. Requerimiento', description: 'El cliente solicita cotizar un sistema, equipo o elemento específico para su embarcación o instalación.' },
        { step: '02', title: '2. Evaluación', description: 'MITSA evalúa junto con sus representadas las alternativas de diseño de cada fabricante según precio, innovación, normativa y calidad.' },
        { step: '03', title: '3. Presentación', description: 'Presentamos al cliente las mejores opciones técnicas y comerciales que satisfacen plenamente su necesidad.' },
        { step: '04', title: '4. Suministro & Soporte', description: 'Una vez elegida la opción, se procede al suministro, coordinación de entrega e inicio del plan de acompañamiento operativo.' },
      ],
    },
    cta: {
      heading: '¿Tiene un proyecto naval o industrial en curso?',
      description: 'Revise requerimientos de caudal, espacio y plazos de entrega directamente con nuestros ingenieros de aplicación.',
      primary_button: {
        label: 'Solicitar evaluación técnica',
        url: '/contacto/?tipo=evaluacion',
      },
      secondary_button: {
        label: 'Consultar repuestos',
        url: '/contacto/?tipo=repuestos',
      },
    },
  },
};

/**
 * Dataset estático de fallback para la página "Industrias / Sectores".
 */
export const INDUSTRIAS_FALLBACK_DATA = {
  slug: 'industrias',
  title: 'Sectores e Industrias · Soluciones Navales, Acuícolas e Industriales | MITSA',
  seo: {
    meta_title: 'Sectores e Industrias · Soluciones Navales, Acuícolas e Industriales | MITSA',
    meta_description: 'Soluciones de ingeniería naval, sanitaria y ambiental por sector: Naval & Defensa, Astilleros, Acuicultura, Offshore, Transporte Marítimo e Instalaciones en Tierra.',
    canonical_url: 'https://mitsachile.com/industrias/',
    og_image: 'https://mitsachile.com/images/naval-y-defensa-5b2a62fc.jpg',
    og_type: 'website' as const,
  },
  sections: {
    hero: {
      title: 'Cada industria exige una respuesta técnica distinta',
      description: 'La solución no la define el catálogo: la definen la normativa que aplica, la ventana de intervención disponible y qué pasa si el sistema se detiene.',
      primary_button: {
        label: 'Solicitar evaluación técnica',
        url: '/contacto/?tipo=evaluacion',
      },
      secondary_button: {
        label: 'Ver sectores',
        url: '#sectores',
      },
    },
    industries: [
      {
        id: 'naval',
        num: '01',
        title: 'Naval y defensa',
        desc: 'Fragatas, OPVs y patrulleras: construcción nueva, modernización y disponibilidad operacional bajo estrictos requisitos de clase militar.',
        tags: ['Sanitarios al vacío', 'ICCP', 'Aguas residuales', 'Agua dulce'],
        image: '/images/naval-y-defensa-5b2a62fc.jpg',
      },
      {
        id: 'acuicultura',
        num: '02',
        title: 'Acuicultura y pesca',
        desc: 'Wellboats, pontones y centros de cultivo con tripulación permanente y ventanas de mantenimiento sumamente acotadas.',
        tags: ['Sanitarios', 'Agua dulce', 'Repuestos', 'ICAF'],
        image: '/images/acuicultura-64fec532.jpg',
      },
      {
        id: 'offshore',
        num: '03',
        title: 'Offshore y energía',
        desc: 'Plataformas y unidades de apoyo marítimo (PSV/AHTS) donde el espacio, el peso y la descarga de efluentes están fuertemente normados.',
        tags: ['BWTS', 'ICAF', 'Drenajes', 'Aguas residuales'],
        image: '/images/offshore-y-energía-37f4cf0d.jpg',
      },
      {
        id: 'astilleros',
        num: '04',
        title: 'Astilleros y reparación',
        desc: 'Integración de sistemas durante construcción nueva o retrofit en dique seco, coordinado con la carta Gantt del astillero.',
        tags: ['Retrofit', 'Montaje', 'Puesta en marcha', 'Supervisión'],
        image: '/images/astilleros-y-reparac-9d3b1bf1.jpg',
      },
      {
        id: 'carga',
        num: '05',
        title: 'Transporte marítimo y carga',
        desc: 'Flotas mercantes y portacontenedores que deben cumplir convenios MARPOL y agua de lastre D-2 sin alterar su itinerario.',
        tags: ['BWTS', 'Aguas residuales', 'Servicio a bordo', 'ICCP'],
        image: '/images/transporte-marítimo--e848a060.jpg',
      },
      {
        id: 'tierra',
        num: '06',
        title: 'Instalaciones en tierra y minería',
        desc: 'Plantas industriales, faenas mineras y edificios donde no existe cota de pendiente para redes de evacuación por gravedad.',
        tags: ['Sanitarios al vacío', 'Drenajes inox', 'Agua caliente', 'Efluentes'],
        image: '/images/instalaciones-en-tie-f9537988.jpg',
      },
    ],
    criteria: {
      heading: 'Criterios de ingeniería por industria',
      subheading: 'Variables críticas de diseño que evalúan nuestros ingenieros de aplicación para cada tipo de instalación.',
      items: [
        {
          title: 'Normativa y Certificaciones de Clase',
          description: 'Cumplimiento estricto con IMO MARPOL (Anexo IV y D-2), SOLAS, USCG y casas clasificadoras (DNV, Lloyd\'s Register, ABS).',
        },
        {
          title: 'Ventanas de Intervención en Faena',
          description: 'Coordinación con recaladas acotadas, diques secos y paradas de planta programadas para evitar sobrecostos por detención.',
        },
        {
          title: 'Redundancia y Continuidad Operativa',
          description: 'Diseño con bombas duplicadas, módulos en standby y repuestos críticos garantizados por el fabricante.',
        },
        {
          title: 'Eficiencia Hídrica y Energética',
          description: 'Reducción de consumo de agua hasta un 90% mediante sistemas al vacío e intercambiadores térmicos de alta eficiencia.',
        },
      ],
    },
    cta: {
      heading: '¿Necesita dimensionar una solución para su sector?',
      description: 'Nuestros ingenieros evalúan requerimientos específicos de espacio, caudal y normativas aplicables a su industria.',
      button: {
        label: 'Contactar a ingeniería de aplicación',
        url: '/contacto/?tipo=evaluacion',
      },
    },
  },
};

/**
 * Dataset estático de fallback para las Opciones Globales del Sitio.
 */
export const SITE_OPTIONS_FALLBACK_DATA = {
  brand: {
    name: 'MITSA SpA',
    tagline: 'Integramos tecnología. Resolvemos desafíos.',
    since: 'Desde 1982',
    logo_main: '/images/mitsa-27703545.svg',
    logo_white: '/images/mitsa-0e284396.svg',
    favicon: '/favicon.ico',
  },
  header: {
    announcement: '',
    btn_repuestos_label: 'Repuestos',
    btn_repuestos_url: '/contacto/?tipo=repuestos',
    btn_cta_label: 'Conversemos',
    btn_cta_url: '/contacto/',
  },
  footer: {
    statement_prefix: 'Integramos',
    statement_prefix_sub: 'tecnología.',
    statement_suffix: 'Resolvemos',
    statement_suffix_sub: 'desafíos.',
    description: 'Ingeniería de aplicación, suministro, retrofit y soporte postventa para sistemas marítimos e industriales.',
    location: 'Reñaca, Viña del Mar · Chile',
    copyright: '© 2026 MITSA SpA. Todos los derechos reservados.',
    agency_name: 'AplicacionesWeb',
    agency_url: 'https://aplicacionesweb.cl',
  },
  contact: {
    email_general: 'contacto@mitsachile.com',
    email_sales: 'fjdelaiglesia@mitsachile.com',
    phone_main: '+56 32 2835055',
    phone_mobile: '+56 9 9876 5432',
    address: 'Av. Edmundo Eluchans 1737, Of. 61, Reñaca, Viña del Mar, Chile',
    whatsapp: '+56998765432',
  },
  social: {
    linkedin: 'https://www.linkedin.com/company/mitsa-chile',
    catalog_pdf: '/recursos/catalogo-general-mitsa.pdf',
    smm_expo: '/smm2026/',
  },
};

/**
 * Dataset estático de fallback para la página "Proyectos & Casos de Éxito".
 */
export const PROYECTOS_FALLBACK_DATA = {
  slug: 'proyectos',
  title: 'Proyectos & Casos de Éxito · Casos de Ingeniería en Chile y Latinoamérica | MITSA',
  seo: {
    meta_title: 'Proyectos & Casos de Éxito · Casos de Ingeniería en Chile y Latinoamérica | MITSA',
    meta_description: 'Casos representativos de ingeniería naval y ambiental instalados y operando en Chile: Armada, astilleros, navieras, minería y acuicultura.',
    canonical_url: 'https://mitsachile.com/proyectos/',
    og_image: 'https://mitsachile.com/images/proyectos-img-2-149f33fe.jpg',
    og_type: 'website' as const,
  },
  sections: {
    hero: {
      title: 'Lo que ya está instalado y operando.',
      description: 'Cada proyecto publica el sistema, la industria y el fabricante detrás. Casos reales y representativos respaldados por 40 años de trayectoria.',
      image: '/images/proyectos-img-2-149f33fe.jpg',
      primary_button: {
        label: 'Ver proyectos',
        url: '#catalogo-proyectos',
      },
      secondary_button: {
        label: 'Solicitar referencias',
        url: '/contacto/?tipo=evaluacion',
      },
    },
    metrics: [
      { value: '40+', label: 'años integrando sistemas en Chile' },
      { value: '10', label: 'líneas de solución en operación' },
      { value: '100%', label: 'cumplimiento en protocolos y pruebas de mar' },
    ],
    projects: [
      {
        num: '01',
        sector: 'Astillero',
        title: 'Astillero — Construcción nueva',
        description: 'Sistema sanitario al vacío completo para una unidad en construcción, dimensionado antes del corte de primera plancha de acero.',
        tags: ['Astillero', 'Sanitarios al vacío', 'EVAC'],
        image: '/images/proyectos-img-3-636210b7.jpg',
        url: '/contacto/?tipo=evaluacion&proyecto=astillero-construccion-nueva',
      },
      {
        num: '02',
        sector: 'Buques de apoyo',
        title: 'Buque de apoyo (PSV) — Retrofit',
        description: 'Reemplazo integral de la planta de tratamiento de aguas servidas con la nave en operación, sin alterar la red troncal existente.',
        tags: ['Buques de apoyo', 'Aguas residuales', 'EVAC · BLÜCHER'],
        image: '/images/proyectos-img-4-8d5d1037.jpg',
        url: '/contacto/?tipo=evaluacion&proyecto=buque-de-apoyo-psv-retrofit',
      },
      {
        num: '03',
        sector: 'Offshore',
        title: 'Plataforma offshore — Protección catódica',
        description: 'Protección catódica por corriente impresa (ICCP) y control de bioincrustación (ICAF) en estructura fija con monitoreo automático continuo.',
        tags: ['Offshore', 'ICCP · ICAF', 'Cathelco'],
        image: '/images/proyectos-img-5-8886341c.jpg',
        url: '/contacto/?tipo=evaluacion&proyecto=plataforma-offshore-proteccion-catodica',
      },
      {
        num: '04',
        sector: 'Acuicultura',
        title: 'Centro de cultivo — Pontón habitable',
        description: 'Tratamiento de efluentes y saneamiento integral en pontón habitable con logística y soporte de repuestos en la Región de Los Lagos.',
        tags: ['Acuicultura', 'Tratamiento de aguas', 'ERMA FIRST'],
        image: '/images/proyectos-img-6-6ece81b5.jpg',
        url: '/contacto/?tipo=evaluacion&proyecto=centro-de-cultivo-ponton-habitable',
      },
      {
        num: '05',
        sector: 'Pesca',
        title: 'Flota pesquera — Redes al vacío continuas',
        description: 'Modernización de sistemas sanitarios y drenajes inoxidables en flota de alta mar para operaciones continuas en aguas frías.',
        tags: ['Pesca industrial', 'Vacío marino', 'BLÜCHER · EVAC'],
        image: '/images/proyectos-img-2-149f33fe.jpg',
        url: '/contacto/?tipo=evaluacion&proyecto=flota-pesquera-redes-al-vacio-continuas',
      },
      {
        num: '06',
        sector: 'Minería e Industria',
        title: 'Campamento minero — Evacuación sin pendiente',
        description: 'Red de vacío en terreno plano para campamento en altura geográfica, eliminando excavaciones profundas y optimizando consumo de agua.',
        tags: ['Minería, Drenajes', 'EVAC · BLÜCHER'],
        image: '/images/instalaciones-en-tie-f9537988.jpg',
        url: '/contacto/?tipo=evaluacion&proyecto=campamento-minero-evacuacion-sin-pendiente',
      },
    ],
    methodology: {
      heading: '¿Cómo ejecutamos cada proyecto?',
      description: 'Desde la ingeniería de preventa hasta las pruebas de mar y el soporte postventa a largo plazo.',
      steps: [
        {
          step: '01',
          title: '1. Levantamiento & Viabilidad',
          description: 'Evaluación de planos, requerimientos de caudal, consumo energético y espacios disponibles en la nave o instalación.',
        },
        {
          step: '02',
          title: '2. Ingeniería & Suministro',
          description: 'Selección directa con los fabricantes representados y coordinación de plazos de entrega en puerto o faena.',
        },
        {
          step: '03',
          title: '3. Supervisión & Puesta en Marcha',
          description: 'Acompañamiento en dique seco o terreno por ingenieros certificados para pruebas FAT/HAT y comisionamiento.',
        },
        {
          step: '04',
          title: '4. Garantía & Soporte Continuo',
          description: 'Entrega de protocolos a inspectores de clase, capacitación a tripulación y provisión continua de repuestos originales.',
        },
      ],
    },
    cta: {
      heading: '¿Tiene un proyecto naval o industrial en evaluación?',
      description: 'Podemos compartir casos técnicos de referencia similares y coordinar una reunión con nuestros ingenieros de aplicación.',
      button: {
        label: 'Solicitar referencias de ingeniería',
        url: '/contacto/?tipo=evaluacion',
      },
    },
  },
};

/**
 * Dataset estático de fallback para la página "Recursos & Biblioteca Técnica".
 */
export const RECURSOS_FALLBACK_DATA = {
  slug: 'recursos',
  title: 'Recursos & Biblioteca Técnica · Artículos Regulatorios y Descargas | MITSA',
  seo: {
    meta_title: 'Recursos & Biblioteca Técnica · Artículos Regulatorios y Descargas | MITSA',
    meta_description: 'Artículos técnicos de ingeniería naval, guías regulatorias OMI/DIRECTEMAR (D-2, ICCP, MARPOL, ósmosis) y biblioteca de descargas de MITSA.',
    canonical_url: 'https://mitsachile.com/recursos/',
    og_image: 'https://mitsachile.com/images/recursos-img-2-92bb5d09.jpg',
    og_type: 'website' as const,
  },
  sections: {
    hero: {
      title: 'El criterio técnico, publicado.',
      description: 'Artículos abiertos sobre normativa marítima, documentación técnica de representadas y protocolos de ingeniería para clientes.',
      image: '/images/recursos-img-2-92bb5d09.jpg',
      primary_button: {
        label: 'Ver artículos técnicos',
        url: '#articulos',
      },
      secondary_button: {
        label: 'Biblioteca de descargas',
        url: '#biblioteca',
      },
    },
    gateways: [
      {
        badge: 'Centro Técnico',
        title: 'Cómo se decide un sistema a bordo',
        description: 'Artículos abiertos sobre dimensionamiento, normativa OMI, DIRECTEMAR y mejores prácticas de mantenimiento preventivo.',
        link_label: 'Ver artículos técnicos →',
        link_url: '#articulos',
      },
      {
        badge: 'Biblioteca Técnica',
        title: 'Fichas, manuales y protocolos',
        description: 'Documentación de las representadas oficiales (EVAC, Cathelco, ERMA FIRST, EPE, BLÜCHER), organizada por equipo.',
        link_label: 'Entrar a la biblioteca →',
        link_url: '#biblioteca',
      },
    ],
    articles: [
      {
        slug: 'norma-d2-omi-chile-agua-lastre',
        title: 'Norma D-2 OMI en Chile: Plazos, Exigencias y Soluciones BWTS',
        description: 'Guía técnica sobre la implementación del estándar D-2 del Convenio BWM en naves que operan en aguas jurisdiccionales chilenas.',
        category: 'Agua de Lastre · OMI',
        status: 'Borrador Técnico',
        summary: 'Análisis técnico y normativo para el cumplimiento de tratamiento de agua de lastre bajo inspección DIRECTEMAR.',
      },
      {
        slug: 'circular-a-52-007-directemar-aguas-grises-negras',
        title: 'Circular A-52/007 de DIRECTEMAR: Tratamiento de Aguas Servidas',
        description: 'Exigencias de descarga y certificación para naves mayores, pontones y artefactos navales en aguas interiores y bahías chilenas.',
        category: 'DIRECTEMAR · Aguas Servidas',
        status: 'Borrador Técnico',
        summary: 'Requisitos de muestreo, límites de descarga de coliformes fecales y DQO según la autoridad marítima nacional.',
      },
      {
        slug: 'iccp-vs-anodos-sacrificio-proteccion-catodica-chile',
        title: 'Protección Catódica ICCP vs. Ánodos de Sacrificio',
        description: 'Comparativa técnico-económica para cascos de acero en buques mercantes, naves de defensa y plataformas marinas en Chile.',
        category: 'Protección Catódica · Casco',
        status: 'Borrador Técnico',
        summary: 'Cuándo conviene migrar de ánodos galvánicos a corriente impresa automática (ICCP) en dique seco.',
      },
      {
        slug: 'osmosis-inversa-marina-desalinizacion-a-bordo',
        title: 'Ósmosis Inversa Marina: Desalinización Confiable a Bordo',
        description: 'Dimensionamiento, pretratamiento y mantenimiento de plantas desalinizadoras para autonomía de tripulación y faenas en alta mar.',
        category: 'Generación de Agua Dulce',
        status: 'Borrador Técnico',
        summary: 'Criterios de ingeniería para evitar incrustación de membranas y asegurar agua potable continua.',
      },
      {
        slug: 'marpol-anexo-iv-planta-tratamiento-aguas-servidas-chile',
        title: 'MARPOL Anexo IV y Resolución MEPC.227(64): Plantas Marinas',
        description: 'Estándares internacionales de prevención de la contaminación por aguas sucias procedentes de los buques y zonas especiales.',
        category: 'MARPOL · Tratamiento Marino',
        status: 'Borrador Técnico',
        summary: 'Diferencias entre plantas de tratamiento biológico MBBR vs físico-químico y su aprobación de tipo.',
      },
    ],
    downloads: [
      {
        title: 'Catálogo General de Soluciones MITSA 2026',
        format: 'PDF · 4.2 MB',
        level: 'Descarga Libre',
        url: '/docs/brochure-extracto.pdf',
      },
      {
        title: 'Ficha Técnica — Sistema Sanitario al Vacío EVAC',
        format: 'PDF · 1.8 MB',
        level: 'Acceso Libre',
        url: '/contacto/?tipo=evaluacion',
      },
      {
        title: 'Manual de Operación de Plantas de Tratamiento de Aguas Servidas',
        format: 'PDF · 3.1 MB',
        level: 'Clientes / Registro',
        url: '/contacto/?tipo=evaluacion',
      },
      {
        title: 'Listado de Repuestos Críticos y Números de Parte (P/N)',
        format: 'XLSX / PDF',
        level: 'Clientes',
        url: '/contacto/?tipo=repuestos',
      },
      {
        title: 'Protocolo de Comisionamiento y Pruebas de Puesta en Marcha',
        format: 'PDF · 950 KB',
        level: 'Acceso con Registro',
        url: '/contacto/?tipo=servicio',
      },
    ],
    cta: {
      heading: '¿Necesita documentación técnica específica o certificación de fábrica?',
      description: 'Gestionamos directamente con los fabricantes las fichas de homologación, certificados tipo (Type Approval) y planos de montaje para su proyecto.',
      button: {
        label: 'Solicitar documentación técnica',
        url: '/contacto/?tipo=evaluacion',
      },
    },
  },
};

/**
 * Dataset estático de fallback para la página "Contacto & Asesoría Técnica".
 */
export const CONTACTO_FALLBACK_DATA = {
  slug: 'contacto',
  title: 'Contacto & Asesoría Técnica · Canales de Ingeniería y Soporte | MITSA',
  seo: {
    meta_title: 'Contacto & Asesoría Técnica · Canales de Ingeniería y Soporte | MITSA',
    meta_description: 'Canales de contacto especializados de MITSA: evaluación de proyectos, cotización de repuestos originales, servicio técnico a bordo y cobertura regional en 8 países.',
    canonical_url: 'https://mitsachile.com/contacto/',
    og_image: 'https://mitsachile.com/images/recursos-img-2-92bb5d09.jpg',
    og_type: 'website' as const,
  },
  sections: {
    hero: {
      title: 'Cuéntenos qué necesita resolver',
      description: 'Cada requerimiento pide datos distintos. Elegir la puerta correcta conecta su consulta directo con el especialista correspondiente.',
    },
    doors: [
      {
        key: 'evaluacion',
        num: '01',
        title: 'Evaluación técnica',
        description: 'Proyecto nuevo o retrofit que requiere dimensionar una solución.',
      },
      {
        key: 'repuestos',
        num: '02',
        title: 'Repuestos',
        description: 'Identificación y cotización de piezas por número de parte (P/N).',
      },
      {
        key: 'servicio',
        num: '03',
        title: 'Servicio técnico',
        description: 'Diagnóstico, comisionamiento o asistencia sobre un sistema.',
      },
      {
        key: 'general',
        num: '04',
        title: 'Contacto general',
        description: 'Consultas comerciales, institucionales o de representación.',
      },
    ],
    channels: {
      address: 'Av. Vicuña Mackenna 882, Reñaca, Viña del Mar, Chile',
      branch: 'Av. Edmundo Eluchans 1737, Of. 61, Reñaca, Viña del Mar',
      phone_main: '+56 32 2835055',
      phone_mobile: '+56 9 9876 5432',
      email_general: 'contacto@mitsachile.com',
      email_sales: 'fjdelaiglesia@mitsachile.com',
      hours: 'Lunes a Viernes: 08:30 a 18:00 hrs',
    },
    coverage: {
      title: 'Presencia y Cobertura Regional',
      description: 'Atención comercial y soporte de ingeniería para proyectos marítimos e industriales en 8 países de Latinoamérica.',
      countries: ['Chile', 'Perú', 'Ecuador', 'Colombia', 'Panamá', 'Paraguay', 'Bolivia', 'Venezuela'],
    },
    form: {
      action_url: 'https://formspree.io/f/placeholder',
      title: 'Formulario de contacto y asesoría técnica',
      description: 'Complete los datos requeridos y nuestro equipo técnico le responderá en menos de 24 horas hábiles.',
    },
  },
};

/**
 * Dataset estático de fallback para la página "Marcas Representadas".
 */
export const REPRESENTADAS_FALLBACK_DATA = {
  slug: 'representadas',
  title: 'Marcas Representadas Oficiales · Tecnologías Marinas y Sanitarias | MITSA',
  seo: {
    meta_title: 'Marcas Representadas Oficiales · Tecnologías Marinas y Sanitarias | MITSA',
    meta_description: 'Representación oficial en Chile y Latinoamérica: EVAC, Cathelco, ERMA FIRST, EPE, BLÜCHER y fabricantes líderes mundiales.',
    canonical_url: 'https://mitsachile.com/representadas/',
    og_image: 'https://mitsachile.com/images/hero-1-8a9d042f.jpg',
    og_type: 'website' as const,
  },
  sections: {
    hero: {
      title: 'Marcas líderes mundiales representadas en Chile y la región.',
      description: 'Ingeniería de aplicación directa con los fabricantes, repuestos originales y certificación oficial de fábrica para sistemas marinos e industriales.',
      image: '/images/hero-1-8a9d042f.jpg',
      primary_button: {
        label: 'Ver representadas',
        url: '#marcas-principales',
      },
      secondary_button: {
        label: 'Solicitar repuestos',
        url: '/contacto/?tipo=repuestos',
      },
    },
    metrics: [
      { num: '14+', label: 'marcas internacionales representadas' },
      { num: '40+', label: 'años de alianza con fabricantes líderes' },
      { num: '100%', label: 'soporte y certificación directa de fábrica' },
    ],
    main_brands: [
      {
        name: 'EVAC',
        country: 'Finlandia',
        holding: 'Evac Group',
        category: 'Aguas y sanitarios',
        description: 'Líder mundial en sistemas sanitarios al vacío (Optima), unidades generadoras de vacío (OnlineVac) y biorreactores de membrana biológica (MBR).',
        solutions: ['Sanitarios al vacío', 'Biorreactores MBR', 'Tratamiento de aguas grises y negras'],
        image: '/images/naval-y-defensa-5b2a62fc.jpg',
        consult_url: '/contacto/?tipo=repuestos&marca=evac',
      },
      {
        name: 'Cathelco',
        country: 'Inglaterra',
        holding: 'Evac Group',
        category: 'Protección casco & Desalinización',
        description: 'Especialista en protección catódica por corriente impresa (ICCP), prevención de bioincrustación (ICAF/MGPS) y plantas desalinizadoras por ósmosis inversa (Seafresh / H2O Mk3).',
        solutions: ['Protección catódica ICCP', 'Control biofouling ICAF/MGPS', 'Ósmosis inversa marina'],
        image: '/images/plataforma-offshore-8886341c.jpg',
        consult_url: '/contacto/?tipo=repuestos&marca=cathelco',
      },
      {
        name: 'ERMA FIRST',
        country: 'Grecia',
        holding: 'Erma First Group',
        category: 'Tratamiento agua de lastre',
        description: 'Fabricante referente en sistemas de tratamiento de agua de lastre (BWTS) bajo estándar D-2 de la OMI y homologación USCG, con filtración de 40 micras y desinfección electrolítica.',
        solutions: ['FIT BWTS', 'Monitoreo por IA METIS', 'Cumplimiento OMI D-2 y USCG'],
        image: '/images/transporte-maritimo-3720ea8c.jpg',
        consult_url: '/contacto/?tipo=repuestos&marca=erma-first',
      },
      {
        name: 'EPE',
        country: 'Grecia',
        holding: 'EPE Environmental',
        category: 'Protección ambiental & Fisicoquímico',
        description: 'Más de 45 años en protección ambiental marina: plantas fisicoquímicas de aguas residuales Triton FIT (certificación DNV/MEPC.227) y equipos de contingencia.',
        solutions: ['Triton FIT 3.0 / 6.0', 'Plantas fisicoquímicas', 'Separadores de sentina'],
        image: '/images/astilleros-y-diques-0e241764.jpg',
        consult_url: '/contacto/?tipo=repuestos&marca=epe',
      },
      {
        name: 'BLÜCHER',
        country: 'Dinamarca',
        holding: 'Watts Water',
        category: 'Drenajes & Cañerías inoxidables',
        description: 'Sistemas de drenaje de alta resistencia, canaletas, sumideros y tuberías push-fit en acero inoxidable AISI 316L para buques, plantas de alimentos e industrias.',
        solutions: ['Tuberías EuroPipe AISI 316L', 'Drenajes marinos', 'Canales industriales'],
        image: '/images/acuicultura-y-pesca-6ece81b5.jpg',
        consult_url: '/contacto/?tipo=repuestos&marca=blucher',
      },
      {
        name: 'Uson Marine',
        country: 'Suecia',
        holding: 'Evac Group',
        category: 'Gestión de residuos a bordo',
        description: 'Sistemas integrales para compactación, trituración y almacenamiento higiénico de residuos sólidos y orgánicos a bordo de buques y plataformas.',
        solutions: ['Compactadores marinos', 'Trituradores orgánicos', 'Gestión de residuos'],
        image: '/images/instalaciones-en-tie-f9537988.jpg',
        consult_url: '/contacto/?tipo=repuestos&marca=uson-marine',
      },
    ],
    directory: [
      {
        name: 'Herborner Pumpen',
        country: 'Alemania',
        category: 'Bombas y fluidos',
        description: 'Bombas marinas centrífugas con recubrimiento cerámico resistente a la corrosión.',
      },
      {
        name: 'SIHI',
        country: 'Alemania',
        category: 'Bombas y vacío',
        description: 'Bombas de vacío de anillo líquido y sistemas de bombeo de procesos industriales.',
      },
      {
        name: 'Harwil',
        country: 'USA',
        category: 'Instrumentación',
        description: 'Interruptores de flujo y sensores de nivel para automatización y control de bombas.',
      },
      {
        name: 'Moyno',
        country: 'USA',
        category: 'Bombas y fluidos',
        description: 'Bombas de cavidad progresiva para lodos, fluidos viscosos y efluentes marinos.',
      },
      {
        name: 'Burks Pumps',
        country: 'USA',
        category: 'Bombas industriales',
        description: 'Bombas centrífugas y turbinas regenerativas para alta presión y servicios auxiliares.',
      },
      {
        name: 'FCI Watermaker',
        country: 'USA',
        category: 'Desalinización',
        description: 'Plantas desalinizadoras automáticas por ósmosis inversa para embarcaciones.',
      },
      {
        name: 'Planus',
        country: 'Italia',
        category: 'Aguas y sanitarios',
        description: 'Sanitarios marinos integrados y sistemas de bombeo de maceración.',
      },
      {
        name: 'Terminator',
        country: 'Chile',
        category: 'Confort & Residuos',
        description: 'Equipos compactadores y trituradores de residuos para faenas en tierra y mar.',
      },
    ],
    cta: {
      heading: '¿Requiere asesoría directa o repuestos de nuestras representadas?',
      description: 'Como representantes oficiales, contamos con acceso directo a ingeniería de fábrica, números de parte originales y tiempos prioritarios de entrega.',
      button: {
        label: 'Contactar a un especialista de marca',
        url: '/contacto/?tipo=repuestos',
      },
    },
  },
};
