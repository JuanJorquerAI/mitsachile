#!/usr/bin/env python3
"""Auditoria editorial determinista para borradores de contenido MITSA."""

from __future__ import annotations

import argparse
import json
import re
import sys
from collections import Counter
from pathlib import Path


REQUIRED_PATTERNS = {
    "estado de borrador": r"Estado:\s*.*BORRADOR",
    "slug propuesto": r"Slug propuesto",
    "keyword principal": r"Keyword principal",
    "title SEO": r"Title SEO",
    "meta description": r"Meta description",
    "seccion de fuentes": r"^##+\s+Fuente(?:s)?\b",
}

AI_TICS = {
    "cabe destacar": r"\bcabe destacar\b",
    "es crucial": r"\bes crucial\b",
    "en el panorama actual": r"\ben (?:el )?(?:panorama|entorno) actual\b",
    "en conclusion": r"\ben conclusi[oó]n\b",
    "solucion integral": r"\bsoluci[oó]n integral\b",
    "tecnologia de vanguardia": r"\btecnolog[ií]a de vanguardia\b",
    "no solo sino": r"\bno solo\b.{0,100}\bsino\b",
    "por otro lado": r"\bpor otro lado\b",
}

PROMOTIONAL = re.compile(
    r"\b(l[ií]der(?:es)? mundial(?:es)?|revolucionari[oa]s?|inigualable|"
    r"la mejor soluci[oó]n|excelencia|de punta)\b",
    re.IGNORECASE,
)


def strip_metadata(text: str) -> str:
    """Excluye metadatos iniciales para varias heuristicas de estilo."""
    parts = re.split(r"\n(?=>\s*\*\*|##\s)", text, maxsplit=1)
    return parts[-1] if len(parts) == 2 else text


def audit(path: Path) -> dict[str, object]:
    text = path.read_text(encoding="utf-8")
    body = strip_metadata(text)
    blocks: list[str] = []
    warnings: list[str] = []
    notes: list[str] = []

    for label, pattern in REQUIRED_PATTERNS.items():
        if not re.search(pattern, text, re.IGNORECASE | re.MULTILINE):
            blocks.append(f"Falta {label}.")

    if not re.search(
        r"pendiente de validaci[oó]n|validaci[oó]n pendiente|requiere validaci[oó]n",
        text,
        re.IGNORECASE,
    ):
        warnings.append("No se identifica con precision que afirmaciones requieren validacion de MITSA.")

    links = re.findall(r"https?://[^)\s>]+", text)
    if not links:
        blocks.append("No hay enlaces a fuentes verificables.")
    elif len(set(links)) < 2:
        warnings.append("Solo hay una fuente enlazada; comprobar si basta para todas las afirmaciones.")

    if not re.search(r"^##+\s+Preguntas frecuentes\b", text, re.IGNORECASE | re.MULTILINE):
        warnings.append("No hay preguntas frecuentes derivadas de dudas reales del lector.")
    if "|" not in body:
        warnings.append("No hay tabla comparativa o de decision; usarla solo si mejora la comprension.")
    if not re.search(r"^>\s*\*\*(?:En breve|Respuesta breve|Resumen)", text, re.IGNORECASE | re.MULTILINE):
        warnings.append("La respuesta principal no aparece en un bloque inicial identificable.")

    for label, pattern in AI_TICS.items():
        count = len(re.findall(pattern, body, re.IGNORECASE | re.DOTALL))
        if count:
            warnings.append(f"Tic de redaccion '{label}': {count} aparicion(es).")

    promo_hits = sorted(set(match.lower() for match in PROMOTIONAL.findall(body)))
    if promo_hits:
        warnings.append("Lenguaje promocional que requiere prueba o reescritura: " + ", ".join(promo_hits) + ".")

    dash_count = body.count("—") + body.count("–")
    if dash_count:
        warnings.append(f"Hay {dash_count} raya(s) larga(s); revisar si son necesarias.")

    if re.search(r"\b(TODO|TBD)\b|\[VALIDAR[^\]]*\]", text):
        blocks.append("Hay placeholders editoriales sin resolver.")

    if not re.search(r"autor|revis(?:ado|or|ion) tecnic", text, re.IGNORECASE):
        notes.append("Gate de publicacion pendiente: autor o revisor tecnico identificable.")
    if not re.search(r"imagen|fotograf", text, re.IGNORECASE):
        notes.append("Gate de publicacion pendiente: imagen propia o autorizada con contexto.")

    sentences = [s.strip() for s in re.split(r"(?<=[.!?])\s+", body) if len(s.split()) >= 4]
    openings = Counter(" ".join(re.findall(r"\b[\wáéíóúñü]+\b", s.lower())[:2]) for s in sentences)
    repeated = [opening for opening, count in openings.items() if opening and count >= 5]
    if repeated:
        warnings.append("Inicios de oracion repetidos: " + ", ".join(sorted(repeated)) + ".")

    status = "NEEDS_WORK" if blocks else "DRAFT_READY"
    return {
        "file": str(path),
        "status": status,
        "blocks": blocks,
        "warnings": warnings,
        "publication_notes": notes,
        "unique_source_links": len(set(links)),
    }


def main() -> int:
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("files", nargs="+", type=Path)
    parser.add_argument("--json", action="store_true")
    args = parser.parse_args()

    results = []
    missing = False
    for path in args.files:
        if not path.is_file():
            results.append({"file": str(path), "status": "ERROR", "blocks": ["Archivo inexistente."]})
            missing = True
            continue
        results.append(audit(path))

    if args.json:
        print(json.dumps(results, ensure_ascii=False, indent=2))
    else:
        for result in results:
            print(f"{result['status']} {result['file']}")
            for key in ("blocks", "warnings", "publication_notes"):
                for item in result.get(key, []):
                    print(f"  {key}: {item}")

    return 2 if missing or any(r.get("status") == "NEEDS_WORK" for r in results) else 0


if __name__ == "__main__":
    sys.exit(main())
