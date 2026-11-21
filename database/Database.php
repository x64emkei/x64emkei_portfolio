<?php
declare(strict_types=1);

namespace Database;

use PDO;
use PDOException;
use RuntimeException;

final class Database
{
    private static ?PDO $instance = null;

    private function __construct() {}

    public static function getConnection(array $overrideConfig = []): PDO
    {
        if (self::$instance !== null && empty($overrideConfig)) {
            return self::$instance;
        }

        $config = require dirname(__DIR__) . '/config/database.php';
        if (!empty($overrideConfig)) {
            $config = array_merge($config, $overrideConfig);
        }

        try {
            if ($config['driver'] === 'sqlite') {
                $dsn = 'sqlite:' . $config['sqlite_path'];
                $pdo = new PDO($dsn, null, null, $config['options']);
                $pdo->exec('PRAGMA foreign_keys = ON;');
            } else {
                $dsn = sprintf(
                    'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                    $config['host'],
                    $config['port'],
                    $config['database'],
                    $config['charset']
                );
                $pdo = new PDO($dsn, $config['username'], $config['password'], $config['options']);
            }

            if (empty($overrideConfig)) {
                self::$instance = $pdo;
            }
            return $pdo;
        } catch (PDOException $e) {
            // Log real error privately without leaking credentials in web output
            $logDir = dirname(__DIR__) . '/storage/logs';
            if (!is_dir($logDir)) {
                @mkdir($logDir, 0755, true);
            }
            @file_put_contents(
                $logDir . '/database.log',
                '[' . date('Y-m-d H:i:s') . '] Connection failure: ' . $e->getMessage() . PHP_EOL,
                FILE_APPEND
            );
            throw new RuntimeException('Database connection failed. Please verify database service status and credentials.');
        }
    }

    public static function setConnection(?PDO $pdo): void
    {
        self::$instance = $pdo;
    }
}
