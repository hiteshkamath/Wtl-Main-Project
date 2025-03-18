<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Movie Review System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Movie Reviews</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('movies.create') }}">Upload Movie</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">{{ auth()->user()->name }}</a></li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Welcome to the Movie Review System</h1>
        <p>Here you can browse and review movies!</p>

        @if($movies->isEmpty())
            <p class="text-center">No movies uploaded yet.</p>
        @else
            <div class="row">
                @foreach($movies as $movie)
                    <div class="col-md-4">
                        <div class="card mb-4">
                            @if($movie->poster)
                                <img src="{{ asset('storage/' . $movie->poster) }}" class="card-img-top" alt="Movie Poster">
                            @else
                                <img src="https://via.placeholder.com/300x400" class="card-img-top" alt="Default Poster">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $movie->title }}</h5>
                                <p class="card-text">{{ $movie->description }}</p>

                                <!-- Display Average Rating -->
                                <p>⭐ {{ number_format($movie->averageRating(), 1) }}/5 ({{ $movie->ratings->count() }} ratings)</p>

                                <!-- Rating Form -->
                                @auth
                                    <form action="{{ route('movies.rate', $movie->id) }}" method="POST">
                                        @csrf
                                        <label for="rating">Rate this movie:</label>
                                        <select name="rating" class="form-select form-select-sm d-inline w-auto">
                                            <option value="1">⭐ 1</option>
                                            <option value="2">⭐⭐ 2</option>
                                            <option value="3">⭐⭐⭐ 3</option>
                                            <option value="4">⭐⭐⭐⭐ 4</option>
                                            <option value="5">⭐⭐⭐⭐⭐ 5</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                    </form>
                                @else
                                    <p><a href="{{ route('login') }}">Login to rate this movie</a></p>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>