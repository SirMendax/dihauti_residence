<?php

namespace App\Models\Forum;

use Illuminate\Database\Eloquent\Model;
use Str;

/**
 * @OA\Schema(
 *     description="ForumCategory model",
 *     type="object",
 *     title="Category for forum",
 * )
 */
class ForumCategory extends Model
{
    /**
     * @OA\Property(format="int64")
     * @var int
     */
    public $id;

    /**
     * @OA\Property(format="string")
     * @var string
     */
    public $name;

    /**
     * @OA\Property(format="string")
     * @var string
     */
    public $slug;

    protected $fillable = ['name', 'slug'];

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
