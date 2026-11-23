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
    <style>
        .journal-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 24px 80px 24px;
        }
        .journal-hero {
            border-bottom: 1px solid rgba(0, 229, 255, 0.2);
            padding-bottom: 30px;
            margin-bottom: 40px;
        }
        .journal-grid {
            display: grid;
            grid-template-columns: 2.8fr 1.2fr;
            gap: 40px;
        }
        @media (max-width: 900px) {
            .journal-grid {
                grid-template-columns: 1fr;
            }
        }
        .article-card {
            background: rgba(14, 18, 26, 0.7);
            border: 1px solid rgba(0, 229, 255, 0.15);
            border-radius: 6px;
            padding: 24px;
            margin-bottom: 24px;
            transition: transform 0.2s, border-color 0.2s, box-shadow 0.2s;
            position: relative;
        }
        .article-card:hover {
            transform: translateY(-2px);
            border-color: var(--color-cyan, #00e5ff);
            box-shadow: 0 4px 20px rgba(0, 229, 255, 0.12);
        }
        .article-badge {
            display: inline-block;
            font-size: 0.75rem;
            font-family: 'JetBrains Mono', monospace;
            padding: 2px 8px;
            border-radius: 4px;
            background: rgba(0, 229, 255, 0.1);
            color: #00e5ff;
            border: 1px solid rgba(0, 229, 255, 0.3);
            margin-bottom: 12px;
        }
        .article-title {
            margin: 0 0 10px 0;
            font-size: 1.35rem;
            color: #f8fafc;
            line-height: 1.35;
        }
        .article-title a {
            color: inherit;
            text-decoration: none;
        }
        .article-title a:hover {
            color: #00e5ff;
        }
        .article-excerpt {
            color: #94a3b8;
            font-size: 0.92rem;
            line-height: 1.6;
            margin-bottom: 16px;
        }
        .article-meta {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 0.78rem;
            color: #64748b;
            font-family: 'JetBrains Mono', monospace;
        }
        .journal-sidebar-box {
            background: rgba(14, 18, 26, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 24px;
        }
        .sidebar-title {
            font-size: 0.85rem;
            color: #00e5ff;
            font-family: 'JetBrains Mono', monospace;
            margin: 0 0 16px 0;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(0, 229, 255, 0.2);
            padding-bottom: 8px;
        }
        .tag-pill {
            display: inline-block;
            padding: 4px 10px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #cbd5e1;
            font-size: 0.75rem;
            font-family: 'JetBrains Mono', monospace;
            border-radius: 4px;
            text-decoration: none;
            margin: 0 6px 8px 0;
            transition: all 0.2s;
        }
        .tag-pill:hover {
            border-color: #00e5ff;
            color: #00e5ff;
            background: rgba(0, 229, 255, 0.08);
        }
        .guide-module-card {
            background: rgba(14, 18, 26, 0.7);
            border: 1px solid rgba(0, 229, 255, 0.15);
            border-radius: 6px;
            padding: 22px;
            margin-bottom: 18px;
        }
        .manifesto-callout {
            background: rgba(14, 18, 26, 0.85);
            border: 1px solid rgba(255, 51, 102, 0.3);
            border-left: 4px solid #ff3366;
            border-radius: 6px;
            padding: 30px;
            margin-top: 24px;
        }
    </style>
</head>
<body style="background: #07090e; color: #e2e8f0; font-family: 'Outfit', sans-serif; margin: 0;">

    <!-- MASTER HUD PRIMARY NAVIGATION COMPONENT -->
    <?php require dirname(__DIR__) . '/partials/header_nav.php'; ?>

    <main class="main-content">
        <div class="view-wrapper">
            <div class="journal-container">
                <!-- Breadcrumbs -->
                <nav style="display: flex; align-items: center; gap: 8px; font-family: 'JetBrains Mono', monospace; font-size: 0.78rem; color: #64748b; margin-bottom: 24px;" aria-label="Breadcrumb">
                    <a href="<?= url('/') ?>" style="color: #00e5ff; text-decoration: none;">HOME</a>
                    <span style="color: #334155;">/</span>
                    <a href="<?= url('journal') ?>" style="color: #00e5ff; text-decoration: none;">JOURNAL</a>
                    <span style="color: #334155;">/</span>
                    <span style="color: #f8fafc; font-weight: 600;">ALL TRANSMISSIONS</span>
                </nav>

                <!-- Sub-Navigation Navigation Anchors -->
                <div class="subnav-tabs" role="tablist" style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 30px; border-bottom: 1px solid rgba(0, 229, 255, 0.15); padding-bottom: 16px;">
                    <a href="#blog" class="subnav-btn section-anchor-link active" data-target-section="blog" role="tab">
                        // 01. BLOG &amp; ESSAYS
                    </a>
                    <a href="#tutorials" class="subnav-btn section-anchor-link" data-target-section="tutorials" role="tab">
                        // 02. TUTORIALS &amp; GUIDES
                    </a>
                    <a href="#technical-notes" class="subnav-btn section-anchor-link" data-target-section="technical-notes" role="tab">
                        // 03. TECHNICAL NOTES
                    </a>
                    <a href="#research" class="subnav-btn section-anchor-link" data-target-section="research" role="tab">
                        // 04. RESEARCH &amp; INSIGHTS
                    </a>
                    <a href="#ai-manifesto" class="subnav-btn section-anchor-link" data-target-section="ai-manifesto" role="tab" style="color: #ff3366; border-color: rgba(255,51,102,0.4);">
                        // 05. AI MANIFESTO
                    </a>
                </div>

                <!-- Hero Header -->
                <div class="journal-hero">
                    <div style="font-family: 'JetBrains Mono', monospace; color: #00e5ff; font-size: 0.82rem; margin-bottom: 8px;">
                        // TRANSMISSION ARCHIVES &bull; ARCHITECTURAL ESSAYS &bull; PHILOSOPHY
                    </div>
                    <h1 style="font-size: 2.2rem; margin: 0 0 10px 0; font-family: 'Space Grotesk', sans-serif; color: #f8fafc;">
                        Engineering Journal &amp; Publications
                    </h1>
                    <p style="color: #94a3b8; max-width: 800px; margin: 0; font-size: 1rem; line-height: 1.6;">
                        Technical documentation, systems engineering guides, zero-trust protocols, vintage computing restoration records, and architectural positions on computing progress.
                    </p>
                </div>

                <div class="journal-grid">
                    <!-- Main Stream: Sequential Sections -->
                    <div>
                        <!-- SECTION 01: BLOG & ESSAYS -->
                        <section id="blog" class="content-section" data-section-name="blog" style="margin-bottom: 50px;">
                            <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(0, 229, 255, 0.2); padding-bottom: 12px; margin-bottom: 20px;">
                                <div>
                                    <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #00e5ff;">SECTION 01 // PUBLISHED LOGS</span>
                                    <h2 style="font-family: 'Space Grotesk', sans-serif; color: #f8fafc; font-size: 1.5rem; margin: 4px 0 0 0;">Blog &amp; Technical Articles</h2>
                                </div>
                                <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem; color: #64748b;">(<?= count($articles ?? []) ?> Entries)</span>
                            </div>

                            <?php if (!empty($search)): ?>
                                <div style="margin-bottom: 24px; padding: 12px 18px; background: rgba(0, 229, 255, 0.05); border: 1px solid rgba(0, 229, 255, 0.2); border-radius: 4px; font-family: 'JetBrains Mono', monospace; font-size: 0.85rem;">
                                    Search filter: <strong style="color: #00e5ff;">"<?= e($search) ?>"</strong> &bull; <?= e((string)($totalArticles ?? count($articles))) ?> result(s) found.
                                    <a href="<?= url('journal') ?>" style="color: #ff3366; margin-left: 10px; text-decoration: none;">[CLEAR]</a>
                                </div>
                            <?php endif; ?>

                            <?php if (empty($articles)): ?>
                                <div style="text-align: center; padding: 40px 20px; background: rgba(14, 18, 26, 0.4); border: 1px dashed rgba(255, 255, 255, 0.1); border-radius: 6px;">
                                    <div style="font-size: 1.8rem; margin-bottom: 8px;">📡</div>
                                    <h3 style="color: #f8fafc; margin: 0 0 6px 0;">No Transmissions Logged</h3>
                                    <p style="color: #64748b; font-size: 0.9rem; margin: 0;">Telemetry archives currently empty or pending publication.</p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($articles as $art): ?>
                                <article class="article-card">
                                    <?php if (!empty($art['category_name'])): ?>
                                        <span class="article-badge"><?= e($art['category_name']) ?></span>
                                    <?php endif; ?>
                                    
                                    <h3 class="article-title">
                                        <a href="<?= url('journal/' . $art['slug']) ?>"><?= e($art['title']) ?></a>
                                    </h3>

                                    <p class="article-excerpt"><?= e($art['excerpt'] ?? substr(strip_tags($art['content'] ?? ''), 0, 160)) ?></p>

                                    <div class="article-meta">
                                        <span>📅 <?= e(formatPhtDate($art['published_at'] ?? $art['created_at'] ?? null, 'M d, Y')) ?> PHT</span>
                                        <span>👤 <?= e($art['author_name'] ?? 'x64emkei') ?></span>
                                        <a href="<?= url('journal/' . $art['slug']) ?>" style="color: #00e5ff; text-decoration: none; margin-left: auto;">Read Transmission &rarr;</a>
                                    </div>
                                </article>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </section>

                        <!-- SECTION 02: TUTORIALS & GUIDES -->
                        <section id="tutorials" class="content-section" data-section-name="tutorials" style="margin-bottom: 50px;">
                            <div style="border-bottom: 1px solid rgba(0, 229, 255, 0.2); padding-bottom: 12px; margin-bottom: 20px;">
                                <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #00e5ff;">SECTION 02 // PRACTICAL ENGINEERING</span>
                                <h2 style="font-family: 'Space Grotesk', sans-serif; color: #f8fafc; font-size: 1.5rem; margin: 4px 0 0 0;">Tutorials &amp; Implementation Guides</h2>
                            </div>

                            <div class="guide-module-card">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                                    <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #39ff14; background: rgba(57,255,20,0.1); border: 1px solid rgba(57,255,20,0.3); padding: 2px 8px; border-radius: 3px;">TUTORIAL // ARCH-01</span>
                                    <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #64748b;">SYSTEMS &bull; LINUX</span>
                                </div>
                                <h3 style="margin: 0 0 8px 0; font-size: 1.2rem; color: #f8fafc; font-family: 'Space Grotesk', sans-serif;">
                                    Building a Headless Zero-Trust Proxmox VE Homelab Cluster
                                </h3>
                                <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.6; margin: 0 0 12px 0;">
                                    A step-by-step walkthrough covering VLAN isolation, WireGuard site-to-site tunnels, automated snapshot backups via ZFS, and secure container management.
                                </p>
                                <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem; color: #00e5ff;">
                                    STATUS: DOCUMENTED IN LAB // REPOSITORY CODE AVAILABLE
                                </div>
                            </div>

                            <div class="guide-module-card">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                                    <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #00e5ff; background: rgba(0,229,255,0.1); border: 1px solid rgba(0,229,255,0.3); padding: 2px 8px; border-radius: 3px;">TUTORIAL // SEC-02</span>
                                    <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #64748b;">SECURITY &bull; PHP</span>
                                </div>
                                <h3 style="margin: 0 0 8px 0; font-size: 1.2rem; color: #f8fafc; font-family: 'Space Grotesk', sans-serif;">
                                    Zero-Dependency Security Architecture for PHP 8 Web Applications
                                </h3>
                                <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.6; margin: 0 0 12px 0;">
                                    How to write bulletproof authentication, session fingerprinting, timing-attack-safe CSRF tokens, and parameterized PDO queries without heavy framework overhead.
                                </p>
                                <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem; color: #00e5ff;">
                                    STATUS: IMPLEMENTED IN CORE PLATFORM
                                </div>
                            </div>
                        </section>

                        <!-- SECTION 03: TECHNICAL NOTES -->
                        <section id="technical-notes" class="content-section" data-section-name="technical-notes" style="margin-bottom: 50px;">
                            <div style="border-bottom: 1px solid rgba(0, 229, 255, 0.2); padding-bottom: 12px; margin-bottom: 20px;">
                                <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #00e5ff;">SECTION 03 // LAB NOTEBOOK</span>
                                <h2 style="font-family: 'Space Grotesk', sans-serif; color: #f8fafc; font-size: 1.5rem; margin: 4px 0 0 0;">Technical Notes &amp; System Diagnostics</h2>
                            </div>

                            <div style="background: rgba(14, 18, 26, 0.7); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 6px; padding: 22px;">
                                <ul style="margin: 0; padding-left: 20px; color: #cbd5e1; font-size: 0.92rem; line-height: 1.8;">
                                    <li><strong style="color: #00e5ff;">Netbook Thermal Profiling:</strong> Investigating power-saving states (C-states) and undervolting the Intel Atom N280 on Sony Vaio VPCW115XG under lightweight Linux kernels.</li>
                                    <li><strong style="color: #00e5ff;">CORS &amp; CSP Policy Hardening:</strong> Implementing strict nonces and eliminating inline eval vectors while maintaining real-time canvas visualization.</li>
                                    <li><strong style="color: #00e5ff;">Vanilla DOM Lifecycle:</strong> Avoiding layout thrashing by batching geometry reads (`getBoundingClientRect`) outside requestAnimationFrame write steps.</li>
                                    <li><strong style="color: #00e5ff;">SQLite / MariaDB Compatibility:</strong> Ensuring SQL syntax parity across standard shared hosts and local development environments.</li>
                                </ul>
                            </div>
                        </section>

                        <!-- SECTION 04: RESEARCH & INSIGHTS -->
                        <section id="research" class="content-section" data-section-name="research" style="margin-bottom: 50px;">
                            <div style="border-bottom: 1px solid rgba(0, 229, 255, 0.2); padding-bottom: 12px; margin-bottom: 20px;">
                                <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #00e5ff;">SECTION 04 // INVESTIGATION</span>
                                <h2 style="font-family: 'Space Grotesk', sans-serif; color: #f8fafc; font-size: 1.5rem; margin: 4px 0 0 0;">Research &amp; Architectural Insights</h2>
                            </div>

                            <div style="background: rgba(14, 18, 26, 0.7); border: 1px solid rgba(0, 229, 255, 0.15); border-radius: 6px; padding: 24px;">
                                <h3 style="color: #00e5ff; font-family: 'Space Grotesk', sans-serif; margin: 0 0 10px 0; font-size: 1.25rem;">
                                    Hardware Longevity &amp; Digital Preservation in Computing
                                </h3>
                                <p style="color: #94a3b8; font-size: 0.95rem; line-height: 1.7; margin: 0 0 16px 0;">
                                    Modern computing cycles often prematurely discard functional computing platforms. Through component-level repair, lightweight kernel tuning, and purpose-built software design, legacy hardware can continue to deliver utility in edge telemetry, air-gapped backups, and educational sandboxes.
                                </p>
                                <div style="display: flex; gap: 12px; font-family: 'JetBrains Mono', monospace; font-size: 0.78rem; color: #64748b;">
                                    <span>TRACK: HARDWARE RESEARCH</span>
                                    <span>&bull;</span>
                                    <span>FOCUS: CIRCULAR TECHNOLOGY</span>
                                </div>
                            </div>
                        </section>

                        <!-- SECTION 05: AI MANIFESTO -->
                        <section id="ai-manifesto" class="content-section" data-section-name="ai-manifesto" style="margin-bottom: 50px;">
                            <div style="border-bottom: 1px solid rgba(255, 51, 102, 0.3); padding-bottom: 12px; margin-bottom: 20px;">
                                <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: #ff3366;">SECTION 05 // CORE PHILOSOPHICAL POSITION</span>
                                <h2 style="font-family: 'Space Grotesk', sans-serif; color: #f8fafc; font-size: 1.5rem; margin: 4px 0 0 0;">
                                    My AI Manifesto: A Personal Position on AI, Human Skill, and Responsible Progress
                                </h2>
                            </div>

                            <div class="manifesto-callout">
                                <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem; color: #ff3366; margin-bottom: 12px;">
                                    AUTHOR: MICHAEL BENEDICT ORDENES // VERSION: 1.0 // PHILIPPINE COMPUTING PERSPECTIVE
                                </div>
                                <h3 style="font-family: 'Space Grotesk', sans-serif; color: #f8fafc; font-size: 1.3rem; margin: 0 0 12px 0;">
                                    Preamble
                                </h3>
                                <p style="color: #cbd5e1; font-size: 0.95rem; line-height: 1.7; margin-bottom: 20px;">
                                    Artificial intelligence is not a distant future. It is already here, reshaping how we learn, how we build, and how we think about work. There is excitement in what AI can accomplish, but there is also a responsibility to understand what should remain distinctly human. This manifesto represents the principles that will guide my relationship with AI—not as something to fear or reject, but as something to understand, use responsibly, and keep in its proper place.
                                </p>

                                <div style="display: flex; flex-direction: column; gap: 16px; margin-bottom: 24px;">
                                    <div style="background: rgba(0,0,0,0.3); padding: 14px 18px; border-radius: 4px; border-left: 2px solid #00e5ff;">
                                        <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: #00e5ff; font-weight: 700;">I. AI IS A TOOL, NOT A SUBSTITUTE FOR SKILL</div>
                                        <div style="color: #94a3b8; font-size: 0.88rem; margin-top: 4px; line-height: 1.5;">
                                            AI should amplify human intelligence, not replace the struggle of learning. If I cannot build it from first principles, I do not yet own the knowledge.
                                        </div>
                                    </div>

                                    <div style="background: rgba(0,0,0,0.3); padding: 14px 18px; border-radius: 4px; border-left: 2px solid #39ff14;">
                                        <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: #39ff14; font-weight: 700;">II. TRANSPARENCY IN CREATION</div>
                                        <div style="color: #94a3b8; font-size: 0.88rem; margin-top: 4px; line-height: 1.5;">
                                            Honesty about the use of AI builds credibility; hiding it destroys trust. Where AI significantly contributes to my work, I will be transparent about its role.
                                        </div>
                                    </div>

                                    <div style="background: rgba(0,0,0,0.3); padding: 14px 18px; border-radius: 4px; border-left: 2px solid #ffb800;">
                                        <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: #ffb800; font-weight: 700;">III. CRITICAL SKEPTICISM AS A DEFAULT</div>
                                        <div style="color: #94a3b8; font-size: 0.88rem; margin-top: 4px; line-height: 1.5;">
                                            LLMs produce plausible patterns, not verified truth. Every generated line and architectural recommendation must be independently verified against documentation and tests.
                                        </div>
                                    </div>

                                    <div style="background: rgba(0,0,0,0.3); padding: 14px 18px; border-radius: 4px; border-left: 2px solid #a855f7;">
                                        <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: #a855f7; font-weight: 700;">IV. PRESERVING THE JOY OF PROBLEM-SOLVING</div>
                                        <div style="color: #94a3b8; font-size: 0.88rem; margin-top: 4px; line-height: 1.5;">
                                            The deepest satisfaction in engineering comes from solving hard problems through persistent effort. I will protect my capacity for deep work and analytical struggle.
                                        </div>
                                    </div>

                                    <div style="background: rgba(0,0,0,0.3); padding: 14px 18px; border-radius: 4px; border-left: 2px solid #ff3366;">
                                        <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: #ff3366; font-weight: 700;">V. EMPOWERING THE LOCAL TECH ECOSYSTEM</div>
                                        <div style="color: #94a3b8; font-size: 0.88rem; margin-top: 4px; line-height: 1.5;">
                                            As a Filipino developer and student, I will leverage modern computing tools to solve real community problems, share knowledge openly, and mentor peers across local tech ecosystems.
                                        </div>
                                    </div>
                                </div>

                                <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.82rem; color: #cbd5e1; border-top: 1px dashed rgba(255,255,255,0.1); padding-top: 14px;">
                                    <em>Signed: Michael Benedict Ordenes (x64emkei) &bull; Laguna, Philippines</em>
                                    <div style="margin-top: 10px;">
                                        <a href="<?= url('journal/my-ai-manifesto') ?>" style="color: #00e5ff; text-decoration: none;">View Standalone AI Manifesto Article &rarr;</a>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- Sidebar -->
                    <aside>
                        <!-- Search Box -->
                        <div class="journal-sidebar-box">
                            <div class="sidebar-title">// SEARCH ARCHIVE</div>
                            <form method="GET" action="<?= url('journal') ?>">
                                <input type="text" name="q" value="<?= e($search ?? '') ?>" placeholder="Search dossiers..." 
                                       style="width: 100%; padding: 8px 12px; background: #07090e; border: 1px solid rgba(0, 229, 255, 0.2); color: #fff; font-family: inherit; font-size: 0.85rem; border-radius: 4px; box-sizing: border-box;">
                            </form>
                        </div>

                        <!-- Quick Section Navigation -->
                        <div class="journal-sidebar-box">
                            <div class="sidebar-title">// DIRECTORY SECTIONS</div>
                            <ul style="list-style: none; padding: 0; margin: 0; font-family: 'JetBrains Mono', monospace; font-size: 0.82rem; line-height: 2;">
                                <li><a href="#blog" class="section-anchor-link" data-target-section="blog" style="color: #cbd5e1; text-decoration: none;">&rsaquo; 01. Blog &amp; Essays</a></li>
                                <li><a href="#tutorials" class="section-anchor-link" data-target-section="tutorials" style="color: #cbd5e1; text-decoration: none;">&rsaquo; 02. Tutorials &amp; Guides</a></li>
                                <li><a href="#technical-notes" class="section-anchor-link" data-target-section="technical-notes" style="color: #cbd5e1; text-decoration: none;">&rsaquo; 03. Technical Notes</a></li>
                                <li><a href="#research" class="section-anchor-link" data-target-section="research" style="color: #cbd5e1; text-decoration: none;">&rsaquo; 04. Research &amp; Insights</a></li>
                                <li><a href="#ai-manifesto" class="section-anchor-link" data-target-section="ai-manifesto" style="color: #ff3366; text-decoration: none;">&rsaquo; 05. AI Manifesto</a></li>
                            </ul>
                        </div>

                        <!-- Categories -->
                        <div class="journal-sidebar-box">
                            <div class="sidebar-title">// CATEGORIES</div>
                            <ul style="list-style: none; padding: 0; margin: 0; font-family: 'JetBrains Mono', monospace; font-size: 0.82rem;">
                                <?php foreach ($categories as $cat): ?>
                                <li style="margin-bottom: 8px; display: flex; justify-content: space-between;">
                                    <a href="<?= url('journal/category/' . $cat['slug']) ?>" style="color: #94a3b8; text-decoration: none;">
                                        <?= e($cat['name']) ?>
                                    </a>
                                    <span style="color: #64748b;">(<?= e((string)($cat['article_count'] ?? 0)) ?>)</span>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <!-- Tags -->
                        <div class="journal-sidebar-box">
                            <div class="sidebar-title">// TELEMETRY TAGS</div>
                            <div>
                                <?php foreach ($tags as $t): ?>
                                <a href="<?= url('journal/tag/' . $t['slug']) ?>" class="tag-pill">#<?= e($t['name']) ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>

            <!-- UNIFIED SITE FOOTER -->
            <?php require dirname(__DIR__) . '/partials/footer.php'; ?>
        </div>
    </main>

    <script src="<?= asset('script.js') ?>"></script>
</body>
</html>
