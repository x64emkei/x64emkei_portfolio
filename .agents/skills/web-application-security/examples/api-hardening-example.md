# API Hardening Example

## Scenario: REST API for a PA Service Portal

Express.js API serving an Angular frontend. Handles: authentication (SPID/CIE), service requests, document upload, payment initiation.

## Before Hardening

```typescript
const app = express();
app.use(cors());                          // ❌ Wide open
app.use(express.json());                  // ❌ No size limit
app.use(express.static('public'));        // ❌ May expose sensitive files

app.post('/api/login', loginHandler);     // ❌ No rate limiting
app.get('/api/users', getUsers);          // ❌ No auth check
app.post('/api/upload', uploadHandler);   // ❌ No file validation
app.get('/api/richieste', getRichieste);  // ❌ No pagination
```

## After Hardening

```typescript
import express from 'express';
import helmet from 'helmet';
import cors from 'cors';
import rateLimit from 'express-rate-limit';

const app = express();

// 1. Security headers
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
  },
  hsts: { maxAge: 31536000, includeSubDomains: true, preload: true },
}));

// 2. CORS: explicit origins
const allowedOrigins = [
  'https://servizi.comune.example.it',
  'https://comune.example.it',
];
app.use(cors({
  origin: allowedOrigins,
  credentials: true,
  methods: ['GET', 'POST', 'PUT', 'DELETE'],
}));

// 3. Body size limit
app.use(express.json({ limit: '1mb' }));

// 4. Rate limiting
const authLimiter = rateLimit({
  windowMs: 60 * 1000,  // 1 minute
  max: 5,               // 5 attempts
  message: { error: 'Troppi tentativi. Riprova tra un minuto.' },
});

const apiLimiter = rateLimit({
  windowMs: 60 * 1000,
  max: 100,
  message: { error: 'Troppe richieste. Riprova tra un minuto.' },
});

// 5. Auth middleware
function requireAuth(req, res, next) {
  const token = req.cookies.session_token;
  if (!token) return res.status(401).json({ error: 'Autenticazione richiesta' });
  
  const session = sessionStore.get(token);
  if (!session) return res.status(401).json({ error: 'Sessione scaduta' });
  
  req.user = session.user;
  next();
}

function requireRole(role) {
  return (req, res, next) => {
    if (!req.user || req.user.role !== role) {
      return res.status(403).json({ error: 'Non autorizzato' });
    }
    next();
  };
}

// 6. Routes with auth + rate limiting
app.post('/api/login', authLimiter, loginHandler);
app.get('/api/users', requireAuth, requireRole('admin'), getUsers);
app.post('/api/upload', requireAuth, apiLimiter, uploadHandler);
app.get('/api/richieste', requireAuth, apiLimiter, getRichieste);

// 7. Error handler (no stack traces)
app.use((err, req, res, next) => {
  console.error(`[${new Date().toISOString()}] ${req.method} ${req.path}:`, err.message);
  // Never send stack trace to client
  res.status(err.status || 500).json({
    error: 'Si è verificato un errore. Riprova più tardi.',
  });
});

// 8. 404 handler
app.use((req, res) => {
  res.status(404).json({ error: 'Endpoint non trovato' });
});
```

## What Changed

| Before | After | Why |
|--------|-------|-----|
| `cors()` wide open | Explicit origin allowlist | Prevents cross-site request abuse |
| No body size limit | `limit: '1mb'` | Prevents DoS via large payloads |
| No rate limiting | 5/min on auth, 100/min on API | Prevents brute force and abuse |
| No auth on endpoints | `requireAuth` + `requireRole` middleware | Prevents unauthorized access |
| Error shows stack trace | Generic message + server-side log | Prevents information disclosure |
| No security headers | helmet with CSP, HSTS, X-Frame-Options | Browser-level protections |
| Static files exposed | Removed (serve via reverse proxy) | Prevents accidental file exposure |

## Verification

```bash
# 1. Check headers
curl -I https://api.comune.example.it/api/health

# 2. Test CORS rejection
curl -H "Origin: https://evil.com" -I https://api.comune.example.it/api/richieste
# Should NOT have Access-Control-Allow-Origin: https://evil.com

# 3. Test rate limiting
for i in {1..10}; do curl -s -o /dev/null -w "%{http_code}\n" -X POST https://api.comune.example.it/api/login -d '{}'; done
# Should see 429 after 5 attempts

# 4. Test auth required
curl -s https://api.comune.example.it/api/users
# Should return 401, not user data

# 5. Test error handling
curl -s https://api.comune.example.it/api/nonexistent
# Should return {"error":"Endpoint non trovato"}, not stack trace
```
