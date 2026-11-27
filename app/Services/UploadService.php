<?php
declare(strict_types=1);

namespace App\Services;

use Exception;

class UploadService
{
    private string $uploadDir;
    private int $maxSize;
    private array $allowedMimes;

    public function __construct(?string $uploadDir = null, ?int $maxSize = null, ?array $allowedMimes = null)
    {
        $config = require dirname(__DIR__, 2) . '/config/app.php';
        $this->uploadDir = $uploadDir ?: ($config['uploads_path'] ?? dirname(__DIR__, 2) . '/storage/uploads');
        $this->maxSize = $maxSize ?: ($config['max_upload_size'] ?? 8388608); // 8MB
        $this->allowedMimes = $allowedMimes ?: ($config['allowed_image_mimes'] ?? [
            'image/jpeg',
            'image/png',
            'image/webp',
            'image/gif',
            'image/svg+xml'
        ]);

        $this->ensureUploadDirectory();
    }

    private function ensureUploadDirectory(): void
    {
        if (!is_dir($this->uploadDir)) {
            @mkdir($this->uploadDir, 0755, true);
        }

        // Write security .htaccess to prevent execution of PHP files in upload directory
        $htaccess = $this->uploadDir . '/.htaccess';
        if (!file_exists($htaccess)) {
            $rules = "# Prevent script execution in uploads directory\n" .
                     "<FilesMatch \"\\.(php|phtml|php3|php4|php5|php7|php8|phps|cgi|pl|sh|py)$\">\n" .
                     "    Require all denied\n" .
                     "    Deny from all\n" .
                     "</FilesMatch>\n" .
                     "Options -Indexes -ExecCGI\n";
            @file_put_contents($htaccess, $rules);
        }
    }

    public function handleImageUpload(array $file): array
    {
        if (!isset($file['error']) || is_array($file['error'])) {
            throw new Exception('Invalid upload parameters.');
        }

        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new Exception('Uploaded file exceeds maximum allowable size.');
            case UPLOAD_ERR_NO_FILE:
                throw new Exception('No file was uploaded.');
            default:
                throw new Exception('An error occurred during file upload.');
        }

        if ($file['size'] > $this->maxSize) {
            throw new Exception('File size exceeds the limit of ' . ($this->maxSize / 1048576) . ' MB.');
        }

        // Validate MIME type strictly via finfo
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $realMime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($realMime, $this->allowedMimes, true)) {
            throw new Exception('Forbidden file type. Only JPEG, PNG, WebP, GIF, and SVG images are permitted.');
        }

        // Map MIME to extension
        $extensions = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif',
            'image/svg+xml' => 'svg',
        ];
        $ext = $extensions[$realMime] ?? 'bin';

        // Additional sanity check for SVG (ensure no embedded scripts, foreignObject, or event handlers)
        if ($ext === 'svg') {
            $svgContent = file_get_contents($file['tmp_name']);
            if ($svgContent !== false && preg_match('/<script|<foreignObject|\bon[a-z]+\s*=|javascript:|data:text\/html|data:image\/svg\+xml/i', $svgContent)) {
                throw new Exception('Malicious SVG payload detected. Script execution is prohibited.');
            }
        }

        // Generate cryptographically random filename
        $safeName = 'media_' . date('Ymd_His') . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
        $destination = $this->uploadDir . '/' . $safeName;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new Exception('Failed to persist uploaded media to destination.');
        }

        @chmod($destination, 0644);

        return [
            'filename' => $safeName,
            'original_name' => basename($file['name']),
            'mime_type' => $realMime,
            'file_size' => $file['size'],
            'file_path' => 'storage/uploads/' . $safeName,
            'full_path' => $destination,
        ];
    }

    public function deleteFile(string $filename): bool
    {
        $clean = basename($filename);
        $path = $this->uploadDir . '/' . $clean;
        if (file_exists($path)) {
            return @unlink($path);
        }
        return false;
    }
}
