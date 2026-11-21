<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Skill;
use App\Models\ActivityLog;
use App\Services\AuthService;
use App\Services\ViewRenderer;

class SkillsController
{
    public function index(): void
    {
        $skills = Skill::all('`category` ASC, `display_order` ASC');
        $renderer = new ViewRenderer();
        echo $renderer->render('admin.skills.index', [
            'skills' => $skills,
            'pageTitle' => 'Skills & Competencies'
        ], 'admin.layout');
    }

    public function store(): void
    {
        $name = trim((string)($_POST['name'] ?? ''));
        $category = trim((string)($_POST['category'] ?? 'Languages'));
        $level = (int)($_POST['proficiency_level'] ?? 85);
        $order = (int)($_POST['display_order'] ?? 0);

        if ($name === '') {
            flash('error', 'Skill name cannot be empty.');
            redirect('admin/skills');
        }

        Skill::create([
            'name' => $name,
            'category' => $category,
            'proficiency_level' => max(10, min(100, $level)),
            'display_order' => $order,
            'is_published' => 1
        ]);

        ActivityLog::record(AuthService::id(), 'SKILL_CREATE', "Added skill: {$name}");
        flash('success', "Skill \"{$name}\" added successfully.");
        redirect('admin/skills');
    }

    public function delete(int $id): void
    {
        $skill = Skill::find($id);
        if ($skill) {
            Skill::delete($id);
            ActivityLog::record(AuthService::id(), 'SKILL_DELETE', "Deleted skill: {$skill['name']}");
            flash('success', "Skill deleted.");
        }
        redirect('admin/skills');
    }
}
