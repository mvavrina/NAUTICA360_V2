<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class YachtImage extends Model
{
    protected $table = 'api_yacht_images';

    protected $fillable = [
        'yacht_id',
        'name',
        'description',
        'url',
        'sortOrder',
        'image_generated',
    ];

    //public $timestamps = false;

    public function yacht()
    {
        return $this->belongsTo(Yacht::class);
    }
}
