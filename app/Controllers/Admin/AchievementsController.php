<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Achievement;
use App\Models\ActivityLog;
use App\Services\AuthService;
use App\Services\ViewRenderer;

class AchievementsController
{
    public function index(): void
    {
        $achievements = Achievement::all('`display_order` ASC, `id` DESC');
        $renderer = new ViewRenderer();
        echo $renderer->render('admin.achievements.index', [
            'achievements' => $achievements,
            'pageTitle' => 'Achievements & Awards'
        ], 'admin.layout');
    }

    public function store(): void
    {
        $title = trim((string)($_POST['title'] ?? ''));
        if ($title === '') {
            flash('error', 'Achievement title is required.');
            redirect('admin/achievements');
        }

        Achievement::create([
            'title' => $title,
            'issuer' => trim((string)($_POST['issuer'] ?? '')),
            'description' => trim((string)($_POST['description'] ?? '')),
            'award_date' => trim((string)($_POST['award_date'] ?? '')),
            'category' => trim((string)($_POST['category'] ?? 'Academic')),
            'image_url' => trim((string)($_POST['image_url'] ?? '')),
            'document_url' => trim((string)($_POST['document_url'] ?? '')),
            'verification_url' => trim((string)($_POST['verification_url'] ?? '')),
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_published' => isset($_POST['is_published']) ? 1 : 0,
        ]);

        ActivityLog::record(AuthService::id(), 'ACHIEVE_CREATE', "Added achievement: {$title}");
        flash('success', 'Achievement record saved.');
        redirect('admin/achievements');
    }

    public function update(int|string $id): void
    {
        $id = (int)$id;
        $achievement = Achievement::find($id);
        if (!$achievement) {
            flash('error', 'Achievement not found.');
            redirect('admin/achievements');
        }

        $title = trim((string)($_POST['title'] ?? ''));
        if ($title === '') {
            flash('error', 'Achievement title cannot be empty.');
            redirect('admin/achievements');
        }

        Achievement::update($id, [
            'title' => $title,
            'issuer' => trim((string)($_POST['issuer'] ?? '')),
            'description' => trim((string)($_POST['description'] ?? '')),
            'award_date' => trim((string)($_POST['award_date'] ?? '')),
            'category' => trim((string)($_POST['category'] ?? 'Academic')),
            'image_url' => trim((string)($_POST['image_url'] ?? '')),
            'document_url' => trim((string)($_POST['document_url'] ?? '')),
            'verification_url' => trim((string)($_POST['verification_url'] ?? '')),
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_published' => isset($_POST['is_published']) ? 1 : 0,
        ]);

        ActivityLog::record(AuthService::id(), 'ACHIEVE_UPDATE', "Updated achievement ID {$id}");
        flash('success', 'Achievement record updated.');
        redirect('admin/achievements');
    }

    public function delete(int|string $id): void
    {
        $id = (int)$id;
        $achievement = Achievement::find($id);
        if ($achievement) {
            Achievement::delete($id);
            ActivityLog::record(AuthService::id(), 'ACHIEVE_DELETE', "Deleted achievement ID {$id}");
            flash('success', 'Achievement removed.');
        }
        redirect('admin/achievements');
    }
}
