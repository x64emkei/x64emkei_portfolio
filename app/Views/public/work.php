<?php
$activeSub = $activeSub ?? 'projects';

$subTitles = [
    'projects' => 'Portfolio & Software Projects Matrix',
    'services' => 'Engineering Services & Technical Specialties',
    'laboratory' => 'Technical Laboratory & Homelab Infrastructure',
    'hardware' => 'Retro Hardware Diagnostics & Legacy Archive',
];

$pageSubtitle = $subTitles[$activeSub] ?? 'Engineering Showcase';
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
        .work-container { max-width: 1200px; margin: 0 auto; padding: 30px 24px 80px 24px; }
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
        .hud-card {
            background: rgba(14, 18, 26, 0.7);
            border: 1px solid rgba(0, 229, 255, 0.2);
            border-radius: 6px;
            padding: 24px;
            margin-bottom: 24px;
            transition: all 0.2s;
        }
        .hud-card:hover {
            border-color: #00e5ff;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 229, 255, 0.12);
        }
    </style>
</head>
<body style="background: #07090e; color: #e2e8f0; font-family: 'Outfit', sans-serif; margin: 0;">

    <!-- MASTER HUD PRIMARY NAVIGATION COMPONENT -->
    <?php require __DIR__ . '/partials/header_nav.php'; ?>

    <main class="work-container">
        <!-- Breadcrumbs -->
        <nav class="hud-breadcrumb" aria-label="Breadcrumb">
            <a href="<?= url('/') ?>">HOME</a>
            <span class="sep">/</span>
            <a href="<?= url('work') ?>">WORK</a>
            <span class="sep">/</span>
            <span class="current"><?= strtoupper(e($activeSub)) ?></span>
        </nav>

        <div style="margin-bottom: 30px; border-bottom: 1px solid rgba(0, 229, 255, 0.2); padding-bottom: 24px;">
            <div style="font-family: 'JetBrains Mono', monospace; color: #00e5ff; font-size: 0.85rem; margin-bottom: 8px;">// ENGINEERING & SYSTEMS ARCHIVE</div>
            <h1 style="font-size: 2.2rem; margin: 0 0 10px 0; font-family: 'Space Grotesk', sans-serif; color: #f8fafc;"><?= e($pageSubtitle) ?></h1>
            <p style="color: #94a3b8; font-size: 1rem; margin: 0; max-width: 780px;">
                Engineered solutions, virtualization topologies, network overlays, and vintage hardware preservation built and curated by Michael Benedict Ordenes.
            </p>
        </div>

        <!-- Sub-Navigation Navigation Tabs (Child Pages) -->
        <div class="subnav-tabs" role="tablist">
            <a href="<?= url('work/projects') ?>" class="subnav-btn <?= $activeSub === 'projects' ? 'active' : '' ?>" role="tab">
                // PORTFOLIO & PROJECTS
            </a>
            <a href="<?= url('work/services') ?>" class="subnav-btn <?= $activeSub === 'services' ? 'active' : '' ?>" role="tab">
                // SERVICES
            </a>
            <a href="<?= url('work/laboratory') ?>" class="subnav-btn <?= $activeSub === 'laboratory' ? 'active' : '' ?>" role="tab">
                // TECHNICAL LABORATORY
            </a>
            <a href="<?= url('work/hardware') ?>" class="subnav-btn <?= $activeSub === 'hardware' ? 'active' : '' ?>" role="tab">
                // HARDWARE ARCHIVE (6 NODES)
            </a>
        </div>

        <?php if ($activeSub === 'projects'): ?>
            <!-- Projects Section -->
            <?php if (empty($projects)): ?>
                <div class="hud-card" style="text-align: center; padding: 48px 24px; border-style: dashed; border-color: rgba(0, 229, 255, 0.3);">
                    <div style="font-family: 'JetBrains Mono', monospace; color: #00e5ff; font-size: 0.85rem; margin-bottom: 12px;">
                        [SYS.STATUS: INVENTORY_STAGING // ACTIVE REPOSITORY COMPILATION]
                    </div>
                    <h2 style="font-family: 'Space Grotesk', sans-serif; color: #f8fafc; font-size: 1.6rem; margin: 0 0 12px 0;">
                        Project Catalog in Preparation
                    </h2>
                    <p style="color: #94a3b8; font-size: 0.95rem; max-width: 620px; margin: 0 auto 24px auto; line-height: 1.6;">
                        Production dossiers, blueprints, and software repositories are currently undergoing telemetry audit and code review prior to public release. In the meantime, inspect our live <a href="<?= url('work/hardware') ?>" style="color: #00e5ff;">Hardware Archive</a>, review our <a href="<?= url('work/services') ?>" style="color: #00e5ff;">Engineering Services</a>, or read our latest technical papers in the <a href="<?= url('journal') ?>" style="color: #00e5ff;">Journal</a>.
                    </p>
                    <div style="display: flex; justify-content: center; gap: 14px; flex-wrap: wrap;">
                        <a href="<?= url('work/services') ?>" class="subnav-btn" style="color: #00e5ff; border-color: #00e5ff;">Explore Services &rarr;</a>
                        <a href="<?= url('work/hardware') ?>" class="subnav-btn">View Hardware Archive &rarr;</a>
                        <a href="<?= url('contact/inquiry') ?>" class="subnav-btn">Send Project Inquiry &rarr;</a>
                    </div>
                </div>
            <?php else: ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 24px;">
                    <?php foreach ($projects as $proj): ?>
                    <div class="hud-card">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                            <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #00e5ff; background: rgba(0, 229, 255, 0.1); padding: 2px 8px; border-radius: 4px; border: 1px solid rgba(0, 229, 255, 0.2);">
                                <?= e($proj['category'] ?? 'Software') ?>
                            </span>
                            <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #10b981;">
                                ● <?= e($proj['operational_status'] ?? 'Operational') ?>
                            </span>
                        </div>
                        <h2 style="font-size: 1.35rem; margin: 0 0 8px 0; color: #f8fafc;">
                            <a href="<?= url('project/' . $proj['slug']) ?>" style="color: inherit; text-decoration: none;">
                                <?= e($proj['title']) ?>
                            </a>
                        </h2>
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

        <?php elseif ($activeSub === 'services'): ?>
            <!-- Services Section -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 24px;">
                <?php foreach ($services as $srv): ?>
                <div class="hud-card">
                    <div style="font-family: 'JetBrains Mono', monospace; color: #00e5ff; font-size: 0.8rem; margin-bottom: 8px;">
                        // SPECIALTY // <?= strtoupper(e($srv['icon'] ?? 'SRV')) ?>
                    </div>
                    <h2 style="font-size: 1.3rem; margin: 0 0 10px 0; font-family: 'Space Grotesk', sans-serif; color: #f8fafc;">
                        <?= e($srv['title']) ?>
                    </h2>
                    <p style="color: #94a3b8; font-size: 0.92rem; line-height: 1.6; margin: 0 0 16px 0;">
                        <?= e($srv['description']) ?>
                    </p>
                    <?php 
                    $caps = is_string($srv['capabilities_json'] ?? null) ? json_decode($srv['capabilities_json'], true) : ($srv['capabilities_json'] ?? []);
                    if (!empty($caps) && is_array($caps)):
                    ?>
                    <div style="border-top: 1px solid rgba(255, 255, 255, 0.06); padding-top: 12px;">
                        <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #ff3366; margin-bottom: 8px;">CAPABILITIES:</div>
                        <ul style="margin: 0; padding-left: 18px; color: #cbd5e1; font-size: 0.85rem; line-height: 1.6;">
                            <?php foreach ($caps as $cap): ?>
                            <li><?= e($cap) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>

        <?php elseif ($activeSub === 'laboratory'): ?>
            <!-- Homelab & Virtualization Section -->
            <div class="hud-card">
                <div style="font-family: 'JetBrains Mono', monospace; color: #00e5ff; font-size: 0.85rem; margin-bottom: 8px;">
                    // ARCHITECTURE // TECHNICAL LABORATORY & VIRTUALIZATION
                </div>
                <h2 style="font-family: 'Space Grotesk', sans-serif; color: #f8fafc; font-size: 1.5rem; margin: 0 0 12px 0;">
                    24/7 Resilient Virtualization Cluster & Edge Topology
                </h2>
                <p style="color: #cbd5e1; font-size: 0.95rem; line-height: 1.7; margin: 0 0 20px 0;">
                    Operating an internal dedicated hardware homelab utilizing Proxmox VE hypervisors, Debian/Ubuntu container instances, and encrypted Tailscale WireGuard mesh routing for isolated staging, microservices testing, and continuous deployment environments.
                </p>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px; margin-top: 20px;">
                    <div style="background: rgba(0, 0, 0, 0.4); border: 1px solid rgba(0, 229, 255, 0.15); border-radius: 4px; padding: 16px;">
                        <div style="color: #00e5ff; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem;">HYPERVISOR</div>
                        <div style="font-weight: 700; color: #f8fafc; margin-top: 4px;">Proxmox VE 8.x</div>
                        <div style="color: #94a3b8; font-size: 0.82rem; margin-top: 6px;">Bare-metal hypervisor cluster hosting isolated staging servers and test environments.</div>
                    </div>
                    <div style="background: rgba(0, 0, 0, 0.4); border: 1px solid rgba(0, 229, 255, 0.15); border-radius: 4px; padding: 16px;">
                        <div style="color: #00e5ff; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem;">MESH OVERLAY</div>
                        <div style="font-weight: 700; color: #f8fafc; margin-top: 4px;">Tailscale WireGuard Mesh</div>
                        <div style="color: #94a3b8; font-size: 0.82rem; margin-top: 6px;">Zero-trust peer-to-peer encrypted mesh VPN interconnecting test rigs and nodes securely.</div>
                    </div>
                    <div style="background: rgba(0, 0, 0, 0.4); border: 1px solid rgba(0, 229, 255, 0.15); border-radius: 4px; padding: 16px;">
                        <div style="color: #00e5ff; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem;">CONTAINERIZATION</div>
                        <div style="font-weight: 700; color: #f8fafc; margin-top: 4px;">Docker & LXC Stacks</div>
                        <div style="color: #94a3b8; font-size: 0.82rem; margin-top: 6px;">Microservice workloads, database engines, telemetry scrapers, and local reverse proxies.</div>
                    </div>
                </div>
            </div>

        <?php elseif ($activeSub === 'hardware'): ?>
            <!-- Retro Hardware Archive Section -->
            <div style="margin-bottom: 24px;">
                <p style="color: #94a3b8; font-size: 0.95rem; margin: 0 0 20px 0;">
                    Hands-on hardware diagnostics, BIOS recovery, and preservation across iconic computing architectures.
                </p>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
                    <?php foreach ($hardwareNodes as $node): ?>
                    <div class="hud-card">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                            <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #00e5ff; background: rgba(0, 229, 255, 0.1); padding: 2px 8px; border-radius: 3px;">
                                <?= e($node['node_id'] ?? 'NODE') ?>
                            </span>
                            <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #10b981;">
                                ● <?= e($node['status_label'] ?? 'Operational') ?>
                            </span>
                        </div>
                        <h3 style="font-size: 1.15rem; margin: 0 0 6px 0; color: #f8fafc; font-family: 'Space Grotesk', sans-serif;">
                            <?= e($node['name']) ?>
                        </h3>
                        <div style="color: #ff3366; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; margin-bottom: 10px;">
                            <?= e($node['brand_label'] ?? '') ?> &bull; <?= e($node['category'] ?? 'Hardware') ?>
                        </div>
                        <p style="color: #94a3b8; font-size: 0.88rem; line-height: 1.5; margin: 0 0 12px 0;">
                            <?= e($node['description']) ?>
                        </p>
                        <?php if (!empty($node['specs_json'])): 
                            $specs = is_string($node['specs_json']) ? json_decode($node['specs_json'], true) : $node['specs_json'];
                            if (is_array($specs)):
                        ?>
                        <div style="background: rgba(0,0,0,0.3); border-radius: 4px; padding: 10px; font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #cbd5e1;">
                            <?php foreach ($specs as $k => $v): ?>
                            <div><strong style="color: #00e5ff;"><?= e(strtoupper($k)) ?>:</strong> <?= e($v) ?></div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <footer style="border-top: 1px solid rgba(0, 229, 255, 0.15); padding: 30px 24px; text-align: center; color: #64748b; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem;">
        &copy; <?= date('Y') ?> Michael Benedict Ordenes (x64emkei). Systems Architecture &bull; All Telemetry Active.
    </footer>
</body>
</html>
