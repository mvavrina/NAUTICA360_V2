<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class Shipyard extends Model
{
    protected $table = 'api_shipyards';

    protected $fillable = [
        'id', 'name', 'shortName'
    ];

    //public $timestamps = false;
}
