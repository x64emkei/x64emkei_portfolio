<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

class PortfolioSection extends BaseModel
{
    protected static string $table = 'portfolio_sections';

    public static function allOrdered(): array
    {
        $stmt = static::db()->query(
            "SELECT * FROM `portfolio_sections` ORDER BY `display_order` ASC, `id` ASC"
        );
        return $stmt->fetchAll();
    }

    public static function allKeyed(): array
    {
        $rows = static::allOrdered();
        $keyed = [];
        foreach ($rows as $row) {
            $keyed[$row['section_key']] = $row;
        }
        return $keyed;
    }

    public static function findByKey(string $key): ?array
    {
        $stmt = static::db()->prepare("SELECT * FROM `portfolio_sections` WHERE `section_key` = :key LIMIT 1");
        $stmt->execute([':key' => $key]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function isEnabled(string $key): bool
    {
        $section = static::findByKey($key);
        if (!$section) {
            return true; // Default fallback to enabled if not configured
        }
        return (bool)$section['is_enabled'];
    }

    public static function updateSection(string $key, array $data): bool
    {
        $sql = "UPDATE `portfolio_sections` SET
            `title` = :title,
            `subtitle` = :subtitle,
            `intro_text` = :intro_text,
            `is_enabled` = :is_enabled,
            `display_order` = :display_order,
            `layout_variation` = :layout_variation,
            `hide_if_empty` = :hide_if_empty
            WHERE `section_key` = :key";
        $stmt = static::db()->prepare($sql);
        return $stmt->execute([
            ':key' => $key,
            ':title' => $data['title'] ?? '',
            ':subtitle' => $data['subtitle'] ?? '',
            ':intro_text' => $data['intro_text'] ?? '',
            ':is_enabled' => (int)($data['is_enabled'] ?? 1),
            ':display_order' => (int)($data['display_order'] ?? 0),
            ':layout_variation' => $data['layout_variation'] ?? 'default',
            ':hide_if_empty' => (int)($data['hide_if_empty'] ?? 1),
        ]);
    }

    public static function upsert(array $data): void
    {
        $sql = "INSERT INTO `portfolio_sections` (`section_key`, `title`, `subtitle`, `intro_text`, `is_enabled`, `display_order`, `layout_variation`, `hide_if_empty`)
                VALUES (:section_key, :title, :subtitle, :intro_text, :is_enabled, :display_order, :layout_variation, :hide_if_empty)
                ON DUPLICATE KEY UPDATE
                `title` = VALUES(`title`),
                `subtitle` = VALUES(`subtitle`),
                `intro_text` = VALUES(`intro_text`),
                `is_enabled` = VALUES(`is_enabled`),
                `display_order` = VALUES(`display_order`),
                `layout_variation` = VALUES(`layout_variation`),
                `hide_if_empty` = VALUES(`hide_if_empty`)";
        $stmt = static::db()->prepare($sql);
        $stmt->execute([
            ':section_key' => $data['section_key'],
            ':title' => $data['title'],
            ':subtitle' => $data['subtitle'] ?? '',
            ':intro_text' => $data['intro_text'] ?? '',
            ':is_enabled' => (int)($data['is_enabled'] ?? 1),
            ':display_order' => (int)($data['display_order'] ?? 0),
            ':layout_variation' => $data['layout_variation'] ?? 'default',
            ':hide_if_empty' => (int)($data['hide_if_empty'] ?? 1),
        ]);
    }
}
