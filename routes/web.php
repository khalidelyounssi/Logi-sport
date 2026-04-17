<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\RefereeDashboardController;
use App\Http\Controllers\RefereeMatchController;
use App\Http\Controllers\SportController;
use App\Http\Controllers\StandingController;
use App\Http\Controllers\TournamentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index']);
Route::get('/public/matches-feed', [LandingController::class, 'feed'])->name('public.matches.feed');

Route::middleware(['auth'])->group(function () {
    // Admin
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::patch('/admin/users/{user}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admin.users.toggleStatus');
    Route::patch('/admin/users/{user}/change-role', [AdminController::class, 'changeRole'])->name('admin.users.changeRole');
    Route::resource('sports', SportController::class);
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::patch('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Dashboards
    Route::get('/organizer/dashboard', [OrganizerController::class, 'dashboard'])->name('organizer.dashboard');
    Route::get('/referee/dashboard', [RefereeDashboardController::class, 'index'])->name('referee.dashboard');
    Route::get('/player/dashboard', [PlayerController::class, 'dashboard'])->name('player.dashboard');

    // Player pages
    Route::get('/player/matches', [PlayerController::class, 'matches'])->name('player.matches');
    Route::get('/player/tournaments', [PlayerController::class, 'tournaments'])->name('player.tournaments');
    Route::get('/player/profile', [PlayerController::class, 'profile'])->name('player.profile');

    // Tournament CRUD
    Route::resource('tournaments', TournamentController::class);

    // Participants CRUD
    Route::resource('tournaments.participants', ParticipantController::class)->except(['show']);

    // Matches CRUD
    Route::resource('tournaments.matches', MatchController::class);

    // Referee score management
    Route::get('/referee/matches', [RefereeMatchController::class, 'index'])->name('referee.matches.index');
    Route::get('/referee/matches/{match}/edit-score', [RefereeMatchController::class, 'edit'])->name('referee.matches.edit');
    Route::put('/referee/matches/{match}/update-score', [RefereeMatchController::class, 'update'])->name('referee.matches.update');

    // Auto match generation
    Route::post('/tournaments/{tournament}/generate-matches', [TournamentController::class, 'generateMatches'])
        ->name('tournaments.generateMatches');

    // Standings
    Route::get('/tournaments/{tournament}/standings', [StandingController::class, 'index'])
        ->name('tournaments.standings.index');

    Route::post('/tournaments/{tournament}/standings/recalculate', [StandingController::class, 'recalculate'])
        ->name('tournaments.standings.recalculate');
});

require __DIR__ . '/auth.php';