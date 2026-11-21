<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Services\CsrfService;

class CsrfMiddleware
{
    public static function handle(): void
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        if (in_array($method, ['POST', 'PUT', 'DELETE', 'PATCH'], true)) {
            $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
            if (!CsrfService::validate($token)) {
                http_response_code(419);
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    json_response(['error' => 'Security token invalid or expired. Please reload.'], 419);
                }
                flash('error', 'Security token expired. Please try submitting again.');
                redirect($_SERVER['HTTP_REFERER'] ?? '/');
            }
        }
    }
}
