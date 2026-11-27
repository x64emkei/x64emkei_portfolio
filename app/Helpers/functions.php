<?php
declare(strict_types=1);

/**
 * Global Application Helper Functions
 */

use App\Services\CsrfService;

if (!function_exists('e')) {
    /**
     * Escape HTML output safely for UTF-8
     */
    function e(?string $value): string
    {
        return htmlspecialchars((string)($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('url')) {
    /**
     * Generate an application URL supporting subfolder installs (like /x64emkei_portfolio/)
     * or root domain (like x64emkei.dpdns.org)
     */
    function url(string $path = ''): string
    {
        $base = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
        $cleanPath = '/' . ltrim($path, '/');
        
        // Handle when base is empty or root
        if ($base === '' || $base === '.') {
            return $cleanPath;
        }
        
        return $base . $cleanPath;
    }
}

if (!function_exists('asset')) {
    /**
     * Return asset path with cache-busting timestamp
     */
    function asset(string $path): string
    {
        $urlPath = url($path);
        $fullPath = dirname(__DIR__, 2) . '/' . ltrim($path, '/');
        if (file_exists($fullPath)) {
            $version = filemtime($fullPath);
            return $urlPath . '?v=' . $version;
        }
        return $urlPath;
    }
}

if (!function_exists('csrf_token')) {
    /**
     * Get or create current CSRF token
     */
    function csrf_token(): string
    {
        return CsrfService::getToken();
    }
}

if (!function_exists('csrf_field')) {
    /**
     * Render hidden HTML input containing CSRF token
     */
    function csrf_field(): string
    {
        return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
    }
}

if (!function_exists('flash')) {
    /**
     * Set or retrieve flash messages
     */
    function flash(string $key, ?string $message = null): ?string
    {
        if ($message !== null) {
            $_SESSION['_flash'][$key] = $message;
            return null;
        }
        
        if (isset($_SESSION['_flash'][$key])) {
            $msg = $_SESSION['_flash'][$key];
            unset($_SESSION['_flash'][$key]);
            return $msg;
        }
        
        return null;
    }
}

if (!function_exists('has_flash')) {
    function has_flash(string $key): bool
    {
        return isset($_SESSION['_flash'][$key]);
    }
}

if (!function_exists('old')) {
    /**
     * Retrieve old submitted form values
     */
    function old(string $key, mixed $default = ''): mixed
    {
        $val = $_SESSION['_old'][$key] ?? $default;
        return is_string($val) ? e($val) : $val;
    }
}

if (!function_exists('set_old_input')) {
    function set_old_input(array $data): void
    {
        $_SESSION['_old'] = $data;
    }
}

if (!function_exists('clear_old_input')) {
    function clear_old_input(): void
    {
        unset($_SESSION['_old']);
    }
}

if (!function_exists('redirect')) {
    /**
     * Redirect to another URL and terminate
     */
    function redirect(string $path, int $status = 302): never
    {
        $target = str_starts_with($path, 'http') ? $path : url($path);
        if (!headers_sent()) {
            header("Location: {$target}", true, $status);
        }
        exit;
    }
}

if (!function_exists('json_response')) {
    /**
     * Return JSON response
     */
    function json_response(array $data, int $status = 200): never
    {
        http_response_code($status);
        if (!headers_sent()) {
            header('Content-Type: application/json; charset=utf-8');
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        exit;
    }
}

if (!function_exists('slugify')) {
    function slugify(string $text): string
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text) ?: $text;
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        return strtolower($text ?: 'n-a');
    }
}

if (!function_exists('formatPhtDate')) {
    /**
     * Format a date/time explicitly in Philippine Standard Time (GMT+8 / Asia/Manila)
     * e.g. "November 24, 2026, 9:30 PM PHT"
     */
    function formatPhtDate(string|int|\DateTimeInterface|null $date, bool $includeTime = true): string
    {
        if (!$date) {
            return 'N/A';
        }
        try {
            $tz = new \DateTimeZone('Asia/Manila');
            if (is_numeric($date)) {
                $dt = new \DateTime('@' . $date);
                $dt->setTimezone($tz);
            } elseif ($date instanceof \DateTimeInterface) {
                $dt = (new \DateTime($date->format('Y-m-d H:i:s'), $date->getTimezone()))->setTimezone($tz);
            } else {
                $dt = new \DateTime((string)$date, $tz);
            }
            return $dt->format($includeTime ? 'F j, Y, g:i A \P\H\T' : 'F j, Y');
        } catch (\Throwable) {
            return (string)$date;
        }
    }
}

if (!function_exists('client_ip')) {
    function client_ip(): string
    {
        $remoteAddress = (string) ($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
        $trustedProxies = array_filter(array_map(
            'trim',
            explode(',', (string) env('TRUSTED_PROXIES', ''))
        ));

        $ip = $remoteAddress;
        // Forwarding headers can be forged by clients. Honor them only when
        // the direct peer has been explicitly designated as a trusted proxy.
        $isTrustedProxy = false;
        foreach ($trustedProxies as $trustedProxy) {
            if (ip_matches_cidr($remoteAddress, $trustedProxy)) {
                $isTrustedProxy = true;
                break;
            }
        }

        if ($isTrustedProxy) {
            if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
                $ip = (string) $_SERVER['HTTP_CF_CONNECTING_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $parts = explode(',', (string) $_SERVER['HTTP_X_FORWARDED_FOR']);
                $ip = trim($parts[0]);
            }
        }
        return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
    }
}

if (!function_exists('ip_matches_cidr')) {
    /**
     * Match an address against a literal IP or CIDR range without trusting
     * client-provided forwarding headers.
     */
    function ip_matches_cidr(string $ip, string $network): bool
    {
        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            return false;
        }

        if (!str_contains($network, '/')) {
            return hash_equals($network, $ip);
        }

        [$subnet, $prefix] = explode('/', $network, 2);
        if (!ctype_digit($prefix)) {
            return false;
        }

        $packedIp = inet_pton($ip);
        $packedSubnet = inet_pton($subnet);
        if ($packedIp === false || $packedSubnet === false || strlen($packedIp) !== strlen($packedSubnet)) {
            return false;
        }

        $prefixLength = (int) $prefix;
        $maxPrefixLength = strlen($packedIp) * 8;
        if ($prefixLength < 0 || $prefixLength > $maxPrefixLength) {
            return false;
        }

        $fullBytes = intdiv($prefixLength, 8);
        $remainingBits = $prefixLength % 8;
        if (substr($packedIp, 0, $fullBytes) !== substr($packedSubnet, 0, $fullBytes)) {
            return false;
        }

        if ($remainingBits === 0) {
            return true;
        }

        $mask = (0xFF << (8 - $remainingBits)) & 0xFF;
        return (ord($packedIp[$fullBytes]) & $mask) === (ord($packedSubnet[$fullBytes]) & $mask);
    }
}
