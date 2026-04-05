<?php

namespace App\Services;

use App\Models\MatchModel;
use Illuminate\Support\Facades\DB;

class MatchScoreService
{
    public function __construct(
        private readonly StandingService $standingService
    ) {
    }

    public function updateScore(MatchModel $match, ?int $scoreA, ?int $scoreB, string $status): MatchModel
    {
        $previousStatus = $match->status;

        DB::transaction(function () use ($match, $scoreA, $scoreB, $status, $previousStatus): void {
            $payload = ['status' => $status];

            if ($scoreA !== null) {
                $payload['score_a'] = $scoreA;
            }

            if ($scoreB !== null) {
                $payload['score_b'] = $scoreB;
            }

            $match->update($payload);

            if ($status === 'finished' || $previousStatus === 'finished') {
                $this->standingService->recalculate($match->tournament);
            }
        });

        return $match->refresh();
    }
}
