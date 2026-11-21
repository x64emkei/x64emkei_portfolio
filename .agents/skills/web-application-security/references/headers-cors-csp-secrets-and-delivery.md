# Headers, CORS, CSP, Secrets, and Delivery

## Security Headers

### Recommended Headers

```
Strict-Transport-Security: max-age=31536000; includeSubDomains; preload
Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self'; connect-src 'self'; frame-ancestors 'none'
X-Content-Type-Options: nosniff
X-Frame-Options: DENY
Referrer-Policy: strict-origin-when-cross-origin
Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=()
X-XSS-Protection: 0
```

Note: `X-XSS-Protection: 0` is correct — the browser XSS filter is deprecated and can cause issues. CSP replaces it.

### WordPress Implementation
```php
add_action('send_headers', function() {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self'");
});
```

WordPress often needs `'unsafe-inline'` for scripts and styles due to wp-admin and plugins. Tighten progressively.

### Angular / Express Implementation
```typescript
// Express with helmet
import helmet from 'helmet';
app.use(helmet({
  contentSecurityPolicy: {
    directives: {
      defaultSrc: ["'self'"],
      scriptSrc: ["'self'"],
      styleSrc: ["'self'", "'unsafe-inline'"],
      imgSrc: ["'self'", "data:"],
      fontSrc: ["'self'"],
      connectSrc: ["'self'"],
      frameAncestors: ["'none'"],
    }
  }
}));
```

## CORS Configuration

### Secure CORS

```typescript
// ✅ Explicit origin allowlist
const allowedOrigins = ['https://comune.example.it', 'https://servizi.comune.example.it'];
app.use(cors({
  origin: (origin, callback) => {
    if (!origin || allowedOrigins.includes(origin)) {
      callback(null, true);
    } else {
      callback(new Error('Not allowed by CORS'));
    }
  },
  credentials: true,
  methods: ['GET', 'POST', 'PUT', 'DELETE'],
  allowedHeaders: ['Content-Type', 'Authorization'],
}));

// ❌ Wide open
app.use(cors({ origin: '*' }));  // Never for authenticated endpoints
```

### CORS Rules
- `Access-Control-Allow-Origin: *` only for truly public, unauthenticated, read-only endpoints
- Authenticated endpoints: explicit origin allowlist
- `credentials: true` requires specific origin (not `*`)
- Preflight caching: `Access-Control-Max-Age: 86400` to reduce OPTIONS requests

## Content Security Policy (CSP)

### Progressive Tightening

```
Phase 1 (baseline):
  default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'

Phase 2 (remove unsafe-inline for scripts):
  script-src 'self' 'nonce-{random}'; style-src 'self' 'unsafe-inline'

Phase 3 (strict):
  script-src 'self' 'nonce-{random}'; style-src 'self' 'nonce-{random}'
```

Start with Phase 1, test thoroughly, then tighten. `'unsafe-inline'` for styles is often the last to go (many frameworks depend on it).

### CSP Reporting
```
Content-Security-Policy-Report-Only: default-src 'self'; report-uri /csp-report
```
Use `Report-Only` first to find violations without breaking the site.

## Secret Management

### Rules
1. **Never in code**: no API keys, passwords, or tokens in source files
2. **Never in client bundle**: Angular `environment.ts` is compiled into JS — visible to everyone
3. **Never in logs**: sanitize request/response logging
4. **Never in error messages**: generic errors to users
5. **Environment variables**: for server-side secrets (`process.env.DB_PASSWORD`)
6. **`.env` in `.gitignore`**: always, no exceptions
7. **Rotate on exposure**: if a secret is committed to git, rotate immediately (git history preserves it)

### WordPress Secrets
```php
// wp-config.php — unique salts (generate from WordPress API)
define('AUTH_KEY', 'unique-random-string');
define('SECURE_AUTH_KEY', 'unique-random-string');
// ... all 8 salt constants

// Database credentials via environment
define('DB_PASSWORD', getenv('WP_DB_PASSWORD'));
```

### Verification
```bash
# Check for secrets in codebase
grep -rn "password\|secret\|api_key\|token\|private_key" --include="*.php" --include="*.ts" --include="*.js" --include="*.env" . | grep -v node_modules | grep -v ".env.example"
```

## Dependency Security

### Audit Commands
```bash
npm audit                    # Node.js
pip audit                    # Python (pip-audit package)
composer audit               # PHP
```

### Rules
- Audit in CI: fail build on high/critical vulnerabilities
- Pin versions: `"express": "4.18.2"` not `"express": "^4.18.0"`
- Remove unused dependencies: smaller surface = less risk
- Review new dependencies before adding: check maintainer, download count, last update
- Self-host everything: no runtime CDN dependencies (security + GDPR)

## Pre-Delivery Security Checklist

- [ ] HTTPS enforced (HSTS header set)
- [ ] Security headers configured (CSP, X-Content-Type-Options, X-Frame-Options, Referrer-Policy)
- [ ] CORS: explicit origin allowlist (no `*` on authenticated endpoints)
- [ ] All input validated server-side
- [ ] All output encoded for context
- [ ] No secrets in code, logs, or client bundle
- [ ] Dependencies audited, no high/critical vulnerabilities
- [ ] Rate limiting on auth and search endpoints
- [ ] Error pages don't reveal internal details
- [ ] File uploads validated and stored securely
- [ ] Session cookies: HttpOnly, Secure, SameSite
- [ ] CSRF protection on all state-changing requests
- [ ] No external scripts/fonts/CDN in production (GDPR + security)
- [ ] `WP_DEBUG = false` in production (WordPress)
- [ ] Source maps not deployed to production
