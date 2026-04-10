<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRefereeMatchScoreRequest;
use App\Models\MatchModel;
use App\Services\MatchScoreService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use RuntimeException;

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

    public function update(
        UpdateRefereeMatchScoreRequest $request,
        MatchModel $match,
        MatchScoreService $matchScoreService
    ): RedirectResponse {
        abort_if(auth()->user()->role !== 'referee', 403);
        abort_if($match->referee_id !== auth()->id(), 403);

        try {
            $matchScoreService->updateScore(
                $match,
                $request->score_a !== null ? (int) $request->score_a : null,
                $request->score_b !== null ? (int) $request->score_b : null,
                $request->status,
                $request->expected_updated_at
            );
        } catch (RuntimeException $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('referee.matches.index')
            ->with('success', 'Match score updated successfully.');
    }
}