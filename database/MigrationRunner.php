<?php
declare(strict_types=1);

namespace Database;

use PDO;
use Exception;

class MigrationRunner
{
    private PDO $pdo;
    private string $migrationsDir;

    public function __construct(PDO $pdo, ?string $migrationsDir = null)
    {
        $this->pdo = $pdo;
        $this->migrationsDir = $migrationsDir ?: __DIR__ . '/migrations';
        $this->ensureMigrationsTable();
    }

    private function ensureMigrationsTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS `migrations` (
            `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `migration` VARCHAR(255) NOT NULL UNIQUE,
            `batch` INT NOT NULL,
            `executed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        $this->pdo->exec($sql);
    }

    public function getExecutedMigrations(): array
    {
        $stmt = $this->pdo->query("SELECT `migration` FROM `migrations` ORDER BY `id` ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN) ?: [];
    }

    public function getNextBatchNumber(): int
    {
        $stmt = $this->pdo->query("SELECT MAX(`batch`) as max_batch FROM `migrations`");
        $res = $stmt->fetch();
        return ($res && $res['max_batch']) ? (int)$res['max_batch'] + 1 : 1;
    }

    public function run(): array
    {
        $executed = $this->getExecutedMigrations();
        $files = glob($this->migrationsDir . '/*.sql');
        sort($files);

        $toRun = [];
        foreach ($files as $file) {
            $base = basename($file);
            if (!in_array($base, $executed, true)) {
                $toRun[] = $file;
            }
        }

        if (empty($toRun)) {
            return ['status' => 'clean', 'applied' => []];
        }

        $batch = $this->getNextBatchNumber();
        $applied = [];

        foreach ($toRun as $filePath) {
            $base = basename($filePath);
            $sql = file_get_contents($filePath);
            if ($sql === false) {
                throw new Exception("Unable to read migration file: {$base}");
            }

            // Execute SQL script
            try {
                $this->pdo->exec($sql);
                $stmt = $this->pdo->prepare("INSERT INTO `migrations` (`migration`, `batch`) VALUES (:m, :b)");
                $stmt->execute([':m' => $base, ':b' => $batch]);
                $applied[] = $base;
            } catch (Exception $e) {
                throw new Exception("Migration {$base} failed: " . $e->getMessage(), (int)$e->getCode(), $e);
            }
        }

        return ['status' => 'applied', 'applied' => $applied, 'batch' => $batch];
    }
}
