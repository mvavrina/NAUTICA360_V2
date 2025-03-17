<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';

    protected $fillable = [
        'id', 'parent_id', 'title', 'type', 'object'
    ];

    // Definice vztahu pro rodičovský menu
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }
}
