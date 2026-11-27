<?php
declare(strict_types=1);

namespace App\Models;

use Database\Database;
use PDO;

abstract class BaseModel
{
    protected static string $table = '';

    protected static function db(): PDO
    {
        return Database::getConnection();
    }

    protected static function validateIdentifier(string $identifier): string
    {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $identifier)) {
            throw new \InvalidArgumentException('Invalid SQL identifier.');
        }
        return $identifier;
    }

    public static function all(string $orderBy = 'id ASC'): array
    {
        $table = static::validateIdentifier(static::$table);
        if (!preg_match('/^[a-zA-Z0-9_`]+(\s+(ASC|DESC))?(\s*,\s*[a-zA-Z0-9_`]+(\s+(ASC|DESC))?)*$/i', trim($orderBy))) {
            throw new \InvalidArgumentException('Invalid ORDER BY clause.');
        }
        $sql = "SELECT * FROM `{$table}` ORDER BY {$orderBy}";
        return static::db()->query($sql)->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $table = static::validateIdentifier(static::$table);
        $stmt = static::db()->prepare("SELECT * FROM `{$table}` WHERE `id` = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function update(int $id, array $data): bool
    {
        if (empty($data)) {
            return false;
        }
        $table = static::validateIdentifier(static::$table);
        $setParts = [];
        $params = [':id' => $id];
        foreach ($data as $column => $value) {
            $col = static::validateIdentifier((string)$column);
            $paramKey = ':u_' . $col;
            $setParts[] = "`{$col}` = {$paramKey}";
            $params[$paramKey] = $value;
        }
        $sql = "UPDATE `{$table}` SET " . implode(', ', $setParts) . " WHERE `id` = :id";
        $stmt = static::db()->prepare($sql);
        return $stmt->execute($params);
    }

    public static function count(string $where = '', array $params = []): int
    {
        $table = static::validateIdentifier(static::$table);
        $sql = "SELECT COUNT(*) FROM `{$table}`";
        if ($where !== '') {
            $sql .= " WHERE {$where}";
        }
        $stmt = static::db()->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    public static function delete(int $id): bool
    {
        $table = static::validateIdentifier(static::$table);
        $stmt = static::db()->prepare("DELETE FROM `{$table}` WHERE `id` = :id");
        return $stmt->execute([':id' => $id]);
    }
}
