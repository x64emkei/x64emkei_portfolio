<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\PortfolioSection;
use App\Models\ActivityLog;
use App\Services\AuthService;
use App\Services\ViewRenderer;

class SectionsController
{
    public function index(): void
    {
        $sections = PortfolioSection::allOrdered();
        $renderer = new ViewRenderer();
        echo $renderer->render('admin.sections.index', [
            'sections' => $sections,
            'pageTitle' => 'Portfolio Section Architecture'
        ], 'admin.layout');
    }

    public function update(int|string $id): void
    {
        $id = (int)$id;
        $section = PortfolioSection::find($id);
        if (!$section) {
            flash('error', 'Section not found.');
            redirect('admin/sections');
        }

        $title = trim((string)($_POST['title'] ?? ''));
        if ($title === '') {
            flash('error', 'Section title cannot be empty.');
            redirect('admin/sections');
        }

        PortfolioSection::updateSection($section['section_key'], [
            'title' => $title,
            'subtitle' => trim((string)($_POST['subtitle'] ?? '')),
            'intro_text' => trim((string)($_POST['intro_text'] ?? '')),
            'is_enabled' => isset($_POST['is_enabled']) ? 1 : 0,
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'layout_variation' => trim((string)($_POST['layout_variation'] ?? 'default')),
            'hide_if_empty' => isset($_POST['hide_if_empty']) ? 1 : 0,
        ]);

        ActivityLog::record(AuthService::id(), 'SECTION_UPDATE', "Updated section {$section['section_key']} configuration");
        flash('success', "Section [{$section['section_key']}] updated successfully.");
        redirect('admin/sections');
    }

    public function toggle(int|string $id): void
    {
        $id = (int)$id;
        $section = PortfolioSection::find($id);
        if ($section) {
            $newStatus = $section['is_enabled'] ? 0 : 1;
            PortfolioSection::updateSection($section['section_key'], array_merge($section, ['is_enabled' => $newStatus]));
            ActivityLog::record(AuthService::id(), 'SECTION_TOGGLE', "Toggled section {$section['section_key']} to {$newStatus}");
            flash('success', "Section [{$section['section_key']}] visibility toggled.");
        }
        redirect('admin/sections');
    }
}
