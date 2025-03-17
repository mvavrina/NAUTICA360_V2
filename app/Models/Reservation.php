<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Api\Yacht;

class Reservation extends Model
{
    protected $table = 'reservations';

    protected $fillable = [
        'id', 'first_name', 'last_name', 'email', 'tel', 'date_from', 'date_to', 'reserved', 'yacht_id', 'price', 'discount', 'base_price', 'note', 'status'
    ];

    public function yacht()
    {
        return $this->belongsTo(Yacht::class);
    }
}
