<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // public function index()
    // {
    //     // // Retrieve posts based on user role
    //     // if (Auth::user()->hasRole('superadmin')) {
    //     //     $posts = Post::all();
    //     // } else {
    //     //     $posts = Post::where('status', 'active')
    //     //                  ->where('approved', true)
    //     //                  ->get();
    //     // }
    //     $posts = Post::all(); // Adjust this query as needed
    //     return view('posts.index', compact('posts'));
    // }

    public function index()
    {
        // Retrieve posts based on user role
        if (Auth::user()->hasRole('superadmin')) {
            $posts = Post::all();
        } else {
            $posts = Post::all();

            // $posts = Post::where('status', 'active')
            //              ->where('approved', true)
            //              ->get();
        }
        return view('posts.index', compact('posts'));
    }
    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image',
            'tags' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        // Handle file upload
        $imagePath = $request->file('image') ? $request->file('image')->store('images', 'public') : null;

        // Create a new post
        Post::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'image' => $imagePath,
            'tags' => $request->input('tags'),
            'status' => $request->input('status'),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        // Ensure the post belongs to the authenticated user
        if (Auth::id() != $post->user_id && !Auth::user()->hasRole('superadmin')) {
            return redirect()->route('posts.index')->with('error', 'Unauthorized access.');
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $post = Post::findOrFail($id);

        // Ensure the post belongs to the authenticated user
        if (Auth::id() != $post->user_id && !Auth::user()->hasRole('superadmin')) {
            return redirect()->route('posts.index')->with('error', 'Unauthorized access.');
        }

        // Handle file upload
        if ($request->hasFile('image')) {
            // Delete old image
            // if ($post->image) {
            //     Storage::disk('public')->delete($post->image);
            // }
            $post->image = $request->file('image')->store('images', 'public');
        }

        // Update post
        $post->update([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'tags' => $request->input('tags'),
            'status' => $request->input('status'),
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }
    public function approve(Post $post)
    {
        // Check if the authenticated user is a superadmin
        if (!auth()->user()->hasRole('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        // Update post approval and status
        $post->approved = 1; // Set to 1 for approved
        $post->status = 'active'; // Set status to active when approved
        $post->save();

        // Redirect with a success message
        return redirect()->route('posts.index')->with('status', 'Post approved!');
    }

    public function disapprove(Post $post)
    {
        // Check if the authenticated user is a superadmin
        if (!auth()->user()->hasRole('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        // Update post approval and status
        $post->approved = 0; // Set to 0 for disapproved
        $post->status = 'inactive'; // Set status to inactive when disapproved
        $post->save();

        // Redirect with a success message
        return redirect()->route('posts.index')->with('status', 'Post disapproved!');
    }


    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Ensure the post belongs to the authenticated user
        if (Auth::id() != $post->user_id && !Auth::user()->hasRole('superadmin')) {
            return redirect()->route('posts.index')->with('error', 'Unauthorized access.');
        }

        // Delete image if exists
        if ($post->image) {
            // Storage::disk('public')->delete($post->image);
        }

        // Delete the post
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

        // Ensure the post is approved and active
        if ($post->status != 'active' || (!$post->approved && !Auth::user()->hasRole('superadmin'))) {
            return redirect()->route('posts.index')->with('error', 'Post not available.');
        }

        return view('posts.show', compact('post'));
    }
    public function like(Post $post)
    {
        $post->likes()->attach(auth()->user()->id);
        return back();
    }

    public function unlike(Post $post)
    {
        $post->likes()->detach(auth()->user()->id);
        return back();
    }

    public function feed()
    {
        $posts = Post::where('status', 'active')
            ->where('approved', true)
            ->get();
        return view('posts.index', compact('posts'));
    }
    public function welcome()
    {
        $posts = Post::where('status', 'active')
            ->where('approved', true)
            ->get();
        return view('posts.welcome', compact('posts'));
    }
    public function storecomments(Request $request, Post $post)
    {
        // Validate the request
        $request->validate([
            'content' => 'required|max:255',
        ]);

        // Create a new comment
        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = auth()->id();
        $comment->post_id = $post->id;
        $comment->save();

        // Redirect back to the post
        return redirect()->route('posts.show', $post->id)->with('success', 'Comment added successfully!');
    }
}
