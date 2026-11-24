<?php
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
                    <span class="current"><?= strtoupper(e($pageHeading)) ?></span>
                </nav>

                <div style="margin-bottom: 24px;">
                    <a href="<?= url('journal') ?>" class="btn btn-outline btn-sm" style="text-decoration: none;">
                        &larr; // ALL DISPATCHES
                    </a>
                </div>

                <!-- Section Watermark & Header -->
                <div class="section-watermark-num">03</div>
                <div class="section-header">
                    <span class="section-subtitle">// ARCHIVE TELEMETRY &bull; FILTERED INDEX</span>
                    <h2 class="section-title"><?= e($pageHeading) ?></h2>
                    <div class="section-divider"></div>
                </div>

                <?php if (!empty($pageDescription)): ?>
                <div class="bento-card" style="padding: 20px 24px; margin-bottom: 30px;">
                    <p style="color: var(--text-secondary); margin: 0; font-size: var(--font-size-base); line-height: 1.6;">
                        <?= e($pageDescription) ?>
                    </p>
                </div>
                <?php endif; ?>

                <?php if (empty($articles)): ?>
                    <div class="bento-card" style="text-align: center; padding: 48px 24px; margin-bottom: 40px;">
                        <div class="bento-tag" style="justify-content: center; margin-bottom: 12px;">
                            <span class="tag-rec-dot"></span>
                            <span>ARCHIVE // EMPTY</span>
                        </div>
                        <h3 class="bento-heading">No Published Dispatches In This Index</h3>
                        <p style="color: var(--text-secondary); max-width: 500px; margin: 0 auto; line-height: 1.6;">
                            Technical writeups and diagnostics for this topic are currently undergoing review.
                        </p>
                    </div>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column; gap: 18px; margin-bottom: 40px;">
                        <?php foreach ($articles as $art): ?>
                        <article class="bento-card" style="padding: 24px 28px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                <span class="bento-tag" style="margin-bottom: 0;">
                                    <span class="tag-rec-dot"></span>
                                    <span><?= strtoupper(e($art['category'] ?? 'DISPATCH')) ?></span>
                                </span>
                                <span style="font-family: var(--font-mono); font-size: var(--font-size-2xs); color: var(--text-muted);">
                                    <?= e($art['published_at'] ? date('Y.m.d', strtotime($art['published_at'])) : '') ?>
                                </span>
                            </div>
                            <h3 style="font-family: var(--font-display); font-size: var(--font-size-xl); margin: 8px 0 10px 0; color: var(--text-primary);">
                                <a href="<?= url('journal/' . $art['slug']) ?>" style="color: inherit; text-decoration: none;">
                                    <?= e($art['title']) ?>
                                </a>
                            </h3>
                            <p style="color: var(--text-secondary); font-size: var(--font-size-base); line-height: 1.6; margin: 0 0 16px 0;">
                                <?= e($art['excerpt'] ?? '') ?>
                            </p>
                            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border); padding-top: 12px; font-family: var(--font-mono); font-size: var(--font-size-xs);">
                                <a href="<?= url('journal/' . $art['slug']) ?>" style="color: var(--primary); text-decoration: none; font-weight: 600;">
                                    READ DISPATCH &rarr;
                                </a>
                                <span style="color: var(--text-muted);">
                                    <?= e($art['author_name'] ?? 'x64emkei') ?>
                                </span>
                            </div>
                        </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
        <!-- Website Footer Component -->
        <?php require dirname(__DIR__) . '/partials/footer.php'; ?>
    </main>

    <script src="<?= asset('script.js') ?>"></script>
</body>
</html>