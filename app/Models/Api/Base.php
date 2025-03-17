<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    protected $table = 'api_bases';

    protected $fillable = [
        'id', 'name', 'city', 'country', 'address', 'latitude', 'longitude', 'countryId', 'sailingAreas'
    ];

    //public $timestamps = false;

    public function getCountry(){
        return $this->belongsTo(Country::class, 'countryId');
    }
}
