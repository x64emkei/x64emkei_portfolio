<?php
declare(strict_types=1);

namespace App\Middleware;

class SecurityHeadersMiddleware
{
    public static function handle(): void
    {
        if (headers_sent()) {
            return;
        }

        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=()');
        header('X-XSS-Protection: 0');

        // Optional CSP allowing self, inline styles/fonts for HUD aesthetic
        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline' https://fonts.googleapis.com; " .
               "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; " .
               "font-src 'self' https://fonts.gstatic.com data:; " .
               "img-src 'self' data: https: blob:; " .
               "connect-src 'self'; " .
               "frame-ancestors 'self';";
        header("Content-Security-Policy: {$csp}");
    }
}
