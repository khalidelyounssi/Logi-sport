<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMatchRequest;
use App\Http\Requests\UpdateMatchRequest;
use App\Models\MatchModel;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MatchController extends Controller
{
    public function index(Tournament $tournament): View
    {
        abort_if(!in_array(auth()->user()->role, ['organizer', 'referee']), 403);

        $matches = $tournament->matches()
            ->with(['participantA', 'participantB', 'referee'])
            ->latest()
            ->get();

        if (auth()->user()->role === 'referee') {
            $matches = $matches->where('referee_id', auth()->id());
        }

        return view('matches.index', compact('tournament', 'matches'));
    }

    public function create(Tournament $tournament): View
    {
        abort_if(auth()->user()->role !== 'organizer', 403);

        $participants = $tournament->participants()->orderBy('name')->get();
        $referees = User::where('role', 'referee')->where('is_active', true)->orderBy('name')->get();

        return view('matches.create', compact('tournament', 'participants', 'referees'));
    }

    public function store(StoreMatchRequest $request, Tournament $tournament): RedirectResponse
    {
        abort_if(auth()->user()->role !== 'organizer', 403);

        $participantIds = $tournament->participants()->pluck('id')->toArray();

        abort_if(
            !in_array((int) $request->participant_a_id, $participantIds) ||
            !in_array((int) $request->participant_b_id, $participantIds),
            422
        );

        $tournament->matches()->create([
            'participant_a_id' => $request->participant_a_id,
            'participant_b_id' => $request->participant_b_id,
            'match_date' => $request->match_date,
            'location' => $request->location,
            'status' => $request->status,
            'referee_id' => $request->referee_id,
            'score_a' => $request->score_a,
            'score_b' => $request->score_b,
        ]);

        return redirect()
            ->route('tournaments.matches.index', $tournament)
            ->with('success', 'Match created successfully.');
    }

    public function show(Tournament $tournament, MatchModel $match): View
    {
        abort_if(!in_array(auth()->user()->role, ['organizer', 'referee']), 403);
        abort_if($match->tournament_id !== $tournament->id, 404);

        if (auth()->user()->role === 'referee') {
            abort_if($match->referee_id !== auth()->id(), 403);
        }

        $match->load(['participantA', 'participantB', 'referee', 'tournament']);

        return view('matches.show', compact('tournament', 'match'));
    }

    public function edit(Tournament $tournament, MatchModel $match): View
    {
        abort_if(!in_array(auth()->user()->role, ['organizer', 'referee']), 403);
        abort_if($match->tournament_id !== $tournament->id, 404);

        if (auth()->user()->role === 'referee') {
            abort_if($match->referee_id !== auth()->id(), 403);
        }

        $participants = $tournament->participants()->orderBy('name')->get();
        $referees = User::where('role', 'referee')->where('is_active', true)->orderBy('name')->get();

        return view('matches.edit', compact('tournament', 'match', 'participants', 'referees'));
    }

    public function update(UpdateMatchRequest $request, Tournament $tournament, MatchModel $match): RedirectResponse
    {
        abort_if(!in_array(auth()->user()->role, ['organizer', 'referee']), 403);
        abort_if($match->tournament_id !== $tournament->id, 404);

        if (auth()->user()->role === 'referee') {
            abort_if($match->referee_id !== auth()->id(), 403);
        }

        $data = [
            'participant_a_id' => $request->participant_a_id,
            'participant_b_id' => $request->participant_b_id,
            'match_date' => $request->match_date,
            'location' => $request->location,
            'status' => $request->status,
            'score_a' => $request->score_a,
            'score_b' => $request->score_b,
        ];

        if (auth()->user()->role === 'organizer') {
            $data['referee_id'] = $request->referee_id;
        }

        $match->update($data);

        return redirect()
            ->route('tournaments.matches.index', $tournament)
            ->with('success', 'Match updated successfully.');
    }

    public function destroy(Tournament $tournament, MatchModel $match): RedirectResponse
    {
        abort_if(auth()->user()->role !== 'organizer', 403);
        abort_if($match->tournament_id !== $tournament->id, 404);

        $match->delete();

        return redirect()
            ->route('tournaments.matches.index', $tournament)
            ->with('success', 'Match deleted successfully.');
    }
}