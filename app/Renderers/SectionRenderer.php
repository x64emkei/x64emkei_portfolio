<?php
declare(strict_types=1);

namespace App\Renderers;

use App\Models\PortfolioSection;

class SectionRenderer
{
    private array $sections;

    public function __construct(array $sections = [])
    {
        if (!empty($sections)) {
            $this->sections = $sections;
        } else {
            try {
                $this->sections = PortfolioSection::allKeyed();
            } catch (\Throwable $e) {
                $this->sections = [];
            }
        }
    }

    public function isVisible(string $key, $data = null): bool
    {
        $sec = $this->sections[$key] ?? null;
        if (!$sec) {
            return true;
        }

        if (empty($sec['is_enabled'])) {
            return false;
        }

        if (!empty($sec['hide_if_empty']) && empty($data)) {
            return false;
        }

        return true;
    }

    public function getSection(string $key): array
    {
        return $this->sections[$key] ?? [
            'section_key' => $key,
            'title' => strtoupper($key),
            'subtitle' => 'TELEMETRY NODE',
            'intro_text' => '',
            'is_enabled' => 1,
            'display_order' => 0,
            'layout_variation' => 'default',
            'hide_if_empty' => 1
        ];
    }
}
