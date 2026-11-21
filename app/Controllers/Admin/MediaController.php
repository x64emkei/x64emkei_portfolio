<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Media;
use App\Models\ActivityLog;
use App\Services\AuthService;
use App\Services\UploadService;
use App\Services\ViewRenderer;

class MediaController
{
    public function index(): void
    {
        $mediaList = Media::all('`created_at` DESC');
        $renderer = new ViewRenderer();
        echo $renderer->render('admin.media.index', [
            'mediaList' => $mediaList,
            'totalStorage' => Media::totalStorageBytes(),
            'pageTitle' => 'Media & Storage Manager'
        ], 'admin.layout');
    }

    public function upload(): void
    {
        if (empty($_FILES['file']['name'])) {
            flash('error', 'No media file selected.');
            redirect('admin/media');
        }

        try {
            $uploader = new UploadService();
            $uploaded = $uploader->handleImageUpload($_FILES['file']);

            $alt = trim((string)($_POST['alt_text'] ?? ''));
            $caption = trim((string)($_POST['caption'] ?? ''));

            Media::create([
                'filename' => $uploaded['filename'],
                'original_name' => $uploaded['original_name'],
                'mime_type' => $uploaded['mime_type'],
                'file_size' => $uploaded['file_size'],
                'file_path' => $uploaded['file_path'],
                'alt_text' => $alt,
                'caption' => $caption,
            ]);

            ActivityLog::record(AuthService::id(), 'MEDIA_UPLOAD', "Uploaded file: {$uploaded['original_name']}");
            flash('success', "Media file \"{$uploaded['original_name']}\" uploaded successfully.");
        } catch (\Exception $e) {
            flash('error', 'Upload rejected: ' . $e->getMessage());
        }

        redirect('admin/media');
    }

    public function delete(int $id): void
    {
        $item = Media::find($id);
        if ($item) {
            $uploader = new UploadService();
            $uploader->deleteFile($item['filename']);
            Media::delete($id);

            ActivityLog::record(AuthService::id(), 'MEDIA_DELETE', "Deleted file: {$item['original_name']}");
            flash('success', 'Media file purged from disk and database.');
        }
        redirect('admin/media');
    }
}
