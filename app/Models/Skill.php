<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

class Skill extends BaseModel
{
    protected static string $table = 'skills';

    public static function getPublishedGrouped(): array
    {
        $stmt = static::db()->query(
            "SELECT * FROM `skills` WHERE `is_published` = 1 ORDER BY `category` ASC, `display_order` ASC"
        );
        $all = $stmt->fetchAll();
        $grouped = [];
        foreach ($all as $item) {
            $grouped[$item['category']][] = $item;
        }
        return $grouped;
    }

    public static function create(array $data): int
    {
        $sql = "INSERT INTO `skills` (`category`, `name`, `proficiency_level`, `icon_svg`, `display_order`, `is_published`)
                VALUES (:category, :name, :proficiency_level, :icon_svg, :display_order, :is_published)";
        $stmt = static::db()->prepare($sql);
        $stmt->execute([
            ':category' => $data['category'],
            ':name' => $data['name'],
            ':proficiency_level' => (int)($data['proficiency_level'] ?? 85),
            ':icon_svg' => $data['icon_svg'] ?? '',
            ':display_order' => (int)($data['display_order'] ?? 0),
            ':is_published' => (int)($data['is_published'] ?? 1),
        ]);
        return (int)static::db()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $sql = "UPDATE `skills` SET
            `category` = :category,
            `name` = :name,
            `proficiency_level` = :proficiency_level,
            `icon_svg` = :icon_svg,
            `display_order` = :display_order,
            `is_published` = :is_published
            WHERE `id` = :id";
        $stmt = static::db()->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':category' => $data['category'],
            ':name' => $data['name'],
            ':proficiency_level' => (int)($data['proficiency_level'] ?? 85),
            ':icon_svg' => $data['icon_svg'] ?? '',
            ':display_order' => (int)($data['display_order'] ?? 0),
            ':is_published' => (int)($data['is_published'] ?? 1),
        ]);
    }
}
