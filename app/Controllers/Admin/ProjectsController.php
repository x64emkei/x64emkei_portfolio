<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Project;
use App\Models\ActivityLog;
use App\Services\AuthService;
use App\Services\UploadService;
use App\Services\ViewRenderer;

class ProjectsController
{
    public function index(): void
    {
        $projects = Project::all('`display_order` ASC, `id` DESC');
        $renderer = new ViewRenderer();
        echo $renderer->render('admin.projects.index', [
            'projects' => $projects,
            'pageTitle' => 'Project Matrix'
        ], 'admin.layout');
    }

    public function create(): void
    {
        $renderer = new ViewRenderer();
        echo $renderer->render('admin.projects.create', [
            'pageTitle' => 'Create New System Project'
        ], 'admin.layout');
    }

    public function store(): void
    {
        $features = array_filter(array_map('trim', explode("\n", (string)($_POST['features_raw'] ?? ''))));
        $technologies = array_filter(array_map('trim', explode(',', (string)($_POST['technologies_raw'] ?? ''))));

        $title = trim((string)($_POST['title'] ?? ''));
        $slug = trim((string)($_POST['slug'] ?? '')) ?: slugify($title);

        $featuredImage = trim((string)($_POST['featured_image'] ?? 'images/carousel-retro.jpg'));

        if (!empty($_FILES['image_file']['name'])) {
            try {
                $uploader = new UploadService();
                $uploaded = $uploader->handleImageUpload($_FILES['image_file']);
                $featuredImage = $uploaded['file_path'];
            } catch (\Exception $e) {
                flash('error', 'Image upload failure: ' . $e->getMessage());
                redirect('admin/projects/create');
            }
        }

        $id = Project::create([
            'slug' => $slug,
            'code_id' => trim((string)($_POST['code_id'] ?? 'SYS.000 // ARCHITECTURE')),
            'category' => trim((string)($_POST['category'] ?? 'Systems')),
            'filter_tag' => trim((string)($_POST['filter_tag'] ?? 'systems')),
            'title' => $title,
            'tagline' => trim((string)($_POST['tagline'] ?? '')),
            'environment' => trim((string)($_POST['environment'] ?? '')),
            'performance_metric' => trim((string)($_POST['performance_metric'] ?? '')),
            'operational_status' => trim((string)($_POST['operational_status'] ?? 'Operational')),
            'description' => trim((string)($_POST['description'] ?? '')),
            'features_json' => array_values($features),
            'code_filename' => trim((string)($_POST['code_filename'] ?? '')),
            'code_snippet' => (string)($_POST['code_snippet'] ?? ''),
            'technologies_json' => array_values($technologies),
            'github_url' => trim((string)($_POST['github_url'] ?? '')),
            'demo_url' => trim((string)($_POST['demo_url'] ?? '')),
            'featured_image' => $featuredImage,
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'is_published' => isset($_POST['is_published']) ? 1 : 0,
        ]);

        ActivityLog::record(AuthService::id(), 'PROJECT_CREATE', "Created project: {$title} (ID: {$id})");
        flash('success', "Project \"{$title}\" created successfully.");
        redirect('admin/projects');
    }

    public function edit(int|string $id): void
    {
        $id = (int)$id;
        $project = Project::find($id);
        if (!$project) {
            flash('error', 'Project not found.');
            redirect('admin/projects');
        }

        $renderer = new ViewRenderer();
        echo $renderer->render('admin.projects.edit', [
            'project' => $project,
            'pageTitle' => 'Edit System Project: ' . $project['title']
        ], 'admin.layout');
    }

    public function update(int|string $id): void
    {
        $id = (int)$id;
        $project = Project::find($id);
        if (!$project) {
            flash('error', 'Project not found.');
            redirect('admin/projects');
        }

        $features = array_filter(array_map('trim', explode("\n", (string)($_POST['features_raw'] ?? ''))));
        $technologies = array_filter(array_map('trim', explode(',', (string)($_POST['technologies_raw'] ?? ''))));

        $title = trim((string)($_POST['title'] ?? ''));
        $slug = trim((string)($_POST['slug'] ?? '')) ?: slugify($title);

        $featuredImage = trim((string)($_POST['featured_image'] ?? $project['featured_image']));

        if (!empty($_FILES['image_file']['name'])) {
            try {
                $uploader = new UploadService();
                $uploaded = $uploader->handleImageUpload($_FILES['image_file']);
                $featuredImage = $uploaded['file_path'];
            } catch (\Exception $e) {
                flash('error', 'Image upload failure: ' . $e->getMessage());
                redirect('admin/projects/' . $id . '/edit');
            }
        }

        Project::update($id, [
            'slug' => $slug,
            'code_id' => trim((string)($_POST['code_id'] ?? $project['code_id'])),
            'category' => trim((string)($_POST['category'] ?? $project['category'])),
            'filter_tag' => trim((string)($_POST['filter_tag'] ?? $project['filter_tag'])),
            'title' => $title,
            'tagline' => trim((string)($_POST['tagline'] ?? '')),
            'environment' => trim((string)($_POST['environment'] ?? '')),
            'performance_metric' => trim((string)($_POST['performance_metric'] ?? '')),
            'operational_status' => trim((string)($_POST['operational_status'] ?? 'Operational')),
            'description' => trim((string)($_POST['description'] ?? '')),
            'features_json' => array_values($features),
            'code_filename' => trim((string)($_POST['code_filename'] ?? '')),
            'code_snippet' => (string)($_POST['code_snippet'] ?? ''),
            'technologies_json' => array_values($technologies),
            'github_url' => trim((string)($_POST['github_url'] ?? '')),
            'demo_url' => trim((string)($_POST['demo_url'] ?? '')),
            'featured_image' => $featuredImage,
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'is_published' => isset($_POST['is_published']) ? 1 : 0,
        ]);

        ActivityLog::record(AuthService::id(), 'PROJECT_UPDATE', "Updated project: {$title} (ID: {$id})");
        flash('success', "Project \"{$title}\" updated successfully.");
        redirect('admin/projects');
    }

    public function delete(int|string $id): void
    {
        $id = (int)$id;
        $project = Project::find($id);
        if ($project) {
            Project::delete($id);
            ActivityLog::record(AuthService::id(), 'PROJECT_DELETE', "Deleted project: {$project['title']}");
            flash('success', "Project deleted from database.");
        }
        redirect('admin/projects');
    }
}
