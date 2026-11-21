<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($project['title']) ?> // System Dossier &bull; x64emkei</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Outfit:wght@400;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('style.css') ?>">
    <style>
        .dossier-wrap {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 24px 60px 24px;
        }
        .dossier-box {
            background: rgba(14, 18, 26, 0.85);
            border: 1px solid rgba(0, 229, 255, 0.3);
            box-shadow: 0 0 35px rgba(0, 229, 255, 0.08);
            border-radius: 8px;
            overflow: hidden;
            backdrop-filter: blur(12px);
        }
        .dossier-header {
            padding: 28px;
            border-bottom: 1px solid rgba(0, 229, 255, 0.2);
            background: rgba(7, 9, 14, 0.6);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 16px;
        }
        .dossier-title {
            margin: 0 0 8px 0;
            font-size: 1.8rem;
            color: #00e5ff;
            font-family: 'Space Grotesk', sans-serif;
            letter-spacing: 1px;
        }
        .dossier-body {
            padding: 32px;
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 32px;
        }
        @media (max-width: 768px) {
            .dossier-body {
                grid-template-columns: 1fr;
            }
        }
        .dossier-img {
            width: 100%;
            height: auto;
            border-radius: 6px;
            border: 1px solid rgba(0, 229, 255, 0.25);
            margin-bottom: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.5);
        }
        .tech-pill {
            display: inline-block;
            background: rgba(0, 229, 255, 0.1);
            color: #00e5ff;
            border: 1px solid rgba(0, 229, 255, 0.3);
            padding: 4px 10px;
            font-size: 0.75rem;
            border-radius: 4px;
            margin: 0 6px 6px 0;
            font-family: 'JetBrains Mono', monospace;
        }
        .hud-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.2s ease;
        }
        .hud-btn-cyan {
            background: #00e5ff;
            color: #07090e;
            border: 1px solid #00e5ff;
        }
        .hud-btn-cyan:hover {
            box-shadow: 0 0 20px rgba(0, 229, 255, 0.5);
            transform: translateY(-2px);
        }
        .hud-btn-outline {
            background: transparent;
            color: #94a3b8;
            border: 1px solid rgba(148, 163, 184, 0.3);
        }
        .hud-btn-outline:hover {
            color: #fff;
            border-color: #00e5ff;
        }
        .section-label {
            font-size: 0.75rem;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 8px;
            display: block;
        }
    </style>
</head>
<body style="background-color: #07090e; color: #e2e8f0; font-family: 'JetBrains Mono', monospace; margin: 0;">
    <div class="dossier-wrap">
        <div style="margin-bottom: 24px;">
            <a href="<?= e(url('/')) ?>#projects" class="hud-btn hud-btn-outline">
                &larr; // RETURN TO MATRIX
            </a>
        </div>

        <div class="dossier-box">
            <div class="dossier-header">
                <div>
                    <span class="section-label">// PROJECT DOSSIER &bull; <?= e(strtoupper($project['category'])) ?></span>
                    <h1 class="dossier-title"><?= e($project['title']) ?></h1>
                    <div style="color: #64748b; font-size: 0.85rem;">
                        DEPLOYED: <?= e($project['completion_date'] ?: ($project['start_date'] ?: 'Active Production')) ?>
                        &bull; ROLE: <span style="color: #38bdf8;"><?= e($project['role'] ?: 'Lead Systems Architect') ?></span>
                    </div>
                </div>
                <div>
                    <span style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid #10b981; padding: 4px 10px; font-size: 0.75rem; border-radius: 4px; font-weight: bold;">
                        &#9679; <?= strtoupper(e($project['status'])) ?>
                    </span>
                </div>
            </div>

            <div class="dossier-body">
                <div>
                    <?php if (!empty($project['thumbnail_url'])): ?>
                        <img src="<?= e(asset($project['thumbnail_url'])) ?>" alt="<?= e($project['title']) ?>" class="dossier-img">
                    <?php endif; ?>

                    <span class="section-label">// SYSTEM ARCHITECTURE & OVERVIEW</span>
                    <p style="color: #cbd5e1; font-size: 0.92rem; line-height: 1.7; margin-top: 4px;">
                        <?= nl2br(e($project['full_description'] ?: $project['short_description'])) ?>
                    </p>

                    <?php if (!empty($project['contributions'])): ?>
                        <div style="margin-top: 24px;">
                            <span class="section-label">// KEY CONTRIBUTIONS & IMPLEMENTATION</span>
                            <p style="color: #94a3b8; font-size: 0.88rem; line-height: 1.6;">
                                <?= nl2br(e($project['contributions'])) ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>

                <div>
                    <div style="background: rgba(7, 9, 14, 0.7); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 6px; padding: 20px; margin-bottom: 24px;">
                        <span class="section-label">// ACTIVE TELEMETRY LINKS</span>
                        <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 14px;">
                            <?php if (!empty($project['demo_url'])): ?>
                                <a href="<?= e($project['demo_url']) ?>" target="_blank" class="hud-btn hud-btn-cyan">
                                    &#9654; LAUNCH LIVE DEMO &nearr;
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($project['repo_url'])): ?>
                                <a href="<?= e($project['repo_url']) ?>" target="_blank" class="hud-btn hud-btn-outline" style="border-color: rgba(0, 229, 255, 0.3); color: #00e5ff;">
                                    &lt;/&gt; SOURCE REPOSITORY &nearr;
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div style="background: rgba(7, 9, 14, 0.7); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 6px; padding: 20px; margin-bottom: 24px;">
                        <span class="section-label">// SYSTEM SPECIFICATION & TECH STACK</span>
                        <div style="margin-top: 12px;">
                            <?php 
                            $tags = is_array($project['technologies']) 
                                ? $project['technologies'] 
                                : explode(',', (string)($project['technologies'] ?? ''));
                            foreach ($tags as $tag): 
                                $tag = trim($tag);
                                if ($tag === '') continue;
                            ?>
                                <span class="tech-pill"><?= e($tag) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div style="border-top: 1px solid rgba(255, 255, 255, 0.08); padding-top: 20px;">
                        <div style="font-size: 0.8rem; color: #64748b; line-height: 1.5;">
                            SYSTEM RECORD ID: <span style="color: #94a3b8;"><?= e((string)$project['id']) ?></span><br>
                            SLUG: <span style="color: #94a3b8;"><?= e($project['slug']) ?></span><br>
                            AUTHENTICATED BY: <span style="color: #00e5ff;">x64emkei Telemetry Core</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
