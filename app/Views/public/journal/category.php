<?php
// Category / Tag Archive View (shares identical aesthetic with tag-level filters)
$pageHeading = isset($category) ? "Category: {$category['name']}" : "Tag: #{$tag['name']}";
$pageDescription = isset($category) ? ($category['description'] ?? '') : "Archived articles filtered by #{$tag['name']}";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Archive // Journal') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Outfit:wght@400;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('style.css') ?>">
    <style>
        .archive-container { max-width: 1000px; margin: 0 auto; padding: 40px 24px 80px 24px; }
        .archive-header { border-bottom: 1px solid rgba(0, 229, 255, 0.2); padding-bottom: 24px; margin-bottom: 36px; }
        .article-card { background: rgba(14, 18, 26, 0.7); border: 1px solid rgba(0, 229, 255, 0.15); border-radius: 6px; padding: 24px; margin-bottom: 20px; }
        .article-card:hover { border-color: #00e5ff; }
    </style>
</head>
<body style="background: #07090e; color: #e2e8f0; font-family: 'Outfit', sans-serif; margin: 0;">
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

    <main class="archive-container">
        <a href="<?= url('journal') ?>" style="color: #64748b; text-decoration: none; font-family: 'JetBrains Mono', monospace; font-size: 0.85rem;">&larr; ALL ARTICLES</a>
        
        <div class="archive-header" style="margin-top: 14px;">
            <h1 style="font-size: 2rem; color: #00e5ff; font-family: 'Space Grotesk', sans-serif; margin: 0 0 8px 0;"><?= e($pageHeading) ?></h1>
            <p style="color: #94a3b8; margin: 0; font-size: 0.95rem;"><?= e($pageDescription) ?></p>
        </div>

        <?php if (empty($articles)): ?>
            <p style="color: #64748b; font-family: 'JetBrains Mono', monospace;">No articles located in this archive index.</p>
        <?php else: ?>
            <?php foreach ($articles as $art): ?>
            <article class="article-card">
                <h2 style="font-size: 1.3rem; margin: 0 0 8px 0; color: #f8fafc;">
                    <a href="<?= url('journal/' . $art['slug']) ?>" style="color: inherit; text-decoration: none;"><?= e($art['title']) ?></a>
                </h2>
                <p style="color: #94a3b8; font-size: 0.92rem; margin: 0 0 14px 0;"><?= e($art['excerpt'] ?? '') ?></p>
                <div style="font-size: 0.78rem; color: #64748b; font-family: 'JetBrains Mono', monospace;">
                    <span>📅 <?= e(date('M d, Y', strtotime($art['published_at'] ?? $art['created_at']))) ?></span>
                    <span style="margin-left: 12px;">👤 <?= e($art['author_name'] ?? 'x64emkei') ?></span>
                </div>
            </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>

    <footer style="border-top: 1px solid rgba(0, 229, 255, 0.15); padding: 30px 24px; text-align: center; color: #64748b; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem;">
        &copy; <?= date('Y') ?> Michael Benedict Ordenes (x64emkei). Systems Architecture &bull; All Telemetry Active.
    </footer>
</body>
</html>
