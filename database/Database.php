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

        $hostsToTry = [$config['host']];
        if (str_contains($config['host'], 'infinityfree.com')) {
            $hostsToTry[] = str_replace('infinityfree.com', 'epizy.com', $config['host']);
        } elseif (str_contains($config['host'], 'epizy.com')) {
            $hostsToTry[] = str_replace('epizy.com', 'infinityfree.com', $config['host']);
        }

        $lastException = null;
        foreach ($hostsToTry as $host) {
            try {
                if ($config['driver'] === 'sqlite') {
                    $dsn = 'sqlite:' . $config['sqlite_path'];
                    $pdo = new PDO($dsn, null, null, $config['options']);
                    $pdo->exec('PRAGMA foreign_keys = ON;');
                } else {
                    $dsn = sprintf(
                        'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                        $host,
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
                $lastException = $e;
                $logDir = dirname(__DIR__) . '/storage/logs';
                if (!is_dir($logDir)) {
                    @mkdir($logDir, 0755, true);
                }
                @file_put_contents(
                    $logDir . '/database.log',
                    sprintf("[%s] Host [%s] failed: %s\n", date('Y-m-d H:i:s'), $host, $e->getMessage()),
                    FILE_APPEND
                );
            }
        }

        throw new RuntimeException('Database connection failed. Please verify database service status and credentials.');
    }

    public static function setConnection(?PDO $pdo): void
    {
        self::$instance = $pdo;
    }
}
