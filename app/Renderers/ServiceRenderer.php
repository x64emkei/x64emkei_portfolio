<?php
declare(strict_types=1);

namespace App\Renderers;

class ServiceRenderer
{
    public static function render(array $services, array $section = []): string
    {
        if (empty($services)) {
            return '<div class="hud-empty-telemetry">// NO SERVICES CATALOG LOGGED</div>';
        }

        $heading = htmlspecialchars($section['title'] ?? 'SERVICES & OFFERINGS');
        $subtitle = htmlspecialchars($section['subtitle'] ?? 'ENGINEERING & CONSULTATION');
        $intro = !empty($section['intro_text']) ? '<p class="section-intro">' . nl2br(htmlspecialchars($section['intro_text'])) . '</p>' : '';

        $cardsHtml = '';
        foreach ($services as $srv) {
            $title = htmlspecialchars($srv['title']);
            $cat = htmlspecialchars($srv['category']);
            $desc = nl2br(htmlspecialchars($srv['description']));

            $caps = is_array($srv['capabilities_json']) ? $srv['capabilities_json'] : (json_decode((string)($srv['capabilities_json'] ?? '[]'), true) ?: []);
            $capsHtml = '';
            if (!empty($caps)) {
                $capsHtml .= '<ul class="service-capabilities">';
                foreach ($caps as $cap) {
                    $capsHtml .= '<li>' . htmlspecialchars((string)$cap) . '</li>';
                }
                $capsHtml .= '</ul>';
            }

            $cardsHtml .= <<<HTML
            <div class="service-card">
                <span class="service-cat">// {$cat}</span>
                <h3 class="service-title">{$title}</h3>
                <p class="service-desc">{$desc}</p>
                {$capsHtml}
            </div>
HTML;
        }

        return <<<HTML
        <div class="section-header">
            <span class="hud-subtitle">// {$subtitle}</span>
            <h2 class="hud-heading">{$heading}</h2>
            {$intro}
        </div>
        <div class="services-grid">
            {$cardsHtml}
        </div>
HTML;
    }
}
