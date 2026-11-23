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
            --admin-bg: #07090e;
            --admin-surface: #0e121a;
            --admin-card: rgba(18, 24, 38, 0.7);
            --admin-border: rgba(0, 229, 255, 0.2);
            --admin-cyan: #00e5ff;
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
            background: var(--admin-surface);
            border-right: 1px solid var(--admin-border);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            z-index: 50;
        }
        .admin-brand {
            padding: 24px;
            border-bottom: 1px solid var(--admin-border);
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
            color: var(--admin-cyan);
            background: rgba(0, 229, 255, 0.08);
            border-left-color: var(--admin-cyan);
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
            border-bottom: 1px solid var(--admin-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            background: rgba(14, 18, 26, 0.6);
            backdrop-filter: blur(8px);
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
            background: var(--admin-surface);
            border: 1px solid var(--admin-border);
            border-radius: 6px;
            padding: 24px;
            margin-bottom: 24px;
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
            background: rgba(7, 9, 14, 0.8);
            border: 1px solid rgba(0, 229, 255, 0.25);
            color: #f8fafc;
            font-family: inherit;
            font-size: 0.88rem;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--admin-cyan);
            box-shadow: 0 0 10px rgba(0, 229, 255, 0.2);
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
            background: var(--admin-cyan);
            color: #07090e;
        }
        .btn-admin-cyan:hover {
            box-shadow: 0 0 15px rgba(0, 229, 255, 0.4);
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
            background: rgba(0, 229, 255, 0.02);
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
                width: 280px;
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
            }
            .admin-topbar {
                padding: 0 16px;
                gap: 12px;
            }
            .admin-content {
                padding: 20px 16px;
            }
            .admin-card {
                padding: 16px;
                overflow-x: auto;
            }
            .admin-table {
                min-width: 600px;
            }
        }
    </style>
</head>
<body class="admin-body">
    <!-- Mobile Drawer Backdrop -->
    <div class="admin-backdrop" id="adminBackdrop" onclick="toggleAdminDrawer()"></div>

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="admin-brand">
            <h2>X64EMKEI // CMS</h2>
            <span>Systems Telemetry &bull; v2.0-PROD</span>
        </div>
        <ul class="admin-nav">
            <li><a href="<?= e(url('admin')) ?>" class="<?= (($_SERVER['REQUEST_URI'] ?? '') === url('admin') || str_contains($_SERVER['REQUEST_URI'] ?? '', 'dashboard')) ? 'active' : '' ?>"><span>// DASHBOARD</span></a></li>
            <li><a href="<?= e(url('admin/articles')) ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'articles') ? 'active' : '' ?>"><span>// JOURNAL ARTICLES</span></a></li>
            <li><a href="<?= e(url('admin/sections')) ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'sections') ? 'active' : '' ?>"><span>// SECTIONS ARCH</span></a></li>
            <li><a href="<?= e(url('admin/profile')) ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'profile') ? 'active' : '' ?>"><span>// PROFILE</span></a></li>
            <li><a href="<?= e(url('admin/projects')) ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'projects') ? 'active' : '' ?>"><span>// PROJECTS MATRIX</span></a></li>
            <li><a href="<?= e(url('admin/skills')) ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'skills') ? 'active' : '' ?>"><span>// SKILLS</span></a></li>
            <li><a href="<?= e(url('admin/experience')) ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'experience') ? 'active' : '' ?>"><span>// EXPERIENCE</span></a></li>
            <li><a href="<?= e(url('admin/education')) ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'education') ? 'active' : '' ?>"><span>// EDUCATION</span></a></li>
            <li><a href="<?= e(url('admin/achievements')) ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'achievements') ? 'active' : '' ?>"><span>// ACHIEVEMENTS</span></a></li>
            <li><a href="<?= e(url('admin/services')) ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'services') ? 'active' : '' ?>"><span>// SERVICES</span></a></li>
            <li><a href="<?= e(url('admin/hardware')) ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'hardware') ? 'active' : '' ?>"><span>// LAB ARCHIVE</span></a></li>
            <li><a href="<?= e(url('admin/certifications')) ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'certifications') ? 'active' : '' ?>"><span>// CERTS</span></a></li>
            <li><a href="<?= e(url('admin/social')) ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'social') ? 'active' : '' ?>"><span>// SOCIAL LINKS</span></a></li>
            <li><a href="<?= e(url('admin/media')) ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'media') ? 'active' : '' ?>"><span>// MEDIA MANAGER</span></a></li>
            <li><a href="<?= e(url('admin/messages')) ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'messages') ? 'active' : '' ?>"><span>// MESSAGES</span></a></li>
            <li><a href="<?= e(url('admin/users')) ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'users') ? 'active' : '' ?>"><span>// OPERATORS & RBAC</span></a></li>
            <li><a href="<?= e(url('admin/settings')) ?>" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'settings') ? 'active' : '' ?>"><span>// CORE SETTINGS</span></a></li>
            <li style="margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 10px;">
                <a href="<?= e(url('/')) ?>" target="_blank" style="color: #38bdf8;"><span>&nearr; PUBLIC PORTFOLIO</span></a>
            </li>
            <li>
                <a href="<?= e(url('admin/logout')) ?>" style="color: var(--admin-magenta);"><span>&cross; LOGOUT</span></a>
            </li>
        </ul>
    </aside>

    <!-- Main View -->
    <div class="admin-main">
        <header class="admin-topbar">
            <div style="display: flex; align-items: center; gap: 12px;">
                <button type="button" class="admin-mobile-toggle" onclick="toggleAdminDrawer()" aria-label="Toggle navigation menu">
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
                OPERATOR: <span style="color: var(--admin-cyan);"><?= e($currentUser['username'] ?? 'Admin') ?></span>
                (<?= e($currentUser['role'] ?? 'admin') ?>)
            </div>
        </header>

        <main class="admin-content">
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
        function toggleAdminDrawer() {
            var sidebar = document.getElementById('adminSidebar');
            var backdrop = document.getElementById('adminBackdrop');
            if (!sidebar || !backdrop) return;
            var isOpen = sidebar.classList.contains('open');
            if (isOpen) {
                sidebar.classList.remove('open');
                backdrop.classList.remove('active');
                document.body.style.overflow = '';
            } else {
                sidebar.classList.add('open');
                backdrop.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }
    </script>
</body>
</html>
