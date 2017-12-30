<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoogleMapsApi extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'apikey',
        'used_count',
    ];
}
