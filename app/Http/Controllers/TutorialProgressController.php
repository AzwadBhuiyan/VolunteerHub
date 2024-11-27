<?php

namespace App\Http\Controllers;

use App\Models\TutorialProgress;
use Illuminate\Http\Request;

class TutorialProgressController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'page_name' => 'required|string',
            'dont_show_again' => 'boolean',
            'last_step_seen' => 'integer'
        ]);

        $progress = TutorialProgress::updateOrCreate(
            [
                'userid' => auth()->user()->userid,
                'page_name' => $validated['page_name']
            ],
            [
                'dont_show_again' => $validated['dont_show_again']
            ]
        );

        return response()->json($progress);
    }

    public function check($path)
    {
        $pageMap = [
            'dashboard' => 'volunteer_dashboard',
            'favorites' => 'favorites',
            '/' => 'home',
            'h' => 'home',
            '' => 'home'
        ];
        
        // Handle profile path separately due to dynamic URL
        if (preg_match('/^profile\/[^\/]+$/', $path)) {
            $pageName = 'volunteer_profile';
        } else {
            $pageName = $pageMap[$path] ?? null;
        }

        if (!$pageName) {
            return response()->json(['dont_show_again' => false]);
        }

        try {
            $progress = TutorialProgress::where('userid', auth()->user()->userid)
                ->where('page_name', $pageName)
                ->first();

            return response()->json([
                'dont_show_again' => $progress ? $progress->dont_show_again : false,
                'page_name' => $pageName,
                'debug_path' => $path
            ]);
        } catch (\Exception $e) {
            \Log::error('Tutorial progress check failed', [
                'error' => $e->getMessage(),
                'path' => $path,
                'user' => auth()->user()->userid ?? null
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}