---
name: wcag-accessibility-auditor
description: Estándares de accesibilidad web WCAG 2.1 Nivel AA para los componentes de MITSA. Incluye contraste de color (mínimo 4.5:1 para texto normal, 3:1 para texto grande/interfaz), navegación completa por teclado, indicadores de foco visibles (:focus-visible), atributos ARIA (aria-label, aria-live, role), e interactividad táctil adecuada (mínimo 44x44px).
---

# WCAG 2.1 AA Accessibility Skill

Esta skill asegura que todos los módulos y componentes del sitio web cumplan con los criterios de accesibilidad universal WCAG 2.1 Nivel AA.

## Checklist de Cumplimiento

1. **Contraste de Color**:
   - Texto normal (#1B263B, #0D1B2A) sobre fondo claro (#F8F6F0, #FFFFFF) -> Ratio > 10:1 (supera ampliamente el 4.5:1 exigido).
   - Texto secundario (#415A77) sobre fondo claro -> Ratio > 4.8:1.
   - Texto claro (#F8F6F0) sobre fondo oscuro (#0D1B2A) -> Ratio > 14:1.
2. **Navegación por Teclado y Foco**:
   - Todo botón, enlace o campo interactivo debe ser alcanzable con `Tab` y accionable con `Enter` / `Space`.
   - Indicador de foco visible con `outline` nítido (`:focus-visible`).
3. **Semántica y ARIA**:
   - Formularios y cajas de búsqueda deben contar con `<label>` o `aria-label` descriptivo.
   - Textos rotativos o dinámicos deben usar `aria-live="polite"` o mantener el texto accesible en el DOM para lectores de pantalla.
   - Los botones de solo icono deben tener `aria-label` explícito.
4. **Objetivos Táctiles (Touch Targets)**:
   - Todo botón o enlace interactivo debe tener un área mínima de toque de 44x44px.
