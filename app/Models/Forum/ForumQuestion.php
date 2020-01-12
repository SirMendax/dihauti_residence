<?php

namespace App\Models\Forum;

use App\Models\Like;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\User;

class ForumQuestion extends Model
{
    protected $fillable = ['title', 'slug', 'body', 'user_id', 'forum_category_id'];
    protected $with=['replies'];
    protected static function boot()
    {
        parent::boot();
        static::creating(function($question){
            $question->slug = Str::slug($question->title);
        });
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function replies()
    {
        return $this->hasMany(ForumReply::class, 'forum_question_id')->latest();
    }
    public function forumCategory()
    {
        return $this->belongsTo(ForumCategory::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }

    public function getPathAttribute()
    {
        return "/forum/$this->slug";
    }
    public static function setExtract($string)
    {
        $start = 0;
        $length = 120;
        $trimmarker = '...';
        $len = strlen(trim($string));
        $newstring = ( ($len > $length) && ($len != 0) ) ? rtrim(mb_substr($string, $start, $length - strlen($trimmarker))) . $trimmarker : $string;
        return $newstring;
    }
}
