<?php
declare(strict_types=1);

require_once __DIR__ . '/../bootstrap/autoload.php';
require_once __DIR__ . '/../bootstrap/app.php';

$publicRoutes = [
    // 1. HOME
    '/',
    
    // 2. ABOUT & CHILD ROUTES
    '/about',
    '/about/',
    '/about/biography',
    '/about/biography/',
    '/about/education',
    '/about/education/',
    '/about/skills',
    '/about/skills/',
    '/about/experience',
    '/about/experience/',
    '/about/certifications',
    '/about/certifications/',

    // 3. WORK & CHILD ROUTES
    '/work',
    '/work/',
    '/work/projects',
    '/work/projects/',
    '/work/services',
    '/work/services/',
    '/work/laboratory',
    '/work/laboratory/',
    '/work/hardware',
    '/work/hardware/',

    // 4. JOURNAL & CHILD ROUTES
    '/journal',
    '/journal/',
    '/journal/blog',
    '/journal/blog/',
    '/journal/tutorials',
    '/journal/tutorials/',
    '/journal/technical-notes',
    '/journal/technical-notes/',
    '/journal/research',
    '/journal/research/',
    '/journal/ai-manifesto',
    '/journal/ai-manifesto/',
    '/journal/manifesto',

    // 5. CONTACT & CHILD ROUTES
    '/contact',
    '/contact/',
    '/contact/information',
    '/contact/information/',
    '/contact/inquiry',
    '/contact/inquiry/',
    '/contact/social',
    '/contact/social/',

    // 6. LEGAL & FOOTER COMPLIANCE
    '/privacy',
    '/terms',
    '/accessibility',
    '/sitemap'
];

echo "\n======================================================\n";
echo "   x64emkei // STRICT NAVIGATION & ROUTE VERIFICATION \n";
echo "======================================================\n\n";

$passCount = 0;
$failCount = 0;

foreach ($publicRoutes as $route) {
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = $route;
    
    ob_start();
    try {
        $router = require __DIR__ . '/../routes/web.php';
        $router->dispatch();
        $html = ob_get_clean();
        
        if (strlen($html) > 0) {
            echo "  [PASS] Public Route [{$route}] (bytes: " . strlen($html) . ")\n";
            $passCount++;
        } else {
            echo "  [FAIL] Public Route [{$route}]: Empty response body\n";
            $failCount++;
        }
    } catch (\Throwable $e) {
        ob_end_clean();
        echo "  [FAIL] Public Route [{$route}]: " . $e->getMessage() . "\n";
        $failCount++;
    }
}

// Admin Routes
$adminRoutes = [
    '/admin/login',
    '/admin',
    '/admin/dashboard',
    '/admin/content',
    '/admin/media',
    '/admin/settings',
    '/admin/settings/navigation',
    '/admin/system'
];

echo "\n--- TESTING ADMIN PROTECTED ROUTES ---\n";
foreach ($adminRoutes as $route) {
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = $route;
    unset($_SESSION['user_id']);
    
    try {
        $router = require __DIR__ . '/../routes/web.php';
        $matched = false;
        
        // Use reflection to verify route registration and auth middleware binding
        $ref = new \ReflectionClass($router);
        $prop = $ref->getProperty('routes');
        $prop->setAccessible(true);
        $registered = $prop->getValue($router);
        
        $clean = '/' . trim($route, '/');
        $foundRoute = null;
        foreach ($registered as $r) {
            if ($r['method'] === 'GET' && $r['path'] === $clean) {
                $foundRoute = $r;
                break;
            }
        }
        
        if ($foundRoute !== null) {
            $handler = $foundRoute['handler'];
            $middlewares = $foundRoute['middleware'] ?? [];
            $isProtected = in_array(\App\Middleware\AuthMiddleware::class, $middlewares);
            echo "  [PASS] Admin Route [{$route}] mapped to " . (is_array($handler) ? $handler[0] . '@' . $handler[1] : 'callable') . " [Protected: " . ($isProtected ? 'YES' : 'NO') . "]\n";
            $passCount++;
        } else {
            echo "  [FAIL] Admin Route [{$route}] not registered in web.php\n";
            $failCount++;
        }
    } catch (\Throwable $e) {
        echo "  [FAIL] Admin Route [{$route}]: " . $e->getMessage() . "\n";
        $failCount++;
    }
}

echo "\n======================================================\n";
echo "  SUMMARY: {$passCount} Passed, {$failCount} Failed\n";
echo "======================================================\n\n";

if ($failCount > 0) {
    exit(1);
}
