<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin'], function () {
    Route::get('login', 'Server\AuthController@getLogin')->name('login');
    Route::post('login', 'Server\AuthController@postLogin')->name('login');
    Route::get('top', 'AdminAuthController@index');
    Route::resource('user', 'Server\UserController');
    Route::resource('post', 'Server\PostController');
});


// Route::get('login/{provider}', 'User\SocialiteController@redirect');
// Route::get('auth/{provider}/callback', 'User\SocialiteController@callback');
