<?php
declare(strict_types=1);

/**
 * Application Routing Registry
 */

use App\Controllers\HomeController;
use App\Controllers\JournalController;
use App\Controllers\ContactController;
use App\Controllers\ApiController;
use App\Controllers\Admin\AuthController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\ProfileController;
use App\Controllers\Admin\ProjectsController;
use App\Controllers\Admin\ArticlesController;
use App\Controllers\Admin\UsersController;
use App\Controllers\Admin\SkillsController;
use App\Controllers\Admin\ExperienceController;
use App\Controllers\Admin\EducationController;
use App\Controllers\Admin\ServicesController;
use App\Controllers\Admin\HardwareController;
use App\Controllers\Admin\CertificationsController;
use App\Controllers\Admin\AchievementsController;
use App\Controllers\Admin\SectionsController;
use App\Controllers\Admin\SocialLinksController;
use App\Controllers\Admin\MediaController;
use App\Controllers\Admin\MessagesController;
use App\Controllers\Admin\SettingsController;
use App\Services\Router;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;

$router = new Router();

// ==========================================
// 1. PUBLIC PRIMARY & CHILD ROUTES
// ==========================================

// 1. HOME
$router->get('/', [HomeController::class, 'index']);

// 2. ABOUT & CHILD ROUTES
$router->get('about', [HomeController::class, 'about']);
$router->get('about/biography', [HomeController::class, 'aboutBiography']);
$router->get('about/education', [HomeController::class, 'aboutEducation']);
$router->get('about/skills', [HomeController::class, 'aboutSkills']);
$router->get('about/experience', [HomeController::class, 'aboutExperience']);
$router->get('about/certifications', [HomeController::class, 'aboutCertifications']);
$router->get('about/{sub}', [HomeController::class, 'about']);

// 3. WORK & CHILD ROUTES
$router->get('work', [HomeController::class, 'work']);
$router->get('work/projects', [HomeController::class, 'workProjects']);
$router->get('work/services', [HomeController::class, 'workServices']);
$router->get('work/laboratory', [HomeController::class, 'workLaboratory']);
$router->get('work/hardware', [HomeController::class, 'workHardware']);
$router->get('work/{slug}', [HomeController::class, 'workOrProject']);
$router->get('explore', [HomeController::class, 'work']);
$router->get('explore/{slug}', [HomeController::class, 'workOrProject']);
$router->get('project/{slug}', [HomeController::class, 'project']);

// 4. JOURNAL & CHILD ROUTES
$router->get('journal', [JournalController::class, 'index']);
$router->get('journal/blog', [JournalController::class, 'blog']);
$router->get('journal/tutorials', [JournalController::class, 'tutorials']);
$router->get('journal/technical-notes', [JournalController::class, 'technicalNotes']);
$router->get('journal/research', [JournalController::class, 'research']);
$router->get('journal/ai-manifesto', [JournalController::class, 'manifesto']);
$router->get('journal/manifesto', [JournalController::class, 'manifesto']);
$router->get('journal/category/{slug}', [JournalController::class, 'category']);
$router->get('journal/tag/{slug}', [JournalController::class, 'tag']);
$router->get('journal/{slug}', [JournalController::class, 'show']);

// 5. CONTACT & CHILD ROUTES
$router->get('contact', [HomeController::class, 'contact']);
$router->get('contact/information', [HomeController::class, 'contactInformation']);
$router->get('contact/inquiry', [HomeController::class, 'contactInquiry']);
$router->get('contact/social', [HomeController::class, 'contactSocial']);
$router->post('contact', [ContactController::class, 'submit'], [CsrfMiddleware::class]);

$router->get('health', [ApiController::class, 'health']);

// API Endpoints for dynamic client telemetry & modals
$router->get('api/projects', [ApiController::class, 'projects']);
$router->get('api/project/{slug}', [ApiController::class, 'project']);
$router->get('api/hardware/{id}', [ApiController::class, 'hardware']);

// ==========================================
// 2. ADMIN AUTHENTICATION & SETUP ROUTES
// ==========================================
$router->get('admin/login', [AuthController::class, 'login']);
$router->post('admin/login', [AuthController::class, 'authenticate'], [CsrfMiddleware::class]);
$router->get('admin/setup', [AuthController::class, 'setup']);
$router->post('admin/setup', [AuthController::class, 'createFirstAdmin'], [CsrfMiddleware::class]);
$router->get('admin/logout', [AuthController::class, 'logout']);
$router->post('admin/logout', [AuthController::class, 'logout'], [CsrfMiddleware::class]);

// ==========================================
// 3. ADMIN DASHBOARD & CMS MODULES (PROTECTED)
// ==========================================
$router->get('admin', [DashboardController::class, 'index'], [AuthMiddleware::class]);
$router->get('admin/dashboard', [DashboardController::class, 'index'], [AuthMiddleware::class]);
$router->get('admin/content', [DashboardController::class, 'content'], [AuthMiddleware::class]);
$router->get('admin/system', [DashboardController::class, 'system'], [AuthMiddleware::class]);
$router->get('admin/system-health', [DashboardController::class, 'systemHealth'], [AuthMiddleware::class]);
$router->get('admin/database/sync', [DashboardController::class, 'syncDatabase'], [AuthMiddleware::class]);
$router->post('admin/database/sync', [DashboardController::class, 'syncDatabase'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Articles (Journal CMS)
$router->get('admin/articles', [ArticlesController::class, 'index'], [AuthMiddleware::class]);
$router->get('admin/articles/create', [ArticlesController::class, 'create'], [AuthMiddleware::class]);
$router->post('admin/articles/create', [ArticlesController::class, 'store'], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->get('admin/articles/{id}/edit', [ArticlesController::class, 'edit'], [AuthMiddleware::class]);
$router->post('admin/articles/{id}/edit', [ArticlesController::class, 'update'], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->post('admin/articles/{id}/delete', [ArticlesController::class, 'delete'], [AuthMiddleware::class, CsrfMiddleware::class]);

// User Management & RBAC
$router->get('admin/users', [UsersController::class, 'index'], [AuthMiddleware::class]);
$router->post('admin/users', [UsersController::class, 'store'], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->post('admin/users/{id}/role', [UsersController::class, 'updateRole'], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->post('admin/users/{id}/toggle', [UsersController::class, 'toggleStatus'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Portfolio Sections Architecture
$router->get('admin/sections', [SectionsController::class, 'index'], [AuthMiddleware::class]);
$router->post('admin/sections/{id}/update', [SectionsController::class, 'update'], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->post('admin/sections/{id}/toggle', [SectionsController::class, 'toggle'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Profile
$router->get('admin/profile', [ProfileController::class, 'edit'], [AuthMiddleware::class]);
$router->post('admin/profile', [ProfileController::class, 'update'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Projects CRUD
$router->get('admin/projects', [ProjectsController::class, 'index'], [AuthMiddleware::class]);
$router->get('admin/projects/create', [ProjectsController::class, 'create'], [AuthMiddleware::class]);
$router->post('admin/projects/create', [ProjectsController::class, 'store'], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->get('admin/projects/{id}/edit', [ProjectsController::class, 'edit'], [AuthMiddleware::class]);
$router->post('admin/projects/{id}/edit', [ProjectsController::class, 'update'], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->post('admin/projects/{id}/delete', [ProjectsController::class, 'delete'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Skills CRUD
$router->get('admin/skills', [SkillsController::class, 'index'], [AuthMiddleware::class]);
$router->post('admin/skills', [SkillsController::class, 'store'], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->post('admin/skills/{id}/delete', [SkillsController::class, 'delete'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Experience CRUD
$router->get('admin/experience', [ExperienceController::class, 'index'], [AuthMiddleware::class]);
$router->post('admin/experience', [ExperienceController::class, 'store'], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->post('admin/experience/{id}/delete', [ExperienceController::class, 'delete'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Education CRUD
$router->get('admin/education', [EducationController::class, 'index'], [AuthMiddleware::class]);
$router->post('admin/education', [EducationController::class, 'store'], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->post('admin/education/{id}/delete', [EducationController::class, 'delete'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Services CRUD
$router->get('admin/services', [ServicesController::class, 'index'], [AuthMiddleware::class]);
$router->post('admin/services', [ServicesController::class, 'store'], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->post('admin/services/{id}/delete', [ServicesController::class, 'delete'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Hardware Lab Archive CRUD
$router->get('admin/hardware', [HardwareController::class, 'index'], [AuthMiddleware::class]);
$router->post('admin/hardware', [HardwareController::class, 'store'], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->post('admin/hardware/{id}/delete', [HardwareController::class, 'delete'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Certifications CRUD
$router->get('admin/certifications', [CertificationsController::class, 'index'], [AuthMiddleware::class]);
$router->post('admin/certifications', [CertificationsController::class, 'store'], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->post('admin/certifications/{id}/delete', [CertificationsController::class, 'delete'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Achievements CRUD
$router->get('admin/achievements', [AchievementsController::class, 'index'], [AuthMiddleware::class]);
$router->post('admin/achievements', [AchievementsController::class, 'store'], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->post('admin/achievements/{id}/update', [AchievementsController::class, 'update'], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->post('admin/achievements/{id}/delete', [AchievementsController::class, 'delete'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Social Links CRUD
$router->get('admin/social', [SocialLinksController::class, 'index'], [AuthMiddleware::class]);
$router->post('admin/social', [SocialLinksController::class, 'store'], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->post('admin/social/{id}/delete', [SocialLinksController::class, 'delete'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Media Manager
$router->get('admin/media', [MediaController::class, 'index'], [AuthMiddleware::class]);
$router->post('admin/media/upload', [MediaController::class, 'upload'], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->post('admin/media/{id}/delete', [MediaController::class, 'delete'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Messages Inbox
$router->get('admin/messages', [MessagesController::class, 'index'], [AuthMiddleware::class]);
$router->post('admin/messages/{id}/read', [MessagesController::class, 'toggleRead'], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->post('admin/messages/{id}/archive', [MessagesController::class, 'archive'], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->post('admin/messages/{id}/delete', [MessagesController::class, 'delete'], [AuthMiddleware::class, CsrfMiddleware::class]);

// System & SEO Settings
$router->get('admin/settings', [SettingsController::class, 'index'], [AuthMiddleware::class]);
$router->post('admin/settings', [SettingsController::class, 'update'], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->get('admin/settings/navigation', [SettingsController::class, 'navigation'], [AuthMiddleware::class]);
$router->post('admin/settings/navigation', [SettingsController::class, 'updateNavigation'], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->post('admin/settings/navigation/reset', [SettingsController::class, 'resetNavigation'], [AuthMiddleware::class, CsrfMiddleware::class]);

return $router;
