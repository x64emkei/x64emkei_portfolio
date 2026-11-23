<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact & Communication Telemetry // x64emkei.dev</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('style.css') ?>">
    <style>
        .contact-container { max-width: 1100px; margin: 0 auto; padding: 40px 24px 80px 24px; }
        .contact-grid { display: grid; grid-template-columns: 1fr 1.3fr; gap: 32px; }
        @media (max-width: 768px) {
            .contact-grid { grid-template-columns: 1fr; }
        }
        .contact-card { background: rgba(14, 18, 26, 0.7); border: 1px solid rgba(0, 229, 255, 0.2); border-radius: 6px; padding: 30px; }
        .input-control { width: 100%; padding: 12px 14px; background: #07090e; border: 1px solid rgba(0, 229, 255, 0.2); border-radius: 4px; color: #fff; font-family: inherit; font-size: 0.9rem; box-sizing: border-box; margin-bottom: 16px; }
        .input-control:focus { outline: none; border-color: #00e5ff; box-shadow: 0 0 10px rgba(0, 229, 255, 0.2); }
        .info-pill { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.06); padding: 12px 16px; border-radius: 4px; }
    </style>
</head>
<body style="background: #07090e; color: #e2e8f0; font-family: 'Outfit', sans-serif; margin: 0;">
    <header style="border-bottom: 1px solid rgba(0, 229, 255, 0.15); background: rgba(14, 18, 26, 0.8); backdrop-filter: blur(10px); position: sticky; top: 0; z-index: 100;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;">
            <a href="<?= url('/') ?>" style="color: #00e5ff; text-decoration: none; font-family: 'JetBrains Mono', monospace; font-size: 1.1rem; font-weight: 700; letter-spacing: 1px;">
                x64emkei<span style="color: #ff3366;">.</span>dev
            </a>
            <nav style="display: flex; gap: 20px; font-family: 'JetBrains Mono', monospace; font-size: 0.85rem;">
                <a href="<?= url('/') ?>" style="color: #94a3b8; text-decoration: none;">HOME</a>
                <a href="<?= url('about') ?>" style="color: #94a3b8; text-decoration: none;">ABOUT</a>
                <a href="<?= url('work') ?>" style="color: #94a3b8; text-decoration: none;">EXPLORE</a>
                <a href="<?= url('journal') ?>" style="color: #94a3b8; text-decoration: none;">JOURNAL</a>
                <a href="<?= url('contact') ?>" style="color: #00e5ff; text-decoration: none; font-weight: 600;">CONTACT</a>
            </nav>
        </div>
    </header>

    <main class="contact-container">
        <div style="margin-bottom: 36px; border-bottom: 1px solid rgba(0, 229, 255, 0.2); padding-bottom: 24px;">
            <div style="font-family: 'JetBrains Mono', monospace; color: #00e5ff; font-size: 0.85rem; margin-bottom: 8px;">// SECURE TELEMETRY CHANNEL</div>
            <h1 style="font-size: 2.2rem; margin: 0 0 10px 0; font-family: 'Space Grotesk', sans-serif; color: #f8fafc;">Initiate Communication</h1>
            <p style="color: #94a3b8; font-size: 1rem; margin: 0; max-width: 700px;">
                Reach out for systems engineering, software consultation, homelab architecture, or collaborative development.
            </p>
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

        <div class="contact-grid">
            <!-- Left Info Panel -->
            <div>
                <div class="contact-card" style="margin-bottom: 24px;">
                    <h2 style="font-family: 'Space Grotesk', sans-serif; color: #00e5ff; font-size: 1.3rem; margin: 0 0 16px 0;">
                        // DIRECT CHANNELS
                    </h2>
                    
                    <div class="info-pill">
                        <div>
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #ff3366;">OPERATOR EMAIL</div>
                            <div style="color: #f8fafc; font-weight: 600; font-family: 'JetBrains Mono', monospace; font-size: 0.9rem; margin-top: 2px;">
                                <a href="mailto:<?= e($profile['email'] ?? 'mordenes@acm.org') ?>" style="color: inherit; text-decoration: none;">
                                    <?= e($profile['email'] ?? 'mordenes@acm.org') ?>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="info-pill">
                        <div>
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #00e5ff;">OPERATIONAL LOCATION</div>
                            <div style="color: #cbd5e1; font-size: 0.9rem; margin-top: 2px;">
                                <?= e($profile['location'] ?? 'Laguna, Philippines') ?>
                            </div>
                        </div>
                    </div>

                    <div class="info-pill">
                        <div>
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #10b981;">STATUS READOUT</div>
                            <div style="color: #34d399; font-size: 0.88rem; margin-top: 2px; font-family: 'JetBrains Mono', monospace;">
                                ● <?= e($profile['availability_status'] ?? 'Available for Systems Engineering') ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Telemetry Links -->
                <?php if (!empty($socialLinks)): ?>
                <div class="contact-card">
                    <h3 style="font-family: 'JetBrains Mono', monospace; color: #00e5ff; font-size: 0.95rem; margin: 0 0 14px 0;">
                        // VERIFIED SOCIAL TELEMETRY
                    </h3>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <?php foreach ($socialLinks as $link): ?>
                        <a href="<?= e($link['url']) ?>" target="_blank" rel="noopener" style="display: flex; justify-content: space-between; align-items: center; background: rgba(0,0,0,0.3); border: 1px solid rgba(0,229,255,0.15); padding: 10px 14px; border-radius: 4px; color: #f8fafc; text-decoration: none; font-family: 'JetBrains Mono', monospace; font-size: 0.85rem; transition: all 0.2s;">
                            <span><?= e($link['platform_name']) ?></span>
                            <span style="color: #00e5ff;">&rarr;</span>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Right Transmission Form -->
            <div class="contact-card">
                <h2 style="font-family: 'Space Grotesk', sans-serif; color: #00e5ff; font-size: 1.3rem; margin: 0 0 16px 0;">
                    // DISPATCH INQUIRY
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
        </div>
    </main>

    <footer style="border-top: 1px solid rgba(0, 229, 255, 0.15); padding: 30px 24px; text-align: center; color: #64748b; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem;">
        &copy; <?= date('Y') ?> Michael Benedict Ordenes (x64emkei). Systems Architecture &bull; All Telemetry Active.
    </footer>
</body>
</html>
