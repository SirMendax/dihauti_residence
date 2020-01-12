<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class BlogCategory extends Model
{
    protected $fillable = ['name'];
    protected static function boot()
    {
        parent::boot();
        static::creating(function($blogCategory){
            $blogCategory->slug = Str::slug($blogCategory->name);
        });
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class);
    }
}
