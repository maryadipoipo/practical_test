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

    Route::post('delete_testimoni', 'TestimoniController@deleteTestimoni');

    Route::post('create_tag', 'TagController@createNewTag');
    Route::post('edit_tag', 'TagController@editTag');
    Route::post('delete_tag', 'TagController@deleteTag');
    Route::post('get_menu_tag', 'TagController@getMenuTag');
    Route::post('get_submenu_tag', 'TagController@getSubMenuTag');
    Route::post('get_detailmenu_tag', 'TagController@getDetailMenuTag');
    Route::post('get_tag_by_id', 'TagController@getTagById');

    Route::post('create_menu', 'MenuController@createNewMenu');
    Route::post('edit_menu', 'MenuController@editMenu');
    Route::post('delete_menu', 'MenuController@deleteMenu');
    Route::post('get_menu_by_id', 'MenuController@findMenuById');
});

