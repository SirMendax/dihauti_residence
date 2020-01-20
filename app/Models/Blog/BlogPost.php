<?php

namespace App\Models\Blog;

use App\Models\Like;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Str;
use App\Models\User;


class BlogPost extends Model
{
    protected $fillable = ['title', 'body','description', 'blog_category_id'];

    protected $with=['blogComments'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($blogPost) => $blogPost->slug = Str::slug($blogPost->title));
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function blogComments()
    {
        return $this->hasMany(BlogComment::class, 'blog_post_id')->latest();
    }
    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }
    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class);
    }
    public function getPathAttribute()
    {
        return "/blog/$this->slug";
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')->whereDate('published_at', '<=', today());
    }

//    public static function setExtract($string)
//    {
//        $start = 0;
//        $length = 120;
//        $trimmarker = '...';
//        $len = strlen(trim($string));
//        $newstring = ( ($len > $length) && ($len != 0) ) ? rtrim(mb_substr($string, $start, $length - strlen($trimmarker))) . $trimmarker : $string;
//        return $newstring;
//    }
}
