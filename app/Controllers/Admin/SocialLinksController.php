<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\SocialLink;
use App\Models\ActivityLog;
use App\Services\AuthService;
use App\Services\ViewRenderer;

class SocialLinksController
{
    public function index(): void
    {
        $links = SocialLink::all('`display_order` ASC, `id` ASC');
        $renderer = new ViewRenderer();
        echo $renderer->render('admin.social.index', [
            'links' => $links,
            'pageTitle' => 'Social & External Telemetry Links'
        ], 'admin.layout');
    }

    public function store(): void
    {
        $platform = trim((string)($_POST['platform'] ?? ''));
        $label = trim((string)($_POST['label'] ?? ''));
        $targetUrl = trim((string)($_POST['url'] ?? ''));

        if ($platform === '' || $targetUrl === '') {
            flash('error', 'Platform and valid URL are required.');
            redirect('admin/social');
        }

        SocialLink::create([
            'platform' => $platform,
            'label' => $label ?: ucfirst($platform),
            'url' => $targetUrl,
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_published' => 1
        ]);

        ActivityLog::record(AuthService::id(), 'SOCIAL_CREATE', "Added social link: {$label} ({$platform})");
        flash('success', 'Social link added.');
        redirect('admin/social');
    }

    public function delete(int|string $id): void
    {
        $id = (int)$id;
        $item = SocialLink::find($id);
        if ($item) {
            SocialLink::delete($id);
            ActivityLog::record(AuthService::id(), 'SOCIAL_DELETE', "Deleted social link ID {$id}");
            flash('success', 'Social link removed.');
        }
        redirect('admin/social');
    }
}
