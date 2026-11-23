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
            ['id' => 11, 'section_key' => 'laboratory', 'title' => 'TECHNICAL LABORATORY & EXPERIMENTATION', 'subtitle' => 'ACTIVE RESEARCH TRACKS & VIRTUALIZATION NODES', 'intro_text' => 'Hands-on experimentation with bare-metal hypervisors, encrypted mesh networks, and legacy operating systems.', 'is_enabled' => 1, 'display_order' => 11, 'layout_variation' => 'cards', 'hide_if_empty' => 0],
            ['id' => 12, 'section_key' => 'journal', 'title' => 'ENGINEERING JOURNAL & PUBLICATIONS', 'subtitle' => 'TRANSMISSION ARCHIVES & ARCHITECTURAL ESSAYS', 'intro_text' => 'Technical documentation, systems engineering guides, zero-trust protocols, and architectural positions.', 'is_enabled' => 1, 'display_order' => 12, 'layout_variation' => 'stream', 'hide_if_empty' => 0],
            ['id' => 13, 'section_key' => 'tutorials', 'title' => 'TUTORIALS & IMPLEMENTATION GUIDES', 'subtitle' => 'PRACTICAL ENGINEERING WALKTHROUGHS', 'intro_text' => 'Step-by-step guides for zero-trust clusters, PHP 8 security architectures, and Linux system management.', 'is_enabled' => 1, 'display_order' => 13, 'layout_variation' => 'cards', 'hide_if_empty' => 0],
            ['id' => 14, 'section_key' => 'technical-notes', 'title' => 'TECHNICAL NOTES & SYSTEM DIAGNOSTICS', 'subtitle' => 'LAB NOTEBOOK & FIELD DIAGNOSTICS', 'intro_text' => 'Thermal profiling, CORS/CSP policy hardening, low-level memory debugging, and runtime telemetry.', 'is_enabled' => 1, 'display_order' => 14, 'layout_variation' => 'list', 'hide_if_empty' => 0],
            ['id' => 15, 'section_key' => 'research', 'title' => 'RESEARCH & ARCHITECTURAL INSIGHTS', 'subtitle' => 'INVESTIGATION & HARDWARE LONGEVITY', 'intro_text' => 'Hardware longevity, circular technology, and digital preservation in modern computing.', 'is_enabled' => 1, 'display_order' => 15, 'layout_variation' => 'cards', 'hide_if_empty' => 0],
            ['id' => 16, 'section_key' => 'ai-manifesto', 'title' => 'MY AI MANIFESTO', 'subtitle' => 'A PERSONAL POSITION ON AI, HUMAN SKILL, AND RESPONSIBLE PROGRESS', 'intro_text' => 'Principles guiding learning, craft, professional development, accountability, and Filipino opportunity.', 'is_enabled' => 1, 'display_order' => 16, 'layout_variation' => 'callout', 'hide_if_empty' => 0],
            ['id' => 17, 'section_key' => 'contact', 'title' => 'CONTACT & TECHNICAL CONSULTATION', 'subtitle' => 'SECURE TELEMETRY CHANNEL & DIRECT DISPATCH', 'intro_text' => 'Direct inquiry channels for systems engineering, software consultation, homelab architecture, or collaborative initiatives.', 'is_enabled' => 1, 'display_order' => 17, 'layout_variation' => 'default', 'hide_if_empty' => 0],
            ['id' => 18, 'section_key' => 'information', 'title' => 'CONTACT INFORMATION & DIRECT CHANNELS', 'subtitle' => 'OPERATOR TELEMETRY & AVAILABILITY', 'intro_text' => 'Verified operator email, timezone, and operational availability status.', 'is_enabled' => 1, 'display_order' => 18, 'layout_variation' => 'cards', 'hide_if_empty' => 0],
            ['id' => 19, 'section_key' => 'inquiry', 'title' => 'SEND AN INQUIRY', 'subtitle' => 'SECURE TRANSMISSION DISPATCH FORM', 'intro_text' => 'Submit inquiries regarding systems architecture, software consulting, or project collaborations.', 'is_enabled' => 1, 'display_order' => 19, 'layout_variation' => 'form', 'hide_if_empty' => 0],
            ['id' => 20, 'section_key' => 'social', 'title' => 'VERIFIED SOCIAL TELEMETRY & NETWORKS', 'subtitle' => 'PUBLIC REPOSITORIES & PROFESSIONAL PROFILES', 'intro_text' => 'Direct connections through GitHub, LinkedIn, and professional engineering associations.', 'is_enabled' => 1, 'display_order' => 20, 'layout_variation' => 'cards', 'hide_if_empty' => 0],
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
