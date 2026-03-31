<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTournamentRequest;
use App\Http\Requests\UpdateTournamentRequest;
use App\Models\Sport;
use App\Models\Tournament;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TournamentController extends Controller
{
    public function index(): View
    {
        abort_if(auth()->user()->role !== 'organizer', 403);

        $tournaments = Tournament::with('sport')
            ->where('organizer_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('tournaments.index', compact('tournaments'));
    }

    public function create(): View
    {
        abort_if(auth()->user()->role !== 'organizer', 403);

        $sports = Sport::orderBy('name')->get();

        return view('tournaments.create', compact('sports'));
    }

    public function store(StoreTournamentRequest $request): RedirectResponse
    {
        Tournament::create([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'sport_id' => $request->sport_id,
            'organizer_id' => auth()->id(),
        ]);

        return redirect()
            ->route('tournaments.index')
            ->with('success', 'Tournament created successfully.');
    }

    public function show(Tournament $tournament): View
    {
        abort_if(auth()->user()->role !== 'organizer', 403);
        abort_if($tournament->organizer_id !== auth()->id(), 403);

        $tournament->load('sport', 'participants', 'matches');

        return view('tournaments.show', compact('tournament'));
    }

    public function edit(Tournament $tournament): View
    {
        abort_if(auth()->user()->role !== 'organizer', 403);
        abort_if($tournament->organizer_id !== auth()->id(), 403);

        $sports = Sport::orderBy('name')->get();

        return view('tournaments.edit', compact('tournament', 'sports'));
    }

    public function update(UpdateTournamentRequest $request, Tournament $tournament): RedirectResponse
    {
        abort_if($tournament->organizer_id !== auth()->id(), 403);

        $tournament->update([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'sport_id' => $request->sport_id,
        ]);

        return redirect()
            ->route('tournaments.index')
            ->with('success', 'Tournament updated successfully.');
    }

    public function generateMatches($tournamentId)
{
    $tournament = Tournament::with('participants')->findOrFail($tournamentId);

    abort_if(auth()->user()->role !== 'organizer', 403);

    $participants = $tournament->participants;

    $tournament->matches()->delete();

    for ($i = 0; $i < count($participants); $i++) {
        for ($j = $i + 1; $j < count($participants); $j++) {

            \App\Models\MatchModel::create([
                'tournament_id' => $tournament->id,
                'participant_a_id' => $participants[$i]->id,
                'participant_b_id' => $participants[$j]->id,
                'status' => 'scheduled',
            ]);
        }
    }

    return redirect()
        ->route('tournaments.matches.index', $tournament)
        ->with('success', 'Matches generated successfully 🔥');
}

    public function destroy(Tournament $tournament): RedirectResponse
    {
        abort_if(auth()->user()->role !== 'organizer', 403);
        abort_if($tournament->organizer_id !== auth()->id(), 403);

        $tournament->delete();

        return redirect()
            ->route('tournaments.index')
            ->with('success', 'Tournament deleted successfully.');
    }
}