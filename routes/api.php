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

//Route::post('register', 'UserController@register');

Route::group(['middleware' => 'jwt.verify'], function (){
    Route::post('register', 'UserController@register');
    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::post('logout', 'UserController@logout');
    Route::get('users', 'UserController@getAllUser');
    Route::post('delete_user', 'UserController@deleteUser');
    Route::post('user_by_id', 'UserController@getUserById');
    Route::post('edit_user', 'UserController@editUser');
    Route::get('user_by_skill_id', 'UserController@getUserBySkillId');

    Route::get('profile', 'ProfileController@getAllProfile');
    Route::post('create_profile', 'ProfileController@createNewProfile');
    Route::post('edit_profile', 'ProfileController@editProfile');
    Route::post('delete_profile', 'ProfileController@deleteProfile');
    Route::post('profile_by_id', 'ProfileController@getProfileById');

    Route::get('skill', 'SkillController@getAllSkills');
    Route::post('create_skill', 'SkillController@createNewSkill');
    Route::post('edit_skill', 'SkillController@editSkill');
    Route::post('delete_skill', 'SkillController@deleteSkill');
    Route::post('skill_by_id', 'SkillController@getSkillById');


    Route::get('activity', 'ActivityController@getAllActivities');
    Route::post('create_activity', 'ActivityController@createNewActivity');
    Route::post('edit_activity', 'ActivityController@editActivity');
    Route::post('delete_activity', 'ActivityController@deleteActivity');
    Route::post('activity_by_id', 'ActivityController@getActivityById');
});

