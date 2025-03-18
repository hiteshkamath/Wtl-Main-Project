<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    // Show movie upload form
    public function create()
    {
        return view('movies.create');
    }

    // Store movie in database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $movie = new Movie();
        $movie->title = $request->title;
        $movie->description = $request->description;

        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('posters', 'public');
            $movie->poster = $posterPath;
        }

        $movie->save();

        return redirect()->route('home')->with('success', 'Movie uploaded successfully!');
    }
}