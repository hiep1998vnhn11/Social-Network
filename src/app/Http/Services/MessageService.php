<?php
namespace App\Http\Services;

use App\Consts;
use App\Message;
use Illuminate\Support\Arr;

class MessageService
{
    public function getMessageByUserId($param, $userID)
    {
        $limit = Arr::get($param, 'limit', Consts::DEFAULT_PER_PAGE);
        $searchKey = Arr::get($param, 'search_key', null);

        $query = Message::join('users', 'messages.sent_id', 'users.id')
          ->join('users as users2', 'messages.received_id', 'users2.id')
          ->select('messages.sent_id', 'users.name as sent_name', 'messages.content', 'messages.received_id', 'users2.name as received_name');
        if($userID == auth()->user()->id){
            $query = $query->where('messages.sent_id', $userID)
              ->where('messages.received_id', $userID);
        } else {
        $query = $query->where(function($q) use ($userID){
            $q->where('messages.sent_id', $userID)
            ->orWhere('messages.received_id', $userID);
        });
        }
    }
}