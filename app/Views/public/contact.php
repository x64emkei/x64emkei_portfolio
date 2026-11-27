<?php
$activeSub = $activeSub ?? 'information';
$secHelper = new \App\Renderers\SectionRenderer($sections ?? []);
$secContact = $secHelper->getSection('contact');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact &amp; Communication // <?= e($profile['full_name'] ?? 'Michael Benedict Ordenes') ?> (x64emkei)</title>
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
            <div class="page-container" data-initial-section="<?= e($activeSub) ?>">
                <!-- Breadcrumbs -->
                <nav class="hud-breadcrumb" aria-label="Breadcrumb">
                    <a href="<?= url('/') ?>">HOME</a>
                    <span class="sep">/</span>
                    <a href="<?= url('contact') ?>">CONTACT</a>
                    <span class="sep">/</span>
                    <span class="current" id="breadcrumbActiveSection">COMMUNICATION DIRECTORY</span>
                </nav>

                <!-- Section Watermark & Header -->
                <div class="section-watermark-num">04</div>
                <div class="section-header">
                    <span class="section-subtitle">// CONTACT &amp; SECURITY</span>
                    <h2 class="section-title"><?= e($secContact['title'] ?: 'Contact &amp; Consultation') ?></h2>
                    <div class="section-divider"></div>
                </div>

                <!-- Subnav Tabs (Anchor Jumps) -->
                <div class="subnav-tabs" role="tablist" aria-label="Contact sections">
                    <a href="#information" class="subnav-btn section-anchor-link active" data-target-section="information" role="tab">01. Contact Info</a>
                    <a href="#inquiry" class="subnav-btn section-anchor-link" data-target-section="inquiry" role="tab">02. Send Inquiry</a>
                    <a href="#social" class="subnav-btn section-anchor-link" data-target-section="social" role="tab">03. Social Networks</a>
                </div>

                <?php if (has_flash('success')): ?>
                    <div style="padding: 14px 18px; background: rgba(57, 255, 20, 0.12); border: 1px solid var(--accent-green); border-radius: var(--radius-xs); color: var(--accent-green); margin-bottom: 24px; font-family: var(--font-mono); font-size: var(--font-size-sm);">
                        &#10004; <?= e(flash('success')) ?>
                    </div>
                <?php endif; ?>

                <?php if (has_flash('error')): ?>
                    <div style="padding: 14px 18px; background: rgba(255, 42, 42, 0.12); border: 1px solid var(--primary); border-radius: var(--radius-xs); color: var(--primary); margin-bottom: 24px; font-family: var(--font-mono); font-size: var(--font-size-sm);">
                        &#9888; <?= e(flash('error')) ?>
                    </div>
                <?php endif; ?>

                <div class="contact-bento-grid">

                    <!-- SECTION 01: CONTACT INFORMATION (Hero Card Span 7) -->
                    <section id="information" class="content-section bento-card contact-hero-card" data-section-name="information">
                        <div class="contact-card-layout">
                            <div class="contact-card-text">
                                <div class="bento-tag">
                                    <span class="tag-rec-dot"></span>
                                    <span>CONTACT // DIRECT LINKS</span>
                                    <div class="win-controls">
                                        <span class="win-btn">_</span>
                                        <span class="win-btn win-close">&times;</span>
                                    </div>
                                </div>
                                <h3 class="bento-heading">Let&rsquo;s discuss systems, code, or homelab architecture.</h3>
                                <p class="contact-text">
                                    Have an interesting project, engineering proposal, or academic inquiry? Feel free to send a transmission.
                                </p>

                                <div class="contact-info-list">
                                    <div class="contact-info-item">
                                        <div class="contact-info-bullet"></div>
                                        <div class="contact-info-details">
                                            <div class="contact-info-label">Primary Email</div>
                                            <a href="mailto:<?= e($profile['email'] ?? 'mordenes@acm.org') ?>" class="contact-info-val">
                                                <?= e($profile['email'] ?? 'mordenes@acm.org') ?>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="contact-info-item">
                                        <div class="contact-info-bullet"></div>
                                        <div class="contact-info-details">
                                            <div class="contact-info-label">Location</div>
                                            <div class="contact-info-val"><?= e($profile['location'] ?? 'Laguna, Philippines') ?> (UTC+8)</div>
                                        </div>
                                    </div>

                                    <div class="contact-info-item">
                                        <div class="contact-info-bullet"></div>
                                        <div class="contact-info-details">
                                            <div class="contact-info-label">Current Status</div>
                                            <div class="contact-info-val" style="color: var(--accent-green);">
                                                ● <?= e($profile['availability_status'] ?? 'Open for Software & Systems Consultation') ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="contact-card-photo-pane">
                                <img src="<?= asset($profile['avatar_url'] ?: 'images/me_2.png') ?>" alt="<?= e($profile['full_name']) ?>" class="contact-flush-photo" loading="lazy">
                                <div class="contact-photo-telemetry">
                                    <span class="tag-pulse"></span>
                            <span class="contact-photo-label">AVAILABLE FOR CONTACT</span>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- SECTION 02: INQUIRY FORM (Span 5) -->
                    <section id="inquiry" class="content-section bento-card contact-form-card" data-section-name="inquiry" style="grid-column: span 5;">
                        <div class="bento-tag">
                            <span class="tag-rec-dot"></span>
                            <span>CONTACT FORM</span>
                            <div class="win-controls">
                                <span class="win-btn">_</span>
                                <span class="win-btn win-close">&times;</span>
                            </div>
                        </div>
                        <h3 class="bento-heading" style="margin-bottom: 16px;">Send Transmission</h3>

                        <form action="<?= url('contact') ?>" method="POST" class="contact-form">
                            <?= csrf_field() ?>

                            <div class="form-group" style="margin-bottom: 16px;">
                                <label for="name" style="display: block; font-family: var(--font-mono); font-size: var(--font-size-xs); color: var(--text-secondary); margin-bottom: 6px;">
                                    // YOUR NAME
                                </label>
                                <input type="text" id="name" name="name" required class="input-terminal" style="width: 100%; box-sizing: border-box; background: var(--input-bg); border: 1px solid var(--input-border); color: var(--text-primary); padding: 10px 14px; border-radius: var(--radius-xs); font-family: var(--font-mono); font-size: var(--font-size-sm);" placeholder="e.g. John Doe">
                            </div>

                            <div class="form-group" style="margin-bottom: 16px;">
                                <label for="email" style="display: block; font-family: var(--font-mono); font-size: var(--font-size-xs); color: var(--text-secondary); margin-bottom: 6px;">
                                    // EMAIL ADDRESS
                                </label>
                                <input type="email" id="email" name="email" required class="input-terminal" style="width: 100%; box-sizing: border-box; background: var(--input-bg); border: 1px solid var(--input-border); color: var(--text-primary); padding: 10px 14px; border-radius: var(--radius-xs); font-family: var(--font-mono); font-size: var(--font-size-sm);" placeholder="name@domain.com">
                            </div>

                            <div class="form-group" style="margin-bottom: 16px;">
                                <label for="subject" style="display: block; font-family: var(--font-mono); font-size: var(--font-size-xs); color: var(--text-secondary); margin-bottom: 6px;">
                                    // SUBJECT
                                </label>
                                <input type="text" id="subject" name="subject" class="input-terminal" style="width: 100%; box-sizing: border-box; background: var(--input-bg); border: 1px solid var(--input-border); color: var(--text-primary); padding: 10px 14px; border-radius: var(--radius-xs); font-family: var(--font-mono); font-size: var(--font-size-sm);" placeholder="Project consultation / Technical inquiry">
                            </div>

                            <div class="form-group" style="margin-bottom: 20px;">
                                <label for="message" style="display: block; font-family: var(--font-mono); font-size: var(--font-size-xs); color: var(--text-secondary); margin-bottom: 6px;">
                                    // PAYLOAD MESSAGE
                                </label>
                                <textarea id="message" name="message" rows="4" required class="input-terminal" style="width: 100%; box-sizing: border-box; background: var(--input-bg); border: 1px solid var(--input-border); color: var(--text-primary); padding: 10px 14px; border-radius: var(--radius-xs); font-family: var(--font-mono); font-size: var(--font-size-sm); resize: vertical;" placeholder="Describe your project, systems scope, or consultation details..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                                <span>Dispatch Transmission</span>
                                <svg class="btn-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                                    <line x1="22" y1="2" x2="11" y2="13"></line>
                                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                </svg>
                            </button>
                        </form>
                    </section>

                    <!-- SECTION 03: SOCIAL LINKS (Span 12) -->
                    <section id="social" class="content-section bento-card contact-channels-card" data-section-name="social" style="grid-column: span 12;">
                        <div class="bento-tag">
                            <span class="tag-rec-dot"></span>
                            <span>NETWORK // CONNECTED PLATFORMS</span>
                            <div class="win-controls">
                                <span class="win-btn">_</span>
                                <span class="win-btn win-close">&times;</span>
                            </div>
                        </div>
                        <h3 class="bento-heading">External Verified Channels &amp; Repositories</h3>

                        <div class="affiliation-list" style="margin-top: 16px;">
                            <div class="affiliation-item">
                                <div class="affiliation-bullet"></div>
                                <div class="affiliation-details">
                                    <div class="affiliation-name">
                                        <a href="https://github.com/x64emkei" target="_blank" rel="noopener noreferrer" style="color: inherit; text-decoration: none;">
                                            GitHub &mdash; @x64emkei
                                        </a>
                                    </div>
                                    <div class="affiliation-role">Source Code, Dotfiles &amp; Open Source Repositories</div>
                                </div>
                            </div>
                            <div class="affiliation-item">
                                <div class="affiliation-bullet"></div>
                                <div class="affiliation-details">
                                    <div class="affiliation-name">Association for Computing Machinery (ACM)</div>
                                    <div class="affiliation-role">Member Directory: mordenes@acm.org</div>
                                </div>
                            </div>
                            <div class="affiliation-item">
                                <div class="affiliation-bullet"></div>
                                <div class="affiliation-details">
                                    <div class="affiliation-name">Encrypted PGP Key</div>
                                    <div class="affiliation-role">Available on demand for verified secure communications</div>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
        <!-- Website Footer Component -->
        <?php require __DIR__ . '/partials/footer.php'; ?>
    </main>

    <script src="<?= asset('script.js') ?>"></script>
</body>
</html>
