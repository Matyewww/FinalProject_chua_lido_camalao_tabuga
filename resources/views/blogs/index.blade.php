<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Blogs</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    <style>
        .btn-dark {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .btn-dark i {
            margin-right: 10px;
        }
        .navbar-nav .nav-item .nav-link {
            padding: 0.5rem 1rem;
        }
        .navbar .search-bar {
            width: 100%;
            max-width: 300px;
        }
        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .card-header {
            background-color: #f8f9fa;
        }
        .card-title {
            color: #007bff;
        }
        .card-subtitle {
            color: #6c757d;
        }
        .card-text {
            color: #343a40;
        }
        .btn-outline-success {
            border-color: #615f5f;
            color: #000000;
        }
        .btn-outline-success:hover {
            background-color: #28a745;
            color: white;
        }
        .btn-outline-danger {
            border-color: #dc3545;
            color: #dc3545;
        }
        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <a class="navbar-brand" href="#">Post IT</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('home') }}">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Blogs</a>
                </li>
                <!-- Add any additional nav items here -->
            </ul>

            <ul class="navbar-nav ml-auto">
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                </li>
                @endguest
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                @endauth
            </ul>
        </div>
    </nav>

    <!-- Add New Blog Button -->
    <div class="container mt-4">
        <div class="form-group mb-3">
            <a href="{{ url('blogs/create') }}" class="btn btn-dark"> <i class="fas fa-plus"></i> Add Blogs </a>
        </div>

        <!-- Blog Posts -->
        <div class="row">
            @foreach ($blogs as $blog)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if($blog->photo)
                    @php
                    $photos = json_decode($blog->photo);
                    @endphp
                    @if(count($photos) > 0)
                    <img src="{{ Storage::url($photos[0]) }}" class="card-img-top" alt="Blog Photo">
                    @else
                    <img src="{{ asset('default-photo.png') }}" class="card-img-top" alt="Default Photo">
                    @endif
                    @else
                    <img src="{{ asset('default-photo.png') }}" class="card-img-top" alt="Default Photo">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $blog->title_name }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">By {{ $blog->author }}</h6>
                        <p class="card-text">{{ Str::limit($blog->content, 100) }}</p>
                        <p class="card-text"><small class="text-muted">Published on {{ $blog->published_date }}</small>
                        </p>
                        <a href="{{ url('blogs', $blog->id) }}/edit" class="btn btn-outline-success btn-sm">Edit</a>
                        <form action="{{ url('blogs', $blog->id) }}" method="post" class="d-inline">
                            @method('delete') @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                onclick="return confirm('Delete this item?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div>
            {{-- Pagination Links --}}
            {{ $blogs->links() }}
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>