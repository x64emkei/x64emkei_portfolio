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
}
