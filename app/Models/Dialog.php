<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dialog extends Model
{
    protected $fillable = ['title', 'recipient_id'];

    public function users()
    {
        return $this->belongsToMany(User::class,'dialog_user');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
