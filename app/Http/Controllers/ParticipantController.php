<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParticipantRequest;
use App\Http\Requests\UpdateParticipantRequest;
use App\Models\Participant;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ParticipantController extends Controller
{
    public function index(Tournament $tournament): View
    {
        abort_if(auth()->user()->role !== 'organizer', 403);
        abort_if($tournament->organizer_id !== auth()->id(), 403);

        $participants = $tournament->participants()
            ->with('user')
            ->latest()
            ->get();

        $availableTournaments = Tournament::with('sport')
            ->where('organizer_id', auth()->id())
            ->latest()
            ->get(['id', 'title', 'sport_id']);

        return view('participants.index', compact('tournament', 'participants', 'availableTournaments'));
    }

    public function create(Tournament $tournament): View
    {
        abort_if(auth()->user()->role !== 'organizer', 403);
        abort_if($tournament->organizer_id !== auth()->id(), 403);

        $players = User::where('role', 'player')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('participants.create', compact('tournament', 'players'));
    }

    public function store(StoreParticipantRequest $request, Tournament $tournament): RedirectResponse
    {
        abort_if(auth()->user()->role !== 'organizer', 403);
        abort_if($tournament->organizer_id !== auth()->id(), 403);

        $tournament->participants()->create([
            'name' => $request->name,
            'type' => $request->type,
            'user_id' => $request->user_id,
        ]);

        return redirect()
            ->route('tournaments.participants.index', $tournament)
            ->with('success', 'Participant created successfully.');
    }

    public function edit(Tournament $tournament, Participant $participant): View
    {
        abort_if(auth()->user()->role !== 'organizer', 403);
        abort_if($tournament->organizer_id !== auth()->id(), 403);
        abort_if($participant->tournament_id !== $tournament->id, 404);

        $players = User::where('role', 'player')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('participants.edit', compact('tournament', 'participant', 'players'));
    }

    public function update(
        UpdateParticipantRequest $request,
        Tournament $tournament,
        Participant $participant
    ): RedirectResponse {
        abort_if(auth()->user()->role !== 'organizer', 403);
        abort_if($tournament->organizer_id !== auth()->id(), 403);
        abort_if($participant->tournament_id !== $tournament->id, 404);

        $participant->update([
            'name' => $request->name,
            'type' => $request->type,
            'user_id' => $request->user_id,
        ]);

        return redirect()
            ->route('tournaments.participants.index', $tournament)
            ->with('success', 'Participant updated successfully.');
    }

    public function destroy(Tournament $tournament, Participant $participant): RedirectResponse
    {
        abort_if(auth()->user()->role !== 'organizer', 403);
        abort_if($tournament->organizer_id !== auth()->id(), 403);
        abort_if($participant->tournament_id !== $tournament->id, 404);

        $participant->delete();

        return redirect()
            ->route('tournaments.participants.index', $tournament)
            ->with('success', 'Participant deleted.');
    }
}