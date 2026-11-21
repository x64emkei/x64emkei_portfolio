<?php
declare(strict_types=1);

/**
 * Application Core Configuration
 */

return [
    'name' => getenv('APP_NAME') ?: 'x64emkei.dev',
    'env' => getenv('APP_ENV') ?: 'production', // 'development' or 'production'
    'debug' => filter_var(getenv('APP_DEBUG') ?: false, FILTER_VALIDATE_BOOLEAN),
    'url' => getenv('APP_URL') ?: 'https://x64emkei.dpdns.org',
    'timezone' => 'Asia/Manila',
    'session_name' => 'X64EMKEI_SESSID',
    'session_lifetime' => 86400 * 7, // 7 days
    'storage_path' => dirname(__DIR__) . '/storage',
    'uploads_path' => dirname(__DIR__) . '/storage/uploads',
    'max_upload_size' => 8 * 1024 * 1024, // 8MB (within InfinityFree 10MB limits)
    'allowed_image_mimes' => [
        'image/jpeg',
        'image/png',
        'image/webp',
        'image/gif',
        'image/svg+xml'
    ],
    'rate_limits' => [
        'login_max_attempts' => 5,
        'login_lockout_seconds' => 900, // 15 minutes
        'contact_max_attempts' => 4,
        'contact_decay_seconds' => 3600, // 1 hour
    ],
];
