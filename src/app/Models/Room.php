<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'message_rooms';

    public function user_sent(){
        return $this->belongsTo('App\User', 'sent');
    }

    public function user_to(){
        return $this->belongsTo('App\User', 'to');
    }

    public function chat(){
        return $this->hasMany('App\Models\Chat', 'room_id', 'id');
    }
}
