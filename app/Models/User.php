<?php

namespace App\Models;

use App\Models\Blog\BlogComment;
use App\Models\Blog\BlogPost;
use App\Models\Forum\ForumQuestion;
use App\Models\Forum\ForumReply;
use App\Models\Profile\Profile;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Cache;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'verification_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return HasMany
     */
    public function forumQuestion()
    {
        return $this->hasMany(ForumQuestion::class);
    }

    /**
     * @return HasMany
     */
    public function replies()
    {
        return $this->hasMany(ForumReply::class);
    }

    /**
     * @return HasMany
     */
    public function blogPost()
    {
        return $this->hasMany(BlogPost::class);
    }

    /**
     * @return HasMany
     */
    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    /**
     * @return HasOne
     */
    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function send()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * @return HasMany
     */
    public function receive()
    {
        return $this->hasMany(Message::class, 'recipient_id');
    }

    /**
     * @return bool
     */
    public function isOnline()
    {
    	return Cache::has('user-is-online-' . $this->id);

    }

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @return BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    /**
     * @return BelongsToMany
     */
    public function dialogs()
    {
        return $this->belongsToMany(Dialog::class, 'dialog_user', 'user_id', 'dialog_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function($user){
            $user->slug = Str::slug($user->name);
        });
    }

    public function isAdmin()
    {
        $roles = $this->roles()->get();
        foreach ($roles as $v){
            if($v['name'] === 'ROLE_ADMIN') return true;
            else return false;
        }
    }

    public function isEditor()
    {
        $roles = $this->roles()->get();
        foreach ($roles as $v){
            if($v['name'] === 'ROLE_EDITOR' or $this->isAdmin()) return true;
            else return false;
        }
    }

    public function isCommentator()
    {
        $roles = $this->roles()->get();
        foreach ($roles as $v){
            if($v['name'] === 'ROLE_COMMENTATOR' or $this->isEditor()) return true;
            else return false;
        }
    }

}
