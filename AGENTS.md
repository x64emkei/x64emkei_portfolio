# Project Guidelines & Agent Instructions

Welcome to **x64emkei_portfolio**, the personal developer portfolio and interactive showcase for **Michael Benedict Ordenes (x64emkei)**.

---

## 1. Project Overview & Architecture

- **Stack**: Pure Vanilla HTML5, Modern CSS3 (custom CSS variables, high-tech HUD aesthetic, responsive grid/flexbox), Vanilla JavaScript (ES6+ modular DOM interactions).
- **Aesthetic Direction**: High-Tech / Cyberpunk / Developer HUD theme featuring dynamic glowing ambient orbs, telemetry equalizers, laser transitions, terminal-inspired typography (`JetBrains Mono`, `Space Grotesk`, `Outfit`), and interactive project matrices.
- **Key Files**:
  - `index.html`: Main portfolio application containing semantic navigation, hero, telemetry, project cards, and modals.
  - `style.css`: Comprehensive design system with scoped custom properties, animations, and responsive media queries.
  - `script.js`: Interactive UI logic, screen transitions, active link telemetry, and mobile drawer controls.
  - `images/`: High-resolution assets, showcase photography, retro computing, homelab setups, and personal photography.

---

## 2. Integrated Agent Skills

The project is equipped with specialized local skills located in `.agents/skills/`:

| Skill | Path | Description & Purpose |
| :--- | :--- | :--- |
| **frontend-design** | `.agents/skills/frontend-design` | Directs aesthetic decisions, color palettes, HUD styling, typography, and distinctive visual polish. |
| **frontend-skill** | `.agents/skills/frontend-skill` | Frontend implementation specialist for resilient HTML/CSS/JS, responsive layouts, and modern web APIs. |
| **accessibility** | `.agents/skills/accessibility` | WCAG 2.2 standards, keyboard navigation, high-contrast visibility, and ARIA landmarks for HUD interfaces. |
| **architecture** | `.agents/skills/architecture` | Modular separation of concerns, maintainable code structures, and trade-off analysis. |
| **web-application-security** | `.agents/skills/web-application-security` | Client-side hardening, Content Security Policy (CSP), sanitization, and secure asset delivery. |

---

## 3. Git Workflow & Mandatory Commit Labels

All contributions, automated commits, and pull requests **must** follow the Conventional Commits label standard:

```
<label>(<optional-scope>): <description>
```

### Approved Labels:
- `feat`: A new portfolio feature, project card, section, or interactive UI widget.
- `fix`: Bug fix, mobile glitch resolution, broken anchor link, or visual defect.
- `style`: CSS styling, theme palette adjustments, animations, glow effects, or typographic changes.
- `docs`: Documentation updates, README additions, or skill file documentation.
- `perf`: Performance enhancements, image lazy loading, script optimization, or animation frame rate tuning.
- `refactor`: Code reorganization without introducing new features or bug fixes.
- `chore`: Tooling, maintenance, git hooks, or configuration updates.
- `ci`: Changes to GitHub Actions workflows (`.github/workflows/`).

### Automated Sync & Upload:
Use `sync.bat` or `.\scripts\sync.ps1` to automatically stage changes, select a valid commit label, format the commit, and push immediately to GitHub:
```powershell
.\scripts\sync.ps1 -Type feat -Scope hero -Message "add interactive telemetry readout"
```
Or simply double-click / run:
```cmd
sync.bat
```
Git hooks configured in `.githooks/` enforce label validation (`commit-msg`) and auto-upload commits (`post-commit`).
