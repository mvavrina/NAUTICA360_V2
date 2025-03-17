<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class YachtType extends Model
{
    protected $table = 'api_yacht_types';

    protected $fillable = [
        'name'
    ];

    //public $timestamps = false;
}
