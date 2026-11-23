# Deployment Guide: Shared Hosting (InfinityFree / cPanel)

This document provides complete instructions for deploying the **x64emkei.dev** platform to InfinityFree or any standard shared cPanel hosting provider running PHP 8.2+.

---

## 1. Hosting Architecture Overview

- **Stack**: PHP 8.2+, MySQL / MariaDB, Apache (`.htaccess` URL rewriting enabled).
- **Public Entry Point**: `index.php` (Root front controller).
- **Protected Directories**: `storage/logs/`, `storage/cache/`, `storage/uploads/` are secured with `.htaccess` rules preventing direct PHP execution.

---

## 2. Step-by-Step Deployment Procedure

### Step 1: Prepare Database on InfinityFree
1. Log into your **InfinityFree Client Area** and select your account.
2. Navigate to **MySQL Databases**.
3. Create a new database (e.g., `epiz_XXXXX_portfolio`).
4. Note down your credentials:
   - **MySQL Hostname**: (e.g. `sqlXXX.infinityfree.com` or `sqlXXX.epizy.com`)
   - **MySQL Database Name**: `epiz_XXXXX_portfolio`
   - **MySQL Username**: `epiz_XXXXX`
   - **MySQL Password**: Your vPanel account password.

### Step 2: Initialize Database Schema and Data
1. In the InfinityFree Control Panel, click on **phpMyAdmin** next to your database.
2. Click the **Import** tab.
3. Import `database/schema.sql`.
4. Import `database/seed.sql` to populate projects, profile data, categories, and site settings.

### Step 3: Configure Environment Credentials
1. Create or edit `.env` in the root directory:
   ```ini
   APP_NAME="x64emkei.dev"
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://welcome.x64emkei.dpdns.org

   DB_CONNECTION=mysql
   DB_HOST=sqlXXX.epizy.com
   DB_PORT=3306
   DB_DATABASE=epiz_XXXXX_portfolio
   DB_USERNAME=epiz_XXXXX
   DB_PASSWORD=your_mysql_password
   ```

### Step 4: Upload Application Files via FTP
Using FileZilla, WinSCP, or your preferred FTP client:
1. Connect using your FTP host, username, and password.
2. In your remote file system, navigate to:
   ```
   welcome.x64emkei.dpdns.org/htdocs/
   ```
3. Upload all project files into this directory:
   - `app/`
   - `bootstrap/`
   - `config/`
   - `database/`
   - `images/`
   - `routes/`
   - `storage/`
   - `.htaccess`
   - `index.php`
   - `style.css`
   - `script.js`
   - `.env`

### Step 5: Initialize Primary Administrator Account
1. Open your browser and navigate to:
   ```
   https://your-domain.com/admin/setup
   ```
2. Enter your chosen Administrator Username, Email, and strong Password (minimum 8 characters).
3. Click **INITIALIZE ADMINISTRATOR ACCOUNT**.
4. Once created, `/admin/setup` automatically locks itself against further access.
5. Log in at `https://your-domain.com/admin/login` to access the CMS dashboard.

---

## 3. Post-Deployment Security Checklist
- [x] Ensure `.env` is blocked from web access (covered by root `.htaccess`).
- [x] Ensure `storage/logs/` and `storage/uploads/` deny direct script execution.
- [x] Verify `/journal` and `/work` URLs resolve properly without index.php in the URL.
- [x] Check contact form spam mitigation and rate limiting.
