<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\UserService;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\PostRequest;
use App\Http\Services\PostService;
use App\Models\Post;
use App\User;
use Carbon\Carbon;
use App\Models\Friend;

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

    public function getForClient(Request $request){
        $data = $this->userService->getUsers($request->all());
        return $this->sendResponse($data);
    }

    public function getInfoByUserId(User $user)
    {
        if($user->id == auth('api')->user()->id) return $this->sendResponse($user);
        $data = [
            'name' => $user->name,
            'url' => $user->url,
            'created_at' => $user->created_at
        ];
        return $this->sendResponse($data);
    }

    public function handleFriend(Request $request)
    {
        $success = 'Handle like successfully!';
        $fail = 'Handle add friend fail! Something went wrong with server...';
        $message = $this->userService->handleFriend($request->all());
        if(!$message) return $this->sendMessageFail($fail);
        else return $this->sendMessageSuccess($message, $success);
    }

}
