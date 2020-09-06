<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'message_rooms';

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function user_with(){
        return $this->belongsTo('App\User', 'with_id');
    }

    public function chat(){
        return $this->hasMany('App\Models\Chat', 'room_id', 'id');
    }
}
