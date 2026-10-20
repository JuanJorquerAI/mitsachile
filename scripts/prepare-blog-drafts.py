#!/usr/bin/env python3
"""
Prepara y sincroniza los 5 artículos técnicos regulatorios de MITSA como borradores (drafts)
en WordPress de producción (mitsa.org), con HTML formateado, metadatos Yoast SEO y relaciones
con soluciones comerciales.
"""
import json
import os
import re
import subprocess
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent

try:
    import markdown
except ImportError:
    import sys
    print("Ejecutar con uv run --with markdown python3 ...", file=sys.stderr)
    raise

ARTICLES = [
    {
        "file": "content/08-blog-norma-d2-bwm-chile.md",
        "category_id": 9,  # Normativa
        "solution_ids": [50],  # Tratamiento de agua de lastre
        "reuse_id": None
    },
    {
        "file": "content/09-blog-circular-a-52-007.md",
        "category_id": 9,  # Normativa
        "solution_ids": [51, 52],  # Protección catódica ICCP / Bioincrustaciones ICAF
        "reuse_id": 67
    },
    {
        "file": "content/10-blog-iccp-vs-anodos.md",
        "category_id": 10,  # Tecnologías
        "solution_ids": [51],  # Protección catódica ICCP
        "reuse_id": 66
    },
    {
        "file": "content/11-blog-osmosis-inversa-a-bordo.md",
        "category_id": 10,  # Tecnologías
        "solution_ids": [53],  # Generación de agua dulce
        "reuse_id": 65
    },
    {
        "file": "content/12-blog-marpol-anexo-iv.md",
        "category_id": 9,  # Normativa
        "solution_ids": [48, 49],  # Sanitarios al vacío / Tratamiento aguas residuales
        "reuse_id": 64
    }
]

parsed_articles = []

for item in ARTICLES:
    p = ROOT / item["file"]
    content = p.read_text(encoding="utf-8")
    
    title_m = re.search(r'^#\s+(.+)$', content, re.M)
    title = title_m.group(1).strip() if title_m else ""
    
    slug_m = re.search(r'-\s+\*\*Slug propuesto:\*\*\s+`([^`]+)`', content)
    slug = slug_m.group(1).strip() if slug_m else ""
    
    kw_m = re.search(r'-\s+\*\*Keyword principal:\*\*\s+(.+)$', content, re.M)
    kw = kw_m.group(1).strip() if kw_m else ""
    
    seo_title_m = re.search(r'-\s+\*\*Title SEO:\*\*\s+`([^`]+)`', content)
    seo_title = seo_title_m.group(1).strip() if seo_title_m else ""
    
    seo_desc_m = re.search(r'-\s+\*\*Meta description:\*\*\s+`([^`]+)`', content)
    seo_desc = seo_desc_m.group(1).strip() if seo_desc_m else ""
    
    cat_m = re.search(r'-\s+\*\*Categoría propuesta:\*\*\s+(.+)$', content, re.M)
    cat_name = cat_m.group(1).strip() if cat_m else ""
    
    # Extract excerpt
    excerpt_m = re.search(r'>\s+\*\*En breve:\*\*\s+(.+?)(?=\n\n|\n##)', content, re.S)
    excerpt = excerpt_m.group(1).strip() if excerpt_m else ""
    
    # Body starts after excerpt
    en_breve_end = content.find(excerpt) + len(excerpt) if excerpt else content.find('## ')
    body_raw = content[en_breve_end:].strip()
    
    # Extract pendientes section if present
    pendientes_m = re.search(r'## Pendientes antes de publicar\s*\n\n(.*?)(?=\n>|\Z)', body_raw, re.S)
    pendientes = pendientes_m.group(1).strip() if pendientes_m else ""
    
    # Remove pendientes from public article body
    body_clean = re.sub(r'## Pendientes antes de publicar\s*\n\n.*?(?=\n>|\Z)', '', body_raw, flags=re.S).strip()
    
    # Convert body_clean to HTML
    body_html = markdown.markdown(body_clean, extensions=['tables', 'fenced_code'])
    
    parsed_articles.append({
        "file": item["file"],
        "title": title,
        "slug": slug,
        "kw": kw,
        "seo_title": seo_title,
        "seo_desc": seo_desc,
        "category_id": item["category_id"],
        "category_name": cat_name,
        "solution_ids": item["solution_ids"],
        "reuse_id": item["reuse_id"],
        "excerpt": excerpt,
        "body_html": body_html,
        "pendientes": pendientes
    })

output_json = ROOT / "scripts/seo-migration/blog-drafts-payload.json"
output_json.write_text(json.dumps(parsed_articles, indent=2, ensure_ascii=False), encoding="utf-8")
print(f"✓ Generado payload con {len(parsed_articles)} artículos en {output_json}")
