<?php
declare(strict_types=1);

namespace App\Services;

use App\Middleware\SecurityHeadersMiddleware;

class Router
{
    private array $routes = [];

    public function get(string $path, array $handler, array $middleware = []): void
    {
        $this->addRoute('GET', $path, $handler, $middleware);
    }

    public function post(string $path, array $handler, array $middleware = []): void
    {
        $this->addRoute('POST', $path, $handler, $middleware);
    }

    private function addRoute(string $method, string $path, array $handler, array $middleware): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => '/' . trim($path, '/'),
            'handler' => $handler,
            'middleware' => $middleware,
        ];
    }

    public function dispatch(): void
    {
        SecurityHeadersMiddleware::handle();

        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

        // Resolve requested path (supporting both clean URI and query string fallback)
        $uri = '';
        if (isset($_GET['route'])) {
            $uri = '/' . trim((string)$_GET['route'], '/');
        } else {
            $requestUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
            $baseDir = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
            if ($baseDir !== '' && str_starts_with($requestUri, $baseDir)) {
                $uri = substr($requestUri, strlen($baseDir));
            } else {
                $uri = $requestUri;
            }
        }

        $uri = '/' . trim($uri, '/');
        if ($uri === '//' || $uri === '') {
            $uri = '/';
        }

        $pathMatched = false;
        foreach ($this->routes as $route) {
            // Convert route pattern with {param} to regex
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                $pathMatched = true;
                if ($route['method'] !== $method) {
                    continue;
                }
                // Execute Middlewares
                foreach ($route['middleware'] as $mw) {
                    $mw::handle();
                }

                // Filter named parameters and cast integers for strict-type compatibility
                $rawParams = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $params = [];
                foreach ($rawParams as $name => $value) {
                    if (is_numeric($value) && (string)(int)$value === (string)$value) {
                        $params[] = (int)$value;
                    } else {
                        $params[] = $value;
                    }
                }

                [$controllerClass, $action] = $route['handler'];
                $controller = new $controllerClass();
                $controller->$action(...$params);
                return;
            }
        }

        if ($pathMatched) {
            http_response_code(405);
            header('Allow: ' . implode(', ', array_unique(array_column(array_filter($this->routes, static function (array $route) use ($uri): bool {
                $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $route['path']);
                return preg_match('#^' . $pattern . '$#', $uri) === 1;
            }), 'method'))));
            echo 'Method Not Allowed';
            return;
        }

        // Route Not Found (404)
        http_response_code(404);
        echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>404 // ROUTE NOT FOUND</title>';
        echo '<style>body{background:#0a0c10;color:#ff5252;font-family:"JetBrains Mono",monospace;display:flex;align-items:center;justify-content:center;height:100vh;margin:0;}';
        echo '.hud{border:1px solid #ff5252;padding:40px;background:rgba(255,82,82,0.05);max-width:500px;text-align:center;}a{color:#ff5252;}</style></head>';
        echo '<body><div class="hud"><h2>[404 // NODE NOT FOUND]</h2><p>The requested route does not exist in the active telemetry matrix.</p><a href="' . e(url('/')) . '">// RETURN TO HOME</a></div></body></html>';
    }
}
