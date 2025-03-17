<?php

namespace App\Models;

use Biostate\FilamentMenuBuilder\Traits\Menuable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use Menuable;
    protected $table = 'posts';

    protected $fillable = [
        'id', 'title', 'published', 'content', 'tooltip', 'thumbnail', 'exceprt', 'slug', 'hp'
    ];

    protected $casts = [
        'published' => 'datetime',
    ];    

    public static function getFilamentSearchLabel(): string
    {
        return 'title';
    }

    public function getMenuLinkAttribute(): string
    {
        return route('post.show', $this);
    }

    public function getMenuNameAttribute(): string
    {
        return $this->title; // Change based on your column name
    }

    public function getRouteKeyName()
    {
        return 'slug'; // Laravel automaticky používá slug místo ID
    }

    protected static function booted()
    {
        static::deleting(function ($post) {
            $menuItems = \Biostate\FilamentMenuBuilder\Models\MenuItem::where('menuable_type', self::class)
                ->where('menuable_id', $post->id)
                ->get();

            // If related MenuItems exist, delete them
            if ($menuItems->isNotEmpty()) {
                $menuItems->each(function ($menuItem) {
                    $menuItem->delete();
                });
            }
                
            if (!empty($post->thumbnail)) {
                Storage::disk('public')->delete($post->thumbnail);
            }
        });
    
        static::updating(function ($post) {
            if ($post->isDirty('thumbnail') && $post->getOriginal('thumbnail')) {
                Storage::disk('public')->delete($post->getOriginal('thumbnail'));
            }
        });
    
        static::saved(function ($post) {
            if ($post->isDirty('thumbnail') && $post->getOriginal('thumbnail')) {
                Storage::disk('public')->delete($post->getOriginal('thumbnail'));
            }
        });    
    }

    protected static function afterSave($record)
    {
        // Check if the image was updated
        if ($record->isDirty('thumbnail') && $record->getOriginal('thumbnail')) {
            // Delete the old image if it exists
            Storage::disk('public')->delete($record->getOriginal('thumbnail'));
        }
    }

    // Definice vztahu pro obrázek
    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    // Vztah pro taxony
    public function taxons()
    {
        return $this->belongsToMany(Taxon::class, 'post_taxons');
    }
    

}
