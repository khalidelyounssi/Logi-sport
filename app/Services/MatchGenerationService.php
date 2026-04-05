<?php

namespace App\Services;

use App\Models\MatchModel;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MatchGenerationService
{
    public function generateRoundRobin(
        Tournament $tournament,
        bool $replaceExisting = true,
        bool $autoAssignReferees = true
    ): int {
        if ($tournament->type !== 'round_robin') {
            throw ValidationException::withMessages([
                'type' => 'Automatic generation is only supported for round-robin tournaments.',
            ]);
        }

        $participantIds = $tournament->participants()
            ->orderBy('id')
            ->pluck('id')
            ->all();

        if (count($participantIds) < 2) {
            throw ValidationException::withMessages([
                'participants' => 'At least two participants are required to generate matches.',
            ]);
        }

        $refereeIds = [];

        if ($autoAssignReferees) {
            $refereeIds = User::query()
                ->where('role', 'referee')
                ->where('is_active', true)
                ->orderBy('id')
                ->pluck('id')
                ->all();
        }

        $generatedMatches = $this->buildRoundRobinMatches($tournament, $participantIds, $refereeIds);

        DB::transaction(function () use ($tournament, $replaceExisting, $generatedMatches): void {
            if ($replaceExisting) {
                $tournament->matches()->delete();
            }

            MatchModel::insert($generatedMatches);
        });

        return count($generatedMatches);
    }

    /**
     * @param  array<int, int|null>  $participantIds
     * @param  array<int, int>  $refereeIds
     * @return array<int, array<string, mixed>>
     */
    private function buildRoundRobinMatches(
        Tournament $tournament,
        array $participantIds,
        array $refereeIds
    ): array {
        if (count($participantIds) % 2 !== 0) {
            $participantIds[] = null;
        }

        $participantCount = count($participantIds);
        $rounds = $participantCount - 1;
        $matchesPerRound = (int) ($participantCount / 2);
        $refereeIndex = 0;
        $now = now();

        $rows = [];

        for ($round = 0; $round < $rounds; $round++) {
            for ($slot = 0; $slot < $matchesPerRound; $slot++) {
                $participantA = $participantIds[$slot];
                $participantB = $participantIds[$participantCount - 1 - $slot];

                if ($participantA === null || $participantB === null) {
                    continue;
                }

                if ($round % 2 !== 0) {
                    [$participantA, $participantB] = [$participantB, $participantA];
                }

                $rows[] = [
                    'tournament_id' => $tournament->id,
                    'participant_a_id' => $participantA,
                    'participant_b_id' => $participantB,
                    'match_date' => $tournament->start_date?->copy()->addDays($round),
                    'location' => null,
                    'score_a' => null,
                    'score_b' => null,
                    'status' => 'scheduled',
                    'referee_id' => $this->nextReferee($refereeIds, $refereeIndex),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            $last = array_pop($participantIds);
            array_splice($participantIds, 1, 0, [$last]);
        }

        return $rows;
    }

    /**
     * @param  array<int, int>  $refereeIds
     */
    private function nextReferee(array $refereeIds, int &$refereeIndex): ?int
    {
        if ($refereeIds === []) {
            return null;
        }

        $refereeId = $refereeIds[$refereeIndex % count($refereeIds)];
        $refereeIndex++;

        return $refereeId;
    }
}
