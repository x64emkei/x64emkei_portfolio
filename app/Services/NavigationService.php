<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\SiteSetting;

class NavigationService
{
    public const SETTING_KEY = 'site_navigation_json';

    public static function getDefaults(): array
    {
        return [
            'home' => [
                'id' => 'home',
                'label' => 'Home',
                'route' => '/',
                'enabled' => true,
                'children' => []
            ],
            'about' => [
                'id' => 'about',
                'label' => 'About',
                'route' => '/about',
                'enabled' => true,
                'children' => [
                    ['id' => 'biography', 'label' => 'Biography', 'route' => '/about#biography', 'enabled' => true],
                    ['id' => 'education', 'label' => 'Education', 'route' => '/about#education', 'enabled' => true],
                    ['id' => 'skills', 'label' => 'Skills', 'route' => '/about#skills', 'enabled' => true],
                    ['id' => 'experience', 'label' => 'Experience & Affiliations', 'route' => '/about#experience', 'enabled' => true],
                    ['id' => 'certifications', 'label' => 'Certifications & Achievements', 'route' => '/about#certifications', 'enabled' => true],
                ]
            ],
            'work' => [
                'id' => 'work',
                'label' => 'Work',
                'route' => '/work',
                'enabled' => true,
                'children' => [
                    ['id' => 'portfolio', 'label' => 'Portfolio & Projects', 'route' => '/work#portfolio', 'enabled' => true],
                    ['id' => 'services', 'label' => 'Services', 'route' => '/work#services', 'enabled' => true],
                    ['id' => 'laboratory', 'label' => 'Technical Laboratory', 'route' => '/work#laboratory', 'enabled' => true],
                    ['id' => 'hardware', 'label' => 'Hardware Archive', 'route' => '/work#hardware', 'enabled' => true],
                ]
            ],
            'journal' => [
                'id' => 'journal',
                'label' => 'Journal',
                'route' => '/journal',
                'enabled' => true,
                'children' => [
                    ['id' => 'blog', 'label' => 'Blog', 'route' => '/journal#blog', 'enabled' => true],
                    ['id' => 'tutorials', 'label' => 'Tutorials & Guides', 'route' => '/journal#tutorials', 'enabled' => true],
                    ['id' => 'technical-notes', 'label' => 'Technical Notes', 'route' => '/journal#technical-notes', 'enabled' => true],
                    ['id' => 'research', 'label' => 'Research & Insights', 'route' => '/journal#research', 'enabled' => true],
                    ['id' => 'ai-manifesto', 'label' => 'AI Manifesto', 'route' => '/journal#ai-manifesto', 'enabled' => true],
                ]
            ],
            'contact' => [
                'id' => 'contact',
                'label' => 'Contact',
                'route' => '/contact',
                'enabled' => true,
                'children' => [
                    ['id' => 'information', 'label' => 'Contact Information', 'route' => '/contact#information', 'enabled' => true],
                    ['id' => 'inquiry', 'label' => 'Send an Inquiry', 'route' => '/contact#inquiry', 'enabled' => true],
                    ['id' => 'social', 'label' => 'Social Links', 'route' => '/contact#social', 'enabled' => true],
                ]
            ],
            'admin' => [
                'id' => 'admin',
                'label' => 'Admin',
                'route' => '/admin/dashboard',
                'enabled' => true,
                'is_protected' => true,
                'children' => [
                    ['id' => 'dashboard', 'label' => 'Dashboard', 'route' => '/admin/dashboard', 'enabled' => true],
                    ['id' => 'content', 'label' => 'Content Management', 'route' => '/admin/content', 'enabled' => true],
                    ['id' => 'media', 'label' => 'Media Library', 'route' => '/admin/media', 'enabled' => true],
                    ['id' => 'settings', 'label' => 'Website Settings', 'route' => '/admin/settings', 'enabled' => true],
                    ['id' => 'system', 'label' => 'System Management', 'route' => '/admin/system', 'enabled' => true],
                ]
            ],
        ];
    }

    public static function getAll(): array
    {
        try {
            $json = SiteSetting::get(self::SETTING_KEY);
        } catch (\Throwable) {
            return self::getDefaults();
        }

        if (!$json) {
            return self::getDefaults();
        }

        $decoded = json_decode($json, true);
        if (!is_array($decoded) || empty($decoded)) {
            return self::getDefaults();
        }

        // Merge defaults to preserve required architecture while respecting customizations
        $defaults = self::getDefaults();
        foreach ($defaults as $key => $defaultItem) {
            if (isset($decoded[$key])) {
                $defaults[$key]['label'] = strip_tags(trim((string)($decoded[$key]['label'] ?? $defaultItem['label'])));
                $defaults[$key]['enabled'] = (bool)($decoded[$key]['enabled'] ?? true);
                
                if (!empty($defaultItem['children'])) {
                    $savedChildren = $decoded[$key]['children'] ?? [];
                    $mergedChildren = [];
                    foreach ($defaultItem['children'] as $child) {
                        $childId = $child['id'];
                        // Find customized child
                        $found = null;
                        foreach ($savedChildren as $sc) {
                            if (($sc['id'] ?? '') === $childId) {
                                $found = $sc;
                                break;
                            }
                        }
                        if ($found) {
                            $child['label'] = strip_tags(trim((string)($found['label'] ?? $child['label'])));
                            $child['enabled'] = (bool)($found['enabled'] ?? true);
                        }
                        $mergedChildren[] = $child;
                    }
                    $defaults[$key]['children'] = $mergedChildren;
                }
            }
        }

        return $defaults;
    }

    public static function getPublicNavigation(): array
    {
        $all = self::getAll();
        $publicNav = [];

        foreach ($all as $key => $item) {
            // Strictly exclude admin and protected items from the public navigation sidebar
            if ($key === 'admin' || !empty($item['is_protected']) || empty($item['enabled'])) {
                continue;
            }

            $item['children'] = array_values(array_filter($item['children'] ?? [], fn($c) => !empty($c['enabled'])));
            $publicNav[$key] = $item;
        }

        return $publicNav;
    }

    public static function save(array $customNav): bool
    {
        // Sanitize and validate
        $clean = [];
        $defaults = self::getDefaults();

        foreach ($defaults as $key => $def) {
            $incoming = $customNav[$key] ?? [];
            $cleanItem = [
                'id' => $key,
                'label' => strip_tags(trim((string)($incoming['label'] ?? $def['label']))),
                'route' => $def['route'],
                'enabled' => isset($incoming['enabled']) ? (bool)$incoming['enabled'] : true,
                'is_protected' => !empty($def['is_protected']),
                'children' => []
            ];

            if ($cleanItem['label'] === '') {
                $cleanItem['label'] = $def['label'];
            }

            if (!empty($def['children'])) {
                $incomingChildren = $incoming['children'] ?? [];
                foreach ($def['children'] as $childDef) {
                    $cId = $childDef['id'];
                    $inChild = $incomingChildren[$cId] ?? null;
                    $cLabel = $inChild ? strip_tags(trim((string)($inChild['label'] ?? $childDef['label']))) : $childDef['label'];
                    $cEnabled = $inChild ? (isset($inChild['enabled']) ? (bool)$inChild['enabled'] : true) : true;
                    if ($cLabel === '') {
                        $cLabel = $childDef['label'];
                    }

                    $cleanItem['children'][] = [
                        'id' => $cId,
                        'label' => $cLabel,
                        'route' => $childDef['route'],
                        'enabled' => $cEnabled
                    ];
                }
            }

            $clean[$key] = $cleanItem;
        }

        return SiteSetting::set(self::SETTING_KEY, json_encode($clean, JSON_PRETTY_PRINT), 'navigation', 'Customized 6-category navigation architecture');
    }

    public static function resetDefaults(): bool
    {
        return SiteSetting::set(self::SETTING_KEY, json_encode(self::getDefaults(), JSON_PRETTY_PRINT), 'navigation', 'Default 6-category navigation architecture');
    }
}
