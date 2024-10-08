<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityCategory;
use App\Models\Activity;
use App\Models\Organization;

class FavoriteController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();
        $favorites = $user->volunteer->favorite;
        $volunteer = $user->volunteer;
        
        // Sort categories alphabetically by name
        $categories = ActivityCategory::orderBy('name')->get();
        
        // Sort districts alphabetically
        $districts = collect(config('districts.districts'))->sort()->values()->all();

        // Get followed organizations
        $followedOrganizations = $volunteer->followedOrganizations;
    
        // If favorites exist, ensure we're passing only category names
        if ($favorites && $favorites->favorite_categories) {
            $favorites->favorite_categories = array_values($favorites->favorite_categories);
        }
    
        return view('profile.edit-favorites', compact('favorites', 'categories', 'districts', 'user', 'followedOrganizations'));
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $volunteer = $user->volunteer;
    
        $request->validate([
            'favorite_categories' => 'required|json|max:255',
            'favorite_districts' => 'required|json|max:255',
        ]);
    
        $favoriteCategories = json_decode($request->favorite_categories, true);
        $favoriteDistricts = json_decode($request->favorite_districts, true);
    
        // Extract only the category names
        $categoryNames = array_column($favoriteCategories, 'name');
    
        $favorite = $volunteer->favorite()->updateOrCreate(
            ['volunteer_userid' => $volunteer->userid],
            [
                'favorite_categories' => $categoryNames,
                'favorite_districts' => $favoriteDistricts,
            ]
        );
    
        return redirect()->route('favorites.show')->with('status', 'favorites-updated');
    }

    public function showFavorites(Request $request)
    {
        $user = $request->user();
        $volunteer = $user->volunteer;
        $favorites = $user->volunteer->favorite;
        $followedOrganizations = $user->volunteer->followedOrganizations()->pluck('userid');
        
        $query = Activity::where('status', 'open')
            ->where(function ($q) use ($favorites, $followedOrganizations) {
                $q->when($favorites && (!empty($favorites->favorite_categories) || !empty($favorites->favorite_districts)), function ($subQ) use ($favorites) {
                    $subQ->where(function ($innerQ) use ($favorites) {
                        if (!empty($favorites->favorite_categories)) {
                            $innerQ->whereIn('category', $favorites->favorite_categories);
                        }
                        if (!empty($favorites->favorite_districts)) {
                            $innerQ->orWhereIn('district', $favorites->favorite_districts);
                        }
                    });
                })
                ->orWhereIn('userid', $followedOrganizations);
            });
    
        $activities = $query->orderBy('date', 'asc')->paginate(10);
    
        if ($activities->isEmpty() && ($favorites || $followedOrganizations->isNotEmpty())) {
            $activities = Activity::where('status', 'open')->orderBy('date', 'asc')->paginate(10);
        }
    
        return view('profile.favorites', compact('activities', 'favorites', 'user', 'volunteer'));
    }
}