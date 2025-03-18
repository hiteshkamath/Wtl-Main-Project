<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;
use App\Models\Movie;

// Home Page Route
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/', function () {
    $movies = Movie::latest()->get(); // Fetch all movies, newest first
    return view('home', compact('movies'));
})->name('home');

Route::post('/movies/{movie}/rate', [RatingController::class, 'store'])->middleware('auth')->name('movies.rate');

// Dashboard Route (Redirect to Home After Login)
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/movies/create', [MovieController::class, 'create'])->name('movies.create');
    Route::post('/movies/store', [MovieController::class, 'store'])->name('movies.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/movies/{movie}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::post('/reviews/{review}/like', [ReviewController::class, 'like'])->name('reviews.like');
});

// Profile Routes (For Editing User Profile)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/movies/{movie}/rate', [RatingController::class, 'rateMovie'])->name('movies.rate');

// Authentication Routes (Login, Register, Logout)
require __DIR__.'/auth.php';