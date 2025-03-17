<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class YachtCrew extends Model
{
    protected $table = 'api_yacht_crews';

    protected $fillable = [
        'id',
        'yacht_id',
        'name',
        'description',
        'age',
        'nationality',
        'roles',
        'licenses',
        'languages',
        'images',
    ];

    //public $timestamps = false;

    public function yacht()
    {
        return $this->belongsTo(Yacht::class);
    }
}
