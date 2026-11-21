<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Message;
use App\Models\ActivityLog;
use App\Services\RateLimiter;
use App\Services\CsrfService;

class ContactController
{
    public function submit(): void
    {
        $limiter = new RateLimiter();
        $ip = client_ip();
        $rateKey = 'contact_submit_' . $ip;

        // Rate limiting: 4 submissions per hour per IP
        if ($limiter->tooManyAttempts($rateKey, 4, 3600)) {
            $wait = $limiter->availableIn($rateKey);
            $msg = "Telemetry rate limit exceeded. Please wait " . ceil($wait / 60) . " minute(s) before transmitting another message.";
            if ($this->isAjax()) {
                json_response(['success' => false, 'error' => $msg], 429);
            }
            flash('error', $msg);
            redirect('/#contact');
        }

        // Honeypot spam defense
        if (!empty($_POST['contact_botcheck'])) {
            // Silently discard bot transmissions
            if ($this->isAjax()) {
                json_response(['success' => true, 'message' => 'Telemetry transmission acknowledged.']);
            }
            flash('success', 'Telemetry transmission received.');
            redirect('/#contact');
        }

        $name = trim((string)($_POST['name'] ?? ''));
        $email = trim((string)($_POST['email'] ?? ''));
        $subject = trim((string)($_POST['subject'] ?? 'General Portfolio Inquiry'));
        $messageBody = trim((string)($_POST['message'] ?? ''));

        // Validation
        $errors = [];
        if (strlen($name) < 2 || strlen($name) > 100) {
            $errors[] = 'Please provide a valid sender name (2-100 characters).';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please provide a valid email address.';
        }
        if (strlen($messageBody) < 5 || strlen($messageBody) > 5000) {
            $errors[] = 'Transmission message must be between 5 and 5000 characters.';
        }

        if (!empty($errors)) {
            if ($this->isAjax()) {
                json_response(['success' => false, 'error' => implode(' ', $errors)], 422);
            }
            flash('error', implode(' ', $errors));
            set_old_input($_POST);
            redirect('/#contact');
        }

        $limiter->hit($rateKey, 3600);

        Message::create([
            'sender_name' => $name,
            'sender_email' => $email,
            'subject' => $subject,
            'message_body' => $messageBody,
            'sender_ip' => $ip,
        ]);

        ActivityLog::record(null, 'CONTACT_SUBMISSION', "New message received from {$name} ({$email}).");

        clear_old_input();

        if ($this->isAjax()) {
            json_response(['success' => true, 'message' => 'Telemetry transmission received. I will acknowledge your signal shortly!']);
        }

        flash('success', 'Telemetry transmission received. I will acknowledge your signal shortly!');
        redirect('/#contact');
    }

    private function isAjax(): bool
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') ||
               (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json'));
    }
}
