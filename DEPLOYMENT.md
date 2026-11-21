# Production Deployment Guide // InfinityFree (PHP + MySQL)

This guide provides step-by-step instructions for deploying **x64emkei.dev** to **InfinityFree shared hosting** connected to your domain `x64emkei.dpdns.org`.

---

## 1. Hosting Architecture Overview

InfinityFree provides standard Apache + PHP 8.2/8.3 + MariaDB/MySQL shared hosting.

### Target Directory Layout:
```text
/htdocs/                     <-- Primary public web root on InfinityFree
  ├── app/                   <-- Application code (protected via .htaccess)
  ├── bootstrap/             <-- Core autoloader & error handler
  ├── config/                <-- Database & application configs
  ├── database/              <-- Migrations & SQL schemas
  ├── images/                <-- Portfolio images & photography
  ├── scripts/               <-- Maintenance utilities
  ├── storage/               <-- Logs, cache & media uploads (protected)
  ├── .env                   <-- PRIVATE database credentials (NEVER in GitHub)
  ├── .htaccess              <-- Security & URL routing rewrite rules
  ├── index.php              <-- Front controller entry point
  ├── script.js              <-- Client-side HUD interactions
  └── style.css              <-- Main stylesheet
```

> [!NOTE]
> If your InfinityFree account permits directory creation **above** `/htdocs/` (e.g., `/private/`), you may optionally place `app/`, `config/`, and `.env` in `/private/`. The application's `bootstrap/app.php` automatically scans `../private/config/.env` and `../private/.env` as fallback locations!

---

## 2. Pre-Deployment Preparation

1. **Build the Production Package**:
   Run the automated packaging script locally:
   ```powershell
   .\scripts\build_production_package.ps1
   ```
   This generates `deploy/x64emkei_portfolio_deploy.zip` excluding local Git histories, tests, and temporary files.

2. **Set up MySQL Database in InfinityFree Control Panel**:
   - Log in to your InfinityFree Client Area (`https://dash.infinityfree.com`).
   - Select your hosting account for `x64emkei.dpdns.org`.
   - Click **MySQL Databases**.
   - Create a new database (e.g., `if0_12345678_portfolio`).
   - Note the connection details provided in your panel:
     - **MySQL Hostname**: e.g., `sql123.infinityfree.com`
     - **MySQL Database Name**: e.g., `if0_12345678_portfolio`
     - **MySQL Username**: e.g., `if0_12345678`
     - **MySQL Password**: Your hosting account password

---

## 3. Uploading Files via FTP (FileZilla)

1. Open **FileZilla** (or your preferred FTP client).
2. Connect using the credentials found in the InfinityFree Control Panel:
   - **Host**: e.g., `ftpupload.net` (Port 21)
   - **Username**: Your FTP username (e.g., `if0_12345678`)
   - **Password**: Your hosting account password
   - **Encryption**: *Require explicit FTP over TLS* (or Plain FTP if TLS is unsupported)
3. Navigate to `/htdocs/` on the remote server.
4. Upload all files from the `deploy/` package directly into `/htdocs/`.

---

## 4. Configuring Private Credentials (`.env`)

1. In `/htdocs/` on the server, create or edit the `.env` file (copied from `.env.example`).
2. Insert your actual InfinityFree database credentials:
   ```ini
   APP_NAME="x64emkei.dev"
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://x64emkei.dpdns.org

   DB_CONNECTION=mysql
   DB_HOST=sql123.infinityfree.com
   DB_PORT=3306
   DB_DATABASE=if0_12345678_portfolio
   DB_USERNAME=if0_12345678
   DB_PASSWORD=YourHostingPasswordHere
   ```
3. Save the file. The `.htaccess` file already blocks any web visitors from viewing `.env`!

---

## 5. Applying Database Migrations & Initial Seed

You have two convenient options to initialize the production database:

### Option A: Via phpMyAdmin (Recommended for Shared Hosting)
1. In InfinityFree Control Panel, open **phpMyAdmin** for your database.
2. Click the **Import** tab.
3. Import the all-in-one schema file:
   [database/schema_dump.sql](file:///c:/xampp/htdocs/x64emkei_portfolio/database/schema_dump.sql)
4. All 14 tables, site settings, profile, skills, and 16 portfolio projects will be initialized immediately!

### Option B: Via Web Migration Runner
Access the protected web migration endpoint in your browser:
```text
https://x64emkei.dpdns.org/index.php?route=admin/setup
```

---

## 6. Creating the First Administrator

Once the database is initialized:
1. Visit `https://x64emkei.dpdns.org/admin/setup` (or `https://x64emkei.dpdns.org/admin`).
2. The system detects that no administrator accounts exist and displays the **Primary Operator Setup** screen.
3. Enter your desired administrator username, notification email, and master password (minimum 8 characters).
4. Click **Initialize Administrator**.
5. You are now logged into the **Control Center** at `https://x64emkei.dpdns.org/admin`!

---

## 7. Rollback & Disaster Recovery

- If a file upload issue occurs, replace `/htdocs/` files with the previous deployment zip.
- To export your live database, use phpMyAdmin -> **Export** -> **Quick** -> **SQL**.
- Live uploads are stored in `/htdocs/storage/uploads/` — download this directory periodically to maintain a local backup.
