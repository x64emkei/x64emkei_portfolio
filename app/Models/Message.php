<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

class Message extends BaseModel
{
    protected static string $table = 'messages';

    public static function getInbox(int $limit = 50, int $offset = 0): array
    {
        $stmt = static::db()->prepare(
            "SELECT * FROM `messages` WHERE `is_archived` = 0 ORDER BY `created_at` DESC LIMIT :limit OFFSET :offset"
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function countUnread(): int
    {
        return self::count('`is_read` = 0 AND `is_archived` = 0');
    }

    public static function create(array $data): int
    {
        $sql = "INSERT INTO `messages` (`sender_name`, `sender_email`, `subject`, `message_body`, `sender_ip`, `user_agent`)
                VALUES (:name, :email, :subject, :body, :ip, :ua)";
        $stmt = static::db()->prepare($sql);
        $stmt->execute([
            ':name' => $data['sender_name'],
            ':email' => $data['sender_email'],
            ':subject' => $data['subject'],
            ':body' => $data['message_body'],
            ':ip' => $data['sender_ip'] ?? client_ip(),
            ':ua' => substr($data['user_agent'] ?? ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255),
        ]);
        return (int)static::db()->lastInsertId();
    }

    public static function markRead(int $id, bool $read = true): bool
    {
        $stmt = static::db()->prepare("UPDATE `messages` SET `is_read` = :r WHERE `id` = :id");
        return $stmt->execute([':r' => $read ? 1 : 0, ':id' => $id]);
    }

    public static function archive(int $id, bool $archived = true): bool
    {
        $stmt = static::db()->prepare("UPDATE `messages` SET `is_archived` = :a WHERE `id` = :id");
        return $stmt->execute([':a' => $archived ? 1 : 0, ':id' => $id]);
    }
}
