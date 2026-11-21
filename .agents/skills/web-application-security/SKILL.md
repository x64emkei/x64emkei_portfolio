---
name: web-application-security
description: "Review, harden, and remediate security issues in web applications, APIs, and WordPress/Angular projects. Load when reviewing auth, input validation, API exposure, headers, secrets, CORS, CSP, or preparing a security-focused delivery."
---

# Web Application Security

## Scope
Security review, hardening, and remediation for web applications, APIs, and frontend/backend stacks. Covers authentication, authorization, input validation, output encoding, session management, API security, headers, CORS, CSP, secret management, dependency risk, and GDPR-aligned data protection. Oriented to defensive review and remediation, not offensive testing.

## Boundaries
- **This skill**: Application-level security review, hardening, remediation, secure design patterns
- **NOT this skill**: Infrastructure/network security (firewalls, VPN, OS hardening), penetration testing/exploitation, generic QA (→ kiro-qa), WordPress plugin code patterns (→ `wordpress-plugin-engineering`), Angular component code (→ `pa-angular-implementation`), accessibility audit (→ `pa-accessibility-audit`)
- **Overlap note**: WordPress and Angular skills have security sections (sanitization, escaping). This skill goes deeper: auth flows, API exposure, headers, secrets, supply chain. Use this skill for security-focused review, the other skills for implementation.

## Triggers
- "review security" / "security audit" / "is this secure?"
- "harden the API" / "lock down endpoints"
- "fix authentication issue" / "authorization bypass"
- "configure CSP" / "set security headers" / "fix CORS"
- "secret exposed" / "credentials in code"
- "prepare for security review" / "pre-delivery security check"
- "dependency vulnerability" / "supply chain risk"

## When NOT to Use
- Penetration testing or exploit development
- Infrastructure/network security
- Generic code review without security focus
- Accessibility audit (→ `pa-accessibility-audit`)
- GDPR policy decisions (→ `gdpr-and-self-hosting` steering)

## Goals
- Identify security risks that could lead to data exposure, unauthorized access, or service compromise
- Distinguish between exploitable risks and theoretical concerns — prioritize by real impact
- Provide actionable remediation: specific code changes, configuration fixes, architecture recommendations
- Reduce attack surface: fewer exposed endpoints, fewer external dependencies, fewer secrets in code

## Constraints
- Principle of least privilege: every user, role, API key, and service account gets minimum necessary access
- Never trust client input: validate and sanitize ALL input on the server, regardless of client-side validation
- Never expose secrets: no API keys, passwords, tokens, or credentials in code, logs, error messages, or client bundles
- Always use parameterized queries: no string concatenation for SQL, LDAP, or command execution
- Always set security headers: `Strict-Transport-Security`, `Content-Security-Policy`, `X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`
- CORS: explicit allowlist of origins, never `Access-Control-Allow-Origin: *` for authenticated endpoints
- Session tokens: HttpOnly, Secure, SameSite=Strict (or Lax with justification)
- Error responses: generic messages to users, detailed logs server-side only
- Dependencies: pin versions, audit regularly (`npm audit`, `pip audit`), remove unused
- Self-hosted assets: no external scripts/fonts/CDN that expand the trust boundary (GDPR + security)

## Input Minimi
- Application type (WordPress, Angular, API, hybrid)
- Authentication method (session, JWT, OAuth, SPID)
- Deployment environment (shared hosting, VPS, cloud, container)
- Known concerns (if any)

## Check Before Acting
- Authentication flow: how do users log in? How are sessions managed?
- Authorization: how are roles/permissions checked? Where?
- API endpoints: list exposed routes, methods, auth requirements
- Headers: check with `curl -I https://site.com`
- Dependencies: `npm audit` / `pip audit` / `composer audit`
- Secrets: `grep -rn "password\|secret\|api_key\|token" --include="*.php" --include="*.ts" --include="*.env"`
- Error handling: what do error pages reveal?

## Checklist

### Authentication & Session
1. Passwords hashed with bcrypt/argon2 (never MD5/SHA1)
2. Session tokens: HttpOnly, Secure, SameSite
3. CSRF protection on all state-changing requests
4. Rate limiting on login endpoint
5. See `references/auth-session-and-access-control.md`

### API & Input
1. All input validated server-side (type, length, format, range)
2. All output encoded for context (HTML, URL, JS, SQL)
3. Parameterized queries for all database operations
4. File uploads: type validation, size limit, no execution
5. See `references/api-endpoint-and-input-security.md`

### Headers & Delivery
1. HTTPS enforced (HSTS)
2. CSP configured (at minimum: `default-src 'self'`)
3. CORS: explicit origin allowlist
4. No secrets in client bundle or source maps
5. Dependencies audited, no known vulnerabilities
6. See `references/headers-cors-csp-secrets-and-delivery.md`

## Gotchas

1. **Authorization check on the frontend only.** Angular route guard prevents navigation but the API endpoint has no auth check. Anyone with the URL can access the data. Fix: ALWAYS check authorization server-side. Frontend guards are UX, not security.

2. **CORS `Access-Control-Allow-Origin: *` on authenticated API.** Allows any website to make authenticated requests. Fix: explicit allowlist of trusted origins. `*` only for truly public, unauthenticated endpoints.

3. **JWT stored in localStorage.** Accessible to any XSS attack. Fix: store in HttpOnly cookie. If localStorage is unavoidable, implement strict CSP to prevent XSS.

4. **Error page reveals stack trace.** Production error shows file paths, database names, framework version. Fix: generic error page for users (`Si è verificato un errore`), detailed logging server-side only. `WP_DEBUG = false` in production.

5. **API key in Angular environment.ts.** Compiled into the JS bundle, visible to anyone. Fix: API keys that grant write access or access sensitive data must NEVER be in client code. Use a backend proxy.

6. **WordPress `wp-config.php` with default salts.** Or worse, no salts at all. Fix: generate unique salts from `https://api.wordpress.org/secret-key/1.1/salt/` and keep them secret.

7. **No rate limiting on API.** Attacker can brute-force login, enumerate users, or DoS the service. Fix: rate limit by IP on auth endpoints (e.g., 5 attempts/minute). Use `express-rate-limit`, WordPress login limiter plugin, or reverse proxy rules.

8. **Dependency with known vulnerability ignored.** `npm audit` shows 3 high-severity issues but nobody fixes them. Fix: audit dependencies in CI. Block deployment if high/critical vulnerabilities exist. Update or replace vulnerable packages.

9. **CSP missing or `unsafe-inline` everywhere.** No protection against XSS. Fix: start with `default-src 'self'; script-src 'self'; style-src 'self' 'unsafe-inline'` (inline styles are hard to eliminate). Progressively tighten. Use nonces for inline scripts if needed.

10. **Logging user passwords or tokens.** Debug logging captures the full request body including credentials. Fix: sanitize logs. Never log passwords, tokens, session IDs, or PII. Log request metadata (method, path, status, user ID), not body content.

## Handoff
- After security review → kiro-builder for remediation implementation
- If WordPress-specific → load `wordpress-plugin-engineering` for sanitization/escaping patterns
- If Angular-specific → load `pa-angular-implementation` for SPA security patterns
- If API design issue → kiro-architect for API redesign
- After remediation → re-run security review (this skill again)

## Memory Guidance
**TotalRecall**: Security findings and their resolutions, hardening configurations that worked, vulnerability patterns per project, remediation decisions
**Kore candidates**: Security review checklists that work across projects, common vulnerability→fix patterns, header configurations, auth flow patterns
**Never save**: Actual passwords, API keys, tokens, or credentials. Never save exploit details or attack payloads.

## When to Read Support Files
- **Reviewing auth/sessions/access control?** Read `references/auth-session-and-access-control.md`
- **Reviewing API endpoints or input handling?** Read `references/api-endpoint-and-input-security.md`
- **Configuring headers, CORS, CSP, or managing secrets?** Read `references/headers-cors-csp-secrets-and-delivery.md`
- **Reviewing a WordPress plugin/site?** Read `examples/wordpress-plugin-security-review-example.md`
- **Reviewing an Angular app?** Read `examples/angular-app-security-review-example.md`
- **Hardening an API?** Read `examples/api-hardening-example.md`
