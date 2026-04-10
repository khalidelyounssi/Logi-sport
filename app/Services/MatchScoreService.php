<?php

namespace App\Services;

use App\Models\MatchModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class MatchScoreService
{
    public function __construct(
        private readonly StandingService $standingService
    ) {
    }

    public function updateScore(
        MatchModel $match,
        ?int $scoreA,
        ?int $scoreB,
        string $status,
        ?string $expectedUpdatedAt = null
    ): MatchModel {
        $updatedMatch = DB::transaction(function () use ($match, $scoreA, $scoreB, $status, $expectedUpdatedAt) {
            $freshMatch = MatchModel::with('tournament')
                ->lockForUpdate()
                ->findOrFail($match->id);

            $previousStatus = $freshMatch->status;

            if ($expectedUpdatedAt !== null) {
                $clientTimestamp = Carbon::parse($expectedUpdatedAt);
                $dbTimestamp = $freshMatch->updated_at;

                if (! $dbTimestamp || ! $dbTimestamp->equalTo($clientTimestamp)) {
                    throw new RuntimeException('This match was updated by another user. Please refresh and try again.');
                }
            }

            $payload = [
                'status' => $status,
            ];

            if ($scoreA !== null) {
                $payload['score_a'] = $scoreA;
            }

            if ($scoreB !== null) {
                $payload['score_b'] = $scoreB;
            }

            $freshMatch->update($payload);

            if ($freshMatch->status === 'finished' || $previousStatus === 'finished') {
                $this->standingService->recalculate($freshMatch->tournament);
            }

            return $freshMatch;
        });

        return $updatedMatch->refresh();
    }
}