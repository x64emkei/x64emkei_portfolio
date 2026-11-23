<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

class PortfolioSection extends BaseModel
{
    protected static string $table = 'portfolio_sections';

    private static function defaultSections(): array
    {
        return [
            ['id' => 1, 'section_key' => 'hero', 'title' => 'OPERATIONAL ARCHITECTURE', 'subtitle' => 'SYSTEMS SCHOLAR // HARDWARE SPECIALIST', 'intro_text' => 'High-performance computing student, systems architect, and IT enthusiast.', 'is_enabled' => 1, 'display_order' => 1, 'layout_variation' => 'default', 'hide_if_empty' => 0],
            ['id' => 2, 'section_key' => 'about', 'title' => 'BIOGRAPHY // CORE DIRECTIVE', 'subtitle' => 'IDENTITY & SCHOLASTIC DISCIPLINE', 'intro_text' => 'Computer Science student and systems engineer exploring low-level hardware and resilient platforms.', 'is_enabled' => 1, 'display_order' => 2, 'layout_variation' => 'default', 'hide_if_empty' => 0],
            ['id' => 3, 'section_key' => 'projects', 'title' => 'FEATURED PRODUCTION ARCHITECTURES', 'subtitle' => 'DEPLOYED PLATFORMS & SOFTWARE CODEBASES', 'intro_text' => 'Engineered desktop engines, embedded terminal POS systems, neural networks, and distributed services.', 'is_enabled' => 1, 'display_order' => 3, 'layout_variation' => 'cards', 'hide_if_empty' => 1],
            ['id' => 4, 'section_key' => 'hardware', 'title' => 'HARDWARE LAB ARCHIVE & FLEET INFRASTRUCTURE', 'subtitle' => 'LAB FLEET TELEMETRY & RETRO HARDWARE REPOSITORY', 'intro_text' => 'High-performance compute clusters, bare-metal hypervisors, and vintage x86 compute artifacts.', 'is_enabled' => 1, 'display_order' => 4, 'layout_variation' => 'cards', 'hide_if_empty' => 1],
            ['id' => 5, 'section_key' => 'skills', 'title' => 'TECHNICAL PROFICIENCIES & CAPABILITIES', 'subtitle' => 'ENGINEERING MATRIX // PROFICIENCY CATALOG', 'intro_text' => 'Grouped multi-disciplinary technical competencies from systems programming to cloud architectures.', 'is_enabled' => 1, 'display_order' => 5, 'layout_variation' => 'default', 'hide_if_empty' => 1],
            ['id' => 6, 'section_key' => 'experience', 'title' => 'ORGANIZATIONAL EXPERIENCE & LEADERSHIP', 'subtitle' => 'CHRONOLOGY & RESPONSIBILITIES', 'intro_text' => 'Track record of student leadership, technical committee stewardship, and academic operations.', 'is_enabled' => 1, 'display_order' => 6, 'layout_variation' => 'timeline', 'hide_if_empty' => 1],
            ['id' => 7, 'section_key' => 'education', 'title' => 'ACADEMIC FOUNDATION', 'subtitle' => 'DEGREES & SCHOLASTIC FORMATION', 'intro_text' => 'Higher education history and formal Computer Science undergraduate curriculum.', 'is_enabled' => 1, 'display_order' => 7, 'layout_variation' => 'cards', 'hide_if_empty' => 1],
            ['id' => 8, 'section_key' => 'achievements', 'title' => 'HONORS & RECOGNITIONS', 'subtitle' => 'ACADEMIC & INDUSTRY DISTINCTIONS', 'intro_text' => 'Academic distinctions, hackathon recognitions, and professional commendations.', 'is_enabled' => 1, 'display_order' => 8, 'layout_variation' => 'cards', 'hide_if_empty' => 1],
            ['id' => 9, 'section_key' => 'certifications', 'title' => 'CERTIFICATIONS & CREDENTIALS', 'subtitle' => 'VERIFIED SPECIALIZATIONS', 'intro_text' => 'Industry credentials and vendor qualifications.', 'is_enabled' => 1, 'display_order' => 9, 'layout_variation' => 'cards', 'hide_if_empty' => 1],
            ['id' => 10, 'section_key' => 'services', 'title' => 'SPECIALIZED ENGINEERING OFFERINGS', 'subtitle' => 'CAPABILITIES & ADVISORY', 'intro_text' => 'Custom application engineering, systems optimization, and network topology consulting.', 'is_enabled' => 1, 'display_order' => 10, 'layout_variation' => 'cards', 'hide_if_empty' => 1],
            ['id' => 11, 'section_key' => 'contact', 'title' => 'INITIALIZE SECURE TRANSMISSION', 'subtitle' => 'TELEMETRY UPLINK & DIRECT DISPATCH', 'intro_text' => 'Connect directly via encrypted transmission or explore active communication channels.', 'is_enabled' => 1, 'display_order' => 11, 'layout_variation' => 'default', 'hide_if_empty' => 0],
        ];
    }

    public static function autoMigrateIfMissing(): void
    {
        try {
            $pdo = static::db();
            $sql = "CREATE TABLE IF NOT EXISTS `portfolio_sections` (
              `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              `section_key` VARCHAR(50) NOT NULL UNIQUE,
              `title` VARCHAR(100) NOT NULL,
              `subtitle` VARCHAR(255) NULL,
              `intro_text` TEXT NULL,
              `is_enabled` TINYINT(1) NOT NULL DEFAULT 1,
              `display_order` INT NOT NULL DEFAULT 0,
              `layout_variation` VARCHAR(50) NOT NULL DEFAULT 'default',
              `hide_if_empty` TINYINT(1) NOT NULL DEFAULT 1,
              `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              INDEX `idx_section_order` (`display_order`),
              INDEX `idx_section_enabled` (`is_enabled`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
            $pdo->exec($sql);

            $check = (int)$pdo->query("SELECT COUNT(*) FROM `portfolio_sections`")->fetchColumn();
            if ($check === 0) {
                $ins = $pdo->prepare("INSERT INTO `portfolio_sections` 
                    (`section_key`, `title`, `subtitle`, `intro_text`, `is_enabled`, `display_order`, `layout_variation`, `hide_if_empty`)
                    VALUES (:k, :t, :s, :i, :e, :o, :l, :h)");
                foreach (static::defaultSections() as $sec) {
                    $ins->execute([
                        ':k' => $sec['section_key'],
                        ':t' => $sec['title'],
                        ':s' => $sec['subtitle'],
                        ':i' => $sec['intro_text'],
                        ':e' => $sec['is_enabled'],
                        ':o' => $sec['display_order'],
                        ':l' => $sec['layout_variation'],
                        ':h' => $sec['hide_if_empty'],
                    ]);
                }
            }
        } catch (\Throwable $e) {
            // Silent fallback; will serve defaults
        }
    }

    public static function allOrdered(): array
    {
        try {
            $stmt = static::db()->query(
                "SELECT * FROM `portfolio_sections` ORDER BY `display_order` ASC, `id` ASC"
            );
            $results = $stmt->fetchAll();
            if (empty($results)) {
                static::autoMigrateIfMissing();
                $stmt = static::db()->query("SELECT * FROM `portfolio_sections` ORDER BY `display_order` ASC, `id` ASC");
                $results = $stmt ? $stmt->fetchAll() : [];
            }
            return !empty($results) ? $results : static::defaultSections();
        } catch (\Throwable $e) {
            static::autoMigrateIfMissing();
            try {
                $stmt = static::db()->query("SELECT * FROM `portfolio_sections` ORDER BY `display_order` ASC, `id` ASC");
                return $stmt ? $stmt->fetchAll() : static::defaultSections();
            } catch (\Throwable $e2) {
                return static::defaultSections();
            }
        }
    }

    public static function allKeyed(): array
    {
        $rows = static::allOrdered();
        $keyed = [];
        foreach ($rows as $row) {
            $keyed[$row['section_key']] = $row;
        }
        return $keyed;
    }

    public static function findByKey(string $key): ?array
    {
        try {
            $stmt = static::db()->prepare("SELECT * FROM `portfolio_sections` WHERE `section_key` = :key LIMIT 1");
            $stmt->execute([':key' => $key]);
            $row = $stmt->fetch();
            if ($row) return $row;
        } catch (\Throwable $e) {
            static::autoMigrateIfMissing();
        }

        foreach (static::defaultSections() as $sec) {
            if ($sec['section_key'] === $key) return $sec;
        }
        return null;
    }

    public static function isEnabled(string $key): bool
    {
        $section = static::findByKey($key);
        if (!$section) {
            return true;
        }
        return (bool)$section['is_enabled'];
    }

    public static function updateSection(string $key, array $data): bool
    {
        static::autoMigrateIfMissing();
        $sql = "UPDATE `portfolio_sections` SET
            `title` = :title,
            `subtitle` = :subtitle,
            `intro_text` = :intro_text,
            `is_enabled` = :is_enabled,
            `display_order` = :display_order,
            `layout_variation` = :layout_variation,
            `hide_if_empty` = :hide_if_empty
            WHERE `section_key` = :key";
        $stmt = static::db()->prepare($sql);
        return $stmt->execute([
            ':key' => $key,
            ':title' => $data['title'] ?? '',
            ':subtitle' => $data['subtitle'] ?? '',
            ':intro_text' => $data['intro_text'] ?? '',
            ':is_enabled' => (int)($data['is_enabled'] ?? 1),
            ':display_order' => (int)($data['display_order'] ?? 0),
            ':layout_variation' => $data['layout_variation'] ?? 'default',
            ':hide_if_empty' => (int)($data['hide_if_empty'] ?? 1),
        ]);
    }
}
