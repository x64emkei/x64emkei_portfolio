<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

class Certification extends BaseModel
{
    protected static string $table = 'certifications';

    public static function getPublished(): array
    {
        $stmt = static::db()->query(
            "SELECT * FROM `certifications` WHERE `is_published` = 1 ORDER BY `display_order` ASC, `id` DESC"
        );
        return $stmt->fetchAll();
    }

    public static function create(array $data): int
    {
        $sql = "INSERT INTO `certifications` (`title`, `issuer`, `issue_date`, `credential_id`, `credential_url`, `display_order`, `is_published`)
                VALUES (:title, :issuer, :issue_date, :credential_id, :credential_url, :display_order, :is_published)";
        $stmt = static::db()->prepare($sql);
        $stmt->execute([
            ':title' => $data['title'],
            ':issuer' => $data['issuer'],
            ':issue_date' => $data['issue_date'] ?? '',
            ':credential_id' => $data['credential_id'] ?? '',
            ':credential_url' => $data['credential_url'] ?? '',
            ':display_order' => (int)($data['display_order'] ?? 0),
            ':is_published' => (int)($data['is_published'] ?? 1),
        ]);
        return (int)static::db()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $sql = "UPDATE `certifications` SET
            `title` = :title,
            `issuer` = :issuer,
            `issue_date` = :issue_date,
            `credential_id` = :credential_id,
            `credential_url` = :credential_url,
            `display_order` = :display_order,
            `is_published` = :is_published
            WHERE `id` = :id";
        $stmt = static::db()->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':title' => $data['title'],
            ':issuer' => $data['issuer'],
            ':issue_date' => $data['issue_date'] ?? '',
            ':credential_id' => $data['credential_id'] ?? '',
            ':credential_url' => $data['credential_url'] ?? '',
            ':display_order' => (int)($data['display_order'] ?? 0),
            ':is_published' => (int)($data['is_published'] ?? 1),
        ]);
    }
}
