<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

class Service extends BaseModel
{
    protected static string $table = 'services';

    public static function getPublished(): array
    {
        $stmt = static::db()->query(
            "SELECT * FROM `services` WHERE `is_published` = 1 ORDER BY `display_order` ASC, `id` ASC"
        );
        return $stmt->fetchAll();
    }

    public static function create(array $data): int
    {
        $sql = "INSERT INTO `services` (`title`, `category`, `description`, `capabilities_json`, `icon_name`, `display_order`, `is_published`)
                VALUES (:title, :category, :description, :capabilities_json, :icon_name, :display_order, :is_published)";
        $stmt = static::db()->prepare($sql);
        $stmt->execute([
            ':title' => $data['title'],
            ':category' => $data['category'],
            ':description' => $data['description'],
            ':capabilities_json' => is_array($data['capabilities_json'] ?? null) ? json_encode($data['capabilities_json']) : ($data['capabilities_json'] ?? '[]'),
            ':icon_name' => $data['icon_name'] ?? '',
            ':display_order' => (int)($data['display_order'] ?? 0),
            ':is_published' => (int)($data['is_published'] ?? 1),
        ]);
        return (int)static::db()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $sql = "UPDATE `services` SET
            `title` = :title,
            `category` = :category,
            `description` = :description,
            `capabilities_json` = :capabilities_json,
            `icon_name` = :icon_name,
            `display_order` = :display_order,
            `is_published` = :is_published
            WHERE `id` = :id";
        $stmt = static::db()->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':title' => $data['title'],
            ':category' => $data['category'],
            ':description' => $data['description'],
            ':capabilities_json' => is_array($data['capabilities_json'] ?? null) ? json_encode($data['capabilities_json']) : ($data['capabilities_json'] ?? '[]'),
            ':icon_name' => $data['icon_name'] ?? '',
            ':display_order' => (int)($data['display_order'] ?? 0),
            ':is_published' => (int)($data['is_published'] ?? 1),
        ]);
    }
}
