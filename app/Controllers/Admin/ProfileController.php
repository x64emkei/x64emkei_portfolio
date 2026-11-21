<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Profile;
use App\Models\ActivityLog;
use App\Services\AuthService;
use App\Services\UploadService;
use App\Services\ViewRenderer;

class ProfileController
{
    public function edit(): void
    {
        $profile = Profile::get() ?: [];
        $renderer = new ViewRenderer();
        echo $renderer->render('admin.profile', [
            'profile' => $profile,
            'pageTitle' => 'Profile Telemetry'
        ], 'admin.layout');
    }

    public function update(): void
    {
        $data = [
            'full_name' => trim((string)($_POST['full_name'] ?? '')),
            'title' => trim((string)($_POST['title'] ?? '')),
            'tagline' => trim((string)($_POST['tagline'] ?? '')),
            'bio_short' => trim((string)($_POST['bio_short'] ?? '')),
            'bio_full' => trim((string)($_POST['bio_full'] ?? '')),
            'location' => trim((string)($_POST['location'] ?? '')),
            'availability_status' => trim((string)($_POST['availability_status'] ?? '')),
            'resume_url' => trim((string)($_POST['resume_url'] ?? '')),
            'email' => trim((string)($_POST['email'] ?? '')),
            'avatar_url' => trim((string)($_POST['avatar_url'] ?? '')),
            'cover_url' => trim((string)($_POST['cover_url'] ?? '')),
        ];

        // Handle avatar file upload if provided
        if (!empty($_FILES['avatar_file']['name'])) {
            try {
                $uploader = new UploadService();
                $uploaded = $uploader->handleImageUpload($_FILES['avatar_file']);
                $data['avatar_url'] = $uploaded['file_path'];
            } catch (\Exception $e) {
                flash('error', 'Avatar upload error: ' . $e->getMessage());
                redirect('admin/profile');
            }
        }

        Profile::save($data);
        ActivityLog::record(AuthService::id(), 'PROFILE_UPDATE', 'Administrator updated profile details.');

        flash('success', 'Profile telemetry updated successfully.');
        redirect('admin/profile');
    }
}
