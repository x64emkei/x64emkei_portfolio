# Domain & DNS Integration Guide // x64emkei.dpdns.org

This guide details connecting your custom domain **`x64emkei.dpdns.org`** to your **InfinityFree hosting account** and provisioning free SSL encryption.

---

## 1. Domain Registration in InfinityFree

1. Log in to the [InfinityFree Client Area](https://dash.infinityfree.com).
2. Open your hosting account (or click **Create Account** if not yet created).
3. Under Domain Name selection, select **Custom Domain**.
4. Enter: `x64emkei.dpdns.org`.
5. InfinityFree will display the required DNS configuration:
   - Either a specific **A Record** (e.g. pointing to `185.27.134.xxx`)
   - Or a **CNAME Record** (e.g. pointing to your account cluster hostname)
   - Do **NOT** guess IP addresses or CNAME destinations — copy the exact values supplied by InfinityFree.

---

## 2. Configuring Records at DPDNS.org

1. Log in to your **dpdns.org** DNS management dashboard.
2. Locate the DNS records table for `x64emkei.dpdns.org`.
3. Add or update the record according to InfinityFree instructions:

| Type | Name / Host | Target / Destination | TTL |
| :--- | :--- | :--- | :--- |
| **A** or **CNAME** | `@` or `x64emkei` | *(Provided by InfinityFree panel)* | 3600 (1 hour) |

> [!IMPORTANT]
> **Preserve Existing Records**: Do not alter or delete unrelated TXT, MX, or SPF records that may be required for other services on dpdns.org.

---

## 3. DNS Propagation Verification

DNS changes typically propagate within 15 minutes to 4 hours. You can verify propagation using standard CLI tools:

```powershell
# Check DNS resolution in PowerShell:
Resolve-DnsName x64emkei.dpdns.org
```
Or check via external DNS checker: `https://dnschecker.org/#A/x64emkei.dpdns.org`.

---

## 4. Free SSL Certificate Issuance (HTTPS)

InfinityFree provides automated Free SSL certificate management:

1. In the InfinityFree Client Area, click **Free SSL Certificates**.
2. Click **New SSL Certificate**.
3. Enter your domain: `x64emkei.dpdns.org`.
4. Choose **Let's Encrypt** or **ZeroSSL** provider.
5. Follow the verification steps:
   - InfinityFree will request a **CNAME Record** for DNS verification (e.g. `_acme-challenge.x64emkei.dpdns.org` -> `xyz.infinityfree.com`).
   - Add this verification CNAME record to your **dpdns.org** control panel.
6. Once the CNAME record is detected by the SSL provider, click **Request Certificate**.
7. Once issued, click **Install SSL Certificate Automatically**.

---

## 5. Enforcing HTTPS

After SSL is installed and working:
The included `.htaccess` in your repository will automatically redirect all traffic to HTTPS:

```apache
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

Test your live secure connection:
```text
https://x64emkei.dpdns.org
```
Verify that the browser displays the secure padlock icon with zero mixed-content warnings.
