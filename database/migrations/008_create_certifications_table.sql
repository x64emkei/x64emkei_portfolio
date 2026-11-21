CREATE TABLE IF NOT EXISTS `certifications` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(150) NOT NULL,
    `issuer` VARCHAR(150) NOT NULL,
    `issue_date` VARCHAR(50) NULL,
    `credential_id` VARCHAR(100) NULL,
    `credential_url` VARCHAR(255) NULL,
    `display_order` INT NOT NULL DEFAULT 0,
    `is_published` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_is_published` (`is_published`),
    INDEX `idx_display_order` (`display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
