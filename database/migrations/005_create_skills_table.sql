CREATE TABLE IF NOT EXISTS `skills` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `category` VARCHAR(50) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `proficiency_level` INT NOT NULL DEFAULT 85,
    `icon_svg` TEXT NULL,
    `display_order` INT NOT NULL DEFAULT 0,
    `is_published` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_category` (`category`),
    INDEX `idx_display_order` (`display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
