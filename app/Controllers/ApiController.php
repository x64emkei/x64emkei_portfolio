<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Project;
use App\Models\HardwareNode;

class ApiController
{
    public function projects(): void
    {
        $filter = (string)($_GET['filter'] ?? 'all');
        $projects = Project::getPublished($filter);
        json_response(['status' => 'success', 'count' => count($projects), 'data' => $projects]);
    }

    public function project(string $slug): void
    {
        $project = Project::findBySlug($slug);
        if (!$project) {
            json_response(['status' => 'error', 'message' => 'Project record not found in telemetry registry.'], 404);
        }

        // Decode JSON fields for rich client consumption
        $project['features'] = json_decode($project['features_json'] ?: '[]', true);
        $project['technologies'] = json_decode($project['technologies_json'] ?: '[]', true);

        json_response(['status' => 'success', 'data' => $project]);
    }

    public function hardware(string $id): void
    {
        $node = HardwareNode::find((int)$id);
        if (!$node) {
            json_response(['status' => 'error', 'message' => 'Hardware node not found in archive.'], 404);
        }

        $node['specs'] = json_decode($node['specs_json'] ?: '{}', true);
        json_response(['status' => 'success', 'data' => $node]);
    }

    public function health(): void
    {
        $dbStatus = 'disconnected';
        try {
            $pdo = \Database\Database::getConnection();
            $pdo->query('SELECT 1');
            $dbStatus = 'connected';
        } catch (\Throwable $e) {
            $dbStatus = 'unreachable';
        }

        $healthy = ($dbStatus === 'connected');
        json_response([
            'status' => $healthy ? 'healthy' : 'degraded',
            'timestamp' => date('c'),
            'subsystems' => [
                'php' => PHP_VERSION,
                'database' => $dbStatus,
                'storage' => is_writable(dirname(__DIR__, 2) . '/storage/logs') ? 'writable' : 'readonly',
            ]
        ], $healthy ? 200 : 503);
    }
}
