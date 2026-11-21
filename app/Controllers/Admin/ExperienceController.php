<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Experience;
use App\Models\ActivityLog;
use App\Services\AuthService;
use App\Services\ViewRenderer;

class ExperienceController
{
    public function index(): void
    {
        $experiences = Experience::all('`display_order` ASC, `id` DESC');
        $renderer = new ViewRenderer();
        echo $renderer->render('admin.experience.index', [
            'experiences' => $experiences,
            'pageTitle' => 'Experience Records'
        ], 'admin.layout');
    }

    public function store(): void
    {
        $title = trim((string)($_POST['title'] ?? ''));
        $org = trim((string)($_POST['organization'] ?? ''));

        if ($title === '' || $org === '') {
            flash('error', 'Role title and organization are required.');
            redirect('admin/experience');
        }

        Experience::create([
            'title' => $title,
            'organization' => $org,
            'location' => trim((string)($_POST['location'] ?? '')),
            'type' => trim((string)($_POST['type'] ?? 'Professional')),
            'period_start' => trim((string)($_POST['period_start'] ?? '')),
            'period_end' => trim((string)($_POST['period_end'] ?? '')),
            'is_current' => isset($_POST['is_current']) ? 1 : 0,
            'description' => trim((string)($_POST['description'] ?? '')),
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_published' => 1
        ]);

        ActivityLog::record(AuthService::id(), 'EXPERIENCE_CREATE', "Added experience: {$title} at {$org}");
        flash('success', 'Experience record created.');
        redirect('admin/experience');
    }

    public function delete(int|string $id): void
    {
        $id = (int)$id;
        $exp = Experience::find($id);
        if ($exp) {
            Experience::delete($id);
            ActivityLog::record(AuthService::id(), 'EXPERIENCE_DELETE', "Deleted experience ID {$id}");
            flash('success', 'Experience record removed.');
        }
        redirect('admin/experience');
    }
}
