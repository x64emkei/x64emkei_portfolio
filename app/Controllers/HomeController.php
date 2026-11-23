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
use App\Models\Article;
use App\Services\ViewRenderer;
use App\Services\HttpException;

class HomeController
{
    private function getCommonData(): array
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
        try { $latestArticles = Article::getPublished(3); } catch (\Throwable) { $latestArticles = []; }

        $metaTitle = $settings['site_title'] ?? ($profile['full_name'] . ' | ' . $profile['title']);
        $metaDesc = $settings['meta_description'] ?? $profile['tagline'];
        $metaKeywords = $settings['meta_keywords'] ?? 'Michael Benedict Ordenes, x64emkei, developer portfolio';
        $siteUrl = rtrim($settings['primary_domain'] ?? 'https://welcome.x64emkei.dpdns.org', '/');

        return [
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
            'latestArticles' => $latestArticles,
            'metaTitle' => $metaTitle,
            'metaDesc' => $metaDesc,
            'metaKeywords' => $metaKeywords,
            'siteUrl' => $siteUrl,
        ];
    }

    public function index(): void
    {
        $data = $this->getCommonData();
        $renderer = new ViewRenderer();
        echo $renderer->render('public.layout', $data);
    }

    public function about(?string $sub = null): void
    {
        $data = $this->getCommonData();
        $data['activeNav'] = 'about';
        $data['activeSub'] = $sub ?? 'biography';
        $renderer = new ViewRenderer();
        echo $renderer->render('public.about', $data);
    }

    public function work(?string $sub = null): void
    {
        $data = $this->getCommonData();
        $data['activeNav'] = 'work';
        $data['activeSub'] = $sub ?? 'projects';
        $renderer = new ViewRenderer();
        echo $renderer->render('public.work', $data);
    }

    public function workOrProject(string $slug): void
    {
        $knownSubsections = ['projects', 'services', 'laboratory', 'hardware', 'interests'];
        if (in_array(strtolower($slug), $knownSubsections, true)) {
            $this->work(strtolower($slug));
            return;
        }

        $this->project($slug);
    }

    public function contact(): void
    {
        $data = $this->getCommonData();
        $data['activeNav'] = 'contact';
        $renderer = new ViewRenderer();
        echo $renderer->render('public.contact', $data);
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
