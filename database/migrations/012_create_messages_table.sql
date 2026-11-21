CREATE TABLE IF NOT EXISTS `messages` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `sender_name` VARCHAR(100) NOT NULL,
    `sender_email` VARCHAR(150) NOT NULL,
    `subject` VARCHAR(200) NOT NULL,
    `message_body` TEXT NOT NULL,
    `sender_ip` VARCHAR(45) NULL,
    `user_agent` VARCHAR(255) NULL,
    `is_read` TINYINT(1) NOT NULL DEFAULT 0,
    `is_archived` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_is_read` (`is_read`),
    INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
