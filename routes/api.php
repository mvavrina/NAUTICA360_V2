<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/yachts', function () {
    $response = Http::withHeaders([
        'Accept' => 'application/json',
        'Authorization' => config('services.api_key_secret')
    ])
    ->get('https://www.booking-manager.com/api/v2/countries');

    // Check if the response was successful
    if ($response->successful()) {
        return response()->json($response->json());
    } else {
        return response()->json(['error' => 'Unable to fetch countries'], 500);
    }
});

// Countries
Route::get('/countries', 'ApiController@getCountries');
Route::get('/country/{id}', 'ApiController@getCountry');

// World Regions
Route::get('/worldRegions', 'ApiController@getWorldRegions');
Route::get('/worldRegion/{id}', 'ApiController@getWorldRegion');

// Sailing Areas
Route::get('/sailingAreas', 'ApiController@getSailingAreas');
Route::get('/sailingArea/{id}', 'ApiController@getSailingArea');

// Bases
Route::get('/bases', 'ApiController@getBases');
Route::get('/base/{id}', 'ApiController@getBase');

// Equipment
Route::get('/equipment', 'ApiController@getEquipment');

// Companies
Route::get('/companies', 'ApiController@getCompanies');
Route::get('/company/{id}', 'ApiController@getCompany');

// Shipyards
Route::get('/shipyards', 'ApiController@getShipyards');
Route::get('/shipyard/{id}', 'ApiController@getShipyard');

// Yachts
Route::get('/yachts', 'ApiController@getYachts');
Route::get('/yacht/{id}', 'ApiController@getYacht');

// Yacht Types
Route::get('/yachtTypes', 'ApiController@getYachtTypes');

// Offers
Route::get('/offers', 'ApiController@getOffers');
Route::get('/specialOffers', 'ApiController@getSpecialOffers');
Route::get('/specialOffers/{offerType}', 'ApiController@getSpecialOffersByType');

// Prices
Route::get('/prices', 'ApiController@getPrices');
Route::put('/setWeeklyPrice/{id}', 'ApiController@setWeeklyPrice');

// Reservations
Route::post('/reservation', 'ApiController@createReservation');
Route::get('/reservation/{reservationId}', 'ApiController@getReservation');
Route::put('/reservation/{reservationId}', 'ApiController@confirmReservation');
Route::delete('/reservation/{reservationId}', 'ApiController@cancelReservation');
Route::get('/reservations/{year}', 'ApiController@getReservations');

// Availability
Route::get('/availability/{year}', 'ApiController@getAvailability');
Route::get('/shortAvailability/{year}', 'ApiController@getShortAvailability');

// Documents
Route::post('/addDocument/{itemType}', 'ApiController@addDocument');

// Crew List
Route::get('/crewListLink/{reservationId}', 'ApiController@getCrewListLink');

// Invoices
Route::get('/invoices/{invoiceType}', 'ApiController@getInvoices');

// Users
Route::get('/users', 'ApiController@getUsers');
Route::post('/users', 'ApiController@createUser');
Route::post('/users/search', 'ApiController@searchUsers');
Route::get('/users/{id}', 'ApiController@getUser');
Route::put('/users/{id}', 'ApiController@updateUser');

// Skippers
Route::get('/skippers', 'ApiController@getSkippers');

// General
Route::get('/objects/{entity}/properties', 'ApiController@getEntityProperties');
