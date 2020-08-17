<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Services\PostService;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\PostRequest;

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

    public function getForFeed(Request $request)
    {
        $data = $this->postService->getPostForFeed($request->all());
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

        return response()->json([
            'success' => true,
            'message' => 'Create post success!',
            'data' => $post
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
