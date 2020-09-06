<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chats';

    public function room(){
        return $this->belongsTo('App\Models\Room', 'room_id');
    }

    public function sent(){
        return $this->belongsTo('App\User', 'sent_id');
    }

}
