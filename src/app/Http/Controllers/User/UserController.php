<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\UserService;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\PostRequest;
use App\Http\Services\PostService;
use App\Post;
use App\User;
use Carbon\Carbon;

class UserController extends AppBaseController
{
    private $userService;
    private $postService;

    public function __construct(UserService $userService, PostService $postService)
    {
        $this->userService = $userService;
        $this->postService = $postService;
    }
    public function get(Request $request){
        $users = $this->userService->getUsers($request->all());
        return $this->sendResponse($users);
    }

    public function getInfoByUserId(User $user)
    {
        if($user->id == auth()->user()->id) return $this->sendResponse($user);
        $data = [
            'name' => $user->name,
            'url' => $user->url,
            'created_at' => $user->created_at
        ];
        return $this->sendResponse($data);
    }

    public function deletePost(Post $post)
    {
        $fail = 'Delete post permission denied!';
        $success = 'Delete post successfully';
        if(auth()->user()->id != $post->user_id){
            return $this->sendMessageFail($fail);
        }

        $post->delete();
        return $this->sendMessageSuccess($post,$success);
    }

    public function editPost(PostRequest $request, Post $post)
    {
        $fail = 'Edit post permission denied!';
        $success = 'edit post successfully';

        if(auth()->user()->id != $post->user_id){
            return $this->sendMessageFail($fail);
        }

        $post->content = $request->content;
        $post->imageUrl = $request->imageUrl;
        $post->update_at = Carbon::now()->toDateTimeString();
        $post->save();

        return $this->sendMessageSuccess($post, $success);
    }

}
