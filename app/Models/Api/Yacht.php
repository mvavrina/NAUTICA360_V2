<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class Yacht extends Model
{
    protected $table = 'api_yachts';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'model',
        'modelId',
        'shipyardId',
        'year',
        'kind',
        'certificate',
        'homeBaseId',
        'homeBase',
        'companyId',
        'company',
        'draught',
        'beam',
        'length',
        'waterCapacity',
        'fuelCapacity',
        'engine',
        'deposit',
        'depositWithWaiver',
        'currency',
        'commissionPercentage',
        'maxDiscountFromCommissionPercentage',
        'wc',
        'berths',
        'cabins',
        'wcNote',
        'berthsNote',
        'cabinsNote',
        'transitLog',
        'mainsailArea',
        'genoaArea',
        'mainsailType',
        'genoaType',
        'requiredSkipperLicense',
        'defaultCheckInDay',
        'allCheckInDays',
        'defaultCheckInTime',
        'defaultCheckOutTime',
        'minimumCharterDuration',
        'maximumCharterDuration',
        'maxPeopleOnBoard',
        'comment'
    ];

    //public $timestamps = false;

    public function images()
    {
        return $this->hasMany(YachtImage::class, 'yacht_id')
                    ->orderByRaw("CASE
                                    WHEN description = 'Main image' THEN 1
                                    WHEN description = 'Interior image' THEN 2
                                    WHEN description = 'Plan image' THEN 3
                                    ELSE 4
                                 END");
    }
    
    public function equipment()
    {
        return $this->hasMany(YachtEquipment::class, 'yacht_id', 'id');
    }
    
    public function products()
    {
        return $this->hasMany(YachtProduct::class, 'yacht_id');
    }
    
    public function productsExtras()
    {
        return $this->hasMany(YachtExtra::class, 'yacht_id');
    }

    public function crew()
    {
        return $this->hasMany(YachtCrew::class, 'yacht_id');
    }

    public function descriptions()
    {
        return $this->hasMany(YachtDescription::class, 'yacht_id');
    }

    public function licenses()
    {
        return $this->hasMany(YachtLicense::class, 'yacht_id');
    }

    public function shipyard()
    {
        return $this->belongsTo(Shipyard::class, 'shipyardId', 'id');
    }

    public function homeBase()
    {
        return $this->belongsTo(Base::class, 'homeBaseId', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'companyId', 'id');
    }
}
