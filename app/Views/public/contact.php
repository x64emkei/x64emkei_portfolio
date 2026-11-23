<?php
$activeSub = $activeSub ?? 'information';

$subTitles = [
    'information' => 'Contact Information & Direct Channels',
    'inquiry' => 'Send an Inquiry & Technical Consultation',
    'social' => 'Verified Social Telemetry & Networks',
];

$pageSubtitle = $subTitles[$activeSub] ?? 'Contact & Communication';
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
    
</head>
<body style="background: #07090e; color: #e2e8f0; font-family: 'Outfit', sans-serif; margin: 0;">

    <!-- MASTER HUD PRIMARY NAVIGATION COMPONENT -->
    <?php require __DIR__ . '/partials/header_nav.php'; ?>

    <main class="main-content"><div class="view-wrapper">
<div class="contact-container">
        <!-- Breadcrumbs -->
        <nav class="hud-breadcrumb" aria-label="Breadcrumb">
            <a href="<?= url('/') ?>">HOME</a>
            <span class="sep">/</span>
            <a href="<?= url('contact') ?>">CONTACT</a>
            <span class="sep">/</span>
            <span class="current"><?= strtoupper(e($activeSub)) ?></span>
        </nav>

        <div style="margin-bottom: 30px; border-bottom: 1px solid rgba(0, 229, 255, 0.2); padding-bottom: 24px;">
            <div style="font-family: 'JetBrains Mono', monospace; color: #00e5ff; font-size: 0.85rem; margin-bottom: 8px;">// SECURE TELEMETRY CHANNEL</div>
            <h1 style="font-size: 2.2rem; margin: 0 0 10px 0; font-family: 'Space Grotesk', sans-serif; color: #f8fafc;"><?= e($pageSubtitle) ?></h1>
            <p style="color: #94a3b8; font-size: 1rem; margin: 0; max-width: 700px;">
                Reach out for systems engineering, software consultation, homelab architecture, or collaborative development.
            </p>
        </div>

        <!-- Sub-Navigation Navigation Tabs (Child Pages) -->
        <div class="subnav-tabs" role="tablist">
            <a href="<?= url('contact/information') ?>" class="subnav-btn <?= $activeSub === 'information' ? 'active' : '' ?>" role="tab">
                // CONTACT INFORMATION
            </a>
            <a href="<?= url('contact/inquiry') ?>" class="subnav-btn <?= $activeSub === 'inquiry' ? 'active' : '' ?>" role="tab">
                // SEND AN INQUIRY
            </a>
            <a href="<?= url('contact/social') ?>" class="subnav-btn <?= $activeSub === 'social' ? 'active' : '' ?>" role="tab">
                // SOCIAL LINKS
            </a>
        </div>

        <?php if (has_flash('success')): ?>
            <div style="padding: 16px; background: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; border-radius: 4px; color: #34d399; margin-bottom: 24px; font-family: 'JetBrains Mono', monospace;">
                &#10004; <?= e(flash('success')) ?>
            </div>
        <?php endif; ?>

        <?php if (has_flash('error')): ?>
            <div style="padding: 16px; background: rgba(255, 51, 102, 0.15); border: 1px solid #ff3366; border-radius: 4px; color: #ff6b8b; margin-bottom: 24px; font-family: 'JetBrains Mono', monospace;">
                &#9888; <?= e(flash('error')) ?>
            </div>
        <?php endif; ?>

        <?php if ($activeSub === 'information'): ?>
            <!-- Contact Information Focused Layout -->
            <div class="contact-card" style="max-width: 700px; margin: 0 auto;">
                <h2 style="font-family: 'Space Grotesk', sans-serif; color: #00e5ff; font-size: 1.4rem; margin: 0 0 20px 0;">
                    // DIRECT TELEMETRY CHANNELS
                </h2>
                
                <div class="info-pill">
                    <div>
                        <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #ff3366;">OPERATOR EMAIL</div>
                        <div style="color: #f8fafc; font-weight: 600; font-family: 'JetBrains Mono', monospace; font-size: 1rem; margin-top: 4px;">
                            <a href="mailto:<?= e($profile['email'] ?? 'mordenes@acm.org') ?>" style="color: inherit; text-decoration: none;">
                                <?= e($profile['email'] ?? 'mordenes@acm.org') ?>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="info-pill">
                    <div>
                        <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #00e5ff;">LOCATION & TIMEZONE</div>
                        <div style="color: #cbd5e1; font-size: 0.95rem; margin-top: 4px;">
                            <?= e($profile['location'] ?? 'Laguna, Philippines') ?> (UTC+8 / PHT)
                        </div>
                    </div>
                </div>

                <div class="info-pill">
                    <div>
                        <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #10b981;">CURRENT OPERATIONAL AVAILABILITY</div>
                        <div style="color: #34d399; font-size: 0.9rem; margin-top: 4px; font-family: 'JetBrains Mono', monospace;">
                            ● <?= e($profile['availability_status'] ?? 'Available for Systems & Web Engineering') ?>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 24px; display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="<?= url('contact/inquiry') ?>" class="subnav-btn" style="color: #00e5ff; border-color: #00e5ff;">Send an Inquiry Form &rarr;</a>
                    <a href="<?= url('contact/social') ?>" class="subnav-btn">View Social Links &rarr;</a>
                </div>
            </div>

        <?php elseif ($activeSub === 'inquiry'): ?>
            <!-- Send an Inquiry Form Focused Layout -->
            <div class="contact-card" style="max-width: 800px; margin: 0 auto;">
                <h2 style="font-family: 'Space Grotesk', sans-serif; color: #00e5ff; font-size: 1.4rem; margin: 0 0 16px 0;">
                    // DISPATCH SECURE TRANSMISSION
                </h2>
                <form method="POST" action="<?= url('contact') ?>">
                    <?= csrf_field() ?>
                    <div>
                        <label style="display: block; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: #00e5ff; margin-bottom: 6px;">TRANSMITTER NAME *</label>
                        <input type="text" name="name" required class="input-control" placeholder="e.g. Elena Vance">
                    </div>

                    <div>
                        <label style="display: block; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: #00e5ff; margin-bottom: 6px;">TRANSMITTER EMAIL *</label>
                        <input type="email" name="email" required class="input-control" placeholder="e.g. elena@blackmesa.org">
                    </div>

                    <div>
                        <label style="display: block; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: #00e5ff; margin-bottom: 6px;">SUBJECT / INQUIRY TOPIC</label>
                        <input type="text" name="subject" class="input-control" placeholder="e.g. Systems Architecture Review">
                    </div>

                    <div>
                        <label style="display: block; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: #00e5ff; margin-bottom: 6px;">TRANSMISSION PAYLOAD *</label>
                        <textarea name="message" rows="6" required class="input-control" placeholder="Enter transmission message payload..."></textarea>
                    </div>

                    <button type="submit" style="background: #00e5ff; color: #07090e; font-family: 'JetBrains Mono', monospace; font-weight: 700; font-size: 0.9rem; padding: 14px 28px; border: none; border-radius: 4px; cursor: pointer; transition: all 0.2s;">
                        TRANSMIT MESSAGE &rarr;
                    </button>
                </form>
            </div>

        <?php elseif ($activeSub === 'social'): ?>
            <!-- Social Links Focused Layout -->
            <div class="contact-card" style="max-width: 700px; margin: 0 auto;">
                <h2 style="font-family: 'Space Grotesk', sans-serif; color: #00e5ff; font-size: 1.4rem; margin: 0 0 16px 0;">
                    // VERIFIED SOCIAL TELEMETRY & NETWORKS
                </h2>
                <p style="color: #94a3b8; font-size: 0.95rem; margin-bottom: 24px;">
                    Connect directly through verified developer profiles, professional networks, and open-source code repositories.
                </p>

                <?php if (empty($socialLinks)): ?>
                    <p style="color: #64748b;">// NO SOCIAL TELEMETRY LINKS REGISTERED</p>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <?php foreach ($socialLinks as $link): ?>
                        <a href="<?= e($link['url']) ?>" target="_blank" rel="noopener" style="display: flex; justify-content: space-between; align-items: center; background: rgba(0,0,0,0.3); border: 1px solid rgba(0,229,255,0.15); padding: 14px 18px; border-radius: 4px; color: #f8fafc; text-decoration: none; font-family: 'JetBrains Mono', monospace; font-size: 0.9rem; transition: all 0.2s;">
                            <span style="font-weight: 600;"><?= e($link['platform_name']) ?></span>
                            <span style="color: #00e5ff;">[OPEN LINK &nearr;]</span>
                        </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    </div></main>

    <footer style="border-top: 1px solid rgba(0, 229, 255, 0.15); padding: 30px 24px; text-align: center; color: #64748b; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem;">
        &copy; <?= date('Y') ?> Michael Benedict Ordenes (x64emkei). Systems Architecture &bull; All Telemetry Active.
    </footer>
    <script src="<?= asset('script.js') ?>"></script>
</body>
</html>
