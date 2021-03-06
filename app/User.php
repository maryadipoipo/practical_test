<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     * array empty [] means all attributes are mass assignable
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * to make sure that returned skill_ids is in array
     */
    protected $casts = [
        'skill_ids' => 'array'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public static function getAllUser() {
        $users = DB::table('users')
                ->join('profiles', 'profiles.id', '=', 'users.profile_id')
                ->where([
                    'users.deleted_at' => null
                ])
                ->select(
                    'users.id',
                    'users.name',
                    'users.email',
                    'users.profile_id',
                    'users.skills',
                    'profiles.title as profile_name'
                )
                ->get();
        return $users;
    }

    public static function getUserBySkillId($skill_ids) {
        $res = [];
        $users = DB::table('users')
                ->where('deleted_at', NULL)
                ->get();
        foreach($users as $user) {
            $userSkills = json_decode($user->skills, true);
            foreach($userSkills as $skill) {
                foreach($skill_ids as $id) {
                    if($skill['key'] == $id) {
                        if(!self::checkIdExists($user->id, $res)) {
                            array_push($res, [
                                'id' => $user->id,
                                'name' => $user->name
                            ]);
                        }
                    }
                }
                
            }
        }
        return $res;
    }

    private static function checkIdExists($id, $arr) {
        $ret = false;
        foreach($arr as $ar) {
            if ($ar['id'] == $id) {
                $ret = true;
                break;
            }
        }

        return $ret;
    }
}
