<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class YachtEquipment extends Model
{
    protected $table = 'api_yacht_equipment';

    protected $fillable = [
        'yacht_id',
        'equipmentId',
        'value',
    ];

    protected $casts = [
        'value' => 'string',
    ];    

    //public $timestamps = false;

    public function yacht()
    {
        return $this->belongsTo(Yacht::class, 'yacht_id', 'id');
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
