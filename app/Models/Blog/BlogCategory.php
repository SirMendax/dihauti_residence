<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations\OpenApi;
use Str;


/**
 * @OA\Schema(
 *     description="BlogCategory model",
 *     type="object",
 *     title="Category for blog",
 * )
 */
class BlogCategory extends Model
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
