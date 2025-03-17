<?php

namespace App\Models;

use Biostate\FilamentMenuBuilder\Traits\Menuable;
use Illuminate\Database\Eloquent\Model;

class Taxon extends Model
{
    use Menuable;
    protected $table = 'taxons';

    protected $fillable = [
        'id', 'parent_id', 'title', 'slug', 'description'
    ];

    protected static function booted()
    {
        static::deleting(function ($taxon) {
            $menuItems = \Biostate\FilamentMenuBuilder\Models\MenuItem::where('menuable_type', self::class)
                ->where('menuable_id', $taxon->id)
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
        return route('handleSlug', $this->slug);
    }
    
    public function getMenuNameAttribute(): string
    {
        return $this->name;
    }

    // Definice vztahu pro rodičovský taxon
    public function parent()
    {
        return $this->belongsTo(Taxon::class, 'parent_id');
    }

    // Definice vztahu pro příspěvky
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_taxons');
    }
    
}