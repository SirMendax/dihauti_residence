<?php

namespace App\Models\Blog;

use App\Models\Like;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class BlogComment extends Model
{
    protected $fillable = ['body'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($comment){
            $comment->user_id = auth("api")->user()->id;
        });
    }

    public function blogPost()
    {
        return $this->belongsTo(BlogPost::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }
}
