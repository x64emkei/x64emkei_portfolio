<?php
declare(strict_types=1);

/**
 * Portable PSR-4 Autoloader
 * Works on free shared hosting without Composer requirement,
 * while seamlessly delegating to Composer when vendor/autoload.php exists.
 */

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

spl_autoload_register(function (string $class): void {
    $prefixes = [
        'App\\' => dirname(__DIR__) . '/app/',
        'Database\\' => dirname(__DIR__) . '/database/',
    ];

    foreach ($prefixes as $prefix => $baseDir) {
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            continue;
        }

        $relativeClass = substr($class, $len);
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Load helper functions
require_once dirname(__DIR__) . '/app/Helpers/functions.php';
