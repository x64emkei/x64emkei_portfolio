<?php
$activeSub = $activeSub ?? 'portfolio';
$secHelper = new \App\Renderers\SectionRenderer($sections ?? []);
$secPortfolio = $secHelper->getSection('projects');
$secServices = $secHelper->getSection('services');
$secLaboratory = $secHelper->getSection('laboratory');
$secHardware = $secHelper->getSection('hardware');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work, Services &amp; Technical Laboratory // <?= e($profile['full_name'] ?? 'Michael Benedict Ordenes') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('style.css') ?>">
</head>
<body>

    <!-- Unified HUD Navigation (Utility Bar + Sidebar Rail + Mobile Drawer) -->
    <?php require __DIR__ . '/partials/header_nav.php'; ?>

    <main class="main-content">
        <div class="view-wrapper">
            <div class="page-container" data-initial-section="<?= e($activeSub) ?>">
                <!-- Breadcrumbs -->
                <nav class="hud-breadcrumb" aria-label="Breadcrumb">
                    <a href="<?= url('/') ?>">HOME</a>
                    <span class="sep">/</span>
                    <a href="<?= url('work') ?>">WORK</a>
                    <span class="sep">/</span>
                    <span class="current" id="breadcrumbActiveSection">PROJECTS &amp; SERVICES</span>
                </nav>

                <!-- Section Watermark & Header -->
                <div class="section-watermark-num">02</div>
                <div class="section-header">
                    <span class="section-subtitle">// ENGINEERING PORTFOLIO, CAPABILITIES &amp; ARCHIVE</span>
                    <h2 class="section-title"><?= e($secPortfolio['title'] ?: 'Work &amp; Technical Catalog') ?></h2>
                    <div class="section-divider"></div>
                </div>

                <!-- Subnav Tabs (Anchor Jumps) -->
                <div class="subnav-tabs" role="tablist" aria-label="Work sections">
                    <a href="#portfolio" class="subnav-btn section-anchor-link active" data-target-section="portfolio" role="tab">Portfolio &amp; Projects</a>
                    <a href="#services" class="subnav-btn section-anchor-link" data-target-section="services" role="tab">Services &amp; Specialties</a>
                    <a href="#laboratory" class="subnav-btn section-anchor-link" data-target-section="laboratory" role="tab">Technical Laboratory</a>
                    <a href="#hardware" class="subnav-btn section-anchor-link" data-target-section="hardware" role="tab">Hardware Archive</a>
                </div>

                <!-- SECTION 1: PORTFOLIO & PROJECTS -->
                <section id="portfolio" class="content-section" data-section-name="Portfolio and Projects" style="margin-bottom: 48px;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 18px;">
                        <h3 class="bento-heading" style="margin: 0; font-size: var(--font-size-lg); color: var(--accent-cyan);">
                            // <?= e($secPortfolio['title'] ?: 'PORTFOLIO &amp; SOFTWARE PROJECTS') ?>
                        </h3>
                        <span style="font-family: var(--font-mono); font-size: var(--font-size-2xs); color: var(--text-muted);">
                            <?= e($secPortfolio['subtitle'] ?: 'ACTIVE TELEMETRY') ?>
                        </span>
                    </div>

                    <?php if (empty($projects)): ?>
                        <!-- Authentic Cybernetic Staging State -->
                        <div class="program-card program-card-wip" style="padding: 36px 28px; text-align: center;">
                            <div class="program-card-header" style="justify-content: center; margin-bottom: 12px;">
                                <div class="program-badge badge-wip">
                                    <span class="badge-dot-amber"></span>
                                    <span>CATALOG STATUS: STAGING &amp; DOCUMENTATION</span>
                                </div>
                            </div>
                            <h3 class="bento-heading" style="margin: 0 0 12px 0;">Projects are currently undergoing documentation &amp; verification</h3>
                            <p style="color: var(--text-secondary); font-size: var(--font-size-base); max-width: 650px; margin: 0 auto 24px auto; line-height: 1.6;">
                                Production dossiers, source code repositories, and engineering blueprints are being packaged for public showcase. In the meantime, explore our verified <strong>Technical Laboratory</strong>, <strong>Hardware Archive</strong>, or active <strong>Services</strong> below.
                            </p>
                            <div style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;">
                                <a href="#services" class="btn btn-primary section-anchor-link" data-target-section="services" style="text-decoration: none;">
                                    <span>Explore Services &darr;</span>
                                </a>
                                <a href="#laboratory" class="btn btn-outline section-anchor-link" data-target-section="laboratory" style="text-decoration: none;">
                                    <span>Inspect Tech Lab &darr;</span>
                                </a>
                                <a href="#hardware" class="btn btn-outline section-anchor-link" data-target-section="hardware" style="text-decoration: none;">
                                    <span>Hardware Archive &darr;</span>
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="featured-programs-grid">
                            <?php foreach ($projects as $proj): ?>
                            <div class="program-card">
                                <div class="program-card-header">
                                    <span class="program-badge">
                                        <span class="badge-dot"></span>
                                        <span><?= e($proj['category'] ?? 'SOFTWARE') ?></span>
                                    </span>
                                    <span style="font-family: var(--font-mono); font-size: var(--font-size-2xs); color: var(--accent-green);">
                                        ● <?= e($proj['operational_status'] ?? 'Active') ?>
                                    </span>
                                </div>
                                <h3 class="program-title" style="margin: 12px 0 8px 0;">
                                    <a href="<?= url('project/' . $proj['slug']) ?>" style="color: inherit; text-decoration: none;">
                                        <?= e($proj['title']) ?>
                                    </a>
                                </h3>
                                <p class="program-desc" style="color: var(--text-secondary); margin-bottom: 16px;">
                                    <?= e($proj['tagline']) ?>
                                </p>
                                <div class="program-card-footer" style="margin-top: auto; border-top: 1px solid var(--border); padding-top: 12px;">
                                    <a href="<?= url('project/' . $proj['slug']) ?>" style="color: var(--accent-cyan); font-family: var(--font-mono); font-size: var(--font-size-xs); text-decoration: none; font-weight: 600;">
                                        VIEW DOSSIER &rarr;
                                    </a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </section>

                <!-- SECTION 2: SERVICES & SPECIALTIES -->
                <section id="services" class="content-section" data-section-name="Services" style="margin-bottom: 48px;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 18px;">
                        <h3 class="bento-heading" style="margin: 0; font-size: var(--font-size-lg); color: var(--accent-cyan);">
                            // <?= e($secServices['title'] ?: 'SERVICES &amp; SPECIALTIES') ?>
                        </h3>
                        <span style="font-family: var(--font-mono); font-size: var(--font-size-2xs); color: var(--text-muted);">
                            <?= e($secServices['subtitle'] ?: 'WHAT I DO') ?>
                        </span>
                    </div>

                    <div class="services-grid">
                        <?php if (!empty($services)): ?>
                            <?php foreach ($services as $idx => $svc): ?>
                            <div class="service-card <?= ($idx === 0) ? 'service-card-red' : '' ?>">
                                <div class="service-num"><?= sprintf('%02d', $idx + 1) ?></div>
                                <div class="service-icon-box">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22" height="22">
                                        <polyline points="16 18 22 12 16 6"></polyline>
                                        <polyline points="8 6 2 12 8 18"></polyline>
                                    </svg>
                                </div>
                                <h3 class="service-title"><?= e($svc['title']) ?></h3>
                                <p class="service-desc"><?= nl2br(e($svc['description'])) ?></p>
                                <?php if (!empty($svc['features']) || !empty($svc['tagline'])): ?>
                                <ul class="service-features">
                                    <li><?= e($svc['features'] ?: $svc['tagline']) ?></li>
                                </ul>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Authentic Preset Service 1 (Span 7) -->
                            <div class="service-card service-card-red">
                                <div class="service-num">01</div>
                                <div class="service-icon-box">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24">
                                        <polyline points="16 18 22 12 16 6"></polyline>
                                        <polyline points="8 6 2 12 8 18"></polyline>
                                    </svg>
                                </div>
                                <h3 class="service-title">Modern Web &amp; Systems Engineering</h3>
                                <p class="service-desc">
                                    Building performant, responsive web applications and backend systems utilizing modern PHP 8.2+, pure HTML5/CSS3, and vanilla JavaScript without unnecessary runtime overhead.
                                </p>
                                <ul class="service-features">
                                    <li>Custom CMS Architectures &amp; RESTful APIs</li>
                                    <li>Accessible (WCAG 2.2 AA) Responsive Design</li>
                                    <li>High-performance Relational Schema Modeling</li>
                                    <li>Defensive Security (CSRF, XSS, SQLi Shielding)</li>
                                </ul>
                            </div>

                            <!-- Authentic Preset Service 2 (Span 5) -->
                            <div class="service-card">
                                <div class="service-num">02</div>
                                <div class="service-icon-box">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24">
                                        <rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect>
                                        <rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect>
                                        <line x1="6" y1="6" x2="6.01" y2="6"></line>
                                        <line x1="6" y1="18" x2="6.01" y2="18"></line>
                                    </svg>
                                </div>
                                <h3 class="service-title">Linux Server &amp; Cloud Infra</h3>
                                <p class="service-desc">
                                    Debian and Ubuntu server provisioning, security hardening, automated backup scheduling, SSH public key infrastructures, and system service monitoring.
                                </p>
                                <ul class="service-features">
                                    <li>Debian/Ubuntu Server Hardening</li>
                                    <li>Firewall Configuration (UFW &amp; iptables)</li>
                                    <li>Automated Task Automation &amp; Cron Workflows</li>
                                </ul>
                            </div>

                            <!-- Authentic Preset Service 3 (Span 4) -->
                            <div class="service-card">
                                <div class="service-num">03</div>
                                <div class="service-icon-box">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22" height="22">
                                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                                    </svg>
                                </div>
                                <h3 class="service-title">Virtualization &amp; Homelab</h3>
                                <p class="service-desc">
                                    Proxmox VE hypervisor clustering, Docker containerization, LXC segmentation, and Tailscale mesh VPN deployment for secure encrypted access.
                                </p>
                                <ul class="service-features">
                                    <li>Proxmox VE &amp; Docker Stacks</li>
                                    <li>Tailscale Mesh Network Overlays</li>
                                    <li>Local Self-Hosted Microservices</li>
                                </ul>
                            </div>

                            <!-- Authentic Preset Service 4 (Span 4) -->
                            <div class="service-card">
                                <div class="service-num">04</div>
                                <div class="service-icon-box">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22" height="22">
                                        <rect x="4" y="4" width="16" height="16" rx="2"/>
                                        <line x1="9" y1="9" x2="15" y2="15"/>
                                        <line x1="15" y1="9" x2="9" y2="15"/>
                                    </svg>
                                </div>
                                <h3 class="service-title">Hardware Diagnostics &amp; Repair</h3>
                                <p class="service-desc">
                                    Bench diagnostics, thermal management repasting, memory upgrades, BIOS recovery, and preservation of legacy computing hardware.
                                </p>
                                <ul class="service-features">
                                    <li>Component Testing &amp; Diagnostics</li>
                                    <li>Thermal Repasting &amp; Fan Replacement</li>
                                    <li>Retro Computing Restoration</li>
                                </ul>
                            </div>

                            <!-- Authentic Preset Service 5 (Span 4) -->
                            <div class="service-card">
                                <div class="service-num">05</div>
                                <div class="service-icon-box">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22" height="22">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 14 14"></polyline>
                                    </svg>
                                </div>
                                <h3 class="service-title">Technical Review &amp; Advisory</h3>
                                <p class="service-desc">
                                    Consultation on software architecture, code quality auditing, database normalization, and technical documentation writing.
                                </p>
                                <ul class="service-features">
                                    <li>Code Reviews &amp; Refactoring Guidance</li>
                                    <li>Security &amp; Performance Auditing</li>
                                    <li>Technical Dossier &amp; Specs Drafting</li>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

                <!-- SECTION 3: TECHNICAL LABORATORY -->
                <section id="laboratory" class="content-section" data-section-name="Technical Laboratory" style="margin-bottom: 48px;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 18px;">
                        <h3 class="bento-heading" style="margin: 0; font-size: var(--font-size-lg); color: var(--accent-cyan);">
                            // TECHNICAL LABORATORY &amp; INFRASTRUCTURE
                        </h3>
                        <span style="font-family: var(--font-mono); font-size: var(--font-size-2xs); color: var(--accent-green);">
                            ACTIVE MESH: TAILSCALE // PROXMOX VE
                        </span>
                    </div>

                    <div class="about-bento-grid">
                        <div class="bento-card" style="grid-column: span 6;">
                            <div class="bento-tag">
                                <span class="tag-rec-dot"></span>
                                <span>HYPERVISOR // PROXMOX CLUSTER</span>
                            </div>
                            <h3 class="bento-heading">Virtualized Compute Cluster</h3>
                            <p style="color: var(--text-secondary); font-size: var(--font-size-sm); line-height: 1.6;">
                                Dedicated homelab infrastructure hosting containerized staging environments, local database instances, and automated telemetry testing nodes under isolated VLAN boundaries.
                            </p>
                            <div class="skills-badge-list" style="margin-top: 12px;">
                                <span class="skill-badge skill-badge-highlight">Proxmox VE 8.x</span>
                                <span class="skill-badge">Debian 12 Bookworm</span>
                                <span class="skill-badge">ZFS Mirror Pool</span>
                            </div>
                        </div>

                        <div class="bento-card" style="grid-column: span 6;">
                            <div class="bento-tag">
                                <span class="tag-rec-dot"></span>
                                <span>NETWORKING // ENCRYPTED MESH</span>
                            </div>
                            <h3 class="bento-heading">Secure Tailscale Mesh</h3>
                            <p style="color: var(--text-secondary); font-size: var(--font-size-sm); line-height: 1.6;">
                                Zero-trust WireGuard mesh overlay interconnecting remote terminals, staging containers, and mobile diagnostic stations without exposing public ports.
                            </p>
                            <div class="skills-badge-list" style="margin-top: 12px;">
                                <span class="skill-badge">Tailscale WireGuard</span>
                                <span class="skill-badge">MagicDNS Routing</span>
                                <span class="skill-badge">ACL Access Rules</span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- SECTION 4: HARDWARE ARCHIVE -->
                <section id="hardware" class="content-section" data-section-name="Hardware Archive" style="margin-bottom: 48px;">
                    <div class="retro-header-row" style="margin-bottom: 18px;">
                        <div class="bento-tag">
                            <span class="tag-rec-dot"></span>
                            <span>RETRO HARDWARE LAB // LEGACY ARCHIVE</span>
                        </div>
                        <div class="retro-indicator">
                            <span class="indicator-pulse-dot"></span>
                            <span>Operational Nodes</span>
                        </div>
                    </div>

                    <div class="retro-machine-grid">
                        <?php if (!empty($hardwareNodes)): ?>
                            <?php foreach ($hardwareNodes as $idx => $node): ?>
                            <div class="retro-machine-card">
                                <div class="retro-card-top">
                                    <span class="retro-sys-id">NODE.<?= sprintf('%02d', $idx + 1) ?></span>
                                    <span class="retro-form-tag"><?= e($node['architecture'] ?? 'Hardware') ?></span>
                                </div>
                                <div class="retro-machine-content">
                                    <div class="retro-machine-name"><?= e($node['name']) ?></div>
                                    <div class="retro-machine-desc"><?= e($node['specs'] ?? $node['description'] ?? '') ?></div>
                                </div>
                                <div class="retro-status-bar">
                                    <span class="retro-status-active"><span class="retro-status-dot"></span><?= e($node['operational_status'] ?? 'Operational') ?></span>
                                    <span class="retro-oem-tag"><?= e($node['category'] ?? 'Laboratory') ?></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Machine 1: Sony Vaio W-series -->
                            <div class="retro-machine-card">
                                <div class="retro-card-top">
                                    <span class="retro-sys-id">NODE.01</span>
                                    <span class="retro-form-tag">Netbook</span>
                                </div>
                                <div class="retro-machine-content">
                                    <div class="retro-machine-name">Sony Vaio W-series VPCW115XG</div>
                                    <div class="retro-machine-desc">Intel Atom N280, 10.1&quot; WXGA (1366&times;768), island keyboard design. Classic Japanese ultraportable engineering.</div>
                                </div>
                                <div class="retro-status-bar">
                                    <span class="retro-status-active"><span class="retro-status-dot"></span>Preserved</span>
                                    <span class="retro-oem-tag">Sony VAIO</span>
                                </div>
                            </div>

                            <!-- Machine 2: Panasonic Lets Note -->
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
                                    <div class="retro-machine-desc">Intel Core 2 Duo platform, 15.0&quot; 4:3 matte panel, legacy serial &amp; parallel I/O, dedicated hardware diagnostic terminal.</div>
                                </div>
                                <div class="retro-status-bar">
                                    <span class="retro-status-active"><span class="retro-status-dot"></span>Diagnostic Rig</span>
                                    <span class="retro-oem-tag">HP / Compaq</span>
                                </div>
                            </div>

                            <!-- Machine 4: HP Pavilion a6000 -->
                            <div class="retro-machine-card">
                                <div class="retro-card-top">
                                    <span class="retro-sys-id">NODE.04</span>
                                    <span class="retro-form-tag">Mid-Tower Sleeper</span>
                                </div>
                                <div class="retro-machine-content">
                                    <div class="retro-machine-name">HP Pavilion a6000 Sleeper Build</div>
                                    <div class="retro-machine-desc">Modernized internal chassis with active cooling, SSD cache storage array, and dedicated staging server node.</div>
                                </div>
                                <div class="retro-status-bar">
                                    <span class="retro-status-active"><span class="retro-status-dot"></span>Active Build</span>
                                    <span class="retro-oem-tag">Custom Lab</span>
                                </div>
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
