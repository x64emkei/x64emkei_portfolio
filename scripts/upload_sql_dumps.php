<?php
declare(strict_types=1);

/**
 * Upload SQL schema and seed files to production via FTP.
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

$host      = $env['FTP_HOST']       ?? die("[FATAL] Missing FTP_HOST in .env\n");
$user      = $env['FTP_USER']       ?? die("[FATAL] Missing FTP_USER in .env\n");
$pass      = $env['FTP_PASS']       ?? die("[FATAL] Missing FTP_PASS in .env\n");
$port      = (int)($env['FTP_PORT'] ?? 21);
$remoteDir = $env['FTP_REMOTE_DIR'] ?? die("[FATAL] Missing FTP_REMOTE_DIR in .env\n");

// ---------------------------------------------------------------------------
// Connect
// ---------------------------------------------------------------------------
$conn = ftp_connect($host, $port, 30);
if (!$conn || !ftp_login($conn, $user, $pass)) {
    die("FTP connection failed.\n");
}
ftp_pasv($conn, true);

$base = dirname(__DIR__);
ftp_put($conn, $remoteDir . '/database/schema.sql', $base . '/database/schema.sql', FTP_BINARY);
ftp_put($conn, $remoteDir . '/database/seed.sql',   $base . '/database/seed.sql',   FTP_BINARY);

echo "[SUCCESS] Both schema.sql and seed.sql uploaded with pure UTF-8 encoding!\n";

ftp_close($conn);
