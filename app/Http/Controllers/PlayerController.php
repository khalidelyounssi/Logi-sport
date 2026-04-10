<?php

namespace App\Http\Controllers;

use App\Models\MatchModel;
use App\Models\Participant;
use App\Models\Standing;
use App\Models\Tournament;
use Illuminate\View\View;

class PlayerController extends Controller
{
    public function dashboard(): View
    {
        abort_if(auth()->user()->role !== 'player', 403);

        $user = auth()->user();

        $participantIds = Participant::where('user_id', $user->id)->pluck('id');

        $myTournaments = Tournament::whereHas('participants', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with('sport')->latest()->get();

        $recentMatches = MatchModel::with(['tournament', 'participantA', 'participantB'])
            ->where(function ($query) use ($participantIds) {
                $query->whereIn('participant_a_id', $participantIds)
                    ->orWhereIn('participant_b_id', $participantIds);
            })
            ->latest()
            ->take(5)
            ->get();

        $matchesPlayed = MatchModel::where('status', 'finished')
            ->where(function ($query) use ($participantIds) {
                $query->whereIn('participant_a_id', $participantIds)
                    ->orWhereIn('participant_b_id', $participantIds);
            })
            ->count();

        $wins = 0;
        $goalsOrPoints = 0;

        foreach ($recentMatches as $match) {
            $isA = $participantIds->contains($match->participant_a_id);
            $isB = $participantIds->contains($match->participant_b_id);

            if ($match->status === 'finished') {
                if ($isA) {
                    $goalsOrPoints += (int) ($match->score_a ?? 0);
                    if (($match->score_a ?? 0) > ($match->score_b ?? 0)) {
                        $wins++;
                    }
                }

                if ($isB) {
                    $goalsOrPoints += (int) ($match->score_b ?? 0);
                    if (($match->score_b ?? 0) > ($match->score_a ?? 0)) {
                        $wins++;
                    }
                }
            }
        }

        $bestStanding = Standing::whereIn('participant_id', $participantIds)
            ->orderByDesc('points')
            ->first();

        $rank = $bestStanding ? '#' . $this->getRankInTournament($bestStanding) : '—';

        return view('dashboards.player', compact(
            'myTournaments',
            'recentMatches',
            'matchesPlayed',
            'wins',
            'goalsOrPoints',
            'rank'
        ));
    }

    public function matches(): View
    {
        abort_if(auth()->user()->role !== 'player', 403);

        $participantIds = Participant::where('user_id', auth()->id())->pluck('id');

        $matches = MatchModel::with(['tournament', 'participantA', 'participantB', 'referee'])
            ->where(function ($query) use ($participantIds) {
                $query->whereIn('participant_a_id', $participantIds)
                    ->orWhereIn('participant_b_id', $participantIds);
            })
            ->latest()
            ->get();

        return view('player.matches', compact('matches'));
    }

    public function tournaments(): View
    {
        abort_if(auth()->user()->role !== 'player', 403);

        $tournaments = Tournament::whereHas('participants', function ($query) {
            $query->where('user_id', auth()->id());
        })->with('sport')->latest()->get();

        return view('player.tournaments', compact('tournaments'));
    }

    private function getRankInTournament(Standing $standing): int
    {
        return Standing::where('tournament_id', $standing->tournament_id)
            ->orderByDesc('points')
            ->orderByDesc('won')
            ->orderBy('lost')
            ->pluck('id')
            ->search($standing->id) + 1;
    }
}