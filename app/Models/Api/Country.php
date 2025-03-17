<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'api_countries';

    protected $fillable = [
        'id', 'worldRegion', 'name', 'shortName', 'longName'
    ];

    public function worldRegion()
    {
        return $this->belongsTo(WorldRegion::class, 'id');
    }
}
