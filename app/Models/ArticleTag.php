<?php
declare(strict_types=1);

namespace App\Models;

use Database\Database;
use PDO;

class ArticleTag extends BaseModel
{
    protected static string $table = 'article_tags';

    public static function allOrdered(): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM `article_tags` ORDER BY `name` ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public static function findBySlug(string $slug): ?array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM `article_tags` WHERE `slug` = :slug LIMIT 1");
        $stmt->execute(['slug' => $slug]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: null;
    }

    public static function findOrCreate(string $name): int
    {
        $name = trim($name);
        $slug = slugify($name);
        $pdo = Database::getConnection();
        
        $stmt = $pdo->prepare("SELECT id FROM `article_tags` WHERE `slug` = :slug LIMIT 1");
        $stmt->execute(['slug' => $slug]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($existing) {
            return (int)$existing['id'];
        }

        $insert = $pdo->prepare("INSERT INTO `article_tags` (`name`, `slug`) VALUES (:name, :slug)");
        $insert->execute(['name' => $name, 'slug' => $slug]);
        return (int)$pdo->lastInsertId();
    }
}
