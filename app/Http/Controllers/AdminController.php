<?php

namespace App\Http\Controllers;

use App\Models\MatchModel;
use App\Models\Sport;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function users(): View
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $users = User::latest()->paginate(10);

        return view('admin.users', compact('users'));
    }

    public function toggleStatus(User $user): RedirectResponse
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot suspend your own account.');
        }

        $user->update([
            'is_active' => ! $user->is_active,
        ]);

        return back()->with('success', 'User status updated successfully.');
    }

    public function changeRole(Request $request, User $user): RedirectResponse
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $request->validate([
            'role' => ['required', 'in:admin,organizer,referee,player'],
        ]);

        $user->update([
            'role' => $request->role,
        ]);

        return back()->with('success', 'User role updated successfully.');
    }

    public function statistics(): View
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $totalUsers = User::count();
        $totalTournaments = Tournament::count();
        $totalMatches = MatchModel::count();
        $totalSports = Sport::count();

        $usersByRole = [
            'admins' => User::where('role', 'admin')->count(),
            'organizers' => User::where('role', 'organizer')->count(),
            'referees' => User::where('role', 'referee')->count(),
            'players' => User::where('role', 'player')->count(),
        ];

        return view('admin.statistics', compact(
            'totalUsers',
            'totalTournaments',
            'totalMatches',
            'totalSports',
            'usersByRole'
        ));
    }
}