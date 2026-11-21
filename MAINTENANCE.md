# Maintenance & Future VPS Migration Guide // x64emkei.dev

This document provides operational procedures for routine maintenance, performance audits, and seamless migration from free shared hosting to a VPS.

---

## 1. Routine Maintenance Checklist

### Monthly:
- [ ] Export a fresh SQL database backup via phpMyAdmin or `database/migrate.php`.
- [ ] Download new uploads from `/htdocs/storage/uploads/` via FileZilla to local cold storage.
- [ ] Review `storage/logs/error.log` and `storage/logs/database.log` for any recurring issues.
- [ ] Clear temporary session cache files in `storage/cache/` if disk quotas approach limits.

### Quarterly:
- [ ] Audit dependencies and run `composer audit` if Composer is used.
- [ ] Verify SSL certificate renewal status in the InfinityFree Client Area.
- [ ] Run automated test suite locally:
  ```powershell
  php tests/run_tests.php
  ```

---

## 2. Future Migration: Moving to a VPS (Ubuntu / Debian / NGINX / Docker)

When upgrading from InfinityFree to a VPS (e.g. DigitalOcean, Linode, Hetzner, AWS), the application architecture requires **zero refactoring**:

### Step 1: Provision VPS & LAMP/LEMP Stack
```bash
sudo apt update && sudo apt install -y nginx php8.3-fpm php8.3-mysql php8.3-mbstring php8.3-xml php8.3-curl mariadb-server
```

### Step 2: Clone Repository via Git
```bash
cd /var/www
git clone https://github.com/x64emkei/x64emkei_portfolio.git x64emkei.dev
cd x64emkei.dev
cp .env.example .env
```

### Step 3: NGINX Configuration
```nginx
server {
    listen 80;
    server_name x64emkei.dpdns.org;
    root /var/www/x64emkei.dev;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
    }

    location ~ ^/(app|bootstrap|config|database|storage/logs|storage/cache) {
        deny all;
        return 404;
    }
}
```

### Step 4: Import Database & Restore Uploads
```bash
mysql -u root -p x64emkei_portfolio < database/schema_dump.sql
```
Update `.env` with your new local MySQL credentials.

### Step 5: Provision Free SSL via Certbot
```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d x64emkei.dpdns.org
```
Your portfolio CMS is now live on a high-speed VPS with zero code modifications!
