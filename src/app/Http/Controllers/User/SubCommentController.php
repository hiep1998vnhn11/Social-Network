<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CommentRequest;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Sub_Comment;

class SubCommentController extends AppBaseController
{

    public function __construct()
    {

    }
    public function get()
    {

    }

    public function create(CommentRequest $request, Comment $comment)
    {
        $sub_comment = new Sub_Comment();
        $sub_comment->user_id = auth()->user()->id;
        $sub_comment->comment_id = $comment->id;
        $sub_comment->content = $request->content;
        $sub_comment->save();

        return $this->sendMessageSuccess($sub_comment, 'Create Sub comment successfully!');
    }

    public function edit(CommentRequest $request, Comment $comment, Sub_Comment $sub_Comment)
    {
        if($sub_Comment->user_id != auth()->user()->id)
            return $this->sendMessageFail('Edit Sub comment permission denied!');
        
        if($sub_Comment->comment_id != $comment->id)
            return $this->sendMessageFail('Edit Sub comment permission denied!');
        $sub_Comment->content = $request->content;
        $sub_Comment->save();
        return $this->sendMessageSuccess($sub_Comment, 'Update sub comment successfully!');
    }

    public function delete(Comment $comment, Sub_Comment $sub_Comment)
    {
        if($sub_Comment->user_id != auth()->user()->id)
            return $this->sendMessageFail('Delete Sub comment permission denied!');
        if($sub_Comment->comment_id != $comment->id)
            return $this->sendMessageFail('Delete Sub comment permission denied!');

        $sub_Comment->delete();
        return $this->sendMessageSuccess($sub_Comment, 'Delete sub comment successfully!');
    }
}
