<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function rateMovie(Request $request, $movieId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $movie = Movie::findOrFail($movieId);

        // Check if user already rated this movie
        $existingRating = Rating::where('user_id', Auth::id())
                                ->where('movie_id', $movieId)
                                ->first();

        if ($existingRating) {
            // Update existing rating
            $existingRating->update(['rating' => $request->rating]);
        } else {
            // Create new rating
            Rating::create([
                'user_id' => Auth::id(),
                'movie_id' => $movieId,
                'rating' => $request->rating,
            ]);
        }

        return back()->with('success', 'Thank you for rating!');
    }
}