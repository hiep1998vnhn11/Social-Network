<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    //auth
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    //Post
    Route::group([ 
        'prefix' => 'post',
        'middleware' => 'role:viewer|admin|super-admin'
    ], function (){
        
        Route::post('get', 'PostController@get');
    });
    //User
    Route::group([ 
        'prefix' => 'user',
        'middleware' => 'role:viewer|admin|super-admin'
    ], function (){
        Route::get('get', 'User\UserController@get');
    });
});
Route::post('register', 'RegisterController@register');

Route::group([
    'middleware' => ['role:admin|super-admin'],
    'prefix' => 'admin'
], function($router){
    Route::get('users', 'Admin\AdminController@index');
    Route::post('show/{user}', 'Admin\AdminController@show');
    Route::post('delete/{user}', 'Admin\AdminController@delete');
    Route::post('create', 'Admin\AdminController@create');
    Route::post('update/{user}', 'Admin\AdminController@update');
});