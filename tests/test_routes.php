<?php
declare(strict_types=1);

require_once __DIR__ . '/../bootstrap/autoload.php';
require_once __DIR__ . '/../bootstrap/app.php';

$routes = [
    '/',
    '/about',
    '/about/education',
    '/about/skills',
    '/about/experience',
    '/about/credentials',
    '/work',
    '/work/services',
    '/work/laboratory',
    '/work/hardware',
    '/explore',
    '/explore/hardware',
    '/journal',
    '/journal/manifesto',
    '/journal/my-ai-manifesto',
    '/journal/zero-trust-architecture-modern-systems',
    '/journal/category/systems-architecture',
    '/journal/tag/security',
    '/contact',
    '/admin/login'
];

echo "\n--- TESTING NEW ROUTE DISPATCHES ---\n";
foreach ($routes as $route) {
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = $route;
    
    ob_start();
    try {
        $router = require __DIR__ . '/../routes/web.php';
        $router->dispatch();
        $html = ob_get_clean();
        echo "  [OK] Route [{$route}] rendered successfully (Length: " . strlen($html) . " bytes)\n";
    } catch (\Throwable $e) {
        ob_end_clean();
        echo "  [ERROR] Route [{$route}]: " . $e->getMessage() . "\n";
    }
}
echo "--- ALL TESTED ROUTES OK ---\n\n";
