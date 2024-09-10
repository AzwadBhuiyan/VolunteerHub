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
        return view('profile.favorites.edit', compact('favorites'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user->volunteer) {
            abort(403, 'Only volunteers can update favorites.');
        }
        
        $validated = $request->validate([
            'favorites' => 'required|array|max:5',
            'favorites.*' => 'string|distinct|max:50',
        ]);
        
        $user->volunteer->favorites = $validated['favorites'];
        $user->volunteer->save();
        
        return redirect()->route('profile.edit')->with('status', 'favorites-updated');
    }
}