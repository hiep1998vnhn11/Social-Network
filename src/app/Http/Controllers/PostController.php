<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Post;
use App\User;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware('auth:api', ['except' => ['login']]);
    }


    public function get()
    {
        return $this->respondWithPostByUserId(auth()->user()->id);
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
        $post->visible = $request->visible;
        $post->user_id = auth()->user()->id;
        $post->save();
        return response()->json([
            'success' => 'Create Post successfully!'
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
    public function show(User $user)
    {
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
    public function update(PostRequest $request, Post $post)
    {
        if($post->user_id != auth()->user()->id)
            return response()->json(['error' => 'Can not edit post of other user!']);
        $post->content = $request->content;
        $post->visible = $request->visible;
        $post->save();
        return response()->json(['success' => 'Update Post successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json([
            'success' => 'Delete Post successfully!'
        ]);
    }

    public function getPostByUserId($id){
        return response()->json(
            Post::orderBy('created_at', 'desc')->where('user_id', $id)->get()
        );
    }

    protected function respondWithPostByUserId($id){
        return response()->json(Post::orderBy('created_at', 'desc')->where('user_id', $id)->get());
    }
}
