<?php

namespace App\Http\Services;

use App\Comment;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;
use App\Post;
use App\Consts;
use App\Like;

class PostService {
    
    public function getPostForUser($param){
        $limit = Arr::get($param, 'limit', Consts::DEFAULT_PER_PAGE);
        $searchKey = Arr::get($param, 'search_key', null);
        $visible = Arr::get($param, 'visible', null);
        $query = Post::select('posts.content', 'posts.likes','posts.imageUrl', 'posts.visible', 'posts.created_at')
            ->where('posts.user_id', 'like', auth()->user()->id);
        if($searchKey){
            $query = $query->where(function ($q) use ($searchKey){
                $q->where('posts.content', 'like', '%' . $searchKey . '%');
            });
        }

        if($visible){
            $query = $query->where('posts.visible', $visible);
        }
       
        $posts = $query->orderBy('created_at')->paginate($limit);
        return $posts;
    }

    public function getPostForAdmin($param){
        $limit = Arr::get($param, 'limit', Consts::DEFAULT_PER_PAGE);
        $searchKey = Arr::get($param, 'search_key', null);
        $visible = Arr::get($param, 'visible', null);
        $query = Post::select('posts.id','posts.user_id','posts.content','posts.likes', 'posts.imageUrl', 'posts.visible', 'posts.created_at');
        if($searchKey){
            $query = $query->where(function ($q) use ($searchKey){
                $q->where('posts.content', 'like', '%' . $searchKey . '%')
                  ->orWhere('posts.user_id', 'like', '%' . $searchKey . '%');
            });
        }

        if($visible){
            $query = $query->where('posts.visible', 'like', $visible);
        }
       
        $posts = $query->orderBy('created_at')->paginate($limit);
        return $posts;
    }

    public function getPostForFriend($param){
        $limit = Arr::get($param, 'limit', Consts::DEFAULT_PER_PAGE);
        $userID = Arr::get($param, 'user_id', null);
        $searchKey = Arr::get($param, 'search_key', null);
        $query = Post::select('posts.content', 'posts.likes','posts.imageUrl', 'posts.visible', 'posts.created_at')
            ->where('posts.visible', 'friend')
            ->orWhere('posts.visible', 'public');
        if($userID){
            $query = $query->where('posts.user_id', $userID);
        }

        if($searchKey){
            $query = $query->where(function ($q) use ($searchKey){
                $q->where('posts.content', 'like', '%' . $searchKey . '%');
            });
        }
       
        $posts = $query->orderBy('created_at')->paginate($limit);
        return $posts;
    }

    public function getPostForPublic($param){
        $limit = Arr::get($param, 'limit', Consts::DEFAULT_PER_PAGE);
        $searchKey = Arr::get($param, 'search_key', null);
        $userID = Arr::get($param, 'user_id', null);
        $query = Post::select('posts.content', 'posts.likes','posts.imageUrl', 'posts.visible', 'posts.created_at')
            ->where('posts.visible', 'like', 'public');

        if($userID){
            $query = $query->where('posts.user_id', 'like', $userID);
        }
        if($searchKey){
            $query = $query->where(function ($q) use ($searchKey){
                $q->where('posts.content', 'like', '%' . $searchKey . '%');
            });
        }
        $posts = $query->orderBy('created_at')->paginate($limit);
        return $posts;
    }

    public function getPostForFeed($param){
        $limit = Arr::get($param, 'limit', 20);
        $query = Post::select('posts.content', 'posts.likes','posts.imageUrl', 'posts.visible', 'posts.created_at')
        ->where('posts.user_id', 'like', auth()->user()->id)
        ->orWhere('posts.visible', 'like', 'friend');

        $posts = $query->orderBy('created_at')->paginate($limit);
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
        $likes = $query->select('posts.id as post_id', 'users.id as user_id', 'likes.id', 'users.name as user_name')->paginate($limit);

        return $likes;
    }

    public function getComment($param, $postID){
        $limit = Arr::get($param, 'limit', Consts::DEFAULT_PER_PAGE);
        $searchKey = Arr::get($param, 'search_key', null);

        $query = Comment::join('posts',  'comments.post_id', 'posts.id')
          ->leftJoin('users', 'comments.user_id', 'users.id')
          ->where('comments.post_id', $postID);

        if($searchKey){
            $query = $query->where('users_name', 'like', '%'.$searchKey.'%')
              ->orWhere('comments.content', 'like', '%'.$searchKey.'%');
        }

        $comments = $query->select('posts.id as post_id', 'users.id as user_id', 'users.name as user_name','comments.id', 'comments.content')->paginate($limit);
        return $comments;
    }

}