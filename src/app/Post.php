<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'content'
    ];

    protected $table = 'posts';

    public function user(){
        return $this->belongsTo('\App\User', 'user_id');
    }

    public function like(){
        return $this->hasMany('App\Like', 'post_id', 'id');
    }

    public function comment(){
        return $this->hasMany('App\Comment', 'post_id', 'id');
    }
}
