<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

class HardwareNode extends BaseModel
{
    protected static string $table = 'hardware_nodes';

    public static function getPublished(): array
    {
        $stmt = static::db()->query(
            "SELECT * FROM `hardware_nodes` WHERE `is_published` = 1 ORDER BY `display_order` ASC, `id` ASC"
        );
        return $stmt->fetchAll();
    }

    public static function create(array $data): int
    {
        $sql = "INSERT INTO `hardware_nodes`
            (`node_id`, `tag`, `title`, `subtitle`, `oem`, `specs_json`, `diagnostics_log`, `image_url`, `display_order`, `is_published`)
            VALUES
            (:node_id, :tag, :title, :subtitle, :oem, :specs_json, :diagnostics_log, :image_url, :display_order, :is_published)";
        $stmt = static::db()->prepare($sql);
        $stmt->execute([
            ':node_id' => $data['node_id'],
            ':tag' => $data['tag'] ?? 'PRESERVED',
            ':title' => $data['title'],
            ':subtitle' => $data['subtitle'],
            ':oem' => $data['oem'],
            ':specs_json' => is_array($data['specs_json'] ?? null) ? json_encode($data['specs_json']) : ($data['specs_json'] ?? '[]'),
            ':diagnostics_log' => $data['diagnostics_log'],
            ':image_url' => $data['image_url'] ?? '',
            ':display_order' => (int)($data['display_order'] ?? 0),
            ':is_published' => (int)($data['is_published'] ?? 1),
        ]);
        return (int)static::db()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $sql = "UPDATE `hardware_nodes` SET
            `node_id` = :node_id,
            `tag` = :tag,
            `title` = :title,
            `subtitle` = :subtitle,
            `oem` = :oem,
            `specs_json` = :specs_json,
            `diagnostics_log` = :diagnostics_log,
            `image_url` = :image_url,
            `display_order` = :display_order,
            `is_published` = :is_published
            WHERE `id` = :id";
        $stmt = static::db()->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':node_id' => $data['node_id'],
            ':tag' => $data['tag'] ?? 'PRESERVED',
            ':title' => $data['title'],
            ':subtitle' => $data['subtitle'],
            ':oem' => $data['oem'],
            ':specs_json' => is_array($data['specs_json'] ?? null) ? json_encode($data['specs_json']) : ($data['specs_json'] ?? '[]'),
            ':diagnostics_log' => $data['diagnostics_log'],
            ':image_url' => $data['image_url'] ?? '',
            ':display_order' => (int)($data['display_order'] ?? 0),
            ':is_published' => (int)($data['is_published'] ?? 1),
        ]);
    }
}
