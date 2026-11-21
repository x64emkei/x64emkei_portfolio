<?php
declare(strict_types=1);

/**
 * Application Routing Registry
 */

use App\Controllers\HomeController;
use App\Controllers\ContactController;
use App\Controllers\ApiController;
use App\Controllers\Admin\AuthController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\ProfileController;
use App\Controllers\Admin\ProjectsController;
use App\Controllers\Admin\SkillsController;
use App\Controllers\Admin\ExperienceController;
use App\Controllers\Admin\EducationController;
use App\Controllers\Admin\ServicesController;
use App\Controllers\Admin\HardwareController;
use App\Controllers\Admin\CertificationsController;
use App\Controllers\Admin\SocialLinksController;
use App\Controllers\Admin\MediaController;
use App\Controllers\Admin\MessagesController;
use App\Controllers\Admin\SettingsController;
use App\Services\Router;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Middleware\SecurityHeadersMiddleware;

$router = new Router();

// ==========================================
// 1. PUBLIC ROUTES
// ==========================================
$router->get('/', [HomeController::class, 'index']);
$router->post('contact', [ContactController::class, 'submit'], [CsrfMiddleware::class]);

// API Endpoints for dynamic client modals & filters
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
// 3. ADMIN DASHBOARD & CMS ROUTES (PROTECTED)
// ==========================================
$router->get('admin', [DashboardController::class, 'index'], [AuthMiddleware::class]);
$router->get('admin/dashboard', [DashboardController::class, 'index'], [AuthMiddleware::class]);

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

return $router;
