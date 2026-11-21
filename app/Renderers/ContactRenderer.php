<?php
declare(strict_types=1);

namespace App\Renderers;

class ContactRenderer
{
    public static function render(array $profile, array $socialLinks = [], array $section = []): string
    {
        $email = htmlspecialchars($profile['email'] ?? 'mordenes@acm.org');
        $location = htmlspecialchars($profile['location'] ?? 'Laguna, Philippines');
        $status = htmlspecialchars($profile['availability_status'] ?? 'Available for Systems & Web Engineering');
        $heading = htmlspecialchars($section['title'] ?? 'TRANSMIT MESSAGE');
        $subtitle = htmlspecialchars($section['subtitle'] ?? 'DIRECT TELEMETRY UPLINK');
        $intro = !empty($section['intro_text']) ? '<p class="section-intro">' . nl2br(htmlspecialchars($section['intro_text'])) . '</p>' : '';

        $socialsHtml = '';
        foreach ($socialLinks as $link) {
            $label = htmlspecialchars($link['label']);
            $url = htmlspecialchars($link['url']);
            $socialsHtml .= <<<HTML
            <a href="{$url}" target="_blank" rel="noopener noreferrer" class="contact-social-pill">
                <span>{$label}</span> &nearr;
            </a>
HTML;
        }

        $csrfField = csrf_field();
        $contactUrl = htmlspecialchars(url('contact'));

        return <<<HTML
        <div class="section-header">
            <span class="hud-subtitle">// {$subtitle}</span>
            <h2 class="hud-heading">{$heading}</h2>
            {$intro}
        </div>
        <div class="contact-hud-grid">
            <div class="contact-info-panel">
                <div class="contact-info-item">
                    <span class="info-label">// DIRECT DISPATCH</span>
                    <a href="mailto:{$email}" class="info-value">{$email}</a>
                </div>
                <div class="contact-info-item">
                    <span class="info-label">// CURRENT STATION</span>
                    <span class="info-value">{$location}</span>
                </div>
                <div class="contact-info-item">
                    <span class="info-label">// OPERATIONAL STATUS</span>
                    <span class="info-value text-accent">{$status}</span>
                </div>
                <div class="contact-socials-wrap">
                    <span class="info-label">// SOCIAL PROTOCOLS</span>
                    <div class="social-pills-row">
                        {$socialsHtml}
                    </div>
                </div>
            </div>
            <div class="contact-form-panel">
                <form action="{$contactUrl}" method="POST" class="hud-form">
                    {$csrfField}
                    <div class="form-row">
                        <div class="form-field">
                            <label for="contact_name">// CALLSIGN / NAME</label>
                            <input type="text" id="contact_name" name="name" required placeholder="e.g. Alex Mercer">
                        </div>
                        <div class="form-field">
                            <label for="contact_email">// RETURN FREQUENCY / EMAIL</label>
                            <input type="email" id="contact_email" name="email" required placeholder="alex@domain.com">
                        </div>
                    </div>
                    <div class="form-field">
                        <label for="contact_subject">// TRANSMISSION SUBJECT</label>
                        <input type="text" id="contact_subject" name="subject" required placeholder="e.g. Systems Architecture Collaboration">
                    </div>
                    <div class="form-field">
                        <label for="contact_message">// PAYLOAD / MESSAGE</label>
                        <textarea id="contact_message" name="message" rows="5" required placeholder="Transmit your communication payload..."></textarea>
                    </div>
                    <button type="submit" class="hud-submit-btn">&gt;&gt; DISPATCH TRANSMISSION</button>
                </form>
            </div>
        </div>
HTML;
    }
}
