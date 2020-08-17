<?php

namespace App\Http\Controllers\User;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Services\PostService;
use App\Http\Requests\CommentRequest;


class CommentController extends AppBaseController
{
    private $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    
    public function createComment(CommentRequest $request,Post $post)
    {
        $comment = new Comment();
        $comment->post_id = $post->id;
        $comment->user_id = auth()->user()->id;
        $comment->content = $request->content;
        $comment->save();

        $success = 'Create comment successfully';
        return $this->sendMessageSuccess($comment, $success);
    }

    public function getComment(Request $request,Post $post)
    {
        $data = $this->postService->getComment($request->all(), $post->id);
        return $this->sendResponse($data);
    }
}
