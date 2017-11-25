<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConvertedAddressData extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'levels',
        'bounds',
        'country',
        'address',
        'latitude',
        'longitude',
    ];
    
    protected $casts = [
        'levels'=>'array',
        'bounds'=>'array',
    ];
}
