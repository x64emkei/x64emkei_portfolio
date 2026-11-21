<?php
declare(strict_types=1);

/**
 * x64emkei.dev // Master Front Controller
 * Production-ready PHP Application Entry Point
 */

require_once __DIR__ . '/bootstrap/autoload.php';
require_once __DIR__ . '/bootstrap/app.php';

/** @var Router $router */
$router = require_once __DIR__ . '/routes/web.php';

$router->dispatch();
