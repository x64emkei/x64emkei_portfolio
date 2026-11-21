# Angular App Security Review Example

## Scenario: Review of a PA Service Portal (Angular 17)

An Angular SPA for a Comune service portal: citizen login (SPID), service requests, document upload, payment redirect.

## Security Review Findings

### 1. API Key in environment.ts (CRITICAL)
```typescript
// ❌ Found in environments/environment.prod.ts
export const environment = {
  production: true,
  apiUrl: 'https://api.comune.example.it',
  mapsApiKey: 'AIzaSyB1234567890abcdefghijklmnop',  // Google Maps key
  paymentSecret: 'sk_live_abc123def456',              // Payment secret
};
```
**Risk**: Both keys visible in compiled JS bundle. Maps key can be abused (billing). Payment secret = full compromise.
**Fix**: Remove secrets from client code. Use backend proxy:
```typescript
// environment.prod.ts — no secrets
export const environment = {
  production: true,
  apiUrl: 'https://api.comune.example.it',
  // Maps loaded via backend proxy: /api/maps/embed?address=...
  // Payment initiated server-side, client gets redirect URL
};
```

### 2. Authorization Only in Route Guard (HIGH)
```typescript
// ❌ Route guard checks role
canActivate(): boolean {
  return this.authService.hasRole('admin');
}
// But API endpoint /api/admin/users has NO auth check
```
**Risk**: Anyone who knows the API URL can access admin data.
**Fix**: Add auth middleware to EVERY API endpoint:
```typescript
// Express middleware
app.use('/api/admin/*', (req, res, next) => {
  if (!req.user || req.user.role !== 'admin') {
    return res.status(403).json({ error: 'Non autorizzato' });
  }
  next();
});
```

### 3. innerHTML Used with User Content (HIGH)
```html
<!-- ❌ Found in service-detail.component.html -->
<div [innerHTML]="service.description"></div>
```
**Risk**: If `service.description` contains `<script>` or event handlers, XSS is possible. Angular sanitizes by default but `bypassSecurityTrustHtml()` might be used elsewhere.
**Fix**: Verify Angular's built-in sanitization is not bypassed. Search for:
```bash
grep -rn "bypassSecurityTrust" src/ --include="*.ts"
```
If found, evaluate each usage. Remove `bypassSecurityTrustHtml()` unless absolutely necessary and input is from a trusted source (CMS admin, not user input).

### 4. No CSP Header (MEDIUM)
```bash
curl -I https://servizi.comune.example.it
# No Content-Security-Policy header
```
**Risk**: No XSS mitigation at browser level.
**Fix**: Add CSP via Express middleware or reverse proxy:
```
Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self'; connect-src 'self' https://api.comune.example.it; frame-ancestors 'none'
```

### 5. Source Maps Deployed to Production (MEDIUM)
```bash
ls dist/browser/*.map
# main.abc123.js.map, polyfills.def456.js.map
```
**Risk**: Source maps reveal original TypeScript code, making reverse engineering trivial.
**Fix**: In `angular.json`:
```json
"configurations": {
  "production": {
    "sourceMap": false
  }
}
```

### 6. External Font Loaded (LOW but GDPR)
```html
<!-- ❌ Found in index.html -->
<link href="https://fonts.googleapis.com/css?family=Titillium+Web:300,400,600,700" rel="stylesheet">
```
**Risk**: User IP sent to Google on every page load. GDPR violation.
**Fix**: Self-host fonts from `src/assets/fonts/`. See `pa-angular-implementation` skill.

## Remediation Priority

| # | Finding | Severity | Fix Type | Sprint |
|---|---------|----------|----------|--------|
| 1 | API key in client | Critical | Structural (backend proxy) | Immediate |
| 2 | Auth only in guard | High | Structural (API middleware) | Sprint 1 |
| 3 | innerHTML risk | High | Quick (verify sanitization) | Sprint 1 |
| 4 | No CSP | Medium | Quick (add header) | Sprint 1 |
| 5 | Source maps | Medium | Quick (build config) | Sprint 1 |
| 6 | External font | Low/GDPR | Quick (self-host) | Sprint 1 |
