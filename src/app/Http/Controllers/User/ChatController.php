<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\AppBaseController;
use App\Models\Chat;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Requests\ChatRequest;
use App\User;
use Illuminate\Support\Arr;

class ChatController extends AppBaseController
{

    public function __construct()
    {
        $this->middleware('role:viewer|admin|super-admin');
    }
    /**
     * Sending an message 
     *
     * @return \Illuminate\Http\Response
     */
    public function send(User $user, Request $request)
    {
        //check content
        if(!$request->content) return $this->sendMessageFail('Content is required!');

        $userID = auth('api')->user()->id;
        $roomUser = $user->with_room()->where('user_id', $userID)->first();
        $roomWith = $user->room()->where('with_id', $userID)->first();

        if(!$roomUser){ // check had chat yet
            $roomUser = new Room;
            $roomUser->user_id = $userID;
            $roomUser->with_id = $user->id;
            $roomUser->save();
        }

        if(!$roomWith){
            $roomWith = new Room;
            $roomWith->user_id = $user->id;
            $roomWith->with_id = $userID;
            $roomWith->save();
        }

        //start make a chat. Chat was not seen until with_id call api
        $chatSent = new Chat; 
        $chatSent->room_id = $roomUser->id;
        $chatSent->content = $request->content;
        $chatSent->sent_id = $userID;
        $chatSent->save();

        $chatReceived = new Chat;
        $chatReceived->room_id = $roomWith->id;
        $chatReceived->content = $request->content;
        $chatReceived->sent_id = $userID;
        $chatReceived->chat_id = $chatSent->id;
        $chatReceived->save();

        return $this->sendResponse($chatSent, 'Sent message successfully!');
    }

    /**
     * Delete MEssage
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteChatOnYourSide(Chat $chat)
    {
        $userID = auth('api')->user()->id;
        return $chat->room;
        if($chat->room->user_id != $userID || $chat->room->with_id != $userID){
            return $this->sendMessageFail('Delete message Permission denied!');
        }

        $chat->delete();
        return $this->sendMessageSuccess($chat, 'Delete message Successfully!');
    }

     /**
     * Delete MEssage
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteChat(Chat $chat)
    {
        $userID = auth('api')->user()->id;
        if($chat->room->user_id != $userID || $chat->room->with_id != $userID){
            return $this->sendMessageFail('Delete message Permission denied!');
        }

        $chat->delete();
        $chatReceived = Chat::where('chat_id', $chat->id)->first();
        if($chatReceived) $chatReceived->delete();
        return $this->sendMessageSuccess($chat, 'Delete message Successfully!');
    }

    public function deleteRoomOmYourSide(Room $room)
    {
        if($room->user_id != auth('api')->user()->id){
            return $this->sendMessageFail('Delete Room permission denied!');
        }

        $room->delete();
        return $this->sendMessageSuccess($room, 'Delete Room successfully!');
    }

    public function deleteRoom(Room $room)
    {
        
        if($room->user_id != auth('api')->user()->id){
            return $this->sendMessageFail('Delete Room permission denied!');
        }

        $room->delete();
        $roomWith = Room::where('user_id', $room->with_id)
            ->where('with_id', $room->user_id)
            ->first();
        if($roomWith){
            $roomWith->delete();
        }

        return $this->sendMessageSuccess($room, 'Delete Room successfully!');
    }

    /**
     * Get Room for user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getRoom(Request $request)
    {
        $searchKey = Arr::get($request->all(), 'search_key', null);
        $data = auth('api')->user()->room();
        
        $data = $data->join('users', 'with_id', 'users.id')
            ->select('message_rooms.*','users.url', 'users.avatar', 'users.name');
        if($searchKey){
            $data = $data->where('name', 'like', '%' . $searchKey . '%');
        }
        $data = $data->paginate(config('const.default_per_page'));
        return $data;
    }

    public function getChatOnRoom(Room $room, Request $request)
    {
        if($room->user_id != auth('api')->user()->id)
            return $this->sendMessageFail('Get Message permission denied!');

        $data = $room->chat();
        $searchKey = Arr::get($request, 'search_key', null);
        if($searchKey){
            $data = $data->where('content', 'like', '%' . $searchKey . '%');
        }
        $chats = $data->paginate(config('const.default_per_page'));
        return $this->sendResponse($chats);
    }

    public function getMessage(Request $request)
    {
        return Room::find(1)->user_with;
    }
}
