<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class YachtProduct extends Model
{
    protected $table = 'api_yacht_products';

    protected $fillable = [
        'yacht_id',
        'name',
        'crewedByDefault',
        'isDefaultProduct',
    ];

    //public $timestamps = false;

    public function yacht()
    {
        return $this->belongsTo(Yacht::class);
    }
}
