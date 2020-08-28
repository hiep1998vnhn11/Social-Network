<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\Like;
use App\Models\Post;
use App\Http\Services\PostService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class LikeController extends AppBaseController
{
    private $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    public function like(Post $post)
    {
        $success = 'Handle like successfully!';
        if($post->visible = 'blocked') return $this->sendMessageFail('This post was blocked by admin!');

        $isLiked = Like::where('user_id', auth()->user()->id)
            ->where('post_id', $post->id)
            ->first();
        if($isLiked){
            if($isLiked->status){ // liked and status = 1 => handleUnLike()
                $isLiked->status = 0;
                $isLiked->save();
                return $this->sendMessageSuccess($isLiked, $success);
            } 
            else{ //liked and status = 0 => handleLike()
                $isLiked->status = 1;
                $isLiked->save();
                return $this->sendMessageSuccess($isLiked, $success);
            }
        } else{ //hadn't liked =>create()
            $like = new Like;
            $like->user_id = auth()->user()->id;
            $like->post_id = $post->id;
            $like->save();
            return $this->sendMessageSuccess($like, $success);
        }
    }

    public function getLike(Request $request, Post $post)
    {
        if($post->visible = 'blocked') return $this->sendMessageFail('This post was blocked by admin!');
       $data = $this->postService->getLike($request->all(), $post->id);
       return $this->sendResponse($data);
    }

}
