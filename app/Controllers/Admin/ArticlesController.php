<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleTag;
use App\Models\ActivityLog;
use App\Services\AuthService;
use App\Services\ViewRenderer;
use App\Services\HttpException;

class ArticlesController
{
    public function index(): void
    {
        $pdo = \Database\Database::getConnection();
        $user = $this->currentUser();
        $sql = "SELECT a.*, c.name as category_name, u.username as author_name 
                FROM `articles` a
                LEFT JOIN `article_categories` c ON c.id = a.category_id
                LEFT JOIN `users` u ON u.id = a.author_id";
        if ($user['role'] === 'author') {
            $sql .= ' WHERE a.author_id = :author_id';
        }
        $sql .= ' ORDER BY a.created_at DESC';
        $stmt = $pdo->prepare($sql);
        if ($user['role'] === 'author') {
            $stmt->execute(['author_id' => $user['id']]);
        } else {
            $stmt->execute();
        }
        $articles = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];

        $renderer = new ViewRenderer();
        echo $renderer->render('admin.articles.index', [
            'articles' => $articles,
            'pageTitle' => 'Journal Articles Registry'
        ], 'admin.layout');
    }

    public function create(): void
    {
        $categories = ArticleCategory::allOrdered();
        $tags = ArticleTag::allOrdered();

        $renderer = new ViewRenderer();
        echo $renderer->render('admin.articles.create', [
            'categories' => $categories,
            'tags' => $tags,
            'pageTitle' => 'Create Article // Journal'
        ], 'admin.layout');
    }

    public function store(): void
    {
        $user = $this->currentUser();
        $title = trim((string)($_POST['title'] ?? ''));
        $slug = trim((string)($_POST['slug'] ?? ''));
        if ($slug === '') {
            $slug = slugify($title);
        } else {
            $slug = slugify($slug);
        }

        $content = trim((string)($_POST['content'] ?? ''));
        $excerpt = trim((string)($_POST['excerpt'] ?? ''));
        $categoryId = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
        $status = in_array($_POST['status'] ?? '', ['draft', 'published', 'archived']) ? $_POST['status'] : 'draft';
        $isFeatured = !empty($_POST['is_featured']) ? 1 : 0;
        if ($user['role'] === 'author') {
            $status = 'draft';
            $isFeatured = 0;
        }
        $featuredImage = trim((string)($_POST['featured_image'] ?? ''));
        $seoTitle = trim((string)($_POST['seo_title'] ?? ''));
        $seoDesc = trim((string)($_POST['seo_description'] ?? ''));
        $publishedAt = ($status === 'published') ? date('Y-m-d H:i:s') : null;

        if ($title === '' || $content === '') {
            flash('error', 'Article title and content are mandatory.');
            redirect('admin/articles/create');
        }

        $userId = (int) $user['id'];

        $pdo = \Database\Database::getConnection();
        $sql = "INSERT INTO `articles` 
                (`author_id`, `category_id`, `title`, `slug`, `excerpt`, `content`, `featured_image`, `seo_title`, `seo_description`, `is_featured`, `status`, `published_at`)
                VALUES (:author_id, :category_id, :title, :slug, :excerpt, :content, :featured_image, :seo_title, :seo_description, :is_featured, :status, :published_at)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'author_id' => $userId,
            'category_id' => $categoryId,
            'title' => $title,
            'slug' => $slug,
            'excerpt' => $excerpt ?: substr(strip_tags($content), 0, 160),
            'content' => $content,
            'featured_image' => $featuredImage ?: null,
            'seo_title' => $seoTitle ?: null,
            'seo_description' => $seoDesc ?: null,
            'is_featured' => $isFeatured,
            'status' => $status,
            'published_at' => $publishedAt
        ]);

        $articleId = (int)$pdo->lastInsertId();

        // Handle tags
        if (!empty($_POST['tags_input'])) {
            $tagNames = explode(',', (string)$_POST['tags_input']);
            $tagIds = [];
            foreach ($tagNames as $rawName) {
                $trimmed = trim($rawName);
                if ($trimmed !== '') {
                    $tagIds[] = ArticleTag::findOrCreate($trimmed);
                }
            }
            Article::syncTags($articleId, $tagIds);
        }

        ActivityLog::record($userId, 'ARTICLE_CREATE', "Created article: {$title}");
        flash('success', "Article '{$title}' was created successfully.");
        redirect('admin/articles');
    }

    public function edit(int|string $id): void
    {
        $article = Article::find((int)$id);
        if (!$article) {
            throw new HttpException(404, "Article {$id} not found.");
        }
        $this->ensureCanManageArticle($article);

        $categories = ArticleCategory::allOrdered();
        $tags = ArticleTag::allOrdered();
        $articleTags = Article::getTagsForArticle((int)$id);
        $articleTagNames = implode(', ', array_column($articleTags, 'name'));

        $renderer = new ViewRenderer();
        echo $renderer->render('admin.articles.edit', [
            'article' => $article,
            'categories' => $categories,
            'tags' => $tags,
            'articleTagNames' => $articleTagNames,
            'pageTitle' => "Edit Article // {$article['title']}"
        ], 'admin.layout');
    }

    public function update(int|string $id): void
    {
        $id = (int)$id;
        $article = Article::find((int)$id);
        if (!$article) {
            throw new HttpException(404, "Article {$id} not found.");
        }
        $user = $this->ensureCanManageArticle($article);

        $title = trim((string)($_POST['title'] ?? ''));
        $slug = trim((string)($_POST['slug'] ?? ''));
        $slug = $slug !== '' ? slugify($slug) : slugify($title);
        $content = trim((string)($_POST['content'] ?? ''));
        $excerpt = trim((string)($_POST['excerpt'] ?? ''));
        $categoryId = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
        $status = in_array($_POST['status'] ?? '', ['draft', 'published', 'archived']) ? $_POST['status'] : 'draft';
        $isFeatured = !empty($_POST['is_featured']) ? 1 : 0;
        if ($user['role'] === 'author') {
            $status = 'draft';
            $isFeatured = 0;
        }
        $featuredImage = trim((string)($_POST['featured_image'] ?? ''));
        $seoTitle = trim((string)($_POST['seo_title'] ?? ''));
        $seoDesc = trim((string)($_POST['seo_description'] ?? ''));

        $publishedAt = $article['published_at'];
        if ($status === 'published' && empty($publishedAt)) {
            $publishedAt = date('Y-m-d H:i:s');
        }

        $pdo = \Database\Database::getConnection();
        $sql = "UPDATE `articles` SET 
                `category_id` = :category_id,
                `title` = :title,
                `slug` = :slug,
                `excerpt` = :excerpt,
                `content` = :content,
                `featured_image` = :featured_image,
                `seo_title` = :seo_title,
                `seo_description` = :seo_description,
                `is_featured` = :is_featured,
                `status` = :status,
                `published_at` = :published_at
                WHERE `id` = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id' => (int)$id,
            'category_id' => $categoryId,
            'title' => $title,
            'slug' => $slug,
            'excerpt' => $excerpt ?: substr(strip_tags($content), 0, 160),
            'content' => $content,
            'featured_image' => $featuredImage ?: null,
            'seo_title' => $seoTitle ?: null,
            'seo_description' => $seoDesc ?: null,
            'is_featured' => $isFeatured,
            'status' => $status,
            'published_at' => $publishedAt
        ]);

        // Handle tags
        if (isset($_POST['tags_input'])) {
            $tagNames = explode(',', (string)$_POST['tags_input']);
            $tagIds = [];
            foreach ($tagNames as $rawName) {
                $trimmed = trim($rawName);
                if ($trimmed !== '') {
                    $tagIds[] = ArticleTag::findOrCreate($trimmed);
                }
            }
            Article::syncTags((int)$id, $tagIds);
        }

        ActivityLog::record(AuthService::id(), 'ARTICLE_UPDATE', "Updated article record #{$id}: {$title}");
        flash('success', "Article '{$title}' updated successfully.");
        redirect('admin/articles');
    }

    public function delete(int|string $id): void
    {
        $id = (int)$id;
        $article = Article::find($id);
        if ($article) {
            $this->ensureCanManageArticle($article);
            Article::delete($id);
            ActivityLog::record(AuthService::id(), 'ARTICLE_DELETE', "Deleted article #{$id}: {$article['title']}");
            flash('success', "Article deleted successfully.");
        }
        redirect('admin/articles');
    }

    private function currentUser(): array
    {
        $user = AuthService::user();
        if ($user === null) {
            throw new HttpException(403, 'Authentication context is unavailable.');
        }

        return $user;
    }

    private function ensureCanManageArticle(array $article): array
    {
        $user = $this->currentUser();
        if ($user['role'] === 'author' && (int) ($article['author_id'] ?? 0) !== (int) $user['id']) {
            throw new HttpException(403, 'Authors may only manage their own articles.');
        }

        return $user;
    }
}
