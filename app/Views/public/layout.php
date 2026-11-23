<?php
$secHelper = new \App\Renderers\SectionRenderer($sections ?? []);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <script>if(location.protocol==='http:'&&location.hostname!=='localhost'&&location.hostname!=='127.0.0.1'){location.replace('https://'+location.host+location.pathname+location.search+location.hash);}</script>
    <meta name="description" content="<?= e($metaDesc ?? "Michael Benedict Ordenes — Computer Science Student, IT Enthusiast & Developer portfolio.") ?>">
    <title><?= e($metaTitle ?? "Michael Benedict Ordenes | Portfolio") ?></title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- High-Tech Color Sweep & Pixel Dissolve Screen Transition Curtain -->
    <div class="color-sweep-curtain" id="colorSweepCurtain" aria-hidden="true">
        <canvas class="pixel-dissolve-canvas" id="pixelDissolveCanvas"></canvas>
        <div class="sweep-layer sweep-primary"></div>
        <div class="sweep-layer sweep-main">
            <div class="sweep-laser-line"></div>
            <div class="sweep-hud-readout">
                <span class="sweep-pip"></span>
                <span class="sweep-text" id="sweepText">SYS.TRANSITION // INITIALIZING</span>
            </div>
        </div>
    </div>

    <!-- Ambient Dynamic Glow Orbs & Background Atmospheric Effects -->
    <div class="ambient-glow-backdrop" aria-hidden="true">
        <div class="glow-orb orb-primary"></div>
        <div class="glow-orb orb-cyan"></div>
        <div class="glow-orb orb-amber"></div>
        <div class="glow-orb orb-violet"></div>
        <div class="ambient-laser-sweep"></div>
        <div class="ambient-grid-shimmer"></div>
    </div>

    <!-- Mobile Navigation Toggle -->
    <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle navigation menu" aria-expanded="false">
        <span class="hamburger-bar"></span>
        <span class="hamburger-bar"></span>
        <span class="hamburger-bar"></span>
    </button>

    <!-- Sidebar Backdrop for Mobile -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Left Sidebar Navigation -->
    <aside class="sidebar" id="sidebar">
        <!-- Sidebar Brand / Telemetry -->
        <div class="sidebar-brand">
            <div class="brand-telemetry">
                <span class="telemetry-live-dot"></span>
                <span>SYS.ONLINE</span>
                <div class="techno-equalizer" aria-hidden="true">
                    <span class="eq-bar"></span>
                    <span class="eq-bar"></span>
                    <span class="eq-bar"></span>
                    <span class="eq-bar"></span>
                </div>
            </div>
            <h2 class="brand-title">x64emkei<span class="brand-dot">.</span>dev</h2>
            <span class="brand-subtitle"><?= e($profile['full_name'] ?? "Michael Benedict Ordenes") ?></span>
        </div>

        <nav class="sidebar-nav" aria-label="Main Navigation">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="#home" class="nav-link active" data-section="home">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                        <span>Home</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#about" class="nav-link" data-section="about">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="5"/>
                            <path d="M20 21a8 8 0 0 0-16 0"/>
                        </svg>
                        <span>About</span>
                    </a>
                </li>
                <?php if ($secHelper->isVisible('services', $services)): ?>
                <li class="nav-item">
                    <a href="#services" class="nav-link" data-section="services">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="18" x="3" y="3" rx="2"/>
                            <path d="m9 8 6 4-6 4Z"/>
                        </svg>
                        <span>Services</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if ($secHelper->isVisible('projects', $projects)): ?>
                <li class="nav-item">
                    <a href="#portfolio" class="nav-link" data-section="portfolio">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="14" x="2" y="7" rx="2" ry="2"/>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                        </svg>
                        <span>Portfolio</span>
                    </a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a href="#contact" class="nav-link" data-section="contact">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                        <span>Contact</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="sidebar-footer">
            <!-- Telemetry Live HUD Clock (Clickable 12/24H toggle) -->
            <div class="sidebar-telemetry-hud" title="Local System Time (Click to toggle 12/24H mode)">
                <span class="hud-clock-label">SYS.TIME</span>
                <span class="hud-clock-val" id="liveSysClock">--:--:-- --</span>
            </div>

            <!-- AI Manifesto Trigger Button -->
            <button class="btn-manifesto" id="sidebarManifestoBtn" aria-label="Open AI Manifesto">
                <span class="manifesto-hazard">⚡</span>
                <span>AI MANIFESTO</span>
                <span class="manifesto-glitch">v1.0</span>
            </button>

            <!-- Trust Me Button -->
            <a href="#about" class="btn btn-trust-me sidebar-trust-btn nav-trigger" data-target="about">
                <span class="trust-hazard">⚠️</span>
                <span>TRUST ME</span>
                <span class="trust-glitch">// LAB</span>
            </a>

            <!-- Theme Toggle Button -->
            <button class="theme-toggle-btn" id="themeToggle" aria-label="Toggle light/dark theme">
                <span class="theme-icon-container">
                    <svg class="theme-icon icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="5"/>
                        <line x1="12" y1="1" x2="12" y2="3"/>
                        <line x1="12" y1="21" x2="12" y2="23"/>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                        <line x1="1" y1="12" x2="3" y2="12"/>
                        <line x1="21" y1="12" x2="23" y2="12"/>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                    </svg>
                    <svg class="theme-icon icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
                    </svg>
                </span>
                <span class="theme-label" id="themeLabel">Dark Mode</span>
            </button>

            <!-- Social Links -->
            <div class="social-links">
                <a href="https://github.com/x64_emkei" target="_blank" rel="noopener noreferrer" class="social-btn" aria-label="GitHub">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"/>
                        <path d="M9 18c-4.51 2-5-2-7-2"/>
                    </svg>
                </a>
                <a href="https://linkedin.com/in/michael-ordenes/" target="_blank" rel="noopener noreferrer" class="social-btn" aria-label="LinkedIn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/>
                        <rect width="4" height="12" x="2" y="9"/>
                        <circle cx="4" cy="4" r="2"/>
                    </svg>
                </a>
                <a href="mailto:mordenes@acm.org" class="social-btn" aria-label="Email Michael">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect width="20" height="16" x="2" y="4" rx="2"/>
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                    </svg>
                </a>
            </div>
            <p class="copyright-text"><?= e($settings['copyright_text'] ?? "© 2026 Michael Benedict Ordenes. Systems Architecture // All telemetry active.") ?></p>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="main-content">
        <div class="view-wrapper">
            
            <!-- ================= HOME SECTION VIEW ================= -->
            <section id="home" class="page-view active-view" aria-label="Home View">
                <div class="section-watermark-num watermark-home">00</div>
                
                <div class="hero-container">
                    <div class="hero-layout">
                        <!-- Left Column: Content, Terminal, & Focus Bento -->
                        <div class="hero-content">
                            <div class="hero-tag">
                                <span class="tag-pulse"></span>
                                <span><?= e($profile['title'] ?? "CS Student • IT Infrastructure • Systems Builder") ?></span>
                            </div>

                            <h1 class="hero-title">
                                <span class="hero-title-prefix">x64</span><span class="text-gradient">emkei</span>
                            </h1>

                            <p class="hero-subtitle-badge">
                                <?= e($profile['full_name'] ?? "Michael Benedict Ordenes") ?> &bull; <?= e($profile['tagline'] ?? "Computer Science • Systems • Retro Compute") ?>
                            </p>

                            <p class="hero-description">
                                <?= e($profile['bio_short'] ?? "Building resilient software architectures, deploying virtualized server homelabs, and experimenting across the boundary of modern edge systems and vintage computing hardware.") ?>
                            </p>

                            <div class="hero-actions">
                                <a href="#portfolio" class="btn btn-primary nav-trigger" data-target="portfolio">
                                    <span>Explore Portfolio</span>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="5" y1="12" x2="19" y2="12"/>
                                        <polyline points="12 5 19 12 12 19"/>
                                    </svg>
                                </a>
                                <a href="#about" class="btn btn-outline nav-trigger" data-target="about">
                                    <span>About Me</span>
                                </a>
                                <button class="btn btn-manifesto-hero" id="heroManifestoBtn">
                                    <span class="manifesto-hero-dot"></span>
                                    <span>AI Manifesto</span>
                                    <span class="manifesto-hero-badge">READ</span>
                                </button>
                            </div>


                            <!-- Focus Area Cards (2x2 Brutalist Grid with Meta Tags) -->
                            <div class="stats-grid">
                                <div class="stat-card">
                                    <div class="stat-header-row">
                                        <span class="stat-badge">DEV.CORE</span>
                                        <span class="stat-tag-mini">16 BUILDS</span>
                                    </div>
                                    <span class="stat-number">Software</span>
                                    <span class="stat-label">C#, C++, Python, WASM & WebDev</span>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-header-row">
                                        <span class="stat-badge stat-badge-sys">LAB.VIRT</span>
                                        <span class="stat-tag-mini">24/7 ONLINE</span>
                                    </div>
                                    <span class="stat-number">Homelab</span>
                                    <span class="stat-label">Proxmox VE, Debian & Docker</span>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-header-row">
                                        <span class="stat-badge stat-badge-net">NET.MESH</span>
                                        <span class="stat-tag-mini">ENCRYPTED</span>
                                    </div>
                                    <span class="stat-number">Mesh Net</span>
                                    <span class="stat-label">Tailscale, WireGuard & DNS</span>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-header-row">
                                        <span class="stat-badge stat-badge-hw">SYS.ARCHIVE</span>
                                        <span class="stat-tag-mini">6 NODES</span>
                                    </div>
                                    <span class="stat-number">Hardware</span>
                                    <span class="stat-label">Restoration & Legacy Platforms</span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Hero Image Panel (Clip-Path Wipe Reveal) -->
                        <div class="hero-image-panel hero-photo-container" id="heroImagePanel">
                            <div class="hero-image-wrapper hero-photo-wrapper">
                                <img src="images/me.png" 
                                     alt="Portrait of Michael Benedict Ordenes — Computer Science student, systems architect, and software developer in front of custom hardware homelab" 
                                     class="hero-image hero-photo" 
                                     id="heroImage" 
                                     loading="eager">
                                <div class="hero-panel-hud" aria-hidden="true">
                                    <span class="hud-pip"></span>
                                    <span class="hud-text">OPERATOR // x64emkei</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ================= ABOUT SECTION VIEW ================= -->
            <section id="about" class="page-view" aria-label="About View">
                <div class="section-watermark-num">01</div>
                
                <div class="section-header">
                    <span class="section-subtitle">Biography & Background</span>
                    <h2 class="section-title">About Me</h2>
                    <div class="section-divider"></div>
                </div>

                <div class="about-bento-grid">
                    <!-- 1. Bio & Philosophy Bento Card (Span 12) -->
                    <div class="bento-card bento-bio">
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
                                    <h3 class="bento-heading"><?= e($profile['tagline'] ?: "Curious mind passionate about systems, code, and hardware.") ?></h3>
                                    <div class="about-text" style="line-height: 1.7; color: #cbd5e1;">
                                        <?= nl2br(e($profile['bio_full'] ?: $profile['bio_short'])) ?>
                                    </div>
                                </div>
                                <div class="bio-card-actions">
                                    <button class="btn btn-outline" id="aboutManifestoBtn" type="button">
                                        <span class="btn-live-pip"></span>
                                        <span>AI Manifesto v1.0</span>
                                        <svg class="btn-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="bio-card-photo-pane">
                                <img src="<?= e(asset($profile['avatar_url'] ?: "images/me_2.png")) ?>" alt="<?= e($profile['full_name'] ?? "Michael Benedict Ordenes") ?>" class="bio-flush-photo" loading="lazy">
                                <div class="bio-photo-telemetry">
                                    <span class="tag-pulse"></span>
                                    <span class="bio-photo-label">x64emkei // OPERATOR</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Education & Credentials Bento Card (Span 6) -->
                    <div class="bento-card bento-edu">
                        <div class="bento-tag">
                            <span class="tag-rec-dot"></span>
                            <span>ACADEMICS // PATHWAY</span>
                            <div class="win-controls">
                                <span class="win-btn">_</span>
                                <span class="win-btn win-close">&times;</span>
                            </div>
                        </div>
                        <h3 class="bento-heading">Education & Credentials</h3>

                        <div class="edu-container">
                                <?php if (!empty($education)): ?>
                                    <?php foreach ($education as $edu): ?>
                                    <div class="edu-entry-card">
                                        <div class="edu-entry-header">
                                            <span class="edu-level-badge"><?= e($edu['degree']) ?></span>
                                            <span class="edu-status-badge"><?= e($edu['period']) ?></span>
                                        </div>
                                        <div class="edu-degree-title"><?= e($edu['field_of_study']) ?></div>
                                        <div class="edu-school-row">
                                            <svg class="edu-school-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                                <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                                            </svg>
                                            <span class="edu-school-name"><?= e($edu['institution']) ?></span>
                                        </div>
                                        <?php if (!empty($edu['honors'])): ?>
                                            <div style="font-size: 0.78rem; color: #fbbf24; margin-top: 4px;"><?= e($edu['honors']) ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                        <!-- Certifications Sub-block -->
                        <div class="edu-cert-section">
                            <div class="edu-cert-header">
                                <span class="indicator-pulse-dot"></span>
                                <span>Verified Credentials & Honors</span>
                            </div>
                            <div class="edu-cert-list">
                                <?php if (!empty($certifications)): ?>
                                    <?php foreach ($certifications as $cert): ?>
                                    <div class="edu-cert-card">
                                        <span class="edu-cert-bullet"></span>
                                        <div class="edu-cert-info">
                                            <span class="edu-cert-name"><?= e($cert['title']) ?></span>
                                            <span class="edu-cert-desc"><?= e($cert['issuer']) ?> &bull; <?= e($cert['issue_date']) ?></span>
                                            <?php if (!empty($cert['credential_url'])): ?>
                                                <a href="<?= e($cert['credential_url']) ?>" target="_blank" style="color: var(--color-cyan); font-size: 0.72rem; text-decoration: underline;">[VERIFY &nearr;]</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Technical Skills Bento Card (Span 6) -->
                    <div class="bento-card bento-skills bento-skills-featured">
                        <div class="featured-header-row">
                            <div class="bento-tag featured-tag">
                                <span class="tag-rec-dot"></span>
                                <span>SYSTEM ARSENAL // TECH STACK</span>
                            </div>
                            <div class="featured-indicator">
                                <span class="indicator-pulse-dot"></span>
                                <span>Active Proficiency</span>
                            </div>
                        </div>
                        <h3 class="bento-heading">Technical Skills & Tooling</h3>

                        <div class="skills-simple-container">
                                <?php if (!empty($skillsGrouped)): ?>
                                    <?php foreach ($skillsGrouped as $category => $skills): ?>
                                    <div class="skills-group">
                                        <div class="skills-group-header">
                                            <span class="group-code-tag"><?= e(strtoupper(substr($category, 0, 3))) ?></span>
                                            <h4 class="skills-group-title"><?= e($category) ?></h4>
                                        </div>
                                        <div class="skills-badge-list">
                                            <?php foreach ($skills as $s): ?>
                                                <span class="skill-badge">
                                                    <?= e($s['name']) ?>
                                                    <?php if (!empty($s['proficiency_level'])): ?>
                                                        <small style="opacity: 0.65; font-size: 0.7rem; margin-left: 4px;">(<?= e($s['proficiency_level']) ?>)</small>
                                                    <?php endif; ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                    </div>

                    <!-- 4. Academic & Community Affiliations Bento Card (Span 12) -->
                    <div class="bento-card bento-affiliations">
                        <div class="bento-tag">
                            <span class="tag-rec-dot"></span>
                            <span>INVOLVEMENT // ORGS</span>
                            <div class="win-controls">
                                <span class="win-btn">_</span>
                                <span class="win-btn win-close">&times;</span>
                            </div>
                        </div>
                        <h3 class="bento-heading">Experience, Leadership & Activities</h3>

                        <div class="affiliation-list">
                            <?php if (!empty($experiences)): ?>
                                <?php foreach ($experiences as $exp): ?>
                                <div class="affiliation-item">
                                    <div class="affiliation-bullet"></div>
                                    <div class="affiliation-details">
                                        <div class="affiliation-name"><?= e($exp['organization']) ?></div>
                                        <div class="affiliation-role"><?= e($exp['role_title']) ?> &bull; <span style="color: var(--color-cyan);"><?= e($exp['period']) ?></span></div>
                                        <?php if (!empty($exp['description'])): ?>
                                            <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 4px;"><?= nl2br(e($exp['description'])) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Conferred Honors & Achievements Bento Card (Span 12) -->
                    <?php if (!empty($achievements)): ?>
                    <div class="bento-card bento-achievements" style="grid-column: span 12;">
                        <div class="bento-tag">
                            <span class="tag-rec-dot"></span>
                            <span>HONORS // CONFERRED DISTINCTIONS</span>
                        </div>
                        <h3 class="bento-heading"><?= e($secHelper->getSection('achievements')['title'] ?? 'Honors & Distinctions') ?></h3>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 14px; margin-top: 14px;">
                            <?php foreach ($achievements as $ach): ?>
                            <div class="edu-cert-card" style="background: rgba(14, 18, 26, 0.7); padding: 14px; border: 1px solid rgba(0, 229, 255, 0.2); border-radius: 6px;">
                                <span class="edu-cert-bullet"></span>
                                <div class="edu-cert-info">
                                    <span class="edu-cert-name" style="font-size: 0.9rem; color: #f8fafc;"><?= e($ach['title']) ?></span>
                                    <span class="edu-cert-desc" style="color: var(--color-cyan); font-size: 0.75rem; display: block; margin: 3px 0;"><?= e($ach['issuer']) ?> &bull; <?= e($ach['award_date']) ?></span>
                                    <p style="font-size: 0.78rem; color: #94a3b8; margin: 4px 0 0 0;"><?= e($ach['description']) ?></p>
                                    <?php if (!empty($ach['verification_url'])): ?>
                                        <a href="<?= e($ach['verification_url']) ?>" target="_blank" style="color: var(--color-cyan); font-size: 0.72rem; text-decoration: underline; margin-top: 4px; display: inline-block;">[VERIFY &nearr;]</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- 5. Vintage Hardware & Compute Lab (Span 12) -->
                    <div class="bento-card bento-retro">
                        <div class="retro-header-row">
                            <div class="bento-tag">
                                <span class="tag-rec-dot"></span>
                                <span>RETRO HARDWARE LAB // LEGACY ARCHIVE</span>
                            </div>
                            <div class="retro-indicator">
                                <span class="indicator-pulse-dot"></span>
                                <span>6 Operational Nodes</span>
                            </div>
                        </div>
                        <h3 class="bento-heading">Vintage Hardware Diagnostics & Restoration Lab</h3>
                        <p class="retro-subtitle">Hands-on hardware diagnostics, BIOS recovery, and preservation across iconic architectures.</p>

                        <div class="retro-machine-grid">
                            <!-- Machine 1: Sony Vaio W-series VPCW115XG -->
                            <div class="retro-machine-card">
                                <div class="retro-card-top">
                                    <span class="retro-sys-id">NODE.01</span>
                                    <span class="retro-form-tag">Netbook</span>
                                </div>
                                <div class="retro-machine-content">
                                    <div class="retro-machine-name">Sony Vaio W-series VPCW115XG</div>
                                    <div class="retro-machine-desc">Intel Atom N280, 10.1" WXGA (1366&times;768), island keyboard design. Classic Japanese ultraportable engineering.</div>
                                </div>
                                <div class="retro-status-bar">
                                    <span class="retro-status-active"><span class="retro-status-dot"></span>Preserved</span>
                                    <span class="retro-oem-tag">Sony VAIO</span>
                                </div>
                            </div>

                            <!-- Machine 2: Panasonic Lets Note CF-T4GW5AXR -->
                            <div class="retro-machine-card">
                                <div class="retro-card-top">
                                    <span class="retro-sys-id">NODE.02</span>
                                    <span class="retro-form-tag">Toughbook Ultra</span>
                                </div>
                                <div class="retro-machine-content">
                                    <div class="retro-machine-name">Panasonic Let's Note CF-T4GW5AXR</div>
                                    <div class="retro-machine-desc">Intel Pentium M ULV 753, magnesium alloy bonnet chassis, circular optical touchpad, fanless silent architecture.</div>
                                </div>
                                <div class="retro-status-bar">
                                    <span class="retro-status-active"><span class="retro-status-dot"></span>Operational</span>
                                    <span class="retro-oem-tag">Panasonic Japan</span>
                                </div>
                            </div>

                            <!-- Machine 3: HP Compaq nx6320 -->
                            <div class="retro-machine-card">
                                <div class="retro-card-top">
                                    <span class="retro-sys-id">RIG.03</span>
                                    <span class="retro-form-tag">Business Notebook</span>
                                </div>
                                <div class="retro-machine-content">
                                    <div class="retro-machine-name">HP Compaq nx6320</div>
                                    <div class="retro-machine-desc">Intel Core 2 Duo platform, 15.0" 4:3 matte panel, legacy serial & parallel I/O, dedicated hardware diagnostic terminal.</div>
                                </div>
                                <div class="retro-status-bar">
                                    <span class="retro-status-active"><span class="retro-status-dot"></span>Diagnostic Rig</span>
                                    <span class="retro-oem-tag">HP / Compaq</span>
                                </div>
                            </div>

                            <!-- Machine 4: HP Pavilion a6000 sleeper build -->
                            <div class="retro-machine-card retro-card-sleeper">
                                <div class="retro-card-top">
                                    <span class="retro-sys-id">RIG.04</span>
                                    <span class="retro-form-tag tag-sleeper">Sleeper Build</span>
                                </div>
                                <div class="retro-machine-content">
                                    <div class="retro-machine-name">HP Pavilion a6000 (Sleeper)</div>
                                    <div class="retro-machine-desc">Iconic mid-2000s glossy wave-front chassis refitted with high-efficiency modern internals, modular cooling & quiet airflow.</div>
                                </div>
                                <div class="retro-status-bar">
                                    <span class="retro-status-active status-sleeper"><span class="retro-status-dot dot-sleeper"></span>Daily Workstation</span>
                                    <span class="retro-oem-tag">HP Custom Sleeper</span>
                                </div>
                            </div>

                            <!-- Machine 5: Dell Optiplex 3010 Homelab server -->
                            <div class="retro-machine-card">
                                <div class="retro-card-top">
                                    <span class="retro-sys-id">NODE.05</span>
                                    <span class="retro-form-tag">Homelab Server</span>
                                </div>
                                <div class="retro-machine-content">
                                    <div class="retro-machine-name">Dell OptiPlex 3010 Server</div>
                                    <div class="retro-machine-desc">Intel Core host with expanded RAM and gigabit uplink. Configured for 24/7 Proxmox VE, Linux containers & network services.</div>
                                </div>
                                <div class="retro-status-bar">
                                    <span class="retro-status-active"><span class="retro-status-dot"></span>Online // 24/7</span>
                                    <span class="retro-oem-tag">Dell Homelab</span>
                                </div>
                            </div>

                            <!-- Machine 6: Dell Optiplex 760 USFF -->
                            <div class="retro-machine-card">
                                <div class="retro-card-top">
                                    <span class="retro-sys-id">NODE.06</span>
                                    <span class="retro-form-tag">Ultra SFF</span>
                                </div>
                                <div class="retro-machine-content">
                                    <div class="retro-machine-name">Dell OptiPlex 760 USFF</div>
                                    <div class="retro-machine-desc">Ultra-small form factor desktop, Intel Core 2 Duo, low-power compact footprint, headless network test node.</div>
                                </div>
                                <div class="retro-status-bar">
                                    <span class="retro-status-active"><span class="retro-status-dot"></span>Bench Test</span>
                                    <span class="retro-oem-tag">Dell Legacy</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ================= SERVICES SECTION VIEW ================= -->
            <section id="services" class="page-view" aria-label="Services View">
                <div class="section-watermark-num">02</div>
                
                <div class="section-header">
                    <span class="section-subtitle">What I Do</span>
                    <h2 class="section-title">Services & Specialties</h2>
                    <div class="section-divider"></div>
                </div>

                <div class="services-grid">
                    <?php if (!empty($services)): ?>
                        <?php foreach ($services as $srv): 
                            $caps = is_array($srv['capabilities_json']) ? $srv['capabilities_json'] : (json_decode((string)($srv['capabilities_json'] ?? '[]'), true) ?: []);
                        ?>
                        <div class="bento-card service-card">
                            <div class="bento-tag">
                                <span class="tag-rec-dot"></span>
                                <span>// <?= strtoupper(e($srv['category'])) ?></span>
                            </div>
                            <h3 class="service-title"><?= e($srv['title']) ?></h3>
                            <p class="service-description"><?= e($srv['description']) ?></p>
                            <?php if (!empty($caps)): ?>
                                <ul class="service-features">
                                    <?php foreach ($caps as $c): ?>
                                        <li><?= e((string)$c) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>

            <!-- ================= PORTFOLIO SECTION VIEW ================= -->
            <section id="portfolio" class="page-view" aria-label="Portfolio View">
                <div class="section-watermark-num">03</div>
                
                <div class="section-header">
                    <span class="section-subtitle">Featured Work</span>
                    <h2 class="section-title">Projects Showcase</h2>
                    <div class="section-divider"></div>
                </div>

                <?php
$featuredProjects = array_filter($projects ?? [], fn($p) => !empty($p['is_featured']));
$csharpProjects = array_filter($projects ?? [], fn($p) => stripos($p['category'] ?? '', 'csharp') !== false || stripos($p['technologies'] ?? '', 'C#') !== false);
$pythonProjects = array_filter($projects ?? [], fn($p) => stripos($p['category'] ?? '', 'python') !== false || stripos($p['technologies'] ?? '', 'Python') !== false);
$webdevProjects = array_filter($projects ?? [], fn($p) => stripos($p['category'] ?? '', 'web') !== false || stripos($p['technologies'] ?? '', 'PHP') !== false || stripos($p['technologies'] ?? '', 'HTML') !== false);
$cppProjects = array_filter($projects ?? [], fn($p) => stripos($p['category'] ?? '', 'cpp') !== false || stripos($p['technologies'] ?? '', 'C++') !== false);
?>
                <!-- Filter Controls -->
                <div class="portfolio-filter-group" role="tablist" aria-label="Portfolio Category Filter">
                    <button class="filter-btn active" data-filter="featured"><svg class="tech-icon-svg" viewBox="0 0 24 24" fill="#FFB800"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg><span>Featured</span></button>
                    <button class="filter-btn" data-filter="csharp"><svg class="tech-icon-svg" viewBox="0 0 24 24" fill="none"><path d="M12 2L3 7.2v9.6L12 22l9-5.2V7.2L12 2z" stroke="#A855F7" stroke-width="1.8" fill="rgba(168, 85, 247, 0.15)"/><path d="M9.5 8.8c-.9 0-1.8.8-1.8 2.7s.9 2.7 1.8 2.7c.6 0 1.1-.3 1.4-.7" stroke="#A855F7" stroke-width="1.8" stroke-linecap="round"/><path d="M14 9.5v5M16.5 9.5v5M13 11h4.5M13 13h4.5" stroke="#A855F7" stroke-width="1.2" stroke-linecap="round"/></svg><span>C# (.NET)</span></button>
                    <button class="filter-btn" data-filter="python"><svg class="tech-icon-svg" viewBox="0 0 24 24" fill="none"><path d="M11.9 2c-3.1 0-5 .9-5 2.6v2.2h5.1v.7H4.7C3 7.5 2 9.2 2 11.8c0 2.5 1.1 4.2 2.7 4.2h1.6v-2.3c0-1.8 1.5-3.3 3.3-3.3h5.2c1.4 0 2.6-1.1 2.6-2.5V4.6C17.4 3 15.3 2 11.9 2zm-1.8 1.5c.5 0 .9.4.9.9s-.4.9-.9.9-.9-.4-.9-.9.4-.9.9-.9z" fill="#387EB8"/><path d="M12.1 22c3.1 0 5-.9 5-2.6v-2.2H12v-.7h7.3c1.7 0 2.7-1.7 2.7-4.3 0-2.5-1.1-4.2-2.7-4.2h-1.6v2.3c0 1.8-1.5 3.3-3.3 3.3H8.7c-1.4 0-2.6 1.1-2.6 2.5v3.3c0 1.6 2.1 2.6 6 2.6zm1.8-1.5c-.5 0-.9-.4-.9-.9s.4-.9.9-.9.9.4.9.9-.4.9-.9.9z" fill="#FFD43B"/></svg><span>Python</span></button>
                    <button class="filter-btn" data-filter="webdev"><svg class="tech-icon-svg" viewBox="0 0 24 24" fill="none" stroke="#00E5FF" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/><line x1="14" y1="4" x2="10" y2="20"/></svg><span>WebDev</span></button>
                    <button class="filter-btn" data-filter="cpp"><svg class="tech-icon-svg" viewBox="0 0 24 24" fill="none"><path d="M12 2L3 7.2v9.6L12 22l9-5.2V7.2L12 2z" stroke="#00A4EF" stroke-width="1.8" fill="rgba(0, 164, 239, 0.15)"/><path d="M9.5 8.8c-.9 0-1.8.8-1.8 2.7s.9 2.7 1.8 2.7c.6 0 1.1-.3 1.4-.7" stroke="#00A4EF" stroke-width="1.8" stroke-linecap="round"/><path d="M13 12h2.5M14.2 10.7v2.6M17 12h2.5M18.2 10.7v2.6" stroke="#00E5FF" stroke-width="1.3" stroke-linecap="round"/></svg><span>C++</span></button>
                    <button class="filter-btn" data-filter="all"><svg class="tech-icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg><span>All Projects</span></button>
                </div>

                <!-- Primary Featured Programs Grid -->
                <!-- ================= 1. FEATURED PROGRAMS SUBSECTION (ONE-PAGE SMALL CARDS) ================= -->
                <div class="portfolio-subsection featured-programs-section" data-section-category="featured">
                    <div class="portfolio-subsection-header">
                        <div class="subsection-meta-row">
                            <span class="subsection-badge-tag">// FLAGSHIP SYSTEMS ARCHIVE</span>
                            <span class="subsection-counter">6 FEATURED BUILDS</span>
                        </div>
                        <h3 class="portfolio-subsection-title">Featured Flagship Applications</h3>
                        <p class="portfolio-subsection-desc">Selected high-impact software systems demonstrating low-level kernel routines, real-time edge intelligence, and distributed architectures.</p>
                    </div>

                    
                    <div class="featured-programs-grid programs-grid-sm">
                        <?php if (!empty($featuredProjects)): ?>
                            <?php foreach ($featuredProjects as $p): ?>
                            <article class="program-card program-card-sm" data-category="featured <?= e($p['category']) ?>" data-project-id="<?= e($p['slug']) ?>">
                                <div class="program-card-header">
                                    <div class="program-tags-group">
                                        <span class="program-lang-tag"><?= e(strtoupper($p['category'])) ?></span>
                                        <span class="program-id-badge">ID.<?= e(str_pad((string)$p['id'], 3, '0', STR_PAD_LEFT)) ?></span>
                                    </div>
                                    <?php if (!empty($p['is_featured'])): ?>
                                        <span class="program-featured-star">★ FEATURED</span>
                                    <?php endif; ?>
                                </div>
                                <div class="program-card-body">
                                    <h4 class="program-title"><?= e($p['title']) ?></h4>
                                    <p class="program-desc"><?= e($p['short_description']) ?></p>
                                    <div class="program-compact-meta">
                                        <div class="program-tech-tags">
                                            <?php 
                                            $techs = is_array($p['technologies']) ? $p['technologies'] : explode(',', (string)($p['technologies'] ?? ''));
                                            foreach (array_slice($techs, 0, 3) as $t):
                                                $t = trim($t);
                                                if ($t === '') continue;
                                            ?>
                                                <span class="skill-badge"><?= e($t) ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                        <span class="program-metric-badge"><?= e(strtoupper($p['status'])) ?></span>
                                    </div>
                                </div>
                                <div class="program-card-footer" style="display: flex; gap: 8px;">
                                    <button class="btn btn-primary btn-sm btn-inspect-project" data-project-id="<?= e($p['slug']) ?>" type="button">Inspect</button>
                                    <a href="<?= e(url('project/' . $p['slug'])) ?>" class="btn btn-outline btn-sm" style="text-decoration: none;">Dossier &nearr;</a>
                                </div>
                            </article>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div style="grid-column: 1/-1; padding: 20px; text-align: center; color: #64748b;">
                                // NO TELEMETRY COMMITTED TO THIS ARCHIVE CATEGORY
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- ================= 2. C# SUBSECTION ================= -->
                <div class="portfolio-subsection is-filtered-out" data-section-category="csharp">
                    <div class="portfolio-subsection-header">
                        <div class="subsection-meta-row">
                            <span class="subsection-badge-tag">// ENTERPRISE .NET PLATFORMS</span>
                            <span class="subsection-counter"><?= count($csharpProjects) ?> COMMITTED BUILDS</span>
                        </div>
                        <h3 class="portfolio-subsection-title">C# &bull; Systems & Desktop Engineering</h3>
                        <p class="portfolio-subsection-desc">High-performance Windows enterprise clients, autonomous POS retail engines, and hardware driver telemetry bridges.</p>
                    </div>
                    <div class="featured-programs-grid programs-grid-sm">
                        <?php if (!empty($csharpProjects)): ?>
                            <?php foreach ($csharpProjects as $p): ?>
                            <article class="program-card program-card-sm" data-category="csharp <?= e($p['category']) ?>" data-project-id="<?= e($p['slug']) ?>">
                                <div class="program-card-header">
                                    <div class="program-tags-group">
                                        <span class="program-lang-tag"><?= e(strtoupper($p['category'])) ?></span>
                                        <span class="program-id-badge">ID.<?= e(str_pad((string)$p['id'], 3, '0', STR_PAD_LEFT)) ?></span>
                                    </div>
                                    <?php if (!empty($p['is_featured'])): ?>
                                        <span class="program-featured-star">★ FEATURED</span>
                                    <?php endif; ?>
                                </div>
                                <div class="program-card-body">
                                    <h4 class="program-title"><?= e($p['title']) ?></h4>
                                    <p class="program-desc"><?= e($p['short_description']) ?></p>
                                    <div class="program-compact-meta">
                                        <div class="program-tech-tags">
                                            <?php 
                                            $techs = is_array($p['technologies']) ? $p['technologies'] : explode(',', (string)($p['technologies'] ?? ''));
                                            foreach (array_slice($techs, 0, 3) as $t):
                                                $t = trim($t);
                                                if ($t === '') continue;
                                            ?>
                                                <span class="skill-badge"><?= e($t) ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                        <span class="program-metric-badge"><?= e(strtoupper($p['status'])) ?></span>
                                    </div>
                                </div>
                                <div class="program-card-footer" style="display: flex; gap: 8px;">
                                    <button class="btn btn-primary btn-sm btn-inspect-project" data-project-id="<?= e($p['slug']) ?>" type="button">Inspect</button>
                                    <a href="<?= e(url('project/' . $p['slug'])) ?>" class="btn btn-outline btn-sm" style="text-decoration: none;">Dossier &nearr;</a>
                                </div>
                            </article>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div style="grid-column: 1/-1; padding: 20px; text-align: center; color: #64748b;">
                                // NO TELEMETRY COMMITTED TO THIS ARCHIVE CATEGORY
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- ================= 3. PYTHON SUBSECTION ================= -->
                <div class="portfolio-subsection is-filtered-out" data-section-category="python">
                    <div class="portfolio-subsection-header">
                        <div class="subsection-meta-row">
                            <span class="subsection-badge-tag">// AI & DISTRIBUTED DATA ENGINES</span>
                            <span class="subsection-counter"><?= count($pythonProjects) ?> ACTIVE DEPLOYS</span>
                        </div>
                        <h3 class="portfolio-subsection-title">Python &bull; AI, Automation & Network Daemons</h3>
                        <p class="portfolio-subsection-desc">High-throughput asynchronous scraping daemons, PyTorch computer vision networks, and distributed messaging bots.</p>
                    </div>
                    <div class="featured-programs-grid programs-grid-sm">
                        <?php if (!empty($pythonProjects)): ?>
                            <?php foreach ($pythonProjects as $p): ?>
                            <article class="program-card program-card-sm" data-category="python <?= e($p['category']) ?>" data-project-id="<?= e($p['slug']) ?>">
                                <div class="program-card-header">
                                    <div class="program-tags-group">
                                        <span class="program-lang-tag"><?= e(strtoupper($p['category'])) ?></span>
                                        <span class="program-id-badge">ID.<?= e(str_pad((string)$p['id'], 3, '0', STR_PAD_LEFT)) ?></span>
                                    </div>
                                    <?php if (!empty($p['is_featured'])): ?>
                                        <span class="program-featured-star">★ FEATURED</span>
                                    <?php endif; ?>
                                </div>
                                <div class="program-card-body">
                                    <h4 class="program-title"><?= e($p['title']) ?></h4>
                                    <p class="program-desc"><?= e($p['short_description']) ?></p>
                                    <div class="program-compact-meta">
                                        <div class="program-tech-tags">
                                            <?php 
                                            $techs = is_array($p['technologies']) ? $p['technologies'] : explode(',', (string)($p['technologies'] ?? ''));
                                            foreach (array_slice($techs, 0, 3) as $t):
                                                $t = trim($t);
                                                if ($t === '') continue;
                                            ?>
                                                <span class="skill-badge"><?= e($t) ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                        <span class="program-metric-badge"><?= e(strtoupper($p['status'])) ?></span>
                                    </div>
                                </div>
                                <div class="program-card-footer" style="display: flex; gap: 8px;">
                                    <button class="btn btn-primary btn-sm btn-inspect-project" data-project-id="<?= e($p['slug']) ?>" type="button">Inspect</button>
                                    <a href="<?= e(url('project/' . $p['slug'])) ?>" class="btn btn-outline btn-sm" style="text-decoration: none;">Dossier &nearr;</a>
                                </div>
                            </article>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div style="grid-column: 1/-1; padding: 20px; text-align: center; color: #64748b;">
                                // NO TELEMETRY COMMITTED TO THIS ARCHIVE CATEGORY
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- ================= 4. WEBDEV SUBSECTION ================= -->
                <div class="portfolio-subsection is-filtered-out" data-section-category="webdev">
                    <div class="portfolio-subsection-header">
                        <div class="subsection-meta-row">
                            <span class="subsection-badge-tag">// FRONTEND & CMS ENGINES</span>
                            <span class="subsection-counter"><?= count($webdevProjects) ?> WEB PLATFORMS</span>
                        </div>
                        <h3 class="portfolio-subsection-title">WebDev &bull; HTML &bull; CSS &bull; JS &bull; PHP</h3>
                        <p class="portfolio-subsection-desc">Browser experiences, custom CMS architectures, and responsive developer showcases.</p>
                    </div>
                    <div class="featured-programs-grid programs-grid-sm">
                        <?php if (!empty($webdevProjects)): ?>
                            <?php foreach ($webdevProjects as $p): ?>
                            <article class="program-card program-card-sm" data-category="webdev <?= e($p['category']) ?>" data-project-id="<?= e($p['slug']) ?>">
                                <div class="program-card-header">
                                    <div class="program-tags-group">
                                        <span class="program-lang-tag"><?= e(strtoupper($p['category'])) ?></span>
                                        <span class="program-id-badge">ID.<?= e(str_pad((string)$p['id'], 3, '0', STR_PAD_LEFT)) ?></span>
                                    </div>
                                    <?php if (!empty($p['is_featured'])): ?>
                                        <span class="program-featured-star">★ FEATURED</span>
                                    <?php endif; ?>
                                </div>
                                <div class="program-card-body">
                                    <h4 class="program-title"><?= e($p['title']) ?></h4>
                                    <p class="program-desc"><?= e($p['short_description']) ?></p>
                                    <div class="program-compact-meta">
                                        <div class="program-tech-tags">
                                            <?php 
                                            $techs = is_array($p['technologies']) ? $p['technologies'] : explode(',', (string)($p['technologies'] ?? ''));
                                            foreach (array_slice($techs, 0, 3) as $t):
                                                $t = trim($t);
                                                if ($t === '') continue;
                                            ?>
                                                <span class="skill-badge"><?= e($t) ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                        <span class="program-metric-badge"><?= e(strtoupper($p['status'])) ?></span>
                                    </div>
                                </div>
                                <div class="program-card-footer" style="display: flex; gap: 8px;">
                                    <button class="btn btn-primary btn-sm btn-inspect-project" data-project-id="<?= e($p['slug']) ?>" type="button">Inspect</button>
                                    <a href="<?= e(url('project/' . $p['slug'])) ?>" class="btn btn-outline btn-sm" style="text-decoration: none;">Dossier &nearr;</a>
                                </div>
                            </article>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div style="grid-column: 1/-1; padding: 20px; text-align: center; color: #64748b;">
                                // NO TELEMETRY COMMITTED TO THIS ARCHIVE CATEGORY
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- ================= 5. C++ SUBSECTION ================= -->
                <div class="portfolio-subsection is-filtered-out" data-section-category="cpp">
                    <div class="portfolio-subsection-header">
                        <div class="subsection-meta-row">
                            <span class="subsection-badge-tag">// KERNEL ARCHITECTURE & HARDWARE</span>
                            <span class="subsection-counter"><?= count($cppProjects) ?> SYSTEM BUILDS</span>
                        </div>
                        <h3 class="portfolio-subsection-title">C++ &bull; Low-Level Hardware & Systems Architecture</h3>
                        <p class="portfolio-subsection-desc">Bare-metal microkernels, lock-free time-series metric loggers, and Direct3D rendering subsystems.</p>
                    </div>
                    <div class="featured-programs-grid programs-grid-sm">
                        <?php if (!empty($cppProjects)): ?>
                            <?php foreach ($cppProjects as $p): ?>
                            <article class="program-card program-card-sm" data-category="cpp <?= e($p['category']) ?>" data-project-id="<?= e($p['slug']) ?>">
                                <div class="program-card-header">
                                    <div class="program-tags-group">
                                        <span class="program-lang-tag"><?= e(strtoupper($p['category'])) ?></span>
                                        <span class="program-id-badge">ID.<?= e(str_pad((string)$p['id'], 3, '0', STR_PAD_LEFT)) ?></span>
                                    </div>
                                    <?php if (!empty($p['is_featured'])): ?>
                                        <span class="program-featured-star">★ FEATURED</span>
                                    <?php endif; ?>
                                </div>
                                <div class="program-card-body">
                                    <h4 class="program-title"><?= e($p['title']) ?></h4>
                                    <p class="program-desc"><?= e($p['short_description']) ?></p>
                                    <div class="program-compact-meta">
                                        <div class="program-tech-tags">
                                            <?php 
                                            $techs = is_array($p['technologies']) ? $p['technologies'] : explode(',', (string)($p['technologies'] ?? ''));
                                            foreach (array_slice($techs, 0, 3) as $t):
                                                $t = trim($t);
                                                if ($t === '') continue;
                                            ?>
                                                <span class="skill-badge"><?= e($t) ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                        <span class="program-metric-badge"><?= e(strtoupper($p['status'])) ?></span>
                                    </div>
                                </div>
                                <div class="program-card-footer" style="display: flex; gap: 8px;">
                                    <button class="btn btn-primary btn-sm btn-inspect-project" data-project-id="<?= e($p['slug']) ?>" type="button">Inspect</button>
                                    <a href="<?= e(url('project/' . $p['slug'])) ?>" class="btn btn-outline btn-sm" style="text-decoration: none;">Dossier &nearr;</a>
                                </div>
                            </article>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div style="grid-column: 1/-1; padding: 20px; text-align: center; color: #64748b;">
                                // NO TELEMETRY COMMITTED TO THIS ARCHIVE CATEGORY
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <!-- ================= CONTACT SECTION VIEW ================= -->
            <section id="contact" class="page-view" aria-label="Contact View">
                <div class="section-watermark-num">04</div>
                
                <div class="section-header">
                    <span class="section-subtitle">Get In Touch</span>
                    <h2 class="section-title">Let’s connect.</h2>
                    <div class="section-divider"></div>
                </div>

                <div class="contact-bento-grid">
                    <!-- Contact Hero Card (Span 7) with Flush Photo Right -->
                    <div class="bento-card contact-hero-card">
                        <div class="contact-card-layout">
                            <div class="contact-card-text">
                                <div>
                                    <div class="bento-tag">
                                        <span class="tag-rec-dot"></span>
                                        <span>DIRECT COMMS // INQUIRIES</span>
                                        <div class="win-controls">
                                            <span class="win-btn">_</span>
                                            <span class="win-btn win-close">&times;</span>
                                        </div>
                                    </div>
                                    <h3 class="bento-heading">Interested in collaborating or discussing systems?</h3>
                                    <p class="about-text">
                                        Whether you want to discuss technology, software engineering, homelab setups, or potential opportunities, feel free to reach out anytime.
                                    </p>
                                </div>

                                <div class="contact-card-list">
                                    <div class="contact-item">
                                        <span class="contact-item-label">Direct Email</span>
                                        <a href="mailto:<?= e($profile['email'] ?? "mordenes@acm.org") ?>" class="contact-item-link"><?= e($profile['email'] ?? "mordenes@acm.org") ?></a>
                                    </div>
                                    <div class="contact-item">
                                        <span class="contact-item-label">Location / Base</span>
                                        <span class="contact-item-text"><?= e($profile['location'] ?? "Laguna, Philippines") ?></span>
                                    </div>
                                    <div class="contact-item" style="margin-top: 10px;">
                                        <span class="contact-item-label">Social & Networks</span>
                                        <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: 4px;">
                                            <?php if (!empty($socialLinks)): ?>
                                                <?php foreach ($socialLinks as $sl): ?>
                                                    <a href="<?= e($sl['url']) ?>" target="_blank" rel="noopener noreferrer" style="color: var(--color-cyan); font-size: 0.8rem; text-decoration: underline;">
                                                        <?= e($sl['label']) ?> &nearr;
                                                    </a>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="contact-card-photo-pane">
                                <img src="images/me_3.jpg" alt="Michael Benedict Ordenes" class="contact-flush-photo">
                                <div class="contact-photo-telemetry">
                                    <span class="tag-pulse"></span>
                                    <span class="contact-photo-label">x64emkei // TERMINAL READY</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form Panel (Span 5) -->
                    <div class="bento-card contact-channels-card">
                        <div class="bento-tag">
                            <span class="tag-rec-dot"></span>
                            <span>SEND MESSAGE // DISPATCH</span>
                            <div class="win-controls">
                                <span class="win-btn">_</span>
                                <span class="win-btn win-close">&times;</span>
                            </div>
                        </div>
                        <h3 class="bento-heading">Quick Message</h3>

                        <form class="contact-form" id="contactForm" novalidate>
                        <?= csrf_field() ?>
                            <div class="form-group">
                                <label for="userName" class="form-label">Your Name</label>
                                <input type="text" id="userName" name="name" class="form-input" placeholder="e.g. Alex Cruz" required>
                                <span class="form-error" id="nameError">Please enter your name</span>
                            </div>

                            <div class="form-group">
                                <label for="userEmail" class="form-label">Email Address</label>
                                <input type="email" id="userEmail" name="email" class="form-input" placeholder="e.g. alex@example.com" required>
                                <span class="form-error" id="emailError">Please enter a valid email address</span>
                            </div>

                            <div class="form-group">
                                <label for="userSubject" class="form-label">Subject</label>
                                <input type="text" id="userSubject" name="subject" class="form-input" placeholder="Collaboration / Tech Discussion / Project" required>
                                <span class="form-error" id="subjectError">Please enter a subject</span>
                            </div>

                            <div class="form-group">
                                <label for="userMessage" class="form-label">Message</label>
                                <textarea id="userMessage" name="message" class="form-textarea" rows="4" placeholder="Tell me what you'd like to build or discuss..." required></textarea>
                                <span class="form-error" id="messageError">Message must be at least 10 characters</span>
                            </div>

                            <button type="submit" class="btn btn-primary btn-submit" id="submitBtn">
                                <span class="btn-text">Send Message</span>
                                <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="22" y1="2" x2="11" y2="13"/>
                                    <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                                </svg>
                            </button>
                        </form>

                        <div class="bento-channel-links">
                            <a href="https://github.com/x64_emkei" target="_blank" rel="noopener noreferrer" class="bento-channel-item">
                                <div class="channel-icon-box">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"/>
                                        <path d="M9 18c-4.51 2-5-2-7-2"/>
                                    </svg>
                                </div>
                                <div class="channel-details">
                                    <span class="channel-name">GitHub</span>
                                    <span class="channel-handle">@x64_emkei</span>
                                </div>
                                <svg class="channel-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
                            </a>

                            <a href="https://linkedin.com/in/michael-ordenes/" target="_blank" rel="noopener noreferrer" class="bento-channel-item">
                                <div class="channel-icon-box">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/>
                                        <rect width="4" height="12" x="2" y="9"/>
                                        <circle cx="4" cy="4" r="2"/>
                                    </svg>
                                </div>
                                <div class="channel-details">
                                    <span class="channel-name">LinkedIn</span>
                                    <span class="channel-handle">in/michael-ordenes</span>
                                </div>
                                <svg class="channel-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Toast Notification Component -->
    <div class="toast-container" id="toastContainer" role="status" aria-live="polite">
        <div class="toast-card" id="toastCard">
            <div class="toast-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>
            <div class="toast-content">
                <h4 class="toast-title" id="toastTitle">Success!</h4>
                <p class="toast-message" id="toastMessage">Your message has been dispatched successfully.</p>
            </div>
        </div>
    </div>

    <!-- AI Manifesto Interactive Modal & Carousel Component -->
    <div class="manifesto-modal-backdrop" id="manifestoModalBackdrop" aria-hidden="true">
        <div class="manifesto-modal-container" id="manifestoModal" role="dialog" aria-modal="true" aria-labelledby="currentSectionName">
            <!-- Modal Header -->
            <div class="manifesto-modal-header">
                <div class="manifesto-header-meta">
                    <span class="manifesto-live-pip"></span>
                    <span class="manifesto-header-id">SYS.DOC // AI_MANIFESTO_V1.0</span>
                    <span class="manifesto-header-tag">ETHICS & SKILL</span>
                </div>
                <div class="manifesto-header-controls">
                    <button class="manifesto-view-toggle-btn" id="manifestoViewToggle" aria-label="Toggle Full Reading Mode">
                        <span class="view-toggle-icon">📜</span>
                        <span class="view-toggle-text">Full Read View</span>
                    </button>
                    <button class="manifesto-close-btn" id="manifestoCloseBtn" aria-label="Close Manifesto Dialog">&times;</button>
                </div>
            </div>

            <!-- Button Carousel Nav Bar -->
            <div class="manifesto-carousel-nav" role="tablist" aria-label="Manifesto Sections">
                <button class="carousel-nav-btn active" data-slide="0" role="tab" aria-selected="true">
                    <span class="nav-btn-idx">00</span>
                    <span>Preamble</span>
                </button>
                <button class="carousel-nav-btn" data-slide="1" role="tab" aria-selected="false">
                    <span class="nav-btn-idx">01</span>
                    <span>I. Tool vs Skill</span>
                </button>
                <button class="carousel-nav-btn" data-slide="2" role="tab" aria-selected="false">
                    <span class="nav-btn-idx">02</span>
                    <span>II. Creativity</span>
                </button>
                <button class="carousel-nav-btn" data-slide="3" role="tab" aria-selected="false">
                    <span class="nav-btn-idx">03</span>
                    <span>III. Development</span>
                </button>
                <button class="carousel-nav-btn" data-slide="4" role="tab" aria-selected="false">
                    <span class="nav-btn-idx">04</span>
                    <span>IV. Responsibility</span>
                </button>
                <button class="carousel-nav-btn" data-slide="5" role="tab" aria-selected="false">
                    <span class="nav-btn-idx">05</span>
                    <span>V. Opportunities</span>
                </button>
                <button class="carousel-nav-btn" data-slide="6" role="tab" aria-selected="false">
                    <span class="nav-btn-idx">06</span>
                    <span>VI. Capable Future</span>
                </button>
                <button class="carousel-nav-btn" data-slide="7" role="tab" aria-selected="false">
                    <span class="nav-btn-idx">07</span>
                    <span>VII. Governance</span>
                </button>
                <button class="carousel-nav-btn" data-slide="8" role="tab" aria-selected="false">
                    <span class="nav-btn-idx">08</span>
                    <span>VIII. Creed</span>
                </button>
            </div>

            <!-- Modal Body & Carousel Track (9 Slides) -->
            <div class="manifesto-modal-body" id="manifestoModalBody">
                <div class="manifesto-carousel-track" id="manifestoCarouselTrack">
                    
                    <!-- Slide 0: Preamble -->
                    <div class="manifesto-slide active-slide" data-slide="0">
                        <div class="slide-inner">
                            <div class="slide-header">
                                <span class="slide-hud-tag">// PREAMBLE</span>
                                <h3 class="slide-main-title">My AI Manifesto</h3>
                                <p class="slide-subtitle">A Personal Position on AI, Human Skill, and Responsible Progress</p>
                                <div class="slide-divider"></div>
                            </div>
                            <div class="slide-text-body">
                                <p class="manifesto-lead-p">
                                    Artificial intelligence is becoming part of the way people learn, work, create, and solve problems. As a student preparing for a professional career in technology, its presence is impossible to ignore.
                                </p>
                                <p>
                                    There is excitement in what AI can accomplish, but there is also a responsibility to understand what should remain distinctly human.
                                </p>
                                <div class="manifesto-highlight-banner">
                                    <span class="banner-pulse-icon">⚡</span>
                                    <span>This manifesto represents the principles that will guide my relationship with AI—not as something to fear or reject, but as something to understand, use responsibly, and keep in its proper place.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 1: Tool vs Skill -->
                    <div class="manifesto-slide" data-slide="1">
                        <div class="slide-inner">
                            <div class="slide-header">
                                <span class="slide-hud-tag">// SECTION 01</span>
                                <h3 class="slide-main-title">I. AI Is a Tool, Not a Substitute for Skill</h3>
                                <p class="slide-subtitle">AI should remain a tool for developing and extending human capability.</p>
                                <div class="slide-divider"></div>
                            </div>
                            <div class="slide-text-body">
                                <p>
                                    As a student, learning should not be reduced to asking an AI for an answer. The purpose of education is not simply to produce an output, but to develop the ability to understand, reason, create, solve problems, and make decisions independently.
                                </p>
                                <div class="manifesto-dichotomy-grid">
                                    <div class="dichotomy-card tool-side">
                                        <div class="dichotomy-header">
                                            <span class="dichotomy-code">TOOL.ASSIST</span>
                                            <h4>Assistance</h4>
                                        </div>
                                        <p>AI can help explain a difficult concept, suggest an approach, assist with code, or provide another perspective.</p>
                                    </div>
                                    <div class="dichotomy-card skill-side">
                                        <div class="dichotomy-header">
                                            <span class="dichotomy-code">HUMAN.SKILL</span>
                                            <h4>Mastery</h4>
                                        </div>
                                        <p>Years of studying, practicing, experimenting, failing, and gaining experience cannot be equated to writing an effective prompt in minutes.</p>
                                    </div>
                                </div>
                                <div class="manifesto-verdict-box">
                                    <span class="verdict-tag">// CORE PRINCIPLE</span>
                                    <span>The value of professional skill lies not only in producing an output, but in understanding why it works, whether it is correct, how it can be improved, and what consequences follow from using it.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2: Human Creativity -->
                    <div class="manifesto-slide" data-slide="2">
                        <div class="slide-inner">
                            <div class="slide-header">
                                <span class="slide-hud-tag">// SECTION 02</span>
                                <h3 class="slide-main-title">II. Human Creativity Still Matters</h3>
                                <p class="slide-subtitle">Human capability enhanced by AI.</p>
                                <div class="slide-divider"></div>
                            </div>
                            <div class="slide-text-body">
                                <p>
                                    Much of what AI can produce is connected to knowledge and creative work that originated from people. Art, writing, programming, research, engineering, design, and other forms of human work have contributed to the knowledge from which modern AI systems derive their capabilities.
                                </p>
                                <div class="manifesto-craft-panel">
                                    <div class="craft-panel-top">
                                        <span class="craft-chip">CRAFT // TASTE</span>
                                    </div>
                                    <p class="craft-statement">A person who has spent years developing a craft possesses something that cannot be reduced to a prompt: <strong>experience</strong>.</p>
                                    <p class="craft-breakdown">That experience shapes judgment, taste, intuition, creativity, and the ability to recognize possibilities that may not be immediately apparent.</p>
                                </div>
                                <div class="manifesto-grand-quote quote-crimson">
                                    <span class="grand-quote-label">// MANDATE</span>
                                    <blockquote>The goal should not be to choose between humans and AI. The goal must be human capability enhanced by AI.</blockquote>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3: Professional Development -->
                    <div class="manifesto-slide" data-slide="3">
                        <div class="slide-inner">
                            <div class="slide-header">
                                <span class="slide-hud-tag">// SECTION 03</span>
                                <h3 class="slide-main-title">III. AI Should Strengthen Professional Development</h3>
                                <p class="slide-subtitle">Competence over dependency.</p>
                                <div class="slide-divider"></div>
                            </div>
                            <div class="slide-text-body">
                                <p class="manifesto-lead-p">
                                    A strong professional should be capable of working with AI without becoming dependent upon it. That means developing the fundamentals:
                                </p>
                                <div class="manifesto-pillars-grid">
                                    <div class="pillar-card">
                                        <span class="pillar-num">01</span>
                                        <span class="pillar-text">Understanding the code behind the abstraction.</span>
                                    </div>
                                    <div class="pillar-card">
                                        <span class="pillar-num">02</span>
                                        <span class="pillar-text">Understanding the reasoning behind the answer.</span>
                                    </div>
                                    <div class="pillar-card">
                                        <span class="pillar-num">03</span>
                                        <span class="pillar-text">Knowing when an AI-generated solution is wrong or hallucinated.</span>
                                    </div>
                                    <div class="pillar-card">
                                        <span class="pillar-num">04</span>
                                        <span class="pillar-text">Being able to independently verify and validate information.</span>
                                    </div>
                                    <div class="pillar-card">
                                        <span class="pillar-num">05</span>
                                        <span class="pillar-text">Being capable of solving a problem even when the tool is unavailable.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 4: Responsibility -->
                    <div class="manifesto-slide" data-slide="4">
                        <div class="slide-inner">
                            <div class="slide-header">
                                <span class="slide-hud-tag">// SECTION 04</span>
                                <h3 class="slide-main-title">IV. Responsibility Cannot Be Automated</h3>
                                <p class="slide-subtitle">Accountability remains human.</p>
                                <div class="slide-divider"></div>
                            </div>
                            <div class="slide-text-body">
                                <p>
                                    AI can generate an answer, but it cannot carry professional responsibility for that answer. When AI contributes to a project, the human using it remains responsible for the final result.
                                </p>
                                <div class="manifesto-alert-panel">
                                    <div class="alert-tag-line">
                                        <span class="tag-pulse"></span>
                                        <span>CRITICAL ETHICAL AXIOM</span>
                                    </div>
                                    <p class="manifesto-p-emph">This principle is especially important in professional environments where mistakes can affect people, organizations, finances, privacy, security, or public welfare.</p>
                                </div>
                                <p>
                                    AI should therefore be questioned, tested, and verified rather than blindly trusted. The presence of an AI system should never become an excuse for avoiding accountability.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 5: Opportunities & PAX Silica -->
                    <div class="manifesto-slide" data-slide="5">
                        <div class="slide-inner">
                            <div class="slide-header">
                                <span class="slide-hud-tag">// SECTION 05</span>
                                <h3 class="slide-main-title">V. Technology Should Create Opportunities</h3>
                                <p class="slide-subtitle">Progress measured by opportunities created for communities.</p>
                                <div class="slide-divider"></div>
                            </div>
                            <div class="slide-text-body">
                                <div class="manifesto-silica-card">
                                    <span class="silica-badge">POLICY & INVESTMENT // PAX SILICA</span>
                                    <h4 class="silica-title">Responsible Tech Investment</h4>
                                    <p class="silica-lead">Large technological investments such as PAX Silica must create tangible opportunities for workers, students, researchers, and local industries.</p>
                                    <span class="silica-list-title">Target Returns:</span>
                                    <div class="silica-grid">
                                        <div class="silica-item"><span class="silica-bullet">&bull;</span> High-quality tech careers & jobs</div>
                                        <div class="silica-item"><span class="silica-bullet">&bull;</span> Knowledge & technology transfer</div>
                                        <div class="silica-item"><span class="silica-bullet">&bull;</span> Opportunities for Filipino talent</div>
                                        <div class="silica-item"><span class="silica-bullet">&bull;</span> Resilient economic growth</div>
                                    </div>
                                </div>
                                <div class="manifesto-filipino-maxim-card">
                                    <div class="maxim-flag-row">
                                        <span class="maxim-dot-blue"></span>
                                        <span class="maxim-dot-yellow"></span>
                                        <span class="maxim-dot-red"></span>
                                        <span class="maxim-hud">FILIPINO GUIDING MAXIM</span>
                                    </div>
                                    <blockquote class="maxim-quote">
                                        &ldquo;Walang dapat agrabyado; lahat dapat may pagkakataong makinabang.&rdquo;
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 6: Capable Future -->
                    <div class="manifesto-slide" data-slide="6">
                        <div class="slide-inner">
                            <div class="slide-header">
                                <span class="slide-hud-tag">// SECTION 06</span>
                                <h3 class="slide-main-title">VI. A Future Where People Become More Capable</h3>
                                <p class="slide-subtitle">Expanding human capability rather than rendering people disposable.</p>
                                <div class="slide-divider"></div>
                            </div>
                            <div class="slide-text-body">
                                <div class="manifesto-questions-grid">
                                    <div class="question-box question-stale">
                                        <span class="q-type">Stale Question</span>
                                        <p>&ldquo;What jobs can be replaced?&rdquo;</p>
                                    </div>
                                    <div class="question-box question-generative">
                                        <span class="q-type">Generative Question</span>
                                        <p>&ldquo;What new capabilities and opportunities can be created?&rdquo;</p>
                                    </div>
                                </div>
                                <div class="manifesto-enablement-flow">
                                    <div class="flow-card">
                                        <span class="flow-agent">Students</span>
                                        <span class="flow-arrow">&rarr;</span>
                                        <span class="flow-action">Understand complex concepts deeper</span>
                                    </div>
                                    <div class="flow-card">
                                        <span class="flow-agent">Developers</span>
                                        <span class="flow-arrow">&rarr;</span>
                                        <span class="flow-action">Explore solutions and build resilient code</span>
                                    </div>
                                    <div class="flow-card">
                                        <span class="flow-agent">Researchers</span>
                                        <span class="flow-arrow">&rarr;</span>
                                        <span class="flow-action">Analyze data and synthesize insights</span>
                                    </div>
                                    <div class="flow-card">
                                        <span class="flow-agent">Citizens</span>
                                        <span class="flow-arrow">&rarr;</span>
                                        <span class="flow-action">Benefit from efficient, transparent services</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 7: Governance -->
                    <div class="manifesto-slide" data-slide="7">
                        <div class="slide-inner">
                            <div class="slide-header">
                                <span class="slide-hud-tag">// SECTION 07</span>
                                <h3 class="slide-main-title">VII. Progress Must Come With Responsible Governance</h3>
                                <p class="slide-subtitle">Developing talent, transparency, and public responsibility.</p>
                                <div class="slide-divider"></div>
                            </div>
                            <div class="slide-text-body">
                                <p>
                                    For the Philippines, technological development should not simply mean becoming a market for technologies developed elsewhere. It must mean developing Filipino talent and capability.
                                </p>
                                <div class="manifesto-stakeholder-matrix">
                                    <div class="matrix-cell">
                                        <span class="cell-target">Students</span>
                                        <span class="cell-benefit">Opportunities to learn and innovate</span>
                                    </div>
                                    <div class="matrix-cell">
                                        <span class="cell-target">Professionals</span>
                                        <span class="cell-benefit">Opportunities to work with dignity</span>
                                    </div>
                                    <div class="matrix-cell">
                                        <span class="cell-target">Researchers</span>
                                        <span class="cell-benefit">Resources to contribute to global science</span>
                                    </div>
                                    <div class="matrix-cell">
                                        <span class="cell-target">Communities</span>
                                        <span class="cell-benefit">Equitable access to technological benefits</span>
                                    </div>
                                </div>
                                <div class="manifesto-core-callout">
                                    <div class="callout-indicator-bar"></div>
                                    <p class="callout-lead-text">
                                        Good governance allows innovation to flourish while ensuring that the benefits of progress reach the people who make that progress possible.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 8: Creed -->
                    <div class="manifesto-slide" data-slide="8">
                        <div class="slide-inner">
                            <div class="slide-header">
                                <span class="slide-hud-tag">// SECTION 08</span>
                                <h3 class="slide-main-title">VIII. The Professional I Aspire to Become</h3>
                                <p class="slide-subtitle">Core Principles & Creed</p>
                                <div class="slide-divider"></div>
                            </div>
                            <div class="slide-text-body">
                                <span class="commitments-title">// THE FOUNDATION BEGINS AS A STUDENT:</span>
                                <div class="commitments-checklist">
                                    <div class="commit-row"><span class="commit-idx">01</span><span class="commit-text">Learn the fundamentals thoroughly.</span></div>
                                    <div class="commit-row"><span class="commit-idx">02</span><span class="commit-text">Develop genuine, independent skills.</span></div>
                                    <div class="commit-row"><span class="commit-idx">03</span><span class="commit-text">Use AI without becoming dependent on it.</span></div>
                                    <div class="commit-row"><span class="commit-idx">04</span><span class="commit-text">Question and verify outputs rigorously.</span></div>
                                    <div class="commit-row"><span class="commit-idx">05</span><span class="commit-text">Use technological knowledge to create opportunities for others.</span></div>
                                </div>

                                <div class="manifesto-creed-box">
                                    <div class="creed-box-header">
                                        <span class="creed-live-dot"></span>
                                        <h4>CORE CREED</h4>
                                        <span class="creed-tag">x64emkei // CREED</span>
                                    </div>
                                    <ul class="creed-tenets">
                                        <li><span class="tenet-marker">&bull;</span><span class="tenet-body"><strong>AI should make people more capable,</strong> not more disposable.</span></li>
                                        <li><span class="tenet-marker">&bull;</span><span class="tenet-body"><strong>Human skill should be strengthened,</strong> not devalued.</span></li>
                                        <li><span class="tenet-marker">&bull;</span><span class="tenet-body"><strong>Technology should create opportunities,</strong> not merely eliminate them.</span></li>
                                        <li><span class="tenet-marker">&bull;</span><span class="tenet-body"><strong>Innovation should serve people,</strong> not leave them behind.</span></li>
                                        <li><span class="tenet-marker">&bull;</span><span class="tenet-body"><strong>Professional competence should always remain greater</strong> than the ability to simply operate a tool.</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Modal Footer Controls -->
            <div class="manifesto-modal-footer">
                <div class="manifesto-bottom-ctrls">
                    <button class="carousel-nav-arrow-btn" id="prevSlideBtn" aria-label="Previous Slide">&larr; Prev</button>
                    <div class="carousel-hud-progress">
                        <div class="hud-progress-labels">
                            <span class="hud-sec-num" id="currentSlideDisplay">SEC 00 / 08</span>
                            <span class="hud-sec-label" id="currentSectionName">Preamble</span>
                        </div>
                        <div class="hud-progress-track">
                            <div class="hud-progress-bar" id="carouselProgressBar" style="width: 11.11%;"></div>
                        </div>
                    </div>
                    <button class="carousel-nav-arrow-btn" id="nextSlideBtn" aria-label="Next Slide">Next &rarr;</button>
                </div>
                <div class="manifesto-footer-actions">
                    <button class="manifesto-action-btn" id="copyManifestoBtn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
                            <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
                        </svg>
                        <span id="copyManifestoText">Copy Text</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- =========================================================================
         INTERACTIVE MODAL WINDOW: PROJECT ARCHITECTURE & CODE INSPECTOR
         ========================================================================= -->
    <div class="project-modal-backdrop" id="projectModalBackdrop" aria-hidden="true">
        <div class="project-modal-container" id="projectModal" role="dialog" aria-modal="true" aria-labelledby="modalProjectTitle">
            <!-- Modal Header -->
            <div class="project-modal-header">
                <div class="project-modal-meta">
                    <span class="modal-pulse-pip"></span>
                    <span class="modal-code-id" id="modalProjectId">PROJECT.INSPECTOR // ARCHITECTURE</span>
                    <span class="modal-category-tag" id="modalProjectCategory">C# .NET</span>
                </div>
                <div class="modal-header-actions">
                    <button class="project-modal-close-btn" id="projectModalCloseBtn" aria-label="Close Project Inspector">&times;</button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="project-modal-body">
                <div class="project-modal-hero">
                    <h3 class="project-modal-title" id="modalProjectTitle">Project Title</h3>
                    <p class="project-modal-tagline" id="modalProjectTagline">Architecture overview and system purpose.</p>
                </div>

                <div class="project-modal-specs-grid">
                    <div class="project-spec-item">
                        <span class="project-spec-label">Platform / Target</span>
                        <span class="project-spec-value" id="modalProjectEnv">Proxmox VE &bull; Linux</span>
                    </div>
                    <div class="project-spec-item">
                        <span class="project-spec-label">Execution Profile</span>
                        <span class="project-spec-value" id="modalProjectPerf">Sub-millisecond &bull; Low Memory Footprint</span>
                    </div>
                    <div class="project-spec-item">
                        <span class="project-spec-label">Deployment Status</span>
                        <span class="project-spec-value modal-status-active" id="modalProjectStatus">Active &bull; Operational</span>
                    </div>
                </div>

                <div class="project-modal-content-stack">
                    <div class="modal-section-block">
                        <h4 class="modal-block-heading">// ARCHITECTURAL SPECIFICATION</h4>
                        <p class="modal-block-text" id="modalProjectDesc">Detailed technical breakdown.</p>
                    </div>

                    <div class="modal-section-block">
                        <h4 class="modal-block-heading">// KEY SYSTEM CAPABILITIES</h4>
                        <ul class="modal-features-list" id="modalProjectFeatures">
                            <!-- Populated dynamically via JS -->
                        </ul>
                    </div>

                    <div class="modal-section-block">
                        <div class="code-block-header">
                            <span class="code-file-tag" id="modalCodeFileName">Architecture.cs</span>
                            <button class="btn-copy-code" id="btnCopyProjectCode" type="button">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 13px; height: 13px;"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                                <span id="copyCodeText">Copy Snippet</span>
                            </button>
                        </div>
                        <pre class="modal-code-viewer"><code id="modalProjectCode">// Code goes here</code></pre>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="project-modal-footer">
                <div class="modal-tech-pills-row" id="modalProjectTechPills">
                    <!-- Populated dynamically -->
                </div>
                <div class="project-modal-buttons">
                    <a href="https://github.com/x64_emkei" target="_blank" rel="noopener noreferrer" class="btn btn-outline" id="modalProjectGithubLink">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 14px; height: 14px;"><path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"/><path d="M9 18c-4.51 2-5-2-7-2"/></svg>
                        <span>Source Code</span>
                    </a>
                    <button class="btn btn-primary" id="modalProjectCloseActionBtn" type="button">Dismiss</button>
                </div>
            </div>
        </div>
    </div>

    <!-- =========================================================================
         INTERACTIVE MODAL WINDOW: VINTAGE HARDWARE NODE TELEMETRY INSPECTOR
         ========================================================================= -->
    <div class="hardware-modal-backdrop" id="hardwareModalBackdrop" aria-hidden="true">
        <div class="hardware-modal-container" id="hardwareModal" role="dialog" aria-modal="true" aria-labelledby="modalHwTitle">
            <div class="hardware-modal-header">
                <div class="hardware-modal-meta">
                    <span class="modal-pulse-pip"></span>
                    <span class="modal-code-id" id="modalHwNodeId">NODE.01 // LAB ARCHIVE</span>
                    <span class="modal-category-tag" id="modalHwTag">PRESERVED</span>
                </div>
                <button class="hardware-modal-close-btn" id="hardwareModalCloseBtn" aria-label="Close Hardware Inspector">&times;</button>
            </div>
            <div class="hardware-modal-body">
                <div class="hardware-modal-hero">
                    <h3 class="hardware-modal-title" id="modalHwTitle">Sony Vaio W-series VPCW115XG</h3>
                    <p class="hardware-modal-subtitle" id="modalHwSubtitle">Intel Atom N280 Netbook Platform &bull; Japanese Ultraportable Engineering</p>
                </div>
                <div class="hardware-specs-matrix" id="modalHwSpecsMatrix">
                    <!-- Populated dynamically via JS -->
                </div>
                <div class="hardware-logs-card">
                    <h4 class="modal-block-heading">// RESTORATION HISTORY & LAB DIAGNOSTICS</h4>
                    <p class="modal-block-text" id="modalHwLog">Restoration history notes.</p>
                </div>
            </div>
            <div class="hardware-modal-footer">
                <span class="hardware-oem-tag" id="modalHwOem">OEM: Sony VAIO Corp.</span>
                <button class="btn btn-primary" id="hardwareModalCloseActionBtn" type="button">Close Telemetry</button>
            </div>
        </div>
    </div>

        <script>
        window.__SERVER_PROJECTS__ = <?= json_encode($projects ?? []) ?>;
        window.__SERVER_HARDWARE__ = <?= json_encode($hardwareNodes ?? []) ?>;
    </script>
    <!-- Main Logic -->
    <script src="<?= asset('script.js') ?>"></script>
</body>
</html>
