<?php
$secHelper = new \App\Renderers\SectionRenderer($sections ?? []);
$secJournal = $secHelper->getSection('journal');
$activeSub = $activeSub ?? 'blog';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= e($metaDesc ?? 'Journal & Telemetry Log by Michael Benedict Ordenes') ?>">
    <title><?= e($pageTitle ?? 'Journal & Telemetry Log // x64emkei.dev') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('style.css') ?>">
</head>
<body>

    <!-- Unified HUD Navigation (Utility Bar + Sidebar Rail + Mobile Drawer) -->
    <?php require __DIR__ . '/../partials/header_nav.php'; ?>

    <main class="main-content">
        <div class="view-wrapper">
            <div class="page-container" data-initial-section="<?= e($activeSub) ?>">
                <!-- Breadcrumbs -->
                <nav class="hud-breadcrumb" aria-label="Breadcrumb">
                    <a href="<?= url('/') ?>">HOME</a>
                    <span class="sep">/</span>
                    <a href="<?= url('journal') ?>">JOURNAL</a>
                    <span class="sep">/</span>
                    <span class="current" id="breadcrumbActiveSection">FIELD NOTES &amp; DISPATCHES</span>
                </nav>

                <!-- Section Watermark & Header -->
                <div class="section-watermark-num">03</div>
                <div class="section-header">
                    <span class="section-subtitle">// FIELD NOTES, ARCHITECTURE BREAKDOWNS &amp; DISPATCHES</span>
                    <h2 class="section-title"><?= e($secJournal['title'] ?: 'Journal &amp; Telemetry Log') ?></h2>
                    <div class="section-divider"></div>
                </div>

                <!-- Subnav Tabs -->
                <div class="subnav-tabs" role="tablist" aria-label="Journal sections">
                    <a href="#blog" class="subnav-btn section-anchor-link active" data-target-section="blog" role="tab">01. Blog &amp; Articles</a>
                    <a href="#tutorials" class="subnav-btn section-anchor-link" data-target-section="tutorials" role="tab">02. Tutorials</a>
                    <a href="#technical-notes" class="subnav-btn section-anchor-link" data-target-section="technical-notes" role="tab">03. Technical Notes</a>
                    <a href="#research" class="subnav-btn section-anchor-link" data-target-section="research" role="tab">04. Research</a>
                    <a href="#ai-manifesto" class="subnav-btn section-anchor-link" data-target-section="ai-manifesto" role="tab" style="color: var(--primary); border-color: var(--primary);">05. AI Manifesto</a>
                </div>

                <!-- SECTION 1: BLOG & ARTICLES -->
                <section id="blog" class="content-section" data-section-name="Blog and Articles" style="margin-bottom: 48px;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 18px;">
                        <h3 class="bento-heading" style="margin: 0; font-size: var(--font-size-lg); color: var(--accent-cyan);">
                            // 01. BLOG &amp; TECHNICAL ARTICLES
                        </h3>
                        <span style="font-family: var(--font-mono); font-size: var(--font-size-2xs); color: var(--text-muted);">
                            SYSTEM ARCHITECTURES
                        </span>
                    </div>

                    <?php if (empty($articles)): ?>
                        <div class="bento-card" style="text-align: center; padding: 40px 24px;">
                            <div class="bento-tag" style="justify-content: center; margin-bottom: 12px;">
                                <span class="tag-rec-dot"></span>
                                <span>DISPATCHES // STAGING</span>
                            </div>
                            <h3 class="bento-heading">Articles &amp; Field Notes are currently being authored</h3>
                            <p style="color: var(--text-secondary); max-width: 550px; margin: 0 auto 18px auto; line-height: 1.6;">
                                In-depth explorations of modern PHP backend design, server virtualization architectures, and zero-trust mesh networking.
                            </p>
                        </div>
                    <?php else: ?>
                        <div style="display: flex; flex-direction: column; gap: 18px;">
                            <?php foreach ($articles as $art): ?>
                            <article class="bento-card" style="padding: 24px 28px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                    <span class="bento-tag" style="margin-bottom: 0;">
                                        <span class="tag-rec-dot"></span>
                                        <span><?= strtoupper(e($art['category'] ?? 'DISPATCH')) ?></span>
                                    </span>
                                    <span style="font-family: var(--font-mono); font-size: var(--font-size-2xs); color: var(--text-muted);">
                                        <?= e($art['published_at'] ? date('Y.m.d', strtotime($art['published_at'])) : '') ?>
                                    </span>
                                </div>
                                <h3 style="font-family: var(--font-display); font-size: var(--font-size-xl); margin: 8px 0 10px 0; color: var(--text-primary);">
                                    <a href="<?= url('journal/' . $art['slug']) ?>" style="color: inherit; text-decoration: none;">
                                        <?= e($art['title']) ?>
                                    </a>
                                </h3>
                                <p style="color: var(--text-secondary); font-size: var(--font-size-base); line-height: 1.6; margin: 0 0 16px 0;">
                                    <?= e($art['excerpt'] ?? '') ?>
                                </p>
                                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border); padding-top: 12px; font-family: var(--font-mono); font-size: var(--font-size-xs);">
                                    <a href="<?= url('journal/' . $art['slug']) ?>" style="color: var(--accent-cyan); text-decoration: none; font-weight: 600;">
                                        READ DISPATCH &rarr;
                                    </a>
                                    <span style="color: var(--text-muted);">
                                        <?= e($art['reading_time_minutes'] ?? 4) ?> MIN READ
                                    </span>
                                </div>
                            </article>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </section>

                <!-- SECTION 2: TUTORIALS -->
                <section id="tutorials" class="content-section" data-section-name="Tutorials" style="margin-bottom: 48px;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 18px;">
                        <h3 class="bento-heading" style="margin: 0; font-size: var(--font-size-lg); color: var(--accent-cyan);">
                            // 02. TUTORIALS &amp; ENGINEERING GUIDES
                        </h3>
                        <span style="font-family: var(--font-mono); font-size: var(--font-size-2xs); color: var(--text-muted);">
                            STEP-BY-STEP LAB PROTOCOLS
                        </span>
                    </div>

                    <div class="about-bento-grid">
                        <div class="bento-card" style="grid-column: span 6;">
                            <div class="bento-tag">
                                <span class="tag-rec-dot"></span>
                                <span>TUTORIAL // HYPERVISOR</span>
                            </div>
                            <h3 class="bento-heading">Proxmox VE 8.x Automated Cluster Provisioning</h3>
                            <p style="color: var(--text-secondary); font-size: var(--font-size-sm); line-height: 1.6;">
                                Configuring SDN network interfaces, ZFS mirror storage datasets, and cloud-init templated Debian LXCs for staging workflows.
                            </p>
                            <div class="skills-badge-list" style="margin-top: 12px;">
                                <span class="skill-badge skill-badge-highlight">Guide</span>
                                <span class="skill-badge">Proxmox</span>
                                <span class="skill-badge">LXC / ZFS</span>
                            </div>
                        </div>

                        <div class="bento-card" style="grid-column: span 6;">
                            <div class="bento-tag">
                                <span class="tag-rec-dot"></span>
                                <span>TUTORIAL // ENCRYPTED MESH</span>
                            </div>
                            <h3 class="bento-heading">Zero-Trust Mesh Networking with Tailscale &amp; Docker</h3>
                            <p style="color: var(--text-secondary); font-size: var(--font-size-sm); line-height: 1.6;">
                                Establishing secure encrypted tunnels, MagicDNS routing, and isolated container ingress without exposed port forwarding.
                            </p>
                            <div class="skills-badge-list" style="margin-top: 12px;">
                                <span class="skill-badge skill-badge-highlight">Guide</span>
                                <span class="skill-badge">WireGuard</span>
                                <span class="skill-badge">Tailscale</span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- SECTION 3: TECHNICAL NOTES -->
                <section id="technical-notes" class="content-section" data-section-name="Technical Notes" style="margin-bottom: 48px;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 18px;">
                        <h3 class="bento-heading" style="margin: 0; font-size: var(--font-size-lg); color: var(--accent-cyan);">
                            // 03. TECHNICAL NOTES &amp; DIAGNOSTICS
                        </h3>
                        <span style="font-family: var(--font-mono); font-size: var(--font-size-2xs); color: var(--text-muted);">
                            SYSTEM LOGS &amp; SNIPPETS
                        </span>
                    </div>

                    <div class="bento-card">
                        <div class="bento-tag">
                            <span class="tag-rec-dot"></span>
                            <span>FIELD NOTES // ARCHITECTURE</span>
                        </div>
                        <h3 class="bento-heading">Defensive PHP 8.2 Architectural Patterns</h3>
                        <p style="color: var(--text-secondary); font-size: var(--font-size-sm); line-height: 1.6;">
                            Analyzing pure PDO prepared statement parametrization, immutable request context, strict type enforcement, and zero-runtime dependency rendering pipelines.
                        </p>
                        <div class="skills-badge-list" style="margin-top: 12px;">
                            <span class="skill-badge">PHP 8.2</span>
                            <span class="skill-badge">Zero-Trust Security</span>
                            <span class="skill-badge">PDO Transactions</span>
                        </div>
                    </div>
                </section>

                <!-- SECTION 4: RESEARCH & INSIGHTS -->
                <section id="research" class="content-section" data-section-name="Research" style="margin-bottom: 48px;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 18px;">
                        <h3 class="bento-heading" style="margin: 0; font-size: var(--font-size-lg); color: var(--accent-cyan);">
                            // 04. RESEARCH &amp; HARDWARE INVESTIGATIONS
                        </h3>
                        <span style="font-family: var(--font-mono); font-size: var(--font-size-2xs); color: var(--text-muted);">
                            COMPUTING PRESERVATION
                        </span>
                    </div>

                    <div class="bento-card">
                        <div class="bento-tag">
                            <span class="tag-rec-dot"></span>
                            <span>RESEARCH // VINTAGE SILICON</span>
                        </div>
                        <h3 class="bento-heading">Thermal &amp; Microcode Analysis on Ultraportable x86 Silicon</h3>
                        <p style="color: var(--text-secondary); font-size: var(--font-size-sm); line-height: 1.6;">
                            Comparative study of thermal dissipation and modern lightweight Linux distributions across Intel Atom N280, Pentium M ULV 753, and Core 2 Duo legacy architectures.
                        </p>
                        <div class="skills-badge-list" style="margin-top: 12px;">
                            <span class="skill-badge">Hardware Diagnostics</span>
                            <span class="skill-badge">Silicon Preservation</span>
                            <span class="skill-badge">Debian Minimal</span>
                        </div>
                    </div>
                </section>

                <!-- SECTION 5: AI MANIFESTO SPOTLIGHT -->
                <section id="ai-manifesto" class="content-section" data-section-name="AI Manifesto" style="margin-bottom: 48px;">
                    <div class="bento-card" style="border: 2px solid var(--primary); background: linear-gradient(145deg, rgba(255, 42, 42, 0.08) 0%, rgba(9, 11, 16, 0.95) 100%); padding: 32px 28px;">
                        <div class="bento-tag">
                            <span class="tag-rec-dot" style="background: var(--primary);"></span>
                            <span>STANDALONE MANIFESTO // ETHICS &amp; SYMBIOSIS</span>
                            <div class="win-controls">
                                <span class="win-btn">_</span>
                                <span class="win-btn win-close">&times;</span>
                            </div>
                        </div>
                        <h3 class="bento-heading" style="color: var(--text-primary); font-size: var(--font-size-xl); margin: 12px 0 10px 0;">
                            AI Manifesto v1.0
                        </h3>
                        <p style="color: var(--text-secondary); font-size: var(--font-size-base); line-height: 1.6; max-width: 720px; margin-bottom: 20px;">
                            A formal statement of principles on the transparent, ethical, and symbiotic utilization of Artificial Intelligence in software engineering. Exploring how intelligent tools enhance human agency rather than replace deep architectural understanding.
                        </p>
                        <div style="display: flex; gap: 14px; flex-wrap: wrap;">
                            <a href="<?= url('journal/ai-manifesto') ?>" class="btn btn-primary" style="text-decoration: none;">
                                <span>Read Full Manifesto &rarr;</span>
                            </a>
                            <a href="<?= url('contact#inquiry') ?>" class="btn btn-outline" style="text-decoration: none;">
                                <span>Discuss with Operator</span>
                            </a>
                        </div>
                    </div>
                </section>

            </div>
        </div>
        <!-- Website Footer Component -->
        <?php require __DIR__ . '/../partials/footer.php'; ?>
    </main>

    <script src="<?= asset('script.js') ?>"></script>
</body>
</html>
