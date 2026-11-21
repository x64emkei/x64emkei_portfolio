# Database Schema, Migrations & Backup // x64emkei.dev

This document provides architectural documentation of the MySQL / MariaDB database schema powering **x64emkei.dev**.

---

## 1. Relational Schema Architecture

The database consists of 15 structured tables designed for performance, integrity, and future migration to VPS or cloud infrastructure:

| Table | Purpose | Primary Keys / Indexes |
| :--- | :--- | :--- |
| `migrations` | Tracks executed schema migration files & batch numbers | `id`, `migration` (UNIQUE) |
| `users` | Administrator accounts, password hashes, and lockout counters | `id`, `username` (UNIQUE), `email` (UNIQUE) |
| `profile` | Professional identity, biography, photo URLs, and availability | `id` |
| `projects` | 16 systems projects with tags, benchmarks, code samples & metrics | `id`, `slug` (UNIQUE), `filter_tag`, `is_published` |
| `hardware_nodes` | Lab Archive hardware nodes, diagnostic logs & restoration history | `id`, `node_id`, `is_published` |
| `skills` | Competency matrix categorized by Language, Platform, Tools | `id`, `category`, `display_order` |
| `experiences` | Employment, student leadership, and systems architecture history | `id`, `is_published`, `display_order` |
| `education` | Academic achievements, degree programs, and honors | `id`, `is_published`, `display_order` |
| `certifications`| Credentials, issuing bodies, credential IDs, and verification links | `id`, `is_published`, `display_order` |
| `services` | Engineering specialties and capabilities | `id`, `is_published`, `display_order` |
| `social_links` | External profiles (GitHub, LinkedIn, Email) | `id`, `display_order`, `is_published` |
| `site_settings` | Dynamic SEO tags, meta keywords, domain, and theme configuration | `id`, `setting_key` (UNIQUE) |
| `messages` | Contact form signal transmissions with IP tracking & read states | `id`, `is_read`, `created_at` |
| `media` | Uploaded images, MIME types, file sizes, and accessibility alt text | `id`, `created_at` |
| `activity_logs` | Audit trail of all administrative actions and logins | `id`, `action`, `created_at` |

---

## 2. Migration Execution

### Local Development (CLI)
Run migrations and automatic seeders:
```powershell
php database/migrate.php
```

### Production Shared Hosting (phpMyAdmin)
InfinityFree shared hosting accounts can import the complete pre-built SQL dump directly:
1. Open **phpMyAdmin** from your InfinityFree panel.
2. Select your database.
3. Click **Import** -> Choose file `database/schema_dump.sql` -> Click **Go**.

---

## 3. Database Backup & Export

Because shared hosting does not provide SSH cron jobs, regular manual backups are strongly recommended:

1. **Exporting via phpMyAdmin**:
   - Open phpMyAdmin in the InfinityFree Control Panel.
   - Click the **Export** tab.
   - Choose **Quick** export method and **SQL** format.
   - Click **Export** and store the `.sql` file in an encrypted local folder (e.g., using 7-Zip AES-256).

2. **Restoring from Backup**:
   - If restoration is required, drop existing tables in phpMyAdmin and import your `.sql` backup.
   - Upload media attachments back into `storage/uploads/`.
