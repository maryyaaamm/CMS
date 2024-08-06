@extends('layouts.app')
<style>/* Add this to your app's CSS file */

    .post-content {
        margin-bottom: 20px;
    }

    .post-image {
        display: block;
        max-width: 100%;
        height: auto;
        margin: 20px 0;
    }

    .comments-section {
        border-top: 1px solid #e6e6e6;
        padding-top: 20px;
    }

    .comments-list {
        max-height: 400px; /* Adjust as needed */
        overflow-y: auto;
        padding-bottom: 20px;
    }

    .comment {
        display: flex;
        margin-bottom: 15px;
    }

    .comment-avatar {
        margin-right: 10px;
    }

    .comment-avatar img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .comment-content {
        flex: 1;
    }

    .comment-user {
        font-weight: bold;
        margin-right: 5px;
    }

    .comment-text {
        margin: 0;
    }

    .comment-time {
        color: #999;
        font-size: 0.85em;
        margin-top: 5px;
    }

    .comment-input {
        display: flex;
        flex-direction: column;
        margin-top: 20px;
    }

    .comment-input textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #e6e6e6;
        border-radius: 5px;
        resize: none;
        margin-bottom: 10px;
    }

    .comment-input button {
        align-self: flex-end;
        background-color: #0095f6;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    .comment-input button:hover {
        background-color: #007bb5;
    }
    </style>
@section('content')
<div class="container">
    <h1>{{ $post->title }}</h1>

    <div class="post-content">
        <p>{{ $post->body }}</p>
        <p>Tags: {{ $post->tags }}</p>
        <p>Status: {{ $post->status }}</p>
        <p>Approved: {{ $post->approved ? 'Yes' : 'No' }}</p>
        <p>Author: {{ $post->user->name }}</p>

        @if($post->image)
            <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="post-image">
        @endif
    </div>

    <div class="comments-section">
        <div class="comments-list">
            @foreach($post->comments as $comment)
                <div class="comment">
                    <div class="comment-avatar">
                        <img src="{{ $comment->user->avatar }}" alt="{{ $comment->user->name }}">
                    </div>
                    <div class="comment-content">
                        <span class="comment-user">{{ $comment->user->name }}</span>
                        <p class="comment-text">{{ $comment->body }}</p>
                        <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @endforeach
        </div>
        <form action="{{ route('comments.store', $post->id) }}" method="POST" class="comment-input">
            @csrf
            <textarea name="content" rows="1" placeholder="Add a comment..." required></textarea>
            <button type="submit" class="btn btn-primary">Post</button>
        </form>
    </div>
</div>
@endsection
