<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work & Projects Matrix // x64emkei.dev</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('style.css') ?>">
    <style>
        .work-container { max-width: 1200px; margin: 0 auto; padding: 40px 24px 80px 24px; }
        .project-card {
            background: rgba(14, 18, 26, 0.7);
            border: 1px solid rgba(0, 229, 255, 0.2);
            border-radius: 6px;
            padding: 24px;
            margin-bottom: 24px;
            transition: all 0.2s;
        }
        .project-card:hover {
            border-color: #00e5ff;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 229, 255, 0.12);
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
                <a href="<?= url('work') ?>" style="color: #00e5ff; text-decoration: none; font-weight: 600;">WORK</a>
                <a href="<?= url('journal') ?>" style="color: #94a3b8; text-decoration: none;">JOURNAL</a>
                <a href="<?= url('contact') ?>" style="color: #94a3b8; text-decoration: none;">CONTACT</a>
            </nav>
        </div>
    </header>

    <main class="work-container">
        <div style="margin-bottom: 36px; border-bottom: 1px solid rgba(0, 229, 255, 0.2); padding-bottom: 24px;">
            <div style="font-family: 'JetBrains Mono', monospace; color: #00e5ff; font-size: 0.85rem; margin-bottom: 8px;">// SYSTEMS BUILDS & CASE STUDIES</div>
            <h1 style="font-size: 2.2rem; margin: 0 0 10px 0; font-family: 'Space Grotesk', sans-serif; color: #f8fafc;">Engineering Projects Matrix</h1>
            <p style="color: #94a3b8; font-size: 1rem; margin: 0; max-width: 750px;">
                Engineered solutions spanning enterprise POS systems, hypervisors, vision AI models, zero-trust protocols, and high-performance web applications.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 24px;">
            <?php foreach ($projects as $proj): ?>
            <div class="project-card">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                    <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #00e5ff; background: rgba(0, 229, 255, 0.1); padding: 2px 8px; border-radius: 4px; border: 1px solid rgba(0, 229, 255, 0.2);">
                        <?= e($proj['category'] ?? 'Software') ?>
                    </span>
                    <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #10b981;">
                        ● <?= e($proj['operational_status'] ?? 'Operational') ?>
                    </span>
                </div>

                <h2 style="font-size: 1.35rem; margin: 0 0 8px 0; color: #f8fafc;">
                    <a href="<?= url('project/' . $proj['slug']) ?>" style="color: inherit; text-decoration: none;">
                        <?= e($proj['title']) ?>
                    </a>
                </h2>

                <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.5; margin: 0 0 16px 0;">
                    <?= e($proj['tagline']) ?>
                </p>

                <?php 
                $techs = is_string($proj['technologies_json']) ? json_decode($proj['technologies_json'], true) : $proj['technologies_json'];
                if (!empty($techs) && is_array($techs)):
                ?>
                <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 18px;">
                    <?php foreach ($techs as $tech): ?>
                    <span style="font-size: 0.72rem; font-family: 'JetBrains Mono', monospace; background: rgba(255, 255, 255, 0.05); padding: 2px 6px; border-radius: 3px; color: #cbd5e1;">
                        <?= e($tech) ?>
                    </span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255, 255, 255, 0.06); padding-top: 14px; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem;">
                    <a href="<?= url('project/' . $proj['slug']) ?>" style="color: #00e5ff; text-decoration: none; font-weight: 600;">
                        VIEW DOSSIER &rarr;
                    </a>
                    <?php if (!empty($proj['github_url'])): ?>
                    <a href="<?= e($proj['github_url']) ?>" target="_blank" rel="noopener" style="color: #94a3b8; text-decoration: none;">
                        [SOURCE CODE]
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer style="border-top: 1px solid rgba(0, 229, 255, 0.15); padding: 30px 24px; text-align: center; color: #64748b; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem;">
        &copy; <?= date('Y') ?> Michael Benedict Ordenes (x64emkei). Systems Architecture &bull; All Telemetry Active.
    </footer>
</body>
</html>
