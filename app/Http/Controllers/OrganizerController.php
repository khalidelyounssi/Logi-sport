<?php

namespace App\Http\Controllers;

use App\Models\MatchModel;
use App\Models\Participant;
use App\Models\Tournament;
use Illuminate\View\View;

class OrganizerController extends Controller
{
    public function dashboard(): View
    {
        abort_if(auth()->user()->role !== 'organizer', 403);

        $user = auth()->user();

        $tournaments = Tournament::with(['sport'])
            ->where('organizer_id', $user->id)
            ->latest()
            ->get();

        $tournamentIds = $tournaments->pluck('id');

        $activeTournaments = $tournaments
            ->whereIn('status', ['upcoming', 'live'])
            ->count();

        $registeredTeams = Participant::whereIn('tournament_id', $tournamentIds)->count();

        $matchesPlayed = MatchModel::whereIn('tournament_id', $tournamentIds)
            ->where('status', 'finished')
            ->count();

        $pendingScores = MatchModel::whereIn('tournament_id', $tournamentIds)
            ->whereIn('status', ['scheduled', 'in_progress'])
            ->count();

        $recentTournaments = $tournaments->take(4);

        $recentUpdates = MatchModel::with(['tournament', 'participantA', 'participantB'])
            ->whereIn('tournament_id', $tournamentIds)
            ->latest()
            ->take(5)
            ->get();

        $currentTournament = $tournaments->first();

        return view('dashboards.organizer', compact(
            'activeTournaments',
            'registeredTeams',
            'matchesPlayed',
            'pendingScores',
            'recentTournaments',
            'recentUpdates',
            'currentTournament'
        ));
    }
}