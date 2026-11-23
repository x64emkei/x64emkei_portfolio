<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= e($metaDesc ?? 'Journal & Telemetry Log by Michael Benedict Ordenes') ?>">
    <title><?= e($pageTitle ?? 'Journal // x64emkei.dev') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('style.css') ?>">
    <style>
        .journal-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 24px 80px 24px;
        }
        .journal-hero {
            border-bottom: 1px solid rgba(0, 229, 255, 0.2);
            padding-bottom: 30px;
            margin-bottom: 40px;
        }
        .journal-grid {
            display: grid;
            grid-template-columns: 2.8fr 1.2fr;
            gap: 40px;
        }
        @media (max-width: 900px) {
            .journal-grid {
                grid-template-columns: 1fr;
            }
        }
        .article-card {
            background: rgba(14, 18, 26, 0.7);
            border: 1px solid rgba(0, 229, 255, 0.15);
            border-radius: 6px;
            padding: 24px;
            margin-bottom: 24px;
            transition: transform 0.2s, border-color 0.2s, box-shadow 0.2s;
            position: relative;
        }
        .article-card:hover {
            transform: translateY(-2px);
            border-color: var(--color-cyan, #00e5ff);
            box-shadow: 0 4px 20px rgba(0, 229, 255, 0.12);
        }
        .article-badge {
            display: inline-block;
            font-size: 0.75rem;
            font-family: 'JetBrains Mono', monospace;
            padding: 2px 8px;
            border-radius: 4px;
            background: rgba(0, 229, 255, 0.1);
            color: #00e5ff;
            border: 1px solid rgba(0, 229, 255, 0.3);
            margin-bottom: 12px;
        }
        .article-title {
            margin: 0 0 10px 0;
            font-size: 1.4rem;
            color: #f8fafc;
            line-height: 1.3;
        }
        .article-title a {
            color: inherit;
            text-decoration: none;
        }
        .article-title a:hover {
            color: #00e5ff;
        }
        .article-excerpt {
            color: #94a3b8;
            font-size: 0.92rem;
            line-height: 1.6;
            margin-bottom: 16px;
        }
        .article-meta {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 0.78rem;
            color: #64748b;
            font-family: 'JetBrains Mono', monospace;
        }
        .journal-sidebar-box {
            background: rgba(14, 18, 26, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 24px;
        }
        .sidebar-title {
            font-size: 0.85rem;
            color: #00e5ff;
            font-family: 'JetBrains Mono', monospace;
            margin: 0 0 16px 0;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(0, 229, 255, 0.2);
            padding-bottom: 8px;
        }
        .tag-pill {
            display: inline-block;
            padding: 4px 10px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #cbd5e1;
            font-size: 0.75rem;
            font-family: 'JetBrains Mono', monospace;
            border-radius: 4px;
            text-decoration: none;
            margin: 0 6px 8px 0;
            transition: all 0.2s;
        }
        .tag-pill:hover {
            border-color: #00e5ff;
            color: #00e5ff;
            background: rgba(0, 229, 255, 0.08);
        }
        .nav-link-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #00e5ff;
            text-decoration: none;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85rem;
            font-weight: 600;
        }
    </style>
</head>
<body style="background: #07090e; color: #e2e8f0; font-family: 'Outfit', sans-serif; margin: 0;">

    <!-- Top Primary Navigation Bar -->
    <header style="border-bottom: 1px solid rgba(0, 229, 255, 0.15); background: rgba(14, 18, 26, 0.8); backdrop-filter: blur(10px); position: sticky; top: 0; z-index: 100;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;">
            <a href="<?= url('/') ?>" style="color: #00e5ff; text-decoration: none; font-family: 'JetBrains Mono', monospace; font-size: 1.1rem; font-weight: 700; letter-spacing: 1px;">
                x64emkei<span style="color: #ff3366;">.</span>dev
            </a>
            <nav style="display: flex; gap: 20px; font-family: 'JetBrains Mono', monospace; font-size: 0.85rem;">
                <a href="<?= url('/') ?>" style="color: #94a3b8; text-decoration: none;">HOME</a>
                <a href="<?= url('about') ?>" style="color: #94a3b8; text-decoration: none;">ABOUT</a>
                <a href="<?= url('work') ?>" style="color: #94a3b8; text-decoration: none;">WORK</a>
                <a href="<?= url('journal') ?>" style="color: #00e5ff; text-decoration: none; font-weight: 600;">JOURNAL</a>
                <a href="<?= url('contact') ?>" style="color: #94a3b8; text-decoration: none;">CONTACT</a>
            </nav>
        </div>
    </header>

    <div class="journal-container">
        <!-- Hero Header -->
        <div class="journal-hero">
            <div style="font-family: 'JetBrains Mono', monospace; color: #00e5ff; font-size: 0.82rem; margin-bottom: 8px;">
                // TRANSMISSION LOGS &bull; ARCHITECTURE ESSAYS
            </div>
            <h1 style="font-size: 2.2rem; margin: 0 0 10px 0; font-family: 'Space Grotesk', sans-serif; color: #f8fafc;">
                Engineering Journal & Publishing Platform
            </h1>
            <p style="color: #94a3b8; max-width: 700px; margin: 0; font-size: 1rem; line-height: 1.6;">
                In-depth dissections of low-level systems programming, Ring-0 kernel drivers, zero-trust network architectures, homelab virtualization, and fullstack performance engineering.
            </p>
        </div>

        <div class="journal-grid">
            <!-- Main Content Area -->
            <div>
                <?php if (!empty($search)): ?>
                    <div style="margin-bottom: 24px; padding: 12px 18px; background: rgba(0, 229, 255, 0.05); border: 1px solid rgba(0, 229, 255, 0.2); border-radius: 4px; font-family: 'JetBrains Mono', monospace; font-size: 0.85rem;">
                        Search filter: <strong style="color: #00e5ff;">"<?= e($search) ?>"</strong> &bull; <?= e((string)$totalArticles) ?> result(s) found.
                        <a href="<?= url('journal') ?>" style="color: #ff3366; margin-left: 10px; text-decoration: none;">[CLEAR]</a>
                    </div>
                <?php endif; ?>

                <?php if (empty($articles)): ?>
                    <div style="text-align: center; padding: 60px 20px; background: rgba(14, 18, 26, 0.4); border: 1px dashed rgba(255, 255, 255, 0.1); border-radius: 6px;">
                        <div style="font-size: 2rem; margin-bottom: 12px;">📡</div>
                        <h3 style="color: #f8fafc; margin: 0 0 6px 0;">No Transmissions Logged</h3>
                        <p style="color: #64748b; font-size: 0.9rem; margin: 0;">Telemetry archives currently empty or pending publication.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($articles as $art): ?>
                    <article class="article-card">
                        <?php if (!empty($art['category_name'])): ?>
                            <a href="<?= url('journal/category/' . $art['category_slug']) ?>" class="article-badge" style="text-decoration: none;">
                                <?= e($art['category_name']) ?>
                            </a>
                        <?php endif; ?>
                        
                        <h2 class="article-title">
                            <a href="<?= url('journal/' . $art['slug']) ?>"><?= e($art['title']) ?></a>
                        </h2>

                        <p class="article-excerpt"><?= e($art['excerpt'] ?? substr(strip_tags($art['content']), 0, 160)) ?></p>

                        <div class="article-meta">
                            <span>📅 <?= e(date('M d, Y', strtotime($art['published_at'] ?? $art['created_at']))) ?></span>
                            <span>👤 <?= e($art['author_name'] ?? 'x64emkei') ?></span>
                            <?php if (!empty($art['tags'])): ?>
                                <span>🏷️ <?= e(implode(', ', array_column($art['tags'], 'name'))) ?></span>
                            <?php endif; ?>
                        </div>
                    </article>
                    <?php endforeach; ?>

                    <!-- Pagination -->
                    <?php if ($totalPages > 1): ?>
                    <div style="display: flex; gap: 8px; justify-content: center; margin-top: 36px; font-family: 'JetBrains Mono', monospace;">
                        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                            <a href="<?= url('journal?page=' . $p . ($search ? '&q=' . urlencode($search) : '')) ?>" 
                               style="padding: 6px 12px; border-radius: 4px; text-decoration: none; border: 1px solid <?= ($p === $currentPage) ? '#00e5ff' : 'rgba(255, 255, 255, 0.1)' ?>; color: <?= ($p === $currentPage) ? '#07090e' : '#cbd5e1' ?>; background: <?= ($p === $currentPage) ? '#00e5ff' : 'transparent' ?>;">
                                <?= $p ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <aside>
                <!-- Search Box -->
                <div class="journal-sidebar-box">
                    <div class="sidebar-title">// SEARCH ARCHIVE</div>
                    <form method="GET" action="<?= url('journal') ?>">
                        <input type="text" name="q" value="<?= e($search ?? '') ?>" placeholder="Search dossiers..." 
                               style="width: 100%; padding: 8px 12px; background: #07090e; border: 1px solid rgba(0, 229, 255, 0.2); color: #fff; font-family: inherit; font-size: 0.85rem; border-radius: 4px; box-sizing: border-box;">
                    </form>
                </div>

                <!-- Categories -->
                <div class="journal-sidebar-box">
                    <div class="sidebar-title">// CATEGORIES</div>
                    <ul style="list-style: none; padding: 0; margin: 0; font-family: 'JetBrains Mono', monospace; font-size: 0.82rem;">
                        <?php foreach ($categories as $cat): ?>
                        <li style="margin-bottom: 8px; display: flex; justify-content: space-between;">
                            <a href="<?= url('journal/category/' . $cat['slug']) ?>" style="color: #94a3b8; text-decoration: none;">
                                <?= e($cat['name']) ?>
                            </a>
                            <span style="color: #64748b;">(<?= e((string)($cat['article_count'] ?? 0)) ?>)</span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Tags -->
                <div class="journal-sidebar-box">
                    <div class="sidebar-title">// TELEMETRY TAGS</div>
                    <div>
                        <?php foreach ($tags as $t): ?>
                        <a href="<?= url('journal/tag/' . $t['slug']) ?>" class="tag-pill">#<?= e($t['name']) ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <!-- Minimal HUD Footer -->
    <footer style="border-top: 1px solid rgba(0, 229, 255, 0.15); padding: 30px 24px; text-align: center; color: #64748b; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem;">
        &copy; <?= date('Y') ?> Michael Benedict Ordenes (x64emkei). Systems Architecture &bull; All Telemetry Active.
    </footer>
</body>
</html>
