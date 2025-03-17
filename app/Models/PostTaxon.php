<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTaxon extends Model
{
    protected $table = 'post_taxons';

    // Zde není potřeba nastavovat $fillable, protože tabulka slouží pouze jako spojovací
    // model pro vztah mezi post a taxon
    public $timestamps = false;
}
