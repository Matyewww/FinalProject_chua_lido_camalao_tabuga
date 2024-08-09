<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create a Blog</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" />
    <style>
        body {
            background-color: #270d46;
        }
        .form-container {
            background-color: #ee2d2d;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #af37df;
            border-color: #640eaf;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <h2 class="mb-4 text-center">Make A Vlog</h2>
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title_name" class="form-control" value="{{ old('title_name') }}" />
                            @error('title_name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Author</label>
                            <input type="text" name="author" class="form-control" value="{{ old('author') }}" />
                            @error('author')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Content</label>
                            <textarea name="content" class="form-control" rows="5">{{ old('content') }}</textarea>
                            @error('content')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                       <div class="form-group mb-3">
                            <label class="form-label">ISBN</label>
                            <input type="date" name="published_date" class="form-control" value="{{ old('published_date') }}" />
                            @error('published_date')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> 

                        <div class="form-group mb-3">
                            <label class="form-label">Photos</label>
                            <input type="file" name="photo[]" class="form-control" multiple />
                            @error('photo.*')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3 text-center">
                            <button type="submit" class="btn btn-primary w-100">Upload Blog</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>