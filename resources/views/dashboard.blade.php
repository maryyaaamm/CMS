<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9; /* Light background */
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background-color: #e91e63;
            color: #fff;
            padding: 20px;
            font-size: 1.5rem;
            text-align: center;
        }

        .card-body {
            padding: 20px;
            text-align: center;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 25px;
            text-transform: uppercase;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin: 10px 5px;
        }

        .btn-primary {
            background-color: #e91e63;
            color: #fff;
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

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .card-header {
                font-size: 1.2rem;
                padding: 15px;
            }

            .card-body {
                padding: 15px;
            }

            .btn {
                padding: 8px 16px;
                margin: 8px 4px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                @if(auth()->user()->hasRole('superadmin'))
                    Superadmin Dashboard
                @else
                    User Dashboard
                @endif
            </div>
            <div class="card-body">
                <p>Welcome, {{ auth()->user()->name }}!</p>
                <p>
                    @if(auth()->user()->hasRole('superadmin'))
                        Here you can manage the website and approve posts.
                    @else
                        You can create and manage your posts.
                    @endif
                </p>
                <div>
                    @if(auth()->user()->hasRole('superadmin'))
                        <a href="{{ route('posts.index') }}" class="btn btn-primary">Manage Posts</a>
                        <a href="{{ route('posts.manageuser') }}" class="btn btn-primary">User management</a></a>
                    @else
                        <a href="{{ route('posts.create') }}" class="btn btn-primary">Create Post</a>
                        <a href="{{ route('posts.index') }}" class="btn btn-secondary">View My Posts</a>
                    @endif
                    <a href="{{ route('posts.feed') }}" class="btn btn-primary">Feed</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
