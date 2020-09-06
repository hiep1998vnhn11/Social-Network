<?php
namespace App\Http\Services;

use Illuminate\Support\Arr;
use App\Models\Room;
use App\Models\Chat;
use Illuminate\Support\Carbon;

class ChatService
{

    public function getRoom($param){
        $limit = Arr::get($param, 'limit', config('const.default_per_page'));
        $userID = auth('api')->user()->id;
        $searchKey = Arr::get($param, 'search_key', null);

        $data = Room::where('sent', $userID);
        
        if($searchKey){
            $data = $data->where('');
        }

    }

    public function getMessage($param){
        $limit = Arr::get($param, 'limit', config('const.default_per_page'));
    }
}