<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    protected $table = 'messages';
    protected $fillable = [
        'user_id', 'post_id', 'content'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
