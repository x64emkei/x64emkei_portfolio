<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

class Experience extends BaseModel
{
    protected static string $table = 'experiences';

    public static function getPublished(): array
    {
        $stmt = static::db()->query(
            "SELECT * FROM `experiences` WHERE `is_published` = 1 ORDER BY `display_order` ASC, `id` DESC"
        );
        return $stmt->fetchAll();
    }

    public static function create(array $data): int
    {
        $sql = "INSERT INTO `experiences`
            (`title`, `organization`, `location`, `type`, `period_start`, `period_end`, `is_current`, `description`, `responsibilities_json`, `display_order`, `is_published`)
            VALUES
            (:title, :organization, :location, :type, :period_start, :period_end, :is_current, :description, :responsibilities_json, :display_order, :is_published)";
        $stmt = static::db()->prepare($sql);
        $stmt->execute([
            ':title' => $data['title'],
            ':organization' => $data['organization'],
            ':location' => $data['location'] ?? '',
            ':type' => $data['type'] ?? 'Professional',
            ':period_start' => $data['period_start'],
            ':period_end' => $data['period_end'] ?? '',
            ':is_current' => (int)($data['is_current'] ?? 0),
            ':description' => $data['description'] ?? '',
            ':responsibilities_json' => is_array($data['responsibilities_json'] ?? null) ? json_encode($data['responsibilities_json']) : ($data['responsibilities_json'] ?? '[]'),
            ':display_order' => (int)($data['display_order'] ?? 0),
            ':is_published' => (int)($data['is_published'] ?? 1),
        ]);
        return (int)static::db()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $sql = "UPDATE `experiences` SET
            `title` = :title,
            `organization` = :organization,
            `location` = :location,
            `type` = :type,
            `period_start` = :period_start,
            `period_end` = :period_end,
            `is_current` = :is_current,
            `description` = :description,
            `responsibilities_json` = :responsibilities_json,
            `display_order` = :display_order,
            `is_published` = :is_published
            WHERE `id` = :id";
        $stmt = static::db()->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':title' => $data['title'],
            ':organization' => $data['organization'],
            ':location' => $data['location'] ?? '',
            ':type' => $data['type'] ?? 'Professional',
            ':period_start' => $data['period_start'],
            ':period_end' => $data['period_end'] ?? '',
            ':is_current' => (int)($data['is_current'] ?? 0),
            ':description' => $data['description'] ?? '',
            ':responsibilities_json' => is_array($data['responsibilities_json'] ?? null) ? json_encode($data['responsibilities_json']) : ($data['responsibilities_json'] ?? '[]'),
            ':display_order' => (int)($data['display_order'] ?? 0),
            ':is_published' => (int)($data['is_published'] ?? 1),
        ]);
    }
}
