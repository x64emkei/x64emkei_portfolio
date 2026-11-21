<?php
declare(strict_types=1);

namespace App\Renderers;

class ProjectRenderer
{
    public static function render(array $projects, array $section = []): string
    {
        if (empty($projects)) {
            return '<div class="hud-empty-telemetry">// NO ACTIVE PROJECT TELEMETRY CURRENTLY DEPLOYED</div>';
        }

        $heading = htmlspecialchars($section['title'] ?? 'PROJECTS MATRIX');
        $subtitle = htmlspecialchars($section['subtitle'] ?? 'DEPLOYED ARCHITECTURES & SYSTEMS');
        $intro = !empty($section['intro_text']) ? '<p class="section-intro">' . nl2br(htmlspecialchars($section['intro_text'])) . '</p>' : '';

        $cardsHtml = '';
        foreach ($projects as $proj) {
            $title = htmlspecialchars($proj['title']);
            $slug = htmlspecialchars($proj['slug']);
            $category = htmlspecialchars(strtoupper($proj['category']));
            $status = htmlspecialchars(strtoupper($proj['status']));
            $desc = htmlspecialchars($proj['short_description']);
            $thumb = htmlspecialchars($proj['thumbnail_url'] ?: 'images/cyber-bg.jpg');
            $detailUrl = htmlspecialchars(url('project/' . $slug));
            $demoUrl = !empty($proj['demo_url']) ? '<a href="' . htmlspecialchars($proj['demo_url']) . '" target="_blank" class="project-link">// DEMO</a>' : '';
            $repoUrl = !empty($proj['repo_url']) ? '<a href="' . htmlspecialchars($proj['repo_url']) . '" target="_blank" class="project-link">// CODE</a>' : '';

            $techs = is_array($proj['technologies']) ? $proj['technologies'] : explode(',', (string)($proj['technologies'] ?? ''));
            $tagsHtml = '';
            foreach ($techs as $t) {
                $t = trim($t);
                if ($t === '') continue;
                $tagsHtml .= '<span class="tech-tag">' . htmlspecialchars($t) . '</span> ';
            }

            $cardsHtml .= <<<HTML
            <article class="project-card" data-category="{$category}">
                <div class="project-card-image-wrap">
                    <img src="{$thumb}" alt="{$title}" loading="lazy" class="project-thumb">
                    <div class="project-status-overlay">{$status}</div>
                </div>
                <div class="project-card-content">
                    <span class="project-category">// {$category}</span>
                    <h3 class="project-title"><a href="{$detailUrl}">{$title}</a></h3>
                    <p class="project-desc">{$desc}</p>
                    <div class="project-tech-tags">{$tagsHtml}</div>
                    <div class="project-actions">
                        <a href="{$detailUrl}" class="project-link project-link-primary">VIEW DOSSIER &rarr;</a>
                        {$demoUrl}
                        {$repoUrl}
                    </div>
                </div>
            </article>
HTML;
        }

        return <<<HTML
        <div class="section-header">
            <span class="hud-subtitle">// {$subtitle}</span>
            <h2 class="hud-heading">{$heading}</h2>
            {$intro}
        </div>
        <div class="projects-grid">
            {$cardsHtml}
        </div>
HTML;
    }
}
