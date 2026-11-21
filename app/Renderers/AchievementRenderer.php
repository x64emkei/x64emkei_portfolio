<?php
declare(strict_types=1);

namespace App\Renderers;

class AchievementRenderer
{
    public static function render(array $achievements, array $section = []): string
    {
        if (empty($achievements)) {
            return '<div class="hud-empty-telemetry">// NO ACHIEVEMENTS OR HONORS LOGGED</div>';
        }

        $heading = htmlspecialchars($section['title'] ?? 'ACHIEVEMENTS & AWARDS');
        $subtitle = htmlspecialchars($section['subtitle'] ?? 'HONORS & RECOGNITIONS');
        $intro = !empty($section['intro_text']) ? '<p class="section-intro">' . nl2br(htmlspecialchars($section['intro_text'])) . '</p>' : '';

        $cardsHtml = '';
        foreach ($achievements as $ach) {
            $title = htmlspecialchars($ach['title']);
            $issuer = htmlspecialchars($ach['issuer'] ?? '');
            $date = htmlspecialchars($ach['award_date'] ?? '');
            $category = htmlspecialchars($ach['category'] ?? 'Academic');
            $desc = !empty($ach['description']) ? '<p class="achieve-desc">' . nl2br(htmlspecialchars($ach['description'])) . '</p>' : '';
            $verifyLink = !empty($ach['verification_url']) ? '<a href="' . htmlspecialchars($ach['verification_url']) . '" target="_blank" class="achieve-link">[RECORD &nearr;]</a>' : '';

            $cardsHtml .= <<<HTML
            <div class="achievement-card">
                <div class="achieve-top">
                    <span class="achieve-category">// {$category}</span>
                    <span class="achieve-date">{$date}</span>
                </div>
                <h3 class="achieve-title">{$title}</h3>
                <div class="achieve-issuer">CONFERRED BY: {$issuer}</div>
                {$desc}
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
        <div class="achievements-grid">
            {$cardsHtml}
        </div>
HTML;
    }
}
