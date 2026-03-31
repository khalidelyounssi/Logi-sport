<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Services\StandingService;
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

    public function recalculate(Tournament $tournament, StandingService $standingService): RedirectResponse
    {
        abort_if(!in_array(auth()->user()->role, ['organizer', 'admin']), 403);

        $standingService->recalculate($tournament);

        return redirect()
            ->route('tournaments.standings.index', $tournament)
            ->with('success', 'Standings recalculated successfully.');
    }
}