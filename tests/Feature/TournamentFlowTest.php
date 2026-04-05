<?php

use App\Models\MatchModel;
use App\Models\Participant;
use App\Models\Sport;
use App\Models\Tournament;
use App\Models\User;

it('generates full round-robin matches and assigns referees', function () {
    $organizer = User::factory()->create(['role' => 'organizer']);
    $referees = User::factory()->count(2)->create([
        'role' => 'referee',
        'is_active' => true,
    ]);

    $sport = Sport::create([
        'name' => 'Football',
        'win_points' => 3,
        'draw_points' => 1,
    ]);

    $tournament = Tournament::create([
        'title' => 'Summer Cup',
        'description' => 'Round robin test tournament',
        'type' => 'round_robin',
        'start_date' => now()->toDateString(),
        'end_date' => now()->addDays(5)->toDateString(),
        'status' => 'upcoming',
        'sport_id' => $sport->id,
        'organizer_id' => $organizer->id,
    ]);

    foreach (['Team A', 'Team B', 'Team C', 'Team D'] as $name) {
        Participant::create([
            'name' => $name,
            'tournament_id' => $tournament->id,
        ]);
    }

    $this->actingAs($organizer)
        ->post(route('tournaments.generateMatches', $tournament))
        ->assertRedirect(route('tournaments.matches.index', $tournament));

    $matches = $tournament->matches()->get();

    expect($matches)->toHaveCount(6)
        ->and($matches->pluck('status')->unique()->values()->all())->toBe(['scheduled'])
        ->and($tournament->standings()->count())->toBe(4);

    $uniquePairs = $matches
        ->map(fn (MatchModel $match) => collect([$match->participant_a_id, $match->participant_b_id])->sort()->implode('-'))
        ->unique();

    expect($uniquePairs)->toHaveCount(6);

    $assignedReferees = $matches->pluck('referee_id')->filter()->unique()->sort()->values()->all();

    expect($assignedReferees)->toBe($referees->pluck('id')->sort()->values()->all());
});

it('updates score through referee endpoint and recalculates standings', function () {
    $organizer = User::factory()->create(['role' => 'organizer']);
    $referee = User::factory()->create([
        'role' => 'referee',
        'is_active' => true,
    ]);

    $sport = Sport::create([
        'name' => 'Basketball',
        'win_points' => 2,
        'draw_points' => 1,
    ]);

    $tournament = Tournament::create([
        'title' => 'City League',
        'description' => 'Score update test',
        'type' => 'round_robin',
        'start_date' => now()->toDateString(),
        'end_date' => now()->addDays(7)->toDateString(),
        'status' => 'live',
        'sport_id' => $sport->id,
        'organizer_id' => $organizer->id,
    ]);

    $teamA = Participant::create([
        'name' => 'Raptors',
        'tournament_id' => $tournament->id,
    ]);

    $teamB = Participant::create([
        'name' => 'Falcons',
        'tournament_id' => $tournament->id,
    ]);

    $match = MatchModel::create([
        'tournament_id' => $tournament->id,
        'participant_a_id' => $teamA->id,
        'participant_b_id' => $teamB->id,
        'status' => 'scheduled',
        'referee_id' => $referee->id,
    ]);

    $this->actingAs($referee)
        ->put(route('referee.matches.update', $match), [
            'score_a' => 3,
            'score_b' => 1,
            'status' => 'finished',
        ])
        ->assertRedirect(route('referee.matches.index'));

    $match->refresh();

    expect($match->status)->toBe('finished')
        ->and($match->score_a)->toBe(3)
        ->and($match->score_b)->toBe(1);

    $standingA = $tournament->standings()->where('participant_id', $teamA->id)->firstOrFail();
    $standingB = $tournament->standings()->where('participant_id', $teamB->id)->firstOrFail();

    expect($standingA->played)->toBe(1)
        ->and($standingA->won)->toBe(1)
        ->and($standingA->points)->toBe(2)
        ->and($standingB->played)->toBe(1)
        ->and($standingB->lost)->toBe(1)
        ->and($standingB->points)->toBe(0);
});

it('recalculates standings with win draw and loss logic', function () {
    $organizer = User::factory()->create(['role' => 'organizer']);

    $sport = Sport::create([
        'name' => 'Football',
        'win_points' => 3,
        'draw_points' => 1,
    ]);

    $tournament = Tournament::create([
        'title' => 'National Tournament',
        'description' => 'Standing recalc test',
        'type' => 'round_robin',
        'start_date' => now()->toDateString(),
        'end_date' => now()->addDays(10)->toDateString(),
        'status' => 'live',
        'sport_id' => $sport->id,
        'organizer_id' => $organizer->id,
    ]);

    $alpha = Participant::create([
        'name' => 'Alpha',
        'tournament_id' => $tournament->id,
    ]);

    $beta = Participant::create([
        'name' => 'Beta',
        'tournament_id' => $tournament->id,
    ]);

    $gamma = Participant::create([
        'name' => 'Gamma',
        'tournament_id' => $tournament->id,
    ]);

    MatchModel::create([
        'tournament_id' => $tournament->id,
        'participant_a_id' => $alpha->id,
        'participant_b_id' => $beta->id,
        'score_a' => 2,
        'score_b' => 0,
        'status' => 'finished',
    ]);

    MatchModel::create([
        'tournament_id' => $tournament->id,
        'participant_a_id' => $alpha->id,
        'participant_b_id' => $gamma->id,
        'score_a' => 1,
        'score_b' => 1,
        'status' => 'finished',
    ]);

    MatchModel::create([
        'tournament_id' => $tournament->id,
        'participant_a_id' => $beta->id,
        'participant_b_id' => $gamma->id,
        'score_a' => 0,
        'score_b' => 3,
        'status' => 'finished',
    ]);

    MatchModel::create([
        'tournament_id' => $tournament->id,
        'participant_a_id' => $alpha->id,
        'participant_b_id' => $beta->id,
        'score_a' => 4,
        'score_b' => 4,
        'status' => 'scheduled',
    ]);

    $this->actingAs($organizer)
        ->post(route('tournaments.standings.recalculate', $tournament))
        ->assertRedirect(route('tournaments.standings.index', $tournament));

    $alphaStanding = $tournament->standings()->where('participant_id', $alpha->id)->firstOrFail();
    $betaStanding = $tournament->standings()->where('participant_id', $beta->id)->firstOrFail();
    $gammaStanding = $tournament->standings()->where('participant_id', $gamma->id)->firstOrFail();

    expect($alphaStanding->played)->toBe(2)
        ->and($alphaStanding->won)->toBe(1)
        ->and($alphaStanding->draw)->toBe(1)
        ->and($alphaStanding->lost)->toBe(0)
        ->and($alphaStanding->points)->toBe(4)
        ->and($betaStanding->played)->toBe(2)
        ->and($betaStanding->won)->toBe(0)
        ->and($betaStanding->draw)->toBe(0)
        ->and($betaStanding->lost)->toBe(2)
        ->and($betaStanding->points)->toBe(0)
        ->and($gammaStanding->played)->toBe(2)
        ->and($gammaStanding->won)->toBe(1)
        ->and($gammaStanding->draw)->toBe(1)
        ->and($gammaStanding->lost)->toBe(0)
        ->and($gammaStanding->points)->toBe(4);
});
