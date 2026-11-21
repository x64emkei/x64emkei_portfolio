<?php
declare(strict_types=1);

namespace App\Renderers;

class HardwareRenderer
{
    public static function render(array $hardwareNodes, array $section = []): string
    {
        if (empty($hardwareNodes)) {
            return '<div class="hud-empty-telemetry">// NO HARDWARE ARCHIVE NODES LOGGED</div>';
        }

        $heading = htmlspecialchars($section['title'] ?? 'HARDWARE LAB ARCHIVE');
        $subtitle = htmlspecialchars($section['subtitle'] ?? 'LAB FLEET TELEMETRY & RETRO NODES');
        $intro = !empty($section['intro_text']) ? '<p class="section-intro">' . nl2br(htmlspecialchars($section['intro_text'])) . '</p>' : '';

        $cardsHtml = '';
        foreach ($hardwareNodes as $node) {
            $code = htmlspecialchars($node['node_code']);
            $form = htmlspecialchars($node['form_factor']);
            $name = htmlspecialchars($node['name']);
            $specs = htmlspecialchars($node['specs_summary']);
            $status = htmlspecialchars($node['status_label']);
            $oem = htmlspecialchars($node['oem_brand']);
            $sleeperClass = !empty($node['is_sleeper']) ? 'retro-card-sleeper' : '';
            $tagSleeper = !empty($node['is_sleeper']) ? 'tag-sleeper' : '';

            $cardsHtml .= <<<HTML
            <div class="retro-machine-card {$sleeperClass}">
                <div class="retro-card-top">
                    <span class="retro-sys-id">{$code}</span>
                    <span class="retro-form-tag {$tagSleeper}">{$form}</span>
                </div>
                <div class="retro-machine-content">
                    <div class="retro-machine-name">{$name}</div>
                    <div class="retro-machine-desc">{$specs}</div>
                </div>
                <div class="retro-status-bar">
                    <span class="retro-status-active"><span class="retro-status-dot"></span>{$status}</span>
                    <span class="retro-oem-tag">{$oem}</span>
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
        <div class="retro-machine-grid">
            {$cardsHtml}
        </div>
HTML;
    }
}
