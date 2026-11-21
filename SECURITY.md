# Cybersecurity & Threat Mitigation Guide // x64emkei.dev

This document outlines the security architecture and defensive controls implemented across **x64emkei.dev**.

---

## 1. Authentication & Session Security

- **Password Hashing**: Passwords are encrypted using PHP's native `password_hash()` algorithm (`PASSWORD_DEFAULT` utilizing modern Bcrypt / Argon2id).
- **Session Fixation Defense**: Calls `session_regenerate_id(true)` upon successful login and logout.
- **Session Cookie Flags**:
  - `HttpOnly`: Mitigates client-side session theft via XSS.
  - `SameSite=Lax`: Defends against Cross-Site Request Forgery (CSRF).
  - `Secure`: Automatically activated whenever requests are delivered over HTTPS.
- **Account Lockout & Brute-Force Rate Limiting**:
  - Failed logins are tracked per IP and username.
  - After 5 consecutive failed attempts, access is locked out for 15 minutes.

---

## 2. SQL Injection Prevention

- **100% Parameterized Queries**: Every database query executes through PHP Data Objects (`PDO`) with prepared statements and parameter binding.
- **`PDO::ATTR_EMULATE_PREPARES => false`**: Forces true server-side prepared statements, eliminating SQL concatenation vulnerabilities.

---

## 3. Cross-Site Scripting (XSS) Prevention

- **Strict Output Encoding**: All database-driven content rendered in public and administrative views passes through the helper:
  ```php
  function e(?string $value): string {
      return htmlspecialchars((string)($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
  }
  ```
- **Content Security Policy (CSP)**: Emits restrictive CSP headers allowing assets from `'self'`, Google Fonts, and explicit inline scripts necessary for the HUD equalizers.

---

## 4. Cross-Site Request Forgery (CSRF) Defense

- **Cryptographic Token Verification**: A 64-character cryptographically secure token (`random_bytes(32)`) is generated and validated using `hash_equals()` on every state-changing request (`POST`, `PUT`, `DELETE`).
- **Honeypot Protection**: The contact transmission form includes an invisible honeypot field (`contact_botcheck`) that silently discards automated spam bots without executing backend processing.

---

## 5. File Upload Hardening

- **MIME Type Validation**: Uses PHP's `finfo_open(FILEINFO_MIME_TYPE)` on the server to inspect raw file signatures. Browser-supplied `Content-Type` headers are never trusted.
- **Allowed Formats**: Restricted strictly to JPEG, PNG, WebP, GIF, and sanitized SVG.
- **SVG Sanitization**: Blocks SVGs containing embedded `<script>`, `onload`, or `javascript:` directives.
- **Cryptographic Renaming**: Files are renamed with `bin2hex(random_bytes(8))` to prevent path traversal (`../`) and filename collision attacks.
- **Script Execution Prevention**: An `.htaccess` file inside `storage/uploads/` denies execution of PHP, Perl, Python, or shell scripts:
  ```apache
  <FilesMatch "\.(php|phtml|php3|php4|php5|php7|php8|phps|cgi|pl|sh|py)$">
      Require all denied
      Deny from all
  </FilesMatch>
  Options -Indexes -ExecCGI
  ```

---

## 6. Infrastructure Protection

- **Direct File Inspection Denied**: Root `.htaccess` rejects requests to `.env`, `.git`, `.md`, `composer.json`, and private folders (`app/`, `config/`, `database/`, `storage/logs/`).
- **Custom Error Display**: Detailed PHP stack traces and database credentials are kept out of public HTTP responses. Uncaught exceptions log to `storage/logs/error.log` and render an HUD-styled 500 fault banner.
