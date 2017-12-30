<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class OriginalAddressData extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'original_address_datas_collection';
    
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
        'fail_count',
        'is_queue',
    ];

    protected $casts = [
        'is_fail'=>'boolean',
        'is_queue'=>'boolean',
        'is_converted'=>'boolean',
        'fail_count'=>'integer',
    ];
}
