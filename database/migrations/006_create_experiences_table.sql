CREATE TABLE IF NOT EXISTS `experiences` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(150) NOT NULL,
    `organization` VARCHAR(150) NOT NULL,
    `location` VARCHAR(100) NULL,
    `type` VARCHAR(50) NOT NULL DEFAULT 'Professional',
    `period_start` VARCHAR(50) NOT NULL,
    `period_end` VARCHAR(50) NULL,
    `is_current` TINYINT(1) NOT NULL DEFAULT 0,
    `description` TEXT NULL,
    `responsibilities_json` TEXT NULL,
    `display_order` INT NOT NULL DEFAULT 0,
    `is_published` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_is_published` (`is_published`),
    INDEX `idx_display_order` (`display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
