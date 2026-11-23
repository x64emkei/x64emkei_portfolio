---
name: fullstack-engineering
version: "1.0.0"
last_updated: 2026-11-24
tags: [fullstack, php, security, frontend, design, technical-debt, architecture, quality]
description: "Unified fullstack engineering standards combining PHP 8.0+ development (PDO, XAMPP, REST APIs), PHP best practices (PSR-12, SOLID), universal P0 security standards & OWASP audit protocols, frontend design (WCAG 2.2 AA, responsive UI/UX), and technical debt management & audit ledgers."
metadata:
  author: x64emkei
  integrated_from:
    - php-development
    - php-best-practices
    - common-security-standards
    - security-audit
    - frontend-design
    - technical-debt
---

# Unified Fullstack Engineering & Security Standards

Comprehensive fullstack engineering guide integrating modern PHP 8.0+ backend development, PSR-12 clean architecture, zero-trust security standards, OWASP audit checklists, accessible and responsive frontend design, and technical debt audit/prioritization protocols.

---

## Table of Contents

1. [Architecture & PHP Best Practices (PSR-12 & SOLID)](#1-architecture--php-best-practices)
2. [PHP 8.0+ Fundamentals & Modern Syntax](#2-php-80-fundamentals--modern-syntax)
3. [Secure Database Engineering (PDO & MySQL/MariaDB)](#3-secure-database-engineering-pdo--mysqlmariadb)
4. [RESTful API Architecture & XAMPP Configuration](#4-restful-api-architecture--xampp-configuration)
5. [Universal Security Standards (P0 Critical)](#5-universal-security-standards-p0-critical)
6. [Security Audit, Threat Modeling & Vulnerability Remediation](#6-security-audit-threat-modeling--vulnerability-remediation)
7. [Frontend Design, UI/UX & WCAG 2.2 AA Accessibility](#7-frontend-design-uiux--wcag-22-aa-accessibility)
8. [Technical Debt Inventory & Prioritization Framework](#8-technical-debt-inventory--prioritization-framework)
9. [Master Verification Protocol & Quality Checklist](#9-master-verification-protocol--quality-checklist)

---

## 1. Architecture & PHP Best Practices

### Recommended Project Structure

```text
src/
├── {Domain}/             # Business domains (e.g., Services, Repositories, Models)
├── Middleware/           # Auth, CORS, rate-limiting, error handling
├── Controllers/          # Request handling and response dispatch
├── Utils/                # Validators, response formatters, crypto helpers
└── Helpers/              # Pure functions, traits, and shared constants
```

### PSR-12 Coding Standards
- **Indentation & Spacing:** Strict 4-space indentation; no tab characters.
- **Braces:** Opening braces for classes and methods on their own line; control structure braces on the same line.
- **Strict Types:** Every PHP file must declare strict typing at the very top: `declare(strict_types=1);`.
- **Naming Conventions:**
  - Classes & Interfaces: `PascalCase` (e.g., `UserRepository`, `PaymentServiceInterface`)
  - Methods & Variables: `camelCase` (e.g., `getUserById`, `recipeData`)
  - Class Constants: `SNAKE_CASE` (e.g., `MAX_RETRY_COUNT`, `DEFAULT_PAGE_SIZE`)
  - Namespaces: Aligned with directory structure (PSR-4 autoloading).

### SOLID Principles in Application Code
- **Single Responsibility Principle (SRP):** Each class must have only one reason to change. Keep service/repository classes under ~200 lines.
- **Open/Closed Principle (OCP):** Open for extension via interfaces and inheritance, closed for modification.
- **Liskov Substitution Principle (LSP):** Subtypes must be substitutable for their base types without altering correctness.
- **Interface Segregation Principle (ISP):** Prefer small, client-specific interfaces over bloated multipurpose ones.
- **Dependency Inversion Principle (DIP):** Depend upon abstractions, not concretions. Inject dependencies via constructors.

### Clean Code Patterns & Guard Clauses
- **Guard Clauses:** Return early for validation/error states. Never use `else` after a `return` or `throw`.
- **No Echo in Services:** Services must return data or throw typed exceptions; only controllers format and send HTTP output.
- **Traits for Cross-Cutting Concerns:** Use lightweight traits (e.g., `HasTimestamps`, `Auditable`) for reusable entity behavior.
- **No Magic Numbers:** All literals and thresholds must be declared as named class constants.

---

## 2. PHP 8.0+ Fundamentals & Modern Syntax

### Modern Language Features

```php
<?php
declare(strict_types=1);

namespace App\Domain\User;

use DateTimeImmutable;

// 1. Constructor property promotion & typed properties
class User {
    public function __construct(
        public readonly int $id,
        public string $name,
        public string $email,
        private string $passwordHash,
        public readonly DateTimeImmutable $createdAt = new DateTimeImmutable()
    ) {}

    public function verifyPassword(string $plainPassword): bool {
        return password_verify($plainPassword, $this->passwordHash);
    }
}

// 2. Named arguments & union types
function findUsers(
    string|int $query,
    int $limit = 20,
    int $offset = 0,
    bool $activeOnly = true
): array {
    // Implementation
    return [];
}

// Invocation using named arguments:
$results = findUsers(query: 'admin', limit: 10, activeOnly: true);

// 3. Nullsafe operator & match expressions
$statusDescription = match($order?->status) {
    'pending'   => 'Awaiting payment confirmation',
    'paid'      => 'Payment verified, preparing shipment',
    'shipped'   => 'In transit to destination',
    'cancelled' => 'Order was cancelled',
    default     => 'Unknown order state',
};
```

---

## 3. Secure Database Engineering (PDO & MySQL/MariaDB)

### Database Singleton Connection Class

```php
<?php
declare(strict_types=1);

namespace App\Utils;

use PDO;
use PDOException;
use RuntimeException;

class Database {
    private static ?PDO $instance = null;

    public static function getInstance(): PDO {
        if (self::$instance === null) {
            $host    = $_ENV['DB_HOST'] ?? 'localhost';
            $dbname  = $_ENV['DB_NAME'] ?? 'portfolio_system';
            $user    = $_ENV['DB_USER'] ?? 'root';
            $pass    = $_ENV['DB_PASSWORD'] ?? '';
            $charset = 'utf8mb4';

            $dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";

            try {
                self::$instance = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false, // Always true prepared statements
                ]);
            } catch (PDOException $e) {
                error_log("Database connection failure: " . $e->getMessage());
                throw new RuntimeException("Database service unavailable");
            }
        }

        return self::$instance;
    }
}
```

### Parameterized Prepared Statements & Password Security

```php
<?php
declare(strict_types=1);

namespace App\Domain\User;

use PDO;

class UserRepository {
    public function __construct(private PDO $db) {}

    public function findByEmail(string $email): ?array {
        $stmt = $this->db->prepare(
            'SELECT id, name, email, password_hash, role, status 
             FROM users 
             WHERE email = :email LIMIT 1'
        );
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function create(string $name, string $email, string $password): int {
        // Secure password hashing with default algorithm (bcrypt / Argon2id)
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare(
            'INSERT INTO users (name, email, password_hash, role, status, created_at)
             VALUES (:name, :email, :password_hash, :role, :status, NOW())'
        );

        $stmt->execute([
            ':name'          => $name,
            ':email'         => $email,
            ':password_hash' => $passwordHash,
            ':role'          => 'user',
            ':status'        => 'active',
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function authenticate(string $email, string $password): ?array {
        $user = $this->findByEmail($email);
        if (!$user) return null;

        if (!password_verify($password, $user['password_hash'])) {
            return null;
        }

        // Check if algorithm requires rehash
        if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $rehashStmt = $this->db->prepare('UPDATE users SET password_hash = :hash WHERE id = :id');
            $rehashStmt->execute([':hash' => $newHash, ':id' => $user['id']]);
        }

        unset($user['password_hash']);
        return $user;
    }
}
```

### Atomic Transaction Management

```php
<?php
declare(strict_types=1);

namespace App\Domain\Order;

use PDO;
use Exception;
use RuntimeException;

class OrderService {
    public function __construct(private PDO $db) {}

    public function createOrder(int $userId, array $items): int {
        try {
            $this->db->beginTransaction();

            $orderStmt = $this->db->prepare(
                'INSERT INTO orders (user_id, status, created_at) VALUES (:user_id, "pending", NOW())'
            );
            $orderStmt->execute([':user_id' => $userId]);
            $orderId = (int) $this->db->lastInsertId();

            $itemStmt = $this->db->prepare(
                'INSERT INTO order_items (order_id, product_id, quantity, unit_price) 
                 VALUES (:order_id, :product_id, :quantity, :unit_price)'
            );

            foreach ($items as $item) {
                $itemStmt->execute([
                    ':order_id'   => $orderId,
                    ':product_id' => $item['productId'],
                    ':quantity'   => $item['quantity'],
                    ':unit_price' => $item['unitPrice'],
                ]);
            }

            $this->db->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Order creation failed: " . $e->getMessage());
            throw new RuntimeException("Transaction failed: unable to process order");
        }
    }
}
```

---

## 4. RESTful API Architecture & XAMPP Configuration

### JSON Response Helpers

```php
<?php
declare(strict_types=1);

namespace App\Utils;

class Response {
    public static function json(mixed $data, int $statusCode = 200): never {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: DENY');
        echo json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
        exit;
    }

    public static function error(string $message, int $statusCode = 400, array $errors = []): never {
        self::json([
            'success' => false,
            'error'   => $message,
            'details' => $errors,
        ], $statusCode);
    }

    public static function success(mixed $data = null, string $message = 'Success', int $statusCode = 200): never {
        self::json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $statusCode);
    }
}
```

### CORS & Authentication Middleware

```php
<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Utils\Response;

class SecurityMiddleware {
    public static function handleCors(array $allowedOrigins): void {
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
        if (in_array($origin, $allowedOrigins, true)) {
            header("Access-Control-Allow-Origin: {$origin}");
            header('Access-Control-Allow-Credentials: true');
        }

        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }
    }

    public static function requireAuth(): array {
        $header = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        if (!preg_match('/Bearer\s+(.*)$/i', $header, $matches)) {
            Response::error('Unauthorized: Missing or invalid token', 401);
        }

        $token = $matches[1];
        // Validate token signature & payload
        $user = TokenService::verify($token);
        if (!$user) {
            Response::error('Unauthorized: Session expired or invalid', 401);
        }

        return $user;
    }
}
```

### Apache `.htaccess` Routing

```apache
RewriteEngine On

# Redirect trailing slashes
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_URI} (.+)/$
RewriteRule ^ %1 [L,R=301]

# Route API endpoints
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^api/(.*)$ api/index.php [QSA,L]

# Route Single Page Application (SPA) / Portfolio
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.html [QSA,L]
```

### Production `php.ini` Hardening
```ini
; Display errors off in production; log to secure location
error_reporting = E_ALL
display_errors = Off
display_startup_errors = Off
log_errors = On
error_log = "C:/xampp/php/logs/php_error.log"

; File upload restrictions
upload_max_filesize = 10M
post_max_size = 10M

; Session hardening
session.save_handler = files
session.use_strict_mode = 1
session.cookie_httponly = 1
session.cookie_secure = 1
session.cookie_samesite = "Lax"
session.use_only_cookies = 1
```

---

## 5. Universal Security Standards (P0 Critical)

### Always-Apply Rules (Every Code Write)
1. **No Hardcoded Secrets:** Never commit API keys, database credentials, JWT secrets, or private certificates to git. Inject exclusively via environment variables or secret vaults.
2. **No Raw SQL Interpolation:** Every query touching variable input must use parameterized PDO prepared statements (`:param`). Concatenation `WHERE id = " . $id` is strictly prohibited.
3. **No Stack Traces in Production:** Return generic error envelopes to clients; log structured detail server-side only.
4. **Zero Trust Data Boundary:** Validate and sanitize every piece of external data (query params, POST bodies, cookies, uploaded headers).

### Authority Lifecycle & Privileged Capability Minting
- **Privileged Capability Minting:** Never reuse generic user session tokens for elevated administrative actions. High-risk mutations (permission grant, credential revocation, data export) require single-operation lifetime tokens bound to operation-private issuers.
- **Independently Protected Authority:** Reject client-asserted state or stale cached permission ledgers. Re-verify authority against the authoritative database record at transaction time.
- **Transaction-Time Revalidation:** Re-verify user status, tenancy, and permissions *inside* the writer transaction after acquiring row or advisory locks. Initial snapshot verification does not guard against race conditions.
- **Concurrency Race Protection:** Prevent race conditions across concurrent requests via atomic updates (`UPDATE accounts SET balance = balance - :amount WHERE balance >= :amount`) and idempotency keys.

### Input Validation & Sanitization Engine

```php
<?php
declare(strict_types=1);

namespace App\Utils;

class Validator {
    public static function email(string $email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function string(string $val, int $min = 1, int $max = 255): bool {
        $len = mb_strlen(trim($val), 'UTF-8');
        return $len >= $min && $len <= $max;
    }

    public static function intRange(int $val, int $min, int $max): bool {
        return $val >= $min && $val <= $max;
    }

    public static function enum(string $val, array $allowed): bool {
        return in_array($val, $allowed, true);
    }

    public static function sanitizeHtml(string $input): string {
        return htmlspecialchars(trim($input), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
```

### CSRF Protection & Session Management

```php
<?php
declare(strict_types=1);

namespace App\Utils;

class Csrf {
    public static function token(): string {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function validate(?string $token): bool {
        if (session_status() === PHP_SESSION_NONE) session_start();
        return !empty($token) && hash_equals($_SESSION['csrf_token'] ?? '', $token);
    }

    public static function regenerateSession(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_regenerate_id(true);
    }
}
```

---

## 6. Security Audit, Threat Modeling & Vulnerability Remediation

### Core Vulnerability Checklist
- [ ] **SQL Injection (SQLi):** Zero direct string interpolation; all queries parameterized.
- [ ] **Cross-Site Scripting (XSS):** Context-aware output encoding (`htmlspecialchars`), Content Security Policy (`CSP`) headers configured, no unsanitized `innerHTML`.
- [ ] **Cross-Site Request Forgery (CSRF):** SameSite cookies configured (`SameSite=Lax` or `Strict`), anti-CSRF tokens on state-changing POST/PUT/DELETE requests.
- [ ] **Command & Code Injection:** No `eval()`, `system()`, `exec()`, or `passthru()` with user-derived strings.
- [ ] **Insecure Deserialization:** No PHP `unserialize()` on untrusted input; use `json_decode()`.
- [ ] **Path Traversal & File Uploads:** Uploaded files validated by MIME type & content, re-encoded/hashed, stored outside web root with execution disabled.
- [ ] **XML External Entity (XXE):** `libxml_disable_entity_loader(true)` enforced.
- [ ] **Server-Side Request Forgery (SSRF):** Whitelist outbound destination hosts; block private IP ranges (RFC 1918 / localhost / cloud metadata endpoints `169.254.169.254`).

### Mandatory HTTP Security Headers
```apache
Header always set X-Content-Type-Options "nosniff"
Header always set X-Frame-Options "DENY"
Header always set X-XSS-Protection "1; mode=block"
Header always set Referrer-Policy "strict-origin-when-cross-origin"
Header always set Permissions-Policy "geolocation=(), camera=(), microphone=()"
Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains; preload"
Header always set Content-Security-Policy "default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https:;"
```

### GitHub Actions Workflow Security
- **Never interpolate expressions inside `run:` blocks:**
  ```yaml
  # BAD - vulnerable to script injection
  - run: echo "${{ github.event.issue.title }}"

  # GOOD - inject via environment variables
  - env:
      ISSUE_TITLE: ${{ github.event.issue.title }}
    run: echo "$ISSUE_TITLE"
  ```

---

## 7. Frontend Design, UI/UX & WCAG 2.2 AA Accessibility

### Operational Decision Rubric

| Criterion | Weight | Hard Gate? | Focus |
| :--- | :---: | :---: | :--- |
| **User & Task Fit** | 20% | Yes | Does the UI directly solve the primary objective? |
| **Accessibility (WCAG 2.2 AA)** | 20% | **Yes (Hard Gate)** | Zero keyboard traps, valid contrast, semantic markup. |
| **Usability & IA** | 15% | Yes | Clear reading hierarchy, predictable navigation. |
| **Visual Coherence & Craft** | 15% | No | Coherent typography, spacing tokens, deliberate styling. |
| **Responsive & Adaptive** | 10% | **Yes (Hard Gate)** | Seamless 320px to 4K scaling without horizontal clipping. |
| **Performance & Resilience** | 10% | Yes | Core Web Vitals compliance, graceful degradation. |
| **Interaction & State Completeness**| 5% | Yes | Complete loading, empty, active, and error states. |
| **Maintainability** | 5% | No | Reusable tokens, clean separation of concerns. |

### Design Mode Router
1. **Product / Workspace:** High utility density, restrained color palette, no superfluous landing hero; prioritize fast workflows and clear data tables.
2. **Marketing / Brand:** Bold visual thesis, strong typography, purposeful imagery, clear conversion CTA.
3. **Data / Dashboard:** Fast scanning, status indicators, explicit units/freshness, zero decorative card mosaics.
4. **Editorial / Content:** Optimal line length (50–75 characters), strong typographic scale, sustained reading rhythm.
5. **Commerce / Service:** Trust signals, transparent pricing, step recovery, zero distraction during checkout/critical flows.
6. **Immersive / Experimental:** Deliberate art direction, progressive enhancement, full `prefers-reduced-motion` compliance.

### Accessibility Baseline (WCAG 2.2 Level AA)
- **Contrast Ratios:** Minimum 4.5:1 for standard text; 3.0:1 for large text (>= 18pt or 14pt bold) and UI components/icons.
- **Keyboard Operability:** All interactive elements must be focusable via `Tab` with visible focus indicators (`:focus-visible`).
- **Touch Target Sizing:** Minimum 24 × 24 CSS pixels normative; **44 × 44 CSS pixels recommended** for touch primary actions.
- **Semantic HTML First:** Native `<button>`, `<a>`, `<nav>`, `<main>`, `<dialog>` before ARIA workarounds.
- **Reduced Motion:** Always respect `prefers-reduced-motion: reduce`:
  ```css
  @media (prefers-reduced-motion: reduce) {
    *, *::before, *::after {
      animation-duration: 0.01ms !important;
      animation-iteration-count: 1 !important;
      transition-duration: 0.01ms !important;
      scroll-behavior: auto !important;
    }
  }
  ```

### Performance Budgets (Core Web Vitals)
- **Largest Contentful Paint (LCP):** $\le 2.5\text{ s}$
- **Interaction to Next Paint (INP):** $\le 200\text{ ms}$
- **Cumulative Layout Shift (CLS):** $\le 0.1$
- Set explicit `width` and `height` on images and embeds to prevent layout shift.

---

## 8. Technical Debt Inventory & Prioritization Framework

### The 10 Technical Debt Categories

1. **Code Debt:** Duplication > 30 lines, functions > 50 lines, cyclomatic complexity > 10, god classes (> 300 lines), magic numbers.
2. **Security Debt:** Stored secrets, missing input schemas, outdated password hashes, missing CSRF/CSP headers.
3. **Design Debt:** Circular dependencies, inverted layer boundaries (repository calling UI), shotgun surgery patterns.
4. **Dependency Debt:** Packages > 2 major versions behind, unmaintained packages (> 24 months), unpatched CVEs.
5. **Test Debt:** Critical paths lacking integration tests, skipped/disabled tests, flaky suites, execution > 10 minutes.
6. **Performance Debt:** N+1 queries, unbounded database result sets (missing pagination), bundle size bloat (> 200 KB gzip).
7. **Data Debt:** Manual schema alterations bypassing migrations, missing database indexes on foreign keys, orphaned records.
8. **Documentation Debt:** Contradictory comments, out-of-date setup guides, undocumented public APIs.
9. **Infrastructure Debt:** EOL runtime versions (PHP 7.x, Node < 18), deprecated framework methods, unmonitored services.
10. **Process Debt:** Aging TODO/FIXME markers (> 6 months), lingering dead feature flags, lack of CODEOWNERS.

### Effort × Impact Prioritization Matrix

| Effort | Low Impact | Medium Impact | High Impact | Critical Impact |
| :--- | :---: | :---: | :---: | :---: |
| **Small ($< 1\text{ day}$)** | P3 | P2 | **P1** | **P0** |
| **Medium ($1\text{--}5\text{ days}$)** | P3 | P2 | **P1** | **P0** |
| **Large ($> 1\text{ week}$)** | P3 | P3 | P2 | **P1** *(Break down)* |

*Rule:* Address cheap, high-impact items first (**P0/P1**). Large items must be divided into smaller tasks before scheduling.

### Debt Ledger Format

```markdown
| # | Category | Item Description             | Location               | Effort | Impact   | Priority |
|---|----------|------------------------------|------------------------|:------:|:--------:|:--------:|
| 1 | deps     | Guzzle 6.x (CVE advisory)    | composer.json:18       | S      | CRITICAL | P0       |
| 2 | perf     | Missing index on user_id     | database/schema.sql:45 | S      | HIGH     | P1       |
| 3 | code     | 80-line auth function        | src/Auth/Login.php:32  | M      | MEDIUM   | P2       |
```

### Static Analysis & Audit Commands
```bash
# PHP Quality & Security
composer outdated --direct           # List outdated dependencies
composer audit                       # Scan for known CVE vulnerabilities
vendor/bin/phpstan analyse --level 8 # Static type analysis
vendor/bin/phpmd src text cleancode  # PHP Mess Detector

# Frontend & JavaScript
npm outdated                         # Outdated packages
npm audit                            # JavaScript vulnerability check
npx depcheck                         # Find unused dependencies
npx eslint . --max-warnings 0        # Zero-warning lint check
```

---

## 9. Master Verification Protocol & Quality Checklist

Before completing any task touching the codebase, verify against this unified checklist:

- [ ] **Architecture:** Follows PSR-12 and modular folder structure; functions have strict typehints and guard clauses.
- [ ] **Database:** Uses PDO prepared statements with named parameters; multi-step operations wrapped in atomic transactions.
- [ ] **Security:** No hardcoded credentials; input validated with `Validator`; output sanitized for XSS; CSRF tokens checked.
- [ ] **Frontend:** Meets WCAG 2.2 AA (4.5:1 text contrast, keyboard navigable, 44px touch targets, `prefers-reduced-motion` honored).
- [ ] **Responsive:** Renders cleanly across 320px, 768px, 1024px, and 1440px+ viewports without horizontal clipping.
- [ ] **Technical Debt:** No new code debt (no functions > 50 lines, no magic numbers, no circular dependencies).
