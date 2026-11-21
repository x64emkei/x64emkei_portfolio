<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Project;
use App\Models\HardwareNode;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Service;
use App\Models\Message;
use App\Models\Media;
use App\Models\ActivityLog;
use App\Services\ViewRenderer;

class DashboardController
{
    public function index(): void
    {
        $stats = [
            'total_projects' => Project::count(),
            'published_projects' => Project::count('`is_published` = 1'),
            'draft_projects' => Project::count('`is_published` = 0'),
            'total_hardware' => HardwareNode::count(),
            'total_skills' => Skill::count(),
            'total_experiences' => Experience::count(),
            'total_services' => Service::count(),
            'unread_messages' => Message::countUnread(),
            'total_messages' => Message::count(),
            'storage_bytes' => Media::totalStorageBytes(),
            'php_version' => PHP_VERSION,
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'PHP CLI / Shared Host',
        ];

        $recentActivity = ActivityLog::getRecent(8);
        $recentMessages = Message::getInbox(5);

        $renderer = new ViewRenderer();
        echo $renderer->render('admin.dashboard', [
            'stats' => $stats,
            'recentActivity' => $recentActivity,
            'recentMessages' => $recentMessages,
            'pageTitle' => 'Telemetry Control Deck'
        ], 'admin.layout');
    }
}
