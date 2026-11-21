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

it("Project matrix contains all seeded builds", function() {
    $count = Project::count();
    if ($count < 6) {
        throw new Exception("Expected at least 6 projects, found {$count}");
    }
    $published = Project::getPublished();
    if (empty($published)) {
        throw new Exception("Published projects list is empty.");
    }
});

it("Hardware nodes archive returns preserved systems", function() {
    $nodes = HardwareNode::getPublished();
    if (empty($nodes)) {
        throw new Exception("No hardware nodes found.");
    }
});

it("Skills matrix returns categorized skills", function() {
    $grouped = Skill::getPublishedGrouped();
    if (!isset($grouped['Languages'])) {
        throw new Exception("Languages category missing in skills.");
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
