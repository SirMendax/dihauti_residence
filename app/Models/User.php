<?php

namespace App\Models;

use App\Models\Blog\BlogComment;
use App\Models\Blog\BlogPost;
use App\Models\Forum\ForumQuestion;
use App\Models\Forum\ForumReply;
use App\Models\Profile\Profile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
    protected $fillable = ['id',
        'name', 'email', 'password', 'verification_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    protected static function boot()
    {
        parent::boot();
        static::created(function ($user) {
            $role = Role::where('name', 'ROLE_NO_VERIFY')->first();
            $user->roles()->attach($role->id);
            $user->profile()->create();
        });
        static::creating(fn($user) => $user->slug = 'id:'.$user->id);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @return bool
     */
    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);

    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeVerified($query)
    {
        return $query->where('verified', TRUE);
    }

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


    public function isBanned()
    {
        $roles = $this->roles()->get();
        foreach ($roles as $v){
            if($v['name'] === 'ROLE_BANNED') return true;
            else return false;
        }
    }

    public function isNoVerify()
    {
        $roles = $this->roles()->get();
        foreach ($roles as $v){
            if($v['name'] === 'ROLE_NO_VERIFY') return true;
            else return false;
        }
    }

    public function isAdmin()
    {
        $roles = $this->roles()->get();
        foreach ($roles as $v){
            if($v['name'] === 'ROLE_ADMIN') return true;
            elseif($this->isBanned() or $this->isNoVerify()) return false;
            else return false;
        }
    }

    public function isModerator()
    {
        $roles = $this->roles()->get();
        foreach ($roles as $v){
            if($v['name'] === 'ROLE_MODERATOR' or $this->isAdmin()) return true;
            elseif($this->isBanned() or $this->isNoVerify()) return false;
            else return false;
        }
    }

    public function isEditor()
    {
        $roles = $this->roles()->get();
        foreach ($roles as $v){
            if($v['name'] === 'ROLE_EDITOR' or $this->isModerator()) return true;
            elseif($this->isBanned() or $this->isNoVerify()) return false;
            else return false;
        }
    }

    public function isCommentator()
    {
        $roles = $this->roles()->get();
        foreach ($roles as $v){
            if($v['name'] === 'ROLE_COMMENTATOR' or $this->isEditor()) return true;
            elseif($this->isBanned() or $this->isNoVerify()) return false;
            else return false;
        }
    }

}
