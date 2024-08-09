<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::where('user_id', auth()->user()->id)->paginate(6);// Adjust the number of items per page as needed
        return view('blogs.index', compact('blogs'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title_name' => 'required',
            'author' => 'required',
            'content' => 'required',
            'published_date' => 'required|date',
            'photo' => 'nullable|array',
            'photo.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $blog = new Blog;
        $blog->title_name = $request->input('title_name');
        $blog->author = $request->input('author');
        $blog->user_id = auth()->user()->id;
        $blog->content = $request->input('content');
        $blog->published_date = $request->input('published_date');

        // Handle file uploads
        if ($request->hasFile('photo')) {
            $photos = [];
            foreach ($request->file('photo') as $photo) {
                $path = $photo->store('public/photos');
                $photos[] = str_replace('\\', '/', $path); // Ensure forward slashes
            }
            $blog->photo = json_encode($photos);
        }

        $blog->save();

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return view('blogs.show', compact('blog'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title_name' => 'required',
            'author' => 'required',
            'content' => 'required',
            'published_date' => 'required|date',
            'photo.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3000',
        ]);

        $blog = Blog::findOrFail($id);
        $blog->title_name = $request->input('title_name');
        $blog->author = $request->input('author');
        $blog->content = $request->input('content');
        $blog->published_date = $request->input('published_date');

        // Handle file uploads
        if ($request->hasFile('photo')) {
            // Optionally delete old photos if needed
            if ($blog->photo) {
                foreach (json_decode($blog->photo) as $oldPhoto) {
                    Storage::delete($oldPhoto);
                }
            }

            $photos = [];
            foreach ($request->file('photo') as $photo) {
                $path = $photo->store('public/photos');
                $photos[] = str_replace('\\', '/', $path); // Ensure forward slashes
            }
            $blog->photo = json_encode($photos);
        }

        $blog->save();

        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        // Optionally delete photos if needed
        if ($blog->photo) {
            foreach (json_decode($blog->photo) as $photo) {
                Storage::delete($photo);
            }
        }

        $blog->delete();
        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $blogs = Blog::where('title_name', 'like', "%{$query}%")
                    ->orWhere('content', 'like', "%{$query}%")
                    ->paginate(5);

        return view('blogs.index', compact('blogs'));
    }

}