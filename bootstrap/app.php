<?php
declare(strict_types=1);

/**
 * Application Bootstrap & Environment Initialization
 */

// 1. Simple, robust .env parser
$envPaths = [
    dirname(__DIR__) . '/.env',
    dirname(__DIR__, 2) . '/private/config/.env',
    dirname(__DIR__, 2) . '/private/.env',
];

foreach ($envPaths as $envFile) {
    if (file_exists($envFile) && is_readable($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }
            if (str_contains($line, '=')) {
                [$key, $val] = explode('=', $line, 2);
                $key = trim($key);
                $val = trim($val);
                // Strip enclosing quotes if present
                if ((str_starts_with($val, '"') && str_ends_with($val, '"')) ||
                    (str_starts_with($val, "'") && str_ends_with($val, "'"))) {
                    $val = substr($val, 1, -1);
                }
                @putenv("{$key}={$val}");
                $_ENV[$key] = $val;
                $_SERVER[$key] = $val;
            }
        }
        break;
    }
}

// 1.1 Robust env() helper compatible with environments where putenv() is restricted
if (!function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        if (isset($_ENV[$key]) && $_ENV[$key] !== '') {
            return $_ENV[$key];
        }
        if (isset($_SERVER[$key]) && $_SERVER[$key] !== '') {
            return $_SERVER[$key];
        }
        $val = @getenv($key);
        if ($val !== false && $val !== '') {
            return $val;
        }
        return $default;
    }
}

// 2. Load Configuration
$appConfig = require dirname(__DIR__) . '/config/app.php';

// 3. Timezone
date_default_timezone_set($appConfig['timezone'] ?? 'Asia/Manila');

// 4. Secure Session Configuration
if (session_status() === PHP_SESSION_NONE) {
    $isHttps = (
        (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
        (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ||
        (!empty($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443)
    );

    // Ensure session save path exists
    $sessionPath = dirname(__DIR__) . '/storage/cache';
    if (!is_dir($sessionPath)) {
        @mkdir($sessionPath, 0755, true);
    }
    if (is_writable($sessionPath)) {
        session_save_path($sessionPath);
    }

    session_set_cookie_params([
        'lifetime' => $appConfig['session_lifetime'] ?? 604800,
        'path' => '/',
        'domain' => '',
        'secure' => $isHttps,
        'httponly' => true,
        'samesite' => 'Lax', // Compatible with external redirects while protecting CSRF
    ]);
    session_name($appConfig['session_name'] ?? 'X64EMKEI_SESSID');
    session_start();
}

// 5. Global Exception & Error Handler
set_exception_handler(function (Throwable $e) use ($appConfig) {
    $logDir = dirname(__DIR__) . '/storage/logs';
    if (!is_dir($logDir)) {
        @mkdir($logDir, 0755, true);
    }
    $logMessage = sprintf(
        "[%s] %s in %s:%d\nStack trace:\n%s\n\n",
        date('Y-m-d H:i:s'),
        $e->getMessage(),
        $e->getFile(),
        $e->getLine(),
        $e->getTraceAsString()
    );
    @file_put_contents($logDir . '/error.log', $logMessage, FILE_APPEND);

    http_response_code(500);

    if (!empty($appConfig['debug'])) {
        echo "<pre style='background:#0f172a;color:#f87171;padding:20px;font-family:monospace;'>";
        echo "<b>Fatal Application Exception:</b> " . htmlspecialchars($e->getMessage()) . "\n";
        echo "File: " . htmlspecialchars($e->getFile()) . ":" . $e->getLine() . "\n\n";
        echo htmlspecialchars($e->getTraceAsString());
        echo "</pre>";
    } else {
        // High-Tech Cyberpunk HUD 500 error display
        echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>SYS.FAULT // 500</title>';
        echo '<style>body{background:#0a0c10;color:#00e5ff;font-family:"JetBrains Mono",monospace;display:flex;align-items:center;justify-content:center;height:100vh;margin:0;}';
        echo '.hud-box{border:1px solid #ff3366;padding:40px;background:rgba(255,51,102,0.05);max-width:550px;box-shadow:0 0 30px rgba(255,51,102,0.2);text-align:center;}';
        echo 'h1{color:#ff3366;margin:0 0 10px 0;font-size:24px;letter-spacing:2px;}p{color:#94a3b8;font-size:14px;}a{color:#00e5ff;text-decoration:none;display:inline-block;margin-top:20px;border:1px solid #00e5ff;padding:8px 16px;}</style></head>';
        echo '<body><div class="hud-box"><h1>[SYS.FAULT // 500]</h1><p>A critical subsystem error occurred. Diagnostics have been recorded to internal telemetry.</p><a href="/">// RETURN TO HOMEVIEW</a></div></body></html>';
    }
    exit;
});
