<?php
declare(strict_types=1);

namespace App\Renderers;

class CertificationRenderer
{
    public static function render(array $certifications, array $section = []): string
    {
        if (empty($certifications)) {
            return '<div class="hud-empty-telemetry">// NO CERTIFICATIONS TELEMETRY LOGGED</div>';
        }

        $heading = htmlspecialchars($section['title'] ?? 'CERTIFICATIONS & LICENSES');
        $subtitle = htmlspecialchars($section['subtitle'] ?? 'VERIFIED TECHNICAL CREDENTIALS');
        $intro = !empty($section['intro_text']) ? '<p class="section-intro">' . nl2br(htmlspecialchars($section['intro_text'])) . '</p>' : '';

        $cardsHtml = '';
        foreach ($certifications as $cert) {
            $title = htmlspecialchars($cert['title']);
            $issuer = htmlspecialchars($cert['issuer']);
            $date = htmlspecialchars($cert['issue_date'] ?? '');
            $credId = !empty($cert['credential_id']) ? '<div class="cert-id">ID: ' . htmlspecialchars($cert['credential_id']) . '</div>' : '';
            $verifyLink = !empty($cert['credential_url']) ? '<a href="' . htmlspecialchars($cert['credential_url']) . '" target="_blank" class="cert-verify-link">VERIFY CREDENTIAL &nearr;</a>' : '';

            $cardsHtml .= <<<HTML
            <div class="cert-card">
                <span class="cert-badge">// CREDENTIAL</span>
                <h3 class="cert-title">{$title}</h3>
                <div class="cert-issuer">{$issuer} &bull; <span class="cert-date">{$date}</span></div>
                {$credId}
                {$verifyLink}
            </div>
HTML;
        }

        return <<<HTML
        <div class="section-header">
            <span class="hud-subtitle">// {$subtitle}</span>
            <h2 class="hud-heading">{$heading}</h2>
            {$intro}
        </div>
        <div class="certifications-grid">
            {$cardsHtml}
        </div>
HTML;
    }
}
