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

    public function systemHealth(): void
    {
        $dbStatus = 'OK';
        $dbDetails = [];
        try {
            $pdo = \Database\Database::getConnection();
            $dbName = $pdo->query('SELECT DATABASE()')->fetchColumn();
            $tables = $pdo->query('SHOW TABLES')->fetchAll(\PDO::FETCH_COLUMN);
            $dbDetails = [
                'status' => 'CONNECTED',
                'database' => $dbName,
                'table_count' => count($tables),
                'tables' => $tables,
            ];
        } catch (\Throwable $e) {
            $dbStatus = 'DEGRADED';
            $dbDetails = [
                'status' => 'ERROR',
                'message' => 'Connection failed or undergoing sync.'
            ];
        }

        $extensions = ['pdo', 'pdo_mysql', 'json', 'mbstring', 'openssl', 'session', 'fileinfo'];
        $extStatus = [];
        foreach ($extensions as $ext) {
            $extStatus[$ext] = extension_loaded($ext);
        }

        $storageLogs = dirname(__DIR__, 3) . '/storage/logs';
        $storageCache = dirname(__DIR__, 3) . '/storage/cache';
        $storageUploads = dirname(__DIR__, 3) . '/storage/uploads';

        $health = [
            'status' => ($dbStatus === 'OK') ? 'OPTIMAL' : 'DEGRADED',
            'timestamp' => date('Y-m-d H:i:s T'),
            'environment' => [
                'php_version' => PHP_VERSION,
                'php_sapi' => PHP_SAPI,
                'server' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
                'memory_limit' => ini_get('memory_limit'),
                'max_execution_time' => ini_get('max_execution_time'),
                'upload_max_filesize' => ini_get('upload_max_filesize'),
                'post_max_size' => ini_get('post_max_size'),
            ],
            'extensions' => $extStatus,
            'database' => $dbDetails,
            'storage' => [
                'logs' => ['path' => 'storage/logs', 'exists' => is_dir($storageLogs), 'writable' => is_writable($storageLogs)],
                'cache' => ['path' => 'storage/cache', 'exists' => is_dir($storageCache), 'writable' => is_writable($storageCache)],
                'uploads' => ['path' => 'storage/uploads', 'exists' => is_dir($storageUploads), 'writable' => is_writable($storageUploads)],
            ]
        ];

        json_response($health, ($health['status'] === 'OPTIMAL') ? 200 : 503);
    }

    public function syncDatabase(): void
    {
        try {
            $pdo = \Database\Database::getConnection();
            $runner = new \Database\MigrationRunner($pdo);
            $runner->run();

            $seeder = new \Database\Seeders\PortfolioDataSeeder($pdo);
            $seeder->run(true);

            \App\Models\ActivityLog::record(\App\Services\AuthService::id(), 'DATABASE_SYNC', 'Synchronized database with authentic portfolio dataset');
            flash('success', 'Database synchronized with full portfolio archives (16 projects, 6 hardware nodes, skills, education, and services).');
        } catch (\Throwable $e) {
            flash('error', 'Database sync failed: ' . $e->getMessage());
        }

        redirect('admin/dashboard');
    }
}
