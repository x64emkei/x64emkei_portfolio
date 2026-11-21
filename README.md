# x64emkei.dev // Production Personal Portfolio CMS

[![PHP 8.2+](https://img.shields.io/badge/PHP-8.2%20%7C%208.3%20%7C%208.4-777bb4?logo=php)](https://php.net)
[![MySQL 8](https://img.shields.io/badge/MySQL-8.0%20%7C%20MariaDB-00758f?logo=mysql)](https://mysql.com)
[![Domain](https://img.shields.io/badge/Domain-x64emkei.dpdns.org-00e5ff)](https://x64emkei.dpdns.org)
[![Hosting](https://img.shields.io/badge/Hosting-InfinityFree-blue)](https://infinityfree.com)
[![Conventional Commits](https://img.shields.io/badge/Conventional%20Commits-1.0.0-yellow.svg)](https://conventionalcommits.org)
[![Aesthetic](https://img.shields.io/badge/Theme-Cyberpunk%20HUD-ff3366.svg)](#aesthetic--design-system)

> Production-ready, fully editable Personal Developer Portfolio and CMS engineered for **Michael Benedict Ordenes (`x64emkei`)** — Computer Science Scholar, IT Infrastructure Enthusiast, and Systems Architect.

---

## 🌟 Highlights & Architecture

- **High-Tech HUD Aesthetic Preserved 100%**: Cybernetic neon ambient glow orbs, laser-sweep screen transitions, live telemetry equalizers, and terminal-inspired typography (`JetBrains Mono`, `Outfit`, `Space Grotesk`).
- **Dynamic MVC Backend**: Native **PHP 8.3+** compatible, portable architecture powered by PDO prepared statements, prepared for shared hosting (InfinityFree) and future migration to VPS.
- **Fully Editable Administrator CMS (`/admin`)**:
  - **Telemetry Control Deck**: Live project counters, unread message alerts, and operational activity logs.
  - **Identity & Profile**: Edit bio, job titles, photo uploads, resume links, and availability.
  - **Projects Matrix**: Full CRUD for 16 flagship systems builds, code snippets, hardware benchmarks, tags, and drafts.
  - **Skills & Competencies**: Manage categorized skills (Languages, Platforms, Databases, Tools) with visual percentage meters.
  - **Hardware Lab Archive**: Manage vintage computing nodes, ThinkPad mods, Proxmox clusters, and restoration logs.
  - **Secure Media Manager**: Cryptographically randomized file naming, server-side MIME verification, and anti-script `.htaccess` protection.
  - **Signals Inbox**: Rate-limited, honeypot-protected contact message handling.
  - **Core System & SEO Settings**: Dynamic Open Graph meta tags, keywords, theme defaults, and primary domain resolution.
- **Zero-Dependency Shared Hosting Portability**:
  - Features a custom PSR-4 autoloader requiring no Composer in production.
  - Supports both Apache URL rewriting (`/admin`) and query parameter fallbacks (`?route=admin`).
  - No continuous daemon, Node.js, Redis, or SSH required in production.
- **Automated Verification**: Complete automated test suite covering database models, CSRF tokens, rate limiters, user authentication, and secure uploads.

---

## 📁 Repository Structure

```text
x64emkei_portfolio/
├── app/
│   ├── Controllers/             # MVC Controllers (Home, Contact, Api, Admin)
│   ├── Models/                  # 14 Relational Models (User, Project, Profile, etc.)
│   ├── Services/                # Security, Auth, RateLimiter, Upload, Router
│   ├── Middleware/              # Auth, CSRF, and Security Headers
│   ├── Helpers/                 # Functions: e(), url(), asset(), csrf_token()
│   └── Views/
│       ├── public/              # High-Tech SSR Public Portfolio views
│       └── admin/               # Cyberpunk HUD Administrator CMS views
├── bootstrap/
│   ├── app.php                  # Environment loader & error handling
│   └── autoload.php             # Portable PSR-4 autoloader
├── config/                      # Database & application configurations
├── database/
│   ├── Database.php             # PDO connection singleton
│   ├── MigrationRunner.php      # Migration manager with batch tracking
│   ├── migrate.php              # CLI migration runner
│   ├── schema_dump.sql          # All-in-one SQL import for phpMyAdmin
│   ├── migrations/              # 14 structured SQL table migrations
│   └── seeders/                 # Seeder populating 16 projects, hardware nodes, skills
├── deploy/                      # Production packaging directory
├── images/                      # Photographic showcase & photography
├── routes/
│   └── web.php                  # Centralized URL routing registry
├── scripts/
│   ├── build_production_package.ps1 # Builds upload-ready zip for FTP
│   └── sync.ps1                 # Automated Git commit & push script
├── storage/
│   ├── logs/                    # Application error logs (protected)
│   ├── uploads/                 # User-uploaded media (script execution blocked)
│   └── cache/                   # Rate limiter & session state
├── tests/
│   ├── run_tests.php            # Comprehensive automated test suite
│   └── HttpIntegrationTest.php  # HTTP route dispatch verification
├── .env.example                 # Safe environment configuration template
├── .htaccess                    # Root rewrite rules & security headers
├── composer.json                # Standard composer descriptor
├── DATABASE.md                  # Database schema & backup guide
├── DEPLOYMENT.md                # InfinityFree & FTP deployment guide
├── DNS_SETUP.md                 # Domain & DNS integration guide
├── MAINTENANCE.md               # Maintenance & VPS migration guide
├── SECURITY.md                  # Cybersecurity & threat defense documentation
├── index.php                    # Front controller entry point
├── script.js                    # Client-side HUD interactions & window bridge
├── style.css                    # Design system & cyberpunk HUD styling
└── sync.bat                     # Windows one-click auto-sync script
```

---

## 🚀 Quick Local Setup (XAMPP / PHP)

1. **Verify Database Connection**:
   Ensure MySQL is running on `127.0.0.1:3306` (e.g. via XAMPP Control Panel).

2. **Initialize Database Schema & Seeds**:
   ```powershell
   php database/migrate.php
   ```

3. **Run Automated Test Suite**:
   ```powershell
   php tests/run_tests.php
   ```

4. **Access Locally**:
   - Start Apache via XAMPP and navigate to `http://localhost/x64emkei_portfolio/`.
   - Access the Administrator CMS at `http://localhost/x64emkei_portfolio/admin`.
   - On first access, complete the secure **First Administrator Setup** wizard.

---

## 🌐 Production Deployment to InfinityFree

Target Domain: **`x64emkei.dpdns.org`**

Detailed step-by-step guides are provided in the repository:

1. **[DEPLOYMENT.md](file:///c:/xampp/htdocs/x64emkei_portfolio/DEPLOYMENT.md)**: Full guide to uploading the production package via FileZilla, configuring private `.env` database credentials, and importing `database/schema_dump.sql`.
2. **[DNS_SETUP.md](file:///c:/xampp/htdocs/x64emkei_portfolio/DNS_SETUP.md)**: Pointing `x64emkei.dpdns.org` from dpdns.org to InfinityFree, verifying propagation, and issuing free SSL certificates.
3. **[DATABASE.md](file:///c:/xampp/htdocs/x64emkei_portfolio/DATABASE.md)**: Relational schema documentation, migrations, and export/restore instructions.
4. **[SECURITY.md](file:///c:/xampp/htdocs/x64emkei_portfolio/SECURITY.md)**: Threat model, CSRF defense, SQL injection protection, XSS escaping, and rate limiting.
5. **[MAINTENANCE.md](file:///c:/xampp/htdocs/x64emkei_portfolio/MAINTENANCE.md)**: Routine maintenance schedule and moving to a dedicated VPS in the future.

### Generating the Production FTP Package:
```powershell
.\scripts\build_production_package.ps1
```
This produces `deploy/x64emkei_portfolio_deploy.zip` ready for one-click upload!

---

## 🛡️ Security Best Practices

- **Zero Hardcoded Secrets**: Production database passwords and API tokens are never committed to GitHub.
- **Upload Hardening**: File uploads are restricted to genuine image MIME types verified via `finfo`, assigned cryptographically random names, and stored in a directory protected by `.htaccess` rules that prevent PHP script execution.
- **Account Lockout**: Failed login attempts trigger automatic lockout after 5 invalid attempts for 15 minutes.

---

## 👤 Author & Digital Identity

**Michael Benedict Ordenes (`x64emkei`)**  
- Primary Domain: [x64emkei.dpdns.org](https://x64emkei.dpdns.org)  
- GitHub: [@x64emkei](https://github.com/x64emkei) / [@x64_emkei](https://github.com/x64_emkei)  
- Email: [mordenes@acm.org](mailto:mordenes@acm.org)
