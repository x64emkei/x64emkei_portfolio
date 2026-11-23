<?php
$currentYear = date('Y');
?>
<!-- MASTER PROFESSIONAL WEBSITE FOOTER -->
<footer class="site-footer" id="siteFooter" role="contentinfo">
    <div class="footer-inner">
        <!-- Main Footer Navigation Grid -->
        <div class="footer-grid">
            <!-- Col 1: Identity & Brand -->
            <div class="footer-col footer-col-brand">
                <div class="footer-brand">
                    <span class="footer-brand-sym">&gt;</span>
                    <span class="footer-brand-name">x64emkei<span class="brand-dot">.</span>dev</span>
                </div>
                <p class="footer-brand-desc">
                    Personal welcome platform and systems engineering portfolio of <strong>Michael Benedict Ordenes</strong>. Computer Science student, IT enthusiast, and systems developer focused on robust architectures, modern PHP/MariaDB backends, and homelab infrastructure.
                </p>
                <div class="footer-telemetry-pill" title="Official Application Timezone: Asia/Manila (GMT+8)">
                    <span class="pht-dot"></span>
                    <span>PST // ASIA/MANILA (UTC+8)</span>
                </div>
            </div>

            <!-- Col 2: Explore Navigation -->
            <div class="footer-col">
                <h4 class="footer-col-title">// EXPLORE</h4>
                <ul class="footer-links">
                    <li><a href="<?= url('/') ?>">Home</a></li>
                    <li><a href="<?= url('about') ?>">About</a></li>
                    <li><a href="<?= url('work') ?>">Work</a></li>
                    <li><a href="<?= url('journal') ?>">Journal</a></li>
                    <li><a href="<?= url('contact') ?>">Contact</a></li>
                </ul>
            </div>

            <!-- Col 3: Resources -->
            <div class="footer-col">
                <h4 class="footer-col-title">// RESOURCES</h4>
                <ul class="footer-links">
                    <li><a href="<?= url('work#portfolio') ?>">Portfolio & Projects</a></li>
                    <li><a href="<?= url('work#laboratory') ?>">Technical Laboratory</a></li>
                    <li><a href="<?= url('work#hardware') ?>">Hardware Archive</a></li>
                    <li><a href="<?= url('journal#tutorials') ?>">Tutorials & Guides</a></li>
                    <li><a href="<?= url('journal#ai-manifesto') ?>">AI Manifesto v1.0</a></li>
                </ul>
            </div>

            <!-- Col 4: Connect & Verified Profiles -->
            <div class="footer-col">
                <h4 class="footer-col-title">// CONNECT</h4>
                <ul class="footer-links">
                    <li>
                        <a href="https://github.com/x64_emkei" target="_blank" rel="noopener noreferrer">
                            GitHub &rarr;
                        </a>
                    </li>
                    <li>
                        <a href="https://linkedin.com/in/michael-ordenes/" target="_blank" rel="noopener noreferrer">
                            LinkedIn &rarr;
                        </a>
                    </li>
                    <li>
                        <a href="mailto:mordenes@acm.org">
                            mordenes@acm.org
                        </a>
                    </li>
                    <li>
                        <a href="<?= url('contact#inquiry') ?>">
                            Send Inquiry Form
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Col 5: Website Information -->
            <div class="footer-col">
                <h4 class="footer-col-title">// WEBSITE INFO</h4>
                <ul class="footer-links">
                    <li><a href="<?= url('privacy') ?>">Privacy Policy</a></li>
                    <li><a href="<?= url('terms') ?>">Terms of Use</a></li>
                    <li><a href="<?= url('accessibility') ?>">Accessibility (WCAG 2.2)</a></li>
                    <li><a href="<?= url('sitemap') ?>">Sitemap</a></li>
                </ul>
            </div>

            <!-- Col 6: Administration (Subtle & Secondary) -->
            <div class="footer-col footer-col-admin">
                <h4 class="footer-col-title">// ADMINISTRATION</h4>
                <p class="footer-admin-note">Authorized system operator and CMS access portal.</p>
                <a href="<?= url('admin/login') ?>" class="footer-admin-link" aria-label="CMS Admin Login">
                    <svg class="admin-lock-icon" viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2">
                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    <span>Admin Login</span>
                </a>
                <div class="footer-auth-status">
                    <span class="auth-dot"></span>
                    <span>SYS.SECURE // RBAC ENFORCED</span>
                </div>
            </div>
        </div>

        <!-- Footer Bottom Bar -->
        <div class="footer-bottom">
            <p class="footer-copyright">
                &copy; <?= $currentYear ?> Michael Benedict Ordenes (x64emkei). Systems Architecture &bull; All Telemetry Active.
            </p>
            <div class="footer-sub-telemetry">
                <span>PHT: <?= date('Y-m-d') ?> (GMT+8)</span>
                <span class="telemetry-sep">&bull;</span>
                <span>PHP <?= PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION ?></span>
                <span class="telemetry-sep">&bull;</span>
                <a href="#siteFooter" class="footer-back-top" onclick="window.scrollTo({top:0,behavior:'smooth'});return false;">TOP &uarr;</a>
            </div>
        </div>
    </div>
</footer>
