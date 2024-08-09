<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;

        }
        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .photo-preview img {
            max-width: 100px;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ url('blogs') }}" class="btn btn-primary">Blogs List</a>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <form action="{{ url('blogs', $blog->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title_name" class="form-control" value="{{ old('title_name', $blog->title_name) }}" />
                            @error('title_name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Author</label>
                            <input type="text" name="author" class="form-control" value="{{ old('author', $blog->author) }}" />
                            @error('author')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Content</label>
                            <textarea name="content" class="form-control" rows="5">{{ old('content', $blog->content) }}</textarea>
                            @error('content')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Photos</label>
                            <input type="file" name="photos[]" class="form-control" multiple />
                            @error('photos.*')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <!-- Display current photos if available -->
                            @if($blog->photo)
                                <div class="photo-preview mt-3">
                                    @foreach(json_decode($blog->photo) as $photo)
                                        <img src="{{ asset('storage/photos/' . basename($photo)) }}" alt="Current Photo">
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Published Date {{ $blog->published_date }}</label>
                            <input type="date" name="published_date" class="form-control" value="{{ $blog->published_date ?? '' }}" />
                            @error('published_date')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3 text-center">
                            <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>