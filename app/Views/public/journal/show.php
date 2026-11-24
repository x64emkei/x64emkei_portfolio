<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= e($metaDesc ?? '') ?>">
    <title><?= e($pageTitle ?? 'Dispatch // x64emkei.dev') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('style.css') ?>">
</head>
<body>

    <!-- Unified HUD Navigation (Utility Bar + Sidebar Rail + Mobile Drawer) -->
    <?php require dirname(__DIR__) . '/partials/header_nav.php'; ?>

    <main class="main-content">
        <div class="view-wrapper">
            <div class="page-container">
                <!-- Breadcrumbs -->
                <nav class="hud-breadcrumb" aria-label="Breadcrumb">
                    <a href="<?= url('/') ?>">HOME</a>
                    <span class="sep">/</span>
                    <a href="<?= url('journal') ?>">JOURNAL</a>
                    <span class="sep">/</span>
                    <span class="current"><?= strtoupper(e($article['title'])) ?></span>
                </nav>

                <div style="margin-bottom: 24px;">
                    <a href="<?= url('journal') ?>" class="btn btn-outline btn-sm" style="text-decoration: none;">
                        &larr; // BACK TO FIELD NOTES
                    </a>
                </div>

                <!-- Section Watermark & Header -->
                <div class="section-watermark-num">03</div>
                <div class="section-header">
                    <span class="section-subtitle">// FIELD DISPATCH &bull; <?= strtoupper(e($article['category_name'] ?? 'ENGINEERING LOG')) ?></span>
                    <h2 class="section-title"><?= e($article['title']) ?></h2>
                    <div class="section-divider"></div>
                </div>

                <!-- Article Container -->
                <article class="bento-card" style="padding: 36px 32px; margin-bottom: 40px;">
                    <div class="bento-tag" style="margin-bottom: 20px;">
                        <span class="tag-rec-dot" style="background: var(--primary);"></span>
                        <span><?= strtoupper(e($article['category_name'] ?? 'DISPATCH')) ?></span>
                        <div class="win-controls">
                            <span class="win-btn">_</span>
                            <span class="win-btn win-close">&times;</span>
                        </div>
                    </div>

                    <div style="display: flex; gap: 20px; align-items: center; font-family: var(--font-mono); font-size: var(--font-size-xs); color: var(--text-muted); border-bottom: 1px solid var(--border); padding-bottom: 16px; margin-bottom: 28px; flex-wrap: wrap;">
                        <span>DATE: <?= e(date('Y.m.d', strtotime($article['published_at'] ?? $article['created_at']))) ?></span>
                        <span>AUTHOR: <span style="color: var(--text-primary);"><?= e($article['author_name'] ?? 'Michael Benedict Ordenes') ?></span></span>
                        <?php if (!empty($article['tags'])): ?>
                            <span>TAGS: <span style="color: var(--primary);"><?= is_array($article['tags']) ? (is_string(reset($article['tags'])) ? implode(', ', $article['tags']) : implode(', ', array_column($article['tags'], 'name'))) : e($article['tags']) ?></span></span>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($article['featured_image'])): ?>
                    <div style="margin-bottom: 30px; border-radius: 4px; overflow: hidden; border: 1px solid var(--border);">
                        <img src="<?= e(asset($article['featured_image'])) ?>" alt="<?= e($article['title']) ?>" style="width: 100%; max-height: 440px; object-fit: cover; display: block;">
                    </div>
                    <?php endif; ?>

                    <div class="article-prose" style="color: var(--text-secondary); font-size: 1.05rem; line-height: 1.8; font-family: var(--font-body);">
                        <?= nl2br(e($article['content'])) ?>
                    </div>

                    <?php if (!empty($related)): ?>
                    <div style="margin-top: 48px; padding-top: 24px; border-top: 1px solid var(--border);">
                        <h3 class="bento-heading" style="font-size: var(--font-size-base); color: var(--primary); margin: 0 0 16px 0;">
                            // RELATED DISPATCHES
                        </h3>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
                            <?php foreach ($related as $rel): ?>
                            <a href="<?= url('journal/' . $rel['slug']) ?>" class="bento-card" style="padding: 18px; text-decoration: none; color: inherit; display: block;">
                                <div style="font-size: var(--font-size-2xs); color: var(--primary); font-family: var(--font-mono); margin-bottom: 6px;"><?= e($rel['category_name'] ?? 'Dispatch') ?></div>
                                <div style="font-size: var(--font-size-sm); font-weight: 600; color: var(--text-primary); line-height: 1.4;"><?= e($rel['title']) ?></div>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </article>

            </div>
        </div>
        <!-- Website Footer Component -->
        <?php require dirname(__DIR__) . '/partials/footer.php'; ?>
    </main>

    <script src="<?= asset('script.js') ?>"></script>
</body>
</html>