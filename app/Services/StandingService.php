<?php

namespace App\Services;

use App\Models\Tournament;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\DB;

class StandingService
{
    public function recalculate(Tournament $tournament): EloquentCollection
    {
        $tournament->loadMissing([
            'sport:id,win_points,draw_points',
            'participants:id,tournament_id,name,user_id',
            'matches:id,tournament_id,participant_a_id,participant_b_id,score_a,score_b,status',
        ]);

        $winPoints = (int) ($tournament->sport?->win_points ?? 3);
        $drawPoints = (int) ($tournament->sport?->draw_points ?? 1);

        $standings = [];

        foreach ($tournament->participants as $participant) {
            $standings[$participant->id] = [
                'tournament_id' => $tournament->id,
                'participant_id' => $participant->id,
                'points' => 0,
                'played' => 0,
                'won' => 0,
                'lost' => 0,
                'draw' => 0,
            ];
        }

        foreach ($tournament->matches as $match) {
            if (
                $match->status !== 'finished' ||
                $match->score_a === null ||
                $match->score_b === null ||
                ! isset($standings[$match->participant_a_id], $standings[$match->participant_b_id])
            ) {
                continue;
            }

            $standings[$match->participant_a_id]['played']++;
            $standings[$match->participant_b_id]['played']++;

            // ROUND ROBIN
            if ($tournament->type === 'round_robin') {
                if ($match->score_a > $match->score_b) {
                    $standings[$match->participant_a_id]['won']++;
                    $standings[$match->participant_a_id]['points'] += $winPoints;
                    $standings[$match->participant_b_id]['lost']++;
                    continue;
                }

                if ($match->score_a < $match->score_b) {
                    $standings[$match->participant_b_id]['won']++;
                    $standings[$match->participant_b_id]['points'] += $winPoints;
                    $standings[$match->participant_a_id]['lost']++;
                    continue;
                }

                $standings[$match->participant_a_id]['draw']++;
                $standings[$match->participant_b_id]['draw']++;
                $standings[$match->participant_a_id]['points'] += $drawPoints;
                $standings[$match->participant_b_id]['points'] += $drawPoints;
                continue;
            }

            // ELIMINATION
            if ($tournament->type === 'elimination') {
                if ($match->score_a > $match->score_b) {
                    $standings[$match->participant_a_id]['won']++;
                    $standings[$match->participant_a_id]['points'] += 1;
                    $standings[$match->participant_b_id]['lost']++;
                    continue;
                }

                if ($match->score_a < $match->score_b) {
                    $standings[$match->participant_b_id]['won']++;
                    $standings[$match->participant_b_id]['points'] += 1;
                    $standings[$match->participant_a_id]['lost']++;
                    continue;
                }

              
                continue;
            }
        }

        DB::transaction(function () use ($tournament, $standings): void {
            $tournament->standings()->delete();

            if (! empty($standings)) {
                $tournament->standings()->createMany(array_values($standings));
            }
        });

        $query = $tournament->standings()
            ->with('participant');

        if ($tournament->type === 'elimination') {
            return $query
                ->orderByDesc('won')
                ->orderBy('lost')
                ->orderByDesc('played')
                ->orderBy('participant_id')
                ->get();
        }

        return $query
            ->orderByDesc('points')
            ->orderByDesc('won')
            ->orderBy('lost')
            ->orderBy('participant_id')
            ->get();
    }
}