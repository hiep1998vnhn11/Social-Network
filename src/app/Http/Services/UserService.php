<?php

namespace App\Http\Services;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\User;
use App\Consts;
use App\Post;
use Spatie\Permission\Models\Role;


class UserService {
    public function getUsers($param){
        $userUrl = Arr::get($param, 'user_url', null);
        $query = User::select('users.name', 'users.url','users.avatar', 'users.background', 'users.created_at'); 
        if($userUrl){
            if(Str::contains($userUrl, ['admin'])) return [];
            $query = $query->where('users.url', $userUrl);
        } else return [];
        $users = $query->get();
        return $users;
    }

    public function getUserForAdmin($param){
        $limit = Arr::get($param, 'limit', Consts::DEFAULT_PER_PAGE);
        $searchKey = Arr::get($param, 'search_key', null);
        $sort = Arr::get($param, 'sort', null);

        $query = User::select('users.id', 'users.name', 'users.email', 'users.url', 'users.created_at', 'users.updated_at', 'users.avatar', 'users.background');

        if($searchKey){
            $query = $query->where(function($q) use ($searchKey){
                $q->where('users.name', 'like', '%' . $searchKey . '%')
                  ->orWhere('users.id', 'like', '%' . $searchKey . '%')
                  ->orWhere('users.email', 'like', '%' . $searchKey . '%')
                  ->orWhere('users.url', 'like', '%' . $searchKey . '%');
            });
        }

        if($sort){
            $query = $query->orderBy($sort, 'desc');
        }

        $users = $query->paginate($limit);
        foreach($users as $user){
            $role = $user->getRoleNames()->first();
            Arr::add($user, 'role', $role);
        }
        return $users;
    }

}