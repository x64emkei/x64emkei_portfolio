<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\User;
use App\Models\ActivityLog;
use App\Services\AuthService;
use App\Services\ViewRenderer;
use App\Services\HttpException;

class UsersController
{
    public function index(): void
    {
        $currentUser = AuthService::user();
        if ($currentUser['role'] !== 'superadmin' && $currentUser['role'] !== 'admin') {
            throw new HttpException(403, "Access restricted to Administrators.");
        }

        $users = User::all();
        $renderer = new ViewRenderer();
        echo $renderer->render('admin.users.index', [
            'users' => $users,
            'currentUser' => $currentUser,
            'pageTitle' => 'Access Control & User Management'
        ], 'admin.layout');
    }

    public function store(): void
    {
        $currentUser = AuthService::user();
        if ($currentUser['role'] !== 'superadmin' && $currentUser['role'] !== 'admin') {
            throw new HttpException(403, "Access denied.");
        }

        $username = trim((string)($_POST['username'] ?? ''));
        $email = trim((string)($_POST['email'] ?? ''));
        $password = (string)($_POST['password'] ?? '');
        $role = (string)($_POST['role'] ?? 'author');

        if (!in_array($role, ['superadmin', 'admin', 'editor', 'author'])) {
            $role = 'author';
        }

        // Only superadmin can create superadmin
        if ($role === 'superadmin' && $currentUser['role'] !== 'superadmin') {
            $role = 'admin';
        }

        if ($username === '' || $email === '' || strlen($password) < 8) {
            flash('error', 'Username, valid email, and minimum 8-character password are required.');
            redirect('admin/users');
        }

        try {
            User::create([
                'username' => $username,
                'email' => $email,
                'password_hash' => password_hash($password, PASSWORD_BCRYPT),
                'role' => $role,
                'is_active' => 1
            ]);
            ActivityLog::record('user_create', "Registered operator account: {$username} ({$role})", AuthService::id());
            flash('success', "Operator account '{$username}' successfully created.");
        } catch (\Throwable $e) {
            flash('error', "Failed to create user: " . $e->getMessage());
        }

        redirect('admin/users');
    }

    public function updateRole(string $id): void
    {
        $currentUser = AuthService::user();
        if ($currentUser['role'] !== 'superadmin') {
            throw new HttpException(403, "Only Super Administrator can modify operator roles.");
        }

        $targetUser = User::find((int)$id);
        if (!$targetUser) {
            throw new HttpException(404, "User not found.");
        }

        $newRole = (string)($_POST['role'] ?? '');
        if (in_array($newRole, ['superadmin', 'admin', 'editor', 'author'])) {
            User::update((int)$id, ['role' => $newRole]);
            ActivityLog::record('user_role_change', "Modified role of {$targetUser['username']} to {$newRole}", AuthService::id());
            flash('success', "Updated permissions for {$targetUser['username']}.");
        }

        redirect('admin/users');
    }

    public function toggleStatus(string $id): void
    {
        $currentUser = AuthService::user();
        if ($currentUser['role'] !== 'superadmin' && $currentUser['role'] !== 'admin') {
            throw new HttpException(403, "Access denied.");
        }

        $targetUser = User::find((int)$id);
        if (!$targetUser) {
            throw new HttpException(404, "User not found.");
        }

        if ((int)$targetUser['id'] === (int)$currentUser['id']) {
            flash('error', "Cannot deactivate your own active session.");
            redirect('admin/users');
        }

        $newStatus = empty($targetUser['is_active']) ? 1 : 0;
        User::update((int)$id, ['is_active' => $newStatus]);
        ActivityLog::record('user_status_toggle', "Toggled status of {$targetUser['username']} to " . ($newStatus ? 'active' : 'suspended'), AuthService::id());
        flash('success', "Account status updated for {$targetUser['username']}.");
        redirect('admin/users');
    }
}
