# WordPress Plugin Security Review Example

## Scenario: Review of a Custom PA Plugin

A custom WordPress plugin for a Comune handles service requests (form submission, file upload, email notification).

## Security Review Findings

### 1. SQL Injection in Search (CRITICAL)
```php
// ❌ Found in includes/search.php
$results = $wpdb->get_results(
    "SELECT * FROM {$wpdb->prefix}richieste WHERE oggetto LIKE '%{$_GET['q']}%'"
);
```
**Risk**: Attacker can extract entire database via search parameter.
**Fix**:
```php
$results = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}richieste WHERE oggetto LIKE %s",
        '%' . $wpdb->esc_like(sanitize_text_field($_GET['q'])) . '%'
    )
);
```

### 2. Missing Capability Check on Admin Action (HIGH)
```php
// ❌ Found in admin/actions.php
add_action('wp_ajax_delete_richiesta', function() {
    $id = intval($_POST['id']);
    $wpdb->delete("{$wpdb->prefix}richieste", ['id' => $id]);
    wp_send_json_success();
});
```
**Risk**: Any logged-in user (even subscriber) can delete requests.
**Fix**:
```php
add_action('wp_ajax_delete_richiesta', function() {
    check_ajax_referer('richieste_nonce');
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Non autorizzato', 403);
    }
    $id = absint($_POST['id']);
    $wpdb->delete("{$wpdb->prefix}richieste", ['id' => $id], ['%d']);
    wp_send_json_success();
});
```

### 3. XSS in Admin Display (HIGH)
```php
// ❌ Found in admin/views/list.php
<td><?php echo $richiesta->nome; ?></td>
<td><?php echo $richiesta->email; ?></td>
```
**Risk**: Stored XSS — attacker submits `<script>` in name field, admin sees it.
**Fix**:
```php
<td><?php echo esc_html($richiesta->nome); ?></td>
<td><?php echo esc_html($richiesta->email); ?></td>
```

### 4. File Upload Without Validation (HIGH)
```php
// ❌ Found in includes/form-handler.php
$uploaded = wp_handle_upload($_FILES['allegato'], ['test_form' => false]);
```
**Risk**: Any file type accepted, including .php (remote code execution).
**Fix**:
```php
$allowed_types = ['application/pdf', 'image/jpeg', 'image/png'];
$file_type = wp_check_filetype($_FILES['allegato']['name']);
if (!in_array($file_type['type'], $allowed_types)) {
    wp_die('Tipo di file non consentito');
}
$uploaded = wp_handle_upload($_FILES['allegato'], [
    'test_form' => false,
    'mimes' => ['pdf' => 'application/pdf', 'jpg' => 'image/jpeg', 'png' => 'image/png'],
]);
```

### 5. No CSRF Protection on Form (MEDIUM)
```php
// ❌ Form has no nonce
<form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
    <input type="hidden" name="action" value="submit_richiesta">
```
**Fix**:
```php
<form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
    <?php wp_nonce_field('submit_richiesta', 'richiesta_nonce'); ?>
    <input type="hidden" name="action" value="submit_richiesta">
```
And in handler: `if (!wp_verify_nonce($_POST['richiesta_nonce'], 'submit_richiesta')) wp_die('Nonce non valido');`

## Remediation Priority

| # | Finding | Severity | Fix Type | Sprint |
|---|---------|----------|----------|--------|
| 1 | SQL injection | Critical | Quick | Immediate |
| 2 | Missing capability check | High | Quick | Sprint 1 |
| 3 | XSS in admin | High | Quick | Sprint 1 |
| 4 | File upload no validation | High | Quick | Sprint 1 |
| 5 | No CSRF | Medium | Quick | Sprint 1 |

All fixes are quick (code changes, no redesign). Total effort: ~2 hours.
