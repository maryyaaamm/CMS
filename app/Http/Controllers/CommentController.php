<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        // Validate the request
        $request->validate([
            'body' => 'required|max:255', // Update to 'body'
        ]);

        // Create a new comment
        $comment = new Comment();
        $comment->body = $request->body; // Update to 'body'
        $comment->user_id = auth()->id();
        $comment->post_id = $post->id;
        $comment->save();

        // Redirect back to the post
        return redirect()->route('posts.show', $post->id)->with('success', 'Comment added successfully!');
    }
}
