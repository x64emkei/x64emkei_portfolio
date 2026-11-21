<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Certification;
use App\Models\ActivityLog;
use App\Services\AuthService;
use App\Services\ViewRenderer;

class CertificationsController
{
    public function index(): void
    {
        $certs = Certification::all('`display_order` ASC, `id` DESC');
        $renderer = new ViewRenderer();
        echo $renderer->render('admin.certifications.index', [
            'certifications' => $certs,
            'pageTitle' => 'Certifications & Credentials'
        ], 'admin.layout');
    }

    public function store(): void
    {
        $title = trim((string)($_POST['title'] ?? ''));
        $issuer = trim((string)($_POST['issuer'] ?? ''));

        if ($title === '' || $issuer === '') {
            flash('error', 'Title and issuing organization are required.');
            redirect('admin/certifications');
        }

        Certification::create([
            'title' => $title,
            'issuer' => $issuer,
            'issue_date' => trim((string)($_POST['issue_date'] ?? '')),
            'credential_id' => trim((string)($_POST['credential_id'] ?? '')),
            'credential_url' => trim((string)($_POST['credential_url'] ?? '')),
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_published' => 1
        ]);

        ActivityLog::record(AuthService::id(), 'CERT_CREATE', "Added certification: {$title}");
        flash('success', 'Certification record logged.');
        redirect('admin/certifications');
    }

    public function delete(int|string $id): void
    {
        $id = (int)$id;
        $cert = Certification::find($id);
        if ($cert) {
            Certification::delete($id);
            ActivityLog::record(AuthService::id(), 'CERT_DELETE', "Deleted certification ID {$id}");
            flash('success', 'Certification removed.');
        }
        redirect('admin/certifications');
    }
}
