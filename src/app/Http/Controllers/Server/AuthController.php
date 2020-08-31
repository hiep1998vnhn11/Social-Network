<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
   public function getLogin()
   {
    return view('login'); 
   }

   public function postLogin(Request $request)
   {
    $credentials = $request->only('email', 'password');
    if(Auth::attempt($credentials)){
        return redirect()->intended('top');
    }
   }
}
