<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Post;
use App\Http\Services\PostService;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PostController extends AppBaseController

{
    private $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getForClient(Request $request){
        if(!auth()->user()){
            $data = $this->postService->getPostForGuest($request->all());
            return $this->sendResponse($data);
        } //guest
        $isAdmin = 0;
        $admins = DB::table('admin')->select('user_id')->get();
        foreach($admins as $admin){
            if(auth()->user()->id == $admin->user_id) $isAdmin = 1;
        }

        if($isAdmin){// Admin
            $data = $this->postService->getPostForAdmin($request->all());
            return $this->sendResponse($data);
        } else {
            $data = $this->postService->getPostForUser($request->all());
            return $this->sendResponse($data);
        }
        
        
    }

    public function get(Request $request)
    {
        $data = $this->postService->get($request->all());
        return $this->sendResponse($data);
    }
    public function getForUser(Request $request)
    {
        $data = $this->postService->getPostForUser($request->all());
        return $this->sendResponse($data);
    }

    public function getForFriend(Request $request)
    {
        $data = $this->postService->getPostForFriend($request->all());
        return $this->sendResponse($data);
    }

    public function getForPublic(Request $request)
    {
        $data = $this->postService->getPostForUser($request->all());
        return $this->sendResponse($data);
    }

    public function getForAdmin(Request $request)
    {
        $data = $this->postService->getPostForAdmin($request->all());
        return $this->sendResponse($data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(PostRequest $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->imageUrl = $request->imageUrl;
        $post->visible = $request->visible;
        $post->user_id = auth()->user()->id;
        $post->save();

       $success = 'Create post successfully!';
       return $this->sendMessageSuccess($post, $success);
    }

    public function delete(Post $post)
    {
        $fail = 'Delete post permission denied!';
        $success = 'Delete post successfully';
        if(auth()->user()->id != $post->user_id){
            return $this->sendMessageFail($fail);
        }

        $post->delete();
        return $this->sendMessageSuccess($post,$success);
    }

    public function edit(PostRequest $request, Post $post)
    {
        $fail = 'Edit post permission denied!';
        $success = 'Edit post successfully';

        if(auth()->user()->id != $post->user_id){
            return $this->sendMessageFail($fail);
        }
        if($post->visible == 'blocked'){
            return $this->sendMessageFail('This post was block by Admin!');
        }
        $post->content = $request->content;
        $post->imageUrl = $request->imageUrl;
        if($request->visible)
            $post->visible = $request->visible;
        $post->update_at = Carbon::now()->toDateTimeString();
        $post->save();

        return $this->sendMessageSuccess($post, $success);
    }
}
