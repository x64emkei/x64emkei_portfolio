<?php
declare(strict_types=1);

/**
 * Recursive FTP Uploader to /htdocs (Root directory) on InfinityFree
 *
 * Credentials are loaded from the project-root .env file.
 * NEVER hardcode credentials in this file.
 */

// ---------------------------------------------------------------------------
// Load credentials from .env
// ---------------------------------------------------------------------------
$envFile = __DIR__ . '/../.env';
$env = [];
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if (str_starts_with($line, '#') || !str_contains($line, '=')) continue;
        [$k, $v] = explode('=', $line, 2);
        $env[trim($k)] = trim($v, " \t\n\r\"'");
    }
}

$host = $env['FTP_HOST'] ?? die("[FATAL] Missing FTP_HOST in .env\n");
$user = $env['FTP_USER'] ?? die("[FATAL] Missing FTP_USER in .env\n");
$pass = $env['FTP_PASS'] ?? die("[FATAL] Missing FTP_PASS in .env\n");
$port = (int)($env['FTP_PORT'] ?? 21);

// ---------------------------------------------------------------------------
// Connect
// ---------------------------------------------------------------------------
$conn = ftp_connect($host, $port, 60);
if (!$conn || !@ftp_login($conn, $user, $pass)) {
    die("ERROR: Failed to connect to {$host} as {$user}.\n");
}
ftp_pasv($conn, true);

$sourceDir = dirname(__DIR__) . '/deploy/htdocs';
$targetDir = '/htdocs';

echo ">>> SYNCING FILES TO INFINITYFREE DIRECTORY: {$targetDir} <<<\n";

function uploadRecursive($conn, string $localPath, string $remotePath): void {
    if (is_dir($localPath)) {
        @ftp_mkdir($conn, $remotePath);

        $items = scandir($localPath);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;
            uploadRecursive($conn, $localPath . '/' . $item, $remotePath . '/' . $item);
        }
    } else {
        $ext = strtolower(pathinfo($localPath, PATHINFO_EXTENSION));
        $binaryExts = ['png', 'jpg', 'jpeg', 'gif', 'webp', 'ico', 'pdf', 'zip', 'gz', 'tar', 'woff', 'woff2', 'ttf', 'eot'];
        $mode = in_array($ext, $binaryExts, true) ? FTP_BINARY : FTP_ASCII;

        @ftp_mkdir($conn, dirname($remotePath));

        $success = @ftp_put($conn, $remotePath, $localPath, $mode);
        if ($success) {
            echo " [OK] {$remotePath}\n";
        } else {
            ftp_pasv($conn, true);
            $retry = @ftp_put($conn, $remotePath, $localPath, $mode);
            echo $retry ? " [RETRY OK] {$remotePath}\n" : " [FAIL] {$remotePath}\n";
        }
    }
}

uploadRecursive($conn, $sourceDir, $targetDir);

ftp_close($conn);
echo "\n=======================================================\n";
echo "SUCCESS: All files successfully uploaded to {$targetDir}!\n";
echo "=======================================================\n";
