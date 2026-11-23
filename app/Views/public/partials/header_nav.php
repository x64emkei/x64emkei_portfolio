<?php
use App\Services\NavigationService;
use App\Services\AuthService;

$navItems = NavigationService::getPublicNavigation();
$currentUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$isAuthenticated = AuthService::check();
$activeNav = $activeNav ?? '';
$activeSub = $activeSub ?? '';
?>
<!-- X64EMKEI MASTER HUD PRIMARY NAVIGATION (DESKTOP & MOBILE) -->
<header class="master-hud-header" id="masterHudHeader" role="banner">
    <div class="hud-nav-container">
        <!-- Brand Telemetry -->
        <a href="<?= url('/') ?>" class="hud-brand" aria-label="x64emkei.dev Home">
            <span class="hud-brand-symbol">&gt;</span>
            <span class="hud-brand-text">x64emkei<span class="hud-brand-dot">.</span>dev</span>
            <span class="hud-live-tag" aria-hidden="true">
                <span class="hud-live-pulse"></span>
                <span>SYS.ON</span>
            </span>
        </a>

        <!-- Desktop Navigation Bar -->
        <nav class="hud-desktop-nav" aria-label="Primary Navigation">
            <ul class="hud-nav-list" role="menubar">
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
                <li class="hud-nav-item <?= $hasChildren ? 'has-dropdown' : '' ?> <?= $isActiveParent ? 'is-active-parent' : '' ?>" role="none">
                    <a href="<?= $itemRoute ?>" 
                       class="hud-nav-link <?= $isActiveParent ? 'active' : '' ?>" 
                       role="menuitem"
                       <?= $hasChildren ? 'aria-haspopup="true" aria-expanded="false"' : '' ?>>
                        <span><?= e($item['label']) ?></span>
                        <?php if ($hasChildren): ?>
                            <svg class="hud-caret" viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        <?php endif; ?>
                        <?php if ($key === 'admin'): ?>
                            <span class="hud-admin-pill"><?= $isAuthenticated ? 'AUTH' : 'LOGIN' ?></span>
                        <?php endif; ?>
                    </a>

                    <?php if ($hasChildren): ?>
                    <ul class="hud-dropdown-menu" role="menu" aria-label="<?= e($item['label']) ?> sub-menu">
                        <?php foreach ($item['children'] as $child): 
                            $childRoute = url(ltrim($child['route'], '/'));
                            $isChildActive = ($activeSub === $child['id']) || ($currentUri === $child['route']);
                        ?>
                        <li role="none">
                            <a href="<?= $childRoute ?>" 
                               class="hud-dropdown-link <?= $isChildActive ? 'child-active' : '' ?>" 
                               role="menuitem">
                                <span class="dropdown-pip"></span>
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

        <!-- Right HUD Utilities -->
        <div class="hud-utilities">
            <a href="<?= url('journal/ai-manifesto') ?>" class="hud-manifesto-btn" title="AI Manifesto v1.0">
                <span class="manifesto-pill-glow"></span>
                <span>AI MANIFESTO</span>
            </a>
            
            <!-- Mobile Hamburger Toggle -->
            <button type="button" class="hud-mobile-toggle" id="hudMobileToggle" aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="hudMobileDrawer">
                <span class="bar bar-1"></span>
                <span class="bar bar-2"></span>
                <span class="bar bar-3"></span>
            </button>
        </div>
    </div>
</header>

<!-- Mobile Navigation Drawer Overlay -->
<div class="hud-mobile-backdrop" id="hudMobileBackdrop" aria-hidden="true"></div>

<!-- Mobile Navigation Off-Canvas Drawer -->
<nav class="hud-mobile-drawer" id="hudMobileDrawer" aria-label="Mobile Navigation" aria-hidden="true">
    <div class="drawer-header">
        <div class="drawer-brand">
            <span class="hud-brand-symbol">&gt;</span>
            <span class="hud-brand-text">x64emkei<span class="hud-brand-dot">.</span>dev</span>
        </div>
        <button type="button" class="drawer-close-btn" id="drawerCloseBtn" aria-label="Close navigation menu">
            &times;
        </button>
    </div>

    <div class="drawer-telemetry-status">
        <span class="telemetry-dot"></span>
        <span>SYS.TELEMETRY // 6 CHANNELS ONLINE</span>
    </div>

    <ul class="drawer-nav-list">
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
        <li class="drawer-item <?= $hasChildren ? 'has-accordion' : '' ?> <?= $isActiveParent ? 'is-active-parent' : '' ?>">
            <div class="drawer-item-row">
                <a href="<?= $itemRoute ?>" class="drawer-link <?= $isActiveParent ? 'active' : '' ?>">
                    <span><?= e($item['label']) ?></span>
                    <?php if ($key === 'admin'): ?>
                        <span class="hud-admin-pill"><?= $isAuthenticated ? 'AUTH' : 'LOGIN' ?></span>
                    <?php endif; ?>
                </a>
                <?php if ($hasChildren): ?>
                <button type="button" class="accordion-toggle-btn" aria-label="Expand <?= e($item['label']) ?> sub-menu">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <?php endif; ?>
            </div>

            <?php if ($hasChildren): ?>
            <ul class="drawer-sub-list <?= $isActiveParent ? 'open' : '' ?>">
                <?php foreach ($item['children'] as $child): 
                    $childRoute = url(ltrim($child['route'], '/'));
                    $isChildActive = ($activeSub === $child['id']) || ($currentUri === $child['route']);
                ?>
                <li>
                    <a href="<?= $childRoute ?>" class="drawer-sub-link <?= $isChildActive ? 'child-active' : '' ?>">
                        <span class="sub-arrow">&rarr;</span>
                        <span><?= e($child['label']) ?></span>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>

    <div class="drawer-footer">
        <div style="font-size: 0.75rem; color: #64748b; font-family: 'JetBrains Mono', monospace;">
            &copy; <?= date('Y') ?> Michael Benedict Ordenes
        </div>
    </div>
</nav>

<style>
/* HUD NAVIGATION DESIGN SYSTEM (Strict adherence to Cyberpunk HUD theme) */
.master-hud-header {
    position: sticky;
    top: 0;
    z-index: 1000;
    background: rgba(7, 9, 14, 0.92);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(0, 229, 255, 0.18);
    box-shadow: 0 4px 25px rgba(0, 0, 0, 0.6);
}
.hud-nav-container {
    max-width: 1300px;
    margin: 0 auto;
    padding: 0 24px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}
.hud-brand {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    font-family: 'JetBrains Mono', monospace;
    font-weight: 700;
    font-size: 1.15rem;
    color: #f8fafc;
    letter-spacing: 0.5px;
    flex-shrink: 0;
}
.hud-brand-symbol { color: #00e5ff; }
.hud-brand-dot { color: #ff3366; }
.hud-live-tag {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.65rem;
    background: rgba(0, 229, 255, 0.08);
    border: 1px solid rgba(0, 229, 255, 0.25);
    padding: 2px 6px;
    border-radius: 3px;
    color: #00e5ff;
    letter-spacing: 1px;
}
.hud-live-pulse {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #00e5ff;
    box-shadow: 0 0 8px #00e5ff;
    animation: livePulse 2s infinite;
}
@keyframes livePulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.4; transform: scale(0.85); }
}

/* Desktop Navigation */
.hud-desktop-nav {
    display: flex;
    align-items: center;
}
@media (max-width: 1024px) {
    .hud-desktop-nav { display: none; }
}
.hud-nav-list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.hud-nav-item {
    position: relative;
}
.hud-nav-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    color: #94a3b8;
    text-decoration: none;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.85rem;
    font-weight: 600;
    border-radius: 4px;
    border: 1px solid transparent;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}
.hud-nav-link:hover, .hud-nav-link:focus-visible {
    color: #00e5ff;
    background: rgba(0, 229, 255, 0.06);
    border-color: rgba(0, 229, 255, 0.2);
    outline: none;
}
.hud-nav-link.active, .is-active-parent > .hud-nav-link {
    color: #00e5ff;
    background: rgba(0, 229, 255, 0.1);
    border-color: rgba(0, 229, 255, 0.35);
    box-shadow: 0 0 12px rgba(0, 229, 255, 0.18);
}
.hud-caret {
    transition: transform 0.2s ease;
}
.hud-nav-item:hover .hud-caret, .hud-nav-item:focus-within .hud-caret {
    transform: rotate(180deg);
}
.hud-admin-pill {
    font-size: 0.65rem;
    padding: 1px 5px;
    border-radius: 3px;
    background: rgba(255, 51, 102, 0.15);
    border: 1px solid rgba(255, 51, 102, 0.4);
    color: #ff3366;
    letter-spacing: 0.5px;
}

/* Dropdown Menus */
.hud-dropdown-menu {
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    min-width: 240px;
    background: rgba(14, 18, 26, 0.98);
    backdrop-filter: blur(14px);
    border: 1px solid rgba(0, 229, 255, 0.25);
    border-radius: 6px;
    padding: 8px 0;
    list-style: none;
    margin: 0;
    opacity: 0;
    visibility: hidden;
    transform: translateY(6px);
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.7);
    pointer-events: none;
    z-index: 1010;
}
.hud-nav-item:hover .hud-dropdown-menu,
.hud-nav-item:focus-within .hud-dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
    pointer-events: auto;
}
.hud-dropdown-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 18px;
    color: #cbd5e1;
    text-decoration: none;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.8rem;
    transition: all 0.15s ease;
}
.dropdown-pip {
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: #64748b;
    transition: all 0.15s ease;
}
.hud-dropdown-link:hover, .hud-dropdown-link:focus-visible {
    background: rgba(0, 229, 255, 0.08);
    color: #00e5ff;
    padding-left: 22px;
    outline: none;
}
.hud-dropdown-link:hover .dropdown-pip, .hud-dropdown-link.child-active .dropdown-pip {
    background: #00e5ff;
    box-shadow: 0 0 6px #00e5ff;
}
.hud-dropdown-link.child-active {
    color: #00e5ff;
    font-weight: 700;
    background: rgba(0, 229, 255, 0.08);
}

/* Utilities */
.hud-utilities {
    display: flex;
    align-items: center;
    gap: 14px;
}
.hud-manifesto-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 14px;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-decoration: none;
    color: #f8fafc;
    background: rgba(255, 51, 102, 0.1);
    border: 1px solid rgba(255, 51, 102, 0.35);
    border-radius: 4px;
    transition: all 0.2s;
}
.hud-manifesto-btn:hover {
    background: rgba(255, 51, 102, 0.2);
    border-color: #ff3366;
    box-shadow: 0 0 15px rgba(255, 51, 102, 0.3);
    color: #fff;
}
.manifesto-pill-glow {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #ff3366;
    box-shadow: 0 0 6px #ff3366;
}

/* Mobile Hamburger Toggle */
.hud-mobile-toggle {
    display: none;
    flex-direction: column;
    justify-content: center;
    gap: 5px;
    width: 44px;
    height: 44px;
    padding: 10px;
    background: rgba(14, 18, 26, 0.8);
    border: 1px solid rgba(0, 229, 255, 0.25);
    border-radius: 4px;
    cursor: pointer;
    box-sizing: border-box;
}
@media (max-width: 1024px) {
    .hud-mobile-toggle { display: flex; }
    .hud-manifesto-btn { display: none; }
}
.hud-mobile-toggle .bar {
    width: 100%;
    height: 2px;
    background: #00e5ff;
    border-radius: 1px;
    transition: all 0.25s ease;
}

/* Mobile Off-Canvas Drawer */
.hud-mobile-backdrop {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.75);
    backdrop-filter: blur(6px);
    z-index: 1990;
}
.hud-mobile-backdrop.open { display: block; }
.hud-mobile-drawer {
    position: fixed;
    top: 0;
    bottom: 0;
    right: 0;
    width: 85%;
    max-width: 380px;
    background: #0b0f17;
    border-left: 1px solid rgba(0, 229, 255, 0.25);
    box-shadow: -10px 0 35px rgba(0, 0, 0, 0.85);
    z-index: 2000;
    transform: translateX(100%);
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    display: flex;
    flex-direction: column;
    overflow-y: auto;
}
.hud-mobile-drawer.open {
    transform: translateX(0);
}
.drawer-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 20px;
    border-bottom: 1px solid rgba(0, 229, 255, 0.15);
}
.drawer-close-btn {
    background: transparent;
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #cbd5e1;
    font-size: 1.6rem;
    line-height: 1;
    width: 36px;
    height: 36px;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}
.drawer-close-btn:hover {
    color: #ff3366;
    border-color: #ff3366;
}
.drawer-telemetry-status {
    padding: 12px 20px;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.72rem;
    color: #10b981;
    background: rgba(16, 185, 129, 0.05);
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    display: flex;
    align-items: center;
    gap: 8px;
}
.drawer-telemetry-status .telemetry-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #10b981;
    box-shadow: 0 0 6px #10b981;
}
.drawer-nav-list {
    list-style: none;
    margin: 0;
    padding: 16px 12px;
    flex: 1;
}
.drawer-item {
    margin-bottom: 8px;
    border-radius: 4px;
    border: 1px solid rgba(255, 255, 255, 0.04);
    background: rgba(14, 18, 26, 0.5);
    overflow: hidden;
}
.drawer-item-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.drawer-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 16px;
    color: #cbd5e1;
    text-decoration: none;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.92rem;
    font-weight: 600;
    flex: 1;
}
.drawer-link.active, .drawer-item.is-active-parent > .drawer-item-row > .drawer-link {
    color: #00e5ff;
}
.accordion-toggle-btn {
    width: 44px;
    height: 48px;
    background: transparent;
    border: none;
    color: #94a3b8;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s ease;
}
.accordion-toggle-btn.expanded {
    transform: rotate(180deg);
    color: #00e5ff;
}
.drawer-sub-list {
    display: none;
    list-style: none;
    margin: 0;
    padding: 6px 0 10px 12px;
    background: rgba(7, 9, 14, 0.6);
    border-top: 1px solid rgba(255, 255, 255, 0.05);
}
.drawer-sub-list.open {
    display: block;
}
.drawer-sub-link {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 14px;
    color: #94a3b8;
    text-decoration: none;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.82rem;
    min-height: 44px; /* WCAG 2.2 touch target standard */
    box-sizing: border-box;
}
.drawer-sub-link .sub-arrow { color: #00e5ff; font-size: 0.8rem; }
.drawer-sub-link:hover, .drawer-sub-link.child-active {
    color: #00e5ff;
    padding-left: 18px;
}
.drawer-footer {
    padding: 18px 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.06);
    background: rgba(7, 9, 14, 0.8);
}
</style>

<script>
// Mobile Navigation Drawer Interactive Controller
(function() {
    var toggleBtn = document.getElementById('hudMobileToggle');
    var drawer = document.getElementById('hudMobileDrawer');
    var backdrop = document.getElementById('hudMobileBackdrop');
    var closeBtn = document.getElementById('drawerCloseBtn');

    function openDrawer() {
        if (!drawer || !backdrop) return;
        drawer.classList.add('open');
        backdrop.classList.add('open');
        drawer.setAttribute('aria-hidden', 'false');
        backdrop.setAttribute('aria-hidden', 'false');
        if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
        if (!drawer || !backdrop) return;
        drawer.classList.remove('open');
        backdrop.classList.remove('open');
        drawer.setAttribute('aria-hidden', 'true');
        backdrop.setAttribute('aria-hidden', 'true');
        if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    if (toggleBtn) toggleBtn.addEventListener('click', openDrawer);
    if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
    if (backdrop) backdrop.addEventListener('click', closeDrawer);

    // Accordions inside drawer
    var accordions = document.querySelectorAll('.accordion-toggle-btn');
    accordions.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var item = btn.closest('.drawer-item');
            var subList = item ? item.querySelector('.drawer-sub-list') : null;
            if (subList) {
                var isOpen = subList.classList.contains('open');
                if (isOpen) {
                    subList.classList.remove('open');
                    btn.classList.remove('expanded');
                } else {
                    subList.classList.add('open');
                    btn.classList.add('expanded');
                }
            }
        });
    });

    // Close drawer on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && drawer && drawer.classList.contains('open')) {
            closeDrawer();
        }
    });
})();
</script>
