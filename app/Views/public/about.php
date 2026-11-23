<?php
$activeSub = $activeSub ?? 'biography';

$subTitles = [
    'biography' => 'Biography & Operator Philosophy',
    'education' => 'Education & Academic History',
    'skills' => 'Technical Proficiencies & Stack Matrix',
    'experience' => 'Career Experience & Affiliations',
    'certifications' => 'Certifications & Verified Credentials',
];

$pageSubtitle = $subTitles[$activeSub] ?? 'Operator Dossier';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageSubtitle) ?> // x64emkei.dev</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('style.css') ?>">
    <style>
        .page-container { max-width: 1200px; margin: 0 auto; padding: 30px 24px 80px 24px; }
        .hud-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.78rem;
            color: #64748b;
            margin-bottom: 24px;
        }
        .hud-breadcrumb a { color: #00e5ff; text-decoration: none; }
        .hud-breadcrumb a:hover { text-decoration: underline; }
        .hud-breadcrumb .sep { color: #334155; }
        .hud-breadcrumb .current { color: #f8fafc; font-weight: 600; }
        .subnav-tabs { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 30px; border-bottom: 1px solid rgba(0, 229, 255, 0.15); padding-bottom: 16px; }
        .subnav-btn {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.82rem;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            color: #94a3b8;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(14, 18, 26, 0.6);
            transition: all 0.2s;
        }
        .subnav-btn:hover, .subnav-btn.active {
            color: #00e5ff;
            border-color: #00e5ff;
            background: rgba(0, 229, 255, 0.1);
            box-shadow: 0 0 10px rgba(0, 229, 255, 0.2);
        }
        .section-box {
            background: rgba(14, 18, 26, 0.7);
            border: 1px solid rgba(0, 229, 255, 0.2);
            border-radius: 6px;
            padding: 30px;
            margin-bottom: 30px;
            transition: all 0.2s;
        }
        .section-box:hover {
            border-color: rgba(0, 229, 255, 0.4);
        }
    </style>
</head>
<body style="background: #07090e; color: #e2e8f0; font-family: 'Outfit', sans-serif; margin: 0;">

    <!-- MASTER HUD PRIMARY NAVIGATION COMPONENT -->
    <?php require __DIR__ . '/partials/header_nav.php'; ?>

    <main class="main-content"><div class="view-wrapper">
<main class="page-container">
        <!-- Breadcrumbs -->
        <nav class="hud-breadcrumb" aria-label="Breadcrumb">
            <a href="<?= url('/') ?>">HOME</a>
            <span class="sep">/</span>
            <a href="<?= url('about') ?>">ABOUT</a>
            <span class="sep">/</span>
            <span class="current"><?= strtoupper(e($activeSub)) ?></span>
        </nav>

        <div style="margin-bottom: 30px; border-bottom: 1px solid rgba(0, 229, 255, 0.2); padding-bottom: 24px;">
            <div style="font-family: 'JetBrains Mono', monospace; color: #00e5ff; font-size: 0.85rem; margin-bottom: 8px;">// OPERATOR DOSSIER & BACKGROUND</div>
            <h1 style="font-size: 2.2rem; margin: 0 0 10px 0; font-family: 'Space Grotesk', sans-serif; color: #f8fafc;"><?= e($profile['full_name']) ?></h1>
            <p style="color: #94a3b8; font-size: 1.05rem; margin: 0; max-width: 750px;">
                <?= e($profile['title']) ?> &bull; <?= e($profile['location']) ?> &bull; 
                <span style="color: #10b981; font-family: 'JetBrains Mono', monospace; font-size: 0.85rem;">● <?= e($profile['availability_status']) ?></span>
            </p>
        </div>

        <!-- Sub-Navigation Navigation Tabs (Child Pages) -->
        <div class="subnav-tabs" role="tablist">
            <a href="<?= url('about/biography') ?>" class="subnav-btn <?= $activeSub === 'biography' ? 'active' : '' ?>" role="tab">
                // BIOGRAPHY
            </a>
            <a href="<?= url('about/education') ?>" class="subnav-btn <?= $activeSub === 'education' ? 'active' : '' ?>" role="tab">
                // EDUCATION
            </a>
            <a href="<?= url('about/skills') ?>" class="subnav-btn <?= $activeSub === 'skills' ? 'active' : '' ?>" role="tab">
                // SKILLS
            </a>
            <a href="<?= url('about/experience') ?>" class="subnav-btn <?= $activeSub === 'experience' ? 'active' : '' ?>" role="tab">
                // EXPERIENCE & AFFILIATIONS
            </a>
            <a href="<?= url('about/certifications') ?>" class="subnav-btn <?= $activeSub === 'certifications' ? 'active' : '' ?>" role="tab">
                // CERTIFICATIONS & ACHIEVEMENTS
            </a>
        </div>

        <?php if ($activeSub === 'biography' || $activeSub === 'about'): ?>
            <!-- Biography Card -->
            <div class="section-box">
                <div style="display: flex; gap: 24px; align-items: flex-start; flex-wrap: wrap;">
                    <?php if (!empty($profile['avatar_url'])): ?>
                    <img src="<?= asset($profile['avatar_url']) ?>" alt="<?= e($profile['full_name']) ?>" style="width: 140px; height: 140px; border-radius: 6px; border: 2px solid #00e5ff; object-fit: cover; box-shadow: 0 0 15px rgba(0,229,255,0.2);">
                    <?php endif; ?>
                    <div style="flex: 1; min-width: 280px;">
                        <h2 style="color: #00e5ff; font-family: 'Space Grotesk', sans-serif; font-size: 1.4rem; margin-top: 0;">// PERSONAL BACKGROUND & IDENTITY</h2>
                        <div style="line-height: 1.8; color: #cbd5e1; font-size: 1rem;">
                            <?= nl2br(e($profile['bio_full'] ?: ($profile['bio_short'] ?: $profile['tagline']))) ?>
                        </div>
                        <div style="margin-top: 20px; display: flex; gap: 12px; flex-wrap: wrap;">
                            <a href="<?= url('contact') ?>" class="subnav-btn" style="color: #00e5ff; border-color: #00e5ff;">Get in Touch &rarr;</a>
                            <a href="<?= url('journal/ai-manifesto') ?>" class="subnav-btn">Read AI Manifesto &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Areas of Focus / Core Competencies -->
            <div class="section-box">
                <h3 style="color: #00e5ff; font-family: 'JetBrains Mono', monospace; font-size: 1.1rem; margin-top: 0;">// CORE ENGINEERING PILLARS</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; margin-top: 16px;">
                    <div style="background: rgba(0,0,0,0.3); padding: 16px; border-radius: 4px; border-left: 3px solid #00e5ff;">
                        <div style="color: #f8fafc; font-weight: 700; margin-bottom: 6px;">Software & Systems Development</div>
                        <div style="color: #94a3b8; font-size: 0.88rem; line-height: 1.5;">Modern web applications, desktop programming, relational database modeling, and modular PHP 8.2 backend systems.</div>
                    </div>
                    <div style="background: rgba(0,0,0,0.3); padding: 16px; border-radius: 4px; border-left: 3px solid #ff3366;">
                        <div style="color: #f8fafc; font-weight: 700; margin-bottom: 6px;">Homelab & Infrastructure</div>
                        <div style="color: #94a3b8; font-size: 0.88rem; line-height: 1.5;">Proxmox VE virtualization clusters, Docker microservice stacks, Debian Linux servers, and encrypted mesh overlays via Tailscale.</div>
                    </div>
                    <div style="background: rgba(0,0,0,0.3); padding: 16px; border-radius: 4px; border-left: 3px solid #10b981;">
                        <div style="color: #f8fafc; font-weight: 700; margin-bottom: 6px;">Vintage Hardware & Diagnostics</div>
                        <div style="color: #94a3b8; font-size: 0.88rem; line-height: 1.5;">Component-level hardware restoration, BIOS recovery, legacy operating systems preservation, and diagnostic benchmarking.</div>
                    </div>
                </div>
            </div>

        <?php elseif ($activeSub === 'education'): ?>
            <!-- Education -->
            <div class="section-box">
                <h2 style="color: #00e5ff; font-family: 'Space Grotesk', sans-serif; font-size: 1.4rem; margin-top: 0;">// ACADEMIC INSTITUTIONS & TRAINING</h2>
                <?php if (empty($education)): ?>
                    <p style="color: #64748b;">// NO ACADEMIC RECORDS CURRENTLY STAGED</p>
                <?php else: ?>
                    <?php foreach ($education as $edu): ?>
                    <div style="margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                        <div style="display: flex; justify-content: space-between; align-items: baseline; flex-wrap: wrap; gap: 8px;">
                            <h3 style="font-size: 1.2rem; color: #f8fafc; margin: 0; font-family: 'Space Grotesk', sans-serif;"><?= e($edu['degree']) ?></h3>
                            <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.82rem; color: #00e5ff; background: rgba(0,229,255,0.1); padding: 2px 8px; border-radius: 3px;">
                                <?= e($edu['period']) ?>
                            </span>
                        </div>
                        <div style="color: #ff3366; font-size: 0.95rem; font-family: 'JetBrains Mono', monospace; margin: 6px 0 10px 0;">
                            <?= e($edu['institution']) ?>
                        </div>
                        <p style="color: #cbd5e1; font-size: 0.92rem; line-height: 1.6; margin: 0;">
                            <?= nl2br(e($edu['description'] ?? '')) ?>
                        </p>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        <?php elseif ($activeSub === 'skills'): ?>
            <!-- Skills Matrix -->
            <div class="section-box">
                <h2 style="color: #00e5ff; font-family: 'Space Grotesk', sans-serif; font-size: 1.4rem; margin-top: 0;">// TECHNICAL PROFICIENCIES & STACK</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 24px; margin-top: 20px;">
                    <?php foreach ($skillsGrouped as $category => $skillList): ?>
                    <div style="background: rgba(0,0,0,0.3); border: 1px solid rgba(0,229,255,0.15); border-radius: 6px; padding: 18px;">
                        <h3 style="color: #ff3366; font-family: 'JetBrains Mono', monospace; font-size: 0.9rem; margin: 0 0 14px 0; border-bottom: 1px solid rgba(255,51,102,0.2); padding-bottom: 6px;">
                            // <?= strtoupper(e($category)) ?>
                        </h3>
                        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                            <?php foreach ($skillList as $sk): ?>
                            <span style="background: rgba(0, 229, 255, 0.08); border: 1px solid rgba(0, 229, 255, 0.2); padding: 5px 10px; border-radius: 4px; font-family: 'JetBrains Mono', monospace; font-size: 0.82rem; color: #cbd5e1;">
                                <?= e($sk['name']) ?>
                            </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

        <?php elseif ($activeSub === 'certifications'): ?>
            <!-- Credentials & Certifications & Achievements -->
            <div class="section-box">
                <h2 style="color: #00e5ff; font-family: 'Space Grotesk', sans-serif; font-size: 1.4rem; margin-top: 0;">// CERTIFICATIONS & VERIFIED CREDENTIALS</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; margin-top: 16px;">
                    <?php foreach ($certifications as $cert): ?>
                    <div style="background: rgba(0,0,0,0.3); border: 1px solid rgba(0,229,255,0.2); border-radius: 6px; padding: 20px;">
                        <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #10b981; margin-bottom: 6px;">
                            [VERIFIED CREDENTIAL]
                        </div>
                        <h3 style="font-size: 1.15rem; color: #f8fafc; margin: 0 0 6px 0; font-family: 'Space Grotesk', sans-serif;">
                            <?= e($cert['title']) ?>
                        </h3>
                        <div style="color: #00e5ff; font-family: 'JetBrains Mono', monospace; font-size: 0.85rem; margin-bottom: 10px;">
                            <?= e($cert['issuer']) ?> &bull; <?= e($cert['issue_date']) ?>
                        </div>
                        <p style="color: #94a3b8; font-size: 0.88rem; line-height: 1.5; margin: 0;">
                            <?= e($cert['credential_summary'] ?? $cert['description'] ?? '') ?>
                        </p>
                    </div>
                    <?php endforeach; ?>
                </div>

                <?php if (!empty($achievements)): ?>
                <h3 style="color: #00e5ff; font-family: 'Space Grotesk', sans-serif; font-size: 1.25rem; margin: 30px 0 16px 0;">
                    // HONORS & SPECIAL ACHIEVEMENTS
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
                    <?php foreach ($achievements as $ach): ?>
                    <div style="background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.08); border-radius: 4px; padding: 16px;">
                        <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #ff3366; margin-bottom: 4px;"><?= e($ach['year'] ?? '') ?></div>
                        <div style="font-weight: 700; color: #f8fafc; margin-bottom: 6px;"><?= e($ach['title']) ?></div>
                        <p style="color: #94a3b8; font-size: 0.85rem; line-height: 1.5; margin: 0;"><?= e($ach['description']) ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

        <?php elseif ($activeSub === 'experience'): ?>
            <!-- Experience & Organizational Involvements -->
            <div class="section-box">
                <h2 style="color: #00e5ff; font-family: 'Space Grotesk', sans-serif; font-size: 1.4rem; margin-top: 0;">// CAREER EXPERIENCE & AFFILIATIONS</h2>
                <?php foreach ($experiences as $exp): ?>
                <div style="margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; flex-wrap: wrap; gap: 8px;">
                        <h3 style="font-size: 1.2rem; color: #f8fafc; margin: 0; font-family: 'Space Grotesk', sans-serif;"><?= e($exp['position']) ?></h3>
                        <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.82rem; color: #00e5ff; background: rgba(0,229,255,0.1); padding: 2px 8px; border-radius: 3px;">
                            <?= e($exp['period']) ?>
                        </span>
                    </div>
                    <div style="color: #ff3366; font-size: 0.92rem; font-family: 'JetBrains Mono', monospace; margin: 6px 0 10px 0;">
                        <?= e($exp['company']) ?>
                    </div>
                    <p style="color: #cbd5e1; font-size: 0.92rem; line-height: 1.6; margin: 0;">
                        <?= nl2br(e($exp['description'])) ?>
                    </p>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
    </div></main>

    <footer style="border-top: 1px solid rgba(0, 229, 255, 0.15); padding: 30px 24px; text-align: center; color: #64748b; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem;">
        &copy; <?= date('Y') ?> Michael Benedict Ordenes (x64emkei). Systems Architecture &bull; All Telemetry Active.
    </footer>
</body>
</html>
