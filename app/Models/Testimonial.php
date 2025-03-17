<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    //
    protected $fillable = [
        'name',
        'text',
        'customer_type',
        'show_hp',
        'img',
        'link',
    ];
}
