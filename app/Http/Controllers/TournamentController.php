<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTournamentRequest;
use App\Http\Requests\UpdateTournamentRequest;
use App\Models\Sport;
use App\Models\Tournament;
use App\Models\User;
use App\Services\MatchGenerationService;
use App\Services\AppNotificationService;
use App\Services\StandingService;
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

    public function store(StoreTournamentRequest $request, AppNotificationService $notificationService): RedirectResponse
    {
        $tournament = Tournament::create([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'sport_id' => $request->sport_id,
            'organizer_id' => auth()->id(),
        ]);

        User::query()
            ->where('role', 'admin')
            ->where('is_active', true)
            ->get()
            ->each(fn (User $user) => $notificationService->sendToUser($user, 'New tournament created: ' . $tournament->title));

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

    public function generateMatches(
        Tournament $tournament,
        MatchGenerationService $matchGenerationService,
        AppNotificationService $notificationService,
        StandingService $standingService
    ): RedirectResponse {
        abort_if(auth()->user()->role !== 'organizer', 403);
        abort_if($tournament->organizer_id !== auth()->id(), 403);

        $generatedCount = $matchGenerationService->generateRoundRobin(
            $tournament,
            replaceExisting: true,
            autoAssignReferees: true
        );

        $tournament->load(['matches.participantA.user', 'matches.participantB.user', 'matches.referee']);

        foreach ($tournament->matches as $match) {
            if ($match->referee) {
                $notificationService->sendToUser(
                    $match->referee,
                    'You have been assigned to match: ' . $match->participantA->name . ' vs ' . $match->participantB->name
                );
            }

            if ($match->participantA?->user) {
                $notificationService->sendToUser(
                    $match->participantA->user,
                    'Your team was scheduled for match: ' . $match->participantA->name . ' vs ' . $match->participantB->name
                );
            }

            if ($match->participantB?->user) {
                $notificationService->sendToUser(
                    $match->participantB->user,
                    'Your team was scheduled for match: ' . $match->participantA->name . ' vs ' . $match->participantB->name
                );
            }
        }

        $standingService->recalculate($tournament);

        return redirect()
            ->route('tournaments.matches.index', $tournament)
            ->with('success', "{$generatedCount} matches generated successfully.");
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
