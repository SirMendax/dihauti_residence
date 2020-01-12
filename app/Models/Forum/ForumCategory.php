<?php

namespace App\Models\Forum;

use Illuminate\Database\Eloquent\Model;
use Str;

class ForumCategory extends Model
{
    protected $fillable = ['name'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function($forumCategory){
            $forumCategory->slug = Str::slug($forumCategory->name);
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function forumQuestions()
    {
        return $this->hasMany(ForumQuestion::class);
    }
}
