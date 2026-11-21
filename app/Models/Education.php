<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

class Education extends BaseModel
{
    protected static string $table = 'education';

    public static function getPublished(): array
    {
        $stmt = static::db()->query(
            "SELECT * FROM `education` WHERE `is_published` = 1 ORDER BY `display_order` ASC, `id` DESC"
        );
        return $stmt->fetchAll();
    }

    public static function create(array $data): int
    {
        $sql = "INSERT INTO `education` (`institution`, `degree`, `field_of_study`, `period_start`, `period_end`, `achievements`, `display_order`, `is_published`)
                VALUES (:institution, :degree, :field_of_study, :period_start, :period_end, :achievements, :display_order, :is_published)";
        $stmt = static::db()->prepare($sql);
        $stmt->execute([
            ':institution' => $data['institution'],
            ':degree' => $data['degree'],
            ':field_of_study' => $data['field_of_study'] ?? '',
            ':period_start' => $data['period_start'],
            ':period_end' => $data['period_end'] ?? '',
            ':achievements' => $data['achievements'] ?? '',
            ':display_order' => (int)($data['display_order'] ?? 0),
            ':is_published' => (int)($data['is_published'] ?? 1),
        ]);
        return (int)static::db()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $sql = "UPDATE `education` SET
            `institution` = :institution,
            `degree` = :degree,
            `field_of_study` = :field_of_study,
            `period_start` = :period_start,
            `period_end` = :period_end,
            `achievements` = :achievements,
            `display_order` = :display_order,
            `is_published` = :is_published
            WHERE `id` = :id";
        $stmt = static::db()->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':institution' => $data['institution'],
            ':degree' => $data['degree'],
            ':field_of_study' => $data['field_of_study'] ?? '',
            ':period_start' => $data['period_start'],
            ':period_end' => $data['period_end'] ?? '',
            ':achievements' => $data['achievements'] ?? '',
            ':display_order' => (int)($data['display_order'] ?? 0),
            ':is_published' => (int)($data['is_published'] ?? 1),
        ]);
    }
}
