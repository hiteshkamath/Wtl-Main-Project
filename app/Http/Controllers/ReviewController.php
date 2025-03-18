<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Movie;

class ReviewController extends Controller
{
    public function store(Request $request, $movieId)
    {
        $request->validate([
            'review_text' => 'required|string|max:500',
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'movie_id' => $movieId,
            'review_text' => $request->review_text,
        ]);

        return redirect()->back()->with('success', 'Review added successfully!');
    }

    public function like($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $review->increment('likes');

        return redirect()->back();
    }
}