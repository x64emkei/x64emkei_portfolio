<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Service;
use App\Models\ActivityLog;
use App\Services\AuthService;
use App\Services\ViewRenderer;

class ServicesController
{
    public function index(): void
    {
        $services = Service::all('`display_order` ASC, `id` ASC');
        $renderer = new ViewRenderer();
        echo $renderer->render('admin.services.index', [
            'services' => $services,
            'pageTitle' => 'Engineering Services'
        ], 'admin.layout');
    }

    public function store(): void
    {
        $title = trim((string)($_POST['title'] ?? ''));
        $cat = trim((string)($_POST['category'] ?? 'Engineering'));
        $desc = trim((string)($_POST['description'] ?? ''));

        if ($title === '' || $desc === '') {
            flash('error', 'Service title and description are required.');
            redirect('admin/services');
        }

        Service::create([
            'title' => $title,
            'category' => $cat,
            'description' => $desc,
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_published' => 1
        ]);

        ActivityLog::record(AuthService::id(), 'SERVICE_CREATE', "Added service: {$title}");
        flash('success', 'Service registered.');
        redirect('admin/services');
    }

    public function delete(int $id): void
    {
        $srv = Service::find($id);
        if ($srv) {
            Service::delete($id);
            ActivityLog::record(AuthService::id(), 'SERVICE_DELETE', "Deleted service ID {$id}");
            flash('success', 'Service removed.');
        }
        redirect('admin/services');
    }
}
