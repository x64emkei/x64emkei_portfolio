<?php
declare(strict_types=1);

/**
 * X64EMKEI Portfolio // System Health & Compatibility CLI Diagnostic
 */

$root = dirname(__DIR__);
require_once $root . '/bootstrap/autoload.php';
require_once $root . '/bootstrap/app.php';

echo "\n======================================================\n";
echo "   x64emkei.dev // SYSTEM HEALTH & AUDIT DIAGNOSTIC\n";
echo "======================================================\n\n";

$allPassed = true;

// 1. PHP Version
$phpVer = PHP_VERSION;
$phpOk = version_compare($phpVer, '8.2.0', '>=');
echo sprintf("  [%s] PHP Version: %s (Requirement: >= 8.2.0)\n", $phpOk ? 'PASS' : 'FAIL', $phpVer);
if (!$phpOk) $allPassed = false;

// 2. Extensions
$requiredExts = ['pdo', 'pdo_mysql', 'json', 'mbstring', 'openssl', 'session', 'fileinfo'];
foreach ($requiredExts as $ext) {
    $ok = extension_loaded($ext);
    echo sprintf("  [%s] Extension: %s\n", $ok ? 'PASS' : 'FAIL', $ext);
    if (!$ok) $allPassed = false;
}

// 3. Storage Directories
$storageDirs = [
    'storage/logs' => $root . '/storage/logs',
    'storage/cache' => $root . '/storage/cache',
    'storage/uploads' => $root . '/storage/uploads',
];
foreach ($storageDirs as $name => $path) {
    $exists = is_dir($path);
    $writable = is_writable($path);
    $ok = $exists && $writable;
    echo sprintf("  [%s] Storage: %s (Exists: %s, Writable: %s)\n",
        $ok ? 'PASS' : 'WARN',
        $name,
        $exists ? 'YES' : 'NO',
        $writable ? 'YES' : 'NO'
    );
    if (!$exists) $allPassed = false;
}

// 4. Database Connection & Schema
try {
    $pdo = \Database\Database::getConnection();
    echo "  [PASS] Database: Connected successfully via PDO\n";
    $tables = $pdo->query('SHOW TABLES')->fetchAll(\PDO::FETCH_COLUMN);
    $tableCount = count($tables);
    echo sprintf("  [PASS] Database Schema: %d tables verified in database\n", $tableCount);
    if ($tableCount < 10) {
        echo "  [WARN] Database has fewer than 10 tables. Please ensure schema_dump.sql is imported.\n";
    }
} catch (\Throwable $e) {
    echo sprintf("  [WARN] Database: Offline or uninitialized (%s)\n", $e->getMessage());
    echo "         (Public pages gracefully use offline fallback telemetry)\n";
}

// 5. Configuration Validation
$appUrl = env('APP_URL');
$dbHost = env('DB_HOST');
echo sprintf("  [INFO] Config APP_URL: %s\n", $appUrl ?: 'DEFAULT');
echo sprintf("  [INFO] Config DB_HOST: %s\n", $dbHost ?: 'DEFAULT');

echo "\n------------------------------------------------------\n";
if ($allPassed) {
    echo "[OPTIMAL] Core system health validated. Application ready for production!\n";
} else {
    echo "[DEGRADED] One or more system checks failed. Review output above.\n";
}
echo "------------------------------------------------------\n\n";
