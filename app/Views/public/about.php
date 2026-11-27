<?php
$activeSub = $activeSub ?? 'biography';
$secHelper = new \App\Renderers\SectionRenderer($sections ?? []);
$secAbout = $secHelper->getSection('about');
$secBio = $secHelper->getSection('biography');
$secEdu = $secHelper->getSection('education');
$secSkills = $secHelper->getSection('skills');
$secExp = $secHelper->getSection('experience');
$secCerts = $secHelper->getSection('certifications');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About &amp; Dossier // <?= e($profile['full_name'] ?? 'Michael Benedict Ordenes') ?> (x64emkei)</title>
    <?php $seoTitle = 'About & Dossier // ' . ($profile['full_name'] ?? 'Michael Benedict Ordenes'); $seoDesc = $profile['bio_short'] ?? 'About Michael Benedict Ordenes: education, technical skills, experience, and credentials.'; require __DIR__ . '/partials/seo_head.php'; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('style.css') ?>">
</head>
<body>
    <a class="skip-link" href="#mainContent">Skip to main content</a>

    <!-- Unified HUD Navigation (Utility Bar + Sidebar Rail + Mobile Drawer) -->
    <?php require __DIR__ . '/partials/header_nav.php'; ?>

    <main class="main-content" id="mainContent" tabindex="-1">
        <div class="view-wrapper">
            <div class="page-container" data-initial-section="<?= e($activeSub) ?>">
                <!-- Breadcrumbs -->
                <nav class="hud-breadcrumb" aria-label="Breadcrumb">
                    <a href="<?= url('/') ?>">HOME</a>
                    <span class="sep">/</span>
                    <a href="<?= url('about') ?>">ABOUT</a>
                    <span class="sep">/</span>
                    <span class="current" id="breadcrumbActiveSection">PROFILE</span>
                </nav>

                <!-- Authentic Section Header with Watermark -->
                <div class="section-watermark-num">01</div>
                <div class="section-header">
                    <span class="section-subtitle">// PROFILE &amp; QUALIFICATIONS</span>
                    <h2 class="section-title"><?= e($secAbout['title'] ?: 'About Me // Dossier') ?></h2>
                    <div class="section-divider"></div>
                </div>

                <!-- Subnav Tabs (Anchor Jumps) -->
                <div class="subnav-tabs" role="tablist" aria-label="About sections">
                    <a href="#biography" class="subnav-btn section-anchor-link active" data-target-section="biography" role="tab">Biography</a>
                    <a href="#education" class="subnav-btn section-anchor-link" data-target-section="education" role="tab">Education</a>
                    <a href="#skills" class="subnav-btn section-anchor-link" data-target-section="skills" role="tab">Technical Skills</a>
                    <a href="#experience" class="subnav-btn section-anchor-link" data-target-section="experience" role="tab">Experience &amp; Leadership</a>
                    <a href="#certifications" class="subnav-btn section-anchor-link" data-target-section="certifications" role="tab">Credentials &amp; Honors</a>
                </div>

                <div class="about-bento-grid">

                    <!-- SECTION 1: BIOGRAPHY (Span 12) -->
                    <section id="biography" class="content-section bento-card bento-bio" data-section-name="Biography" style="grid-column: span 12;">
                        <div class="bio-card-layout">
                            <div class="bio-card-text">
                                <div>
                                    <div class="bento-tag">
                                        <span class="tag-rec-dot"></span>
                                        <span>BIOGRAPHY // PROFILE</span>
                                        <div class="win-controls">
                                            <span class="win-btn">_</span>
                                            <span class="win-btn win-close">&times;</span>
                                        </div>
                                    </div>
                                    <h3 class="bento-heading">Curious mind passionate about systems, code, and hardware.</h3>
                                    <div class="about-text">
                                        <?php if (!empty($profile['bio_full'])): ?>
                                            <?= nl2br(e($profile['bio_full'])) ?>
                                        <?php else: ?>
                                            <p>I’m a Computer Science student interested in software development, IT infrastructure, networking, systems administration, and emerging technologies.</p>
                                            <p style="margin-top: 10px;">I enjoy turning ideas into functional projects and experimenting with both modern and legacy hardware/software.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="bio-card-actions">
                                    <a href="<?= url('contact#inquiry') ?>" class="btn btn-primary" style="text-decoration: none;">
                                        <span>Get In Touch</span>
                                        <svg class="btn-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </a>
                                    <a href="<?= url('journal/ai-manifesto') ?>" class="btn btn-outline" style="text-decoration: none;">
                                        <span class="btn-live-pip"></span>
                                        <span><?= e($manifestoArticle['title'] ?? 'AI Principles') ?></span>
                                        <svg class="btn-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="bio-card-photo-pane">
                                <img src="<?= asset($profile['avatar_url'] ?: 'images/me_2.png') ?>" alt="<?= e($profile['full_name']) ?>" class="bio-flush-photo" loading="lazy">
                                <div class="bio-photo-telemetry">
                                    <span class="tag-pulse"></span>
                                    <span class="bio-photo-label">x64emkei // PROFILE</span>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- SECTION 2: EDUCATION (Span 6) -->
                    <section id="education" class="content-section bento-card bento-edu" data-section-name="Education" style="grid-column: span 6;">
                        <div class="bento-tag">
                            <span class="tag-rec-dot"></span>
                            <span>ACADEMICS // PATHWAY</span>
                            <div class="win-controls">
                                <span class="win-btn">_</span>
                                <span class="win-btn win-close">&times;</span>
                            </div>
                        </div>
                        <h3 class="bento-heading">Education &amp; Credentials</h3>

                        <div class="edu-container">
                            <?php if (empty($education)): ?>
                                <!-- Undergraduate (Default / Staging) -->
                                <div class="edu-entry-card">
                                    <div class="edu-entry-header">
                                        <span class="edu-level-badge">Undergraduate</span>
                                        <span class="edu-status-badge">In Progress</span>
                                    </div>
                                    <div class="edu-degree-title">Bachelor of Science in Computer Science</div>
                                    <div class="edu-school-row">
                                        <svg class="edu-school-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                                            <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                            <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                                        </svg>
                                        <span class="edu-school-name">Laguna College of Business and Arts</span>
                                    </div>
                                </div>

                                <!-- Senior High School -->
                                <div class="edu-entry-card">
                                    <div class="edu-entry-header">
                                        <span class="edu-level-badge">Senior High School</span>
                                        <span class="edu-status-badge edu-status-done">Completed</span>
                                    </div>
                                    <div class="edu-degree-title">Science, Technology, Engineering &amp; Mathematics (STEM)</div>
                                    <div class="edu-school-row">
                                        <svg class="edu-school-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                                            <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                            <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                                        </svg>
                                        <span class="edu-school-name">St. Vincent College of Cabuyao</span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php foreach ($education as $edu): ?>
                                <div class="edu-entry-card">
                                    <div class="edu-entry-header">
                                        <span class="edu-level-badge"><?= e($edu['field_of_study'] ?? 'Academic Track') ?></span>
                                        <span class="edu-status-badge"><?= e($edu['period'] ?? '') ?></span>
                                    </div>
                                    <div class="edu-degree-title"><?= e($edu['degree']) ?></div>
                                    <div class="edu-school-row">
                                        <svg class="edu-school-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                                            <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                            <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                                        </svg>
                                        <span class="edu-school-name"><?= e($edu['institution']) ?></span>
                                    </div>
                                    <?php if (!empty($edu['description'])): ?>
                                    <p style="color: var(--text-secondary); font-size: var(--font-size-xs); margin-top: 6px;">
                                        <?= nl2br(e($edu['description'])) ?>
                                    </p>
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </section>

                    <!-- SECTION 3: SKILLS (Span 6) -->
                    <section id="skills" class="content-section bento-card bento-skills bento-skills-featured" data-section-name="Skills" style="grid-column: span 6;">
                        <div class="featured-header-row">
                            <div class="bento-tag featured-tag">
                                <span class="tag-rec-dot"></span>
                                <span>TECHNOLOGY STACK</span>
                            </div>
                            <div class="featured-indicator">
                                <span class="indicator-pulse-dot"></span>
                                <span>Active Proficiency</span>
                            </div>
                        </div>
                        <h3 class="bento-heading">Technical Skills &amp; Tooling</h3>

                        <div class="skills-simple-container">
                            <?php if (empty($skillsGrouped)): ?>
                                <!-- Group 1: Programming & Scripting -->
                                <div class="skills-group">
                                    <div class="skills-group-header">
                                        <span class="group-code-tag">DEV.01</span>
                                        <h4 class="skills-group-title">Programming &amp; Scripting</h4>
                                    </div>
                                    <div class="skills-badge-list">
                                        <span class="skill-badge">HTML5</span>
                                        <span class="skill-badge">CSS3 / Grid</span>
                                        <span class="skill-badge">JavaScript (ES6+)</span>
                                        <span class="skill-badge">PHP 8.2+</span>
                                        <span class="skill-badge">Python</span>
                                        <span class="skill-badge">C++</span>
                                        <span class="skill-badge">MySQL / MariaDB</span>
                                    </div>
                                </div>

                                <!-- Group 2: Systems, Homelab & Virtualization -->
                                <div class="skills-group">
                                    <div class="skills-group-header">
                                        <span class="group-code-tag tag-sys">SYS.02</span>
                                        <h4 class="skills-group-title">Systems &amp; Virtualization</h4>
                                    </div>
                                    <div class="skills-badge-list">
                                        <span class="skill-badge">Debian / Ubuntu Linux</span>
                                        <span class="skill-badge skill-badge-highlight">Proxmox VE</span>
                                        <span class="skill-badge">Docker Containers</span>
                                        <span class="skill-badge">Tailscale Mesh</span>
                                        <span class="skill-badge">DNS &amp; Routing</span>
                                        <span class="skill-badge">Hardware Diags</span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php foreach ($skillsGrouped as $category => $skillList): ?>
                                <div class="skills-group">
                                    <div class="skills-group-header">
                                        <span class="group-code-tag">// <?= strtoupper(e($category)) ?></span>
                                        <h4 class="skills-group-title"><?= e($category) ?></h4>
                                    </div>
                                    <div class="skills-badge-list">
                                        <?php foreach ($skillList as $sk): ?>
                                        <span class="skill-badge"><?= e($sk['name']) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </section>

                    <!-- SECTION 4: EXPERIENCE & AFFILIATIONS (Span 12) -->
                    <section id="experience" class="content-section bento-card bento-affiliations" data-section-name="Experience and Affiliations" style="grid-column: span 12;">
                        <div class="bento-tag">
                            <span class="tag-rec-dot"></span>
                            <span>INVOLVEMENT // ORGS</span>
                            <div class="win-controls">
                                <span class="win-btn">_</span>
                                <span class="win-btn win-close">&times;</span>
                            </div>
                        </div>
                        <h3 class="bento-heading">Experience, Leadership &amp; Activities</h3>

                        <div class="affiliation-list">
                            <?php if (empty($experiences)): ?>
                                <div class="affiliation-item">
                                    <div class="affiliation-bullet"></div>
                                    <div class="affiliation-details">
                                        <div class="affiliation-name">Alliance of Computer Engineering and Computer Science Students</div>
                                        <div class="affiliation-role">Academic Organization, Secretary</div>
                                    </div>
                                </div>
                                <div class="affiliation-item">
                                    <div class="affiliation-bullet"></div>
                                    <div class="affiliation-details">
                                        <div class="affiliation-name">National Youth Movement for the West Philippine Sea</div>
                                        <div class="affiliation-role">Laguna Chapter Chairperson</div>
                                    </div>
                                </div>
                                <div class="affiliation-item">
                                    <div class="affiliation-bullet"></div>
                                    <div class="affiliation-details">
                                        <div class="affiliation-name">FPJ Youth</div>
                                        <div class="affiliation-role">Director for Communications and Publications</div>
                                    </div>
                                </div>
                                <div class="affiliation-item">
                                    <div class="affiliation-bullet"></div>
                                    <div class="affiliation-details">
                                        <div class="affiliation-name">International Association of Engineers (IAENG)</div>
                                        <div class="affiliation-role">Professional Organization Member</div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php foreach ($experiences as $exp): ?>
                                <div class="affiliation-item">
                                    <div class="affiliation-bullet"></div>
                                    <div class="affiliation-details">
                                        <div class="affiliation-name"><?= e($exp['company']) ?> &mdash; <span style="color: var(--accent-cyan);"><?= e($exp['position']) ?></span></div>
                                        <div class="affiliation-role"><?= e($exp['period']) ?> &bull; <?= e($exp['description']) ?></div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </section>

                    <!-- SECTION 5: CERTIFICATIONS & CREDENTIALS (Span 12) -->
                    <section id="certifications" class="content-section bento-card bento-retro" data-section-name="Certifications and Achievements" style="grid-column: span 12;">
                        <div class="retro-header-row">
                            <div class="bento-tag">
                                <span class="tag-rec-dot"></span>
                                <span>VERIFIED CREDENTIALS // HONORS</span>
                            </div>
                            <div class="retro-indicator">
                                <span class="indicator-pulse-dot"></span>
                                <span>Verified Records</span>
                            </div>
                        </div>
                        <h3 class="bento-heading">Certifications, Credentials &amp; Honors</h3>

                        <div class="edu-cert-list" style="margin-top: 18px;">
                            <?php if (empty($certifications)): ?>
                                <div class="edu-cert-card">
                                    <span class="edu-cert-bullet"></span>
                                    <div class="edu-cert-info">
                                        <span class="edu-cert-name">Certified Six Sigma White Belt</span>
                                        <span class="edu-cert-desc">Continuous Quality Improvement &amp; Process Optimization</span>
                                    </div>
                                </div>
                                <div class="edu-cert-card">
                                    <span class="edu-cert-bullet"></span>
                                    <div class="edu-cert-info">
                                        <span class="edu-cert-name">EF SET English Certificate &mdash; C1 Advanced</span>
                                        <span class="edu-cert-desc">Proficient Professional Technical Communication</span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php foreach ($certifications as $cert): ?>
                                <div class="edu-cert-card">
                                    <span class="edu-cert-bullet"></span>
                                    <div class="edu-cert-info">
                                        <span class="edu-cert-name"><?= e($cert['title']) ?> &mdash; <span style="color: var(--accent-cyan);"><?= e($cert['issuer']) ?></span></span>
                                        <span class="edu-cert-desc"><?= e($cert['issue_date']) ?> &bull; <?= e($cert['credential_summary'] ?? $cert['description'] ?? '') ?></span>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($achievements)): ?>
                        <div style="margin-top: 24px; border-top: 1px solid var(--border); padding-top: 18px;">
                            <h4 style="font-family: var(--font-mono); font-size: var(--font-size-sm); color: var(--accent-amber); margin: 0 0 12px 0;">
                                // HONORS &amp; ACADEMIC RECOGNITION
                            </h4>
                            <div class="affiliation-list">
                                <?php foreach ($achievements as $ach): ?>
                                <div class="affiliation-item">
                                    <div class="affiliation-bullet" style="border-color: var(--accent-amber);"></div>
                                    <div class="affiliation-details">
                                        <div class="affiliation-name"><?= e($ach['title']) ?> (<?= e($ach['year'] ?? '') ?>)</div>
                                        <div class="affiliation-role"><?= e($ach['description']) ?></div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </section>

                </div>
            </div>
        </div>
        <!-- Website Footer Component -->
        <?php require __DIR__ . '/partials/footer.php'; ?>
    </main>

    <script src="<?= asset('script.js') ?>"></script>
</body>
</html>
