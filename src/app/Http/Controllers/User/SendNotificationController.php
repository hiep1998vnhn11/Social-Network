<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\AppBaseController;
use App\Notifications\AddFriendNotification;
use Illuminate\Http\Request;
use App\User;

class SendNotificationController extends AppBaseController
{
    public function sendFriendNotification(Request $request, User $user)
    {
        $data = $request->only(['title', 'content']);
        $user->notify(new AddFriendNotification($data));
    }
}
