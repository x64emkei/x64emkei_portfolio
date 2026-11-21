-- 016_create_achievements_table.sql
CREATE TABLE IF NOT EXISTS `achievements` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `issuer` VARCHAR(255) NULL,
  `description` TEXT NULL,
  `award_date` VARCHAR(50) NULL,
  `category` VARCHAR(100) NULL,
  `image_url` VARCHAR(500) NULL,
  `document_url` VARCHAR(500) NULL,
  `verification_url` VARCHAR(500) NULL,
  `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
  `display_order` INT NOT NULL DEFAULT 0,
  `is_published` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_achieve_published` (`is_published`),
  INDEX `idx_achieve_order` (`display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
