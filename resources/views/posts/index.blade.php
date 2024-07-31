@extends('layouts.app')

<style>
    .container {
        padding: 0 15px;
    }

    .list-group {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .list-group-item {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 300px;
        transition: transform 0.2s ease;
    }

    .list-group-item:hover {
        transform: scale(1.02);
    }

    .list-group-item img {
        width: 100%;
        height: auto;
        border-bottom: 1px solid #ddd;
    }

    .list-group-item h5 {
        margin: 15px;
        font-size: 1.2em;
    }

    .list-group-item p {
        margin: 0 15px 15px;
        color: #666;
    }

    .btn {
        border-radius: 50px;
        padding: 8px 16px;
        font-size: 0.875em;
        text-transform: uppercase;
    }

    .btn-primary {
        background: #3490dc;
        color: #fff;
        border: none;
    }

    .btn-primary:hover {
        background: #2779bd;
    }

    .btn-secondary {
        background: #6c757d;
        color: #fff;
        border: none;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    .icon {
        font-size: 1.2em;
        margin-right: 0.5em;
        color: #666;
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
        background: #28a745;
    }

    .btn-approve:hover {
        background: #218838;
    }

    .btn-disapprove {
        background: #dc3545;
    }

    .btn-disapprove:hover {
        background: #c82333;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

@section('content')
<div class="container">
    <h1>Posts</h1>
    @if(!auth()->user()->hasRole('superadmin'))
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Create Post</a>
    @endif
    <ul class="list-group mt-3">
        @foreach($posts as $post)
        <li class="list-group-item">
            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="img-fluid">
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

                    <!-- Like and Comment Icons -->
                    <div>
                        <span class="icon icon-like"><i class="fas fa-thumbs-up"></i> Like</span>
                        <span class="icon icon-comment"><i class="fas fa-comments"></i> Comment</span>
                    </div>
                </div>
            @endif
        </li>
        @endforeach
    </ul>
</div>
@endsection
