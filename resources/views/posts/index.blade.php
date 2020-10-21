@extends('layouts.app')
@section('title', 'Posts')
@section('content')
<div class="container">
    @if ($posts->count())
    <div class="d-flex justify-content-between">
        <div>
            @isset($category)
            <h4>Category: {{ $category->name }}</h4>
            @else
            <h4>All Post</h4>
            @endisset
            <hr>
        </div>
        <div>
            @auth
            <a href="{{ route('posts.create') }}" class="btn btn-primary">New Post</a>
            @else
            <a href="/login" class="btn btn-primary">Login</a>
            @endauth
        </div>
    </div>
    <div class="row">
        @foreach ($posts as $post)
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    <strong>{{ $post->title }}</strong>
                </div>
                <img style="height: 300px" class="card-img-top" src="{{ $post->takeImage() }}" alt="">
                <div class="card-body">
                    <div>
                        {{ Str::limit($post->body, 100) }}
                    </div>
                    <a href="/posts/{{ $post->slug }}">Read More</a>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    {{-- Published on {{ $post->created_at->format('d F Y') }} --}}
                    Published on {{ $post->created_at->diffForHumans() }}
                    @can('update', $post)
                    <a href="/posts/{{ $post->slug }}/edit" class="btn btn-sm btn-success">Edit</a>
                    @endcan
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        {{ $posts->links() }}
    </div>
    @else
    <div class="alert alert-warning text-center">There are no posts</div>
    <div>
        @auth
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Add New Post</a>
        @else
        <a href="/login" class="btn btn-primary">Login</a>
        @endauth
    </div>
    @endif

</div>
@endsection