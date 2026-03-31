<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRefereeMatchScoreRequest;
use App\Models\MatchModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RefereeMatchController extends Controller
{
    public function index(): View
    {
        abort_if(auth()->user()->role !== 'referee', 403);

        $matches = MatchModel::with(['tournament', 'participantA', 'participantB'])
            ->where('referee_id', auth()->id())
            ->latest()
            ->get();

        return view('referee.matches.index', compact('matches'));
    }

    public function edit(MatchModel $match): View
    {
        abort_if(auth()->user()->role !== 'referee', 403);
        abort_if($match->referee_id !== auth()->id(), 403);

        $match->load(['tournament', 'participantA', 'participantB', 'referee']);

        return view('referee.matches.edit', compact('match'));
    }

    public function update(UpdateRefereeMatchScoreRequest $request, MatchModel $match): RedirectResponse
    {
        abort_if(auth()->user()->role !== 'referee', 403);
        abort_if($match->referee_id !== auth()->id(), 403);

        $match->update([
            'score_a' => $request->score_a,
            'score_b' => $request->score_b,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('referee.matches.index')
            ->with('success', 'Match score updated successfully.');
    }
}