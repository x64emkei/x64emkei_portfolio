<?php
declare(strict_types=1);

/**
 * Database Configuration
 * Loads environment variables with safe defaults for local development.
 */

return [
    'driver' => env('DB_CONNECTION', 'mysql'),
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => (int)env('DB_PORT', 3306),
    'database' => env('DB_DATABASE', env('DB_NAME', 'x64emkei_portfolio')),
    'username' => env('DB_USERNAME', env('DB_USER', 'root')),
    'password' => env('DB_PASSWORD', env('DB_PASS', '')),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ],
    // SQLite configuration for fallback or lightweight isolated tests
    'sqlite_path' => dirname(__DIR__) . '/storage/database.sqlite',
];
