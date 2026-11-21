<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

class ActivityLog extends BaseModel
{
    protected static string $table = 'activity_logs';

    public static function record(?int $userId, string $action, string $description): void
    {
        try {
            $sql = "INSERT INTO `activity_logs` (`user_id`, `action`, `description`, `ip_address`)
                    VALUES (:uid, :action, :description, :ip)";
            $stmt = static::db()->prepare($sql);
            $stmt->execute([
                ':uid' => $userId,
                ':action' => $action,
                ':description' => $description,
                ':ip' => client_ip(),
            ]);
        } catch (\Throwable $e) {
            // Fail silently so activity logging doesn't block core operations
        }
    }

    public static function getRecent(int $limit = 10): array
    {
        $stmt = static::db()->prepare(
            "SELECT a.*, u.username FROM `activity_logs` a
             LEFT JOIN `users` u ON a.user_id = u.id
             ORDER BY a.`created_at` DESC LIMIT :limit"
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
