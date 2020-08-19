<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sub_Comment extends Model
{
    protected $table = 'sub_comments';

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function comment(){
        return $this->belongsTo('App\Comment');
    }
}
