<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        abort_if($notification->user_id !== auth()->id(), 403);

        if (! $notification->is_read) {
            $notification->update(['is_read' => true]);
        }

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification): RedirectResponse
    {
        abort_if($notification->user_id !== auth()->id(), 403);

        $notification->delete();

        return back()->with('success', 'Notification deleted.');
    }

    public function read(Notification $notification): RedirectResponse
    {
        abort_if($notification->user_id !== auth()->id(), 403);

        $notification->update(['is_read' => true]);

        return back();
    }

    public function readAll(): RedirectResponse
    {
        auth()->user()->notifications()->where('is_read', false)->update(['is_read' => true]);

        return back()->with('success', 'All notifications marked as read.');
    }
}
