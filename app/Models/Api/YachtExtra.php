<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class YachtExtra extends Model
{
    protected $table = 'api_yacht_extras';

    protected $primaryKey = false;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'yacht_id',
        'name',
        'obligatory',
        'price',
        'currency',
        'unit',
        'payableInBase',
        'includesDepositWaiver',
        'validDaysFrom',
        'validDaysTo',
        'validDateFrom',
        'validDateTo',
        'sailingDateFrom',
        'sailingDateTo',
        'description',
        'availableInBase', // base ID 
        'validSailingAreas',
    ];

    protected $casts = [
        'obligatory' => 'boolean',
        'payableInBase' => 'boolean',  // Changed from 'payable_in_base'
        'includesDepositWaiver' => 'boolean',  // Changed from 'included_deposit_waiver'
        'validDaysFrom' => 'integer',  // Changed from 'valid_days_from'
        'validDaysTo' => 'integer',  // Changed from 'valid_days_to'
        'validDateFrom' => 'datetime',  // Changed from 'valid_date_from'
        'validDateTo' => 'datetime',  // Changed from 'valid_date_to'
        'availableInBase' => 'integer',  // Changed from 'available_in_base'
    ];

    //public $timestamps = false;

    public function yacht()
    {
        return $this->belongsTo(Yacht::class);
    }
}
