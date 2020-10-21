<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\{Post, Category, Tag};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth')->except(['index','show']);
    // }

    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(6);
        return view('posts.index', [
            'posts' => Post::with('author','tags', 'category')->orderBy('id', 'desc')->paginate(6),
        ]);
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
        $request->validate([
            'thumbnail' => 'image|mimes:jpeg,png,jpg,svg|max:2048'
        ]);

        $attr = $request->all();
        $slug =\Str::slug(request('title'));
        
        $thumbnail = request()->file('thumbnail');
        if ($thumbnail) {
            $thumbnailUrl = $thumbnail->store("images/posts");
        }else{
            $thumbnailUrl='';
        }
        // $thumbnailUrl = $thumbnail->storeAs("images/posts", "{$slug}.{$thumbnail->extension()}");

        $attr['slug'] = $slug;
        $attr['category_id'] = request('category');
        $attr['thumbnail'] = $thumbnailUrl;
        $attr['user_id'] = auth()->id();

        $post = auth()->user()->posts()->create($attr);
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
        $this->authorize('update',$post);
        
        $thumbnail = request()->file('thumbnail');
        if ($thumbnail) {
            \Storage::delete($post->thumbnail);
            $thumbnailUrl = $thumbnail->store("images/posts");
        }else {
            $thumbnailUrl = $post->thumbnail;
        }

        $attr = $request->all();
        $slug =\Str::slug(request('title'));


        $attr['slug'] = $slug;
        $attr['thumbnail'] = $thumbnailUrl;

        $post->update($attr);
        $post->tags()->sync(request('tags'));

        session()->flash('success', 'The post was updated');
        return redirect('posts');
    }

    public function destroy(Post $post)
    {
        if(auth()->user()->is($post->author)){
            $post->tags()->detach();
            $post->delete();
            \Storage::delete($post->thumbnail);
            session()->flash('success', 'The post was deleted');
            return redirect('posts');
        }else {
            session()->flash('error', "it wasn't your post");
            return redirect('posts');
        }
    }

    // public function validateRequest()
    // {
    //     return request()->validate([
    //         'title' =>' required|min:3',
    //         'body' =>' required|min:3'
    //     ]);
    // }
}
