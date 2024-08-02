@extends('layouts.app')

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f9f9f9;
        color: #333;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .list-group {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .list-group-item {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        width: calc(33.333% - 20px);
        display: flex;
        flex-direction: column;
    }

    .list-group-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .list-group-item img {
        width: 100%;
        height: auto;
        border-bottom: 1px solid #ddd;
    }

    .list-group-item h5 {
        margin: 15px;
        font-size: 1.2em;
        color: #333;
    }

    .list-group-item p {
        margin: 0 15px 15px;
        color: #666;
    }

    .btn {
        display: inline-block;
        border-radius: 50px;
        padding: 8px 16px;
        font-size: 0.875em;
        text-transform: uppercase;
        font-weight: bold;
        text-align: center;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .btn-primary {
        background-color: #e91e63;
        color: #fff;
        margin-right: 5px;
    }

    .btn-primary:hover {
        background-color: #c2185b;
    }

    .btn-secondary {
        background-color: #f5f5f5;
        color: #e91e63;
    }

    .btn-secondary:hover {
        background-color: #e0e0e0;
    }

    .btn-warning, .btn-danger {
        margin-right: 5px;
    }

    .icon {
        font-size: 1.2em;
        margin-right: 0.5em;
    }

    .icon-like {
        color: #f39c12;
    }

    .icon-comment {
        color: #3498db;
    }

    .d-flex {
        display: flex;
    }

    .justify-content-between {
        justify-content: space-between;
    }

    .align-items-center {
        align-items: center;
    }

    .status-button {
        font-size: 0.875em;
        border-radius: 50px;
        padding: 5px 10px;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    .btn-approve {
        background-color: #28a745;
    }

    .btn-approve:hover {
        background-color: #218838;
    }

    .btn-disapprove {
        background-color: #dc3545;
    }

    .btn-disapprove:hover {
        background-color: #c82333;
    }

    .comments-section {
        margin-top: 10px;
        padding: 10px 15px;
        background-color: #f8f9fa;
        border-top: 1px solid #ddd;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .comments-list {
        max-height: 150px;
        overflow-y: auto;
        margin-bottom: 10px;
    }

    .comment {
        padding: 5px 0;
    }

    .comment-user {
        font-weight: bold;
        margin-right: 5px;
    }

    .comment-text {
        color: #555;
    }

    .comment-input {
        display: flex;
        align-items: center;
    }

    .comment-input textarea {
        width: 100%;
        border: none;
        border-radius: 20px;
        padding: 5px 10px;
        resize: none;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .comment-input button {
        margin-left: 10px;
    }

    @media (max-width: 768px) {
        .list-group-item {
            width: calc(50% - 20px);
        }
    }

    @media (max-width: 480px) {
        .list-group-item {
            width: 100%;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

@section('content')
<div class="container">
    @if(!auth()->user()->hasRole('superadmin'))
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Create Post</a>
    @endif
    <ul class="list-group mt-3">
        @foreach($posts as $post)
        <li class="list-group-item">
            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
            @endif
            <h5><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></h5>
            <p>Status: {{ $post->status }}</p>

            @if(Auth::user()->id == $post->user_id || Auth::user()->hasRole('superadmin'))
                <div class="d-flex justify-content-between align-items-center">
                    @if(!auth()->user()->hasRole('superadmin'))
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    @endif

                    @if(auth()->user()->hasRole('superadmin'))
                        @if($post->approved)
                            <form action="{{ route('posts.disapprove', $post->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn status-button btn-disapprove">Disapprove</button>
                            </form>
                        @else
                            <form action="{{ route('posts.approve', $post->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn status-button btn-approve">Approve</button>
                            </form>
                        @endif
                    @endif
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mt-2">
                @if($post->likes->contains(auth()->user()->id))
                    <form action="{{ route('posts.unlike', $post->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-secondary"><i class="fas fa-thumbs-down"></i> Unlike</button>
                    </form>
                @else
                    <form action="{{ route('posts.like', $post->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary"><i class="fas fa-thumbs-up"></i> Like</button>
                    </form>
                @endif
                <span class="icon icon-comment"><i class="fas fa-comments"></i> {{ $post->likes->count() }} Likes</span>
            </div>

            <!-- Comments Section -->
            <div class="comments-section">
                <div class="comments-list">
                    @foreach($post->comments as $comment)
                        <div class="comment">
                            <span class="comment-user">{{ $comment->user->name }}</span>
                            <span class="comment-text">{{ $comment->content }}</span>
                        </div>
                    @endforeach
                </div>
                {{-- <form action="{{ route('comments.store', ['post' => $post->id]) }}" method="POST">
                    @csrf
                    <textarea name="content" required></textarea>
                    <button type="submit">Add Comment</button>
                </form> --}}
                <form action="{{ route('comments.store', $post->id) }}" method="POST" class="comment-input">
                    @csrf
                    <textarea name="content" rows="1" placeholder="Add a comment..." required></textarea>
                    <button type="submit" class="btn btn-primary">Post</button>
                </form>

            </div>
        </li>
        @endforeach
    </ul>
</div>
@endsection
