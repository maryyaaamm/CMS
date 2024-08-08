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
        'content' => 'required|max:255',
    ]);

    // Create a new comment
    $comment = new Comment();
    $comment->body = $request->input('content');
    $comment->user_id = auth()->id();
    $comment->post_id = $post->id;
    $comment->save();

    // Redirect back to the post with a success message
    return redirect()->route('posts.show', $post->id)->with('success', 'Comment added successfully!');
}

}
