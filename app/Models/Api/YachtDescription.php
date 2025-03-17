<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class YachtDescription extends Model
{
    protected $table = 'api_yacht_descriptions';

    protected $fillable = [
        'yacht_id',
        'category',
        'text',
        'documents',
    ];

    //public $timestamps = false;

    public function yacht()
    {
        return $this->belongsTo(Yacht::class);
    }
}
