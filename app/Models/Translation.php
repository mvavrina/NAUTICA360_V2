<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $table = 'translations';

    protected $fillable = [
        'name', 'language_id', 'value'
    ];

    // Definice vztahu k tabulce Language
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
