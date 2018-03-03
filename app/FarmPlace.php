<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;
// use Illuminate\Database\Eloquent\Model;

class FarmPlace extends Model
{
    protected $connection = 'mongodb';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'geometry',
        'icon',
        'name',
        'photos',
        'place_id',
        'reference',
        'scope',
        'types',
        'vicinity',
        'center',
        'opening_hours',
        'rating',
        'price_level',
        'permanently_closed',
    ];
    protected $hidden = [
        'icon',
        'name',
        'photos',
        'place_id',
        'reference',
        'scope',
        'types',
        'vicinity',
        'center',
        'opening_hours',
        'rating',
        'price_level',
        'permanently_closed',
    ];
}
