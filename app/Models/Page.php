<?php

namespace App\Models;

use Biostate\FilamentMenuBuilder\Traits\Menuable;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use Menuable;
    protected $table = 'pages';

    protected $fillable = [
        'id', 'language_id', 'title', 'published', 'content', 'content_en', 'slug'
    ];

    protected static function booted()
    {
        static::deleting(function ($page) {
            $menuItems = \Biostate\FilamentMenuBuilder\Models\MenuItem::where('menuable_type', self::class)
                ->where('menuable_id', $page->id)
                ->get();

            // If related MenuItems exist, delete them
            if ($menuItems->isNotEmpty()) {
                $menuItems->each(function ($menuItem) {
                    $menuItem->delete();
                });
            }
        });
    }

    public static function getFilamentSearchLabel(): string
    {
        return 'title';
    }

    public function getMenuLinkAttribute(): string
    {
        return route('handleSlug', $this);
    }
    
    public function getMenuNameAttribute(): string
    {
        return $this->title;
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function getRouteKeyName()
    {
        return 'slug'; // Laravel automaticky používá slug místo ID
    }

}
