@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Post</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $post->title }}" required>
        </div>

        <div class="form-group">
            <label for="body">Body</label>
            <textarea name="body" id="body" class="form-control" rows="5" required>{{ $post->body }}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
            @if($post->image)
                <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" width="100">
            @endif
        </div>

        <div class="form-group">
            <label for="tags">Tags</label>
            <input type="text" name="tags" id="tags" class="form-control" value="{{ $post->tags }}">
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="active" {{ $post->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $post->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Post</button>
    </form>
</div>
@endsection
