<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Organization;
use App\Models\Volunteer;
use App\Models\IdeaThread;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query', '');
        $category = $request->input('category', 'organizations');
        $perPage = 8;

        if (empty($category)) {
            return redirect()->back()->with('error', 'Please select a category before searching');
        }

        if (empty($query)) {
            return view('search.results', compact('results', 'category', 'query'))->with('results', collect([]));
        }

        switch($category) {
            case 'organizations':
                $results = Organization::whereHas('user', function($q) use ($query) {
                    $q->where('org_name', 'like', "%{$query}%")
                      ->orWhere('org_name', 'like', "%{$query}%");
                })->paginate($perPage);
                break;
                
            case 'volunteers':
                $results = Volunteer::with('user')
                    ->whereHas('user', function($q) use ($query) {
                        // Split the search query into words
                        $searchTerms = explode(' ', $query);
                        $q->where(function($query) use ($searchTerms) {
                            foreach($searchTerms as $term) {
                                $query->where('Name', 'like', "%{$term}%");
                            }
                        });
                    })->paginate($perPage);
                break;
                
            case 'activities':
                $results = Activity::where('title', 'like', "%{$query}%")
                                 ->orWhere('description', 'like', "%{$query}%")
                                 ->with('organization')
                                 ->paginate($perPage);
                break;
                
            case 'ideas':
                $results = IdeaThread::where('title', 'like', "%{$query}%")
                                   ->orWhere('description', 'like', "%{$query}%")
                                   ->with('organization')
                                   ->paginate($perPage);
                break;
            
            default:
                $results = collect([]);
        }

        if($request->ajax()) {
            return response()->json([
                'html' => view('search.partials.results', compact('results', 'category'))->render(),
                'hasMore' => $results->hasMorePages()
            ]);
        }

        return view('search.results', compact('results', 'category', 'query'));
    }

    public function suggestions(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category', 'organizations');
        
        // Limit suggestions to 5 items
        $limit = 5;

        switch($category) {
            case 'organizations':
                $suggestions = Organization::whereHas('user', function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('org_name', 'like', "%{$query}%");
                })->limit($limit)->get();
                break;
                
            case 'volunteers':
                $suggestions = Volunteer::whereHas('user', function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%");
                })->limit($limit)->get();
                break;
                
            case 'activities':
                $suggestions = Activity::where('title', 'like', "%{$query}%")
                                     ->limit($limit)
                                     ->get();
                break;
                
            case 'ideas':
                $suggestions = IdeaThread::where('title', 'like', "%{$query}%")
                                       ->limit($limit)
                                       ->get();
                break;
                
            default:
                $suggestions = collect([]);
        }

        return response()->json($suggestions);
    }
}