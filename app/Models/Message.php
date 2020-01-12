<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['text', 'sender_id', 'recipient_id', 'dialog_id'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'to_id');
    }

    public function dialog()
    {
        return $this->belongsTo(Dialog::class);
    }
}
