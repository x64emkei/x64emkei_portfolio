<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

class Achievement extends BaseModel
{
    protected static string $table = 'achievements';

    public static function autoMigrateIfMissing(): void
    {
        try {
            $pdo = static::db();
            $sql = "CREATE TABLE IF NOT EXISTS `achievements` (
              `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              `title` VARCHAR(255) NOT NULL,
              `issuer` VARCHAR(255) NULL,
              `description` TEXT NULL,
              `award_date` VARCHAR(50) NULL,
              `category` VARCHAR(100) NULL,
              `image_url` VARCHAR(500) NULL,
              `document_url` VARCHAR(500) NULL,
              `verification_url` VARCHAR(500) NULL,
              `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
              `display_order` INT NOT NULL DEFAULT 0,
              `is_published` TINYINT(1) NOT NULL DEFAULT 1,
              `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              INDEX `idx_achieve_published` (`is_published`),
              INDEX `idx_achieve_order` (`display_order`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
            $pdo->exec($sql);

            $check = (int)$pdo->query("SELECT COUNT(*) FROM `achievements`")->fetchColumn();
            if ($check === 0) {
                $achievements = [
                    ['Consistent Dean\'s Lister', 'Mapúa Malayan Colleges Laguna', 'Conferred academic honors for consecutive academic terms in BS Computer Science, maintaining exceptional academic performance across algorithmic analysis and systems development.', '2023 - Present', 'Academic', 1, 1],
                    ['ACM Student Chapter Operations Officer', 'Association for Computing Machinery (ACM)', 'Elected chapter officer overseeing systems engineering projects, student technical workshops, and competitive programming initiatives.', 'AY 2024 - 2025', 'Leadership', 1, 2],
                    ['Systems Architect Distinction', 'College of Computer and Information Science', 'Recognized for exceptional software architecture and development of resilient enterprise point-of-sale and homelab telemetry platforms.', '2024', 'Professional', 1, 3]
                ];
                $ins = $pdo->prepare("INSERT INTO `achievements` 
                    (`title`, `issuer`, `description`, `award_date`, `category`, `is_featured`, `display_order`, `is_published`)
                    VALUES (:t, :i, :d, :a, :c, :f, :o, 1)");
                foreach ($achievements as $ach) {
                    $ins->execute([
                        ':t' => $ach[0],
                        ':i' => $ach[1],
                        ':d' => $ach[2],
                        ':a' => $ach[3],
                        ':c' => $ach[4],
                        ':f' => $ach[5],
                        ':o' => $ach[6],
                    ]);
                }
            }
        } catch (\Throwable $e) {
            // Silent fallback
        }
    }

    public static function getPublished(): array
    {
        try {
            $stmt = static::db()->query(
                "SELECT * FROM `achievements` WHERE `is_published` = 1 ORDER BY `display_order` ASC, `id` ASC"
            );
            $rows = $stmt->fetchAll();
            return $rows ?: [];
        } catch (\Throwable $e) {
            static::autoMigrateIfMissing();
            try {
                $stmt = static::db()->query("SELECT * FROM `achievements` WHERE `is_published` = 1 ORDER BY `display_order` ASC, `id` ASC");
                return $stmt ? $stmt->fetchAll() : [];
            } catch (\Throwable $e2) {
                return [];
            }
        }
    }

    public static function getFeatured(): array
    {
        try {
            $stmt = static::db()->query(
                "SELECT * FROM `achievements` WHERE `is_published` = 1 AND `is_featured` = 1 ORDER BY `display_order` ASC, `id` ASC"
            );
            return $stmt->fetchAll() ?: [];
        } catch (\Throwable $e) {
            static::autoMigrateIfMissing();
            return [];
        }
    }

    public static function create(array $data): int
    {
        static::autoMigrateIfMissing();
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
        static::autoMigrateIfMissing();
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
