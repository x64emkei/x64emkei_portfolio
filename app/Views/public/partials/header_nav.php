<?php
use App\Services\NavigationService;
use App\Services\AuthService;

$navItems = NavigationService::getPublicNavigation();
$currentUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$isAuthenticated = AuthService::check();
$activeNav = $activeNav ?? '';
$activeSub = $activeSub ?? '';
?>

<!-- COMPACT TOP UTILITY BAR (Mobile & Tablet) -->
<header class="top-utility-bar" id="topUtilityBar" role="banner">
    <div class="utility-bar-inner">
        <!-- Mobile Drawer Toggle -->
        <button type="button" class="utility-menu-toggle" id="mobileToggle" aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="sidebar">
            <span class="hamburger-bar bar-1"></span>
            <span class="hamburger-bar bar-2"></span>
            <span class="hamburger-bar bar-3"></span>
        </button>

        <!-- Brand Telemetry -->
        <a href="<?= url('/') ?>" class="utility-brand" aria-label="x64emkei.dev Home">
            <span class="brand-sym">&gt;</span>
            <span class="brand-txt">x64emkei<span class="brand-dot">.</span>dev</span>
            <span class="utility-status-pill" aria-hidden="true">
                <span class="live-dot"></span>
                <span>SYS.ON</span>
            </span>
        </a>

        <!-- Right Quick Controls -->
        <div class="utility-actions">
            <!-- Theme Toggle Quick Button -->
            <button type="button" class="utility-theme-btn" id="utilityThemeToggle" aria-label="Toggle theme">
                <svg class="theme-icon icon-sun" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="5"/>
                    <line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
                    <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                    <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
                    <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                </svg>
                <svg class="theme-icon icon-moon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
                </svg>
            </button>
            <!-- AI Manifesto Pill -->
            <a href="<?= url('journal/ai-manifesto') ?>" class="utility-manifesto-btn" title="AI Principles">
                <span class="manifesto-hazard-mini">⚡</span>
                <span class="manifesto-btn-text">AI PRINCIPLES</span>
            </a>
        </div>
    </div>
</header>

<!-- Mobile Drawer Backdrop -->
<div class="sidebar-backdrop" id="sidebarBackdrop" aria-hidden="true"></div>

<!-- UNIFIED RESPONSIVE NAVIGATION SIDEBAR & MOBILE DRAWER -->
<aside class="sidebar" id="sidebar" aria-label="Primary Navigation">
    <!-- Mobile Drawer Header with Close Button -->
    <div class="drawer-mobile-bar">
        <div class="drawer-brand-row">
            <span class="brand-sym">&gt;</span>
            <span class="drawer-brand-name">x64emkei<span class="brand-dot">.</span>dev</span>
        </div>
        <button type="button" class="drawer-close-btn" id="sidebarCloseBtn" aria-label="Close navigation menu">
            &times;
        </button>
    </div>

    <!-- Desktop Sidebar Brand & Telemetry Header -->
    <div class="sidebar-brand">
        <div class="brand-telemetry">
            <span class="telemetry-live-dot"></span>
            <span>SYS.ONLINE</span>
            <div class="techno-equalizer" aria-hidden="true">
                <span class="eq-bar"></span>
                <span class="eq-bar"></span>
                <span class="eq-bar"></span>
                <span class="eq-bar"></span>
            </div>
        </div>
        <a href="<?= url('/') ?>" class="brand-title-link">
            <h2 class="brand-title">x64emkei<span class="brand-dot">.</span>dev</h2>
        </a>
        <span class="brand-subtitle"><?= e($profile['full_name'] ?? "Michael Benedict Ordenes") ?></span>
    </div>

    <!-- Primary Vertical Navigation List (Exact 6 Categories) -->
    <nav class="sidebar-nav" aria-label="Main Navigation">
        <ul class="nav-list" role="menubar">
            <?php foreach ($navItems as $key => $item): 
                $isHome = ($key === 'home');
                $isActiveParent = ($activeNav === $key) || 
                                  ($isHome && ($currentUri === '/' || $currentUri === '')) ||
                                  (!$isHome && str_starts_with($currentUri, $item['route']));
                $hasChildren = !empty($item['children']);
                $itemRoute = url(ltrim($item['route'], '/'));
                if ($key === 'admin' && !$isAuthenticated) {
                    $itemRoute = url('admin/login');
                }
            ?>
            <li class="nav-item <?= $hasChildren ? 'has-subitems' : '' ?> <?= $isActiveParent ? 'is-active-parent' : '' ?>" role="none">
                <div class="nav-link-row">
                    <a href="<?= $itemRoute ?>" 
                       class="nav-link <?= $isActiveParent ? 'active' : '' ?>" 
                       data-section="<?= e($key) ?>"
                       role="menuitem">
                        <?php if ($key === 'home'): ?>
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                <polyline points="9 22 9 12 15 12 15 22"/>
                            </svg>
                        <?php elseif ($key === 'about'): ?>
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="8" r="5"/>
                                <path d="M20 21a8 8 0 0 0-16 0"/>
                            </svg>
                        <?php elseif ($key === 'work'): ?>
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect width="20" height="14" x="2" y="7" rx="2" ry="2"/>
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                            </svg>
                        <?php elseif ($key === 'journal'): ?>
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
                                <path d="M6 6h10"/>
                                <path d="M6 10h10"/>
                                <path d="M6 14h6"/>
                            </svg>
                        <?php elseif ($key === 'contact'): ?>
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect width="20" height="16" x="2" y="4" rx="2"/>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                            </svg>
                        <?php elseif ($key === 'admin'): ?>
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect width="18" height="18" x="3" y="3" rx="2"/>
                                <path d="M9 17V7h6v10"/>
                            </svg>
                        <?php endif; ?>

                        <span class="nav-label"><?= e($item['label']) ?></span>

                        <?php if ($key === 'admin'): ?>
                            <span class="nav-auth-pill"><?= $isAuthenticated ? 'AUTH' : 'LOGIN' ?></span>
                        <?php endif; ?>
                    </a>

                    <?php if ($hasChildren): ?>
                    <button type="button" 
                            class="subnav-accordion-toggle <?= $isActiveParent ? 'expanded' : '' ?>" 
                            aria-label="Expand <?= e($item['label']) ?> child destinations"
                            aria-expanded="<?= $isActiveParent ? 'true' : 'false' ?>">
                        <svg class="chevron-icon" viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <?php endif; ?>
                </div>

                <?php if ($hasChildren): ?>
                <ul class="sidebar-sub-nav <?= $isActiveParent ? 'open' : '' ?>" role="menu">
                    <?php foreach ($item['children'] as $child): 
                        $childRoute = url(ltrim($child['route'], '/'));
                        $isChildActive = ($activeSub === $child['id']) || ($currentUri === $child['route']);
                    ?>
                    <li role="none">
                        <a href="<?= $childRoute ?>" 
                           class="sidebar-sub-link <?= $isChildActive ? 'child-active' : '' ?>" 
                           data-target-section="<?= e($child['id']) ?>"
                           role="menuitem">
                            <span class="sub-arrow">&rsaquo;</span>
                            <span><?= e($child['label']) ?></span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <!-- Sidebar Telemetry & Utilities Footer -->
    <div class="sidebar-footer">
        <!-- Live clock with 12/24-hour toggle -->
        <div class="sidebar-telemetry-hud" id="hudClockContainer" title="Local System Time (Click to toggle 12/24H mode)">
            <span class="hud-clock-label">SYS.TIME</span>
            <span class="hud-clock-val" id="liveSysClock">--:--:-- --</span>
        </div>

        <!-- AI Manifesto Trigger Button -->
        <a href="<?= url('journal/ai-manifesto') ?>" class="btn-manifesto" id="sidebarManifestoBtn" aria-label="Open AI Principles">
            <span class="manifesto-hazard">⚡</span>
            <span>AI PRINCIPLES</span>
            <span class="manifesto-glitch">v1.0</span>
        </a>

        <!-- Trust Me Lab Button -->
        <a href="<?= url('about') ?>" class="btn btn-trust-me sidebar-trust-btn" data-target="about">
            <span class="trust-hazard">⚠️</span>
            <span>TRUST ME</span>
            <span class="trust-glitch">// LAB</span>
        </a>

        <!-- Theme Toggle Button -->
        <button type="button" class="theme-toggle-btn" id="themeToggle" aria-label="Toggle light/dark theme">
            <span class="theme-icon-container">
                <svg class="theme-icon icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="5"/>
                    <line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
                    <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                    <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
                    <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                </svg>
                <svg class="theme-icon icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
                </svg>
            </span>
            <span class="theme-label" id="themeLabel">Dark Mode</span>
        </button>

        <!-- Social Channels -->
        <div class="social-links">
            <a href="https://github.com/x64_emkei" target="_blank" rel="noopener noreferrer" class="social-btn" aria-label="GitHub">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"/>
                    <path d="M9 18c-4.51 2-5-2-7-2"/>
                </svg>
            </a>
            <a href="https://linkedin.com/in/michael-ordenes/" target="_blank" rel="noopener noreferrer" class="social-btn" aria-label="LinkedIn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/>
                    <rect width="4" height="12" x="2" y="9"/>
                    <circle cx="4" cy="4" r="2"/>
                </svg>
            </a>
            <a href="mailto:mordenes@acm.org" class="social-btn" aria-label="Email Michael">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect width="20" height="16" x="2" y="4" rx="2"/>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                </svg>
            </a>
        </div>
        <p class="copyright-text"><?= e($settings['copyright_text'] ?? "© " . date('Y') . " Michael Benedict Ordenes. Systems Architecture // All telemetry active.") ?></p>
    </div>
</aside>
