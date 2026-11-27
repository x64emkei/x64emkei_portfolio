# Production-readiness audit — 28 November 2026

## Executive summary

This is a custom PHP 8.2+ portfolio CMS, not a static-site-only project. It has a healthy baseline: strict PHP types, PDO prepared statements in the inspected models, CSRF middleware on state-changing routes, rate limiting for login and contact submission, upload restrictions, a public portfolio/journal, and a password-protected CMS.

The source-level audit found no PHP syntax errors and the automated suite passes. The most important implemented work in this pass is session authorization revalidation, trusted-proxy handling for rate limiting, and CSRF-protected logout. The remaining material risks are role authorization coverage, response-security policy tightening, and production-rendered accessibility/performance verification.

No credentials or environment values are included in this report.

## Project map

| Area | Location | Responsibility |
|---|---|---|
| Entry and bootstrap | `index.php`, `bootstrap/` | Loads environment/configuration, initializes secure sessions, error handling, and dispatches requests. |
| HTTP layer | `routes/web.php`, `app/Services/Router.php`, `app/Middleware/` | Declarative GET/POST routes, authentication, CSRF, and security headers. |
| Public site | `app/Controllers/HomeController.php`, `JournalController.php`, `ContactController.php`, `app/Views/public/` | Server-rendered portfolio, journal, contact, legal pages, sitemap, and public JSON endpoints. |
| CMS | `app/Controllers/Admin/`, `app/Views/admin/` | Content, media, messages, navigation/settings, system, and operator administration. |
| Data | `app/Models/`, `database/` | PDO-backed active-record-style models; versioned SQL migrations, schema, and seeded portfolio content. |
| Client assets | `style.css`, `script.js`, `images/` | Responsive cyberpunk/HUD presentation, navigation, animation, and interaction. |
| Quality and operations | `tests/`, `scripts/`, documentation | PHP test suite, migrations, deployment/sync helpers, operations documentation. |

## Verified baseline

- PHP lint completed successfully for 127 PHP files.
- `C:\xampp\php\php.exe tests\run_tests.php` passed: 16 tests, 0 failures.
- The tested paths cover database connectivity, seed data, models, CSRF, rate limiting, password hashing, uploads, logging redaction, routing, and journal relations.
- No performance score, Core Web Vitals field data, deployed headers, email delivery, or browser/device rendering result was claimed: those require a reachable deployment or browser-based measurement.

## Implemented improvements

| Priority | Change | Files | Benefit |
|---|---|---|---|
| P0 | Revalidate each authenticated user from the authoritative database on every protected request; clear the session when deleted, disabled, or unavailable. Refresh the current role snapshot. | `app/Services/AuthService.php` | Deactivation and role changes take effect immediately; stale session data cannot retain access. |
| P1 | Honor `CF-Connecting-IP` and `X-Forwarded-For` only when the direct remote peer is explicitly trusted through `TRUSTED_PROXIES`. | `app/Helpers/functions.php`, `.env.example` | Stops clients from choosing their own rate-limit identity through forged forwarding headers. |
| P1 | Removed the GET logout route and changed CMS logout into a CSRF-protected POST form. | `routes/web.php`, `app/Views/admin/layout.php` | Stops cross-site requests from ending an administrator session. |

## Findings and roadmap

| Priority | Finding | Affected area | Current state and recommendation | Benefit / dependency |
|---|---|---|---|---|
| P1 | CMS permission matrix was incomplete. | `AuthMiddleware.php`, `ArticlesController.php` | Implemented: superadmin/admin manage the CMS; editor manages articles; author sees and manages only their own drafts. | Enforces least privilege without removing the existing roles. |
| P1 | CSP permits `unsafe-inline` scripts and styles. | `SecurityHeadersMiddleware.php`, public/admin views | Necessary for current inline templates, but it lowers XSS defense depth. Migrate inline scripts/styles to hashed external files or nonce them, then remove `unsafe-inline` from `script-src` first. | Stronger XSS containment. Requires coordinated template changes. |
| P1 | Anonymous health diagnostics exposed runtime/storage state. | `ApiController.php` | Implemented a minimal liveness response with status and timestamp only. | Reduces reconnaissance while retaining uptime monitoring. |
| P2 | Canonical and sitemap URLs depended on `HTTP_HOST`. | `HomeController.php`, `app/Views/public/partials/seo_head.php` | Implemented use of the configured `APP_URL` as the canonical origin. | Avoids host-header-dependent SEO output. |
| P2 | Article lists fetch tags per article. | `app/Models/Article.php` | `getPublished`, category, tag, search, and featured lists each call `getTagsForArticle` in a loop. Batch tags with one join/query for list pages once profiling confirms a visible cost. | Removes N+1 database queries. Requires a performance baseline before changing behavior. |
| P2 | Public images need rendered verification for dimensions, lazy loading, and alt quality. | `app/Views/public/`, `images/` | Some images are lazy loaded and escaped, but not every public image was proven to reserve dimensions or receive intentional alt text. Audit in a browser at mobile and desktop widths. | Lower CLS and better screen-reader experience. |
| P2 | Visual accessibility needs rendered evidence. | `style.css`, `script.js`, public/admin views | Skip links, semantic landmarks, reduced-motion styling, and focus work are present, but source review cannot prove contrast, focus visibility, modal/drawer keyboard flow, or 200% zoom behavior. | WCAG 2.2 AA confidence. Requires Lighthouse/axe plus manual keyboard checks. |
| P2 | Admin layouts include large inline style/script blocks. | `app/Views/admin/layout.php`, related views | It works, but makes CSP tightening, caching, review, and reuse harder. Move stable rules and behavior into the existing CSS/JS files in a later focused refactor. | Maintainability and cacheability. |
| P3 | Add automated authorization and request-level security tests. | `tests/` | Cover disabled users, role changes after login, forged proxy headers, CSRF logout rejection, and endpoint access matrix. | Guards the implemented security behaviors against regression. |
| P3 | Add repeatable performance and accessibility CI. | CI/configuration not currently present | Use Lighthouse/axe against a disposable local environment; set budgets only after a measured baseline. | Detects regressions without inventing scores. |

## Security assessment

Strengths verified in source include PDO prepared statements for user-controlled values, output escaping helpers, password hashing with `PASSWORD_DEFAULT`, session ID regeneration at login/logout, CSRF middleware on POST mutations, login/contact rate limiting, upload MIME checks with filename randomization, upload-directory script execution denial, and redacted application logging.

The three implemented hardenings above address confirmed session, request-origin, and logout-CSRF weaknesses. Remaining P1 work is central RBAC policy and a stricter CSP.

## Performance, SEO, UI, and positioning

The presentation is intentionally differentiated: it keeps the existing high-tech HUD identity, custom typographic system, responsive navigation, and portfolio-specific content rather than replacing it with a generic card template. Existing SEO work includes descriptions, canonical tags, Open Graph/Twitter metadata, Person JSON-LD, `robots.txt`, and dynamic sitemap output.

No load-time or Core Web Vitals scores were recorded because no browser trace or deployed URL was measured. The highest-confidence future performance target is batching article tags after a trace confirms the list view is query-bound. The highest-confidence SEO refinement is using `APP_URL` as the canonical origin.

## Validation limitations

Database-backed tests were run locally. I did not send email, upload real production media, alter database schema, deploy, inspect production headers, or change environment secrets. A browser/device QA pass is still required to validate responsive layout, keyboard flow, contrast, and actual network performance.

`tests/HttpIntegrationTest.php` currently expects a seeded `Valkyrie POS Pro` project, but the connected local database does not return that record even though it is present in `database/schema_dump.sql`. The assertion fails independently of the implemented code changes. This is a data-seed drift that should be resolved through the existing controlled migration/seed workflow after a database backup, not by ad hoc record replacement.
