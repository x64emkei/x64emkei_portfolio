<?php
declare(strict_types=1);

require_once __DIR__ . '/../bootstrap/autoload.php';
require_once __DIR__ . '/../bootstrap/app.php';

use Database\Database;
use Database\MigrationRunner;
use Database\Seeders\PortfolioDataSeeder;

$key = $_GET['key'] ?? '';
$auth = isset($_SESSION['user_id']);

if (!$auth && $key !== 'x64emkei') {
    http_response_code(403);
    die('ACCESS DENIED // Pass ?key=x64emkei or authenticate in Control Deck.');
}

header('Content-Type: application/json; charset=utf-8');

try {
    $pdo = Database::getConnection();
    $runner = new MigrationRunner($pdo);
    $migResult = $runner->run();

    $seeder = new PortfolioDataSeeder($pdo);
    $seeder->run(true);

    $counts = [
        'projects' => (int)$pdo->query("SELECT COUNT(*) FROM `projects`")->fetchColumn(),
        'hardware_nodes' => (int)$pdo->query("SELECT COUNT(*) FROM `hardware_nodes`")->fetchColumn(),
        'skills' => (int)$pdo->query("SELECT COUNT(*) FROM `skills`")->fetchColumn(),
        'experiences' => (int)$pdo->query("SELECT COUNT(*) FROM `experiences`")->fetchColumn(),
        'education' => (int)$pdo->query("SELECT COUNT(*) FROM `education`")->fetchColumn(),
        'services' => (int)$pdo->query("SELECT COUNT(*) FROM `services`")->fetchColumn(),
        'social_links' => (int)$pdo->query("SELECT COUNT(*) FROM `social_links`")->fetchColumn(),
    ];

    echo json_encode([
        'status' => 'success',
        'message' => 'All portfolio dataset records successfully synchronized to MySQL!',
        'records' => $counts
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ], JSON_PRETTY_PRINT);
}
