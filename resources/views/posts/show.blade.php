@extends('layouts.app')
@section('title',$post->title )
@section('content')
<div class="container">
    <h1 class="mb-0">{{ $post->title }}</h1>
    <p class="text-secondary">
        Wrote by: {{ $post->author->name }}
    </p>
    <div class="text-secondary">
        <a href="/categories/{{ $post->category->slug }}">{{ $post->category->name }}</a>
        &middot;{{ $post->created_at->format('d F, Y') }}
        &middot;
        @foreach ($post->tags as $tag)
        <a href="">{{$tag->name}}</a>
        @endforeach
        <hr> 
    </div>
    <p>{{ $post->body }}</p>
    @if(auth()->user()->id==$post->user_id)
    {{-- @if(auth()->user()->is($post->author)) sama saja --}} 
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
        Delete
    </button>
    
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/posts/{{ $post->slug }}/delete" method="post">
                        @csrf
                        @method("delete")
                        <div class="mb-3">
                            <div class="d-flex">
                                <div class="row">
                                    <div class="col-4">
                                        Title:
                                    </div>
                                    <div class="col">
                                        {{ $post->title }}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="row">
                                    <div class="col-4">
                                        Body:
                                    </div>
                                    <div class="col">
                                        {{ $post->body }}
                                    </div>
                                </div>
                            </div>
                            <div class="text-secondary">
                                <small>
                                    Published on {{ $post->created_at->format('d F Y') }}
                                </small>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-danger mr-2" type="submit">Yes</button>
                            <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection