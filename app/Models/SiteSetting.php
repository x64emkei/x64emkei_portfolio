<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

class SiteSetting extends BaseModel
{
    protected static string $table = 'site_settings';

    public static function get(string $key, ?string $default = null): ?string
    {
        $stmt = static::db()->prepare("SELECT `setting_value` FROM `site_settings` WHERE `setting_key` = :k LIMIT 1");
        $stmt->execute([':k' => $key]);
        $val = $stmt->fetchColumn();
        return $val !== false ? (string)$val : $default;
    }

    public static function getAllKeyed(): array
    {
        $stmt = static::db()->query("SELECT `setting_key`, `setting_value` FROM `site_settings`");
        $rows = $stmt->fetchAll();
        $map = [];
        foreach ($rows as $r) {
            $map[$r['setting_key']] = $r['setting_value'];
        }
        return $map;
    }

    public static function set(string $key, ?string $value, string $group = 'general', ?string $desc = null): bool
    {
        $sql = "INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_group`, `description`)
                VALUES (:k, :v, :g, :d)
                ON DUPLICATE KEY UPDATE `setting_value` = :v2, `setting_group` = :g2";
        $stmt = static::db()->prepare($sql);
        return $stmt->execute([
            ':k' => $key,
            ':v' => $value,
            ':g' => $group,
            ':d' => $desc,
            ':v2' => $value,
            ':g2' => $group,
        ]);
    }
}
