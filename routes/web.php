<?php

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
    return view('login');
});

Route::group(['middleware' => 'jwt.verify'], function (){
    Route::get('home', 'HomeController@home');
    Route::get('profile', 'ProfileController@profile');
    Route::get('skill', 'SkillController@skill');
    Route::get('user', 'UserController@user');
});

