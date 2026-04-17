<?php

namespace App\Http\Controllers;

use App\Services\PublicMatchFeedService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(PublicMatchFeedService $feedService): View
    {
        $initialMatchDay = 'next7days';
        $publicMatches = $feedService->getMatches($initialMatchDay);
        $matchRefreshSeconds = (int) config('services.match_feed.ajax_refresh_seconds', 30);

        return view('welcome', compact('publicMatches', 'initialMatchDay', 'matchRefreshSeconds'));
    }

    public function feed(Request $request, PublicMatchFeedService $feedService): JsonResponse
    {
        $day = $request->query('day', 'next7days');
        $day = in_array($day, ['today', 'tomorrow', 'next7days'], true) ? $day : 'next7days';

        return response()->json([
            'day' => $day,
            'updated_at' => now()->format('Y-m-d H:i:s'),
            'matches' => $feedService->getMatches($day),
        ]);
    }
}
