<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;

use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\AppBaseController;

class RegisterController extends AppBaseController
{
    public function register(RegisterRequest $request){
        if(Str::contains($request->name, 'admin') || Str::contains($request->email, 'admin')){
            $error = 'name or email can not contain \'admin\' string';
            $code = 400;
            return $this->sendError($error, $code);
        }
        $user = new User();
        $role = Role::findById(1);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password) ;
        $user->assignRole($role);
        $user->save();
        return $this->sendResponse($user);
    }
}
