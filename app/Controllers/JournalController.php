<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleTag;
use App\Services\ViewRenderer;
use App\Services\HttpException;

class JournalController
{
    public function index(): void
    {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 6;
        $offset = ($page - 1) * $perPage;

        $search = trim((string)($_GET['q'] ?? ''));
        if ($search !== '') {
            $articles = Article::search($search, 20);
            $total = count($articles);
        } else {
            $articles = Article::getPublished($perPage, $offset);
            $total = Article::countPublished();
        }

        $categories = ArticleCategory::withArticleCount();
        $tags = ArticleTag::allOrdered();
        $featured = Article::getFeatured(3);

        $totalPages = (int)ceil($total / $perPage);

        $renderer = new ViewRenderer();
        echo $renderer->render('public.journal.index', [
            'articles' => $articles,
            'categories' => $categories,
            'tags' => $tags,
            'featured' => $featured,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalArticles' => $total,
            'pageTitle' => 'Journal & Telemetry Log // x64emkei.dev',
            'metaDesc' => 'Technical writeups, systems architecture analysis, and software development insights by Michael Benedict Ordenes.'
        ]);
    }

    public function manifesto(): void
    {
        $this->show('my-ai-manifesto');
    }

    public function show(string $slug): void
    {
        $article = Article::findBySlug($slug);
        if (!$article || ($article['status'] !== 'published' && !isset($_SESSION['user_id']))) {
            throw new HttpException(404, "Transmission '{$slug}' could not be located in journal archives.");
        }

        $categories = ArticleCategory::withArticleCount();
        $related = Article::getByCategory((int)$article['category_id'], 4);
        // Exclude current article
        $related = array_filter($related, fn($a) => (int)$a['id'] !== (int)$article['id']);

        $renderer = new ViewRenderer();
        echo $renderer->render('public.journal.show', [
            'article' => $article,
            'categories' => $categories,
            'related' => $related,
            'pageTitle' => ($article['seo_title'] ?: $article['title']) . ' // x64emkei.dev',
            'metaDesc' => $article['seo_description'] ?: ($article['excerpt'] ?: substr(strip_tags($article['content']), 0, 160))
        ]);
    }

    public function category(string $slug): void
    {
        $category = ArticleCategory::findBySlug($slug);
        if (!$category) {
            throw new HttpException(404, "Category archive '{$slug}' not found.");
        }

        $articles = Article::getByCategory((int)$category['id'], 20);
        $categories = ArticleCategory::withArticleCount();

        $renderer = new ViewRenderer();
        echo $renderer->render('public.journal.category', [
            'category' => $category,
            'articles' => $articles,
            'categories' => $categories,
            'pageTitle' => "Category: {$category['name']} // Journal",
            'metaDesc' => $category['description'] ?: "Articles categorized under {$category['name']}."
        ]);
    }

    public function tag(string $slug): void
    {
        $tag = ArticleTag::findBySlug($slug);
        if (!$tag) {
            throw new HttpException(404, "Tag archive '{$slug}' not found.");
        }

        $articles = Article::getByTag((int)$tag['id'], 20);
        $categories = ArticleCategory::withArticleCount();

        $renderer = new ViewRenderer();
        echo $renderer->render('public.journal.tag', [
            'tag' => $tag,
            'articles' => $articles,
            'categories' => $categories,
            'pageTitle' => "Tag: {$tag['name']} // Journal",
            'metaDesc' => "Articles tagged with #{$tag['name']}."
        ]);
    }
}
