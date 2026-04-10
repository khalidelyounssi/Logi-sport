<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\Participant;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class StandingController extends Controller
{
    public function index(Tournament $tournament): View
    {
        $user = auth()->user();

        // ADMIN
        if ($user->role === 'admin') {
            $standings = $tournament->standings()
                ->with('participant')
                ->orderByDesc('points')
                ->get();

            return view('standings.index', compact('tournament', 'standings'));
        }

        // ORGANIZER
        if ($user->role === 'organizer') {
            abort_if($tournament->organizer_id !== $user->id, 403);

            $standings = $tournament->standings()
                ->with('participant')
                ->orderByDesc('points')
                ->get();

            return view('standings.index', compact('tournament', 'standings'));
        }

        // PLAYER
        if ($user->role === 'player') {
            $isParticipant = Participant::where('tournament_id', $tournament->id)
                ->where('user_id', $user->id)
                ->exists();

            abort_if(! $isParticipant, 403);

            $standings = $tournament->standings()
                ->with('participant')
                ->orderByDesc('points')
                ->get();

            return view('standings.index', compact('tournament', 'standings'));
        }

        abort(403);
    }

    public function recalculate(Tournament $tournament): RedirectResponse
    {
        $user = auth()->user();

        abort_if(! in_array($user->role, ['organizer', 'admin']), 403);

        if ($user->role === 'organizer') {
            abort_if($tournament->organizer_id !== $user->id, 403);
        }

        app(\App\Services\StandingService::class)->recalculate($tournament);

        return redirect()
            ->route('tournaments.standings.index', $tournament)
            ->with('success', 'Standings recalculated successfully.');
    }
}