# /// script
# requires-python = ">=3.11"
# dependencies = ["requests>=2.32,<3", "beautifulsoup4>=4.12,<5"]
# ///
"""Read-only acceptance checks for the approved MITSA domain migration."""
import argparse
import csv
import json
import time
import xml.etree.ElementTree as ET
from concurrent.futures import ThreadPoolExecutor
from datetime import datetime, timezone
from pathlib import Path
from urllib.parse import urlsplit, parse_qs

import requests
from bs4 import BeautifulSoup

ROOT = Path(__file__).resolve().parents[2]
AUDIT = ROOT / "docs/entregables/migracion-seo-mitsa-org-2026-10-20"
parser = argparse.ArgumentParser()
parser.add_argument("--mode", choices=["preflight", "destination", "after"], required=True)
parser.add_argument("--output", type=Path, required=True)
args = parser.parse_args()
results = []


def record(kind, url, ok, **evidence):
    results.append({"kind": kind, "url": url, "ok": bool(ok), **evidence})
    if not ok:
        print("FAIL", kind, url, evidence, flush=True)


def fetch(url, *, head=False):
    time.sleep(0.10)
    return requests.request("HEAD" if head else "GET", url, timeout=25, allow_redirects=False,
                            headers={"User-Agent": "MITSA-Migration-Acceptance/1.0"})


rows = list(csv.DictReader((AUDIT / "mapa-redirecciones.csv").open(encoding="utf-8-sig")))
rows.extend([
    {"origen": "https://mitsachile.com/productos/", "destino_propuesto": "https://mitsa.org/soluciones/"},
    {"origen": "https://mitsachile.com/a-sample-blog-post/", "destino_propuesto": ""},
])
try:
    for row in ([] if args.mode == "destination" else rows):
        path = urlsplit(row["origen"]).path
        retired = path in ["/hello-world/", "/a-sample-blog-post/"]
        expected = 410 if retired else (404 if path == "/trituradores-organicos/" else 301)
        old = row["origen"] if args.mode == "after" else "https://mitsachile.com/__mitsa_migration_preflight_20261020" + path
        response = fetch(old)
        target = row["destino_propuesto"] if expected == 301 else None
        record("old-route", old, response.status_code == expected and response.headers.get("Location") == target,
               status=response.status_code, expected_status=expected, location=response.headers.get("Location"), expected_location=target)
    old_base = "https://mitsachile.com" + ("/__mitsa_migration_preflight_20261020" if args.mode == "preflight" else "")
    if args.mode != "destination":
        query = "puerta=evaluacion&sol=iccp&mensaje=Prueba%20de%20ruta&utm_source=seo-migration-test"
        response = fetch(old_base + "/contacto/?" + query)
        location = response.headers.get("Location", "")
        record("query-preservation", response.url, response.status_code == 301 and parse_qs(urlsplit(location).query) == parse_qs(query), status=response.status_code, location=location)
        unknown = old_base + "/mitsa-audit-inexistente-20261020/"
        response = fetch(unknown)
        record("unknown-remains-404", unknown, response.status_code == 404, status=response.status_code)
    for path in ([] if args.mode == "destination" else ["nosotros", "productos", "representaciones", "contacto", "smm2026"]):
        response = fetch(old_base + "/" + path)
        expected = {"productos": "/soluciones/", "representaciones": "/representadas/"}.get(path, "/" + path + "/")
        record("slash-normalization", response.url, response.status_code == 301 and response.headers.get("Location") == "https://mitsa.org" + expected, status=response.status_code, location=response.headers.get("Location"))
    if args.mode in ["after", "destination"]:
        queue = ["https://mitsa.org/sitemap_index.xml"]
        seen = set()
        pages = set()
        while queue:
            url = queue.pop()
            if url in seen:
                continue
            seen.add(url)
            response = fetch(url)
            record("sitemap-http", url, response.status_code == 200, status=response.status_code)
            response.raise_for_status()
            xml = ET.fromstring(response.content)
            locations = [e.text for e in xml.findall(".//{http://www.sitemaps.org/schemas/sitemap/0.9}loc")]
            record("sitemap-host", url, all(urlsplit(u).netloc == "mitsa.org" for u in locations))
            if xml.tag.endswith("sitemapindex"):
                queue.extend(locations)
            else:
                pages.update(locations)
        record("sitemap-policy", "https://mitsa.org/sitemap_index.xml", len(pages) == 34 and "https://mitsa.org/smm2026/" in pages and not any(any(t in u for t in ["hello-world", "/author/", "/uncategorized/"]) for u in pages), count=len(pages))
        for url in sorted(pages):
            response = fetch(url)
            soup = BeautifulSoup(response.content, "html.parser")
            robots = ", ".join(x.get("content", "") for x in soup.select('meta[name="robots"]')).lower()
            canonical = [x.get("href") for x in soup.select('link[rel="canonical"]')]
            record("indexable-destination", url, response.status_code == 200 and "noindex" not in robots and "noindex" not in response.headers.get("X-Robots-Tag", "").lower() and canonical == [url] and len(soup.select("h1")) == 1,
                   status=response.status_code, robots=robots, canonical=canonical, h1_count=len(soup.select("h1")))
            record("analytics-tag", url, "GT-577M5DL3" in response.text)
            if url != "https://mitsa.org/smm2026/":
                record("meta-description", url, bool(soup.select('meta[name="description"][content]')))
        for path, code in [("/hello-world/", 410), ("/a-sample-blog-post/", 410), ("/trituradores-organicos/", 404), ("/mitsa-audit-inexistente-20261020/", 404)]:
            response = fetch("https://mitsa.org" + path)
            record("destination-retired-or-unknown", response.url, response.status_code == code, status=response.status_code)
        for path in ["/author/juanaplicacionesweb-cl/", "/category/uncategorized/"]:
            response = fetch("https://mitsa.org" + path)
            record("utility-noindex", response.url, response.status_code == 200 and "noindex" in response.text, status=response.status_code)
        resources = json.loads((AUDIT / "assets.json").read_text())["assets"]

        def resource_check(row):
            try:
                old = fetch(row["old_url"], head=True) if args.mode == "after" else None
                new = fetch(row["new_url"], head=True)
                old_ok = old is None or (old.status_code == 301 and old.headers.get("Location") == row["new_url"])
                return {"kind": "resource-pair", "url": row["old_url"], "ok": old_ok and new.status_code == 200,
                        "status": old.status_code if old is not None else None, "location": old.headers.get("Location") if old is not None else None, "new_status": new.status_code}
            except requests.RequestException as error:
                return {"kind": "resource-pair", "url": row["old_url"], "ok": False, "error": str(error)}

        with ThreadPoolExecutor(max_workers=2) as pool:
            for result in pool.map(resource_check, resources):
                results.append(result)
                if not result["ok"]:
                    print("FAIL", result, flush=True)
        for protocol in (["http", "https"] if args.mode == "after" else []):
            for www in ["", "www."]:
                url = protocol + "://" + www + "mitsachile.com/"
                response = requests.get(url, timeout=25)
                record("domain-variant", url, response.url == "https://mitsa.org/" and response.status_code == 200 and len(response.history) <= 2 and all(r.status_code == 301 for r in response.history), final=response.url, chain=[r.status_code for r in response.history])
        for path in ["/robots.txt", "/sitemap_index.xml", "/wp-json/wp/v2/types", "/wp-login.php"]:
            response = fetch("https://mitsachile.com" + path)
            record("old-operational-endpoint", response.url, response.status_code == 200 and not response.headers.get("Location"), status=response.status_code, location=response.headers.get("Location"))
except Exception as error:
    record("verification-error", "", False, error=str(error))
finally:
    report = {"mode": args.mode, "captured_at_utc": datetime.now(timezone.utc).isoformat(), "passed": sum(r["ok"] for r in results), "failed": sum(not r["ok"] for r in results), "checks": results}
    args.output.parent.mkdir(parents=True, exist_ok=True)
    args.output.write_text(json.dumps(report, ensure_ascii=False, indent=2) + "\n")
    print(f"{args.mode}: {report['passed']} passed, {report['failed']} failed; {args.output}", flush=True)
raise SystemExit(1 if report["failed"] else 0)
