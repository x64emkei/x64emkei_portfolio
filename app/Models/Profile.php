<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

class Profile extends BaseModel
{
    protected static string $table = 'profile';

    public static function get(): ?array
    {
        $stmt = static::db()->query("SELECT * FROM `profile` ORDER BY `id` ASC LIMIT 1");
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function save(array $data): bool
    {
        $existing = self::get();
        if ($existing) {
            $sql = "UPDATE `profile` SET
                `full_name` = :full_name,
                `title` = :title,
                `tagline` = :tagline,
                `bio_short` = :bio_short,
                `bio_full` = :bio_full,
                `avatar_url` = :avatar_url,
                `cover_url` = :cover_url,
                `location` = :location,
                `availability_status` = :availability_status,
                `resume_url` = :resume_url,
                `email` = :email
             WHERE `id` = :id";
            $data['id'] = $existing['id'];
        } else {
            $sql = "INSERT INTO `profile`
                (`full_name`, `title`, `tagline`, `bio_short`, `bio_full`, `avatar_url`, `cover_url`, `location`, `availability_status`, `resume_url`, `email`)
                VALUES
                (:full_name, :title, :tagline, :bio_short, :bio_full, :avatar_url, :cover_url, :location, :availability_status, :resume_url, :email)";
        }

        $stmt = static::db()->prepare($sql);
        return $stmt->execute([
            ':full_name' => $data['full_name'],
            ':title' => $data['title'],
            ':tagline' => $data['tagline'] ?? '',
            ':bio_short' => $data['bio_short'] ?? '',
            ':bio_full' => $data['bio_full'] ?? '',
            ':avatar_url' => $data['avatar_url'] ?? '',
            ':cover_url' => $data['cover_url'] ?? '',
            ':location' => $data['location'] ?? '',
            ':availability_status' => $data['availability_status'] ?? 'Available',
            ':resume_url' => $data['resume_url'] ?? '',
            ':email' => $data['email'] ?? '',
            ...($existing ? [':id' => $existing['id']] : [])
        ]);
    }
}
