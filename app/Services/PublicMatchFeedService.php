<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PublicMatchFeedService
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function getMatches(string $day = 'next7days'): array
    {
        $day = in_array($day, ['today', 'tomorrow', 'next7days'], true) ? $day : 'next7days';

        $competition = (string) config('services.match_feed.competition', 'PL');
        $cacheKey = "public.matches.feed.{$competition}.{$day}";
        $ttlMinutes = (int) config('services.match_feed.cache_minutes', 10);

        return Cache::remember($cacheKey, now()->addMinutes($ttlMinutes), function () use ($day): array {
            $baseUrl = rtrim((string) config('services.match_feed.base_url'), '/');
            $apiKey = (string) config('services.match_feed.key');
            $competition = (string) config('services.match_feed.competition', 'PL');
            [$dateFrom, $dateTo] = $this->resolveDateRange($day);

            if ($apiKey === '' || $baseUrl === '') {
                return [];
            }

            $response = Http::timeout(5)
                ->withHeaders(['X-Auth-Token' => $apiKey])
                ->get("{$baseUrl}/competitions/{$competition}/matches", [
                    'dateFrom' => $dateFrom,
                    'dateTo' => $dateTo,
                ]);

            if (! $response->successful()) {
                return [];
            }

            $matches = $response->json('matches', []);

            return collect($matches)
                ->map(function (array $match): array {
                    $utcDate = data_get($match, 'utcDate');

                    return [
                        'competition' => (string) data_get($match, 'competition.name', 'Competition'),
                        'home' => (string) data_get($match, 'homeTeam.name', 'Team A'),
                        'away' => (string) data_get($match, 'awayTeam.name', 'Team B'),
                        'status' => (string) data_get($match, 'status', 'SCHEDULED'),
                        'status_label' => $this->statusLabel((string) data_get($match, 'status', 'SCHEDULED')),
                        'score_home' => data_get($match, 'score.fullTime.home'),
                        'score_away' => data_get($match, 'score.fullTime.away'),
                        'kickoff' => $utcDate ? Carbon::parse($utcDate)->timezone(config('app.timezone'))->format('d M Y, H:i') : null,
                    ];
                })
                ->values()
                ->all();
        });
    }

    /**
     * @return array{0:string,1:string}
     */
    private function resolveDateRange(string $day): array
    {
        if ($day === 'next7days') {
            return [now()->toDateString(), now()->addDays(7)->toDateString()];
        }

        $base = $day === 'tomorrow'
            ? now()->addDay()->startOfDay()
            : now()->startOfDay();

        $date = $base->toDateString();

        return [$date, $date];
    }

    private function statusLabel(string $status): string
    {
        return match ($status) {
            'IN_PLAY', 'LIVE' => 'Live',
            'PAUSED' => 'Paused',
            'FINISHED' => 'FT',
            'SCHEDULED', 'TIMED' => 'Upcoming',
            default => ucfirst(strtolower(str_replace('_', ' ', $status))),
        };
    }
}
