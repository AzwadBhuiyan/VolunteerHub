<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityCategory;

class FavoriteController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();
        $favorites = $user->volunteer->favorite;
        $categories = ActivityCategory::all();
        $districts = array_diff(config('districts.districts'), [$user->volunteer->District]);
    
        // If favorites exist, ensure we're passing only category names
        if ($favorites && $favorites->favorite_categories) {
            $favorites->favorite_categories = array_values($favorites->favorite_categories);
        }
    
        return view('profile.edit-favorites', compact('favorites', 'categories', 'districts', 'user'));
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
    
        return redirect()->route('favorites.edit')->with('status', 'favorites-updated');
    }
}