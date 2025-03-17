<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class SailingArea extends Model
{
    protected $table = 'api_sailing_areas';

    protected $fillable = [
        'id', 'name'
    ];
    
    //public $timestamps = false;
}
