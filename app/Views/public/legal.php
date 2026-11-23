<?php
$legalType = $legalType ?? 'privacy';

$titles = [
    'privacy' => 'Privacy Policy & Data Telemetry',
    'terms' => 'Terms of Use & Code Disclaimers',
    'accessibility' => 'Accessibility Statement & WCAG 2.2 AA Conformance',
    'sitemap' => 'Complete Architecture & HTML Sitemap',
];

$pageTitle = $titles[$legalType] ?? 'Website Information';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> // x64emkei.dev</title>
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
            <div class="page-container">
                <!-- Breadcrumbs -->
                <nav class="hud-breadcrumb" aria-label="Breadcrumb">
                    <a href="<?= url('/') ?>">HOME</a>
                    <span class="sep">/</span>
                    <a href="<?= url($legalType) ?>"><?= strtoupper(e($legalType)) ?></a>
                    <span class="sep">/</span>
                    <span class="current">LEGAL & COMPLIANCE</span>
                </nav>

                <!-- Page Header -->
                <div style="margin-bottom: 30px; border-bottom: 1px solid rgba(0, 229, 255, 0.2); padding-bottom: 24px;">
                    <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: #ff3366; letter-spacing: 1px; margin-bottom: 8px;">
                        // TELEMETRY & COMPLIANCE SPECIFICATION
                    </div>
                    <h1 style="font-family: 'Space Grotesk', sans-serif; font-size: 2.2rem; color: #f8fafc; margin: 0 0 10px 0;">
                        <?= e($pageTitle) ?>
                    </h1>
                    <p style="color: #94a3b8; font-size: 0.95rem; margin: 0; line-height: 1.6;">
                        Standardized legal documentation, accessibility audit standards, and transparent telemetry disclosures for the X64EMKEI platform.
                    </p>
                </div>

                <!-- Subnav Tabs -->
                <div class="subnav-tabs">
                    <a href="<?= url('privacy') ?>" class="subnav-btn <?= $legalType === 'privacy' ? 'active' : '' ?>">Privacy Policy</a>
                    <a href="<?= url('terms') ?>" class="subnav-btn <?= $legalType === 'terms' ? 'active' : '' ?>">Terms of Use</a>
                    <a href="<?= url('accessibility') ?>" class="subnav-btn <?= $legalType === 'accessibility' ? 'active' : '' ?>">Accessibility (WCAG 2.2)</a>
                    <a href="<?= url('sitemap') ?>" class="subnav-btn <?= $legalType === 'sitemap' ? 'active' : '' ?>">HTML Sitemap</a>
                </div>

                <?php if ($legalType === 'privacy'): ?>
                <div class="section-box">
                    <h2 style="color: #00e5ff; font-family: 'Space Grotesk', sans-serif; font-size: 1.4rem; margin-top: 0;">// 1. DATA PRIVACY & TRANSMISSION PRINCIPLES</h2>
                    <p style="color: #cbd5e1; line-height: 1.7; font-size: 0.95rem;">
                        The X64EMKEI digital platform operates on a zero-tracking, privacy-first architecture. We do not sell, monetize, or harvest personal user profiles. Any information submitted through the contact inquiry form is transmitted securely via HTTPS and stored in encrypted databases solely for direct professional correspondence.
                    </p>
                    <h3 style="color: #f8fafc; font-family: 'JetBrains Mono', monospace; font-size: 1.05rem; margin: 20px 0 10px 0;">// TELEMETRY LOGS & HTTP HEADERS</h3>
                    <p style="color: #94a3b8; line-height: 1.6; font-size: 0.92rem;">
                        Standard web server access logs record HTTP request headers, timestamps (recorded in Philippine Standard Time, UTC+8), IP addresses, and response status codes strictly for rate-limiting, bot mitigation, and defensive cybersecurity operations. Logs are rotated periodically and purged.
                    </p>
                </div>

                <?php elseif ($legalType === 'terms'): ?>
                <div class="section-box">
                    <h2 style="color: #00e5ff; font-family: 'Space Grotesk', sans-serif; font-size: 1.4rem; margin-top: 0;">// 1. CODE USAGE & INTELLECTUAL PROPERTY</h2>
                    <p style="color: #cbd5e1; line-height: 1.7; font-size: 0.95rem;">
                        All original technical articles, tutorials, source code snippets, and blueprints published on this website are authored by <strong>Michael Benedict Ordenes</strong> unless explicitly cited otherwise. Open-source code repositories linked from this portfolio are governed by their respective licenses (e.g., MIT, Apache 2.0, or GPLv3).
                    </p>
                    <h3 style="color: #f8fafc; font-family: 'JetBrains Mono', monospace; font-size: 1.05rem; margin: 20px 0 10px 0;">// TECHNICAL DISCLAIMER</h3>
                    <p style="color: #94a3b8; line-height: 1.6; font-size: 0.92rem;">
                        Technical documentation, hardware restoration guides, and network configuration tutorials are provided for educational and research purposes. System operators assume full responsibility when replicating homelab setups, firmware flashes, or virtualization configurations.
                    </p>
                </div>

                <?php elseif ($legalType === 'accessibility'): ?>
                <div class="section-box">
                    <h2 style="color: #00e5ff; font-family: 'Space Grotesk', sans-serif; font-size: 1.4rem; margin-top: 0;">// 1. ACCESSIBILITY COMMITMENT (WCAG 2.2 AA)</h2>
                    <p style="color: #cbd5e1; line-height: 1.7; font-size: 0.95rem;">
                        X64EMKEI is committed to digital inclusivity and accessible engineering. Our HUD interface is designed to meet or exceed <strong>WCAG 2.2 Level AA</strong> requirements across all viewports.
                    </p>
                    <h3 style="color: #f8fafc; font-family: 'JetBrains Mono', monospace; font-size: 1.05rem; margin: 20px 0 10px 0;">// ACCESSIBILITY IMPLEMENTATIONS</h3>
                    <ul style="color: #94a3b8; line-height: 1.8; font-size: 0.92rem; padding-left: 20px;">
                        <li><strong>Visible Keyboard Focus Rings:</strong> High-contrast cyan outline (<code>2px solid #00E5FF</code>) on all interactive controls.</li>
                        <li><strong>Reduced Motion Compliance:</strong> Complete fallback under <code>prefers-reduced-motion: reduce</code>, disabling transitions and laser animations.</li>
                        <li><strong>Touch-Friendly Targets:</strong> Minimum interactive target area of 44&times;44px on mobile devices.</li>
                        <li><strong>Contrast Ratio:</strong> Standard text contrast exceeds 4.5:1 ratio on both Dark and Light theme surfaces.</li>
                        <li><strong>Semantic HTML Landmarks:</strong> Full ARIA landmarks (<code>role="banner"</code>, <code>role="navigation"</code>, <code>role="main"</code>, <code>role="contentinfo"</code>).</li>
                    </ul>
                </div>

                <?php elseif ($legalType === 'sitemap'): ?>
                <div class="section-box">
                    <h2 style="color: #00e5ff; font-family: 'Space Grotesk', sans-serif; font-size: 1.4rem; margin-top: 0;">// COMPLETE PLATFORM SITEMAP</h2>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 24px; margin-top: 20px;">
                        <div style="background: rgba(0,0,0,0.3); padding: 18px; border-radius: 4px; border-left: 3px solid #00e5ff;">
                            <h3 style="color: #f8fafc; font-family: 'JetBrains Mono', monospace; font-size: 1rem; margin-top: 0;">// 1. HOME & PROFILE</h3>
                            <ul style="list-style: none; padding: 0; line-height: 1.8; font-size: 0.88rem;">
                                <li><a href="<?= url('/') ?>" style="color: #00e5ff; text-decoration: none;">&rsaquo; Homepage & Telemetry</a></li>
                                <li><a href="<?= url('/#featured') ?>" style="color: #94a3b8; text-decoration: none;">&rsaquo; Featured Programs</a></li>
                            </ul>
                        </div>
                        <div style="background: rgba(0,0,0,0.3); padding: 18px; border-radius: 4px; border-left: 3px solid #ff3366;">
                            <h3 style="color: #f8fafc; font-family: 'JetBrains Mono', monospace; font-size: 1rem; margin-top: 0;">// 2. ABOUT DOSSIER</h3>
                            <ul style="list-style: none; padding: 0; line-height: 1.8; font-size: 0.88rem;">
                                <li><a href="<?= url('about#biography') ?>" style="color: #00e5ff; text-decoration: none;">&rsaquo; Biography & Focus</a></li>
                                <li><a href="<?= url('about#education') ?>" style="color: #94a3b8; text-decoration: none;">&rsaquo; Education History</a></li>
                                <li><a href="<?= url('about#skills') ?>" style="color: #94a3b8; text-decoration: none;">&rsaquo; Technical Proficiencies</a></li>
                                <li><a href="<?= url('about#experience') ?>" style="color: #94a3b8; text-decoration: none;">&rsaquo; Experience & Roles</a></li>
                                <li><a href="<?= url('about#certifications') ?>" style="color: #94a3b8; text-decoration: none;">&rsaquo; Certifications & Honors</a></li>
                            </ul>
                        </div>
                        <div style="background: rgba(0,0,0,0.3); padding: 18px; border-radius: 4px; border-left: 3px solid #ffb800;">
                            <h3 style="color: #f8fafc; font-family: 'JetBrains Mono', monospace; font-size: 1rem; margin-top: 0;">// 3. WORK & LABS</h3>
                            <ul style="list-style: none; padding: 0; line-height: 1.8; font-size: 0.88rem;">
                                <li><a href="<?= url('work#portfolio') ?>" style="color: #00e5ff; text-decoration: none;">&rsaquo; Portfolio & Projects</a></li>
                                <li><a href="<?= url('work#services') ?>" style="color: #94a3b8; text-decoration: none;">&rsaquo; Engineering Services</a></li>
                                <li><a href="<?= url('work#laboratory') ?>" style="color: #94a3b8; text-decoration: none;">&rsaquo; Technical Laboratory</a></li>
                                <li><a href="<?= url('work#hardware') ?>" style="color: #94a3b8; text-decoration: none;">&rsaquo; Hardware Archive</a></li>
                            </ul>
                        </div>
                        <div style="background: rgba(0,0,0,0.3); padding: 18px; border-radius: 4px; border-left: 3px solid #10b981;">
                            <h3 style="color: #f8fafc; font-family: 'JetBrains Mono', monospace; font-size: 1rem; margin-top: 0;">// 4. JOURNAL</h3>
                            <ul style="list-style: none; padding: 0; line-height: 1.8; font-size: 0.88rem;">
                                <li><a href="<?= url('journal#blog') ?>" style="color: #00e5ff; text-decoration: none;">&rsaquo; Blog Transmissions</a></li>
                                <li><a href="<?= url('journal#tutorials') ?>" style="color: #94a3b8; text-decoration: none;">&rsaquo; Tutorials & Guides</a></li>
                                <li><a href="<?= url('journal#technical-notes') ?>" style="color: #94a3b8; text-decoration: none;">&rsaquo; Technical Notes</a></li>
                                <li><a href="<?= url('journal#research') ?>" style="color: #94a3b8; text-decoration: none;">&rsaquo; Research Papers</a></li>
                                <li><a href="<?= url('journal#ai-manifesto') ?>" style="color: #94a3b8; text-decoration: none;">&rsaquo; AI Manifesto v1.0</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
        <!-- Website Footer Component -->
        <?php require __DIR__ . '/partials/footer.php'; ?>
    </main>

    <script src="<?= asset('script.js') ?>"></script>
</body>
</html>
