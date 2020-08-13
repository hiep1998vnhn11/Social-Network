<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopController extends Controller
{
    private $title;
    private $user_login;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function($request, $next){
            $this->user_login = Auth::user();
            $this->title = __('messages.top');
            return $next($request);
        });
    }

    public function top(){
        return view('top')->with([
            'login_user' => 'admin',
            'title'      => $this->title,
        ]);
    }
}

