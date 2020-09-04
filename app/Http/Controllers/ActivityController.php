<?php

namespace App\Http\Controllers;

use App\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;


class ActivityController extends Controller
{
    public function getAllActivities() {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            } else {
                $data = Activity::all();
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


    public function getActivityById(Request $request) {
        $res_failed = [
            'message' => 'Failed to find Skill',
            'status'  => 'ERROR'
        ];

        $validator = Validator::make($request->all(), [
            'id'       => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            } else {
                $skill = Activity::find($request->get('id'));
                if(!empty($skill)) {
                    return response()->json([
                        'data'    => $skill,
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
     * Function to create a new Skill
     * required fields:
     * title = string max 60
     */
    public function createNewActivity(Request $request) {
        \Log::info($request);
        $validator = Validator::make($request->all(), [
            'id'       => 'required',
            'title'    => 'required|string|max:60',
            'description'    => 'required|string|max:1000',
            'start_date'    => 'required',
            'end_date'    => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 422);
        }

        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            } else {
                $activity = Activity::create([
                    'title' => $request->get('title'),
                    'user_id' => $user->id,
                    'description' => $request->get('title'),
                    'start_date' => $request->get('start_date'),
                    'end_date' => $request->get('end_date'),
                    'participant_ids' => $request->get('participant_ids'),
                ]);
                if($activity) {
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
     * Function to edit Skill
     * required fields:
     * - id of the Skill
     * - title = string max 60
     */
    public function editActivity(Request $request) {
        $validator = Validator::make($request->all(), [
            'id'       => 'required',
            'title'    => 'required|string|max:60',
            'description'    => 'required|string|max:1000',
            'start_date'    => 'required',
            'end_date'    => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            } else {
                $activity = Activity::find($request->get('id'));
                $activity->title = $request->get('title');
                $activity->user_id = $user->id;
                $activity->description = $request->get('title');
                $activity->start_date = $request->get('start_date');
                $activity->end_date = $request->get('end_date');
                $activity->participant_ids = $request->get('participant_ids');
                if($activity->save()) {
                    return response()->json([
                        'message' => 'Update success',
                        'status'  => 'OK'
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'Update failed',
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
     * Function to delete Activity based on id
     */
    public function deleteActivity(Request $request) {
        $res_failed = [
            'message' => 'Delete failed',
            'status'  => 'ERROR'
        ];

        $validator = Validator::make($request->all(), [
            'id'       => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            } else {
                $activity = Activity::find($request->get('id'));
                $activity->user_id = $user->id;
                if($activity->save()) {
                    if($activity->delete()) {
                        return response()->json([
                            'message' => 'Delete success',
                            'status'  => 'OK'
                        ], 200);
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
