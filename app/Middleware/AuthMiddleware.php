<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Services\AuthService;

class AuthMiddleware
{
    public static function handle(): void
    {
        if (!AuthService::check()) {
            flash('error', 'Authentication required to access administrator telemetry.');
            redirect('admin/login');
        }
    }
}
