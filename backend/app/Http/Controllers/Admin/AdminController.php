<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\RegisterRequest;
use Spatie\Permission\Models\Role;


class AdminController extends Controller
{

    public function __construct(){
        $this->middleware('role:admin|super-admin');
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        foreach($users as $user){
            $user->getRoleNames();
        }
        return response()->json($users);
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
        return response()->json([
            'message' => 'Create user success!',
            'user' => $user
        ]);
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
        $role = Role::findById(1);
        if($request->email) return response()->json([
            'error' => 'Can not edit Email!'
        ]);
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->assignRole($role);
        $user->save();
        return response()->json([
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
            'message' => 'Delete user success!',
            'user' => $user
        ]);
    }
}
