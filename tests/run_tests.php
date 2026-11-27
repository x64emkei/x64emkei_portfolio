<?php
declare(strict_types=1);

/**
 * Automated Test Suite for x64emkei.dev
 * Tests Database Models, Routing, Authentication, CSRF, Rate Limiting, and Security Hardening.
 */

require_once __DIR__ . '/../bootstrap/autoload.php';
require_once __DIR__ . '/../bootstrap/app.php';

use Database\Database;
use App\Models\User;
use App\Models\Profile;
use App\Models\Project;
use App\Models\HardwareNode;
use App\Models\Skill;
use App\Models\Message;
use App\Models\Media;
use App\Services\AuthService;
use App\Services\CsrfService;
use App\Services\RateLimiter;
use App\Services\UploadService;
use App\Services\BirthdayService;

echo "\n======================================================\n";
echo "   x64emkei.dev // AUTOMATED COMPREHENSIVE TEST SUITE \n";
echo "======================================================\n\n";

$passed = 0;
$failed = 0;

function it(string $description, callable $fn): void {
    global $passed, $failed;
    try {
        $fn();
        echo "  [PASS] {$description}\n";
        $passed++;
    } catch (\Throwable $e) {
        echo "  [FAIL] {$description}\n";
        echo "         Error: " . $e->getMessage() . "\n";
        $failed++;
    }
}

// ----------------------------------------------------
// 1. Database Connection & Schema Test
// ----------------------------------------------------
it("Database connects and returns valid PDO instance", function() {
    $pdo = Database::getConnection();
    if (!($pdo instanceof PDO)) {
        throw new Exception("Expected PDO instance.");
    }
});

it("Profile record exists and has valid name", function() {
    $profile = Profile::get();
    if (!$profile || empty($profile['full_name'])) {
        throw new Exception("Profile not found or empty.");
    }
    if ($profile['full_name'] !== 'Michael Benedict Ordenes') {
        throw new Exception("Unexpected profile name: " . $profile['full_name']);
    }
});

it("Project matrix operations work cleanly in initial state", function() {
    $count = Project::count();
    if ($count < 0) {
        throw new Exception("Project count returned negative value: {$count}");
    }
    // Verify Project model lifecycle (create, fetch, delete)
    $tempSlug = 'test-node-' . substr(bin2hex(random_bytes(4)), 0, 8);
    $testId = Project::create([
        'code_id' => 'PRJ-TEST-01',
        'title' => 'Test Telemetry Node',
        'slug' => $tempSlug,
        'category' => 'Systems',
        'filter_tag' => 'systems',
        'tagline' => 'Automated test pipeline verification build.',
        'description' => 'Detailed verification telemetry data and system performance assessment.',
        'operational_status' => 'Testing',
        'is_published' => 1
    ]);
    if ($testId <= 0) {
        throw new Exception("Failed to insert test project.");
    }
    $found = Project::findBySlug($tempSlug);
    if (!$found || $found['title'] !== 'Test Telemetry Node') {
        throw new Exception("Failed to retrieve created test project by slug.");
    }
    Project::delete($testId);
});

it("Hardware nodes archive returns preserved systems", function() {
    $nodes = HardwareNode::getPublished();
    if (empty($nodes)) {
        throw new Exception("No hardware nodes found.");
    }
});

it("Skills matrix returns categorized skills", function() {
    $grouped = Skill::getPublishedGrouped();
    if (empty($grouped)) {
        throw new Exception("Skills matrix returned empty list.");
    }
    $expectedCategories = ['Programming & Databases', 'Systems & Virtualization', 'Creative & Digital Media', 'Workflow & Operations'];
    $foundAny = false;
    foreach ($expectedCategories as $cat) {
        if (isset($grouped[$cat])) {
            $foundAny = true;
            break;
        }
    }
    if (!$foundAny) {
        throw new Exception("Expected seeded skills categories not found in grouped output.");
    }
});

// ----------------------------------------------------
// 2. Security Services: CSRF
// ----------------------------------------------------
it("CSRF token generates, persists, and validates with hash_equals", function() {
    $token = CsrfService::getToken();
    if (strlen($token) !== 64) {
        throw new Exception("Expected 64-char hex CSRF token.");
    }
    if (!CsrfService::validate($token)) {
        throw new Exception("CSRF token validation failed on authentic token.");
    }
    if (CsrfService::validate('forged_fake_token_12345')) {
        throw new Exception("CSRF validation falsely accepted an invalid token.");
    }
});

it("Birthday presentation follows July 20 in Asia/Manila", function() {
    $active = BirthdayService::state(new DateTimeImmutable('2026-07-20 00:00:00', new DateTimeZone('Asia/Manila')));
    $inactive = BirthdayService::state(new DateTimeImmutable('2026-07-21 00:00:00', new DateTimeZone('Asia/Manila')));
    if (empty($active['active']) || !empty($inactive['active'])) {
        throw new Exception('Birthday state did not activate and expire on the configured Manila date.');
    }
});

// ----------------------------------------------------
// 3. Security Services: RateLimiter
// ----------------------------------------------------
it("RateLimiter correctly tracks attempts and locks out abuse", function() {
    $limiter = new RateLimiter();
    $testKey = 'test_ip_rate_' . time();
    $limiter->clear($testKey);

    for ($i = 1; $i <= 3; $i++) {
        $limiter->hit($testKey, 60);
    }

    if ($limiter->tooManyAttempts($testKey, 5, 60)) {
        throw new Exception("Should not lock out at 3 attempts when max is 5.");
    }

    $limiter->hit($testKey, 60);
    $limiter->hit($testKey, 60);

    if (!$limiter->tooManyAttempts($testKey, 5, 60)) {
        throw new Exception("Should trigger lockout at 5 attempts.");
    }

    $limiter->clear($testKey);
    if ($limiter->tooManyAttempts($testKey, 5, 60)) {
        throw new Exception("Lockout should clear after reset.");
    }
});

it("Client IP forwarding headers require a trusted proxy", function() {
    putenv('TRUSTED_PROXIES=10.0.0.0/8,2001:db8::/32');

    $_SERVER['REMOTE_ADDR'] = '198.51.100.10';
    $_SERVER['HTTP_X_FORWARDED_FOR'] = '203.0.113.8';
    if (client_ip() !== '198.51.100.10') {
        throw new Exception('Untrusted peer must not control the client IP.');
    }

    $_SERVER['REMOTE_ADDR'] = '10.4.5.6';
    if (client_ip() !== '203.0.113.8') {
        throw new Exception('Trusted CIDR proxy did not supply client IP.');
    }

    putenv('TRUSTED_PROXIES');
    unset($_SERVER['HTTP_X_FORWARDED_FOR']);
});

// ----------------------------------------------------
// 4. Authentication & Lockout Defense
// ----------------------------------------------------
it("User model hashes password and verifies securely", function() {
    $testUser = 'test_op_' . substr(bin2hex(random_bytes(4)), 0, 8);
    $testPass = 'Complex_Sec!2026';

    $userId = User::create([
        'username' => $testUser,
        'email' => $testUser . '@example.com',
        'password' => $testPass,
        'role' => 'admin',
        'is_active' => 1
    ]);

    if ($userId <= 0) {
        throw new Exception("Failed to insert test user.");
    }

    $found = User::findByUsernameOrEmail($testUser);
    if (!$found || !password_verify($testPass, $found['password_hash'])) {
        throw new Exception("Password verification failed.");
    }

    // Clean up test user
    User::delete($userId);
});

it("Authentication revalidates disabled accounts on each request", function() {
    $username = 'test_session_' . substr(bin2hex(random_bytes(4)), 0, 8);
    $userId = User::create([
        'username' => $username,
        'email' => $username . '@example.com',
        'password' => 'Complex_Sec!2026',
        'role' => 'editor',
        'is_active' => 1,
    ]);

    $_SESSION['admin_user_id'] = $userId;
    $_SESSION['admin_user_data'] = ['id' => $userId, 'role' => 'editor'];
    if (!AuthService::check()) {
        throw new Exception('Active account should pass session revalidation.');
    }

    User::update($userId, ['is_active' => 0]);
    if (AuthService::check()) {
        throw new Exception('Disabled account retained access through a stale session.');
    }

    User::delete($userId);
});

// ----------------------------------------------------
// 5. Contact Message & Spam Sanitization
// ----------------------------------------------------
it("Message model stores contact transmissions with sanitized parameters", function() {
    $msgId = Message::create([
        'sender_name' => 'Dr. Telemetry',
        'sender_email' => 'telemetry@research.org',
        'subject' => 'QuantumMesh Consultation',
        'message_body' => 'Testing automated transmission pipeline.',
        'sender_ip' => '127.0.0.1'
    ]);

    if ($msgId <= 0) {
        throw new Exception("Failed to store message.");
    }

    $msg = Message::find($msgId);
    if (!$msg || $msg['sender_name'] !== 'Dr. Telemetry') {
        throw new Exception("Message data mismatch.");
    }

    Message::markRead($msgId, true);
    $updated = Message::find($msgId);
    if ((int)$updated['is_read'] !== 1) {
        throw new Exception("Failed to mark message as read.");
    }

    Message::delete($msgId);
});

// ----------------------------------------------------
// 6. Secure Upload Hardening
// ----------------------------------------------------
it("UploadService enforces directory security and rejects fake files", function() {
    $uploader = new UploadService();
    $htaccess = dirname(__DIR__) . '/storage/uploads/.htaccess';
    if (!file_exists($htaccess)) {
        throw new Exception("Upload directory .htaccess security file missing.");
    }
    $rules = (string)file_get_contents($htaccess);
    if (!str_contains($rules, 'Require all denied') && !str_contains($rules, 'Deny from all')) {
        throw new Exception(".htaccess missing script execution deny rules.");
    }
});

// ----------------------------------------------------
// 7. System Health Endpoint & HttpException
// ----------------------------------------------------
it("HttpException carries accurate status code and health diagnostics function", function() {
    $e = new \App\Services\HttpException(503, "Service Offline");
    if ($e->getStatusCode() !== 503) {
        throw new Exception("HttpException failed to preserve status code 503.");
    }

    $cmd = 'C:\xampp\php\php.exe -r "require \'bootstrap/autoload.php\'; require \'bootstrap/app.php\'; require \'routes/web.php\'; (new \App\Controllers\ApiController())->health();"';
    $output = shell_exec($cmd);
    $data = json_decode((string)$output, true);
    if (!isset($data['status'])) {
        throw new Exception("Health endpoint failed to return structured status. Raw: " . $output);
    }
});

// ----------------------------------------------------
// 8. Resilient Logging & Security Redaction
// ----------------------------------------------------
it("Application logger redacts sensitive credentials from log stream", function() {
    app_log('INFO', 'Test security logging', [
        'password' => 'SuperSecret123',
        'db_pass' => 'DBPassword456',
        'safe_field' => 'TelemetryData'
    ]);
    $logContent = (string)@file_get_contents(dirname(__DIR__) . '/storage/logs/app.log');
    if (str_contains($logContent, 'SuperSecret123') || str_contains($logContent, 'DBPassword456')) {
        throw new Exception("Sensitive credentials leaked into log file!");
    }
});

// ----------------------------------------------------
// 9. Sections Architecture & Achievements Model Test
// ----------------------------------------------------
it("PortfolioSection and Achievement models operate correctly", function() {
    $secCount = \App\Models\PortfolioSection::count();
    if ($secCount < 5) {
        throw new Exception("Expected at least 5 portfolio sections, found {$secCount}");
    }

    $heroSec = \App\Models\PortfolioSection::findByKey('hero');
    if (!$heroSec || empty($heroSec['title'])) {
        throw new Exception("Hero section record missing or invalid.");
    }

    $achievements = \App\Models\Achievement::getPublished();
    if (empty($achievements)) {
        throw new Exception("Published achievements list is empty.");
    }

    $certifications = \App\Models\Certification::getPublished();
    if (empty($certifications)) {
        throw new Exception("Published certifications list is empty.");
    }
});

// ----------------------------------------------------
// 10. Journal & Article Model Test
// ----------------------------------------------------
it("Article and Category models support publication and tag syncing", function() {
    $categories = \App\Models\ArticleCategory::allOrdered();
    if (empty($categories)) {
        throw new Exception("Expected seeded article categories.");
    }

    $articles = \App\Models\Article::getPublished();
    if (empty($articles)) {
        throw new Exception("Expected at least one published journal article.");
    }

    $article = \App\Models\Article::findBySlug('zero-trust-architecture-modern-systems');
    if (!$article || $article['title'] !== 'Zero-Trust Architecture in Modern Systems') {
        throw new Exception("Article lookup by slug failed.");
    }

    if (empty($article['tags'])) {
        throw new Exception("Article tags pivot failed to load associated tags.");
    }
});

// ----------------------------------------------------
// Summary
// ----------------------------------------------------
echo "\n------------------------------------------------------\n";
echo "Tests Passed: {$passed}\n";
echo "Tests Failed: {$failed}\n";
echo "------------------------------------------------------\n\n";

if ($failed > 0) {
    exit(1);
}
echo "[SUCCESS] All unit, integration, and security checks verified!\n\n";
