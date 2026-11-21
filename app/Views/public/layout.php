<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($metaTitle) ?></title>
    <meta name="description" content="<?= e($metaDesc) ?>">
    <meta name="keywords" content="<?= e($metaKeywords) ?>">
    <meta name="author" content="<?= e($profile['full_name']) ?>">
    <link rel="canonical" href="<?= e($siteUrl) ?>">

    <!-- Open Graph / Social Sharing -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= e($siteUrl) ?>">
    <meta property="og:title" content="<?= e($metaTitle) ?>">
    <meta property="og:description" content="<?= e($metaDesc) ?>">
    <meta property="og:image" content="<?= e($siteUrl . '/' . ltrim($profile['avatar_url'], '/')) ?>">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($metaTitle) ?>">
    <meta name="twitter:description" content="<?= e($metaDesc) ?>">
    <meta name="twitter:image" content="<?= e($siteUrl . '/' . ltrim($profile['avatar_url'], '/')) ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="<?= asset('style.css') ?>">

    <!-- JSON-LD Structured Data Schema -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Person",
        "name": "<?= e($profile['full_name']) ?>",
        "jobTitle": "<?= e($profile['title']) ?>",
        "url": "<?= e($siteUrl) ?>",
        "sameAs": [
            <?php 
            $urls = array_map(fn($l) => '"' . e($l['url']) . '"', $socialLinks);
            echo implode(', ', $urls);
            ?>
        ],
        "knowsAbout": [
            <?php
            $skillNames = [];
            foreach ($skillsGrouped as $catSkills) {
                foreach ($catSkills as $sk) {
                    $skillNames[] = '"' . e($sk['name']) . '"';
                }
            }
            echo implode(', ', array_slice($skillNames, 0, 15));
            ?>
        ]
    }
    </script>
</head>
<body>
    <!-- High-Tech Color Sweep Screen Transition Curtain -->
    <div class="color-sweep-curtain" id="colorSweepCurtain" aria-hidden="true">
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
            <span class="brand-subtitle"><?= e($profile['full_name']) ?></span>
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
                <li class="nav-item">
                    <a href="#services" class="nav-link" data-section="services">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="18" x="3" y="3" rx="2"/>
                            <path d="m9 8 6 4-6 4Z"/>
                        </svg>
                        <span>Services</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#portfolio" class="nav-link" data-section="portfolio">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="14" x="2" y="7" rx="2" ry="2"/>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                        </svg>
                        <span>Portfolio</span>
                    </a>
                </li>
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
            <!-- Telemetry Live HUD Clock -->
            <div class="sidebar-telemetry-hud" title="Local System Time (Click to toggle 12/24H mode)">
                <span class="hud-clock-label">SYS.TIME</span>
                <span class="hud-clock-val" id="liveSysClock">--:--:-- --</span>
            </div>

            <!-- AI Manifesto Trigger Button -->
            <button class="btn-manifesto" id="sidebarManifestoBtn" aria-label="Open AI Manifesto">
                <span class="manifesto-hazard">&#9889;</span>
                <span>AI MANIFESTO</span>
                <span class="manifesto-glitch">v1.0</span>
            </button>

            <!-- Trust Me Button -->
            <a href="#about" class="btn btn-trust-me sidebar-trust-btn nav-trigger" data-target="about">
                <span class="trust-hazard">&#9888;</span>
                <span>TRUST ME</span>
                <span class="trust-glitch">// LAB</span>
            </a>

            <!-- Theme Toggle Button -->
            <button class="theme-toggle-btn" id="themeToggle" aria-label="Toggle light/dark theme">
                <span class="theme-icon-container">
                    <svg class="theme-icon icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                        <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                    </svg>
                    <svg class="theme-icon icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
                    </svg>
                </span>
                <span class="theme-label" id="themeLabel">Dark Mode</span>
            </button>

            <!-- Social Links -->
            <div class="social-links">
                <?php foreach ($socialLinks as $link): ?>
                    <a href="<?= e($link['url']) ?>" target="_blank" rel="noopener noreferrer" class="social-btn" aria-label="<?= e($link['label']) ?>">
                        <?php if (str_contains(strtolower($link['platform']), 'github')): ?>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"/>
                                <path d="M9 18c-4.51 2-5-2-7-2"/>
                            </svg>
                        <?php elseif (str_contains(strtolower($link['platform']), 'linkedin')): ?>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/>
                                <rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/>
                            </svg>
                        <?php else: ?>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                            </svg>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
            
            <p class="copyright-text">
                &copy; <?= date('Y') ?> <?= e($profile['full_name']) ?> &bull; 
                <a href="<?= e(url('admin')) ?>" style="color: #64748b; text-decoration: none;" title="Operator CMS Control Deck">[CMS]</a>
            </p>
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
                                <span><?= e($profile['title']) ?></span>
                            </div>

                            <h1 class="hero-title">
                                <span class="hero-title-prefix">x64</span><span class="text-gradient">emkei</span>
                            </h1>

                            <p class="hero-subtitle-badge">
                                <?= e($profile['full_name']) ?> &bull; Systems Architecture &bull; Low-Level Compute
                            </p>

                            <p class="hero-description">
                                <?= e($profile['tagline'] ?: $profile['bio_short']) ?>
                            </p>

                            <div class="hero-actions">
                                <a href="#portfolio" class="btn btn-primary nav-trigger" data-target="portfolio">
                                    <span>Explore Portfolio</span>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
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
                                        <span class="stat-tag-mini"><?= count($projects) ?> BUILDS</span>
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
                                        <span class="stat-tag-mini"><?= count($hardwareNodes) ?> NODES</span>
                                    </div>
                                    <span class="stat-number">Hardware</span>
                                    <span class="stat-label">Restoration & Legacy Platforms</span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Hero Image Panel (Clip-Path Wipe Reveal) -->
                        <div class="hero-image-panel hero-photo-container" id="heroImagePanel">
                            <div class="hero-image-wrapper hero-photo-wrapper">
                                <img src="<?= e(asset($profile['avatar_url'] ?: 'images/me_2.png')) ?>" 
                                     alt="Portrait of <?= e($profile['full_name']) ?> — <?= e($profile['title']) ?>" 
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
                    <span class="section-subtitle">Systems Dossier</span>
                    <h2 class="section-title">About & Engineering Philosophy</h2>
                    <div class="section-divider"></div>
                </div>

                <div class="about-grid">
                    <div class="bento-card about-bio-card" style="grid-column: 1 / -1;">
                        <h3 class="about-section-heading">// PROFESSIONAL DOSSIER</h3>
                        <p class="about-lead">
                            <?= e($profile['bio_full'] ?: $profile['bio_short']) ?>
                        </p>
                        <div style="margin-top: 15px; font-size: 0.85rem; color: #94a3b8;">
                            <span>LOCATION: <b style="color: var(--accent-cyan);"><?= e($profile['location']) ?></b></span> &bull; 
                            <span>AVAILABILITY: <b style="color: var(--accent-emerald);"><?= e($profile['availability_status']) ?></b></span>
                        </div>
                    </div>
                </div>

                <!-- Skills Matrix Bento -->
                <div style="margin-top: 30px;">
                    <h3 class="about-section-heading">// CORE COMPETENCIES MATRIX</h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px; margin-top: 14px;">
                        <?php foreach ($skillsGrouped as $category => $categorySkills): ?>
                            <div class="bento-card">
                                <div class="bento-tag">
                                    <span class="tag-rec-dot"></span>
                                    <span><?= e(strtoupper($category)) ?></span>
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 10px;">
                                    <?php foreach ($categorySkills as $sk): ?>
                                        <div>
                                            <div style="display: flex; justify-content: space-between; font-size: 0.8rem; margin-bottom: 4px;">
                                                <span style="color: #f8fafc; font-weight: 500;"><?= e($sk['name']) ?></span>
                                                <span style="color: var(--accent-cyan);"><?= (int)$sk['proficiency_level'] ?>%</span>
                                            </div>
                                            <div style="background: rgba(255,255,255,0.06); height: 4px; border-radius: 2px;">
                                                <div style="background: var(--accent-cyan); height: 100%; width: <?= (int)$sk['proficiency_level'] ?>%; border-radius: 2px;"></div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Experience & Education Dual Grid -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; margin-top: 36px;">
                    <!-- Experience -->
                    <div class="bento-card">
                        <h3 class="about-section-heading">// EXPERIENCE & LEADERSHIP</h3>
                        <div style="display: flex; flex-direction: column; gap: 18px; margin-top: 14px;">
                            <?php foreach ($experiences as $exp): ?>
                                <div style="border-left: 2px solid var(--accent-cyan); padding-left: 14px;">
                                    <div style="font-size: 0.95rem; font-weight: 700; color: #fff;"><?= e($exp['title']) ?></div>
                                    <div style="font-size: 0.8rem; color: var(--accent-cyan); margin: 2px 0;">
                                        <?= e($exp['organization']) ?> &bull; <?= e($exp['period_start']) ?> &ndash; <?= e($exp['period_end'] ?: 'Present') ?>
                                    </div>
                                    <p style="font-size: 0.8rem; color: #94a3b8; margin: 4px 0 0 0;"><?= e($exp['description']) ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Education -->
                    <div class="bento-card">
                        <h3 class="about-section-heading">// ACADEMIC BACKGROUND</h3>
                        <div style="display: flex; flex-direction: column; gap: 18px; margin-top: 14px;">
                            <?php foreach ($education as $edu): ?>
                                <div style="border-left: 2px solid var(--accent-magenta); padding-left: 14px;">
                                    <div style="font-size: 0.95rem; font-weight: 700; color: #fff;"><?= e($edu['degree']) ?></div>
                                    <div style="font-size: 0.8rem; color: var(--accent-magenta); margin: 2px 0;">
                                        <?= e($edu['institution']) ?> &bull; <?= e($edu['period_start']) ?> &ndash; <?= e($edu['period_end'] ?: 'Present') ?>
                                    </div>
                                    <p style="font-size: 0.8rem; color: #94a3b8; margin: 4px 0 0 0;"><?= e($edu['achievements']) ?></p>
                                </div>
                            <?php endforeach; ?>
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
                    <?php foreach ($services as $index => $srv): ?>
                        <div class="bento-card service-card <?= $index === 0 ? 'service-card-red' : '' ?>">
                            <div class="bento-tag">
                                <span class="tag-rec-dot"></span>
                                <span><?= e(strtoupper($srv['category'])) ?></span>
                                <div class="win-controls">
                                    <span class="win-btn">_</span>
                                    <span class="win-btn win-close">&times;</span>
                                </div>
                            </div>
                            <h3 class="service-title"><?= e($srv['title']) ?></h3>
                            <p class="service-description"><?= e($srv['description']) ?></p>
                        </div>
                    <?php endforeach; ?>
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

                <!-- Filter Controls -->
                <div class="portfolio-filter-group" role="tablist" aria-label="Portfolio Category Filter">
                    <button class="filter-btn active" data-filter="featured"><span>Featured</span></button>
                    <button class="filter-btn" data-filter="csharp"><span>C# (.NET)</span></button>
                    <button class="filter-btn" data-filter="python"><span>Python</span></button>
                    <button class="filter-btn" data-filter="web"><span>WebDev</span></button>
                    <button class="filter-btn" data-filter="cpp"><span>C++</span></button>
                    <button class="filter-btn" data-filter="all"><span>All Projects (<?= count($projects) ?>)</span></button>
                </div>

                <!-- Flagship Applications Container -->
                <div class="portfolio-subsection featured-programs-section" data-section-category="featured">
                    <div class="portfolio-subsection-header">
                        <div class="subsection-meta-row">
                            <span class="subsection-badge-tag">// SYSTEM ARCHIVES</span>
                            <span class="subsection-counter"><?= count($projects) ?> TOTAL BUILDS</span>
                        </div>
                        <h3 class="portfolio-subsection-title">Flagship Applications & Systems</h3>
                        <p class="portfolio-subsection-desc">Interactive software builds demonstrating low-level kernel routines, real-time edge neural pipelines, and mission-critical architectures.</p>
                    </div>

                    <div class="programs-matrix-grid">
                        <?php foreach ($projects as $proj): ?>
                            <div class="program-node-card portfolio-item" 
                                 data-category="<?= e($proj['filter_tag']) ?>" 
                                 data-featured="<?= $proj['is_featured'] ? 'true' : 'false' ?>"
                                 data-project-key="<?= e($proj['slug']) ?>">
                                <div class="node-card-glitch-border"></div>
                                <div class="node-meta-banner">
                                    <span class="node-pulse-pip"></span>
                                    <span class="node-code-id"><?= e($proj['code_id']) ?></span>
                                    <span class="node-status-tag"><?= e($proj['operational_status']) ?></span>
                                </div>
                                <div class="node-card-body">
                                    <div class="node-category-label"><?= e($proj['category']) ?></div>
                                    <h4 class="node-title"><?= e($proj['title']) ?></h4>
                                    <p class="node-tagline"><?= e($proj['tagline']) ?></p>
                                    
                                    <div class="node-specs-block">
                                        <div class="node-spec-line">
                                            <span class="spec-label">ENV</span>
                                            <span class="spec-val"><?= e($proj['environment'] ?: 'Linux / Desktop') ?></span>
                                        </div>
                                        <div class="node-spec-line">
                                            <span class="spec-label">PERF</span>
                                            <span class="spec-val"><?= e($proj['performance_metric'] ?: 'High-Throughput') ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="node-actions-row">
                                        <button class="btn-inspect-node project-open-btn" data-project="<?= e($proj['slug']) ?>">
                                            <span>Inspect Node</span>
                                            <span class="btn-arrow">&rarr;</span>
                                        </button>
                                        <?php if (!empty($proj['github_url'])): ?>
                                            <a href="<?= e($proj['github_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn-repo-link" aria-label="GitHub Repository">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                                                    <path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"/>
                                                    <path d="M9 18c-4.51 2-5-2-7-2"/>
                                                </svg>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <!-- ================= CONTACT SECTION VIEW ================= -->
            <section id="contact" class="page-view" aria-label="Contact View">
                <div class="section-watermark-num">04</div>
                
                <div class="section-header">
                    <span class="section-subtitle">Get in Touch</span>
                    <h2 class="section-title">Transmit a Signal</h2>
                    <div class="section-divider"></div>
                </div>

                <div class="contact-grid">
                    <!-- Left: Contact Details -->
                    <div class="bento-card contact-info-card">
                        <div class="bento-tag">
                            <span class="tag-rec-dot"></span>
                            <span>TELEMETRY INGRESS</span>
                        </div>
                        <h3 class="contact-card-title">Direct Communication</h3>
                        <p class="contact-card-text">
                            Have an engineering inquiry, systems question, or collaboration opportunity? Transmit a secure signal directly to my inbox.
                        </p>
                        
                        <div class="contact-details-list">
                            <div class="contact-item">
                                <span class="contact-icon">&#9993;</span>
                                <div>
                                    <div class="contact-label">EMAIL</div>
                                    <a href="mailto:<?= e($profile['email']) ?>" class="contact-val"><?= e($profile['email']) ?></a>
                                </div>
                            </div>
                            <div class="contact-item">
                                <span class="contact-icon">&#128205;</span>
                                <div>
                                    <div class="contact-label">LOCATION</div>
                                    <span class="contact-val"><?= e($profile['location']) ?></span>
                                </div>
                            </div>
                            <div class="contact-item">
                                <span class="contact-icon">&#9889;</span>
                                <div>
                                    <div class="contact-label">OPERATING STATUS</div>
                                    <span class="contact-val" style="color: var(--accent-emerald);"><?= e($profile['availability_status']) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: CSRF-Protected Form -->
                    <div class="bento-card contact-form-card">
                        <?php if (has_flash('success')): ?>
                            <div class="form-status-alert success" style="margin-bottom: 20px; padding: 12px; border: 1px solid var(--accent-emerald); background: rgba(16,185,129,0.1); color: var(--accent-emerald); border-radius: 4px;">
                                &#10004; <?= e(flash('success')) ?>
                            </div>
                        <?php endif; ?>
                        <?php if (has_flash('error')): ?>
                            <div class="form-status-alert error" style="margin-bottom: 20px; padding: 12px; border: 1px solid var(--accent-magenta); background: rgba(255,51,102,0.1); color: var(--accent-magenta); border-radius: 4px;">
                                &#9888; <?= e(flash('error')) ?>
                            </div>
                        <?php endif; ?>

                        <form id="contactForm" action="<?= e(url('contact')) ?>" method="POST" class="contact-form">
                            <?= csrf_field() ?>
                            <!-- Honeypot -->
                            <input type="text" name="contact_botcheck" style="display:none !important;" tabindex="-1" autocomplete="off">

                            <div class="form-row">
                                <div class="form-field">
                                    <label for="contactName">SENDER NAME *</label>
                                    <input type="text" id="contactName" name="name" value="<?= old('name') ?>" required placeholder="Operator Identifier">
                                </div>
                                <div class="form-field">
                                    <label for="contactEmail">EMAIL ADDRESS *</label>
                                    <input type="email" id="contactEmail" name="email" value="<?= old('email') ?>" required placeholder="signal@domain.org">
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="contactSubject">TRANSMISSION SUBJECT</label>
                                <input type="text" id="contactSubject" name="subject" value="<?= old('subject') ?>" placeholder="Inquiry / Systems Consultation">
                            </div>

                            <div class="form-field">
                                <label for="contactMessage">PAYLOAD MESSAGE *</label>
                                <textarea id="contactMessage" name="message" rows="5" required placeholder="Enter telemetry payload..."><?= old('message') ?></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-submit-telemetry">
                                <span>TRANSMIT SIGNAL</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                                    <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Project Inspector Modal (Hydrated Dynamically via script.js from Database) -->
    <div class="project-modal-backdrop" id="projectModalBackdrop" aria-hidden="true">
        <div class="project-modal-container" id="projectModal" role="dialog" aria-modal="true" aria-labelledby="modalProjectTitle">
            <div class="modal-corner-bracket modal-corner-tl"></div>
            <div class="modal-corner-bracket modal-corner-tr"></div>
            <div class="modal-corner-bracket modal-corner-bl"></div>
            <div class="modal-corner-bracket modal-corner-br"></div>
            
            <div class="modal-header-telemetry">
                <div class="modal-meta-left">
                    <span class="modal-pulse-pip"></span>
                    <span class="modal-code-id" id="modalProjectId">PROJECT.INSPECTOR // ARCHITECTURE</span>
                    <span class="modal-category-tag" id="modalProjectCategory">C# .NET</span>
                </div>
                <div class="modal-header-actions">
                    <button class="project-modal-close-btn" id="projectModalCloseBtn" aria-label="Close Project Inspector">&times;</button>
                </div>
            </div>

            <div class="modal-body-scrollable">
                <div class="modal-hero-strip">
                    <h3 class="project-modal-title" id="modalProjectTitle">Project Title</h3>
                    <p class="project-modal-tagline" id="modalProjectTagline">Architecture overview and system purpose.</p>
                </div>

                <div class="modal-specs-bar">
                    <div class="modal-spec-col">
                        <span class="project-spec-key">TARGET ENVIRONMENT</span>
                        <span class="project-spec-value" id="modalProjectEnv">Proxmox VE &bull; Linux</span>
                    </div>
                    <div class="modal-spec-col">
                        <span class="project-spec-key">EXECUTION TELEMETRY</span>
                        <span class="project-spec-value" id="modalProjectPerf">Sub-millisecond &bull; Low Memory Footprint</span>
                    </div>
                    <div class="modal-spec-col">
                        <span class="project-spec-key">STATUS</span>
                        <span class="project-spec-value modal-status-active" id="modalProjectStatus">Active &bull; Operational</span>
                    </div>
                </div>

                <div class="modal-section-block">
                    <h4 class="modal-block-heading">// ARCHITECTURAL SPECIFICATION</h4>
                    <p class="modal-block-text" id="modalProjectDesc">Detailed technical breakdown.</p>
                </div>

                <div class="modal-section-block">
                    <h4 class="modal-block-heading">// KEY SYSTEM CAPABILITIES</h4>
                    <ul class="modal-features-list" id="modalProjectFeatures"></ul>
                </div>

                <div class="modal-section-block">
                    <div class="modal-code-header">
                        <h4 class="modal-block-heading" style="margin:0;">// SYSTEM ARCHITECTURE LOGIC</h4>
                        <span class="code-file-tag" id="modalCodeFileName">Architecture.cs</span>
                    </div>
                    <pre class="modal-code-viewer"><code id="modalProjectCode">// Code goes here</code></pre>
                </div>
            </div>

            <div class="modal-footer-telemetry">
                <div class="modal-tech-pills-row" id="modalProjectTechPills"></div>
                <div class="modal-footer-actions">
                    <a href="https://github.com/x64_emkei" target="_blank" rel="noopener noreferrer" class="btn btn-outline" id="modalProjectGithubLink">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                            <path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"/>
                            <path d="M9 18c-4.51 2-5-2-7-2"/>
                        </svg>
                        <span>Source Code</span>
                    </a>
                    <button class="btn btn-primary" id="modalProjectCloseActionBtn" type="button">Dismiss</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Inject Database Data to Client-side Window Bridge -->
    <script>
        window.__SERVER_PROJECTS__ = <?= json_encode(array_combine(
            array_column($projects, 'slug'),
            array_map(function($p) {
                return [
                    'id' => $p['code_id'],
                    'category' => $p['category'],
                    'title' => $p['title'],
                    'tagline' => $p['tagline'],
                    'env' => $p['environment'],
                    'perf' => $p['performance_metric'],
                    'status' => $p['operational_status'],
                    'desc' => $p['description'],
                    'features' => json_decode($p['features_json'] ?: '[]', true),
                    'fileName' => $p['code_filename'],
                    'code' => $p['code_snippet'],
                    'tech' => json_decode($p['technologies_json'] ?: '[]', true),
                    'github' => $p['github_url'],
                    'demo' => $p['demo_url']
                ];
            }, $projects)
        ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;

        window.__SERVER_HARDWARE__ = <?= json_encode(array_map(function($h) {
            return [
                'nodeId' => $h['node_id'],
                'tag' => $h['tag'],
                'title' => $h['title'],
                'subtitle' => $h['subtitle'],
                'oem' => $h['oem'],
                'specs' => json_decode($h['specs_json'] ?: '{}', true),
                'log' => $h['diagnostics_log'],
                'img' => $h['image_url']
            ];
        }, $hardwareNodes), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
    </script>

    <!-- Client Script -->
    <script src="<?= asset('script.js') ?>"></script>
</body>
</html>
