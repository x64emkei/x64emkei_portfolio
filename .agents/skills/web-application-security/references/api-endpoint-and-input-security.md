# API Endpoint and Input Security

## Input Validation Rules

### Server-Side Validation (mandatory)

| Input Type | Validation | Example |
|-----------|-----------|---------|
| String | Max length, allowed characters, trim | `name.trim().substring(0, 100)` |
| Number | Type check, min/max range | `parseInt(id); if (id < 1 || id > 999999) reject` |
| Email | Format regex + length limit | `/^[^\s@]+@[^\s@]+\.[^\s@]+$/` + max 254 chars |
| URL | Protocol allowlist (https only), length | Reject `javascript:`, `data:`, `file:` |
| File upload | MIME type check, extension allowlist, size limit | `.pdf,.jpg,.png` only, max 10MB |
| Date | Format validation, range check | ISO 8601, not in the future (if applicable) |
| Free text (HTML) | Sanitize with allowlist | WordPress: `wp_kses_post()`. Angular: DomSanitizer. |
| JSON body | Schema validation | Use Joi, Zod, or JSON Schema |

**Rule**: Client-side validation is UX. Server-side validation is security. Both are needed, but only server-side prevents attacks.

### Output Encoding

| Context | Encoding | WordPress | Angular |
|---------|----------|-----------|---------|
| HTML content | HTML entity encoding | `esc_html()` | Auto-escaped by default |
| HTML attribute | Attribute encoding | `esc_attr()` | `[attr.value]` binding |
| URL | URL encoding | `esc_url()` | `DomSanitizer` |
| JavaScript | JS encoding | `esc_js()` | Avoid `innerHTML` |
| SQL | Parameterized query | `$wpdb->prepare()` | Use ORM/query builder |
| CSS | CSS encoding | Avoid dynamic CSS | Avoid `[style]` with user input |

### SQL Injection Prevention

```php
// ✅ WordPress: parameterized
$wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}items WHERE id = %d", $id));

// ❌ WordPress: concatenated
$wpdb->get_results("SELECT * FROM {$wpdb->prefix}items WHERE id = $id");
```

```typescript
// ✅ TypeORM: parameterized
repository.find({ where: { id: parseInt(req.params.id) } });

// ❌ Raw query with concatenation
connection.query(`SELECT * FROM items WHERE id = ${req.params.id}`);
```

## API Endpoint Security

### Endpoint Exposure Checklist

For every API endpoint, verify:
- [ ] Authentication required? (or intentionally public?)
- [ ] Authorization checked? (correct role/permission?)
- [ ] Input validated? (all parameters, body, headers?)
- [ ] Rate limited? (especially auth and search endpoints)
- [ ] Response doesn't leak sensitive data? (no passwords, tokens, internal IDs)
- [ ] HTTP method correct? (GET for read, POST/PUT for write, DELETE for delete)
- [ ] Pagination enforced? (no unbounded queries)

### Common API Vulnerabilities

| Vulnerability | Risk | Fix |
|--------------|------|-----|
| No auth on admin endpoint | Full compromise | Add auth middleware |
| IDOR (Insecure Direct Object Reference) | Data of other users | Check ownership: `WHERE user_id = $current_user` |
| Mass assignment | Privilege escalation | Allowlist accepted fields, never bind request body directly to model |
| No pagination | DoS via large response | Default limit (20), max limit (100) |
| Verbose error response | Information disclosure | Generic errors to client, detailed logs server-side |
| No input size limit | DoS via large payload | `express.json({ limit: '1mb' })` or equivalent |

### File Upload Security

```
1. Validate MIME type (check magic bytes, not just extension)
2. Allowlist extensions: .pdf, .jpg, .png, .docx — reject everything else
3. Size limit: 10MB default, configurable
4. Store outside web root (not in /uploads/ accessible via URL)
5. Generate random filename (don't use original)
6. Scan for malware if possible
7. Never execute uploaded files (no .php, .js, .sh in upload directory)
```

WordPress: use `wp_check_filetype()` + `wp_handle_upload()` with strict `mimes` filter.
