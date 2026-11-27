<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Models\ActivityLog;
use PDO;

class AuthService
{
    private const SESSION_USER_KEY = 'admin_user_id';
    private const SESSION_USER_DATA = 'admin_user_data';

    public static function attempt(string $usernameOrEmail, string $password): bool
    {
        $user = User::findByUsernameOrEmail($usernameOrEmail);
        if (!$user) {
            return false;
        }

        if (!$user['is_active']) {
            return false;
        }

        // Check account temporary lockout
        if (!empty($user['locked_until']) && strtotime($user['locked_until']) > time()) {
            return false;
        }

        if (!password_verify($password, $user['password_hash'])) {
            User::incrementFailedLogins((int)$user['id']);
            return false;
        }

        // Reset failed logins & update last login
        User::recordSuccessfulLogin((int)$user['id'], client_ip());

        // Secure session fixation defense: regenerate session ID
        session_regenerate_id(true);

        $_SESSION[self::SESSION_USER_KEY] = (int)$user['id'];
        $_SESSION[self::SESSION_USER_DATA] = [
            'id' => (int)$user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];

        ActivityLog::record(
            (int)$user['id'],
            'AUTH_LOGIN',
            "Administrator {$user['username']} logged in successfully."
        );

        return true;
    }

    public static function check(): bool
    {
        $userId = $_SESSION[self::SESSION_USER_KEY] ?? null;
        if (!is_int($userId) && !ctype_digit((string) $userId)) {
            return false;
        }

        try {
            $user = User::find((int) $userId);
        } catch (\Throwable) {
            // A failed revalidation must never grant access based solely on
            // data that was previously stored in the session.
            self::forgetSession();
            return false;
        }

        if ($user === null || empty($user['is_active'])) {
            self::forgetSession();
            return false;
        }

        // Refresh the authorization snapshot on every protected request so
        // a role change takes effect immediately rather than at next login.
        $_SESSION[self::SESSION_USER_KEY] = (int) $user['id'];
        $_SESSION[self::SESSION_USER_DATA] = [
            'id' => (int) $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];

        return true;
    }

    public static function user(): ?array
    {
        return $_SESSION[self::SESSION_USER_DATA] ?? null;
    }

    public static function id(): ?int
    {
        return $_SESSION[self::SESSION_USER_KEY] ?? null;
    }

    public static function logout(): void
    {
        $userId = self::id();
        if ($userId) {
            ActivityLog::record($userId, 'AUTH_LOGOUT', 'Administrator logged out.');
        }

        self::forgetSession();
        session_regenerate_id(true);
    }

    private static function forgetSession(): void
    {
        unset($_SESSION[self::SESSION_USER_KEY], $_SESSION[self::SESSION_USER_DATA]);
    }
}
