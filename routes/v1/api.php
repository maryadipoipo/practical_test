<?php

use Illuminate\Http\Request;

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

// Login api doesn't need a token
Route::post('login', 'UserController@login');

Route::post('register', 'UserController@register');

Route::group(['middleware' => 'jwt.verify'], function (){
    //Route::post('register', 'UserController@register');
    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::post('logout', 'UserController@logout');

    Route::post('profile', 'ProfileController@getAllProfile');
    Route::post('create_profile', 'ProfileController@createNewProfile');
    Route::post('edit_profile', 'ProfileController@editProfile');
    Route::post('delete_profile', 'ProfileController@deleteProfile');
    Route::post('profile_by_id', 'ProfileController@getProfileById');

    Route::post('create_menu', 'MenuController@createNewMenu');
    Route::post('edit_menu', 'MenuController@editMenu');
    Route::post('delete_menu', 'MenuController@deleteMenu');
    Route::post('get_menu_by_id', 'MenuController@findMenuById');
});

