<?php
declare(strict_types=1);

require_once __DIR__ . '/../bootstrap/autoload.php';
require_once __DIR__ . '/../bootstrap/app.php';

echo "\n--- [HTTP ROUTING & DISPATCH INTEGRATION TESTS] ---\n";

function testEndpoint(string $uri, string $method = 'GET'): array {
    $_SERVER['REQUEST_METHOD'] = $method;
    $_SERVER['REQUEST_URI'] = $uri;
    $_SERVER['SCRIPT_NAME'] = '/index.php';
    $_SERVER['HTTP_HOST'] = 'x64emkei.dpdns.org';

    ob_start();
    try {
        /** @var Router $router */
        $router = require __DIR__ . '/../routes/web.php';
        $router->dispatch();
        $output = ob_get_clean();
        return ['status' => http_response_code(), 'body' => $output];
    } catch (\Throwable $e) {
        ob_end_clean();
        return ['status' => 500, 'error' => $e->getMessage()];
    }
}

// 1. Test Home page
$res = testEndpoint('/');
echo "Route [/]: Status " . $res['status'] . ", HTML Length: " . strlen($res['body'] ?? '') . "\n";
assert(str_contains($res['body'], 'Michael Benedict Ordenes'), "Home page contains profile full_name");
assert(str_contains($res['body'], 'Valkyrie POS Pro'), "Home page contains seeded project title");

// 2. Test API projects
$resApi = testEndpoint('/api/projects');
echo "Route [/api/projects]: Status " . $resApi['status'] . "\n";
$json = json_decode($resApi['body'], true);
assert($json['status'] === 'success', "API response status is success");
assert($json['count'] >= 16, "API returned all seeded projects");
echo "API project count: " . $json['count'] . "\n";

echo "\n[SUCCESS] HTTP Routing & SSR views tested and fully operational!\n\n";
