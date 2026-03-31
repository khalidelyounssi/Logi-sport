<?php

use App\Http\Controllers\MatchController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\TournamentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RefereeMatchController;
use App\Http\Controllers\StandingController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

   

    Route::get('/admin/dashboard', function () {
        abort_if(auth()->user()->role !== 'admin', 403);
        return view('dashboards.admin');
    })->name('admin.dashboard');

    Route::get('/organizer/dashboard', function () {
        abort_if(auth()->user()->role !== 'organizer', 403);
        return view('dashboards.organizer');
    })->name('organizer.dashboard');

    Route::get('/referee/dashboard', function () {
        abort_if(auth()->user()->role !== 'referee', 403);
        return view('dashboards.referee');
    })->name('referee.dashboard');

    Route::get('/player/dashboard', function () {
        abort_if(auth()->user()->role !== 'player', 403);
        return view('dashboards.player');
    })->name('player.dashboard');

    

    Route::resource('tournaments', TournamentController::class);

    

    Route::resource('tournaments.participants', ParticipantController::class)
        ->except(['show']);

    

    Route::resource('tournaments.matches', MatchController::class);
});

    Route::get('/referee/matches', [RefereeMatchController::class, 'index'])->name('referee.matches.index');
    Route::get('/referee/matches/{match}/edit-score', [RefereeMatchController::class, 'edit'])->name('referee.matches.edit');
    Route::put('/referee/matches/{match}/update-score', [RefereeMatchController::class, 'update'])->name('referee.matches.update');

    Route::get('/tournaments/{tournament}/standings', [StandingController::class, 'index'])->name('tournaments.standings.index');
Route::post('/tournaments/{tournament}/standings/recalculate', [StandingController::class, 'recalculate'])->name('tournaments.standings.recalculate');


require __DIR__.'/auth.php';