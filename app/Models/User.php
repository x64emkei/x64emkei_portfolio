<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

class User extends BaseModel
{
    protected static string $table = 'users';

    public static function findByUsernameOrEmail(string $identifier): ?array
    {
        $stmt = static::db()->prepare(
            "SELECT * FROM `users` WHERE `username` = :u OR `email` = :e LIMIT 1"
        );
        $stmt->execute([':u' => $identifier, ':e' => $identifier]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(array $data): int
    {
        $sql = "INSERT INTO `users` (`username`, `email`, `password_hash`, `role`, `is_active`)
                VALUES (:username, :email, :password_hash, :role, :is_active)";
        $stmt = static::db()->prepare($sql);
        $stmt->execute([
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
            ':role' => $data['role'] ?? 'admin',
            ':is_active' => $data['is_active'] ?? 1,
        ]);
        return (int)static::db()->lastInsertId();
    }

    public static function incrementFailedLogins(int $userId): void
    {
        $stmt = static::db()->prepare(
            "UPDATE `users` SET `failed_logins` = `failed_logins` + 1 WHERE `id` = :id"
        );
        $stmt->execute([':id' => $userId]);

        // Lock if exceeds 5 attempts
        $stmt2 = static::db()->prepare(
            "UPDATE `users` SET `locked_until` = DATE_ADD(NOW(), INTERVAL 15 MINUTE)
             WHERE `id` = :id AND `failed_logins` >= 5"
        );
        $stmt2->execute([':id' => $userId]);
    }

    public static function recordSuccessfulLogin(int $userId, string $ip): void
    {
        $stmt = static::db()->prepare(
            "UPDATE `users` SET
                `failed_logins` = 0,
                `locked_until` = NULL,
                `last_login_at` = NOW(),
                `last_login_ip` = :ip
             WHERE `id` = :id"
        );
        $stmt->execute([':ip' => $ip, ':id' => $userId]);
    }

    public static function updatePassword(int $userId, string $newPassword): bool
    {
        $stmt = static::db()->prepare(
            "UPDATE `users` SET `password_hash` = :hash WHERE `id` = :id"
        );
        return $stmt->execute([
            ':hash' => password_hash($newPassword, PASSWORD_DEFAULT),
            ':id' => $userId,
        ]);
    }
}
