<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\User;
use App\Models\ActivityLog;
use App\Services\AuthService;
use App\Services\RateLimiter;
use App\Services\ViewRenderer;

class AuthController
{
    public function login(): void
    {
        // If no users exist, redirect to initial setup wizard
        if (User::count() === 0) {
            redirect('admin/setup');
        }

        if (AuthService::check()) {
            redirect('admin/dashboard');
        }

        $renderer = new ViewRenderer();
        echo $renderer->render('admin.login');
    }

    public function authenticate(): void
    {
        $limiter = new RateLimiter();
        $ip = client_ip();
        $rateKey = 'login_attempt_' . $ip;

        if ($limiter->tooManyAttempts($rateKey, 5, 900)) {
            $wait = $limiter->availableIn($rateKey);
            flash('error', "Too many failed authentication attempts. Access locked for " . ceil($wait / 60) . " minute(s).");
            redirect('admin/login');
        }

        $username = trim((string)($_POST['username'] ?? ''));
        $password = (string)($_POST['password'] ?? '');

        if ($username === '' || $password === '') {
            flash('error', 'Please enter your administrator username and password.');
            redirect('admin/login');
        }

        if (!AuthService::attempt($username, $password)) {
            $attempts = $limiter->hit($rateKey, 900);
            $remaining = max(0, 5 - $attempts);
            flash('error', "Invalid authentication credentials. Remaining attempts: {$remaining}.");
            redirect('admin/login');
        }

        $limiter->clear($rateKey);
        flash('success', "Welcome back, Operator {$username}. Systems online.");
        redirect('admin/dashboard');
    }

    public function setup(): void
    {
        // Only allow first admin creation if users table is empty
        if (User::count() > 0) {
            flash('error', 'Administrator setup has already been initialized.');
            redirect('admin/login');
        }

        $renderer = new ViewRenderer();
        echo $renderer->render('admin.setup');
    }

    public function createFirstAdmin(): void
    {
        if (User::count() > 0) {
            flash('error', 'Administrator setup has already been initialized.');
            redirect('admin/login');
        }

        $username = trim((string)($_POST['username'] ?? ''));
        $email = trim((string)($_POST['email'] ?? ''));
        $password = (string)($_POST['password'] ?? '');
        $passwordConfirm = (string)($_POST['password_confirmation'] ?? '');

        $errors = [];
        if (strlen($username) < 3 || !preg_match('/^[a-zA-Z0-9_-]+$/', $username)) {
            $errors[] = 'Username must be at least 3 characters and contain only alphanumeric, dash, or underscore characters.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please provide a valid email address.';
        }
        if (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters long for security.';
        }
        if ($password !== $passwordConfirm) {
            $errors[] = 'Passwords do not match.';
        }

        if (!empty($errors)) {
            flash('error', implode(' ', $errors));
            set_old_input(['username' => $username, 'email' => $email]);
            redirect('admin/setup');
        }

        $userId = User::create([
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'role' => 'admin',
            'is_active' => 1
        ]);

        ActivityLog::record($userId, 'INITIAL_SETUP', "Primary administrator {$username} created.");

        // Automatically log in
        AuthService::attempt($username, $password);

        flash('success', 'First administrator created successfully! Welcome to the X64EMKEI Control Center.');
        redirect('admin/dashboard');
    }

    public function logout(): void
    {
        AuthService::logout();
        flash('info', 'Administrator telemetry session safely terminated.');
        redirect('admin/login');
    }
}
