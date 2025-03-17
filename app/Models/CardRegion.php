<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CardRegion extends Model
{
    protected $table = 'card_regions';

    protected $fillable = [
        'heading', 'text', 'show_hp', 'img', 'flag', 'link'
    ];

    protected static function booted()
    {
        static::deleting(function ($cardRegion) {
            // Delete the related image (img) if it exists
            if (!empty($cardRegion->img)) {
                Storage::disk('public')->delete($cardRegion->img);
            }

            // Delete the related flag if it exists
            if (!empty($cardRegion->flag)) {
                Storage::disk('public')->delete($cardRegion->flag);
            }
        });

        static::updating(function ($cardRegion) {
            // Delete the old image if it's been updated and the old image exists
            if ($cardRegion->isDirty('img') && $cardRegion->getOriginal('img')) {
                Storage::disk('public')->delete($cardRegion->getOriginal('img'));
            }

            // Delete the old flag if it's been updated and the old flag exists
            if ($cardRegion->isDirty('flag') && $cardRegion->getOriginal('flag')) {
                Storage::disk('public')->delete($cardRegion->getOriginal('flag'));
            }
        });

        static::saved(function ($cardRegion) {
            // Delete the old image if it's been updated
            if ($cardRegion->isDirty('img') && $cardRegion->getOriginal('img')) {
                Storage::disk('public')->delete($cardRegion->getOriginal('img'));
            }

            // Delete the old flag if it's been updated
            if ($cardRegion->isDirty('flag') && $cardRegion->getOriginal('flag')) {
                Storage::disk('public')->delete($cardRegion->getOriginal('flag'));
            }
        });
    }
}
