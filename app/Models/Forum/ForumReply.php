<?php

namespace App\Models\Forum;

use App\Models\Like;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ForumReply extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($reply){
            $reply->user_id = auth("api")->user()->id;
        });
    }
    protected $fillable = ['user_id', 'body'];

    public function forumQuestion()
    {
        return $this->belongsTo(ForumQuestion::class);
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
