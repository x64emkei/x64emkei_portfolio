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
<body>
    <a class="skip-link" href="#mainContent">Skip to main content</a>

    <!-- Unified HUD Navigation (Utility Bar + Sidebar Rail + Mobile Drawer) -->
    <?php require __DIR__ . '/partials/header_nav.php'; ?>

    <main class="main-content" id="mainContent" tabindex="-1">
        <div class="view-wrapper">
            <div class="page-container">
                <!-- Breadcrumbs -->
                <nav class="hud-breadcrumb" aria-label="Breadcrumb">
                    <a href="<?= url('/') ?>">HOME</a>
                    <span class="sep">/</span>
                    <a href="<?= url($legalType) ?>"><?= strtoupper(e($legalType)) ?></a>
                    <span class="sep">/</span>
                    <span class="current">LEGAL &amp; COMPLIANCE</span>
                </nav>

                <!-- Section Watermark & Header -->
                <div class="section-watermark-num">06</div>
                <div class="section-header">
                    <span class="section-subtitle">// PRIVACY &amp; SITE TERMS</span>
                    <h2 class="section-title"><?= e($pageTitle) ?></h2>
                    <div class="section-divider"></div>
                </div>

                <!-- Subnav Tabs -->
                <div class="subnav-tabs" role="tablist">
                    <a href="<?= url('privacy') ?>" class="subnav-btn <?= $legalType === 'privacy' ? 'active' : '' ?>">01. Privacy Policy</a>
                    <a href="<?= url('terms') ?>" class="subnav-btn <?= $legalType === 'terms' ? 'active' : '' ?>">02. Terms of Use</a>
                    <a href="<?= url('accessibility') ?>" class="subnav-btn <?= $legalType === 'accessibility' ? 'active' : '' ?>">03. Accessibility (WCAG 2.2)</a>
                    <a href="<?= url('sitemap') ?>" class="subnav-btn <?= $legalType === 'sitemap' ? 'active' : '' ?>">04. HTML Sitemap</a>
                </div>

                <?php if ($legalType === 'privacy'): ?>
                <div class="bento-card" style="padding: 32px 28px; margin-bottom: 40px;">
                    <div class="bento-tag">
                        <span class="tag-rec-dot" style="background: var(--primary);"></span>
                        <span>PRIVACY POLICY</span>
                    </div>
                    <h3 class="bento-heading" style="color: var(--text-primary); margin: 12px 0 10px 0;">
                        <span style="color: var(--primary); font-family: var(--font-mono); margin-right: 6px;">// 1.</span>DATA PRIVACY PRINCIPLES
                    </h3>
                    <p style="color: var(--text-secondary); line-height: 1.7; font-size: var(--font-size-base); margin-bottom: 24px;">
                        The X64EMKEI digital platform operates on a zero-tracking, privacy-first architecture. We do not sell, monetize, or harvest personal user profiles. Any information submitted through the contact inquiry form is transmitted securely via HTTPS and processed solely for direct professional correspondence.
                    </p>
                    <h4 style="color: var(--text-primary); font-family: var(--font-mono); font-size: var(--font-size-sm); margin: 0 0 10px 0;">
                        // LOGS &amp; HTTP HEADERS
                    </h4>
                    <p style="color: var(--text-muted); line-height: 1.6; font-size: var(--font-size-sm); margin: 0;">
                        Standard web server access logs record HTTP request headers, timestamps (recorded in Philippine Standard Time, UTC+8), IP addresses, and response status codes strictly for rate-limiting, bot mitigation, and defensive cybersecurity operations. Logs are rotated periodically and purged.
                    </p>
                </div>

                <?php elseif ($legalType === 'terms'): ?>
                <div class="bento-card" style="padding: 32px 28px; margin-bottom: 40px;">
                    <div class="bento-tag">
                        <span class="tag-rec-dot" style="background: var(--primary);"></span>
                        <span>TERMS OF USE // CODE DISCLAIMER</span>
                    </div>
                    <h3 class="bento-heading" style="color: var(--text-primary); margin: 12px 0 10px 0;">
                        <span style="color: var(--primary); font-family: var(--font-mono); margin-right: 6px;">// 1.</span>CODE USAGE &amp; INTELLECTUAL PROPERTY
                    </h3>
                    <p style="color: var(--text-secondary); line-height: 1.7; font-size: var(--font-size-base); margin-bottom: 24px;">
                        All original technical articles, tutorials, source code snippets, and blueprints published on this website are authored by <strong>Michael Benedict Ordenes</strong> unless explicitly cited otherwise. Open-source code repositories linked from this portfolio are governed by their respective licenses (e.g., MIT, Apache 2.0, or GPLv3).
                    </p>
                    <h4 style="color: var(--text-primary); font-family: var(--font-mono); font-size: var(--font-size-sm); margin: 0 0 10px 0;">
                        // TECHNICAL DISCLAIMER
                    </h4>
                    <p style="color: var(--text-muted); line-height: 1.6; font-size: var(--font-size-sm); margin: 0;">
                        Technical documentation, hardware restoration guides, and network configuration tutorials are provided for educational and research purposes. System operators assume full responsibility when replicating homelab setups, firmware flashes, or virtualization configurations.
                    </p>
                </div>

                <?php elseif ($legalType === 'accessibility'): ?>
                <div class="bento-card" style="padding: 32px 28px; margin-bottom: 40px;">
                    <div class="bento-tag">
                        <span class="tag-rec-dot" style="background: var(--primary);"></span>
                        <span>ACCESSIBILITY // WCAG 2.2 AA CONFORMANCE</span>
                    </div>
                    <h3 class="bento-heading" style="color: var(--text-primary); margin: 12px 0 10px 0;">
                        <span style="color: var(--primary); font-family: var(--font-mono); margin-right: 6px;">// 1.</span>ACCESSIBILITY COMMITMENT (WCAG 2.2 AA)
                    </h3>
                    <p style="color: var(--text-secondary); line-height: 1.7; font-size: var(--font-size-base); margin-bottom: 24px;">
                        X64EMKEI is committed to digital inclusivity and accessible engineering. Our HUD interface is designed to meet or exceed <strong>WCAG 2.2 Level AA</strong> requirements across all viewports.
                    </p>
                    <h4 style="color: var(--text-primary); font-family: var(--font-mono); font-size: var(--font-size-sm); margin: 0 0 12px 0;">
                        // ACCESSIBILITY IMPLEMENTATIONS
                    </h4>
                    <ul style="color: var(--text-secondary); line-height: 1.8; font-size: var(--font-size-sm); padding-left: 20px; margin: 0;">
                        <li><strong>Visible Keyboard Focus Rings:</strong> High-contrast crimson outline (<code>2px solid var(--primary)</code>) on all interactive controls.</li>
                        <li><strong>Reduced Motion Compliance:</strong> Complete fallback under <code>prefers-reduced-motion: reduce</code>, disabling transitions and laser animations.</li>
                        <li><strong>Touch-Friendly Targets:</strong> Minimum interactive target area of 44&times;44px on mobile devices.</li>
                        <li><strong>Contrast Ratio:</strong> Standard text contrast exceeds 4.5:1 ratio on both Dark and Light theme surfaces.</li>
                        <li><strong>Semantic HTML Landmarks:</strong> Full ARIA landmarks (<code>role="banner"</code>, <code>role="navigation"</code>, <code>role="main"</code>, <code>role="contentinfo"</code>).</li>
                    </ul>
                </div>

                <?php elseif ($legalType === 'sitemap'): ?>
                <div class="bento-card" style="padding: 32px 28px; margin-bottom: 40px;">
                    <div class="bento-tag">
                        <span class="tag-rec-dot" style="background: var(--primary);"></span>
                        <span>SITE MAP</span>
                    </div>
                    <h3 class="bento-heading" style="color: var(--text-primary); margin: 12px 0 16px 0;">
                        <span style="color: var(--primary); font-family: var(--font-mono); margin-right: 6px;">// 1.</span>COMPLETE PLATFORM SITEMAP
                    </h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
                        <div class="bento-card" style="padding: 20px; background: rgba(9, 11, 16, 0.8); border-left: 3px solid var(--primary);">
                            <h4 style="color: var(--text-primary); font-family: var(--font-mono); font-size: var(--font-size-sm); margin: 0 0 12px 0;">// 1. HOME &amp; PROFILE</h4>
                            <ul style="list-style: none; padding: 0; margin: 0; line-height: 2; font-size: var(--font-size-sm);">
                                <li><a href="<?= url('/') ?>" style="color: var(--primary); text-decoration: none;">&rsaquo; Homepage &amp; Telemetry</a></li>
                                <li><a href="<?= url('/#featured') ?>" style="color: var(--text-muted); text-decoration: none;">&rsaquo; Featured Programs</a></li>
                            </ul>
                        </div>
                        <div class="bento-card" style="padding: 20px; background: rgba(9, 11, 16, 0.8); border-left: 3px solid var(--primary);">
                            <h4 style="color: var(--text-primary); font-family: var(--font-mono); font-size: var(--font-size-sm); margin: 0 0 12px 0;">// 2. ABOUT</h4>
                            <ul style="list-style: none; padding: 0; margin: 0; line-height: 2; font-size: var(--font-size-sm);">
                                <li><a href="<?= url('about#biography') ?>" style="color: var(--primary); text-decoration: none;">&rsaquo; Biography &amp; Focus</a></li>
                                <li><a href="<?= url('about#education') ?>" style="color: var(--text-muted); text-decoration: none;">&rsaquo; Education History</a></li>
                                <li><a href="<?= url('about#skills') ?>" style="color: var(--text-muted); text-decoration: none;">&rsaquo; Technical Proficiencies</a></li>
                                <li><a href="<?= url('about#experience') ?>" style="color: var(--text-muted); text-decoration: none;">&rsaquo; Experience &amp; Roles</a></li>
                                <li><a href="<?= url('about#certifications') ?>" style="color: var(--text-muted); text-decoration: none;">&rsaquo; Certifications &amp; Honors</a></li>
                            </ul>
                        </div>
                        <div class="bento-card" style="padding: 20px; background: rgba(9, 11, 16, 0.8); border-left: 3px solid var(--accent-amber);">
                            <h4 style="color: var(--text-primary); font-family: var(--font-mono); font-size: var(--font-size-sm); margin: 0 0 12px 0;">// 3. WORK &amp; LABS</h4>
                            <ul style="list-style: none; padding: 0; margin: 0; line-height: 2; font-size: var(--font-size-sm);">
                                <li><a href="<?= url('work#portfolio') ?>" style="color: var(--primary); text-decoration: none;">&rsaquo; Portfolio &amp; Projects</a></li>
                                <li><a href="<?= url('work#services') ?>" style="color: var(--text-muted); text-decoration: none;">&rsaquo; Engineering Services</a></li>
                                <li><a href="<?= url('work#laboratory') ?>" style="color: var(--text-muted); text-decoration: none;">&rsaquo; Technical Laboratory</a></li>
                                <li><a href="<?= url('work#hardware') ?>" style="color: var(--text-muted); text-decoration: none;">&rsaquo; Hardware Archive</a></li>
                            </ul>
                        </div>
                        <div class="bento-card" style="padding: 20px; background: rgba(9, 11, 16, 0.8); border-left: 3px solid var(--accent-green);">
                            <h4 style="color: var(--text-primary); font-family: var(--font-mono); font-size: var(--font-size-sm); margin: 0 0 12px 0;">// 4. JOURNAL</h4>
                            <ul style="list-style: none; padding: 0; margin: 0; line-height: 2; font-size: var(--font-size-sm);">
                                <li><a href="<?= url('journal#blog') ?>" style="color: var(--primary); text-decoration: none;">&rsaquo; Blog Articles</a></li>
                                <li><a href="<?= url('journal#tutorials') ?>" style="color: var(--text-muted); text-decoration: none;">&rsaquo; Tutorials &amp; Guides</a></li>
                                <li><a href="<?= url('journal#technical-notes') ?>" style="color: var(--text-muted); text-decoration: none;">&rsaquo; Technical Notes</a></li>
                                <li><a href="<?= url('journal#research') ?>" style="color: var(--text-muted); text-decoration: none;">&rsaquo; Research Papers</a></li>
                                <li><a href="<?= url('journal/ai-manifesto') ?>" style="color: var(--primary); text-decoration: none;">&rsaquo; AI Principles</a></li>
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
