<?php

declare(strict_types=1);

return [
    'tables' => [
        'menus' => 'menus',
        'menu_items' => 'menu_items',
        'menu_locations' => 'menu_locations',
    ],
    'models' => [
        'Category' => \App\Models\Taxon::class,
        'Page' => \App\Models\Page::class,
        'Post' => \App\Models\Post::class,
    ],
];
