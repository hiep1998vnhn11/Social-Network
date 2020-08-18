<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{

    protected $table = 'likes';
    protected $fillable = [
        'user_id', 'post_id', 'key'
    ];

    public function post(){
        return $this->belongsTo('App\Post', 'post_id');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
