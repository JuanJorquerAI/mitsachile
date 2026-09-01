import fs from 'node:fs';
import path from 'node:path';

export interface Article {
  slug: string;
  title: string;
  seoTitle: string;
  description: string;
  category: string;
  status: string;
  summary: string;
  content: string;
  rawMarkdown: string;
}

const articlesFiles = [
  { file: '08-blog-norma-d2-bwm-chile.md', defaultSlug: 'norma-d2-omi-chile-agua-lastre' },
  { file: '09-blog-circular-a-52-007.md', defaultSlug: 'circular-a-52-007-directemar-aguas-grises-negras' },
  { file: '10-blog-iccp-vs-anodos.md', defaultSlug: 'iccp-vs-anodos-sacrificio-proteccion-catodica-chile' },
  { file: '11-blog-osmosis-inversa-a-bordo.md', defaultSlug: 'osmosis-inversa-marina-desalinizacion-a-bordo' },
  { file: '12-blog-marpol-anexo-iv.md', defaultSlug: 'marpol-anexo-iv-planta-tratamiento-aguas-servidas-chile' }
];

export function getArticles(): Article[] {
  const contentDir = path.resolve('../content');
  
  return articlesFiles.map(({ file, defaultSlug }) => {
    const filePath = path.join(contentDir, file);
    if (!fs.existsSync(filePath)) {
      return null;
    }
    const raw = fs.readFileSync(filePath, 'utf-8');
    
    // Extract metadata
    const titleMatch = raw.match(/^#\s+(.+)$/m);
    const title = titleMatch ? titleMatch[1].trim() : 'Artículo Técnico';
    
    const slugMatch = raw.match(/-\s+\*\*Slug propuesto:\*\*\s+`([^`]+)`/);
    const slug = slugMatch ? slugMatch[1].trim() : defaultSlug;
    
    const seoTitleMatch = raw.match(/-\s+\*\*Title SEO:\*\*\s+`([^`]+)`/);
    const seoTitle = seoTitleMatch ? seoTitleMatch[1].trim() : `${title} | MITSA`;
    
    const descMatch = raw.match(/-\s+\*\*Meta description:\*\*\s+`([^`]+)`/);
    const description = descMatch ? descMatch[1].trim() : '';
    
    const summaryMatch = raw.match(/>\s+\*\*En breve:\*\*\s+([^\n]+)/);
    const summary = summaryMatch ? summaryMatch[1].trim() : '';

    return {
      slug,
      title,
      seoTitle,
      description,
      category: 'Cluster Regulatorio',
      status: 'Borrador Técnico',
      summary,
      content: raw,
      rawMarkdown: raw
    };
  }).filter(Boolean) as Article[];
}

export function getArticleBySlug(slug: string): Article | undefined {
  const articles = getArticles();
  return articles.find(a => a.slug === slug);
}
