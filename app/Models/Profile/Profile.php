<?php

namespace App\Models\Profile;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';

    protected $fillable = [
        'first_name', 'sex', 'city', 'quote', 'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
