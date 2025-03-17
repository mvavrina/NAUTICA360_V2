<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'api_companies';

    protected $fillable = [
        'id', 'name', 'address', 'city', 'zip', 'country', 'telephone', 'telephone2', 'mobile', 'mobile2', 'vatCode',
        'email', 'web', 'bankAccountNumber', 'termsAndConditions', 'checkoutNote', 'maxDiscountFromCommissionPercentage'
    ];

    //public $timestamps = false;

    public function countries(){
        return $this->hasMany(Country::class, 'country', 'id');
    }
}
