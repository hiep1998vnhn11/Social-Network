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
Route::get('get_users', 'User\UserController@getForClient');
Route::get('get_posts', 'User\PostController@getForClient');

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    //auth
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

    //message
    Route::get('get_messages', 'User\MessageController@getForAuth');

    //friend
    Route::get('handle_friend', 'User\UserController@handleFriend');

    //User
    Route::group([ 
        'prefix' => 'user',
        'middleware' => 'role:viewer|admin|super-admin'
    ], function (){
        Route::get('get', 'User\UserController@get');
        Route::get('{user}/get_info', 'User\UserController@getInfoByUserId');
        Route::get('{user}/get_post', 'User\PostController@getPostByUserId');

        Route::post('change_url', 'User\UserController@changeUrl');
        Route::post('change_avatar', 'User\UserController@changeAvatar');
        Route::post('change_background', 'User\UserController@changeBackground');
        Route::post('change_info', 'User\UserController@changeInfo');

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
            Route::post('{post}/delete', 'User\PostController@delete');
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
            Route::get('{post}/{comment}/get_sub-comment', 'User\SubCommentController@get');
            Route::post('{post}/{comment}/create_sub-comment', 'User\SubCommentController@create');
            Route::post('{post}/{comment}/{sub_comment}/edit', 'User\SubCommentController@edit');
            Route::delete('{post}/{comment}/{sub_comment}/delete', 'User\SubCommentController@delete');

        });
    });
});
Route::post('register', 'RegisterController@register');

Route::group([
    'middleware' => ['role:admin|super-admin'],
    'prefix' => 'admin'
], function($router){
    Route::group([
        'prefix' => 'user'
    ], function(){
        Route::get('get', 'Admin\UserController@get');
        Route::get('{user}/show', 'Admin\UserController@show');
        Route::delete('{user}/delete', 'Admin\UserController@delete');
    });

    Route::group([
        'prefix' => 'post'
    ], function(){

    });
});

