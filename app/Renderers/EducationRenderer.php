<?php
declare(strict_types=1);

namespace App\Renderers;

class EducationRenderer
{
    public static function render(array $education, array $section = []): string
    {
        if (empty($education)) {
            return '<div class="hud-empty-telemetry">// NO ACADEMIC RECORDS LOGGED</div>';
        }

        $heading = htmlspecialchars($section['title'] ?? 'ACADEMIC FORMATION');
        $subtitle = htmlspecialchars($section['subtitle'] ?? 'HIGHER EDUCATION & SPECIALIZATIONS');
        $intro = !empty($section['intro_text']) ? '<p class="section-intro">' . nl2br(htmlspecialchars($section['intro_text'])) . '</p>' : '';

        $cardsHtml = '';
        foreach ($education as $edu) {
            $inst = htmlspecialchars($edu['institution']);
            $deg = htmlspecialchars($edu['degree']);
            $field = htmlspecialchars($edu['field_of_study']);
            $period = htmlspecialchars($edu['period']);
            $honors = !empty($edu['honors']) ? '<span class="edu-honors">' . htmlspecialchars($edu['honors']) . '</span>' : '';
            $desc = !empty($edu['description']) ? '<p class="edu-desc">' . nl2br(htmlspecialchars($edu['description'])) . '</p>' : '';

            $cardsHtml .= <<<HTML
            <div class="education-card">
                <div class="edu-badge">// ACADEMIC RECORD</div>
                <h3 class="edu-degree">{$deg}</h3>
                <div class="edu-field">{$field}</div>
                <div class="edu-institution">{$inst} &bull; <span class="edu-period">{$period}</span></div>
                {$honors}
                {$desc}
            </div>
HTML;
        }

        return <<<HTML
        <div class="section-header">
            <span class="hud-subtitle">// {$subtitle}</span>
            <h2 class="hud-heading">{$heading}</h2>
            {$intro}
        </div>
        <div class="education-grid">
            {$cardsHtml}
        </div>
HTML;
    }
}
