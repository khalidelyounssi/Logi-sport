<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\Participant;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreParticipantRequest;
use App\Http\Requests\UpdateParticipantRequest;

class ParticipantController extends Controller
{
    public function index(Tournament $tournament): View
    {
        abort_if(auth()->user()->role !== 'organizer', 403);

        $participants = $tournament->participants()->latest()->get();

        return view('participants.index', compact('tournament', 'participants'));
    }

    public function create(Tournament $tournament): View
    {
        return view('participants.create', compact('tournament'));
    }

    public function store(StoreParticipantRequest $request, Tournament $tournament): RedirectResponse
    {
        $tournament->participants()->create([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return redirect()
            ->route('tournaments.participants.index', $tournament)
            ->with('success', 'Participant created successfully.');
    }

    public function edit(Tournament $tournament, Participant $participant): View
    {
        return view('participants.edit', compact('tournament', 'participant'));
    }

    public function update(UpdateParticipantRequest $request, Tournament $tournament, Participant $participant): RedirectResponse
    {
        $participant->update([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return redirect()
            ->route('tournaments.participants.index', $tournament)
            ->with('success', 'Participant updated successfully.');
    }

    public function destroy(Tournament $tournament, Participant $participant): RedirectResponse
    {
        $participant->delete();

        return redirect()
            ->route('tournaments.participants.index', $tournament)
            ->with('success', 'Participant deleted.');
    }
}