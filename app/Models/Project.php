<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

class Project extends BaseModel
{
    protected static string $table = 'projects';

    public static function getPublished(string $filter = 'all'): array
    {
        $sql = "SELECT * FROM `projects` WHERE `is_published` = 1";
        $params = [];

        if ($filter !== 'all') {
            $sql .= " AND `filter_tag` = :filter";
            $params[':filter'] = $filter;
        }

        $sql .= " ORDER BY `display_order` ASC, `id` ASC";
        $stmt = static::db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function findBySlug(string $slug): ?array
    {
        $stmt = static::db()->prepare("SELECT * FROM `projects` WHERE `slug` = :slug LIMIT 1");
        $stmt->execute([':slug' => $slug]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(array $data): int
    {
        $sql = "INSERT INTO `projects`
            (`slug`, `code_id`, `category`, `filter_tag`, `title`, `tagline`, `environment`, `performance_metric`,
             `operational_status`, `description`, `features_json`, `code_filename`, `code_snippet`,
             `technologies_json`, `github_url`, `demo_url`, `featured_image`, `display_order`, `is_featured`, `is_published`)
            VALUES
            (:slug, :code_id, :category, :filter_tag, :title, :tagline, :environment, :performance_metric,
             :operational_status, :description, :features_json, :code_filename, :code_snippet,
             :technologies_json, :github_url, :demo_url, :featured_image, :display_order, :is_featured, :is_published)";

        $stmt = static::db()->prepare($sql);
        $stmt->execute([
            ':slug' => $data['slug'],
            ':code_id' => $data['code_id'],
            ':category' => $data['category'],
            ':filter_tag' => $data['filter_tag'],
            ':title' => $data['title'],
            ':tagline' => $data['tagline'],
            ':environment' => $data['environment'] ?? '',
            ':performance_metric' => $data['performance_metric'] ?? '',
            ':operational_status' => $data['operational_status'] ?? 'Operational',
            ':description' => $data['description'],
            ':features_json' => is_array($data['features_json'] ?? null) ? json_encode($data['features_json']) : ($data['features_json'] ?? '[]'),
            ':code_filename' => $data['code_filename'] ?? '',
            ':code_snippet' => $data['code_snippet'] ?? '',
            ':technologies_json' => is_array($data['technologies_json'] ?? null) ? json_encode($data['technologies_json']) : ($data['technologies_json'] ?? '[]'),
            ':github_url' => $data['github_url'] ?? '',
            ':demo_url' => $data['demo_url'] ?? '',
            ':featured_image' => $data['featured_image'] ?? '',
            ':display_order' => (int)($data['display_order'] ?? 0),
            ':is_featured' => (int)($data['is_featured'] ?? 0),
            ':is_published' => (int)($data['is_published'] ?? 1),
        ]);

        return (int)static::db()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $sql = "UPDATE `projects` SET
            `slug` = :slug,
            `code_id` = :code_id,
            `category` = :category,
            `filter_tag` = :filter_tag,
            `title` = :title,
            `tagline` = :tagline,
            `environment` = :environment,
            `performance_metric` = :performance_metric,
            `operational_status` = :operational_status,
            `description` = :description,
            `features_json` = :features_json,
            `code_filename` = :code_filename,
            `code_snippet` = :code_snippet,
            `technologies_json` = :technologies_json,
            `github_url` = :github_url,
            `demo_url` = :demo_url,
            `featured_image` = :featured_image,
            `display_order` = :display_order,
            `is_featured` = :is_featured,
            `is_published` = :is_published
            WHERE `id` = :id";

        $stmt = static::db()->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':slug' => $data['slug'],
            ':code_id' => $data['code_id'],
            ':category' => $data['category'],
            ':filter_tag' => $data['filter_tag'],
            ':title' => $data['title'],
            ':tagline' => $data['tagline'],
            ':environment' => $data['environment'] ?? '',
            ':performance_metric' => $data['performance_metric'] ?? '',
            ':operational_status' => $data['operational_status'] ?? 'Operational',
            ':description' => $data['description'],
            ':features_json' => is_array($data['features_json'] ?? null) ? json_encode($data['features_json']) : ($data['features_json'] ?? '[]'),
            ':code_filename' => $data['code_filename'] ?? '',
            ':code_snippet' => $data['code_snippet'] ?? '',
            ':technologies_json' => is_array($data['technologies_json'] ?? null) ? json_encode($data['technologies_json']) : ($data['technologies_json'] ?? '[]'),
            ':github_url' => $data['github_url'] ?? '',
            ':demo_url' => $data['demo_url'] ?? '',
            ':featured_image' => $data['featured_image'] ?? '',
            ':display_order' => (int)($data['display_order'] ?? 0),
            ':is_featured' => (int)($data['is_featured'] ?? 0),
            ':is_published' => (int)($data['is_published'] ?? 1),
        ]);
    }
}
