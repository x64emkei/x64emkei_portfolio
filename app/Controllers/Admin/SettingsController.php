<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\SiteSetting;
use App\Models\ActivityLog;
use App\Services\AuthService;
use App\Services\ViewRenderer;

class SettingsController
{
    public function index(): void
    {
        $settings = SiteSetting::getAllKeyed();
        $renderer = new ViewRenderer();
        echo $renderer->render('admin.settings.index', [
            'settings' => $settings,
            'pageTitle' => 'Core Systems Configuration'
        ], 'admin.layout');
    }

    public function update(): void
    {
        $fields = [
            'site_title' => ['general', 'Public title of the portfolio'],
            'site_tagline' => ['general', 'Meta tagline'],
            'meta_description' => ['seo', 'Default SEO description'],
            'meta_keywords' => ['seo', 'Meta keywords list'],
            'contact_email' => ['contact', 'Primary inbox contact email'],
            'theme_default' => ['appearance', 'Default HUD theme mode (dark or light)'],
            'primary_domain' => ['hosting', 'Primary configured domain'],
            'copyright_text' => ['general', 'Footer copyright label'],
        ];

        foreach ($fields as $key => [$group, $desc]) {
            if (isset($_POST[$key])) {
                SiteSetting::set($key, trim((string)$_POST[$key]), $group, $desc);
            }
        }

        ActivityLog::record(AuthService::id(), 'SETTINGS_UPDATE', 'Updated core site settings & SEO parameters.');
        flash('success', 'Core settings synchronized.');
        redirect('admin/settings');
    }

    public function navigation(): void
    {
        $navigation = \App\Services\NavigationService::getAll();
        $renderer = new ViewRenderer();
        echo $renderer->render('admin.settings.navigation', [
            'navigation' => $navigation,
            'pageTitle' => 'Primary Navigation Manager'
        ], 'admin.layout');
    }

    public function updateNavigation(): void
    {
        $navData = $_POST['nav'] ?? [];
        if (!is_array($navData)) {
            flash('error', 'Invalid navigation payload submitted.');
            redirect('admin/settings/navigation');
            return;
        }

        \App\Services\NavigationService::save($navData);
        ActivityLog::record(AuthService::id(), 'NAV_UPDATE', 'Updated website primary and child navigation settings');
        flash('success', 'Navigation structure and labels updated successfully.');
        redirect('admin/settings/navigation');
    }

    public function resetNavigation(): void
    {
        \App\Services\NavigationService::resetDefaults();
        ActivityLog::record(AuthService::id(), 'NAV_RESET', 'Restored default 6-category navigation architecture');
        flash('success', 'Default 6-category navigation architecture restored.');
        redirect('admin/settings/navigation');
    }
}
