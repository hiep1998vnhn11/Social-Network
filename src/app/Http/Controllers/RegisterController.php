<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request){
        $user = new User();
        $role = Role::findById(1);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password) ;
        $user->assignRole($role);
        $user->save();
        return response()->json([
            'message' => 'RegisterSuccessfully!',
            'user' => $user
        ]);
    }
}
