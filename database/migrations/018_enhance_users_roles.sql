-- ==============================================================================
-- Migration: 018_enhance_users_roles.sql
-- Description: Ensure role permissions, status column, and roles compatibility
-- ==============================================================================

-- Alter users table safely if status or role definitions need adjustment
ALTER TABLE `users` 
    MODIFY COLUMN `role` ENUM('superadmin', 'admin', 'editor', 'author') NOT NULL DEFAULT 'admin';

-- Seed default journal category
INSERT IGNORE INTO `article_categories` (`id`, `name`, `slug`, `description`, `display_order`) VALUES 
(1, 'Systems Architecture', 'systems-architecture', 'Deep-dives into systems engineering, kernel architecture, and low-level development.', 1),
(2, 'Cybersecurity', 'cybersecurity', 'Security analysis, threat intelligence, and zero-trust engineering.', 2),
(3, 'Web & Cloud', 'web-and-cloud', 'High-performance web backends, microservices, and distributed architecture.', 3),
(4, 'Homelab & Hardware', 'homelab-and-hardware', 'Bare-metal virtualization, Proxmox VE, networking, and server maintenance.', 4);

-- Seed default journal tags
INSERT IGNORE INTO `article_tags` (`id`, `name`, `slug`) VALUES 
(1, 'PHP', 'php'),
(2, 'C# .NET', 'csharp-dotnet'),
(3, 'C++20', 'cpp20'),
(4, 'Linux', 'linux'),
(5, 'MySQL', 'mysql'),
(6, 'Security', 'security'),
(7, 'Zero-Trust', 'zero-trust'),
(8, 'Virtualization', 'virtualization');
