<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\HardwareNode;
use App\Models\ActivityLog;
use App\Services\AuthService;
use App\Services\UploadService;
use App\Services\ViewRenderer;

class HardwareController
{
    public function index(): void
    {
        $nodes = HardwareNode::all('`display_order` ASC, `id` ASC');
        $renderer = new ViewRenderer();
        echo $renderer->render('admin.hardware.index', [
            'nodes' => $nodes,
            'pageTitle' => 'Lab Archive Hardware Matrix'
        ], 'admin.layout');
    }

    public function store(): void
    {
        $nodeId = trim((string)($_POST['node_id'] ?? 'NODE.XX // ARCHIVE'));
        $title = trim((string)($_POST['title'] ?? ''));
        $subtitle = trim((string)($_POST['subtitle'] ?? ''));
        $oem = trim((string)($_POST['oem'] ?? ''));
        $log = trim((string)($_POST['diagnostics_log'] ?? ''));

        $img = trim((string)($_POST['image_url'] ?? 'images/carousel-retro.jpg'));
        if (!empty($_FILES['image_file']['name'])) {
            try {
                $uploader = new UploadService();
                $uploaded = $uploader->handleImageUpload($_FILES['image_file']);
                $img = $uploaded['file_path'];
            } catch (\Exception $e) {
                flash('error', 'Image upload failure: ' . $e->getMessage());
                redirect('admin/hardware');
            }
        }

        // Parse specs from lines
        $specsRaw = (string)($_POST['specs_raw'] ?? '');
        $specs = [];
        foreach (explode("\n", $specsRaw) as $line) {
            if (str_contains($line, ':')) {
                [$k, $v] = explode(':', $line, 2);
                $specs[trim($k)] = trim($v);
            }
        }

        HardwareNode::create([
            'node_id' => $nodeId,
            'tag' => trim((string)($_POST['tag'] ?? 'PRESERVED')),
            'title' => $title,
            'subtitle' => $subtitle,
            'oem' => $oem,
            'specs_json' => $specs,
            'diagnostics_log' => $log,
            'image_url' => $img,
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_published' => 1
        ]);

        ActivityLog::record(AuthService::id(), 'HARDWARE_CREATE', "Added hardware node: {$title}");
        flash('success', "Hardware node \"{$title}\" archived in database.");
        redirect('admin/hardware');
    }

    public function delete(int|string $id): void
    {
        $id = (int)$id;
        $node = HardwareNode::find($id);
        if ($node) {
            HardwareNode::delete($id);
            ActivityLog::record(AuthService::id(), 'HARDWARE_DELETE', "Deleted hardware node: {$node['title']}");
            flash('success', "Hardware node record purged.");
        }
        redirect('admin/hardware');
    }
}
