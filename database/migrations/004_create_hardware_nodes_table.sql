CREATE TABLE IF NOT EXISTS `hardware_nodes` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `node_id` VARCHAR(50) NOT NULL,
    `tag` VARCHAR(50) DEFAULT 'PRESERVED',
    `title` VARCHAR(150) NOT NULL,
    `subtitle` VARCHAR(255) NOT NULL,
    `oem` VARCHAR(100) NOT NULL,
    `specs_json` TEXT NOT NULL,
    `diagnostics_log` TEXT NOT NULL,
    `image_url` VARCHAR(255) NULL,
    `display_order` INT NOT NULL DEFAULT 0,
    `is_published` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_is_published` (`is_published`),
    INDEX `idx_display_order` (`display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
