<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Active Posts</title>
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-xxxx" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #fafafa; /* Light grey background */
            color: #333;
            margin: 0;
            padding: 0;
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
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: calc(33.333% - 20px);
            display: flex;
            flex-direction: column;
            padding: 10px;
            position: relative;
        }

        .list-group-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .post-img {
            width: 100%;
            height: auto;
            border-bottom: 2px solid #ddd;
        }

        .list-group-item h5 {
            font-size: 1.1em;
            color: #333;
            margin: 10px 0;
            font-weight: bold;
        }

        .list-group-item p {
            margin: 0;
            color: #666;
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

        .comments-section {
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #fff;
            border-top: 1px solid #ddd;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
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
            color: #333;
        }

        .comment-text {
            color: #666;
        }

        .comment-input {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .comment-input textarea {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 20px;
            padding: 5px 10px;
            resize: none;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
            margin-right: 10px;
        }

        .comment-input button {
            background: #e91e63;
            /* Pink background */
            border: none;
            border-radius: 20px;
            padding: 8px 15px;
            color: #fff;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .comment-input button:hover {
            background: #c2185b;
            /* Darker pink on hover */
        }

        .like-button {
            background: #e91e63;
            /* Pink background */
            border: none;
            border-radius: 20px;
            padding: 8px 15px;
            color: #fff;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .like-button:hover {
            background: #c2185b;
            /* Darker pink on hover */
        }

        .auth-links {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 20px;
        }

        .auth-link {
            display: inline-block;
            padding: 5px 10px;
            color: #fff;
            background-color: #e91e63;
            border-radius: 20px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .auth-link:hover {
            background-color: #c2185b;
        }

        .auth-link.ml-4 {
            margin-left: 10px;
        }

        @media (max-width: 992px) {
            .list-group-item {
                width: calc(50% - 20px);
            }
        }

        @media (max-width: 768px) {
            .list-group-item {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .list-group-item {
                width: 100%;
                padding: 15px;
            }

            .post-img {
                height: auto;
            }
        }
    </style>
</head>

<body class="antialiased">
    <div class="relative flex items-top justify-center min-h-screen sm:items-center py-4 sm:pt-0">
        <div class="container">
            @if (Route::has('login'))
                <div class="fixed top-0 right-0 px-6 py-4 sm:block auth-links">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="auth-link">Dashboard</a>
                        <a href="{{ route('logout') }}" class="auth-link ml-4"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Log out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="auth-link">Log in</a>
                        <a href="{{ route('register') }}" class="auth-link ml-4">Register</a>
                    @endauth
                </div>
            @endif

            <h2 class="my-4">Active Posts</h2>

            <ul class="list-group">
                @foreach ($posts as $post)
                    @if ($post->status == 'active' && $post->approved)
                        <li class="list-group-item">
                            @if ($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                                    class="post-img">
                            @endif
                            <h5><a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none">{{ $post->title }}</a></h5>
                            <p>{{ $post->body }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span>Status: {{ $post->status }}</span>
                                @auth
                                    <button id="like-button-{{ $post->id }}" data-post-id="{{ $post->id }}"
                                        class="like-button {{ $post->likes->contains(auth()->user()->id) ? 'btn-secondary' : 'btn-primary' }}">
                                        <i class="fas {{ $post->likes->contains(auth()->user()->id) ? 'fa-thumbs-down' : 'fa-thumbs-up' }}"></i>
                                        {{ $post->likes->contains(auth()->user()->id) ? 'Unlike' : 'Like' }}
                                    </button>
                                @endauth
                            </div>
                            <div class="comments-section mt-3">
                                <div class="comments-list">
                                    @foreach ($post->comments as $comment)
                                        <div class="comment">
                                            <span class="comment-user">{{ $comment->user->name }}</span>
                                            <span class="comment-text">{{ $comment->content }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                @auth
                                    <form action="{{ route('comments.store', $post->id) }}" method="POST"
                                        class="comment-input mt-2">
                                        @csrf
                                        <textarea name="content" rows="1" placeholder="Add a comment..." required></textarea>
                                        <button type="submit">Post</button>
                                    </form>
                                @endauth
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js
