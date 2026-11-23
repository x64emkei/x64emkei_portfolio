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

        $articles = [];
        $total = 0;
        $categories = [];
        $tags = [];
        $featured = [];

        $search = trim((string)($_GET['q'] ?? ''));
        try {
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
        } catch (\Throwable) {
            $articles = [$this->getManifestoFallback()];
            $total = 1;
        }

        $totalPages = max(1, (int)ceil($total / $perPage));

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

    public function blog(): void
    {
        $this->filterSection('blog', 'Blog & Technical Articles');
    }

    public function tutorials(): void
    {
        $this->filterSection('tutorials', 'Tutorials & Engineering Guides');
    }

    public function technicalNotes(): void
    {
        $this->filterSection('technical-notes', 'Technical Notes & System Diagnostics');
    }

    public function research(): void
    {
        $this->filterSection('research', 'Research, Architecture & Insights');
    }

    private function filterSection(string $type, string $sectionTitle): void
    {
        $articles = [];
        $categories = [];
        $tags = [];
        $featured = [];

        try {
            $slugMap = [
                'blog' => 'systems-architecture',
                'tutorials' => 'full-stack-engineering',
                'technical-notes' => 'cybersecurity-zero-trust',
                'research' => 'hardware-diagnostics'
            ];

            $targetCategory = $slugMap[$type] ?? $type;
            $category = ArticleCategory::findBySlug($targetCategory);
            if ($category) {
                $articles = Article::getByCategory((int)$category['id'], 20);
            } else {
                $articles = Article::search($type, 20);
                if (empty($articles)) {
                    $articles = Article::getPublished(6);
                }
            }

            $categories = ArticleCategory::withArticleCount();
            $tags = ArticleTag::allOrdered();
            $featured = Article::getFeatured(3);
        } catch (\Throwable) {
            $articles = [$this->getManifestoFallback()];
        }

        $renderer = new ViewRenderer();
        echo $renderer->render('public.journal.index', [
            'articles' => $articles,
            'categories' => $categories,
            'tags' => $tags,
            'featured' => $featured,
            'search' => '',
            'activeSection' => $type,
            'currentPage' => 1,
            'totalPages' => 1,
            'totalArticles' => count($articles),
            'pageTitle' => $sectionTitle . ' // Journal',
            'metaDesc' => "Transmissions, research notes, and engineering guides under {$sectionTitle}."
        ]);
    }

    public function show(string $slug): void
    {
        $article = null;
        $categories = [];
        $related = [];

        try {
            $article = Article::findBySlug($slug);
        } catch (\Throwable) {
            $article = null;
        }

        if (!$article && ($slug === 'my-ai-manifesto' || $slug === 'ai-manifesto')) {
            $article = $this->getManifestoFallback();
        }

        if (!$article || (($article['status'] ?? 'published') !== 'published' && !isset($_SESSION['user_id']))) {
            throw new HttpException(404, "Transmission '{$slug}' could not be located in journal archives.");
        }

        try {
            $categories = ArticleCategory::withArticleCount();
            $related = Article::getByCategory((int)($article['category_id'] ?? 1), 4);
            $related = array_filter($related, fn($a) => (int)$a['id'] !== (int)($article['id'] ?? 0));
        } catch (\Throwable) {
            $categories = [];
            $related = [];
        }

        $renderer = new ViewRenderer();
        echo $renderer->render('public.journal.show', [
            'article' => $article,
            'categories' => $categories,
            'related' => $related,
            'pageTitle' => ($article['seo_title'] ?: $article['title']) . ' // x64emkei.dev',
            'metaDesc' => $article['seo_description'] ?: ($article['excerpt'] ?: substr(strip_tags($article['content']), 0, 160))
        ]);
    }

    private function getManifestoFallback(): array
    {
        return [
            'id' => 1,
            'author_id' => 1,
            'category_id' => 1,
            'category_name' => 'Systems Architecture & Philosophy',
            'category_slug' => 'systems-architecture',
            'title' => 'My AI Manifesto: A Personal Position on AI, Human Skill, and Responsible Progress',
            'slug' => 'my-ai-manifesto',
            'excerpt' => 'A personal position on AI, human skill, and responsible progress by Michael Benedict Ordenes. Principles guiding learning, craft, professional development, and Filipino technological opportunity.',
            'content' => "# My AI Manifesto: A Personal Position on AI, Human Skill, and Responsible Progress\n\n**Author:** Michael Benedict Ordenes  \n**Source:** AI Manifesto v1.0 section in the portfolio website\n\n---\n\n## PREAMBLE\n\nArtificial intelligence is not a distant future. It is already here, reshaping how we learn, how we build, and how we think about work.\n\nThere is excitement in what AI can accomplish, but there is also a responsibility to understand what should remain distinctly human.\n\nThis manifesto represents the principles that will guide my relationship with AI—not as something to fear or reject, but as something to understand, use responsibly, and keep in its proper place.\n\n---\n\n## I. AI IS A TOOL, NOT A SUBSTITUTE FOR SKILL\n\n- **Principle:** AI should amplify human intelligence, not replace the struggle of learning.\n- **Commitment:** I will not use AI to skip understanding. When AI assists me with code, research, or problem-solving, I must be able to explain, debug, and defend the output without the machine.\n- **Rule of thumb:** If I cannot build it from first principles, I do not yet own the knowledge.\n\n---\n\n## II. TRANSPARENCY IN CREATION\n\n- **Principle:** Honesty about the use of AI builds credibility; hiding it destroys trust.\n- **Commitment:** Where AI significantly contributes to my work—whether code generation, writing assistance, or design ideation—I will be transparent about its role.\n- **Value:** My portfolio represents my growth. Misrepresenting AI output as purely personal craft deceives others and robs me of authentic achievement.\n\n---\n\n## III. CRITICAL SKEPTICISM AS A DEFAULT\n\n- **Principle:** Large language models produce plausible patterns, not verified truth.\n- **Commitment:** I will treat AI outputs as drafts, hypotheses, or suggestions—never as authoritative conclusions. Every line of generated code, every synthesized summary, and every architectural recommendation must be independently verified against documentation, tests, and domain standards.\n\n---\n\n## IV. PRESERVING THE JOY OF PROBLEM-SOLVING\n\n- **Principle:** The deepest satisfaction in engineering comes from solving hard problems through persistent effort.\n- **Commitment:** I will protect my capacity for deep work and analytical struggle. I will not outsource the fun of thinking, designing, and debugging to an algorithm.\n\n---\n\n## V. EMPOWERING THE LOCAL TECH ECOSYSTEM\n\n- **Principle:** AI tools must bridge gaps, not widen digital divides.\n- **Commitment:** As a Filipino developer and student, I will leverage modern computing tools to solve real community problems, share knowledge openly, and mentor peers across local tech ecosystems.\n\n---\n\n*Signed: Michael Benedict Ordenes (x64emkei)*",
            'featured_image' => 'images/carousel-workspace.jpg',
            'seo_title' => 'My AI Manifesto // Michael Benedict Ordenes',
            'seo_description' => 'A personal position on AI, human skill, and responsible progress by Michael Benedict Ordenes.',
            'is_featured' => 1,
            'status' => 'published',
            'published_at' => date('Y-m-d H:i:s'),
            'tags' => ['AI', 'Philosophy', 'Ethics', 'Engineering']
        ];
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
