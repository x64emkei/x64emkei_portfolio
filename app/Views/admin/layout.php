<?php
use App\Services\AuthService;
$currentUser = AuthService::user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <script>if(location.protocol==='http:'&&location.hostname!=='localhost'&&location.hostname!=='127.0.0.1'){location.replace('https://'+location.host+location.pathname+location.search+location.hash);}</script>
    <title><?= e($pageTitle ?? 'Control Center') ?> // x64emkei.dev Admin</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Outfit:wght@400;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('style.css') ?>">
    <style>
        :root {
            --admin-bg: #06080A;
            --admin-surface: #0C0E12;
            --admin-card: rgba(18, 24, 38, 0.85);
            --admin-border: rgba(255, 42, 42, 0.25);
            --admin-cyan: #FF2A2A;
            --admin-primary: #FF2A2A;
            --admin-magenta: #ff3366;
            --admin-green: #10b981;
            --admin-amber: #f59e0b;
        }
        body.admin-body {
            background-color: var(--admin-bg);
            color: #e2e8f0;
            font-family: 'JetBrains Mono', monospace;
            margin: 0;
            display: flex;
            min-height: 100vh;
        }
        .admin-sidebar {
            width: 280px;
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border-right: 1px solid var(--glass-border);
            box-shadow: var(--glass-shadow);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            z-index: 50;
        }
        .admin-mobile-close {
            display: none;
            background: rgba(255, 42, 42, 0.1);
            border: 1px solid rgba(255, 42, 42, 0.35);
            color: var(--admin-cyan);
            width: 34px;
            height: 34px;
            border-radius: 4px;
            font-size: 1.3rem;
            line-height: 1;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            padding: 0;
            flex-shrink: 0;
        }
        .admin-brand {
            padding: 24px;
            border-bottom: 1px solid var(--admin-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .admin-brand h2 {
            font-size: 1.1rem;
            margin: 0;
            color: var(--admin-cyan);
            letter-spacing: 1px;
        }
        .admin-brand span {
            font-size: 0.75rem;
            color: #64748b;
        }
        .admin-nav {
            list-style: none;
            padding: 16px 12px;
            margin: 0;
            flex-grow: 1;
            overflow-y: auto;
        }
        .admin-nav li {
            margin-bottom: 4px;
        }
        .admin-nav a {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.85rem;
            border-radius: 4px;
            border-left: 2px solid transparent;
            transition: all 0.2s ease;
        }
        .admin-nav a:hover, .admin-nav a.active {
            color: var(--admin-primary);
            background: rgba(255, 42, 42, 0.1);
            border-left-color: var(--admin-primary);
        }
        .admin-logout-button {
            width: 100%;
            display: flex;
            align-items: center;
            padding: 10px 14px;
            border: 0;
            border-left: 2px solid transparent;
            border-radius: 4px;
            background: transparent;
            color: var(--admin-magenta);
            cursor: pointer;
            font: inherit;
            font-size: 0.85rem;
            text-align: left;
        }
        .admin-logout-button:hover,
        .admin-logout-button:focus-visible {
            background: rgba(255, 51, 102, 0.1);
            border-left-color: var(--admin-magenta);
        }
        .admin-badge {
            background: var(--admin-magenta);
            color: #fff;
            padding: 2px 6px;
            font-size: 0.7rem;
            border-radius: 10px;
            font-weight: 600;
        }
        .admin-main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }
        .admin-topbar {
            height: 60px;
            border-bottom: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
        }
        .admin-telemetry-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            color: var(--admin-green);
        }
        .admin-dot {
            width: 8px;
            height: 8px;
            background: var(--admin-green);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--admin-green);
        }
        .admin-content {
            padding: 30px;
            max-width: 1300px;
            width: 100%;
            box-sizing: border-box;
        }
        .admin-alert {
            padding: 14px 18px;
            border-radius: 4px;
            margin-bottom: 24px;
            font-size: 0.88rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .admin-alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid var(--admin-green);
            color: #34d399;
        }
        .admin-alert-error {
            background: rgba(255, 51, 102, 0.1);
            border: 1px solid var(--admin-magenta);
            color: #ff6b8b;
        }
        .admin-card {
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: 1px solid var(--glass-border);
            border-radius: var(--card-radius-md);
            box-shadow: var(--glass-shadow);
            padding: 24px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
            transition: var(--transition);
        }
        .admin-card:hover {
            border-color: var(--glass-border-hover);
            box-shadow: var(--glass-shadow-hover);
        }
        .admin-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding-bottom: 14px;
        }
        .admin-card-title {
            font-size: 1.05rem;
            color: var(--admin-cyan);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-label {
            display: block;
            font-size: 0.8rem;
            color: #94a3b8;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            background: var(--input-bg);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid var(--input-border);
            color: #f8fafc;
            font-family: inherit;
            font-size: 0.88rem;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--admin-primary);
            box-shadow: 2px 2px 0px rgba(0, 0, 0, 0.8);
        }
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }
        .btn-admin {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 18px;
            font-family: inherit;
            font-size: 0.82rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 1px solid transparent;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-admin-cyan {
            background: var(--admin-primary);
            color: #ffffff;
            border: 1px solid var(--admin-primary);
        }
        .btn-admin-cyan:hover {
            box-shadow: 3px 3px 0px #000000;
            transform: translateY(-1px);
        }
        .btn-admin-danger {
            background: transparent;
            border-color: var(--admin-magenta);
            color: var(--admin-magenta);
        }
        .btn-admin-danger:hover {
            background: var(--admin-magenta);
            color: #fff;
        }
        .btn-admin-outline {
            background: transparent;
            border-color: var(--admin-border);
            color: #94a3b8;
        }
        .btn-admin-outline:hover {
            color: #fff;
            border-color: #64748b;
        }
        /* Legacy editor views use the shorter admin-btn names. Keep them
           visually aligned with the current CMS controls. */
        .admin-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 9px 18px;
            font-family: inherit;
            font-size: 0.82rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 1px solid transparent;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }
        .admin-btn-primary {
            background: var(--admin-primary);
            color: #fff;
            border-color: var(--admin-primary);
        }
        .admin-btn-primary:hover {
            box-shadow: 3px 3px 0 #000;
            transform: translateY(-1px);
        }
        .admin-btn-secondary {
            background: transparent;
            border-color: var(--admin-border);
            color: #94a3b8;
        }
        .admin-btn-secondary:hover {
            color: #fff;
            border-color: #64748b;
        }
        .admin-btn-danger {
            background: transparent;
            border-color: var(--admin-magenta);
            color: var(--admin-magenta);
        }
        .admin-btn-danger:hover {
            background: var(--admin-magenta);
            color: #fff;
        }
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }
        .admin-table th {
            text-align: left;
            padding: 12px 14px;
            border-bottom: 1px solid var(--admin-border);
            color: var(--admin-cyan);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .admin-table td {
            padding: 14px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: #cbd5e1;
        }
        .admin-table tr:hover td {
            background: rgba(255, 42, 42, 0.03);
        }
        .status-pill {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.72rem;
            font-weight: 600;
        }
        .status-active { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid #10b981; }
        .status-draft { background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid #f59e0b; }

        /* ==========================================================================
           RESPONSIVE MOBILE / TABLET CMS COMPATIBILITY (ui-ux-pro-max standards)
           ========================================================================== */
        .admin-mobile-toggle {
            display: none;
            background: transparent;
            border: 1px solid var(--admin-border);
            color: var(--admin-cyan);
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-family: inherit;
            font-size: 0.85rem;
            align-items: center;
            gap: 8px;
        }
        .admin-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
            z-index: 90;
        }

        @media (max-width: 900px) {
            body.admin-body {
                flex-direction: column;
            }
            .admin-sidebar {
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                width: min(85vw, 300px);
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
                z-index: 100;
                box-shadow: 4px 0 25px rgba(0, 0, 0, 0.7);
            }
            .admin-sidebar.open {
                transform: translateX(0);
            }
            .admin-backdrop.active {
                display: block;
            }
            .admin-mobile-toggle {
                display: inline-flex;
                min-height: 38px;
            }
            .admin-mobile-close {
                display: inline-flex;
            }
            .admin-brand {
                padding: 18px 16px;
            }
            .admin-topbar {
                padding: 10px 16px;
                height: auto;
                min-height: 60px;
                gap: 10px 14px;
                flex-wrap: wrap;
            }
            .admin-content {
                padding: 20px 16px;
            }
            .admin-card {
                padding: 16px;
                overflow: hidden;
            }
            .admin-table {
                min-width: 600px;
            }
        }

        @media (max-width: 700px) {
            .admin-main,
            .admin-content,
            .admin-card,
            .admin-card-header,
            .admin-topbar,
            .admin-topbar > div {
                min-width: 0;
            }
            .admin-content {
                padding: 16px 12px 28px;
            }
            .admin-content h1 {
                font-size: clamp(1.15rem, 4.5vw, 1.4rem) !important;
                overflow-wrap: anywhere;
            }
            .admin-topbar {
                padding: 10px 12px;
                align-items: center;
            }
            .admin-topbar > div:first-child {
                flex: 1 1 auto;
                min-width: 0;
            }
            .admin-telemetry-badge {
                min-width: 0;
                max-width: 100%;
                font-size: 0.72rem;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            .admin-topbar > div:last-child {
                font-size: 0.74rem !important;
                overflow-wrap: anywhere;
                text-align: left;
            }
            .admin-card {
                padding: 14px;
                margin-bottom: 18px;
            }
            .admin-card-header {
                align-items: flex-start;
                flex-direction: column;
                gap: 10px;
                margin-bottom: 16px;
                padding-bottom: 12px;
            }
            .admin-content [style*="grid-template-columns"] {
                grid-template-columns: minmax(0, 1fr) !important;
            }
            .admin-content [style*="display: flex"] {
                flex-wrap: wrap;
                gap: 10px;
            }
            .form-control {
                font-size: 16px;
            }
            .btn-admin,
            .admin-btn {
                min-height: 42px;
                justify-content: center;
            }
        }
    </style>
</head>
<body class="admin-body">
    <a class="skip-link" href="#adminMainContent">Skip to main content</a>
    <!-- Mobile Drawer Backdrop -->
    <div class="admin-backdrop" id="adminBackdrop" onclick="toggleAdminDrawer()"></div>

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="admin-brand">
            <div>
                <h2>X64EMKEI // CMS</h2>
                <span>Systems Telemetry &bull; v2.0-PROD</span>
            </div>
            <button type="button" class="admin-mobile-close" onclick="toggleAdminDrawer(false)" aria-label="Close navigation menu">&times;</button>
        </div>
        <ul class="admin-nav">
            <li><a href="<?= e(url('admin/dashboard')) ?>" class="<?= (($_SERVER['REQUEST_URI'] ?? '') === url('admin') || str_contains($_SERVER['REQUEST_URI'] ?? '', 'dashboard')) ? 'active' : '' ?>"><span>// DASHBOARD</span></a></li>
            <li><a href="<?= e(url('admin/content')) ?>" class="<?= (($_SERVER['REQUEST_URI'] ?? '') === url('admin/content')) ? 'active' : '' ?>"><span>// CONTENT MANAGEMENT</span></a></li>
            <li><a href="<?= e(url('admin/media')) ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'media') ? 'active' : '' ?>"><span>// MEDIA LIBRARY</span></a></li>
            <li><a href="<?= e(url('admin/settings')) ?>" class="<?= (($_SERVER['REQUEST_URI'] ?? '') === url('admin/settings')) ? 'active' : '' ?>"><span>// WEBSITE SETTINGS</span></a></li>
            <li><a href="<?= e(url('admin/settings/navigation')) ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'settings/navigation') ? 'active' : '' ?>" style="padding-left: 28px; font-size: 0.8rem; color: #94a3b8;"><span>&bull; NAVIGATION ARCH</span></a></li>
            <li><a href="<?= e(url('admin/system')) ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'system') ? 'active' : '' ?>"><span>// SYSTEM MANAGEMENT</span></a></li>

            <li style="margin-top: 14px; padding: 6px 14px 2px 14px; font-size: 0.68rem; color: #64748b; letter-spacing: 1px; font-weight: 700; text-transform: uppercase;">// DIRECT EDITORS</li>
            <li><a href="<?= e(url('admin/articles')) ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'articles') ? 'active' : '' ?>"><span>&rsaquo; Journal Articles</span></a></li>
            <li><a href="<?= e(url('admin/projects')) ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'projects') ? 'active' : '' ?>"><span>&rsaquo; Projects Matrix</span></a></li>
            <li><a href="<?= e(url('admin/hardware')) ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'hardware') ? 'active' : '' ?>"><span>&rsaquo; Lab Archive</span></a></li>
            <li><a href="<?= e(url('admin/messages')) ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'messages') ? 'active' : '' ?>"><span>&rsaquo; Messages</span></a></li>
            <li><a href="<?= e(url('admin/users')) ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'users') ? 'active' : '' ?>"><span>&rsaquo; Operators & RBAC</span></a></li>

            <li style="margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 10px;">
                <a href="<?= e(url('/')) ?>" target="_blank" rel="noopener noreferrer" style="color: #FF5252;"><span>&nearr; PUBLIC PORTFOLIO</span></a>
            </li>
            <li>
                <form action="<?= e(url('admin/logout')) ?>" method="POST" style="margin: 0;">
                    <?= csrf_field() ?>
                    <button type="submit" class="admin-logout-button"><span>&cross; LOGOUT</span></button>
                </form>
            </li>
        </ul>
    </aside>

    <!-- Main View -->
    <div class="admin-main">
        <header class="admin-topbar">
            <div style="display: flex; align-items: center; gap: 12px;">
                <button type="button" class="admin-mobile-toggle" id="adminMobileToggle" onclick="toggleAdminDrawer()" aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="adminSidebar">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                    <span>MENU</span>
                </button>
                <div class="admin-telemetry-badge">
                    <span class="admin-dot"></span>
                    <span>HOST: <?= e($_SERVER['HTTP_HOST'] ?? 'welcome.x64emkei.dpdns.org') ?></span>
                </div>
            </div>
            <div style="font-size: 0.85rem; color: #94a3b8;">
                USER: <span style="color: var(--admin-cyan);"><?= e($currentUser['username'] ?? 'Admin') ?></span>
                (<?= e($currentUser['role'] ?? 'admin') ?>)
            </div>
        </header>

        <main class="admin-content" id="adminMainContent" tabindex="-1">
            <?php if (has_flash('success')): ?>
                <div class="admin-alert admin-alert-success">
                    <span>&#10004;</span> <?= e(flash('success')) ?>
                </div>
            <?php endif; ?>

            <?php if (has_flash('error')): ?>
                <div class="admin-alert admin-alert-error">
                    <span>&#9888;</span> <?= e(flash('error')) ?>
                </div>
            <?php endif; ?>

            <?= $content ?? '' ?>
        </main>
    </div>

    <script>
        function toggleAdminDrawer(forceOpen) {
            var sidebar = document.getElementById('adminSidebar');
            var backdrop = document.getElementById('adminBackdrop');
            var toggleBtn = document.getElementById('adminMobileToggle');
            if (!sidebar || !backdrop) return;
            var isOpen = sidebar.classList.contains('open');
            var nextOpen = typeof forceOpen === 'boolean' ? forceOpen : !isOpen;
            sidebar.classList.toggle('open', nextOpen);
            backdrop.classList.toggle('active', nextOpen);
            document.body.style.overflow = nextOpen ? 'hidden' : '';
            if (toggleBtn) {
                toggleBtn.setAttribute('aria-expanded', nextOpen ? 'true' : 'false');
            }
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                toggleAdminDrawer(false);
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.admin-nav a').forEach(function (link) {
                link.addEventListener('click', function () {
                    if (window.innerWidth <= 900) {
                        toggleAdminDrawer(false);
                    }
                });
            });

            document.querySelectorAll('.admin-table').forEach(function (table) {
                if (table.parentElement && table.parentElement.classList.contains('table-scroll')) return;
                var wrapper = document.createElement('div');
                wrapper.className = 'table-scroll';
                table.parentNode.insertBefore(wrapper, table);
                wrapper.appendChild(table);
            });
        });
    </script>
</body>
</html>
