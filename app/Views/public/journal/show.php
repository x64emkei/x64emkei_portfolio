<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= e($metaDesc ?? '') ?>">
    <title><?= e($pageTitle ?? 'Article // x64emkei.dev') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('style.css') ?>">
    <style>
        .reader-container {
            max-width: 860px;
            margin: 0 auto;
            padding: 40px 24px 80px 24px;
        }
        .reader-header {
            margin-bottom: 36px;
            border-bottom: 1px solid rgba(0, 229, 255, 0.2);
            padding-bottom: 24px;
        }
        .reader-badge {
            display: inline-block;
            font-size: 0.78rem;
            font-family: 'JetBrains Mono', monospace;
            padding: 3px 10px;
            border-radius: 4px;
            background: rgba(0, 229, 255, 0.1);
            color: #00e5ff;
            border: 1px solid rgba(0, 229, 255, 0.3);
            margin-bottom: 14px;
            text-decoration: none;
        }
        .reader-title {
            font-size: 2.3rem;
            line-height: 1.25;
            color: #f8fafc;
            margin: 0 0 16px 0;
            font-family: 'Space Grotesk', sans-serif;
        }
        .reader-meta {
            display: flex;
            align-items: center;
            gap: 20px;
            color: #64748b;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85rem;
        }
        .reader-body {
            color: #cbd5e1;
            font-size: 1.05rem;
            line-height: 1.75;
            font-family: 'Outfit', sans-serif;
        }
        .reader-body h2 {
            color: #00e5ff;
            font-size: 1.5rem;
            margin: 36px 0 16px 0;
            font-family: 'Space Grotesk', sans-serif;
            border-bottom: 1px solid rgba(0, 229, 255, 0.15);
            padding-bottom: 8px;
        }
        .reader-body h3 {
            color: #38bdf8;
            font-size: 1.2rem;
            margin: 28px 0 12px 0;
        }
        .reader-body p {
            margin-bottom: 20px;
        }
        .reader-body code {
            font-family: 'JetBrains Mono', monospace;
            background: rgba(0, 229, 255, 0.08);
            color: #00e5ff;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.9em;
        }
        .reader-body pre {
            background: #0e121a;
            border: 1px solid rgba(0, 229, 255, 0.2);
            padding: 16px;
            border-radius: 6px;
            overflow-x: auto;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.88rem;
            color: #e2e8f0;
            margin: 24px 0;
        }
        .reader-body pre code {
            background: transparent;
            padding: 0;
            color: inherit;
        }
        .reader-body blockquote {
            border-left: 3px solid #00e5ff;
            background: rgba(0, 229, 255, 0.03);
            margin: 24px 0;
            padding: 14px 20px;
            color: #94a3b8;
            font-style: italic;
        }
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

    <main class="reader-container">
        <div style="margin-bottom: 24px;">
            <a href="<?= url('journal') ?>" style="color: #64748b; text-decoration: none; font-family: 'JetBrains Mono', monospace; font-size: 0.85rem;">
                &larr; BACK TO TRANSMISSION LOGS
            </a>
        </div>

        <article class="reader-header">
            <?php if (!empty($article['category_name'])): ?>
                <a href="<?= url('journal/category/' . $article['category_slug']) ?>" class="reader-badge">
                    <?= e($article['category_name']) ?>
                </a>
            <?php endif; ?>

            <h1 class="reader-title"><?= e($article['title']) ?></h1>

            <div class="reader-meta">
                <span>📅 Published <?= e(date('F j, Y', strtotime($article['published_at'] ?? $article['created_at']))) ?></span>
                <span>👤 By <?= e($article['author_name'] ?? 'x64emkei') ?></span>
                <?php if (!empty($article['tags'])): ?>
                    <span>🏷️ <?= e(implode(', ', array_column($article['tags'], 'name'))) ?></span>
                <?php endif; ?>
            </div>
        </article>

        <?php if (!empty($article['featured_image'])): ?>
        <div style="margin-bottom: 30px; border-radius: 6px; overflow: hidden; border: 1px solid rgba(0, 229, 255, 0.2);">
            <img src="<?= e($article['featured_image']) ?>" alt="<?= e($article['title']) ?>" style="width: 100%; max-height: 400px; object-fit: cover; display: block;">
        </div>
        <?php endif; ?>

        <div class="reader-body">
            <?= nl2br($article['content']) ?>
        </div>

        <?php if (!empty($related)): ?>
        <section style="margin-top: 60px; padding-top: 30px; border-top: 1px solid rgba(0, 229, 255, 0.15);">
            <h3 style="color: #00e5ff; font-family: 'JetBrains Mono', monospace; font-size: 0.95rem; margin-bottom: 20px;">
                // RELATED TRANSMISSIONS
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px;">
                <?php foreach ($related as $rel): ?>
                <a href="<?= url('journal/' . $rel['slug']) ?>" style="display: block; padding: 16px; background: rgba(14, 18, 26, 0.6); border: 1px solid rgba(0, 229, 255, 0.15); border-radius: 4px; text-decoration: none; color: inherit;">
                    <div style="font-size: 0.75rem; color: #00e5ff; font-family: 'JetBrains Mono', monospace; margin-bottom: 6px;"><?= e($rel['category_name'] ?? 'Journal') ?></div>
                    <div style="font-size: 0.95rem; font-weight: 600; color: #f8fafc; line-height: 1.3;"><?= e($rel['title']) ?></div>
                </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
    </main>

    <footer style="border-top: 1px solid rgba(0, 229, 255, 0.15); padding: 30px 24px; text-align: center; color: #64748b; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem;">
        &copy; <?= date('Y') ?> Michael Benedict Ordenes (x64emkei). Systems Architecture &bull; All Telemetry Active.
    </footer>
</body>
</html>
