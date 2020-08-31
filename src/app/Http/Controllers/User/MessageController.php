<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Http\Controllers\AppBaseController;
use App\Http\Services\MessageService;

class MessageController extends AppBaseController
{
    private $messageService;
    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }
    public function get(Request $request){
        $data = $this->messageService->get($request->all());
        return $this->sendResponse($data);
    }

    public function getForAuth(Request $request)
    {
        $data = $this->messageService->get($request->all());
        return $this->sendResponse($data);
    }

    public function send(MessageRequest $request, User $user)
    {
        $message = new Message();
        $message->sent_id = auth('api')->user()->id;
        $message->received_id = $user->id;
        $message->content = $request->content;
        $message->save();

        return $this->sendMessageSuccess($message, 'Sent message Successfully!');
    }

    public function edit(MessageRequest $request, User $user, Message $message)
    {
        $fail = 'Edit message permission denied!';
        $success = 'Update message successfully!';
        if($message->sent_id != auth('api')->user()->id || $message->received_id != $user->id)
            return $this->sendMessageFail($fail);

        $message->content = $request->content;
        $message->save();

        return $this->sendMessageSuccess($message, $success);
    }

    public function delete(User $user, Message $message)
    {
        $fail = 'Delete message permission denied!';
        $success = 'Delete message successfully!';
        if($message->sent_id != auth('api')->user()->id || $message->received_id != $user->id)
            return $this->sendMessageFail($fail);

        $message->delete();

        return $this->sendMessageSuccess($message, $success);
    }

    
}
