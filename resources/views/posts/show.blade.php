@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $post->title }}</h1>

    <div>
        <p>{{ $post->body }}</p>
        <p>Tags: {{ $post->tags }}</p>
        <p>Status: {{ $post->status }}</p>
        <p>Approved: {{ $post->approved ? 'Yes' : 'No' }}</p>
        <p>Author: {{ $post->user->name }}</p>
        @if($post->image)
            <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" width="300">
        @endif
    </div>
</div>
@endsection
