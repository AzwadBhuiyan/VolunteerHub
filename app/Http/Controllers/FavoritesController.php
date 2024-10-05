<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        if (!$user->volunteer) {
            abort(403, 'Only volunteers can edit favorites.');
        }
        
        $favorites = $user->volunteer->favorites;
        $districts = config('districts.districts');
        $categories = \App\Models\ActivityCategory::all();
        
        return view('profile.favorites.edit', compact('favorites', 'districts', 'categories'));
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user->volunteer) {
            abort(403, 'Only volunteers can update favorites.');
        }
        
        $validated = $request->validate([
            'districts' => 'required|array|max:3',
            'districts.*' => 'string|distinct|in:' . implode(',', config('districts.districts')),
            'categories' => 'required|array|max:3',
            'categories.*' => 'exists:activity_categories,id',
        ]);
        
        $user->volunteer->favorite_districts = $validated['districts'];
        $user->volunteer->favorite_categories()->sync($validated['categories']);
        $user->volunteer->save();
        
        return redirect()->route('profile.edit')->with('status', 'favorites-updated');
    }
}