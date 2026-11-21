CREATE TABLE IF NOT EXISTS `education` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `institution` VARCHAR(150) NOT NULL,
    `degree` VARCHAR(150) NOT NULL,
    `field_of_study` VARCHAR(150) NULL,
    `period_start` VARCHAR(50) NOT NULL,
    `period_end` VARCHAR(50) NULL,
    `achievements` TEXT NULL,
    `display_order` INT NOT NULL DEFAULT 0,
    `is_published` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_is_published` (`is_published`),
    INDEX `idx_display_order` (`display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
