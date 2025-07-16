<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'comic_id' => 'required|exists:comics,id',
        ]);

        Favorite::create($validated);
    }

    public function destroy(Favorite $favorite)
    {
        $favorite->delete();
    }
}
