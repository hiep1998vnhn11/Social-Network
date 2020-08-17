<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\AppBaseController;
use App\Http\Services\UserService;
use Illuminate\Support\Str;

class AdminController extends AppBaseController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUser(Request $request)
    {
        $data = $this->userService->getUserForAdmin($request->all());
        return $this->sendResponse($data);
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(RegisterRequest $request)
    {
        $role = Role::findById(1);
        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->assignRole($role);
        $user->save();
        return $this->sendResponse($user);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RegisterRequest $request, User $user)
    {
        if($request->email) return response()->json([
            'success' => false,
            'message' => 'Can not edit Email!'
        ], 400);
        if(Str::contains($request->name, 'admin')) return response()->json([
            'success' => false,
            'message' => 'name can not contain \'admin\' string'
        ], 400);

        $role = Role::findById(1);
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->assignRole($role);
        $user->save();
        return response()->json([
            'success' => true,
            'message' => 'Update user success!',
            'user' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(User $user)
    {
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'Delete user success!',
            'user' => $user
        ]);
    }
}
