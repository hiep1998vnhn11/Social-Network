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

    //User
    Route::group([ 
        'prefix' => 'user',
        'middleware' => 'role:viewer|admin|super-admin'
    ], function (){
        Route::get('get', 'User\UserController@get');
        Route::get('{user}/get_info', 'User\UserController@getInfoByUserId');
        Route::get('{user}/get_post', 'User\PostController@getPostByUserId');

           //resource Message
        Route::post('{user}/send_message', 'User\MessageController@send');
        Route::get('/get_message', 'User\MessageController@get');
        Route::post('{user}/{message}/edit', 'User\MessageController@edit');
        Route::delete('{user}/{message}/delete', 'User\MessageController@delete');
        Route::get('/test_message', 'User\MessageController@test');

        //group prefix post
        Route::group([
            'prefix' => 'post'
        ],function(){
            Route::get('get', 'User\PostController@get');
            Route::get('get_for_user', 'User\PostController@getForUser');
            Route::get('get_for_feed', 'User\PostController@getForFeed');
            Route::get('get_for_friend', 'User\PostController@getForFriend');
            Route::get('get_for_public', 'User\PostController@getForPublic');
            Route::get('get_for_admin', 'User\PostController@getForAdmin');

            //resource Post
            Route::post('create', 'User\PostController@create');
            Route::delete('{post}/delete', 'User\PostController@delete');
            Route::post('{post}/edit', 'User\PostController@edit');

         

            //resource Like
            Route::get('{post}/get_like', 'User\LikeController@getLike');
            Route::post('{post}/handle_like', 'User\LikeController@like');

            //resource comment
            Route::get('{post}/get_comment', 'User\CommentController@get');
            Route::post('{post}/create_comment', 'User\CommentController@create');
            Route::delete('{post}/{comment}/delete', 'User\CommentController@delete');
            Route::post('{post}/{comment}/edit', 'User\CommentController@edit');
            

            //resource sub comment
            Route::get('{post}/{comment}/get_sub-comment', 'User\SubCommentController@getSubComment');

        });
    });
});
Route::post('register', 'RegisterController@register');

Route::group([
    'middleware' => ['role:admin|super-admin'],
    'prefix' => 'admin'
], function($router){
    Route::get('users', 'Admin\AdminController@getUser');
    Route::post('show/{user}', 'Admin\AdminController@show');
    Route::delete('delete/{user}', 'Admin\AdminController@delete');
    Route::post('create', 'Admin\AdminController@create');
    Route::post('update/{user}', 'Admin\AdminController@update');
});