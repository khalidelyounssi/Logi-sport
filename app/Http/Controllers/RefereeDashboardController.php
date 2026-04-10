<?php

namespace App\Http\Controllers;

use App\Models\MatchModel;
use Illuminate\View\View;

class RefereeDashboardController extends Controller
{
    public function index(): View
    {
        abort_if(auth()->user()->role !== 'referee', 403);

        $userId = auth()->id();

        $matches = MatchModel::where('referee_id', $userId);

        $assigned = (clone $matches)->count();

        $inProgress = (clone $matches)
            ->where('status', 'in_progress')
            ->count();

        $completed = (clone $matches)
            ->where('status', 'finished')
            ->count();

        $pending = (clone $matches)
            ->where('status', 'scheduled')
            ->count();

        $recentMatches = MatchModel::with(['tournament', 'participantA', 'participantB'])
            ->where('referee_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboards.referee', compact(
            'assigned',
            'inProgress',
            'completed',
            'pending',
            'recentMatches'
        ));
    }
}