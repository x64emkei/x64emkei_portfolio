# Authentication, Session, and Access Control

## Authentication Patterns

### Password Storage
```
✅ bcrypt (cost factor ≥ 12) or argon2id
❌ MD5, SHA1, SHA256 without salt
❌ Plain text (obviously)
❌ Reversible encryption
```

WordPress uses `wp_hash_password()` (phpass-based) — acceptable but bcrypt is better for custom implementations.

### Session Management

| Setting | Secure Value | Why |
|---------|-------------|-----|
| `HttpOnly` | `true` | Prevents JavaScript access (XSS protection) |
| `Secure` | `true` | Only sent over HTTPS |
| `SameSite` | `Strict` or `Lax` | Prevents CSRF via cross-site requests |
| `Max-Age` | Context-dependent | Short for sensitive apps (30min), longer for low-risk |
| `Path` | `/` or specific | Limit cookie scope |

### JWT vs Session Cookies

| Factor | JWT | Session Cookie |
|--------|-----|----------------|
| Storage | Client-side (cookie or header) | Server-side (session store) |
| Revocation | Hard (need blocklist) | Easy (delete from store) |
| Scalability | Stateless (no server store) | Requires shared session store |
| XSS risk | High if in localStorage | Low if HttpOnly cookie |
| Best for | API-to-API, microservices | Traditional web apps, WordPress |

**Rule**: For web apps with login pages, prefer session cookies (HttpOnly, Secure, SameSite). For API-only services, JWT in HttpOnly cookie or Authorization header.

### CSRF Protection

| Framework | Method |
|-----------|--------|
| WordPress | `wp_nonce_field()` + `wp_verify_nonce()` |
| Angular | `HttpClientXsrfModule` (automatic XSRF token) |
| Express | `csurf` middleware or `csrf-csrf` |
| Django | `{% csrf_token %}` (built-in) |

Every state-changing request (POST, PUT, DELETE) must include CSRF token. GET requests must never change state.

## Access Control Patterns

### Role-Based Access Control (RBAC)

```
Check authorization at EVERY layer:
1. Route/middleware level: "Is the user authenticated?"
2. Controller level: "Does the user have the required role?"
3. Data level: "Does the user own this resource?"
```

### WordPress Capabilities
```php
// ✅ Correct: check capability before action
if (!current_user_can('manage_options')) {
    wp_die('Non autorizzato');
}

// ❌ Wrong: check role name (fragile, custom roles break it)
if (get_current_user_role() !== 'administrator') { ... }
```

### Angular Route Guards
```typescript
// Route guard is UX, NOT security
canActivate(): boolean {
  return this.authService.isAuthenticated();
}
// The API endpoint MUST also check auth independently
```

**Critical rule**: Frontend auth checks are for UX (hide buttons, redirect). Backend auth checks are for security (reject unauthorized requests). Both are needed.

## Common Auth Vulnerabilities

| Vulnerability | Risk | Fix |
|--------------|------|-----|
| No rate limiting on login | Brute force | 5 attempts/min per IP, lockout after 10 |
| Password reset token doesn't expire | Account takeover | 1-hour expiry, single-use |
| User enumeration via login error | Information disclosure | Same error for wrong user and wrong password |
| Session not invalidated on logout | Session hijacking | Destroy server-side session on logout |
| Session not invalidated on password change | Persistence after compromise | Invalidate all sessions on password change |
| Remember-me token predictable | Session hijacking | Cryptographically random, stored hashed |
