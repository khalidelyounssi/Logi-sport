<?php

namespace App\Http\Controllers;

use App\Models\Standing;
use App\Models\Tournament;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StandingController extends Controller
{
    public function index(Tournament $tournament): View
    {
        abort_if(!in_array(auth()->user()->role, ['organizer', 'player', 'referee', 'admin']), 403);

        $standings = $tournament->standings()
            ->with('participant')
            ->orderByDesc('points')
            ->orderByDesc('won')
            ->orderBy('lost')
            ->get();

        return view('standings.index', compact('tournament', 'standings'));
    }

    public function recalculate(Tournament $tournament): RedirectResponse
    {
        abort_if(!in_array(auth()->user()->role, ['organizer', 'admin']), 403);

        // 1) نمسحو standings القديمة
        $tournament->standings()->delete();

        // 2) نخلقو standing فارغة لكل participant
        foreach ($tournament->participants as $participant) {
            $tournament->standings()->create([
                'participant_id' => $participant->id,
                'points' => 0,
                'played' => 0,
                'won' => 0,
                'lost' => 0,
                'draw' => 0,
            ]);
        }

        // 3) نجيبو غير الماتشات المسالين
        $matches = $tournament->matches()->where('status', 'finished')->get();

        foreach ($matches as $match) {
            $standingA = Standing::where('tournament_id', $tournament->id)
                ->where('participant_id', $match->participant_a_id)
                ->first();

            $standingB = Standing::where('tournament_id', $tournament->id)
                ->where('participant_id', $match->participant_b_id)
                ->first();

            if (!$standingA || !$standingB) {
                continue;
            }

            $standingA->increment('played');
            $standingB->increment('played');

            if ($match->score_a > $match->score_b) {
                $standingA->increment('won');
                $standingA->increment('points', $tournament->sport->win_points);

                $standingB->increment('lost');
            } elseif ($match->score_a < $match->score_b) {
                $standingB->increment('won');
                $standingB->increment('points', $tournament->sport->win_points);

                $standingA->increment('lost');
            } else {
                $standingA->increment('draw');
                $standingB->increment('draw');

                $standingA->increment('points', $tournament->sport->draw_points);
                $standingB->increment('points', $tournament->sport->draw_points);
            }
        }

        return redirect()
            ->route('tournaments.standings.index', $tournament)
            ->with('success', 'Standings recalculated successfully.');
    }
}