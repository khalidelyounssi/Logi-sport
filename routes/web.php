<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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
});
require __DIR__.'/auth.php';
