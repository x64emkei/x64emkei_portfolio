<?php
declare(strict_types=1);

namespace App\Renderers;

class ExperienceRenderer
{
    public static function render(array $experiences, array $section = []): string
    {
        if (empty($experiences)) {
            return '<div class="hud-empty-telemetry">// NO EXPERIENCE RECORDS LOGGED</div>';
        }

        $heading = htmlspecialchars($section['title'] ?? 'PROFESSIONAL TIMELINE');
        $subtitle = htmlspecialchars($section['subtitle'] ?? 'CAREER // OPERATIONS RECORD');
        $intro = !empty($section['intro_text']) ? '<p class="section-intro">' . nl2br(htmlspecialchars($section['intro_text'])) . '</p>' : '';

        $timelineHtml = '';
        foreach ($experiences as $exp) {
            $role = htmlspecialchars($exp['role_title']);
            $org = htmlspecialchars($exp['organization']);
            $period = htmlspecialchars($exp['period']);
            $type = htmlspecialchars($exp['employment_type'] ?? 'Professional');
            $loc = htmlspecialchars($exp['location'] ?? '');
            $desc = nl2br(htmlspecialchars($exp['description'] ?? ''));

            $achievements = is_array($exp['achievements']) ? $exp['achievements'] : (json_decode((string)($exp['achievements'] ?? '[]'), true) ?: []);
            $achHtml = '';
            if (!empty($achievements)) {
                $achHtml .= '<ul class="timeline-achievements">';
                foreach ($achievements as $ach) {
                    $achHtml .= '<li>' . htmlspecialchars((string)$ach) . '</li>';
                }
                $achHtml .= '</ul>';
            }

            $timelineHtml .= <<<HTML
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <span class="timeline-period">{$period} &bull; {$type}</span>
                    <h3 class="timeline-role">{$role}</h3>
                    <div class="timeline-org">{$org} {$loc}</div>
                    <div class="timeline-desc">{$desc}</div>
                    {$achHtml}
                </div>
            </div>
HTML;
        }

        return <<<HTML
        <div class="section-header">
            <span class="hud-subtitle">// {$subtitle}</span>
            <h2 class="hud-heading">{$heading}</h2>
            {$intro}
        </div>
        <div class="hud-timeline">
            {$timelineHtml}
        </div>
HTML;
    }
}
