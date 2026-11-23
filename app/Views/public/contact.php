<?php
$activeSub = $activeSub ?? 'information';
$secHelper = new \App\Renderers\SectionRenderer($sections ?? []);
$secInfo = $secHelper->getSection('information');
$secInquiry = $secHelper->getSection('inquiry');
$secSocial = $secHelper->getSection('social');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact & Communication // x64emkei.dev</title>
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
            <div class="contact-container" style="max-width: 1000px; margin: 0 auto; padding: 40px 24px 80px 24px;">
                <!-- Breadcrumbs -->
                <nav class="hud-breadcrumb" aria-label="Breadcrumb" style="display: flex; align-items: center; gap: 8px; font-family: 'JetBrains Mono', monospace; font-size: 0.78rem; color: #64748b; margin-bottom: 24px;">
                    <a href="<?= url('/') ?>" style="color: #00e5ff; text-decoration: none;">HOME</a>
                    <span style="color: #334155;">/</span>
                    <a href="<?= url('contact') ?>" style="color: #00e5ff; text-decoration: none;">CONTACT</a>
                    <span style="color: #334155;">/</span>
                    <span style="color: #f8fafc; font-weight: 600;">COMMUNICATION DIRECTORY</span>
                </nav>

                <div style="margin-bottom: 30px; border-bottom: 1px solid rgba(0, 229, 255, 0.2); padding-bottom: 24px;">
                    <div style="font-family: 'JetBrains Mono', monospace; color: #00e5ff; font-size: 0.85rem; margin-bottom: 8px;">// SECURE TELEMETRY CHANNEL</div>
                    <h1 style="font-size: 2.2rem; margin: 0 0 10px 0; font-family: 'Space Grotesk', sans-serif; color: #f8fafc;">Contact & Technical Consultation</h1>
                    <p style="color: #94a3b8; font-size: 1rem; margin: 0; max-width: 760px; line-height: 1.6;">
                        Direct inquiry channels for systems engineering, software consultation, homelab architecture, or collaborative academic and open-source initiatives.
                    </p>
                </div>

                <!-- Sub-Navigation Anchors -->
                <div class="subnav-tabs" role="tablist" style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 36px; border-bottom: 1px solid rgba(0, 229, 255, 0.15); padding-bottom: 16px;">
                    <a href="#information" class="subnav-btn section-anchor-link active" data-target-section="information" role="tab">
                        // 01. CONTACT INFORMATION
                    </a>
                    <a href="#inquiry" class="subnav-btn section-anchor-link" data-target-section="inquiry" role="tab">
                        // 02. SEND AN INQUIRY
                    </a>
                    <a href="#social" class="subnav-btn section-anchor-link" data-target-section="social" role="tab">
                        // 03. SOCIAL NETWORKS
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

                <!-- SECTION 01: CONTACT INFORMATION -->
                <section id="information" class="content-section" data-section-name="information" style="margin-bottom: 48px;">
                    <div class="contact-card" style="background: rgba(14, 18, 26, 0.85); border: 1px solid rgba(0, 229, 255, 0.2); border-radius: 8px; padding: 32px;">
                        <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 16px; margin-bottom: 24px;">
                            <div>
                                <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #00e5ff; letter-spacing: 1px;">SECTION 01 // DIRECT CHANNELS</span>
                                <h2 style="font-family: 'Space Grotesk', sans-serif; color: #f8fafc; font-size: 1.5rem; margin: 4px 0 0 0;">
                                    Contact Information & Telemetry
                                </h2>
                            </div>
                            <span class="telemetry-live-dot" style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #00e5ff; box-shadow: 0 0 10px #00e5ff;"></span>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                            <div class="info-pill" style="background: rgba(0,0,0,0.3); border: 1px solid rgba(255,51,102,0.3); padding: 18px; border-radius: 6px;">
                                <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #ff3366;">PRIMARY EMAIL (ACADEMIC / ACM)</div>
                                <div style="color: #f8fafc; font-weight: 600; font-family: 'JetBrains Mono', monospace; font-size: 1.05rem; margin-top: 6px;">
                                    <a href="mailto:<?= e($profile['email'] ?? 'mordenes@acm.org') ?>" style="color: inherit; text-decoration: none;">
                                        <?= e($profile['email'] ?? 'mordenes@acm.org') ?>
                                    </a>
                                </div>
                                <div style="color: #64748b; font-size: 0.78rem; font-family: 'JetBrains Mono', monospace; margin-top: 4px;">PGP / Encrypted communications available upon request</div>
                            </div>

                            <div class="info-pill" style="background: rgba(0,0,0,0.3); border: 1px solid rgba(0,229,255,0.25); padding: 18px; border-radius: 6px;">
                                <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #00e5ff;">LOCATION &amp; TIMEZONE</div>
                                <div style="color: #cbd5e1; font-size: 1.05rem; font-family: 'JetBrains Mono', monospace; margin-top: 6px;">
                                    <?= e($profile['location'] ?? 'Laguna, Philippines') ?>
                                </div>
                                <div style="color: #64748b; font-size: 0.78rem; font-family: 'JetBrains Mono', monospace; margin-top: 4px;">Philippine Standard Time (PST / UTC+8 / Asia/Manila)</div>
                            </div>

                            <div class="info-pill" style="background: rgba(0,0,0,0.3); border: 1px solid rgba(16,185,129,0.3); padding: 18px; border-radius: 6px;">
                                <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #10b981;">CURRENT AVAILABILITY</div>
                                <div style="color: #34d399; font-size: 0.95rem; font-family: 'JetBrains Mono', monospace; margin-top: 6px;">
                                    ● <?= e($profile['availability_status'] ?? 'Open for Software & Systems Consultation') ?>
                                </div>
                                <div style="color: #64748b; font-size: 0.78rem; font-family: 'JetBrains Mono', monospace; margin-top: 4px;">Expected response turnaround: 24 to 48 hours</div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- SECTION 02: SEND AN INQUIRY -->
                <section id="inquiry" class="content-section" data-section-name="inquiry" style="margin-bottom: 48px;">
                    <div class="contact-card" style="background: rgba(14, 18, 26, 0.85); border: 1px solid rgba(0, 229, 255, 0.2); border-radius: 8px; padding: 32px;">
                        <div style="border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 16px; margin-bottom: 24px;">
                            <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #00e5ff; letter-spacing: 1px;">SECTION 02 // SECURE TRANSMISSION DISPATCH</span>
                            <h2 style="font-family: 'Space Grotesk', sans-serif; color: #f8fafc; font-size: 1.5rem; margin: 4px 0 0 0;">
                                Send an Inquiry Form
                            </h2>
                        </div>

                        <form method="POST" action="<?= url('contact') ?>" style="display: flex; flex-direction: column; gap: 20px;">
                            <?= csrf_field() ?>
                            <!-- Honeypot anti-spam defense -->
                            <div style="display: none;" aria-hidden="true">
                                <label for="contact_botcheck">Do not fill this</label>
                                <input type="text" name="contact_botcheck" id="contact_botcheck" tabindex="-1" autocomplete="off">
                            </div>

                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
                                <div>
                                    <label style="display: block; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: #00e5ff; margin-bottom: 8px;">TRANSMITTER NAME *</label>
                                    <input type="text" name="name" required class="input-control" placeholder="e.g. Jordan Vance" 
                                           style="width: 100%; box-sizing: border-box; background: rgba(7, 9, 14, 0.8); border: 1px solid rgba(0, 229, 255, 0.25); border-radius: 4px; padding: 12px 14px; color: #f8fafc; font-family: inherit; font-size: 0.95rem;">
                                </div>

                                <div>
                                    <label style="display: block; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: #00e5ff; margin-bottom: 8px;">TRANSMITTER EMAIL *</label>
                                    <input type="email" name="email" required class="input-control" placeholder="e.g. jordan@domain.com"
                                           style="width: 100%; box-sizing: border-box; background: rgba(7, 9, 14, 0.8); border: 1px solid rgba(0, 229, 255, 0.25); border-radius: 4px; padding: 12px 14px; color: #f8fafc; font-family: inherit; font-size: 0.95rem;">
                                </div>
                            </div>

                            <div>
                                <label style="display: block; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: #00e5ff; margin-bottom: 8px;">SUBJECT / INQUIRY TOPIC</label>
                                <input type="text" name="subject" class="input-control" placeholder="e.g. Software Architecture / Systems Consultation"
                                       style="width: 100%; box-sizing: border-box; background: rgba(7, 9, 14, 0.8); border: 1px solid rgba(0, 229, 255, 0.25); border-radius: 4px; padding: 12px 14px; color: #f8fafc; font-family: inherit; font-size: 0.95rem;">
                            </div>

                            <div>
                                <label style="display: block; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: #00e5ff; margin-bottom: 8px;">TRANSMISSION PAYLOAD *</label>
                                <textarea name="message" rows="6" required class="input-control" placeholder="Describe your inquiry, project scope, technical requirements, or consultation goals..."
                                          style="width: 100%; box-sizing: border-box; background: rgba(7, 9, 14, 0.8); border: 1px solid rgba(0, 229, 255, 0.25); border-radius: 4px; padding: 12px 14px; color: #f8fafc; font-family: inherit; font-size: 0.95rem; resize: vertical;"></textarea>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-primary" style="background: #00e5ff; color: #07090e; font-family: 'JetBrains Mono', monospace; font-weight: 700; font-size: 0.9rem; padding: 14px 28px; border: none; border-radius: 4px; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px;">
                                    <span>DISPATCH TRANSMISSION</span>
                                    <span>&rarr;</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </section>

                <!-- SECTION 03: SOCIAL NETWORKS -->
                <section id="social" class="content-section" data-section-name="social" style="margin-bottom: 48px;">
                    <div class="contact-card" style="background: rgba(14, 18, 26, 0.85); border: 1px solid rgba(0, 229, 255, 0.2); border-radius: 8px; padding: 32px;">
                        <div style="border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 16px; margin-bottom: 24px;">
                            <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #00e5ff; letter-spacing: 1px;">SECTION 03 // VERIFIED CHANNELS</span>
                            <h2 style="font-family: 'Space Grotesk', sans-serif; color: #f8fafc; font-size: 1.5rem; margin: 4px 0 0 0;">
                                Verified Social Telemetry &amp; Networks
                            </h2>
                        </div>

                        <p style="color: #94a3b8; font-size: 0.95rem; margin-bottom: 24px; line-height: 1.6;">
                            Connect directly through verified developer profiles, professional networks, and open-source code repositories.
                        </p>

                        <?php if (!empty($socialLinks)): ?>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
                            <?php foreach ($socialLinks as $link): ?>
                            <a href="<?= e($link['url']) ?>" target="_blank" rel="noopener noreferrer" 
                               style="display: flex; justify-content: space-between; align-items: center; background: rgba(0,0,0,0.3); border: 1px solid rgba(0,229,255,0.2); padding: 16px 20px; border-radius: 6px; color: #f8fafc; text-decoration: none; font-family: 'JetBrains Mono', monospace; font-size: 0.9rem; transition: all 0.2s;">
                                <div>
                                    <div style="color: #00e5ff; font-size: 0.75rem;">// <?= strtoupper(e($link['platform_name'])) ?></div>
                                    <div style="font-weight: 700; margin-top: 4px;"><?= e($link['platform_name']) ?></div>
                                    <div style="color: #64748b; font-size: 0.78rem;"><?= e($link['username_handle'] ?? '') ?></div>
                                </div>
                                <span style="color: #00e5ff; font-weight: 700;">[OPEN &nearr;]</span>
                            </a>
                            <?php endforeach; ?>
                        </div>
                        <?php else: ?>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
                            <a href="https://github.com/x64_emkei" target="_blank" rel="noopener noreferrer" 
                               style="display: flex; justify-content: space-between; align-items: center; background: rgba(0,0,0,0.3); border: 1px solid rgba(0,229,255,0.2); padding: 16px 20px; border-radius: 6px; color: #f8fafc; text-decoration: none; font-family: 'JetBrains Mono', monospace; font-size: 0.9rem; transition: all 0.2s;">
                                <div>
                                    <div style="color: #00e5ff; font-size: 0.75rem;">// CODE REPOSITORY</div>
                                    <div style="font-weight: 700; margin-top: 4px;">GitHub Profile</div>
                                    <div style="color: #64748b; font-size: 0.78rem;">@x64_emkei</div>
                                </div>
                                <span style="color: #00e5ff; font-weight: 700;">[OPEN &nearr;]</span>
                            </a>

                            <a href="https://linkedin.com/in/michael-ordenes/" target="_blank" rel="noopener noreferrer" 
                               style="display: flex; justify-content: space-between; align-items: center; background: rgba(0,0,0,0.3); border: 1px solid rgba(0,229,255,0.2); padding: 16px 20px; border-radius: 6px; color: #f8fafc; text-decoration: none; font-family: 'JetBrains Mono', monospace; font-size: 0.9rem; transition: all 0.2s;">
                                <div>
                                    <div style="color: #00e5ff; font-size: 0.75rem;">// PROFESSIONAL NETWORK</div>
                                    <div style="font-weight: 700; margin-top: 4px;">LinkedIn Dossier</div>
                                    <div style="color: #64748b; font-size: 0.78rem;">in/michael-ordenes</div>
                                </div>
                                <span style="color: #00e5ff; font-weight: 700;">[OPEN &nearr;]</span>
                            </a>

                            <a href="mailto:<?= e($profile['email'] ?? 'mordenes@acm.org') ?>" 
                               style="display: flex; justify-content: space-between; align-items: center; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,51,102,0.3); padding: 16px 20px; border-radius: 6px; color: #f8fafc; text-decoration: none; font-family: 'JetBrains Mono', monospace; font-size: 0.9rem; transition: all 0.2s;">
                                <div>
                                    <div style="color: #ff3366; font-size: 0.75rem;">// DIRECT INBOX</div>
                                    <div style="font-weight: 700; margin-top: 4px;">ACM Member Email</div>
                                    <div style="color: #64748b; font-size: 0.78rem;"><?= e($profile['email'] ?? 'mordenes@acm.org') ?></div>
                                </div>
                                <span style="color: #ff3366; font-weight: 700;">[COMPOSE &nearr;]</span>
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </section>
            </div>

            <!-- UNIFIED SITE FOOTER -->
            <?php require __DIR__ . '/partials/footer.php'; ?>
        </div>
    </main>

    <script src="<?= asset('script.js') ?>"></script>
</body>
</html>
