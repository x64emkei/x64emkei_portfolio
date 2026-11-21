CREATE TABLE IF NOT EXISTS `profile` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `full_name` VARCHAR(100) NOT NULL,
    `title` VARCHAR(150) NOT NULL,
    `tagline` VARCHAR(255) NULL,
    `bio_short` TEXT NULL,
    `bio_full` MEDIUMTEXT NULL,
    `avatar_url` VARCHAR(255) NULL,
    `cover_url` VARCHAR(255) NULL,
    `location` VARCHAR(100) NULL,
    `availability_status` VARCHAR(100) DEFAULT 'Available for Systems & Web Engineering',
    `resume_url` VARCHAR(255) NULL,
    `email` VARCHAR(150) NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
