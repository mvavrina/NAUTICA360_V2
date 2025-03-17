<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CardCity extends Model
{
    protected $table = 'card_cities';

    protected $fillable = [
        'heading', 'text', 'show_hp', 'img', 'link'
    ];

    protected static function booted()
    {
        static::deleting(function ($cardCity) {
            // Delete the related image (img) if it exists
            if (!empty($cardCity->img)) {
                Storage::disk('public')->delete($cardCity->img);
            }
        });

        static::updating(function ($cardCity) {
            // Delete the old image if it's been updated and the old image exists
            if ($cardCity->isDirty('img') && $cardCity->getOriginal('img')) {
                Storage::disk('public')->delete($cardCity->getOriginal('img'));
            }
        });

        static::saved(function ($cardCity) {
            // Delete the old image if it's been updated
            if ($cardCity->isDirty('img') && $cardCity->getOriginal('img')) {
                Storage::disk('public')->delete($cardCity->getOriginal('img'));
            }
        });
    }
}
