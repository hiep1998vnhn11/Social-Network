<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\UserService;
use App\Http\Controllers\AppBaseController;
use App\User;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;


class UserController extends AppBaseController
{

    private $userService;
    private $adminRole;
    private $superRole;
    private $blockedRole;
    private $viewerRole;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->viewerRole = Role::findById(4);
        $this->adminRole = Role::findById(2);
        $this->superRole = Role::findById(3);
        $this->blockedRole = Role::findById(4);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        $data = $this->userService->getUserForAdmin($request->all());
        return $this->sendResponse($data);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if($user->hasAnyRole($this->superRole))
            return $this->sendMessageFail('Permission denied!');
        $role = $user->getRoleNames()->first();
        Arr::add($user, 'role', $role);
        return $this->sendMessageSuccess($user, 'Show user successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(User $user)
    {
        if($user->hasAnyRole($this->adminRole, $this->superRole))
            return $this->sendMessageFail('Permission denied!');
        
        $user->delete();
        return $this->sendMessageSuccess($user, 'Delete user successfully!');
    }
}
