<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Profile;
use App\Models\Project;
use App\Models\HardwareNode;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Service;
use App\Models\SocialLink;
use App\Models\SiteSetting;
use App\Services\ViewRenderer;

class HomeController
{
    public function index(): void
    {
        $profile = Profile::get() ?: [
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

        $projects = Project::getPublished();
        $hardwareNodes = HardwareNode::getPublished();
        $skillsGrouped = Skill::getPublishedGrouped();
        $experiences = Experience::getPublished();
        $education = Education::getPublished();
        $services = Service::getPublished();
        $socialLinks = SocialLink::getPublished();
        $settings = SiteSetting::getAllKeyed();

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
            'services' => $services,
            'socialLinks' => $socialLinks,
            'settings' => $settings,
            'metaTitle' => $metaTitle,
            'metaDesc' => $metaDesc,
            'metaKeywords' => $metaKeywords,
            'siteUrl' => $siteUrl,
        ];

        $renderer = new ViewRenderer();
        echo $renderer->render('public.layout', $viewData);
    }
}
