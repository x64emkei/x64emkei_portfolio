<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleTag;
use App\Models\Profile;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use App\Models\PortfolioSection;
use App\Services\ViewRenderer;
use App\Services\HttpException;
use App\Services\MarkdownRenderer;

class JournalController
{
    private function getCommonData(): array
    {
        $defaultProfile = [
            'full_name' => 'Michael Benedict Ordenes',
            'title' => 'Computer Science Student, IT Enthusiast & Developer',
            'tagline' => 'Architecting resilient software systems and high-performance applications.',
            'bio_short' => 'Computer Science student and systems developer.',
            'bio_full' => '',
            'avatar_url' => 'images/me_2.png',
            'cover_url' => 'images/carousel-workspace.jpg',
            'location' => 'Laguna, Philippines',
            'availability_status' => 'Available for Systems & Web Engineering',
            'resume_url' => '#contact',
            'email' => 'mordenes@acm.org'
        ];

        try { $profile = Profile::get() ?: $defaultProfile; } catch (\Throwable) { $profile = $defaultProfile; }
        try { $settings = SiteSetting::getAllKeyed(); } catch (\Throwable) { $settings = []; }
        try { $socialLinks = SocialLink::getPublished(); } catch (\Throwable) { $socialLinks = []; }
        try { $sections = PortfolioSection::allKeyed(); } catch (\Throwable) { $sections = []; }
        try { $manifestoArticle = Article::getManifesto() ?: self::getManifestoFallback(); } catch (\Throwable) { $manifestoArticle = self::getManifestoFallback(); }

        return [
            'profile' => $profile,
            'settings' => $settings,
            'socialLinks' => $socialLinks,
            'sections' => $sections,
            'manifestoArticle' => $manifestoArticle,
            'activeNav' => 'journal'
        ];
    }
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
            $articles = [];
            $total = 0;
            $categories = [];
            $tags = [];
            $featured = [];
        }

        $totalPages = max(1, (int)ceil($total / $perPage));

        $renderer = new ViewRenderer();
        $data = array_merge($this->getCommonData(), [
            'articles' => $articles,
            'categories' => $categories,
            'tags' => $tags,
            'featured' => $featured,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalArticles' => $total,
            'pageTitle' => 'Journal & Articles // x64emkei.dev',
            'metaDesc' => 'Technical writeups, systems architecture analysis, and software development insights by Michael Benedict Ordenes.'
        ]);
        echo $renderer->render('public.journal.index', $data);
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
            }

            $categories = ArticleCategory::withArticleCount();
            $tags = ArticleTag::allOrdered();
            $featured = Article::getFeatured(3);
        } catch (\Throwable) {
            $articles = [];
        }

        $renderer = new ViewRenderer();
        $data = array_merge($this->getCommonData(), [
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
            'metaDesc' => "Articles, research notes, and engineering guides under {$sectionTitle}."
        ]);
        echo $renderer->render('public.journal.index', $data);
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
            $article = self::getManifestoFallback();
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
        $data = array_merge($this->getCommonData(), [
            'article' => $article,
            'articleContentHtml' => MarkdownRenderer::render((string)($article['content'] ?? '')),
            'categories' => $categories,
            'related' => $related,
            'pageTitle' => ($article['seo_title'] ?: $article['title']) . ' // x64emkei.dev',
            'metaDesc' => $article['seo_description'] ?: ($article['excerpt'] ?: substr(strip_tags($article['content']), 0, 160))
        ]);
        echo $renderer->render('public.journal.show', $data);
    }

    public static function getManifestoFallback(): array
    {
        return [
            'id' => 1,
            'author_id' => 1,
            'category_id' => 1,
            'category_name' => 'Philosophy & Professional Ethics',
            'category_slug' => 'philosophy-ethics',
            'title' => 'My AI Manifesto: A Personal Position on AI, Human Skill, and Responsible Progress',
            'slug' => 'my-ai-manifesto',
            'excerpt' => 'A personal position on AI, human skill, and responsible progress by Michael Benedict Ordenes. Principles guiding learning, craft, professional development, and Filipino technological opportunity.',
            'content' => "# My AI Manifesto: A Personal Position on AI, Human Skill, and Responsible Progress\n\n**Author:** Michael Benedict Ordenes  \n**Source:** AI Manifesto v1.0 section in the portfolio website  \n\n---\n\n## PREAMBLE\n\nArtificial intelligence is becoming part of the way people learn, work, create, and solve problems. As a student preparing for a professional career in technology, its presence is impossible to ignore.\n\nThere is excitement in what AI can accomplish, but there is also a responsibility to understand what should remain distinctly human.\n\nThis manifesto represents the principles that will guide my relationship with AI—not as something to fear or reject, but as something to understand, use responsibly, and keep in its proper place.\n\n---\n\n## I. AI IS A TOOL, NOT A SUBSTITUTE FOR SKILL\n\nAI should remain a tool for developing and extending human capability.\n\nAs a student, learning should not be reduced to asking an AI for an answer. The purpose of education is not simply to produce an output, but to develop the ability to understand, reason, create, solve problems, and make decisions independently.\n\n* **TOOL.ASSIST — Assistance:** AI can help explain a difficult concept, suggest an approach, assist with code, or provide another perspective.\n* **HUMAN.SKILL — Mastery:** Years of studying, practicing, experimenting, failing, and gaining experience cannot be equated to writing an effective prompt in minutes.\n\n> **CORE PRINCIPLE:**  \n> The value of professional skill lies not only in producing an output, but in understanding why it works, whether it is correct, how it can be improved, and what consequences follow from using it.\n\n---\n\n## II. HUMAN CREATIVITY STILL MATTERS\n\nHuman capability enhanced by AI.\n\nMuch of what AI can produce is connected to knowledge and creative work that originated from people. Art, writing, programming, research, engineering, design, and other forms of human work have contributed to the knowledge from which modern AI systems derive their capabilities.\n\n* **CRAFT / TASTE:** A person who has spent years developing a craft possesses something that cannot be reduced to a prompt: experience. That experience shapes judgment, taste, intuition, creativity, and the ability to recognize possibilities that may not be immediately apparent.\n* **MANDATE:** The goal should not be to choose between humans and AI. The goal must be human capability enhanced by AI.\n\n---\n\n## III. AI SHOULD STRENGTHEN PROFESSIONAL DEVELOPMENT\n\nCompetence over dependency.\n\nA strong professional should be capable of working with AI without becoming dependent upon it. That means developing the fundamentals:\n\n1. Understanding the code behind the abstraction.\n2. Understanding the reasoning behind the answer.\n3. Knowing when an AI-generated solution is wrong or hallucinated.\n4. Being able to independently verify and validate information.\n5. Being capable of solving a problem even when the tool is unavailable.\n\n---\n\n## IV. RESPONSIBILITY CANNOT BE AUTOMATED\n\nAccountability remains human.\n\nAI can generate an answer, but it cannot carry professional responsibility for that answer. When AI contributes to a project, the human using it remains responsible for the final result.\n\n> **CRITICAL ETHICAL AXIOM:**  \n> This principle is especially important in professional environments where mistakes can affect people, organizations, finances, privacy, security, or public welfare.\n> \n> AI should therefore be questioned, tested, and verified rather than blindly trusted. The presence of an AI system should never become an excuse for avoiding accountability.\n\n---\n\n## V. TECHNOLOGY SHOULD CREATE OPPORTUNITIES\n\nProgress measured by opportunities created for communities.\n\n### Policy & Investment / PAX Silica\nLarge technological investments such as PAX Silica must create tangible opportunities for workers, students, researchers, and local industries.\n\n* High-quality tech careers and jobs\n* Knowledge and technology transfer\n* Opportunities for Filipino talent\n* Resilient economic growth\n\n> **FILIPINO GUIDING MAXIM:**  \n> *\"Walang dapat agrabyado; lahat dapat may pagkakataong makinabang.\"*\n\n---\n\n## VI. A FUTURE WHERE PEOPLE BECOME MORE CAPABLE\n\nExpanding human capability rather than rendering people disposable.\n\n* **Stale Question:** \"What jobs can be replaced?\"\n* **Generative Question:** \"What new capabilities and opportunities can be created?\"\n\n### Potential Benefits:\n* **Students** → Understand complex concepts deeper\n* **Developers** → Explore solutions and build resilient code\n* **Researchers** → Analyze data and synthesize insights\n* **Citizens** → Benefit from efficient, transparent services\n\n---\n\n## VII. PROGRESS MUST COME WITH RESPONSIBLE GOVERNANCE\n\nDeveloping talent, transparency, and public responsibility.\n\nFor the Philippines, technological development should not simply mean becoming a market for technologies developed elsewhere. It must mean developing Filipino talent and capability.\n\n* **Students** → Opportunities to learn and innovate\n* **Professionals** → Opportunities to work with dignity\n* **Researchers** → Resources to contribute to global science\n* **Communities** → Equitable access to technological benefits\n\nGood governance allows innovation to flourish while ensuring that the benefits of progress reach the people who make that progress possible.\n\n---\n\n## VIII. THE PROFESSIONAL I ASPIRE TO BECOME\n\nCore Principles & Creed\n\n### The Foundation Begins As A Student:\n1. Learn the fundamentals thoroughly.\n2. Develop genuine, independent skills.\n3. Use AI without becoming dependent on it.\n4. Question and verify outputs rigorously.\n5. Use technological knowledge to create opportunities for others.\n\n### x64emkei // CREED:\n* AI should make people more capable, not more disposable.\n* Human skill should be strengthened, not devalued.\n* Technology should create opportunities, not merely eliminate them.\n* Innovation should serve people, not leave them behind.\n* Professional competence should always remain greater than the ability to simply operate a tool.",
            'featured_image' => 'images/carousel-workspace.jpg',
            'seo_title' => 'My AI Manifesto // Michael Benedict Ordenes',
            'seo_description' => 'A personal position on AI, human skill, and responsible progress by Michael Benedict Ordenes.',
            'is_featured' => 1,
            'status' => 'published',
            'published_at' => '2024-03-01 00:00:00',
            'tags' => ['AI Ethics', 'Engineering Philosophy', 'Human Skill', 'Professional Development']
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
        $data = array_merge($this->getCommonData(), [
            'category' => $category,
            'articles' => $articles,
            'categories' => $categories,
            'pageTitle' => "Category: {$category['name']} // Journal",
            'metaDesc' => $category['description'] ?: "Articles categorized under {$category['name']}."
        ]);
        echo $renderer->render('public.journal.category', $data);
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
        $data = array_merge($this->getCommonData(), [
            'tag' => $tag,
            'articles' => $articles,
            'categories' => $categories,
            'pageTitle' => "Tag: {$tag['name']} // Journal",
            'metaDesc' => "Articles tagged with #{$tag['name']}."
        ]);
        echo $renderer->render('public.journal.tag', $data);
    }
}
