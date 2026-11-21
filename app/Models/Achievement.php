<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

class Achievement extends BaseModel
{
    protected static string $table = 'achievements';

    public static function getPublished(): array
    {
        $stmt = static::db()->query(
            "SELECT * FROM `achievements` WHERE `is_published` = 1 ORDER BY `display_order` ASC, `id` ASC"
        );
        return $stmt->fetchAll();
    }

    public static function getFeatured(): array
    {
        $stmt = static::db()->query(
            "SELECT * FROM `achievements` WHERE `is_published` = 1 AND `is_featured` = 1 ORDER BY `display_order` ASC, `id` ASC"
        );
        return $stmt->fetchAll();
    }

    public static function create(array $data): int
    {
        $sql = "INSERT INTO `achievements` (`title`, `issuer`, `description`, `award_date`, `category`, `image_url`, `document_url`, `verification_url`, `is_featured`, `display_order`, `is_published`)
                VALUES (:title, :issuer, :description, :award_date, :category, :image_url, :document_url, :verification_url, :is_featured, :display_order, :is_published)";
        $stmt = static::db()->prepare($sql);
        $stmt->execute([
            ':title' => $data['title'],
            ':issuer' => $data['issuer'] ?? '',
            ':description' => $data['description'] ?? '',
            ':award_date' => $data['award_date'] ?? '',
            ':category' => $data['category'] ?? 'Academic',
            ':image_url' => $data['image_url'] ?? '',
            ':document_url' => $data['document_url'] ?? '',
            ':verification_url' => $data['verification_url'] ?? '',
            ':is_featured' => (int)($data['is_featured'] ?? 0),
            ':display_order' => (int)($data['display_order'] ?? 0),
            ':is_published' => (int)($data['is_published'] ?? 1),
        ]);
        return (int)static::db()->lastInsertId();
    }

    public static function update(int|string $id, array $data): bool
    {
        $sql = "UPDATE `achievements` SET
            `title` = :title,
            `issuer` = :issuer,
            `description` = :description,
            `award_date` = :award_date,
            `category` = :category,
            `image_url` = :image_url,
            `document_url` = :document_url,
            `verification_url` = :verification_url,
            `is_featured` = :is_featured,
            `display_order` = :display_order,
            `is_published` = :is_published
            WHERE `id` = :id";
        $stmt = static::db()->prepare($sql);
        return $stmt->execute([
            ':id' => (int)$id,
            ':title' => $data['title'],
            ':issuer' => $data['issuer'] ?? '',
            ':description' => $data['description'] ?? '',
            ':award_date' => $data['award_date'] ?? '',
            ':category' => $data['category'] ?? 'Academic',
            ':image_url' => $data['image_url'] ?? '',
            ':document_url' => $data['document_url'] ?? '',
            ':verification_url' => $data['verification_url'] ?? '',
            ':is_featured' => (int)($data['is_featured'] ?? 0),
            ':display_order' => (int)($data['display_order'] ?? 0),
            ':is_published' => (int)($data['is_published'] ?? 1),
        ]);
    }
}
