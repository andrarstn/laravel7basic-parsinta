<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\{Post, Category, Tag};
use Illuminate\Http\Request;

class PostController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth')->except(['index','show']);
    // }

    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(6);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create', [
            'post' => new Post(),
            'categories' => Category::get(),
            'tags' => Tag::get(),
        ]);
    }

    public function store(PostRequest $request)
    {
        // redirect()->to('posts');
        // $request->validate([
        //     'title' =>' required|min:3',
        //     'body' =>' required|min:3'
        // ]);
        // Post::create([
        //     'title' => $request->title,
        //     'slug' => \Str::slug($request->title),
        //     'body' => $request->body,
        // ]);
        // $attr = request()->validate([
        //     'title' =>' required|min:3',
        //     'body' =>' required|min:3'
        // ]);
        // $attr = $this->validateRequest();

        $attr = $request->all();

        $attr['slug'] = \Str::slug(request('title'));
        $attr['category_id'] = request('category');

        $post = Post::create($attr);
        $post->tags()->attach(request('tags'));

        session()->flash('success', 'The post was created');
        return back();
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', [
            'post' => $post,
            'categories' => Category::get(),
            'tags' => Tag::get(),
        ]);
    }

    public function update(Request $request, Post $post)
    {
        // $attr = request()->validate([
        //     'title' =>' required|min:3',
        //     'body' =>' required|min:3'
        // ]);
        // $attr = $this->validateRequest();

        $attr = $request->all();
        $attr['category_id'] = request('category');
        $post->update($attr);
        $post->tags()->sync(request('tags'));

        session()->flash('success', 'The post was updated');
        return redirect('posts');
    }

    public function destroy(Post $post)
    {
        $post->tags()->detach();
        $post->delete();
        session()->flash('success', 'The post was deleted');
        return redirect('posts');
    }

    // public function validateRequest()
    // {
    //     return request()->validate([
    //         'title' =>' required|min:3',
    //         'body' =>' required|min:3'
    //     ]);
    // }
}
