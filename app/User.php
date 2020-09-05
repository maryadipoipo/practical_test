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
}
