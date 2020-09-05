<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{

    public function user() {
        return view('user');
    }

    /**
     * Used to get fresh token
     */
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }
    

    /**
     * Register new user
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'username' => 'required|string|max:255',
            'profile_id' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'username' => $request->get('email'),
            'profile_id' => $request->get('profile_id'),
        ]);

        $token = JWTAuth::fromUser($user);
        
        return response()->json(compact('user','token'), 201);
    }
    
    /**
     * Get current login user
     */
    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }

    /**
     * Unvalidate jwt token
     */
    public function logout() {
        \Log::info(JWTAuth::getToken());
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            } else {
                //$invalidate = JWTAuth::invalidate(JWTAuth::getToken());
                $invalidate = JWTAuth::invalidate(JWTAuth::getToken());
                if ($invalidate) {
                    return response()->json([
                        'message' => 'logout success',
                        'status'  => 'OK'
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'logout fail',
                        'status'  => 'ERROR'
                    ], 200);
                }
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }
    }

    /**
     * Get all users
     */
    public function getAllUser(Request $request) {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            } else {
                $data = User::getAllUser();
                return response()->json($data, 200);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
    }

    /**
     * Get user by it's id
     */
    public function getUserById(Request $request) {
        $res_failed = [
            'message' => 'Find failed',
            'status'  => 'ERROR'
        ];

        $validator = Validator::make($request->all(), [
            'id'       => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 422);
        }

        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            } else {
                $data = User::find($request->get('id'));
                if(!empty($data)) {
                    return response()->json([
                        'data'    => $data,
                        'status'  => 'OK'
                    ],200);
                } else {
                    return response()->json($res_failed, 422);
                }
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
    }

    /**
     * Delete user based on id
     */
    public function deleteUser(Request $request) {
        $res_failed = [
            'message' => 'Delete fail',
            'status'  => 'ERROR'
        ];

        $validator = Validator::make($request->all(), [
            'id'       => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 422);
        }

        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            } else {
                $data = User::find($request->get('id'));
                if($data->delete()) {
                    return response()->json([
                        'message' => 'Delete success',
                        'status'  => 'OK'
                    ],200);
                } else {
                    return response()->json($res_failed, 422);
                }
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
    }
}
