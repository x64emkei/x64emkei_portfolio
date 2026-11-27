<?php
declare(strict_types=1);

namespace App\Services;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

final class BirthdayService
{
    public static function state(?DateTimeInterface $clock = null): array
    {
        $config = require dirname(__DIR__, 2) . '/config/app.php';
        $birthday = $config['birthday'] ?? [];
        $timezone = new DateTimeZone((string) ($birthday['timezone'] ?? $config['timezone'] ?? 'Asia/Manila'));
        $now = $clock === null
            ? new DateTimeImmutable('now', $timezone)
            : (new DateTimeImmutable($clock->format('c')))->setTimezone($timezone);
        $active = (int) $now->format('n') === (int) ($birthday['month'] ?? 7)
            && (int) $now->format('j') === (int) ($birthday['day'] ?? 20);

        return [
            'active' => $active,
            'greeting' => (string) ($birthday['greeting'] ?? "HEY THERE! TODAY'S A SPECIAL DAY!"),
            'headline' => (string) ($birthday['headline'] ?? "IT'S MY BIRTHDAY! 🎂"),
            'poke_enabled' => (bool) ($birthday['poke_enabled'] ?? true),
            'timezone' => $timezone->getName(),
        ];
    }
}
