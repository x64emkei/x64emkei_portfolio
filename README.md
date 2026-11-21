# x64emkei Portfolio

[![GitHub Pages](https://img.shields.io/badge/deployment-GitHub%20Pages-2ea44f?logo=github)](https://x64emkei.github.io/x64emkei_portfolio/)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
[![Conventional Commits](https://img.shields.io/badge/Conventional%20Commits-1.0.0-yellow.svg)](https://conventionalcommits.org)
[![Aesthetic](https://img.shields.io/badge/Theme-Cyberpunk%20HUD-00e5ff.svg)](#aesthetic--design-system)

> Personal developer portfolio and interactive showcase for **Michael Benedict Ordenes (`x64emkei`)** — Computer Science Student, IT Enthusiast, and Systems Developer.

---

## 🌟 Highlights & Features

- **High-Tech HUD Aesthetic**: Neon ambient glow orbs, laser-sweep screen transitions, live telemetry equalizers, and cybernetic UI accents.
- **Pure Web Technologies**: Built strictly with semantic **HTML5**, modern **CSS3** (CSS Custom Properties, Flexbox, Grid), and vanilla **JavaScript (ES6+)**. No heavy framework dependencies.
- **Interactive Project Showcase**: Dynamic project filters, modular cards, homelab / retro computing gallery, and modal walkthroughs.
- **Integrated AI Agent Skills**: Pre-configured with modular skills in `.agents/skills/` for frontend design, accessibility, architecture, and security.
- **Automated GitHub Upload & Sync**: Automatic push hooks and one-click sync scripts with enforced Conventional Commit labels.
- **Continuous Deployment**: Automated GitHub Actions workflow deploying updates to GitHub Pages on every push.

---

## 📁 Repository Structure

```text
x64emkei_portfolio/
├── .agents/
│   └── skills/                  # Integrated Antigravity agent skills
│       ├── accessibility/       # WCAG & a11y standards
│       ├── architecture/        # Code patterns & architectural guidelines
│       ├── frontend-design/     # HUD aesthetic, typography & styling rules
│       ├── frontend-skill/      # Modern frontend implementation patterns
│       └── web-application-security/ # Web hardening & security guides
├── .github/
│   └── workflows/
│       ├── deploy.yml           # GitHub Pages auto-deploy workflow
│       └── labels.yml           # Commit & PR label linter
├── .githooks/
│   ├── commit-msg               # Enforces Conventional Commit labels
│   └── post-commit              # Auto-uploads commits to GitHub
├── images/                      # High-resolution assets, showcase & photos
├── scripts/
│   └── sync.ps1                 # Automated Git sync & upload script
├── .gitattributes               # Line ending normalization
├── .gitignore                   # Ignores backups, logs, and temp files
├── AGENTS.md                    # Detailed agent instructions & guidelines
├── GEMINI.md                    # Workspace agent configuration pointer
├── index.html                   # Main portfolio application
├── README.md                    # Repository documentation
├── script.js                    # Interactive DOM & UI logic
├── style.css                    # Comprehensive HUD design system
└── sync.bat                     # Windows one-click auto-upload batch script
```

---

## 🤖 Integrated Agent Skills

The repository includes localized agent skills located in `.agents/skills/`:

| Skill | Focus Area |
| :--- | :--- |
| **`frontend-design`** | Visual direction, neon/HUD color schemes, cyber telemetry, and responsive layout polish. |
| **`frontend-skill`** | Clean component logic, state management, event listeners, and API integration. |
| **`accessibility`** | Keyboard navigation, focus outlines, high-contrast visibility, and ARIA attributes for HUD elements. |
| **`architecture`** | Modular code organization, maintainability, and clean separation of concerns. |
| **`web-application-security`** | Content Security Policy, script injection prevention, and asset integrity. |

---

## 🚀 Auto-Upload to GitHub with Proper Labels

This repository is equipped with tools that enforce and automate upload to GitHub with Conventional Commit labels.

### 1. One-Click Sync Script (`sync.bat` / `scripts/sync.ps1`)

Run `sync.bat` or PowerShell:

```powershell
# Interactive menu (prompts for label, scope, message):
.\sync.bat

# Or direct command-line arguments:
.\scripts\sync.ps1 -Type feat -Scope ui -Message "Add terminal telemetry readout"
.\scripts\sync.ps1 -Type fix -Scope nav -Message "Fix mobile navigation drawer"
.\scripts\sync.ps1 -Type style -Scope hero -Message "Adjust neon glow intensity"
```

The script will:
1. Detect all modified, added, or deleted files.
2. Format the commit message according to the required label standard.
3. Commit the changes.
4. Automatically push directly to `origin main` on GitHub.

### 2. Git Hooks (`.githooks/`)

- **`commit-msg`**: Automatically validates that every commit message starts with a recognized label (`feat:`, `fix:`, `style:`, `docs:`, `perf:`, `refactor:`, `chore:`, `test:`, `ci:`).
- **`post-commit`**: Automatically runs `git push origin HEAD` immediately after any local commit.

To ensure hooks are active on your clone:
```bash
git config core.hooksPath .githooks
```

### 🏷️ Proper Commit Labels Reference

| Label | Usage | Example |
| :--- | :--- | :--- |
| `feat` | New feature or content | `feat(projects): add homelab cluster card` |
| `fix` | Bug fix or glitch resolution | `fix(mobile): resolve horizontal overflow on iOS` |
| `style` | Aesthetic, CSS, or layout polish | `style(hud): enhance laser sweep animation` |
| `docs` | Documentation & skill updates | `docs: update portfolio README with deployment details` |
| `perf` | Performance or asset optimization | `perf(images): compress carousel photographs` |
| `refactor` | Code reorganization | `refactor(script): modularize telemetry event handlers` |
| `chore` | Maintenance & tooling updates | `chore(hooks): update commit-msg regex pattern` |
| `ci` | GitHub Actions workflow edits | `ci: add automated Pages deployment action` |

---

## 💻 Local Development

To run the portfolio locally:

1. **Using XAMPP / Apache**:
   - Clone or place this directory under `C:\xampp\htdocs\x64emkei_portfolio`.
   - Start Apache from the XAMPP Control Panel.
   - Access via browser: `http://localhost/x64emkei_portfolio/`.

2. **Using Python Local Server**:
   ```bash
   python -m http.server 8000
   ```
   Open `http://localhost:8000`.

3. **Using VS Code Live Server**:
   Right-click `index.html` and select **"Open with Live Server"**.

---

## 👤 Author

**Michael Benedict Ordenes (`x64emkei`)**  
- GitHub: [@x64emkei](https://github.com/x64emkei)
- Repository: [x64emkei/x64emkei_portfolio](https://github.com/x64emkei/x64emkei_portfolio)
