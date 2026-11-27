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
            $status = htmlspecialchars(strtoupper((string)($proj['operational_status'] ?? '')));
            $desc = htmlspecialchars($proj['tagline'] ?? $proj['description'] ?? '');
            $thumb = htmlspecialchars($proj['featured_image'] ?? '');
            $statusOverlay = $status !== '' ? '<div class="project-status-overlay">' . $status . '</div>' : '';
            $thumbMarkup = $thumb !== ''
                ? '<div class="project-card-image-wrap"><img src="' . $thumb . '" alt="' . $title . '" loading="lazy" class="project-thumb">' . $statusOverlay . '</div>'
                : '<div class="project-card-image-wrap project-card-image-empty" aria-hidden="true">' . $statusOverlay . '</div>';
            $detailUrl = htmlspecialchars(url('project/' . $slug));
            $demoUrl = !empty($proj['demo_url']) ? '<a href="' . htmlspecialchars($proj['demo_url']) . '" target="_blank" rel="noopener noreferrer" class="project-link">// DEMO</a>' : '';
            $repoUrl = !empty($proj['github_url']) ? '<a href="' . htmlspecialchars($proj['github_url']) . '" target="_blank" rel="noopener noreferrer" class="project-link">// CODE</a>' : '';

            $techs = json_decode((string)($proj['technologies_json'] ?? '[]'), true);
            $techs = is_array($techs) ? $techs : [];
            $tagsHtml = '';
            foreach ($techs as $t) {
                $t = trim($t);
                if ($t === '') continue;
                $tagsHtml .= '<span class="tech-tag">' . htmlspecialchars($t) . '</span> ';
            }

            $cardsHtml .= <<<HTML
            <article class="project-card" data-category="{$category}">
                {$thumbMarkup}
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
