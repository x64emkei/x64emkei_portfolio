<?php
$activeSub = $activeSub ?? 'biography';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About & Dossier // Michael Benedict Ordenes (x64emkei)</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('style.css') ?>">
</head>
<body style="background: #07090e; color: #e2e8f0; font-family: 'Outfit', sans-serif; margin: 0;">

    <!-- MASTER HUD PRIMARY NAVIGATION COMPONENT -->
    <?php require __DIR__ . '/partials/header_nav.php'; ?>

    <main class="main-content">
        <div class="view-wrapper">
            <div class="page-container" data-initial-section="<?= e($activeSub) ?>">
                <!-- Breadcrumbs -->
                <nav class="hud-breadcrumb" aria-label="Breadcrumb">
                    <a href="<?= url('/') ?>">HOME</a>
                    <span class="sep">/</span>
                    <a href="<?= url('about') ?>">ABOUT</a>
                    <span class="sep">/</span>
                    <span class="current" id="breadcrumbActiveSection">DOSSIER</span>
                </nav>

                <!-- Page Header -->
                <div style="margin-bottom: 30px; border-bottom: 1px solid rgba(0, 229, 255, 0.2); padding-bottom: 24px;">
                    <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: #00e5ff; letter-spacing: 1px; margin-bottom: 8px;">
                        // OPERATOR PROFILE & QUALIFICATIONS
                    </div>
                    <h1 style="font-family: 'Space Grotesk', sans-serif; font-size: 2.2rem; color: #f8fafc; margin: 0 0 10px 0;">
                        About Michael Benedict Ordenes
                    </h1>
                    <p style="color: #94a3b8; font-size: 0.95rem; margin: 0; line-height: 1.6;">
                        Systems engineering background, academic history, technical stack proficiencies, professional affiliations, and verified credentials.
                    </p>
                </div>

                <!-- Quick Subnav Tabs (Anchor Jumps) -->
                <div class="subnav-tabs" role="tablist" aria-label="About sections">
                    <a href="#biography" class="subnav-btn nav-anchor-link" data-target="biography">Biography</a>
                    <a href="#education" class="subnav-btn nav-anchor-link" data-target="education">Education</a>
                    <a href="#skills" class="subnav-btn nav-anchor-link" data-target="skills">Skills</a>
                    <a href="#experience" class="subnav-btn nav-anchor-link" data-target="experience">Experience & Affiliations</a>
                    <a href="#certifications" class="subnav-btn nav-anchor-link" data-target="certifications">Certifications & Achievements</a>
                </div>

                <!-- SECTION 1: BIOGRAPHY -->
                <section id="biography" class="content-section" data-section-name="Biography">
                    <div class="section-box">
                        <div style="display: flex; gap: 24px; align-items: flex-start; flex-wrap: wrap;">
                            <?php if (!empty($profile['avatar_url'])): ?>
                            <img src="<?= asset($profile['avatar_url']) ?>" alt="<?= e($profile['full_name']) ?>" style="width: 140px; height: 140px; border-radius: 6px; border: 2px solid #00e5ff; object-fit: cover; box-shadow: 0 0 15px rgba(0,229,255,0.2);">
                            <?php endif; ?>
                            <div style="flex: 1; min-width: 280px;">
                                <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #ff3366; margin-bottom: 6px;">[OPERATOR DOSSIER // 01]</div>
                                <h2 style="color: #00e5ff; font-family: 'Space Grotesk', sans-serif; font-size: 1.45rem; margin: 0 0 12px 0;">Personal Background & Identity</h2>
                                <div style="line-height: 1.8; color: #cbd5e1; font-size: 1rem;">
                                    <?= nl2br(e($profile['bio_full'] ?: ($profile['bio_short'] ?: $profile['tagline']))) ?>
                                </div>
                                <div style="margin-top: 20px; display: flex; gap: 12px; flex-wrap: wrap;">
                                    <a href="<?= url('contact#inquiry') ?>" class="subnav-btn" style="color: #00e5ff; border-color: #00e5ff;">Get in Touch &rarr;</a>
                                    <a href="<?= url('journal#ai-manifesto') ?>" class="subnav-btn">Read AI Manifesto &rarr;</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Areas of Focus / Core Competencies -->
                    <div class="section-box" style="margin-top: -10px;">
                        <h3 style="color: #00e5ff; font-family: 'JetBrains Mono', monospace; font-size: 1.05rem; margin-top: 0;">// CORE ENGINEERING PILLARS</h3>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; margin-top: 16px;">
                            <div style="background: rgba(0,0,0,0.3); padding: 16px; border-radius: 4px; border-left: 3px solid #00e5ff;">
                                <div style="color: #f8fafc; font-weight: 700; margin-bottom: 6px;">Software & Systems Development</div>
                                <div style="color: #94a3b8; font-size: 0.88rem; line-height: 1.5;">Modern web applications, desktop programming, relational database modeling, and modular PHP 8.2 backend architectures.</div>
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
                </section>

                <!-- SECTION 2: EDUCATION -->
                <section id="education" class="content-section" data-section-name="Education">
                    <div class="section-box">
                        <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #ff3366; margin-bottom: 6px;">[ACADEMIC BACKGROUND // 02]</div>
                        <h2 style="color: #00e5ff; font-family: 'Space Grotesk', sans-serif; font-size: 1.45rem; margin: 0 0 16px 0;">Education & Academic History</h2>
                        <?php if (empty($education)): ?>
                            <div style="background: rgba(0,0,0,0.25); border: 1px dashed rgba(255,255,255,0.15); padding: 24px; border-radius: 6px; text-align: center; color: #94a3b8;">
                                <h3 style="color: #f8fafc; font-size: 1.15rem; margin: 0 0 8px 0; font-family: 'Space Grotesk', sans-serif;">Bachelor of Science in Computer Science</h3>
                                <p style="margin: 0; font-size: 0.92rem; color: #cbd5e1;">Laguna State Polytechnic University (LSPU) &bull; Santa Cruz Main Campus</p>
                                <p style="margin: 8px 0 0 0; font-size: 0.85rem; color: #64748b; font-family: 'JetBrains Mono', monospace;">Specializing in Software Engineering, Computer Architecture & Algorithms.</p>
                            </div>
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
                </section>

                <!-- SECTION 3: SKILLS -->
                <section id="skills" class="content-section" data-section-name="Skills">
                    <div class="section-box">
                        <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #ff3366; margin-bottom: 6px;">[STACK PROFICIENCIES // 03]</div>
                        <h2 style="color: #00e5ff; font-family: 'Space Grotesk', sans-serif; font-size: 1.45rem; margin: 0 0 16px 0;">Technical Proficiencies & Skills Matrix</h2>
                        <?php if (empty($skillsGrouped)): ?>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
                                <div style="background: rgba(0,0,0,0.3); border: 1px solid rgba(0,229,255,0.15); border-radius: 6px; padding: 16px;">
                                    <h3 style="color: #00e5ff; font-family: 'JetBrains Mono', monospace; font-size: 0.88rem; margin: 0 0 10px 0;">// LANGUAGES</h3>
                                    <p style="color: #cbd5e1; font-size: 0.88rem; margin: 0; line-height: 1.6;">PHP 8.2+, C++, JavaScript (ES6+), SQL, Python, HTML5/CSS3</p>
                                </div>
                                <div style="background: rgba(0,0,0,0.3); border: 1px solid rgba(0,229,255,0.15); border-radius: 6px; padding: 16px;">
                                    <h3 style="color: #ff3366; font-family: 'JetBrains Mono', monospace; font-size: 0.88rem; margin: 0 0 10px 0;">// SYSTEMS & CLOUD</h3>
                                    <p style="color: #cbd5e1; font-size: 0.88rem; margin: 0; line-height: 1.6;">Debian/Ubuntu Linux, Proxmox VE, Docker, MariaDB/MySQL, Cloudflare</p>
                                </div>
                            </div>
                        <?php else: ?>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 24px;">
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
                        <?php endif; ?>
                    </div>
                </section>

                <!-- SECTION 4: EXPERIENCE & AFFILIATIONS -->
                <section id="experience" class="content-section" data-section-name="Experience and Affiliations">
                    <div class="section-box">
                        <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #ff3366; margin-bottom: 6px;">[CAREER & INVOLVEMENTS // 04]</div>
                        <h2 style="color: #00e5ff; font-family: 'Space Grotesk', sans-serif; font-size: 1.45rem; margin: 0 0 16px 0;">Career Experience & Organizational Affiliations</h2>
                        <?php if (empty($experiences)): ?>
                            <div style="background: rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.08); border-radius: 6px; padding: 20px;">
                                <div style="display: flex; justify-content: space-between; align-items: baseline; flex-wrap: wrap; gap: 8px;">
                                    <h3 style="font-size: 1.15rem; color: #f8fafc; margin: 0; font-family: 'Space Grotesk', sans-serif;">Student Member & Technical Contributor</h3>
                                    <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.82rem; color: #00e5ff; background: rgba(0,229,255,0.1); padding: 2px 8px; border-radius: 3px;">2023 &ndash; Present</span>
                                </div>
                                <div style="color: #ff3366; font-size: 0.92rem; font-family: 'JetBrains Mono', monospace; margin: 6px 0 10px 0;">Association for Computing Machinery (ACM)</div>
                                <p style="color: #cbd5e1; font-size: 0.92rem; line-height: 1.6; margin: 0;">Active participant in computing seminars, academic research, and computing ethics explorations.</p>
                            </div>
                        <?php else: ?>
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
                        <?php endif; ?>
                    </div>
                </section>

                <!-- SECTION 5: CERTIFICATIONS & ACHIEVEMENTS -->
                <section id="certifications" class="content-section" data-section-name="Certifications and Achievements">
                    <div class="section-box">
                        <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #ff3366; margin-bottom: 6px;">[VERIFIED CREDENTIALS // 05]</div>
                        <h2 style="color: #00e5ff; font-family: 'Space Grotesk', sans-serif; font-size: 1.45rem; margin: 0 0 16px 0;">Certifications & Verified Credentials</h2>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
                            <?php if (empty($certifications)): ?>
                            <div style="background: rgba(0,0,0,0.3); border: 1px solid rgba(0,229,255,0.2); border-radius: 6px; padding: 20px;">
                                <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #10b981; margin-bottom: 6px;">[VERIFIED CREDENTIAL]</div>
                                <h3 style="font-size: 1.15rem; color: #f8fafc; margin: 0 0 6px 0; font-family: 'Space Grotesk', sans-serif;">Foundational Systems & Cybersecurity Training</h3>
                                <div style="color: #00e5ff; font-family: 'JetBrains Mono', monospace; font-size: 0.85rem; margin-bottom: 10px;">LSPU &bull; Verified Academic Track</div>
                                <p style="color: #94a3b8; font-size: 0.88rem; line-height: 1.5; margin: 0;">Comprehensive foundation in database architectures, network topologies, and systems security.</p>
                            </div>
                            <?php else: ?>
                                <?php foreach ($certifications as $cert): ?>
                                <div style="background: rgba(0,0,0,0.3); border: 1px solid rgba(0,229,255,0.2); border-radius: 6px; padding: 20px;">
                                    <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #10b981; margin-bottom: 6px;">[VERIFIED CREDENTIAL]</div>
                                    <h3 style="font-size: 1.15rem; color: #f8fafc; margin: 0 0 6px 0; font-family: 'Space Grotesk', sans-serif;"><?= e($cert['title']) ?></h3>
                                    <div style="color: #00e5ff; font-family: 'JetBrains Mono', monospace; font-size: 0.85rem; margin-bottom: 10px;">
                                        <?= e($cert['issuer']) ?> &bull; <?= e($cert['issue_date']) ?>
                                    </div>
                                    <p style="color: #94a3b8; font-size: 0.88rem; line-height: 1.5; margin: 0;">
                                        <?= e($cert['credential_summary'] ?? $cert['description'] ?? '') ?>
                                    </p>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
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
                </section>

            </div>
        </div>
        <!-- Website Footer Component -->
        <?php require __DIR__ . '/partials/footer.php'; ?>
    </main>

    <script src="<?= asset('script.js') ?>"></script>
</body>
</html>
