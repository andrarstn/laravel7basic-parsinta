@extends('layouts.app')
@section('title', 'Posts')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">New Post</div>
                <div class="card-body">
                    <form action="/posts/store" method="post">
                        @csrf
                        @include('posts.partials.form-control', ['post'=>new \App\Post(),'submit' => 'Create'])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection