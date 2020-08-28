<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function post(){
        return $this->belongsTo('App\Models\Post');
    }

    public function sub_comment(){
        return $this->hasMany('App\Models\Sub_Comment', 'comment_id', 'id');
    }

}
