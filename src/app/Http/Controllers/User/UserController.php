<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\UserService;
use App\Http\Controllers\AppBaseController;

class UserController extends AppBaseController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function get(Request $request){
        $users = $this->userService->getUsers($request->all());
        return $this->sendResponse($users);
    }
}
