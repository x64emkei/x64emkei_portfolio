<?php
declare(strict_types=1);

namespace App\Renderers;

class SkillsRenderer
{
    public static function render(array $skillsGrouped, array $section = []): string
    {
        if (empty($skillsGrouped)) {
            return '<div class="hud-empty-telemetry">// NO SKILLS TELEMETRY LOGGED</div>';
        }

        $heading = htmlspecialchars($section['title'] ?? 'TECHNICAL CAPABILITIES');
        $subtitle = htmlspecialchars($section['subtitle'] ?? 'ENGINEERING & ARCHITECTURE STACK');
        $intro = !empty($section['intro_text']) ? '<p class="section-intro">' . nl2br(htmlspecialchars($section['intro_text'])) . '</p>' : '';

        $groupsHtml = '';
        foreach ($skillsGrouped as $category => $skills) {
            $catTitle = htmlspecialchars(strtoupper($category));
            $itemsHtml = '';
            foreach ($skills as $skill) {
                $name = htmlspecialchars($skill['name']);
                $level = htmlspecialchars($skill['proficiency_level'] ?? 'Competent');
                $years = !empty($skill['years_experience']) ? ' (' . (int)$skill['years_experience'] . 'y)' : '';
                $itemsHtml .= <<<HTML
                <div class="skill-node">
                    <span class="skill-name">{$name}{$years}</span>
                    <span class="skill-level">{$level}</span>
                </div>
HTML;
            }

            $groupsHtml .= <<<HTML
            <div class="skills-category-box">
                <h4 class="skills-category-title">// {$catTitle}</h4>
                <div class="skills-category-nodes">
                    {$itemsHtml}
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
        <div class="skills-matrix-grid">
            {$groupsHtml}
        </div>
HTML;
    }
}
