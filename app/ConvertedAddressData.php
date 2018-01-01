<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class ConvertedAddressData extends Model
{
    protected $connection = 'mongodb';
    // protected $collection = 'converted_address_datas_collection';

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
        'original_address_datas_id',
    ];

    protected $casts = [
        'levels'=> 'array',
        'bounds'=> 'array',
    ];

    protected $hidden = [
        'levels',
        'bounds',
        'country',
        'original_address_datas_id',
        'created_at',
        'updated_at',
        'id',
    ];
    
    public function original_address_datas()
    {
        return $this->belongsTo('OriginalAddressData');
    }
}
