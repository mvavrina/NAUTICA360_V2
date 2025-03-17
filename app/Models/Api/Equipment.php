<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'api_equipments';

    protected $fillable = [
        'id', 'name',
    ];

    public function worldRegion()
    {
        return $this->belongsTo(WorldRegion::class, 'id');
    }
    //public $timestamps = false;
}
