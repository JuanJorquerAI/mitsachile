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
    [key: string]: any;
  };
}
