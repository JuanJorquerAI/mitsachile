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
