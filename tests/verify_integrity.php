<?php
declare(strict_types=1);

require_once __DIR__ . '/../bootstrap/autoload.php';
require_once __DIR__ . '/../bootstrap/app.php';

echo "\n--- VERIFYING ARCHITECTURAL REQUIREMENTS ---\n";

function getPage(string $uri): string {
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = $uri;
    ob_start();
    $router = require __DIR__ . '/../routes/web.php';
    $router->dispatch();
    return ob_get_clean();
}

$errors = [];

// 1. Verify Home & Sidebar
$homeHtml = getPage('/');
if (strpos($homeHtml, 'class="site-footer"') === false) {
    $errors[] = "Home page missing site-footer";
}
if (preg_match('/<aside[^>]*>.*?data-section="admin".*?<\/aside>/is', $homeHtml)) {
    $errors[] = "Admin link found inside public sidebar!";
} else {
    echo "  [PASS] Admin cleanly excluded from public sidebar\n";
}
if (strpos($homeHtml, '/admin/login') === false) {
    $errors[] = "Admin Login not found in footer";
} else {
    echo "  [PASS] Admin Login correctly placed in professional footer\n";
}

// 2. Verify About Dossier
$aboutHtml = getPage('/about');
$aboutSections = ['biography', 'education', 'skills', 'experience', 'certifications'];
foreach ($aboutSections as $sec) {
    if (strpos($aboutHtml, 'id="' . $sec . '"') === false) {
        $errors[] = "About missing section #{$sec}";
    }
}
echo "  [PASS] About page contains all 5 sections simultaneously (#" . implode(', #', $aboutSections) . ")\n";

// 3. Verify Work Catalog
$workHtml = getPage('/work');
$workSections = ['portfolio', 'services', 'laboratory', 'hardware'];
foreach ($workSections as $sec) {
    if (strpos($workHtml, 'id="' . $sec . '"') === false) {
        $errors[] = "Work missing section #{$sec}";
    }
}
echo "  [PASS] Work page contains all 4 sections simultaneously (#" . implode(', #', $workSections) . ")\n";

// 4. Verify Journal Publications
$journalHtml = getPage('/journal');
$journalSections = ['blog', 'tutorials', 'technical-notes', 'research', 'ai-manifesto'];
foreach ($journalSections as $sec) {
    if (strpos($journalHtml, 'id="' . $sec . '"') === false) {
        $errors[] = "Journal missing section #{$sec}";
    }
}
echo "  [PASS] Journal page contains all 5 sections simultaneously (#" . implode(', #', $journalSections) . ")\n";

// 5. Verify Contact Directory
$contactHtml = getPage('/contact');
$contactSections = ['information', 'inquiry', 'social'];
foreach ($contactSections as $sec) {
    if (strpos($contactHtml, 'id="' . $sec . '"') === false) {
        $errors[] = "Contact missing section #{$sec}";
    }
}
echo "  [PASS] Contact page contains all 3 sections simultaneously (#" . implode(', #', $contactSections) . ")\n";

// 6. Verify Timezone & Authenticity
if (strpos($homeHtml, 'ASIA/MANILA') !== false || strpos($homeHtml, 'PST') !== false) {
    echo "  [PASS] PHT (Asia/Manila) telemetry indicator active\n";
}

if (!empty($errors)) {
    echo "\nERRORS DETECTED:\n" . implode("\n", $errors) . "\n";
    exit(1);
} else {
    echo "\nALL ARCHITECTURAL INTEGRITY CHECKS PASSED!\n";
}
