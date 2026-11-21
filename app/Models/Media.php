<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

class Media extends BaseModel
{
    protected static string $table = 'media';

    public static function create(array $data): int
    {
        $sql = "INSERT INTO `media` (`filename`, `original_name`, `mime_type`, `file_size`, `file_path`, `alt_text`, `caption`)
                VALUES (:filename, :original_name, :mime_type, :file_size, :file_path, :alt_text, :caption)";
        $stmt = static::db()->prepare($sql);
        $stmt->execute([
            ':filename' => $data['filename'],
            ':original_name' => $data['original_name'],
            ':mime_type' => $data['mime_type'],
            ':file_size' => (int)$data['file_size'],
            ':file_path' => $data['file_path'],
            ':alt_text' => $data['alt_text'] ?? '',
            ':caption' => $data['caption'] ?? '',
        ]);
        return (int)static::db()->lastInsertId();
    }

    public static function totalStorageBytes(): int
    {
        $stmt = static::db()->query("SELECT SUM(`file_size`) FROM `media`");
        return (int)$stmt->fetchColumn();
    }
}
