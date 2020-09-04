<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'activities';

    /**
     * The attributes that aren't mass assignable.
     * array empty [] means all attributes are mass assignable
     * @var array
     */
    protected $guarded = [];


    /**
     * to make sure that returned participant_ids is in array
     */
    protected $casts = [
        'participant_ids' => 'array'
    ];
}
