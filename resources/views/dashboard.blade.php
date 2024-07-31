<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Layout</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(auth()->user()->hasRole('superadmin'))
                        <h3 class="text-2xl mb-4">Superadmin Dashboard</h3>
                        <p>Welcome, {{ auth()->user()->name }}! Here you can manage the website and approve posts.</p>
                        <a href="{{ route('posts.index') }}" class="btn-primary">Manage Posts</a>
                    @else
                        <h3 class="text-2xl mb-4">User Dashboard</h3>
                        <p>Welcome, {{ auth()->user()->name }}! You can create and manage your posts.</p>
                        <a href="{{ route('posts.create') }}" class="btn-primary">Create Post</a>
                        <a href="{{ route('posts.index') }}" class="btn-secondary">View My Posts</a>
                        @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
