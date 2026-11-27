<?php
declare(strict_types=1);

namespace App\Models;

use Database\Database;
use PDO;

class Article extends BaseModel
{
    protected static string $table = 'articles';

    public static function getPublished(int $limit = 20, int $offset = 0): array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT a.*, c.name as category_name, c.slug as category_slug, u.username as author_name
                FROM `articles` a
                LEFT JOIN `article_categories` c ON c.id = a.category_id
                LEFT JOIN `users` u ON u.id = a.author_id
                WHERE a.status = 'published' AND (a.published_at IS NULL OR a.published_at <= NOW())
                ORDER BY COALESCE(a.published_at, a.created_at) DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        foreach ($articles as &$art) {
            $art['tags'] = self::getTagsForArticle((int)$art['id']);
        }

        return $articles;
    }

    public static function countPublished(): int
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT COUNT(*) FROM `articles` WHERE status = 'published' AND (published_at IS NULL OR published_at <= NOW())");
        return (int)$stmt->fetchColumn();
    }

    public static function getFeatured(int $limit = 3): array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT a.*, c.name as category_name, c.slug as category_slug, u.username as author_name
                FROM `articles` a
                LEFT JOIN `article_categories` c ON c.id = a.category_id
                LEFT JOIN `users` u ON u.id = a.author_id
                WHERE a.status = 'published' AND a.is_featured = 1
                ORDER BY COALESCE(a.published_at, a.created_at) DESC
                LIMIT :limit";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        foreach ($articles as &$art) {
            $art['tags'] = self::getTagsForArticle((int)$art['id']);
        }
        return $articles;
    }

    public static function findBySlug(string $slug): ?array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT a.*, c.name as category_name, c.slug as category_slug, u.username as author_name
                FROM `articles` a
                LEFT JOIN `article_categories` c ON c.id = a.category_id
                LEFT JOIN `users` u ON u.id = a.author_id
                WHERE a.slug = :slug LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        $art = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$art) {
            return null;
        }

        $art['tags'] = self::getTagsForArticle((int)$art['id']);
        return $art;
    }

    /**
     * Return the single canonical AI principles article used across the site.
     * The legacy slug remains supported for existing links and seeded data.
     */
    public static function getManifesto(): ?array
    {
        return self::findBySlug('my-ai-manifesto') ?: self::findBySlug('ai-manifesto');
    }

    public static function getByCategory(int $categoryId, int $limit = 20, int $offset = 0): array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT a.*, c.name as category_name, c.slug as category_slug, u.username as author_name
                FROM `articles` a
                LEFT JOIN `article_categories` c ON c.id = a.category_id
                LEFT JOIN `users` u ON u.id = a.author_id
                WHERE a.status = 'published' AND a.category_id = :cat_id
                ORDER BY COALESCE(a.published_at, a.created_at) DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':cat_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        foreach ($articles as &$art) {
            $art['tags'] = self::getTagsForArticle((int)$art['id']);
        }
        return $articles;
    }

    public static function getByTag(int $tagId, int $limit = 20, int $offset = 0): array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT a.*, c.name as category_name, c.slug as category_slug, u.username as author_name
                FROM `articles` a
                JOIN `article_tag_pivot` p ON p.article_id = a.id
                LEFT JOIN `article_categories` c ON c.id = a.category_id
                LEFT JOIN `users` u ON u.id = a.author_id
                WHERE a.status = 'published' AND p.tag_id = :tag_id
                ORDER BY COALESCE(a.published_at, a.created_at) DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':tag_id', $tagId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        foreach ($articles as &$art) {
            $art['tags'] = self::getTagsForArticle((int)$art['id']);
        }
        return $articles;
    }

    public static function search(string $query, int $limit = 20): array
    {
        $pdo = Database::getConnection();
        $term = '%' . $query . '%';
        $sql = "SELECT a.*, c.name as category_name, c.slug as category_slug, u.username as author_name
                FROM `articles` a
                LEFT JOIN `article_categories` c ON c.id = a.category_id
                LEFT JOIN `users` u ON u.id = a.author_id
                WHERE a.status = 'published' AND (a.title LIKE :q1 OR a.excerpt LIKE :q2 OR a.content LIKE :q3)
                ORDER BY COALESCE(a.published_at, a.created_at) DESC
                LIMIT :limit";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':q1', $term, PDO::PARAM_STR);
        $stmt->bindValue(':q2', $term, PDO::PARAM_STR);
        $stmt->bindValue(':q3', $term, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        foreach ($articles as &$art) {
            $art['tags'] = self::getTagsForArticle((int)$art['id']);
        }
        return $articles;
    }

    public static function getTagsForArticle(int $articleId): array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT t.* FROM `article_tags` t
                JOIN `article_tag_pivot` p ON p.tag_id = t.id
                WHERE p.article_id = :art_id ORDER BY t.name ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['art_id' => $articleId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public static function syncTags(int $articleId, array $tagIds): void
    {
        $pdo = Database::getConnection();
        $del = $pdo->prepare("DELETE FROM `article_tag_pivot` WHERE `article_id` = :art_id");
        $del->execute(['art_id' => $articleId]);

        if (empty($tagIds)) {
            return;
        }

        $ins = $pdo->prepare("INSERT IGNORE INTO `article_tag_pivot` (`article_id`, `tag_id`) VALUES (:art_id, :tag_id)");
        foreach ($tagIds as $tid) {
            $ins->execute(['art_id' => $articleId, 'tag_id' => (int)$tid]);
        }
    }
}
