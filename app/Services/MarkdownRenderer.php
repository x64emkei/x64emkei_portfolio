<?php
declare(strict_types=1);

namespace App\Services;

/**
 * Small, dependency-free Markdown renderer for article content.
 *
 * Article Markdown is escaped before formatting so authors can publish
 * headings, lists, quotes, links, code, and emphasis without introducing
 * arbitrary HTML or scripts.
 */
final class MarkdownRenderer
{
    public static function render(string $markdown): string
    {
        $markdown = str_replace(["\r\n", "\r"], "\n", trim($markdown));
        if ($markdown === '') {
            return '';
        }

        $lines = explode("\n", $markdown);
        $html = [];
        $paragraph = [];
        $listItems = [];
        $listType = null;
        $blockquote = [];
        $codeLines = [];
        $codeLanguage = '';
        $inCode = false;

        $flushParagraph = static function () use (&$html, &$paragraph): void {
            if ($paragraph === []) {
                return;
            }

            $html[] = '<p>' . self::inline(implode("\n", $paragraph)) . '</p>';
            $paragraph = [];
        };

        $flushList = static function () use (&$html, &$listItems, &$listType): void {
            if ($listItems === [] || $listType === null) {
                return;
            }

            $items = array_map(static fn(string $item): string => '<li>' . self::inline($item) . '</li>', $listItems);
            $html[] = '<' . $listType . '>' . implode('', $items) . '</' . $listType . '>';
            $listItems = [];
            $listType = null;
        };

        $flushBlockquote = static function () use (&$html, &$blockquote): void {
            if ($blockquote === []) {
                return;
            }

            $html[] = '<blockquote><p>' . self::inline(implode("\n", $blockquote)) . '</p></blockquote>';
            $blockquote = [];
        };

        foreach ($lines as $line) {
            if ($inCode) {
                if (preg_match('/^\s*```\s*$/', $line) === 1) {
                    $languageClass = $codeLanguage !== '' ? ' class="language-' . self::escape($codeLanguage) . '"' : '';
                    $html[] = '<pre><code' . $languageClass . '>' . self::escape(implode("\n", $codeLines)) . '</code></pre>';
                    $codeLines = [];
                    $codeLanguage = '';
                    $inCode = false;
                } else {
                    $codeLines[] = $line;
                }
                continue;
            }

            if (preg_match('/^\s*```\s*([A-Za-z0-9_+.#-]*)\s*$/', $line, $match) === 1) {
                $flushParagraph();
                $flushList();
                $flushBlockquote();
                $inCode = true;
                $codeLanguage = $match[1] ?? '';
                continue;
            }

            if (trim($line) === '') {
                $flushParagraph();
                $flushList();
                $flushBlockquote();
                continue;
            }

            if (preg_match('/^\s{0,3}(#{1,6})\s+(.+?)\s*#*\s*$/', $line, $match) === 1) {
                $flushParagraph();
                $flushList();
                $flushBlockquote();
                $level = strlen($match[1]);
                $html[] = '<h' . $level . '>' . self::inline($match[2]) . '</h' . $level . '>';
                continue;
            }

            if (preg_match('/^\s{0,3}((\*\s*){3,}|(-\s*){3,}|(_\s*){3,})$/', $line) === 1) {
                $flushParagraph();
                $flushList();
                $flushBlockquote();
                $html[] = '<hr>';
                continue;
            }

            if (preg_match('/^\s*>\s?(.*)$/', $line, $match) === 1) {
                $flushParagraph();
                $flushList();
                $blockquote[] = $match[1];
                continue;
            }

            if (preg_match('/^\s*[-*+]\s+(.+)$/', $line, $match) === 1) {
                $flushParagraph();
                $flushBlockquote();
                if ($listType !== 'ul') {
                    $flushList();
                    $listType = 'ul';
                }
                $listItems[] = $match[1];
                continue;
            }

            if (preg_match('/^\s*\d+[.)]\s+(.+)$/', $line, $match) === 1) {
                $flushParagraph();
                $flushBlockquote();
                if ($listType !== 'ol') {
                    $flushList();
                    $listType = 'ol';
                }
                $listItems[] = $match[1];
                continue;
            }

            $flushList();
            $flushBlockquote();
            $paragraph[] = $line;
        }

        if ($inCode) {
            $languageClass = $codeLanguage !== '' ? ' class="language-' . self::escape($codeLanguage) . '"' : '';
            $html[] = '<pre><code' . $languageClass . '>' . self::escape(implode("\n", $codeLines)) . '</code></pre>';
        }

        $flushParagraph();
        $flushList();
        $flushBlockquote();

        return implode("\n", $html);
    }

    private static function inline(string $text): string
    {
        $escaped = self::escape($text);
        $codeTokens = [];

        $escaped = preg_replace_callback('/`([^`\n]+)`/', static function (array $match) use (&$codeTokens): string {
            $token = '@@INLINECODE' . count($codeTokens) . '@@';
            $codeTokens[$token] = '<code>' . $match[1] . '</code>';
            return $token;
        }, $escaped) ?? $escaped;

        $escaped = preg_replace_callback('/\[([^\]]+)\]\(([^)\s]+)(?:\s+["\']([^"\']*)["\'])?\)/', static function (array $match): string {
            $href = self::safeUrl(html_entity_decode($match[2], ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            if ($href === null) {
                return $match[1];
            }

            $title = isset($match[3]) && $match[3] !== '' ? ' title="' . self::escape($match[3]) . '"' : '';
            return '<a href="' . self::escape($href) . '"' . $title . ' rel="noopener noreferrer">' . $match[1] . '</a>';
        }, $escaped) ?? $escaped;

        $escaped = preg_replace('/\*\*(.+?)\*\*|__(.+?)__/', '<strong>$1$2</strong>', $escaped) ?? $escaped;
        $escaped = preg_replace('/~~(.+?)~~/', '<del>$1</del>', $escaped) ?? $escaped;
        $escaped = preg_replace('/(?<!\*)\*([^*\n]+)\*(?!\*)|(?<!_)_([^_\n]+)_(?!_)/', '<em>$1$2</em>', $escaped) ?? $escaped;
        $escaped = preg_replace('/  \n/', '<br>\n', $escaped) ?? $escaped;

        foreach ($codeTokens as $token => $replacement) {
            $escaped = str_replace($token, $replacement, $escaped);
        }

        return $escaped;
    }

    private static function safeUrl(string $url): ?string
    {
        $url = trim($url);
        if ($url === '' || preg_match('/[\x00-\x1F\x7F]/', $url) === 1) {
            return null;
        }

        if (preg_match('/^(https?:\/\/|mailto:|\/|#)/i', $url) !== 1) {
            return null;
        }

        return $url;
    }

    private static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
