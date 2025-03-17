<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class WorldRegion extends Model
{
    protected $table = 'api_world_regions';

    protected $fillable = [
        'id', 'name'
    ];
    
    public function countries()
    {
        return $this->hasMany(Country::class, 'worldRegion', 'id');
    }

    //public $timestamps = false;
}
