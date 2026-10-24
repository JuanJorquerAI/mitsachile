/**
 * TypeScript Contracts & Interfaces para la API REST de MITSA (WordPress Headless)
 */

export interface ImageObject {
  url: string;
  alt: string;
  width?: number;
  height?: number;
  loading?: 'eager' | 'lazy';
  fetchpriority?: 'high' | 'low' | 'auto';
}

export interface TriageOption {
  label: string;
  url: string;
  highlight?: boolean;
}

export interface TriageData {
  title: string;
  options: TriageOption[];
  placeholder: string;
  button_text: string;
  action_url: string;
}

export interface HeroSectionData {
  title_prefix: string;
  rotating_words: string[];
  description: string;
  triage: TriageData;
}

export interface VisualCardData {
  title: string;
  image: string;
  alt: string;
  width: number;
  height: number;
  loading: 'eager' | 'lazy';
}

export interface PainPointsSectionData {
  heading: string;
  quote: string;
  author_initials: string;
  author_role: string;
  author_note: string;
  resolutions: string[];
}

export interface MetricItemData {
  value: string;
  label: string;
  highlight?: boolean;
}

export interface BrandItemData {
  name: string;
  tagline: string;
  description: string;
  url: string;
}

export interface BrandsSectionData {
  heading: string;
  items: BrandItemData[];
}

export interface SolutionItemData {
  title: string;
  brand: string;
  img: string;
  desc: string;
}

export interface SolutionsSectionData {
  heading: string;
  subheading: string;
  items: SolutionItemData[];
}

export interface WhyMitsaCardData {
  title?: string;
  desc?: string;
  metric?: string;
  is_dark?: boolean;
  image?: string;
  caption?: string;
}

export interface WhyMitsaSectionData {
  heading: string;
  subheading: string;
  cards: WhyMitsaCardData[];
}

export interface CtaButtonData {
  label: string;
  url: string;
}

export interface CtaBannerSectionData {
  heading: string;
  description: string;
  primary_button: CtaButtonData;
  secondary_button: CtaButtonData;
  background_image?: string;
}

export interface FaqItemData {
  question: string;
  answer: string;
}

export interface FaqsSectionData {
  heading: string;
  items: FaqItemData[];
}

export interface SeoMetadata {
  meta_title: string;
  meta_description: string;
  canonical_url: string;
  og_image: string;
  og_type: 'website' | 'article';
}

// Interfaces para la sección "Nosotros"
export interface NosotrosHeroData {
  title: string;
  tagline: string;
  description: string;
  image: string;
}

export interface NosotrosMilestoneData {
  year: string;
  title: string;
  description: string;
}

export interface NosotrosStoryData {
  title: string;
  paragraphs: string[];
  milestones: NosotrosMilestoneData[];
}

export interface NosotrosMissionVisionData {
  mission: {
    title: string;
    text: string;
  };
  vision: {
    title: string;
    text: string;
  };
}

export interface NosotrosPillarData {
  title: string;
  description: string;
}

export interface NosotrosPillarsData {
  heading: string;
  items: NosotrosPillarData[];
}

export interface NosotrosCoverageData {
  title: string;
  description: string;
  headquarters: string;
  scope: string;
}

export interface NosotrosCtaData {
  heading: string;
  description: string;
  button: CtaButtonData;
}

export interface NosotrosSectionsData {
  hero: NosotrosHeroData;
  story: NosotrosStoryData;
  mission_vision: NosotrosMissionVisionData;
  pillars: NosotrosPillarsData;
  coverage: NosotrosCoverageData;
  cta: NosotrosCtaData;
}

export interface NosotrosSectionsResponse {
  slug: string;
  title: string;
  seo: SeoMetadata;
  sections: NosotrosSectionsData;
}

// Interfaces para la sección "Servicios"
export interface ServiciosHeroData {
  title: string;
  description: string;
  primary_button: CtaButtonData;
  secondary_button: CtaButtonData;
  image: string;
}

export interface ServiciosMetricItemData {
  value: string;
  label: string;
}

export interface ServiciosCatalogItemData {
  num: string;
  executor: string;
  title: string;
  desc: string;
  tags: string[];
  image: string;
}

export interface ServiciosProcessStepData {
  step: string;
  title: string;
  description: string;
}

export interface ServiciosProcessData {
  heading: string;
  subheading: string;
  steps: ServiciosProcessStepData[];
}

export interface ServiciosCtaData {
  heading: string;
  description: string;
  primary_button: CtaButtonData;
  secondary_button: CtaButtonData;
}

export interface ServiciosSectionsData {
  hero: ServiciosHeroData;
  metrics: ServiciosMetricItemData[];
  catalog: ServiciosCatalogItemData[];
  process: ServiciosProcessData;
  cta: ServiciosCtaData;
}

export interface ServiciosSectionsResponse {
  slug: string;
  title: string;
  seo: SeoMetadata;
  sections: ServiciosSectionsData;
}

// Interfaces para la sección "Industrias / Sectores"
export interface IndustriasHeroData {
  title: string;
  description: string;
  primary_button: CtaButtonData;
  secondary_button: CtaButtonData;
}

export interface IndustriasSectorItemData {
  id: string;
  num: string;
  title: string;
  desc: string;
  tags: string[];
  image: string;
}

export interface IndustriasCriteriaItemData {
  title: string;
  description: string;
}

export interface IndustriasCriteriaData {
  heading: string;
  subheading: string;
  items: IndustriasCriteriaItemData[];
}

export interface IndustriasCtaData {
  heading: string;
  description: string;
  button: CtaButtonData;
}

export interface IndustriasSectionsData {
  hero: IndustriasHeroData;
  industries: IndustriasSectorItemData[];
  criteria: IndustriasCriteriaData;
  cta: IndustriasCtaData;
}

export interface IndustriasSectionsResponse {
  slug: string;
  title: string;
  seo: SeoMetadata;
  sections: IndustriasSectionsData;
}

// Interfaces para la sección "Proyectos & Casos de Éxito"
export interface ProyectosHeroData {
  title: string;
  description: string;
  image: string;
  primary_button: CtaButtonData;
  secondary_button: CtaButtonData;
}

export interface ProyectosCaseItemData {
  num: string;
  sector: string;
  title: string;
  description: string;
  tags: string[];
  image: string;
  url: string;
}

export interface ProyectosMethodologyStepData {
  step: string;
  title: string;
  description: string;
}

export interface ProyectosMethodologyData {
  heading: string;
  description: string;
  steps: ProyectosMethodologyStepData[];
}

export interface ProyectosCtaData {
  heading: string;
  description: string;
  button: CtaButtonData;
}

export interface ProyectosSectionsData {
  hero: ProyectosHeroData;
  metrics: MetricItemData[];
  projects: ProyectosCaseItemData[];
  methodology: ProyectosMethodologyData;
  cta: ProyectosCtaData;
}

export interface ProyectosSectionsResponse {
  slug: string;
  title: string;
  seo: SeoMetadata;
  sections: ProyectosSectionsData;
}

// Interfaces para la sección "Recursos & Biblioteca Técnica"
export interface RecursosHeroData {
  title: string;
  description: string;
  image: string;
  primary_button: CtaButtonData;
  secondary_button: CtaButtonData;
}

export interface RecursosGatewayData {
  badge: string;
  title: string;
  description: string;
  link_label: string;
  link_url: string;
}

export interface RecursosArticleItemData {
  slug: string;
  title: string;
  description: string;
  category: string;
  status?: string;
  summary?: string;
}

export interface RecursosDownloadItemData {
  title: string;
  format: string;
  level: string;
  url: string;
}

export interface RecursosCtaData {
  heading: string;
  description: string;
  button: CtaButtonData;
}

export interface RecursosSectionsData {
  hero: RecursosHeroData;
  gateways: RecursosGatewayData[];
  articles: RecursosArticleItemData[];
  downloads: RecursosDownloadItemData[];
  cta: RecursosCtaData;
}

export interface RecursosSectionsResponse {
  slug: string;
  title: string;
  seo: SeoMetadata;
  sections: RecursosSectionsData;
}

// Interfaces para la sección "Contacto & Asesoría Técnica"
export interface ContactoHeroData {
  title: string;
  description: string;
}

export interface ContactoDoorData {
  key: string;
  num: string;
  title: string;
  description: string;
}

export interface ContactoChannelsData {
  address: string;
  branch: string;
  phone_main: string;
  phone_mobile: string;
  email_general: string;
  email_sales: string;
  hours: string;
}

export interface ContactoCoverageData {
  title: string;
  description: string;
  countries: string[];
}

export interface ContactoFormData {
  action_url: string;
  title: string;
  description: string;
}

export interface ContactoSectionsData {
  hero: ContactoHeroData;
  doors: ContactoDoorData[];
  channels: ContactoChannelsData;
  coverage: ContactoCoverageData;
  form: ContactoFormData;
}

export interface ContactoSectionsResponse {
  slug: string;
  title: string;
  seo: SeoMetadata;
  sections: ContactoSectionsData;
}

// Interfaces para la sección "Marcas Representadas"
export interface RepresentadasHeroData {
  title: string;
  description: string;
  image: string;
  primary_button: {
    label: string;
    url: string;
  };
  secondary_button: {
    label: string;
    url: string;
  };
}

export interface RepresentadasMetricData {
  num: string;
  label: string;
}

export interface RepresentadasMainBrandData {
  name: string;
  country: string;
  holding: string;
  category: string;
  description: string;
  solutions: string[];
  image: string;
  consult_url: string;
}

export interface RepresentadasDirectoryData {
  name: string;
  country: string;
  category: string;
  description: string;
}

export interface RepresentadasCtaData {
  heading: string;
  description: string;
  button: {
    label: string;
    url: string;
  };
}

export interface RepresentadasSectionsData {
  hero: RepresentadasHeroData;
  metrics: RepresentadasMetricData[];
  main_brands: RepresentadasMainBrandData[];
  directory: RepresentadasDirectoryData[];
  cta: RepresentadasCtaData;
}

export interface RepresentadasSectionsResponse {
  slug: string;
  title: string;
  seo: SeoMetadata;
  sections: RepresentadasSectionsData;
}

export interface PageSectionsResponse {
  slug: string;
  title: string;
  seo: SeoMetadata;
  sections: {
    hero?: HeroSectionData;
    visual_cards?: VisualCardData[];
    pain_points?: PainPointsSectionData;
    metrics?: MetricItemData[];
    brands?: BrandsSectionData;
    solutions?: SolutionsSectionData;
    why_mitsa?: WhyMitsaSectionData;
    cta_banner?: CtaBannerSectionData;
    faqs?: FaqsSectionData;
  };
}

// Interfaces para Opciones Globales del Sitio (Header, Footer, Marca, Contacto, Redes)
export interface SiteBrandOptions {
  name: string;
  tagline: string;
  since: string;
  logo_main: string;
  logo_white: string;
  favicon: string;
}

export interface SiteHeaderOptions {
  announcement?: string;
  btn_repuestos_label: string;
  btn_repuestos_url: string;
  btn_cta_label: string;
  btn_cta_url: string;
}

export interface SiteFooterOptions {
  statement_prefix: string;
  statement_prefix_sub: string;
  statement_suffix: string;
  statement_suffix_sub: string;
  description: string;
  location: string;
  copyright: string;
  agency_name: string;
  agency_url: string;
}

export interface SiteContactOptions {
  email_general: string;
  email_sales: string;
  phone_main: string;
  phone_mobile: string;
  address: string;
  whatsapp: string;
}

export interface SiteSocialOptions {
  linkedin: string;
  catalog_pdf: string;
  smm_expo: string;
}

export interface SiteOptionsData {
  brand: SiteBrandOptions;
  header: SiteHeaderOptions;
  footer: SiteFooterOptions;
  contact: SiteContactOptions;
  social: SiteSocialOptions;
}
