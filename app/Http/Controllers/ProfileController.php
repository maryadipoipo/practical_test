<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;


class ProfileController extends Controller
{
    public function profile() {
        return view('profile');
    }

    public function getAllProfile() {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            } else {
                $data = Profile::all();
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
     * Get profile based on id
     */
    public function getProfileById(Request $request) {
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
                $profile = Profile::find($request->get('id'));
                if(!empty($profile)) {
                    return response()->json([
                        'data'    => $profile,
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
     * Function to create a new Profile
     * required fields:
     * title = string max 60
     */
    public function createNewProfile(Request $request) {
        $validator = Validator::make($request->all(), [
            'title'    => 'required|string|max:60|unique:profiles',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 422);
        }

        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            } else {
                $profile = Profile::create([
                    'title' => $request->get('title'),
                    'user_id' => $user->id,
                ]);
                if($profile) {
                    return response()->json([
                        'message' => 'Create success',
                        'status'  => 'OK'
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'Create failed',
                        'status'  => 'ERROR'
                    ], 422);
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
     * Function to edit Profile
     * required fields:
     * - id of the Profile
     * - title = string max 60
     */
    public function editProfile(Request $request) {
        $validator = Validator::make($request->all(), [
            'id'       => 'required',
            'title'    => 'required|string|max:60'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            } else {
                $profile = Profile::find($request->get('id'));
                $profile->title = $request->get('title');
                $profile->user_id = $user->id;
                if($profile->save()) {
                    return response()->json([
                        'message' => 'Update success',
                        'status'  => 'OK'
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'Update fail',
                        'status'  => 'ERROR'
                    ], 422);
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
     * Function to delete profile based on id
     */
    public function deleteProfile(Request $request) {
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
                $profile = Profile::find($request->get('id'));
                $profile->user_id = $user->id;
                if($profile->save()) {
                    if($profile->delete()) {
                        return response()->json([
                            'message' => 'Delete success',
                            'status'  => 'OK'
                        ],200);
                    } else {
                        return response()->json($res_failed, 422);
                    }
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
