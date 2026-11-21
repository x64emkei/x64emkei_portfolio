<?php
declare(strict_types=1);

namespace App\Models;

use Database\Database;
use PDO;

abstract class BaseModel
{
    protected static string $table = '';

    protected static function db(): PDO
    {
        return Database::getConnection();
    }

    public static function all(string $orderBy = 'id ASC'): array
    {
        $sql = "SELECT * FROM `" . static::$table . "` ORDER BY {$orderBy}";
        return static::db()->query($sql)->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = static::db()->prepare("SELECT * FROM `" . static::$table . "` WHERE `id` = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function count(string $where = '', array $params = []): int
    {
        $sql = "SELECT COUNT(*) FROM `" . static::$table . "`";
        if ($where !== '') {
            $sql .= " WHERE {$where}";
        }
        $stmt = static::db()->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    public static function delete(int $id): bool
    {
        $stmt = static::db()->prepare("DELETE FROM `" . static::$table . "` WHERE `id` = :id");
        return $stmt->execute([':id' => $id]);
    }
}
