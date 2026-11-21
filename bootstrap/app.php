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

// 4.1 Request Correlation Tracking
if (!defined('REQUEST_ID')) {
    define('REQUEST_ID', 'req_' . substr(bin2hex(random_bytes(6)), 0, 8));
}

// 4.2 Resilient Application Logging Facility
if (!function_exists('app_log')) {
    function app_log(string $level, string $message, array $context = []): void
    {
        $logDir = dirname(__DIR__) . '/storage/logs';
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0755, true);
        }

        // Scrub sensitive keys from log context
        $sensitiveKeys = ['password', 'db_pass', 'db_password', 'token', 'csrf_token', 'secret', 'auth', 'cookie'];
        array_walk_recursive($context, function (&$val, $key) use ($sensitiveKeys) {
            if (is_string($key)) {
                foreach ($sensitiveKeys as $bad) {
                    if (stripos($key, $bad) !== false) {
                        $val = '[REDACTED]';
                        break;
                    }
                }
            }
        });

        $entry = sprintf(
            "[%s] [%s] [%s] %s %s\n",
            date('Y-m-d H:i:s'),
            strtoupper($level),
            REQUEST_ID,
            $message,
            !empty($context) ? json_encode($context, JSON_UNESCAPED_SLASHES) : ''
        );

        $logFile = $logDir . '/app.log';
        if (!@file_put_contents($logFile, $entry, FILE_APPEND)) {
            // Fallback to PHP error_log if storage is read-only
            @error_log("[x64emkei] {$entry}");
        }
    }
}

// 5. Global Exception & Error Handler
set_error_handler(function (int $severity, string $message, string $file, int $line): bool {
    if (!(error_reporting() & $severity)) {
        return false;
    }
    app_log('WARNING', "PHP Warning/Notice: {$message}", ['file' => $file, 'line' => $line]);
    return true;
});

register_shutdown_function(function () use ($appConfig) {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
        app_log('FATAL', "PHP Fatal Shutdown: {$error['message']}", ['file' => $error['file'], 'line' => $error['line']]);
        if (!headers_sent()) {
            http_response_code(500);
        }
        echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>SYS.FAULT // 500</title>';
        echo '<style>body{background:#0a0c10;color:#00e5ff;font-family:"JetBrains Mono",monospace;display:flex;align-items:center;justify-content:center;height:100vh;margin:0;}';
        echo '.hud-box{border:1px solid #ff3366;padding:40px;background:rgba(255,51,102,0.05);max-width:550px;box-shadow:0 0 30px rgba(255,51,102,0.2);text-align:center;}';
        echo 'h1{color:#ff3366;margin:0 0 10px 0;font-size:22px;letter-spacing:2px;}p{color:#94a3b8;font-size:13px;line-height:1.6;}';
        echo '.incident{color:#ffb800;font-size:12px;margin-top:15px;display:block;}a{color:#00e5ff;text-decoration:none;display:inline-block;margin-top:20px;border:1px solid #00e5ff;padding:8px 16px;}</style></head>';
        echo '<body><div class="hud-box"><h1>[SYS.FAULT // 500]</h1><p>A fatal system error occurred. Diagnostics recorded to telemetry.</p><span class="incident">INCIDENT REF: ' . htmlspecialchars(REQUEST_ID) . '</span><a href="/">// RECONNECT HOMEVIEW</a></div></body></html>';
    }
});

set_exception_handler(function (Throwable $e) use ($appConfig) {
    $statusCode = 500;
    if ($e instanceof \App\Services\HttpException) {
        $statusCode = $e->getStatusCode();
    } elseif ($e instanceof \PDOException || str_contains($e->getMessage(), 'Database connection failed')) {
        $statusCode = 503; // Service Temporarily Unavailable
    }

    app_log('ERROR', "Uncaught Exception ({$statusCode}): {$e->getMessage()}", [
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'code' => $e->getCode(),
    ]);

    if (!headers_sent()) {
        http_response_code($statusCode);
    }

    if (!empty($appConfig['debug'])) {
        echo "<pre style='background:#0f172a;color:#f87171;padding:20px;font-family:monospace;'>";
        echo "<b>Fatal Application Exception ({$statusCode}):</b> " . htmlspecialchars($e->getMessage()) . "\n";
        echo "File: " . htmlspecialchars($e->getFile()) . ":" . $e->getLine() . "\n";
        echo "Incident: " . REQUEST_ID . "\n\n";
        echo htmlspecialchars($e->getTraceAsString());
        echo "</pre>";
    } else {
        $faultTitles = [
            400 => 'BAD REQUEST // 400',
            401 => 'UNAUTHORIZED // 401',
            403 => 'ACCESS DENIED // 403',
            404 => 'NODE NOT FOUND // 404',
            405 => 'METHOD REJECTED // 405',
            419 => 'TOKEN EXPIRED // 419',
            429 => 'RATE LIMITED // 429',
            500 => 'SYS.FAULT // 500',
            503 => 'TELEMETRY OFFLINE // 503'
        ];
        $faultTitle = $faultTitles[$statusCode] ?? "SYS.FAULT // {$statusCode}";
        $faultDesc = ($statusCode === 503)
            ? 'The database or required service is currently undergoing synchronization. Standby while telemetry reconnects.'
            : 'A critical subsystem error occurred. Diagnostics have been recorded to internal telemetry.';

        echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>' . htmlspecialchars($faultTitle) . '</title>';
        echo '<style>body{background:#0a0c10;color:#00e5ff;font-family:"JetBrains Mono",monospace;display:flex;align-items:center;justify-content:center;height:100vh;margin:0;}';
        echo '.hud-box{border:1px solid #ff3366;padding:40px;background:rgba(255,51,102,0.05);max-width:550px;box-shadow:0 0 30px rgba(255,51,102,0.2);text-align:center;}';
        echo 'h1{color:#ff3366;margin:0 0 10px 0;font-size:22px;letter-spacing:2px;}p{color:#94a3b8;font-size:13px;line-height:1.6;}';
        echo '.incident{color:#ffb800;font-size:12px;margin-top:15px;display:block;}a{color:#00e5ff;text-decoration:none;display:inline-block;margin-top:20px;border:1px solid #00e5ff;padding:8px 16px;}</style></head>';
        echo '<body><div class="hud-box"><h1>[' . htmlspecialchars($faultTitle) . ']</h1><p>' . htmlspecialchars($faultDesc) . '</p><span class="incident">INCIDENT REF: ' . htmlspecialchars(REQUEST_ID) . '</span><a href="/">// RETURN TO HOMEVIEW</a></div></body></html>';
    }
    exit;
});
