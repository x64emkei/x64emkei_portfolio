<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= e($project['short_description'] ?? '') ?>">
    <title><?= e($project['title']) ?> // Project Dossier &bull; x64emkei</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('style.css') ?>">
</head>
<body>

    <!-- Unified HUD Navigation (Utility Bar + Sidebar Rail + Mobile Drawer) -->
    <?php require __DIR__ . '/partials/header_nav.php'; ?>

    <main class="main-content">
        <div class="view-wrapper">
            <div class="page-container">
                <!-- Breadcrumbs -->
                <nav class="hud-breadcrumb" aria-label="Breadcrumb">
                    <a href="<?= url('/') ?>">HOME</a>
                    <span class="sep">/</span>
                    <a href="<?= url('work#portfolio') ?>">WORK</a>
                    <span class="sep">/</span>
                    <span class="current"><?= strtoupper(e($project['title'])) ?></span>
                </nav>

                <div style="margin-bottom: 24px;">
                    <a href="<?= url('work#portfolio') ?>" class="btn btn-outline btn-sm" style="text-decoration: none;">
                        &larr; // RETURN TO MATRIX
                    </a>
                </div>

                <!-- Section Watermark & Header -->
                <div class="section-watermark-num">02</div>
                <div class="section-header">
                    <span class="section-subtitle">// SYSTEM DOSSIER &bull; <?= strtoupper(e($project['category'])) ?></span>
                    <h2 class="section-title"><?= e($project['title']) ?></h2>
                    <div class="section-divider"></div>
                </div>

                <!-- Bento Dossier Container -->
                <div class="bento-card" style="padding: 32px 28px; margin-bottom: 40px;">
                    <div class="bento-tag" style="margin-bottom: 20px;">
                        <span class="tag-rec-dot" style="background: var(--primary);"></span>
                        <span>STATUS: <?= strtoupper(e($project['status'])) ?></span>
                        <div class="win-controls">
                            <span class="win-btn">_</span>
                            <span class="win-btn win-close">&times;</span>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 32px;" class="dossier-grid">
                        <div>
                            <?php if (!empty($project['thumbnail_url'])): ?>
                                <div style="border-radius: 4px; overflow: hidden; border: 1px solid var(--border); margin-bottom: 20px; box-shadow: var(--shadow-sm);">
                                    <img src="<?= e(asset($project['thumbnail_url'])) ?>" alt="<?= e($project['title']) ?>" style="width: 100%; height: auto; display: block;">
                                </div>
                            <?php endif; ?>

                            <h3 class="bento-heading" style="font-size: var(--font-size-base); color: var(--primary); margin: 0 0 10px 0;">
                                // ARCHITECTURAL SPECIFICATION &amp; OVERVIEW
                            </h3>
                            <p style="color: var(--text-secondary); font-size: var(--font-size-base); line-height: 1.7; margin: 0 0 20px 0;">
                                <?= nl2br(e($project['full_description'] ?: $project['short_description'])) ?>
                            </p>

                            <?php if (!empty($project['contributions'])): ?>
                                <h3 class="bento-heading" style="font-size: var(--font-size-base); color: var(--primary); margin: 24px 0 10px 0;">
                                    // KEY CONTRIBUTIONS &amp; IMPLEMENTATION
                                </h3>
                                <p style="color: var(--text-secondary); font-size: var(--font-size-sm); line-height: 1.6; margin: 0;">
                                    <?= nl2br(e($project['contributions'])) ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <!-- Action Telemetry Links -->
                            <div class="bento-card" style="padding: 20px; margin-bottom: 20px; background: rgba(9, 11, 16, 0.8);">
                                <h3 class="bento-heading" style="font-size: var(--font-size-sm); color: var(--text-primary); margin: 0 0 14px 0;">
                                    // ACTIVE TELEMETRY LINKS
                                </h3>
                                <div style="display: flex; flex-direction: column; gap: 10px;">
                                    <?php if (!empty($project['demo_url'])): ?>
                                        <a href="<?= e($project['demo_url']) ?>" target="_blank" class="btn btn-primary" style="text-decoration: none; justify-content: center;">
                                            <span>&#9654; LAUNCH LIVE DEMO &nearr;</span>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (!empty($project['repo_url'])): ?>
                                        <a href="<?= e($project['repo_url']) ?>" target="_blank" class="btn btn-outline" style="text-decoration: none; justify-content: center;">
                                            <span>&lt;/&gt; SOURCE REPOSITORY &nearr;</span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Tech Stack Badges -->
                            <div class="bento-card" style="padding: 20px; margin-bottom: 20px; background: rgba(9, 11, 16, 0.8);">
                                <h3 class="bento-heading" style="font-size: var(--font-size-sm); color: var(--text-primary); margin: 0 0 14px 0;">
                                    // TECHNOLOGIES &amp; PROTOCOLS
                                </h3>
                                <div class="skills-badge-list">
                                    <?php 
                                    $tags = is_array($project['technologies']) 
                                        ? $project['technologies'] 
                                        : explode(',', (string)($project['technologies'] ?? ''));
                                    foreach ($tags as $tag): 
                                        $tag = trim($tag);
                                        if ($tag === '') continue;
                                    ?>
                                        <span class="skill-badge"><?= e($tag) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- System Meta Information -->
                            <div style="border-top: 1px solid var(--border); padding-top: 16px; font-family: var(--font-mono); font-size: var(--font-size-xs); color: var(--text-muted); line-height: 1.8;">
                                <div>RECORD ID: <span style="color: var(--text-secondary);"><?= e((string)$project['id']) ?></span></div>
                                <div>SLUG: <span style="color: var(--text-secondary);"><?= e($project['slug']) ?></span></div>
                                <div>ROLE: <span style="color: var(--primary);"><?= e($project['role'] ?: 'Systems Developer') ?></span></div>
                                <div>AUTHENTICATED: <span style="color: var(--accent-green);">x64emkei Telemetry Core</span></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- Website Footer Component -->
        <?php require __DIR__ . '/partials/footer.php'; ?>
    </main>

    <script src="<?= asset('script.js') ?>"></script>
</body>
</html>