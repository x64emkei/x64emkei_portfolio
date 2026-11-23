<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Profile;
use App\Models\Project;
use App\Models\HardwareNode;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Certification;
use App\Models\Achievement;
use App\Models\Service;
use App\Models\SocialLink;
use App\Models\SiteSetting;
use App\Models\PortfolioSection;
use App\Services\ViewRenderer;
use App\Services\HttpException;

class HomeController
{
    public function index(): void
    {
        $defaultProfile = [
            'full_name' => 'Michael Benedict Ordenes',
            'title' => 'Computer Science Student, IT Enthusiast & Developer',
            'tagline' => 'Architecting resilient software systems and high-performance applications.',
            'bio_short' => 'Computer Science student and systems developer.',
            'bio_full' => '',
            'avatar_url' => 'images/me_2.png',
            'cover_url' => 'images/carousel-workspace.jpg',
            'location' => 'Laguna, Philippines',
            'availability_status' => 'Available for Systems & Web Engineering',
            'resume_url' => '#contact',
            'email' => 'mordenes@acm.org'
        ];

        try { $profile = Profile::get() ?: $defaultProfile; } catch (\Throwable) { $profile = $defaultProfile; }
        try { $projects = Project::getPublished(); } catch (\Throwable) { $projects = []; }
        try { $hardwareNodes = HardwareNode::getPublished(); } catch (\Throwable) { $hardwareNodes = []; }
        try { $skillsGrouped = Skill::getPublishedGrouped(); } catch (\Throwable) { $skillsGrouped = []; }
        try { $experiences = Experience::getPublished(); } catch (\Throwable) { $experiences = []; }
        try { $education = Education::getPublished(); } catch (\Throwable) { $education = []; }
        try { $certifications = Certification::getPublished(); } catch (\Throwable) { $certifications = []; }
        try { $achievements = Achievement::getPublished(); } catch (\Throwable) { $achievements = []; }
        try { $services = Service::getPublished(); } catch (\Throwable) { $services = []; }
        try { $socialLinks = SocialLink::getPublished(); } catch (\Throwable) { $socialLinks = []; }
        try { $settings = SiteSetting::getAllKeyed(); } catch (\Throwable) { $settings = []; }
        try { $sections = PortfolioSection::allKeyed(); } catch (\Throwable) { $sections = []; }

        $metaTitle = $settings['site_title'] ?? ($profile['full_name'] . ' | ' . $profile['title']);
        $metaDesc = $settings['meta_description'] ?? $profile['tagline'];
        $metaKeywords = $settings['meta_keywords'] ?? 'Michael Benedict Ordenes, x64emkei, developer portfolio';
        $siteUrl = rtrim($settings['primary_domain'] ?? 'https://x64emkei.dpdns.org', '/');

        $viewData = [
            'profile' => $profile,
            'projects' => $projects,
            'hardwareNodes' => $hardwareNodes,
            'skillsGrouped' => $skillsGrouped,
            'experiences' => $experiences,
            'education' => $education,
            'certifications' => $certifications,
            'achievements' => $achievements,
            'services' => $services,
            'socialLinks' => $socialLinks,
            'settings' => $settings,
            'sections' => $sections,
            'metaTitle' => $metaTitle,
            'metaDesc' => $metaDesc,
            'metaKeywords' => $metaKeywords,
            'siteUrl' => $siteUrl,
        ];

        $renderer = new ViewRenderer();
        echo $renderer->render('public.layout', $viewData);
    }

    public function project(string $slug): void
    {
        $project = Project::findBySlug($slug);
        if (!$project || empty($project['is_published'])) {
            throw new HttpException(404, "Project dossier for '{$slug}' could not be located in telemetry archive.");
        }

        $renderer = new ViewRenderer();
        echo $renderer->render('public.project_detail', [
            'project' => $project
        ]);
    }
}
