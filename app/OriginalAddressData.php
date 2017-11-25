<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OriginalAddressData extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'is_fail',
        'is_converted',
    ];

    protected $casts = [
        'is_fail'=>'boolean',
        'is_converted'=>'boolean',
    ];
}
