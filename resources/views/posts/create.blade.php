@extends('layouts.app')

<style>
    .container {
        max-width: 600px;
        margin: auto;
        padding: 20px;
        background: #fff; /* White background for the form container */
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
        color: #e91e63; /* Pink color for labels */
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #f8bbd0; /* Light pink border */
        padding: 10px;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus {
        border-color: #e91e63; /* Pink border on focus */
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        outline: none;
    }

    .btn-primary {
        background: #e91e63; /* Pink background */
        color: #fff;
        border: none;
        border-radius: 50px;
        padding: 10px 20px;
        font-size: 1em;
        text-transform: uppercase;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background: #c2185b; /* Darker pink for hover */
    }

    .alert {
        background: #fce4ec; /* Light pink background */
        color: #c2185b; /* Darker pink text */
        border: 1px solid #f8bbd0; /* Light pink border */
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .alert ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .alert li {
        margin-bottom: 5px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            padding: 10px;
        }
    }
</style>

@section('content')
<div class="container">
    <h1>Create Post</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="body">Body</label>
            <textarea name="body" id="body" class="form-control" rows="5" required>{{ old('body') }}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <div class="form-group">
            <label for="tags">Tags</label>
            <input type="text" name="tags" id="tags" class="form-control" value="{{ old('tags') }}">
        </div>

        @if (auth()->user()->hasRole('superadmin'))
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        @else
            <input type="hidden" name="status" value="inactive"> <!-- Default status for regular users -->
        @endif

        <button type="submit" class="btn btn-primary">Create Post</button>
    </form>
</div>
@endsection
