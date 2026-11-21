-- 015_create_portfolio_sections_table.sql
CREATE TABLE IF NOT EXISTS `portfolio_sections` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
