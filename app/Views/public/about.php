<?php
// About Child View & Specialized Deep Dives
$secHelper = new \App\Renderers\SectionRenderer($sections ?? []);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($profile['full_name'] ?? 'Michael Benedict Ordenes') ?> // Profile & Background</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('style.css') ?>">
    <style>
        .page-container { max-width: 1200px; margin: 0 auto; padding: 40px 24px 80px 24px; }
        .section-box { background: rgba(14, 18, 26, 0.7); border: 1px solid rgba(0, 229, 255, 0.2); border-radius: 6px; padding: 30px; margin-bottom: 30px; }
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
                <a href="<?= url('about') ?>" style="color: #00e5ff; text-decoration: none; font-weight: 600;">ABOUT</a>
                <a href="<?= url('work') ?>" style="color: #94a3b8; text-decoration: none;">WORK</a>
                <a href="<?= url('journal') ?>" style="color: #94a3b8; text-decoration: none;">JOURNAL</a>
                <a href="<?= url('contact') ?>" style="color: #94a3b8; text-decoration: none;">CONTACT</a>
            </nav>
        </div>
    </header>

    <main class="page-container">
        <div style="margin-bottom: 40px; border-bottom: 1px solid rgba(0, 229, 255, 0.2); padding-bottom: 24px;">
            <div style="font-family: 'JetBrains Mono', monospace; color: #00e5ff; font-size: 0.85rem; margin-bottom: 8px;">// OPERATOR DOSSIER & BACKGROUND</div>
            <h1 style="font-size: 2.2rem; margin: 0 0 10px 0; font-family: 'Space Grotesk', sans-serif; color: #f8fafc;"><?= e($profile['full_name']) ?></h1>
            <p style="color: #94a3b8; font-size: 1.05rem; margin: 0; max-width: 750px;"><?= e($profile['title']) ?> &bull; <?= e($profile['location']) ?></p>
        </div>

        <!-- Biography -->
        <div class="section-box">
            <h2 style="color: #00e5ff; font-family: 'Space Grotesk', sans-serif; font-size: 1.4rem; margin-top: 0;">// BIOGRAPHY & PHILOSOPHY</h2>
            <div style="line-height: 1.7; color: #cbd5e1; font-size: 1rem;">
                <?= nl2br(e($profile['bio_full'] ?: ($profile['bio_short'] ?: $profile['tagline']))) ?>
            </div>
        </div>

        <!-- Experience & Education Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px;">
            <!-- Experience -->
            <div class="section-box">
                <h3 style="color: #00e5ff; font-family: 'JetBrains Mono', monospace; font-size: 1.1rem; margin-top: 0;">// CAREER & EXPERIENCE</h3>
                <?php foreach ($experiences as $exp): ?>
                <div style="margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid rgba(255, 255, 255, 0.06);">
                    <div style="font-weight: 700; color: #f8fafc;"><?= e($exp['position']) ?></div>
                    <div style="color: #00e5ff; font-size: 0.85rem; font-family: 'JetBrains Mono', monospace;"><?= e($exp['company']) ?> &bull; <?= e($exp['period']) ?></div>
                    <p style="color: #94a3b8; font-size: 0.88rem; margin: 8px 0 0 0; line-height: 1.5;"><?= e($exp['description']) ?></p>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Education -->
            <div class="section-box">
                <h3 style="color: #00e5ff; font-family: 'JetBrains Mono', monospace; font-size: 1.1rem; margin-top: 0;">// EDUCATION & ACADEMIA</h3>
                <?php foreach ($education as $edu): ?>
                <div style="margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid rgba(255, 255, 255, 0.06);">
                    <div style="font-weight: 700; color: #f8fafc;"><?= e($edu['degree']) ?></div>
                    <div style="color: #00e5ff; font-size: 0.85rem; font-family: 'JetBrains Mono', monospace;"><?= e($edu['institution']) ?> &bull; <?= e($edu['period']) ?></div>
                    <p style="color: #94a3b8; font-size: 0.88rem; margin: 8px 0 0 0; line-height: 1.5;"><?= e($edu['description'] ?? '') ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Skills Matrix -->
        <div class="section-box" style="margin-top: 10px;">
            <h3 style="color: #00e5ff; font-family: 'JetBrains Mono', monospace; font-size: 1.1rem; margin-top: 0;">// TECHNICAL PROFICIENCIES</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px;">
                <?php foreach ($skillsGrouped as $category => $skillList): ?>
                <div>
                    <h4 style="color: #ff3366; font-family: 'JetBrains Mono', monospace; font-size: 0.85rem; margin: 0 0 10px 0;"><?= e($category) ?></h4>
                    <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                        <?php foreach ($skillList as $sk): ?>
                        <span style="background: rgba(0, 229, 255, 0.08); border: 1px solid rgba(0, 229, 255, 0.2); padding: 4px 10px; border-radius: 4px; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: #cbd5e1;">
                            <?= e($sk['name']) ?>
                        </span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <footer style="border-top: 1px solid rgba(0, 229, 255, 0.15); padding: 30px 24px; text-align: center; color: #64748b; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem;">
        &copy; <?= date('Y') ?> Michael Benedict Ordenes (x64emkei). Systems Architecture &bull; All Telemetry Active.
    </footer>
</body>
</html>
