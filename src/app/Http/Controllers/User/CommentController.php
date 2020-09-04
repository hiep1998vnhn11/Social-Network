<?php

namespace App\Http\Controllers\User;

use App\Models\Comment;
use App\Models\Post;
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
    
    public function create(CommentRequest $request,Post $post)
    {
        if($post->visible == 'blocked') return $this->sendMessageFail('This post was blocked by admin!');
        $comment = new Comment();
        $comment->post_id = $post->id;
        $comment->user_id = auth('api')->user()->id;
        $comment->content = $request->content;
        $comment->save();

        $success = 'Create comment successfully';
        return $this->sendMessageSuccess($comment, $success);
    }

    public function edit(CommentRequest $request, Comment $comment)
    {
        $fail = 'Edit comment fail!';
        $success = 'Update comment successfully!';
        if($comment->user_id != auth('api')->user()->id){
            return $this->sendMessageFail($fail);
        }

        $comment->content = $request->content;
        $comment->save();

        return $this->sendMessageSuccess($comment, $success);
    }

    public function delete(Post $post, Comment $comment)
    {
        $fail='Delete comment fail';
        $success='Delete comment successfully';
        if($comment->user_id != auth('api')->user()->id | $comment->post_id != $post->id)
            return $this->sendMessageFail($fail);

        $comment->delete();
        return $this->sendMessageSuccess($comment, $success);
    }
}
