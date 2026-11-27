<?php
declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap/autoload.php';

$input = <<<'MARKDOWN'
# Title

A **bold** word and [link](https://example.com).

- One
- Two

> Quote

```php
echo '<script>';
```
MARKDOWN;

$html = \App\Services\MarkdownRenderer::render($input);
$checks = [
    str_contains($html, '<h1>Title</h1>'),
    str_contains($html, '<strong>bold</strong>'),
    str_contains($html, '<pre><code class="language-php">'),
    !str_contains($html, '<script>'),
    str_contains($html, '&lt;script&gt;'),
];

if (in_array(false, $checks, true)) {
    fwrite(STDERR, "MARKDOWN_TEST=FAIL\n" . $html . "\n");
    exit(1);
}

echo "MARKDOWN_TEST=PASS\n";
