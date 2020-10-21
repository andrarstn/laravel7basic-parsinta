<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'slug','body','category_id', 'thumbnail'];
    protected $with = ['author', 'category','tags'];

    public function category()
    {
        return $this->belongsTo(Category::class);
        //sebenarnya return $this->belongsTo(Category::class, 'category_id');
    }
    
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeLatestFirst()
    {
        return $this->latest()->first();
    }

    public function takeImage()
    {
        return "/storage/".$this->thumbnail;
    }
}
