# Database Architecture & Management Guide

This directory manages the database schema, versioned migrations, and seed states for **x64emkei.dev**.

---

## 1. Quick Initialization (Local or Remote)

To initialize or migrate the database automatically:
```bash
php database/migrate.php
```

To refresh projects and core telemetry seeds:
```bash
php database/migrate.php --force
```

---

## 2. SQL Artifacts

- `database/schema.sql`: Exact structure definitions of all 21 tables (indexes, foreign keys, UTF8mb4 character collation).
- `database/seed.sql`: Data dumps including profile info, portfolio projects, skills matrix, hardware lab nodes, and initial categories.
- `database/migrations/`: Incremental numbered SQL migrations (001 through 018).

---

## 3. InfinityFree / Shared Hosting Deployment

1. Create a MySQL database inside the InfinityFree Control Panel (e.g. `epiz_XXXXX_x64emkei`).
2. Open phpMyAdmin for that database.
3. Import `database/schema.sql`.
4. Import `database/seed.sql`.
5. Enter your database credentials into your `.env` file or configure via `/admin/setup`.
6. Log in to the Admin Dashboard via `/admin/login` to manage content.
