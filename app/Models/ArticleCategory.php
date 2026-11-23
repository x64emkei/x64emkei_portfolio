<?php
declare(strict_types=1);

namespace App\Models;

use Database\Database;
use PDO;

class ArticleCategory extends BaseModel
{
    protected static string $table = 'article_categories';

    public static function allOrdered(): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM `article_categories` ORDER BY `display_order` ASC, `name` ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public static function findBySlug(string $slug): ?array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM `article_categories` WHERE `slug` = :slug LIMIT 1");
        $stmt->execute(['slug' => $slug]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: null;
    }

    public static function withArticleCount(): array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT c.*, COUNT(a.id) as article_count 
                FROM `article_categories` c
                LEFT JOIN `articles` a ON a.category_id = c.id AND a.status = 'published'
                GROUP BY c.id
                ORDER BY c.display_order ASC, c.name ASC";
        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}
