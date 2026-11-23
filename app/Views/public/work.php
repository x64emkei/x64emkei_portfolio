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
    <title>Work, Services & Technical Laboratory // Michael Benedict Ordenes</title>
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
            <div class="work-container" data-initial-section="<?= e($activeSub) ?>">
                <!-- Breadcrumbs -->
                <nav class="hud-breadcrumb" aria-label="Breadcrumb">
                    <a href="<?= url('/') ?>">HOME</a>
                    <span class="sep">/</span>
                    <a href="<?= url('work') ?>">WORK</a>
                    <span class="sep">/</span>
                    <span class="current" id="breadcrumbActiveSection">PROJECTS & SERVICES</span>
                </nav>

                <!-- Page Header -->
                <div style="margin-bottom: 30px; border-bottom: 1px solid rgba(0, 229, 255, 0.2); padding-bottom: 24px;">
                    <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: #ff3366; letter-spacing: 1px; margin-bottom: 8px;">
                        // ENGINEERING PORTFOLIO, CAPABILITIES & ARCHIVE
                    </div>
                    <h1 style="font-family: 'Space Grotesk', sans-serif; font-size: 2.2rem; color: #f8fafc; margin: 0 0 10px 0;">
                        Engineering Work & Technical Catalog
                    </h1>
                    <p style="color: #94a3b8; font-size: 0.95rem; margin: 0; line-height: 1.6;">
                        Software projects, professional services, virtualization laboratories, and physical computing archives engineered with reliability in mind.
                    </p>
                </div>

                <!-- Subnav Tabs (Anchor Jumps) -->
                <div class="subnav-tabs" role="tablist" aria-label="Work sections">
                    <a href="#portfolio" class="subnav-btn nav-anchor-link" data-target="portfolio">Portfolio & Projects</a>
                    <a href="#services" class="subnav-btn nav-anchor-link" data-target="services">Services</a>
                    <a href="#laboratory" class="subnav-btn nav-anchor-link" data-target="laboratory">Technical Laboratory</a>
                    <a href="#hardware" class="subnav-btn nav-anchor-link" data-target="hardware">Hardware Archive</a>
                </div>

                <!-- SECTION 1: PORTFOLIO & PROJECTS -->
                <section id="portfolio" class="content-section" data-section-name="Portfolio and Projects">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 16px;">
                        <h2 style="color: #00e5ff; font-family: 'Space Grotesk', sans-serif; font-size: 1.5rem; margin: 0;">
                            // <?= e($secPortfolio['title'] ?: '1. PORTFOLIO & SOFTWARE PROJECTS') ?>
                        </h2>
                        <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #64748b;">
                            <?= e($secPortfolio['subtitle'] ?: 'ACTIVE TELEMETRY') ?>
                        </span>
                    </div>

                    <?php if (empty($projects)): ?>
                        <!-- Polished, Authentic Empty State as Directed by Master Prompt -->
                        <div class="section-box" style="text-align: center; padding: 48px 24px; border: 1px dashed rgba(0, 229, 255, 0.25);">
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: #ffb800; margin-bottom: 12px; letter-spacing: 1px;">
                                [CATALOG STATUS: STAGING & DOCUMENTATION IN PROGRESS]
                            </div>
                            <h3 style="font-family: 'Space Grotesk', sans-serif; color: #f8fafc; font-size: 1.5rem; margin: 0 0 12px 0;">
                                Projects are currently being developed and documented.
                            </h3>
                            <p style="color: #94a3b8; font-size: 0.95rem; max-width: 620px; margin: 0 auto 24px auto; line-height: 1.6;">
                                Production dossiers, blueprints, and codebases are currently undergoing code review and documentation before public release. Check back for future updates. In the meantime, inspect our verified <strong>Technical Laboratory</strong>, physical <strong>Hardware Archive</strong>, or available <strong>Services</strong> below.
                            </p>
                            <div style="display: flex; justify-content: center; gap: 14px; flex-wrap: wrap;">
                                <a href="#services" class="subnav-btn nav-anchor-link" style="color: #00e5ff; border-color: #00e5ff;">Explore Services &darr;</a>
                                <a href="#laboratory" class="subnav-btn nav-anchor-link">Inspect Tech Lab &darr;</a>
                                <a href="#hardware" class="subnav-btn nav-anchor-link">View Hardware Archive &darr;</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; margin-bottom: 30px;">
                            <?php foreach ($projects as $proj): ?>
                            <div class="hud-panel" style="margin-bottom: 0;">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                                    <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #00e5ff; background: rgba(0, 229, 255, 0.1); padding: 2px 8px; border-radius: 4px; border: 1px solid rgba(0, 229, 255, 0.2);">
                                        <?= e($proj['category'] ?? 'Software Application') ?>
                                    </span>
                                    <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #10b981;">
                                        ● <?= e($proj['operational_status'] ?? 'Active') ?>
                                    </span>
                                </div>
                                <h3 style="font-size: 1.3rem; margin: 0 0 8px 0; color: #f8fafc; font-family: 'Space Grotesk', sans-serif;">
                                    <a href="<?= url('project/' . $proj['slug']) ?>" style="color: inherit; text-decoration: none;">
                                        <?= e($proj['title']) ?>
                                    </a>
                                </h3>
                                <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.5; margin: 0 0 16px 0;">
                                    <?= e($proj['tagline']) ?>
                                </p>
                                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255, 255, 255, 0.06); padding-top: 14px; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem;">
                                    <a href="<?= url('project/' . $proj['slug']) ?>" style="color: #00e5ff; text-decoration: none; font-weight: 600;">
                                        VIEW DOSSIER &rarr;
                                    </a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </section>

                <!-- SECTION 2: SERVICES -->
                <section id="services" class="content-section" data-section-name="Services" style="margin-top: 40px;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 16px;">
                        <h2 style="color: #00e5ff; font-family: 'Space Grotesk', sans-serif; font-size: 1.5rem; margin: 0;">
                            // <?= e($secServices['title'] ?: '2. PROFESSIONAL & TECHNICAL SERVICES') ?>
                        </h2>
                        <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #64748b;">
                            <?= e($secServices['subtitle'] ?: 'SPECIALIZATIONS') ?>
                        </span>
                    </div>

                    <?php if (!empty($services)): ?>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; margin-bottom: 30px;">
                        <?php foreach ($services as $idx => $svc): ?>
                        <div class="section-box" style="margin-bottom: 0;">
                            <div style="font-family: 'JetBrains Mono', monospace; color: #00e5ff; font-size: 0.78rem; margin-bottom: 8px;">
                                [SERVICE // <?= sprintf('%02d', $idx + 1) ?>] <?= strtoupper(e($svc['category'] ?? 'ENGINEERING')) ?>
                            </div>
                            <h3 style="font-size: 1.25rem; color: #f8fafc; margin: 0 0 10px 0; font-family: 'Space Grotesk', sans-serif;">
                                <?= e($svc['title']) ?>
                            </h3>
                            <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.6; margin: 0 0 14px 0;">
                                <?= nl2br(e($svc['description'])) ?>
                            </p>
                            <?php if (!empty($svc['features']) || !empty($svc['tagline'])): ?>
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem; color: #cbd5e1; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 10px;">
                                <strong style="color: #ff3366;">Core Stack:</strong> <?= e($svc['features'] ?: $svc['tagline']) ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; margin-bottom: 30px;">
                        <!-- Service 1: Website Development -->
                        <div class="section-box" style="margin-bottom: 0;">
                            <div style="font-family: 'JetBrains Mono', monospace; color: #00e5ff; font-size: 0.78rem; margin-bottom: 8px;">
                                [SERVICE // 01] WEB DEVELOPMENT
                            </div>
                            <h3 style="font-size: 1.25rem; color: #f8fafc; margin: 0 0 10px 0; font-family: 'Space Grotesk', sans-serif;">
                                Custom Website & Web App Development
                            </h3>
                            <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.6; margin: 0 0 14px 0;">
                                Design and implementation of responsive, accessible, and fast websites. Built using pure HTML5, modern CSS3, and modular JavaScript without heavy bloat.
                            </p>
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem; color: #cbd5e1; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 10px;">
                                <strong style="color: #ff3366;">Core Stack:</strong> Vanilla JS, CSS3 Grid/Flexbox, PHP 8+, Responsive UI
                            </div>
                        </div>

                        <!-- Service 2: PHP & Database Applications -->
                        <div class="section-box" style="margin-bottom: 0;">
                            <div style="font-family: 'JetBrains Mono', monospace; color: #00e5ff; font-size: 0.78rem; margin-bottom: 8px;">
                                [SERVICE // 02] BACKEND & DATABASE
                            </div>
                            <h3 style="font-size: 1.25rem; color: #f8fafc; margin: 0 0 10px 0; font-family: 'Space Grotesk', sans-serif;">
                                PHP & Relational Database Applications
                            </h3>
                            <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.6; margin: 0 0 14px 0;">
                                Backend architectures, custom CMS engines, RESTful endpoints, and relational schema modeling with PDO prepared statements and security defenses.
                            </p>
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem; color: #cbd5e1; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 10px;">
                                <strong style="color: #ff3366;">Core Stack:</strong> PHP 8.2+, MySQL / MariaDB, PDO, CSRF/XSS Defense
                            </div>
                        </div>

                        <!-- Service 3: System Administration & Linux Setup -->
                        <div class="section-box" style="margin-bottom: 0;">
                            <div style="font-family: 'JetBrains Mono', monospace; color: #00e5ff; font-size: 0.78rem; margin-bottom: 8px;">
                                [SERVICE // 03] INFRASTRUCTURE
                            </div>
                            <h3 style="font-size: 1.25rem; color: #f8fafc; margin: 0 0 10px 0; font-family: 'Space Grotesk', sans-serif;">
                                Linux Administration & Server Setup
                            </h3>
                            <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.6; margin: 0 0 14px 0;">
                                Operating system provisioning, security hardening, automated backups, SSH key management, and package maintenance for Debian and Ubuntu servers.
                            </p>
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem; color: #cbd5e1; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 10px;">
                                <strong style="color: #ff3366;">Core Stack:</strong> Debian, Ubuntu Server, Bash Shell, Systemd, UFW
                            </div>
                        </div>

                        <!-- Service 4: Homelab & Network Configuration -->
                        <div class="section-box" style="margin-bottom: 0;">
                            <div style="font-family: 'JetBrains Mono', monospace; color: #00e5ff; font-size: 0.78rem; margin-bottom: 8px;">
                                [SERVICE // 04] VIRTUALIZATION
                            </div>
                            <h3 style="font-size: 1.25rem; color: #f8fafc; margin: 0 0 10px 0; font-family: 'Space Grotesk', sans-serif;">
                                Homelab & Virtualization Configuration
                            </h3>
                            <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.6; margin: 0 0 14px 0;">
                                Setting up isolated virtual machines and containers using Proxmox VE, containerizing services with Docker, and establishing secure mesh VPNs via Tailscale.
                            </p>
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem; color: #cbd5e1; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 10px;">
                                <strong style="color: #ff3366;">Core Stack:</strong> Proxmox VE, Docker, Tailscale, Portainer, Reverse Proxies
                            </div>
                        </div>

                        <!-- Service 5: Computer & Hardware Diagnostics -->
                        <div class="section-box" style="margin-bottom: 0;">
                            <div style="font-family: 'JetBrains Mono', monospace; color: #00e5ff; font-size: 0.78rem; margin-bottom: 8px;">
                                [SERVICE // 05] HARDWARE SUPPORT
                            </div>
                            <h3 style="font-size: 1.25rem; color: #f8fafc; margin: 0 0 10px 0; font-family: 'Space Grotesk', sans-serif;">
                                Computer & Hardware Diagnostics
                            </h3>
                            <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.6; margin: 0 0 14px 0;">
                                Component testing, thermal repasting, RAM/SSD upgrades, BIOS diagnostics, and restoration of legacy computing devices and laptops.
                            </p>
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem; color: #cbd5e1; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 10px;">
                                <strong style="color: #ff3366;">Specialty:</strong> Hardware Troubleshooting, Thermal Management, Legacy Laptops
                            </div>
                        </div>

                        <!-- Service 6: Technical Consultation -->
                        <div class="section-box" style="margin-bottom: 0;">
                            <div style="font-family: 'JetBrains Mono', monospace; color: #00e5ff; font-size: 0.78rem; margin-bottom: 8px;">
                                [SERVICE // 06] ADVISORY
                            </div>
                            <h3 style="font-size: 1.25rem; color: #f8fafc; margin: 0 0 10px 0; font-family: 'Space Grotesk', sans-serif;">
                                Technical Consultation & Architecture Review
                            </h3>
                            <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.6; margin: 0 0 14px 0;">
                                Codebase reviews, accessibility audits (WCAG 2.2), technology stack recommendations, and database normalization advisory for small applications.
                            </p>
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem; color: #cbd5e1; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 10px;">
                                <strong style="color: #ff3366;">Inquiries:</strong> <a href="<?= url('contact#inquiry') ?>" style="color: #00e5ff;">Submit Project Consultation Form &rarr;</a>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </section>

                <!-- SECTION 3: TECHNICAL LABORATORY -->
                <section id="laboratory" class="content-section" data-section-name="Technical Laboratory" style="margin-top: 40px;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 16px;">
                        <h2 style="color: #00e5ff; font-family: 'Space Grotesk', sans-serif; font-size: 1.5rem; margin: 0;">
                            // <?= e($secLaboratory['title'] ?: '3. TECHNICAL LABORATORY & EXPERIMENTATION') ?>
                        </h2>
                        <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #64748b;">
                            <?= e($secLaboratory['subtitle'] ?: 'ACTIVE RESEARCH') ?>
                        </span>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; margin-bottom: 30px;">
                        <div class="section-box" style="margin-bottom: 0;">
                            <h3 style="color: #ff3366; font-family: 'Space Grotesk', sans-serif; font-size: 1.2rem; margin: 0 0 8px 0;">
                                Homelab & Virtualization Nodes
                            </h3>
                            <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.6; margin: 0 0 10px 0;">
                                Investigating bare-metal hypervisors with Proxmox VE, evaluating resource overcommit benchmarks on low-power Intel/AMD nodes, and managing LXC microservices.
                            </p>
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #00e5ff;">[ACTIVE LAB TRACK: LAB-NODE-01]</div>
                        </div>

                        <div class="section-box" style="margin-bottom: 0;">
                            <h3 style="color: #ff3366; font-family: 'Space Grotesk', sans-serif; font-size: 1.2rem; margin: 0 0 8px 0;">
                                Encrypted Mesh Networks
                            </h3>
                            <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.6; margin: 0 0 10px 0;">
                                Configuring peer-to-peer WireGuard overlays with Tailscale, testing subnet routing throughput, and benchmarking latency across dynamic residential networks.
                            </p>
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #00e5ff;">[ACTIVE LAB TRACK: NET-MESH-02]</div>
                        </div>

                        <div class="section-box" style="margin-bottom: 0;">
                            <h3 style="color: #ff3366; font-family: 'Space Grotesk', sans-serif; font-size: 1.2rem; margin: 0 0 8px 0;">
                                Legacy Computing & OS Preservation
                            </h3>
                            <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.6; margin: 0 0 10px 0;">
                                Preserving 32-bit x86 netbook platforms, testing lightweight Linux kernels (Debian minimal, Alpine) on Intel Atom architecture, and thermal optimization.
                            </p>
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #00e5ff;">[ACTIVE LAB TRACK: HW-RESTORE-03]</div>
                        </div>
                    </div>
                </section>

                <!-- SECTION 4: HARDWARE ARCHIVE -->
                <section id="hardware" class="content-section" data-section-name="Hardware Archive" style="margin-top: 40px;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 16px;">
                        <h2 style="color: #00e5ff; font-family: 'Space Grotesk', sans-serif; font-size: 1.5rem; margin: 0;">
                            // <?= e($secHardware['title'] ?: '4. PHYSICAL HARDWARE ARCHIVE') ?>
                        </h2>
                        <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #64748b;">
                            <?= e($secHardware['subtitle'] ?: 'VERIFIED DEVICES') ?>
                        </span>
                    </div>

                    <?php if (!empty($hardwareNodes)): ?>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
                        <?php foreach ($hardwareNodes as $hw): ?>
                        <div class="section-box" style="margin-bottom: 0;">
                            <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 8px;">
                                <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #ff3366;">
                                    [OEM: <?= strtoupper(e($hw['oem_brand'] ?? 'FLEET NODE')) ?>]
                                </span>
                                <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: <?= in_array(strtolower($hw['operational_status'] ?? ''), ['operational', 'restored', 'active'], true) ? '#10b981' : '#00e5ff' ?>;">
                                    ● <?= strtoupper(e($hw['operational_status'] ?? 'Active')) ?>
                                </span>
                            </div>
                            <h3 style="font-size: 1.2rem; color: #f8fafc; margin: 0 0 8px 0; font-family: 'Space Grotesk', sans-serif;">
                                <?= e($hw['title']) ?>
                            </h3>
                            <p style="color: #94a3b8; font-size: 0.88rem; line-height: 1.5; margin: 0 0 12px 0;">
                                <?= e($hw['subtitle'] ?? '') ?>
                            </p>
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem; line-height: 1.7; color: #cbd5e1; background: rgba(0,0,0,0.3); padding: 10px; border-radius: 4px; border-left: 2px solid #00e5ff;">
                                <?php if (!empty($hw['cpu_spec'])): ?><div><strong>CPU:</strong> <?= e($hw['cpu_spec']) ?></div><?php endif; ?>
                                <?php if (!empty($hw['ram_spec'])): ?><div><strong>RAM:</strong> <?= e($hw['ram_spec']) ?></div><?php endif; ?>
                                <?php if (!empty($hw['storage_spec'])): ?><div><strong>Storage:</strong> <?= e($hw['storage_spec']) ?></div><?php endif; ?>
                                <?php if (!empty($hw['os_spec'])): ?><div><strong>OS:</strong> <?= e($hw['os_spec']) ?></div><?php endif; ?>
                            </div>
                            <?php if (!empty($hw['restoration_history'])): ?>
                            <p style="color: #64748b; font-size: 0.8rem; margin: 8px 0 0 0; font-family: 'JetBrains Mono', monospace;">
                                Notes: <?= e(substr($hw['restoration_history'], 0, 110)) ?>...
                            </p>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
                        <!-- Genuine Hardware Node 1: Sony VAIO Netbook -->
                        <div class="section-box" style="margin-bottom: 0;">
                            <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 8px;">
                                <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #ff3366;">[OEM: SONY VAIO]</span>
                                <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #10b981;">● RESTORED</span>
                            </div>
                            <h3 style="font-size: 1.2rem; color: #f8fafc; margin: 0 0 8px 0; font-family: 'Space Grotesk', sans-serif;">
                                Sony Vaio W-Series VPCW115XG
                            </h3>
                            <p style="color: #94a3b8; font-size: 0.88rem; line-height: 1.5; margin: 0 0 12px 0;">
                                Intel Atom N280 Netbook Platform &bull; Japanese Ultraportable Engineering. Preserved as a lightweight terminal testing node and diagnostic platform.
                            </p>
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem; line-height: 1.7; color: #cbd5e1; background: rgba(0,0,0,0.3); padding: 10px; border-radius: 4px; border-left: 2px solid #00e5ff;">
                                <div><strong>CPU:</strong> Intel Atom N280 @ 1.66 GHz (1C/2T)</div>
                                <div><strong>RAM:</strong> 2 GB DDR2 SDRAM</div>
                                <div><strong>Storage:</strong> 250 GB SATA HDD</div>
                                <div><strong>OS:</strong> Debian GNU/Linux 32-bit &amp; Windows XP SP3</div>
                            </div>
                        </div>

                        <!-- Genuine Hardware Node 2: Homelab Server Node -->
                        <div class="section-box" style="margin-bottom: 0;">
                            <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 8px;">
                                <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #ff3366;">[CUSTOM NODE]</span>
                                <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #00e5ff;">● OPERATIONAL</span>
                            </div>
                            <h3 style="font-size: 1.2rem; color: #f8fafc; margin: 0 0 8px 0; font-family: 'Space Grotesk', sans-serif;">
                                Proxmox Homelab Microserver Node
                            </h3>
                            <p style="color: #94a3b8; font-size: 0.88rem; line-height: 1.5; margin: 0 0 12px 0;">
                                Multi-purpose virtualization node dedicated to self-hosted development environments, local MariaDB test instances, and Docker containers.
                            </p>
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem; line-height: 1.7; color: #cbd5e1; background: rgba(0,0,0,0.3); padding: 10px; border-radius: 4px; border-left: 2px solid #ff3366;">
                                <div><strong>Hypervisor:</strong> Proxmox Virtual Environment 8</div>
                                <div><strong>Networking:</strong> Tailscale Mesh Overlay + Gigabit LAN</div>
                                <div><strong>Services:</strong> Docker, MariaDB Test DB, Nginx Reverse Proxy</div>
                                <div><strong>Storage:</strong> High-endurance NVMe + SATA Storage Pools</div>
                            </div>
                        </div>

                        <!-- Genuine Hardware Node 3: Primary Development Rig -->
                        <div class="section-box" style="margin-bottom: 0;">
                            <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 8px;">
                                <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #ff3366;">[WORKSTATION]</span>
                                <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #10b981;">● ONLINE</span>
                            </div>
                            <h3 style="font-size: 1.2rem; color: #f8fafc; margin: 0 0 8px 0; font-family: 'Space Grotesk', sans-serif;">
                                Primary Engineering Workstation
                            </h3>
                            <p style="color: #94a3b8; font-size: 0.88rem; line-height: 1.5; margin: 0 0 12px 0;">
                                High-performance development rig configured for rapid C++, PHP, and frontend compilation with multi-display diagnostics.
                            </p>
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem; line-height: 1.7; color: #cbd5e1; background: rgba(0,0,0,0.3); padding: 10px; border-radius: 4px; border-left: 2px solid #ffb800;">
                                <div><strong>Environment:</strong> Windows 11 Pro + WSL2 (Debian Linux)</div>
                                <div><strong>Tooling:</strong> VS Code, Antigravity IDE, Git, XAMPP, Docker</div>
                                <div><strong>Role:</strong> Primary Software Architecture &amp; Client Telemetry</div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </section>

            </div>
        </div>
        <!-- Website Footer Component -->
        <?php require __DIR__ . '/partials/footer.php'; ?>
    </main>

    <script src="<?= asset('script.js') ?>"></script>
</body>
</html>
