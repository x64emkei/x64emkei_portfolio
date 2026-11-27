<?php
declare(strict_types=1);

namespace App\Services;

use Exception;

class ViewRenderer
{
    private string $viewsPath;

    public function __construct(?string $viewsPath = null)
    {
        $this->viewsPath = $viewsPath ?: dirname(__DIR__) . '/Views';
    }

    public function render(string $view, array $data = [], ?string $layout = null): string
    {
        $viewFile = $this->viewsPath . '/' . str_replace('.', '/', $view) . '.php';
        if (!file_exists($viewFile)) {
            throw new Exception("View template not found: {$view}");
        }

        $data['birthday'] ??= BirthdayService::state();

        // Extract variables to local scope
        extract($data, EXTR_SKIP);

        ob_start();
        include $viewFile;
        $content = ob_get_clean();

        if ($layout !== null) {
            $layoutFile = $this->viewsPath . '/' . str_replace('.', '/', $layout) . '.php';
            if (!file_exists($layoutFile)) {
                throw new Exception("Layout file not found: {$layout}");
            }
            ob_start();
            include $layoutFile;
            return ob_get_clean();
        }

        return $content;
    }
}
