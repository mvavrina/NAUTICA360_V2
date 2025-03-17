<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PageOrTaxonController;
use App\Models\Page;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.homepage');
})->name('Domovská stránka');

Route::get('/lod/{id}', [FrontendController::class, 'boatDetail'])->name('yacht.detail');
Route::get('/rezervace', [FrontendController::class, 'reservation'])->name('yacht.reservation');
Route::get('/vyhledat-lod', [FrontendController::class, 'search'])->name('yacht.search');

Route::get('/oblibene-destinace', [PageController::class, 'destinations'])->name('Oblíbené destinace');

Route::get('/faqs', [FrontendController::class, 'faqs'])->name('faqs');

Route::get('/sitemap.xml', [FrontendController::class, 'sitemap'])->name('Sitemapa');

Route::get('/spolecnosti', function () {
    return view('frontend.company.list');
})->name('Přehled společností');

Route::get('/spolecnost/{id}', function ($id) {
    return view('frontend.company.detail', compact('id'));
})->name('Detail společnosti');

Route::get('/mariny', function () {
    return view('frontend.base.list');
})->name('Přehled marín');

Route::get('/marina/{id}', function ($id) {
    return view('frontend.base.detail', compact('id'));
})->name('Detail maríny');


Route::get('/prispevky/{taxonSlugSearch?}', [PageController::class, 'posts'])->name('prehled-prispevku');

Route::get('/prispevek/{slug}', [PageController::class, 'postsShow'])->name('prehled-prispevku-detail');

Route::get('{slug}/{postSlug?}', [PageOrTaxonController::class, 'handleSlug'])->name('handleSlug');