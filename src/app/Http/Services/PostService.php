<?php

namespace App\Http\Services;

use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;
use App\Models\Post;
use App\Consts;
use App\Models\Like;
use App\Models\Sub_Comment;
use Illuminate\Support\Facades\DB;
class PostService {

    public function get($param){
        $limit = Arr::get($param, 'limit', Consts::DEFAULT_PER_PAGE);
        $userID = Arr::get($param, 'user_id', null);
        $searchKey = Arr::get($param, 'search_key', null);
        $visible = Arr::get($param, 'visible', 'public');

        $query = Post::join('users', 'posts.user_id', 'users.id')
            ->select('posts.id', 'posts.user_id','users.name as user_name', 'users.avatar as user_avatar',
                'users.url as user_url', 'posts.content', 'posts.imageUrl', 'posts.visible', 'posts.created_at');
        if($userID){
            $query = $query->where('posts.user_id', $userID);
        }

        if($visible){
            $query = $query->where('posts.visible', $visible);
        }

        if($searchKey){
            $query = $query->where(function ($q) use ($searchKey){
                $q->where('posts.content', 'like', '%' . $searchKey . '%')
                  ->orWhere('users.name', 'like', '%' . $searchKey . '%');
            });
        }

        $posts = $query->orderBy('posts.created_at', 'desc')->paginate($limit);
        $comment_count = 0;
        foreach($posts as $post){
            $likes = Like::join('users', 'likes.user_id', 'users.id')
                ->select('users.url as user_url', 'users.avatar as user_avatar', 'users.name as user_name', 'likes.created_at')
                ->where('likes.post_id', $post->id)
                ->where('likes.status', 1)
                ->orderBy('likes.created_at', 'desc')
                ->get();
            $comments = Comment::join('users', 'comments.user_id', 'users.id')
                ->select('users.url as user_url', 'users.avatar as user_avatar', 'users.name as user_name', 'comments.content', 'comments.created_at')
                ->where('comments.post_id', $post->id)
                ->orderBy('comments.created_at', 'desc')
                ->get();
            $comment_count += count($comments);
                foreach($comments as $comment){
                    $sub_comment = Sub_Comment::join('users', 'sub_comments.user_id', 'users.id')
                        ->select('sub_comments.id', 'sub_comments.user_id', 'users.name as user_name', 'users.url as user_url', 'users.avatar as user_avatar', 'sub_comments.created_at')
                        ->where('sub_comments.comment_id', $comment->id)
                        ->orderBy('sub_comments.created_at', 'desc')
                        ->get();
                    Arr::add($comment, 'sub_comment_count', count($sub_comment));
                    Arr::add($comment, 'sub_comments', $sub_comment);
                    $comment_count += count($sub_comment);
                }
            Arr::add($post, 'like_count', count($likes));
            Arr::add($post, 'comment_count', $comment_count);
            Arr::add($post, 'likes', $likes);
            Arr::add($post, 'comments', $comments);
        }
        return $posts;
        
    }
    public function getPostForGuest($param){
        $limit     = Arr::get($param, 'limit', Consts::DEFAULT_PER_PAGE);
        $userID    = Arr::get($param, 'user_id', null);
        $postID    = Arr::get($param, 'post_id', null);
        $searchKey = Arr::get($param, 'search_key', null);

        $query = Post::join('users', 'posts.user_id', 'users.id')
            ->select('posts.id', 'posts.user_id','users.name as user_name','users.url as user_url', 
             'users.avatar as user_avatar', 'users.url as user_url', 'posts.content', 'posts.imageUrl', 'posts.visible', 'posts.created_at')
            ->where('posts.visible', 'public');
        
        if($userID){
            if($postID) return null;
            else {
                $query = $query->where('posts.user_id', $userID);
                if($searchKey){
                    $query = $query->where(function ($q) use ($searchKey){
                        $q->where('posts.content', 'like', '%' . $searchKey . '%');
                    });
                }
                $posts = $query->orderBy('posts.created_at', 'desc')->paginate($limit);
                $comment_count = 0;
                foreach($posts as $post){
                    $likes = Like::join('users', 'likes.user_id', 'users.id')
                        ->select('users.url as user_url', 'users.avatar as user_avatar','users.name as user_name', 'likes.created_at')
                        ->where('likes.post_id', $post->id)
                        ->where('likes.status', 1)
                        ->orderBy('likes.created_at', 'desc')
                        ->get();
                    $comments = Comment::join('users', 'comments.user_id', 'users.id')
                        ->select('users.url as user_url', 'users.avatar as user_avatar', 'users.name as user_name', 'comments.content', 'comments.created_at')
                        ->where('comments.post_id', $post->id)
                        ->orderBy('comments.created_at', 'desc')
                        ->get();
                    $comment_count += count($comments);
                        foreach($comments as $comment){
                            $sub_comment = Sub_Comment::join('users', 'sub_comments.user_id', 'users.id')
                                ->select('sub_comments.id', 'sub_comments.user_id', 'users.name as user_name', 'users.url as user_url', 'users.avatar as user_avatar', 'sub_comments.created_at')
                                ->where('sub_comments.comment_id', $comment->id)
                                ->orderBy('sub_comments.created_at', 'desc')
                                ->get();
                            Arr::add($comment, 'sub_comment_count', count($sub_comment));
                            Arr::add($comment, 'sub_comments', $sub_comment);
                            $comment_count += count($sub_comment);
                        }
                    Arr::add($post, 'like_count', count($likes));
                    Arr::add($post, 'comment_count', $comment_count);
                    Arr::add($post, 'likes', $likes);
                    Arr::add($post, 'comments', $comments);
                    $comment_count = 0;
                }
                return $posts;
            }
        } else {
            if(!$postID) return null;
            else {
                $post = $query->where('posts.id', $postID)->first();
                $comment_count = 0;
                $likes = Like::join('users', 'likes.user_id', 'users.id')
                    ->select('users.url as user_url', 'users.name as user_name', 'likes.created_at')
                    ->where('likes.post_id', $post->id)
                    ->where('likes.status', 1)
                    ->orderBy('likes.created_at', 'desc')
                    ->get();
                $comments = Comment::join('users', 'comments.user_id', 'users.id')
                    ->select('users.url as user_url', 'users.name as user_name', 'users.avatar as user_avatar', 'comments.content', 'comments.created_at')
                    ->where('comments.post_id', $post->id)
                    ->orderBy('comments.created_at', 'desc')
                    ->get();
                $comment_count += count($comments);
                    foreach($comments as $comment){
                        $sub_comment = Sub_Comment::join('users', 'sub_comments.user_id', 'users.id')
                            ->select('sub_comments.id', 'sub_comments.user_id', 'users.name as user_name', 'users.avatar as user_avatar', 'sub_comments.created_at')
                            ->where('sub_comments.comment_id', $comment->id)
                            ->orderBy('sub_comments.created_at', 'desc')
                            ->get();
                        Arr::add($comment, 'sub_comment_count', count($sub_comment));
                        Arr::add($comment, 'sub_comments', $sub_comment);
                        $comment_count += count($sub_comment);
                    }
                Arr::add($post, 'like_count', count($likes));
                Arr::add($post, 'comment_count', $comment_count);
                Arr::add($post, 'likes', $likes);
                Arr::add($post, 'comments', $comments);
                return $post;
            }
        }
    }
    
    public function getPostForUser($param){
        $limit = Arr::get($param, 'limit', Consts::DEFAULT_PER_PAGE);
        $userID = Arr::get($param, 'user_id', null);
        $postID = Arr::get($param, 'post_id', null);
        $searchKey = Arr::get($param, 'search_key', null);

        $query = Post::join('users', 'posts.user_id', 'users.id')
            ->select('posts.id', 'posts.user_id','users.name as user_name','users.url as user_url',  'users.avatar as user_avatar',
            'posts.content', 'posts.imageUrl', 'posts.visible', 'posts.created_at');
        
        if($userID){
            if($postID) return null;
            else {
                $query = $query->where('posts.user_id', $userID);
                if(auth('api')->user()->id == $userID)
                    $query = $query->whereIn('posts.visible', ['public', 'friend', 'private']);
                else $query = $query->where('posts.visible', ['public', 'friend']);
                if($searchKey){
                    $query = $query->where(function ($q) use ($searchKey){
                        $q->where('posts.content', 'like', '%' . $searchKey . '%');
                    });
                }
            }
        } else {
            if(!$postID) return null;
            else {
                $post = $query->where('posts.id', $postID)->first();
                $comment_count = 0;
                $likes = Like::join('users', 'likes.user_id', 'users.id')
                    ->select('users.url as user_url', 'users.avatar as user_avatar', 'users.name as user_name', 'likes.created_at')
                    ->where('likes.post_id', $post->id)
                    ->where('likes.status', 1)
                    ->orderBy('likes.created_at', 'desc')
                    ->get();
                $comments = Comment::join('users', 'comments.user_id', 'users.id')
                    ->select('users.url as user_url', 'users.name as user_name', 'users.avatar as user_avatar', 'comments.content', 'comments.created_at')
                    ->where('comments.post_id', $post->id)
                    ->orderBy('comments.created_at', 'desc')
                    ->get();
                $comment_count += count($comments);
                    foreach($comments as $comment){
                        $sub_comment = Sub_Comment::join('users', 'sub_comments.user_id', 'users.id')
                            ->select('sub_comments.id', 'sub_comments.user_id', 'users.name as user_name', 'users.url as user_url', 'users.avatar as user_avatar', 'sub_comments.created_at')
                            ->where('sub_comments.comment_id', $comment->id)
                            ->orderBy('sub_comments.created_at', 'desc')
                            ->get();
                        Arr::add($comment, 'sub_comment_count', count($sub_comment));
                        Arr::add($comment, 'sub_comments', $sub_comment);
                        $comment_count += count($sub_comment);
                    }
                Arr::add($post, 'like_count', count($likes));
                Arr::add($post, 'comment_count', $comment_count);
                Arr::add($post, 'likes', $likes);
                Arr::add($post, 'comments', $comments);
                return $post;
            }
        }

        $posts = $query->orderBy('posts.created_at', 'desc')->paginate($limit);
        $comment_count = 0;
        foreach($posts as $post){
            $likes = Like::join('users', 'likes.user_id', 'users.id')
                ->select('users.url as user_url', 'users.name as user_name', 'likes.created_at')
                ->where('likes.post_id', $post->id)
                ->where('likes.status', 1)
                ->orderBy('likes.created_at', 'desc')
                ->get();
            $comments = Comment::join('users', 'comments.user_id', 'users.id')
                ->select('users.url as user_url', 'users.name as user_name', 'comments.content', 'comments.created_at')
                ->where('comments.post_id', $post->id)
                ->orderBy('comments.created_at', 'desc')
                ->get();
            $comment_count += count($comments);
                foreach($comments as $comment){
                    $sub_comment = Sub_Comment::join('users', 'sub_comments.user_id', 'users.id')
                        ->select('sub_comments.id', 'sub_comments.user_id', 'users.name as user_name', 'users.avatar as user_avatar', 'sub_comments.created_at')
                        ->where('sub_comments.comment_id', $comment->id)
                        ->orderBy('sub_comments.created_at', 'desc')
                        ->get();
                    Arr::add($comment, 'sub_comment_count', count($sub_comment));
                    Arr::add($comment, 'sub_comments', $sub_comment);
                    $comment_count += count($sub_comment);
                }
            Arr::add($post, 'like_count', count($likes));
            Arr::add($post, 'comment_count', $comment_count);
            Arr::add($post, 'likes', $likes);
            Arr::add($post, 'comments', $comments);
            $comment_count = 0;
        }
        return $posts;
    }

    public function getPostForFriend($param){

    }

    public function getPostForAdmin($param){
        $limit = Arr::get($param, 'limit', Consts::DEFAULT_PER_PAGE);
        $postID = Arr::get($param, 'post_id', null);
        $userID = Arr::get($param, 'user_id', null);
        $searchKey = Arr::get($param, 'search_key', null);
        $visible = Arr::get($param, 'visible', 'public');

        $query = Post::join('users', 'posts.user_id', 'users.id')
            ->select('posts.id', 'posts.user_id','users.name as user_name', 'users.url as user_url',  'users.avatar as user_avatar',
            'posts.content', 'posts.imageUrl', 'posts.visible', 'posts.created_at');
        if($userID){
            $query = $query->where('posts.user_id', $userID);
        }
        if($postID){
            $query = $query->where('posts.id', $postID);
        }

        if($visible){
            if($visible == 'private') return null;
            else if($visible == 'public' || $visible == 'blocked' || $visible == 'friend') $query = $query->where('posts.visible', $visible);
            else return null;
        }

        if($searchKey){
            $query = $query->where(function ($q) use ($searchKey){
                $q->where('posts.content', 'like', '%' . $searchKey . '%')
                  ->orWhere('users.name', 'like', '%' . $searchKey . '%');
            });
        }

        $posts = $query->orderBy('posts.created_at', 'desc')->paginate($limit);
        $comment_count = 0;
        foreach($posts as $post){
            $likes = Like::join('users', 'likes.user_id', 'users.id')
                ->select('users.url as user_url', 'users.name as user_name', 'likes.created_at')
                ->where('likes.post_id', $post->id)
                ->where('likes.status', 1)
                ->orderBy('likes.created_at', 'desc')
                ->get();
            $comments = Comment::join('users', 'comments.user_id', 'users.id')
                ->select('users.url as user_url', 'users.name as user_name', 'users.avatar as user_avatar', 'comments.content', 'comments.created_at')
                ->where('comments.post_id', $post->id)
                ->orderBy('comments.created_at', 'desc')
                ->get();
            $comment_count += count($comments);
                foreach($comments as $comment){
                    $sub_comment = Sub_Comment::join('users', 'sub_comments.user_id', 'users.id')
                        ->select('sub_comments.id', 'sub_comments.user_id', 'users.name as user_name', 'users.avatar as user_avatar', 'sub_comments.created_at')
                        ->where('sub_comments.comment_id', $comment->id)
                        ->orderBy('sub_comments.created_at', 'desc')
                        ->get();
                    Arr::add($comment, 'sub_comment_count', count($sub_comment));
                    Arr::add($comment, 'sub_comments', $sub_comment);
                    $comment_count += count($sub_comment);
                }
            Arr::add($post, 'like_count', count($likes));
            Arr::add($post, 'comment_count', $comment_count);
            Arr::add($post, 'likes', $likes);
            Arr::add($post, 'comments', $comments);
        }
        return $posts;
    }
    
    public function getLike($param, $postID){
        $limit = Arr::get($param, 'limit', Consts::DEFAULT_PER_PAGE);
        $searchKey = Arr::get($param, 'search_key', null);
        
        $query = Like::join('posts', 'likes.post_id', 'posts.id' )
            ->join('users', 'likes.user_id', 'users.id')
            ->where('likes.post_id', $postID);
        
        if($searchKey){
            $query = $query->where('users_name', 'like', '%'.$searchKey.'%');
        }
        $likes = $query->select('posts.id as post_id', 'users.id as user_id', 'likes.id', 'users.name as user_name', 'users.avatar as user_avatar', 'likes.status')
            ->orderBy('likes.created_at', 'desc')
            ->paginate($limit);
        return $likes;
    }

    public function getComment($param, $postID){
        $limit = Arr::get($param, 'limit', Consts::DEFAULT_PER_PAGE);
        $searchKey = Arr::get($param, 'search_key', null);

        $query = Comment::join('posts',  'comments.post_id', 'posts.id')
          ->join('users', 'comments.user_id', 'users.id')
          ->where('comments.post_id', $postID);

        if($searchKey){
            $query = $query->where('users_name', 'like', '%'.$searchKey.'%')
              ->orWhere('comments.content', 'like', '%'.$searchKey.'%');
        }

        $comments = $query->select('posts.id as post_id', 'users.id as user_id', 'users.name as user_name','comments.id', 'comments.content')
            ->orderBy('comments.created_at', 'desc')
            ->paginate($limit);

        foreach($comments as $comment){
            $sub_comment = Sub_Comment::join('users', 'sub_comments.user_id', 'users.id')
                ->select('sub_comments.id', 'sub_comments.user_id', 'users.name as user_name', 'sub_comments.created_at')
                ->where('sub_comments.comment_id', $comment->id)
                ->orderBy('sub_comments.created_at', 'desc')
                ->get();
            Arr::add($comment, 'sub_comment_count', count($sub_comment));
            Arr::add($comment, 'sub_comments', $sub_comment);
        }
        return $comments;
    }

}