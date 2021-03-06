<?php
namespace App\Http\Services;

use App\Consts;
use App\Models\Message;
use App\User;
use Illuminate\Support\Arr;

class MessageService
{
    public function get($param)
    {
        $limit     = Arr::get($param, 'limit', Consts::DEFAULT_PER_PAGE);
        $searchKey = Arr::get($param, 'search_key', null);
        $userID    = Arr::get($param, 'user_id', null);
        $userOnly  = Arr::get($param, 'user_only', null);
        $currentID = auth('api')->user()->id;

        $query = Message::join('users', 'messages.sent_id', 'users.id')
            ->join('users as users2', 'messages.received_id', 'users2.id')
          ->select('messages.sent_id', 'users.name as sent_name', 'messages.content', 'messages.received_id', 'users2.name as received_name', 'messages.created_at');
        
        if($userID){ //userID != null
            if($userID == auth('api')->user()->id){
                $query = $query->where('messages.sent_id', auth('api')->user()->id)
                ->where('messages.received_id', auth('api')->user()->id);
            } else{
            $query = $query->where(function ($send) use ($userID){
                $send->where('messages.sent_id', auth('api')->user()->id)
                     ->where('messages.received_id', $userID);
            })
              ->orWhere(function ($received) use ($userID){
                  $received->where('messages.sent_id', $userID)
                           ->where('messages.received_id', auth('api')->user()->id);
              });
            }
            if($searchKey){
                $query = $query->where('messages.content', 'like', '%' .$searchKey . '%');
            }
    
            $messages = $query->orderBy('created_at', 'desc')->paginate($limit);
            return $messages;
        } else if($userOnly){ //user_id = null && userOnly
            $query = $query->where('messages.sent_id', auth('api')->user()->id)
                ->where('messages.received_id', auth('api')->user()->id);
            $messages = $query->orderBy('created_at', 'desc')->get();
            $users = [];
            foreach($messages as $message){
                
            }
            return $users;
        } else{ // user_id = null && userOnly = null
            return null;
        }   
    }

    public function getForAuth($param)
    {

    }

//     public function getUserMessage($param)
//     {
//         $limit = Arr::get($param, 'limit', Consts::DEFAULT_PER_PAGE);
//         $searchKey = Arr::get($param, 'search_key', null);
//         $userID = Arr::get($param, 'user_id', null);

//         if(!$userID) return null;
//         $query = User::join('messages', )
//     }
}