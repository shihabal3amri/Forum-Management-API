<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateMessage extends Model
{
    protected $fillable = ['sender_id', 'receiver_id', 'message'];

    // A message is sent by a user (sender)
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // A message is received by a user (receiver)
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}

