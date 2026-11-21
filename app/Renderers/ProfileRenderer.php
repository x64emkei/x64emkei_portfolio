<?php
declare(strict_types=1);

namespace App\Renderers;

class ProfileRenderer
{
    public static function render(array $profile, array $section = []): string
    {
        $fullName = htmlspecialchars($profile['full_name'] ?? 'Michael Benedict Ordenes');
        $title = htmlspecialchars($profile['title'] ?? 'Systems Developer');
        $tagline = htmlspecialchars($profile['tagline'] ?? '');
        $bio = nl2br(htmlspecialchars($profile['bio_full'] ?: ($profile['bio_short'] ?? '')));
        $avatar = htmlspecialchars($profile['avatar_url'] ?: 'images/me_2.png');
        $location = htmlspecialchars($profile['location'] ?? 'Laguna, Philippines');
        $status = htmlspecialchars($profile['availability_status'] ?? 'Available for Systems & Web Engineering');
        $heading = htmlspecialchars($section['title'] ?? 'ABOUT ME');
        $subtitle = htmlspecialchars($section['subtitle'] ?? 'PROFILE // DOSSIER');

        return <<<HTML
        <div class="hud-profile-grid">
            <div class="hud-profile-avatar-wrap">
                <img src="{$avatar}" alt="{$fullName}" class="hud-profile-avatar">
                <div class="hud-profile-telemetry">
                    <span class="telemetry-badge"><span class="dot-live"></span> {$status}</span>
                    <span class="telemetry-meta">LOC: {$location}</span>
                </div>
            </div>
            <div class="hud-profile-details">
                <span class="hud-subtitle">// {$subtitle}</span>
                <h2 class="hud-heading">{$heading}</h2>
                <div class="hud-profile-role">{$fullName} &bull; <span class="text-accent">{$title}</span></div>
                <p class="hud-profile-tagline">"{$tagline}"</p>
                <div class="hud-profile-bio">{$bio}</div>
            </div>
        </div>
HTML;
    }
}
