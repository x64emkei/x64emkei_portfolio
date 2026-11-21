<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

class SocialLink extends BaseModel
{
    protected static string $table = 'social_links';

    public static function getPublished(): array
    {
        $stmt = static::db()->query(
            "SELECT * FROM `social_links` WHERE `is_published` = 1 ORDER BY `display_order` ASC, `id` ASC"
        );
        return $stmt->fetchAll();
    }

    public static function create(array $data): int
    {
        $sql = "INSERT INTO `social_links` (`platform`, `label`, `url`, `icon_svg`, `display_order`, `is_published`)
                VALUES (:platform, :label, :url, :icon_svg, :display_order, :is_published)";
        $stmt = static::db()->prepare($sql);
        $stmt->execute([
            ':platform' => $data['platform'],
            ':label' => $data['label'],
            ':url' => $data['url'],
            ':icon_svg' => $data['icon_svg'] ?? '',
            ':display_order' => (int)($data['display_order'] ?? 0),
            ':is_published' => (int)($data['is_published'] ?? 1),
        ]);
        return (int)static::db()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $sql = "UPDATE `social_links` SET
            `platform` = :platform,
            `label` = :label,
            `url` = :url,
            `icon_svg` = :icon_svg,
            `display_order` = :display_order,
            `is_published` = :is_published
            WHERE `id` = :id";
        $stmt = static::db()->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':platform' => $data['platform'],
            ':label' => $data['label'],
            ':url' => $data['url'],
            ':icon_svg' => $data['icon_svg'] ?? '',
            ':display_order' => (int)($data['display_order'] ?? 0),
            ':is_published' => (int)($data['is_published'] ?? 1),
        ]);
    }
}
