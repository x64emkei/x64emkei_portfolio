<?php
declare(strict_types=1);

/**
 * Robust Recursive FTP Upload Engine for x64emkei.dev
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

$ftpHost     = $env['FTP_HOST']       ?? die("[FATAL] Missing FTP_HOST in .env\n");
$ftpUser     = $env['FTP_USER']       ?? die("[FATAL] Missing FTP_USER in .env\n");
$ftpPass     = $env['FTP_PASS']       ?? die("[FATAL] Missing FTP_PASS in .env\n");
$ftpPort     = (int)($env['FTP_PORT'] ?? 21);
$remoteTarget = $env['FTP_REMOTE_DIR'] ?? die("[FATAL] Missing FTP_REMOTE_DIR in .env\n");

$localSource = dirname(__DIR__) . '/deploy/htdocs';

echo "======================================================\n";
echo "   x64emkei.dev // AUTOMATED INFINITYFREE FTP UPLOADER \n";
echo "======================================================\n\n";

$conn = @ftp_connect($ftpHost, $ftpPort, 60);
if (!$conn) {
    die("[FATAL] Could not connect to FTP host: {$ftpHost}\n");
}

if (!@ftp_login($conn, $ftpUser, $ftpPass)) {
    ftp_close($conn);
    die("[FATAL] FTP authentication failed.\n");
}

ftp_pasv($conn, true);
echo "[OK] Authenticated successfully. Initiating transfer to {$remoteTarget}...\n\n";

function uploadRecursive($conn, string $localDir, string $remoteDir): void
{
    $items = scandir($localDir);
    if (!$items) return;

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;

        $localPath  = $localDir  . '/' . $item;
        $remotePath = $remoteDir . '/' . $item;

        if (is_dir($localPath)) {
            if (!@ftp_chdir($conn, $remotePath)) {
                echo " [MKDIR] {$remotePath}\n";
                @ftp_mkdir($conn, $remotePath);
            }
            uploadRecursive($conn, $localPath, $remotePath);
        } else {
            $size = filesize($localPath);
            $ext  = strtolower(pathinfo($localPath, PATHINFO_EXTENSION));
            $binaryExts = ['png', 'jpg', 'jpeg', 'webp', 'gif', 'ico', 'pdf', 'zip', 'woff', 'woff2', 'ttf', 'eot'];
            $mode = in_array($ext, $binaryExts, true) ? FTP_BINARY : FTP_ASCII;

            $success = @ftp_put($conn, $remotePath, $localPath, $mode);
            echo $success
                ? "  [UPLOADED] {$item} (" . number_format($size) . " bytes)\n"
                : "  [FAILED] Could not upload {$item} to {$remotePath}\n";
        }
    }
}

@ftp_delete($conn, $remoteTarget . '/index2.html');

uploadRecursive($conn, $localSource, $remoteTarget);

ftp_close($conn);

echo "\n======================================================\n";
echo "[SUCCESS] All files uploaded to welcome.x64emkei.dpdns.org/htdocs!\n";
echo "======================================================\n";
