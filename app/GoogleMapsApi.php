<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class GoogleMapsApi extends Model
{
    protected $connection = 'mongodb';
    // protected $collection = 'google_maps_apis_collection';

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
