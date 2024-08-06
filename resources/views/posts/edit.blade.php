@extends('layouts.app')

<style>
    /* General Container Styles */
    .container {
        max-width: 600px; /* Slightly smaller for a more compact view */
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
    }

    /* Post Content */
    .post-content {
        margin-bottom: 20px;
    }

    .post-content p {
        line-height: 1.6;
        color: #333;
    }

    /* Post Image */
    .post-image {
        display: block;
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        margin: 20px 0;
        max-height: 500px;
        object-fit: cover;
    }

    /* Post Details */
    .post-details {
        margin-top: 10px;
        font-size: 14px; /* Smaller text for details */
        color: #666; /* Soft gray for detail text */
    }

    .post-details p {
        margin: 5px 0;
    }

    .post-tags {
        color: #ff6f61; /* Pink color for tags */
    }

    .post-status, .post-approved {
        font-weight: bold;
        color: #ff6f61; /* Pink for statuses */
    }

    .post-author {
        font-style: italic;
    }

    /* Comments Section */
    .comments-section {
        border-top: 1px solid #e6e6e6;
        padding-top: 20px;
        background-color: #fafafa; /* Light gray for comment section background */
        border-radius: 10px;
    }

    /* Comments List */
    .comments-list {
        max-height: 300px;
        overflow-y: auto;
        padding-bottom: 20px;
        margin-bottom: 20px;
    }

    .comment {
        display: flex;
        align-items: flex-start;
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
        border: 2px solid #ff6f61; /* Pink border */
    }

    .comment-content {
        flex: 1;
        background-color: #fff;
        border-radius: 10px;
        padding: 10px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .comment-user {
        font-weight: bold;
        color: #333;
        margin-right: 5px;
    }

    .comment-text {
        margin: 0;
        color: #333;
    }

    .comment-time {
        color: #999;
        font-size: 0.85em;
        margin-top: 5px;
    }

    /* Comment Input */
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
        font-size: 14px;
        color: #333;
    }

    .comment-input button {
        align-self: flex-end;
        background-color: #ff6f61; /* Pink background */
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }

    .comment-input button:hover {
        background-color: #e55b50; /* Darker pink */
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            padding: 10px;
        }

        .comment {
            flex-direction: column;
            align-items: flex-start;
        }

        .comment-avatar {
            margin-bottom: 5px;
        }

        .comment-content {
            padding: 15px;
        }

        .comment-input textarea {
            font-size: 16px;
        }
    }
</style>

@section('content')
<div class="container">
    <h1>{{ $post->title }}</h1>

    <div class="post-content">
        <p>{{ $post->body }}</p>

        <div class="post-details">
            <p class="post-tags">Tags: {{ $post->tags }}</p>
            <p class="post-status">Status: {{ $post->status }}</p>
            <p class="post-approved">Approved: {{ $post->approved ? 'Yes' : 'No' }}</p>
            <p class="post-author">Author: {{ $post->user->name }}</p>
        </div>

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
