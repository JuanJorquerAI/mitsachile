import subprocess
import os
import re

articles_files = [
    ('content/08-blog-norma-d2-bwm-chile.md', 'norma-d2-omi-chile-agua-lastre'),
    ('content/09-blog-circular-a-52-007.md', 'circular-directemar-a-52-007-bioincrustaciones'),
    ('content/10-blog-iccp-vs-anodos.md', 'proteccion-catodica-iccp-vs-anodos-sacrificio'),
    ('content/11-blog-osmosis-inversa-a-bordo.md', 'osmosis-inversa-a-bordo-elegir-planta-agua-dulce'),
    ('content/12-blog-marpol-anexo-iv.md', 'marpol-anexo-iv-chile-aguas-sucias-buques')
]

for file_path, default_slug in articles_files:
    if not os.path.exists(file_path):
        continue
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()

    title_m = re.search(r'^#\s+(.+)$', content, re.M)
    title = title_m.group(1).strip() if title_m else 'Artículo Técnico'

    slug_m = re.search(r'-\s+\*\*Slug propuesto:\*\*\s+`([^`]+)`', content)
    slug = slug_m.group(1).strip() if slug_m else default_slug

    create_cmd = [
        'bash', 'scripts/wpcli.sh', '--path=wp', 'post', 'create',
        f'--post_title={title}',
        f'--post_name={slug}',
        f'--post_content={content}',
        '--post_status=publish',
        '--post_type=post'
    ]
    res = subprocess.run(create_cmd, capture_output=True, text=True)
    lines = [l for l in res.stdout.splitlines() if 'Success:' in l or 'Created' in l]
    print(f"✓ {title[:45]}... -> {lines}")
