<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Like;
use App\Post;
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
    public function handleLike(Post $post)
    {
        $success = 'Handle like successfully!';
        $fail = 'Handle like failed! You can only like one time!';
        $likes = DB::table('likes')->where('user_id', auth()->user()->id)->value('user_id');
        if($likes){
            return $this->sendMessageFail($fail);
        }

        $like = new Like;
        $like->user_id = auth()->user()->id;
        $like->post_id = $post->id;
        $like->save();

        return $this->sendMessageSuccess($like, $success);
    }

    public function getLike(Request $request, Post $post)
    {
       $data = $this->postService->getLike($request->all(), $post->id);
       return $this->sendResponse($data);
    }

    public function handleUnlike(Like $like)
    {
        $success = 'Handle unlike successfully!';
        $fail = 'Handle unlike failed! You do not like any time!';
        $likes = DB::table('likes')->where('user_id', auth()->user()->id)->value('id');
        if(!$likes){
            return $this->sendMessageFail($fail);
        }

        if($like->user_id != auth()->user()->id){
            return $this->sendMessageFail('You can unlike other user like!');
        }

        $like->delete();
    }
}
