<?php
declare(strict_types=1);

/**
 * CLI Migration Runner Script
 * Usage: php database/migrate.php
 */

require_once __DIR__ . '/../bootstrap/autoload.php';
require_once __DIR__ . '/../bootstrap/app.php';

use Database\Database;
use Database\MigrationRunner;
use Database\Seeders\PortfolioDataSeeder;

echo "\n======================================================\n";
echo "   x64emkei.dev // DATABASE MIGRATION & SEED RUNNER    \n";
echo "======================================================\n\n";

try {
    $pdo = Database::getConnection();
    echo "[OK] Connected to database successfully.\n";

    $runner = new MigrationRunner($pdo);
    $result = $runner->run();

    if ($result['status'] === 'clean') {
        echo "[INFO] No pending migrations. Schema is up to date.\n";
    } else {
        echo "[SUCCESS] Applied " . count($result['applied']) . " migration(s) (Batch #{$result['batch']}):\n";
        foreach ($result['applied'] as $mig) {
            echo "  --> " . $mig . "\n";
        }
    }

    // Check if seeding is needed (e.g. projects table empty)
    $stmt = $pdo->query("SELECT COUNT(*) FROM `projects`");
    $projectCount = (int)$stmt->fetchColumn();

    $force = in_array('--force', $argv ?? [], true) || in_array('-f', $argv ?? [], true);

    if ($projectCount === 0 || $force) {
        echo "\n[INFO] Executing PortfolioDataSeeder (Force refresh: " . ($force ? 'YES' : 'NO') . ")...\n";
        $seeder = new PortfolioDataSeeder($pdo);
        $seeder->run($force);
        echo "[SUCCESS] Database seeded with full portfolio dataset (projects, hardware nodes, profile, skills, education, services).\n";
    } else {
        echo "[INFO] Projects table already contains {$projectCount} records. (Use --force to refresh)\n";
    }

    echo "\nDatabase is ready for production!\n\n";
} catch (Exception $e) {
    echo "\n[ERROR] Migration failed: " . $e->getMessage() . "\n\n";
    exit(1);
}
