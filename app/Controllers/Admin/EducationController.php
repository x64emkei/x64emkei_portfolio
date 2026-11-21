<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Education;
use App\Models\ActivityLog;
use App\Services\AuthService;
use App\Services\ViewRenderer;

class EducationController
{
    public function index(): void
    {
        $education = Education::all('`display_order` ASC, `id` DESC');
        $renderer = new ViewRenderer();
        echo $renderer->render('admin.education.index', [
            'education' => $education,
            'pageTitle' => 'Education & Academics'
        ], 'admin.layout');
    }

    public function store(): void
    {
        $inst = trim((string)($_POST['institution'] ?? ''));
        $deg = trim((string)($_POST['degree'] ?? ''));

        if ($inst === '' || $deg === '') {
            flash('error', 'Institution and degree are required.');
            redirect('admin/education');
        }

        Education::create([
            'institution' => $inst,
            'degree' => $deg,
            'field_of_study' => trim((string)($_POST['field_of_study'] ?? '')),
            'period_start' => trim((string)($_POST['period_start'] ?? '')),
            'period_end' => trim((string)($_POST['period_end'] ?? '')),
            'achievements' => trim((string)($_POST['achievements'] ?? '')),
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_published' => 1
        ]);

        ActivityLog::record(AuthService::id(), 'EDUCATION_CREATE', "Added education: {$deg} at {$inst}");
        flash('success', 'Education record added.');
        redirect('admin/education');
    }

    public function delete(int|string $id): void
    {
        $id = (int)$id;
        $edu = Education::find($id);
        if ($edu) {
            Education::delete($id);
            ActivityLog::record(AuthService::id(), 'EDUCATION_DELETE', "Deleted education ID {$id}");
            flash('success', 'Education record removed.');
        }
        redirect('admin/education');
    }
}
