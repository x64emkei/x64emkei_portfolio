<?php
/**
 * Shared SEO, Open Graph, Twitter Card & JSON-LD Metadata Partial
 */
$seoTitle = (string)($seoTitle ?? $metaTitle ?? $pageTitle ?? 'Michael Benedict Ordenes | Portfolio');
$seoDesc = (string)($seoDesc ?? $metaDesc ?? ($profile['tagline'] ?? 'AI-assisted Software Developer, PHP Web Developer & Systems Builder portfolio.'));
$seoType = (string)($seoType ?? 'website');
$appConfig = require dirname(__DIR__, 4) . '/config/app.php';
$baseUrl = rtrim((string) ($appConfig['url'] ?? 'https://welcome.x64emkei.dpdns.org'), '/');
$reqPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$canonicalUrl = (string)($canonicalUrl ?? ($baseUrl . $reqPath));
$seoImage = (string)($seoImage ?? ($baseUrl . asset($profile['avatar_url'] ?? 'images/me_2.png')));
$personName = (string)($profile['full_name'] ?? 'Michael Benedict Ordenes');
?>
<meta name="description" content="<?= e($seoDesc) ?>">
<link rel="canonical" href="<?= e($canonicalUrl) ?>">
<meta property="og:type" content="<?= e($seoType) ?>">
<meta property="og:title" content="<?= e($seoTitle) ?>">
<meta property="og:description" content="<?= e($seoDesc) ?>">
<meta property="og:url" content="<?= e($canonicalUrl) ?>">
<meta property="og:image" content="<?= e($seoImage) ?>">
<meta property="og:site_name" content="x64emkei.dev">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($seoTitle) ?>">
<meta name="twitter:description" content="<?= e($seoDesc) ?>">
<script type="application/ld+json">
<?= json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Person',
    'name' => $personName,
    'alternateName' => 'x64emkei',
    'url' => $baseUrl . url('/'),
    'jobTitle' => (string)($profile['title'] ?? 'AI-Assisted Software Developer & PHP Web Developer'),
    'description' => $seoDesc,
    'sameAs' => [
        'https://github.com/x64_emkei',
        'https://linkedin.com/in/michael-ordenes/',
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>
</script>
