<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Services\AuthService;
use App\Services\HttpException;

class AuthMiddleware
{
    public static function handle(): void
    {
        if (!AuthService::check()) {
            flash('error', 'Authentication required to access administrator telemetry.');
            redirect('admin/login');
        }

        $user = AuthService::user();
        $role = $user['role'] ?? '';
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $isArticleRoute = preg_match('#/admin/articles(?:/|$)#', $path) === 1;
        $isLogoutRoute = preg_match('#/admin/logout/?$#', $path) === 1;

        if (($isArticleRoute || $isLogoutRoute) && in_array($role, ['superadmin', 'admin', 'editor', 'author'], true)) {
            return;
        }

        if (!in_array($role, ['superadmin', 'admin'], true)) {
            throw new HttpException(403, 'This operator role is not authorized for the requested CMS module.');
        }
    }
}
