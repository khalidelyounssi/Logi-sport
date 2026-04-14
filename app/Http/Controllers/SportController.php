<?php

namespace App\Http\Controllers;

use App\Models\Sport;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class SportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $sports = Sport::orderBy('name')->paginate(10);
        return view('sports.index', compact('sports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        abort_if(auth()->user()->role !== 'admin', 403);
        
        return view('sports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $validated = $request->validate([
            'name' => 'required|string|unique:sports,name|max:255',
            'win_points' => 'required|integer|min:0',
            'draw_points' => 'required|integer|min:0',
            'rules' => 'nullable|string',
            'ranking_order' => 'nullable|string|max:255',
            'result_unit' => 'nullable|string|max:255',
        ]);

        Sport::create($validated);

        return redirect()->route('sports.index')->with('success', 'Sport created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sport $sport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sport $sport): View
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        return view('sports.edit', compact('sport'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sport $sport): RedirectResponse
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $validated = $request->validate([
            'name' => 'required|string|unique:sports,name,' . $sport->id . '|max:255',
            'win_points' => 'required|integer|min:0',
            'draw_points' => 'required|integer|min:0',
            'rules' => 'nullable|string',
            'ranking_order' => 'nullable|string|max:255',
            'result_unit' => 'nullable|string|max:255',
        ]);

        $sport->update($validated);

        return redirect()->route('sports.index')->with('success', 'Sport updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sport $sport): RedirectResponse
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        // Check if sport has tournaments
        if ($sport->tournaments()->exists()) {
            return redirect()->route('sports.index')->with('error', 'Cannot delete sport with associated tournaments.');
        }

        $sport->delete();

        return redirect()->route('sports.index')->with('success', 'Sport deleted successfully.');
    }
}
