<?php
declare(strict_types=1);

namespace App\Services;

class RateLimiter
{
    private string $storageDir;

    public function __construct(?string $storageDir = null)
    {
        $this->storageDir = $storageDir ?: dirname(__DIR__, 2) . '/storage/cache';
        if (!is_dir($this->storageDir)) {
            @mkdir($this->storageDir, 0755, true);
        }
    }

    private function getCacheFile(string $key): string
    {
        $safeKey = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $key);
        return $this->storageDir . '/rate_' . md5($safeKey) . '.json';
    }

    public function tooManyAttempts(string $key, int $maxAttempts, int $decaySeconds): bool
    {
        $file = $this->getCacheFile($key);
        if (!file_exists($file)) {
            return false;
        }

        $data = json_decode((string)file_get_contents($file), true);
        if (!is_array($data) || !isset($data['attempts'], $data['reset_at'])) {
            return false;
        }

        if (time() > $data['reset_at']) {
            @unlink($file);
            return false;
        }

        return $data['attempts'] >= $maxAttempts;
    }

    public function hit(string $key, int $decaySeconds): int
    {
        $file = $this->getCacheFile($key);
        $data = ['attempts' => 0, 'reset_at' => time() + $decaySeconds];

        if (file_exists($file)) {
            $existing = json_decode((string)file_get_contents($file), true);
            if (is_array($existing) && isset($existing['reset_at']) && time() <= $existing['reset_at']) {
                $data = $existing;
            }
        }

        $data['attempts']++;
        file_put_contents($file, json_encode($data), LOCK_EX);

        return $data['attempts'];
    }

    public function clear(string $key): void
    {
        $file = $this->getCacheFile($key);
        if (file_exists($file)) {
            @unlink($file);
        }
    }

    public function availableIn(string $key): int
    {
        $file = $this->getCacheFile($key);
        if (!file_exists($file)) {
            return 0;
        }

        $data = json_decode((string)file_get_contents($file), true);
        if (!is_array($data) || !isset($data['reset_at'])) {
            return 0;
        }

        return max(0, $data['reset_at'] - time());
    }
}
