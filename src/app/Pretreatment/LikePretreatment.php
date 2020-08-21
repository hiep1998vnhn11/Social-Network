<?php

namespace App\Pretreatment;
use App\Like;
use App\Post;
use App\User;
use Illuminate\Support\Facades\DB;

class LikePretreatment {
    public function __construct()
    {
    }
    public function checkLiked(Post $post)
    {
        $likes = DB::table('likes')->get();
    }
}
