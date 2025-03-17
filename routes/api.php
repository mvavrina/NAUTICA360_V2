<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

// init Redis
Route::get('/call-all-routes', [ApiController::class, 'callAllRoutes']);
// Countries
Route::get('/countries', [ApiController::class, 'getCountries']);
Route::get('/country/{id}', [ApiController::class, 'getCountry']);

// World Regions
Route::get('/worldRegions', [ApiController::class, 'getWorldRegions']);
Route::get('/worldRegion/{id}', [ApiController::class, 'getWorldRegion']);

// Sailing Areas
Route::get('/sailingAreas', [ApiController::class, 'getSailingAreas']);
Route::get('/sailingArea/{id}', [ApiController::class, 'getSailingArea']);

// Bases
Route::get('/bases', [ApiController::class, 'getBases']);
Route::get('/base/{id}', [ApiController::class, 'getBase']);

// Equipment
Route::get('/equipment', [ApiController::class, 'getEquipment']);

// Companies
Route::get('/companies', [ApiController::class, 'getCompanies']);
Route::get('/company/{id}', [ApiController::class, 'getCompany']);

// Shipyards
Route::get('/shipyards', [ApiController::class, 'getShipyards']);
Route::get('/shipyard/{id}', [ApiController::class, 'getShipyard']);

// Yachts
Route::get('/yachts', [ApiController::class, 'getYachts']);
Route::get('/yacht/{id}', [ApiController::class, 'getYacht']);

// Yacht Types
Route::get('/yachtTypes', [ApiController::class, 'getYachtTypes']);

// Offers
Route::get('/offers', [ApiController::class, 'getOffers']);
Route::get('/specialOffers', [ApiController::class, 'getSpecialOffers']);
Route::get('/specialOffers/{offerType}', [ApiController::class, 'getSpecialOffersByType']);

// Prices
Route::get('/prices', [ApiController::class, 'getPrices'])->name('prices');
Route::put('/setWeeklyPrice/{id}', [ApiController::class, 'setWeeklyPrice']);

// Reservations
Route::post('/reservation', [ApiController::class, 'createReservation']);
Route::get('/reservation/{reservationId}', [ApiController::class, 'getReservation']);
Route::put('/reservation/{reservationId}', [ApiController::class, 'confirmReservation']);
Route::delete('/reservation/{reservationId}', [ApiController::class, 'cancelReservation']);
Route::get('/reservations/{year}', [ApiController::class, 'getReservations']);

// Availability
Route::get('/availability/{year}', [ApiController::class, 'getAvailability']);
Route::get('/shortAvailability/{year}', [ApiController::class, 'getShortAvailability']);

// Documents
Route::post('/addDocument/{itemType}', [ApiController::class, 'addDocument']);

// Crew List
Route::get('/crewListLink/{reservationId}', [ApiController::class, 'getCrewListLink']);

// Invoices
Route::get('/invoices/{invoiceType}', [ApiController::class, 'getInvoices']);

// Users
Route::get('/users', [ApiController::class, 'getUsers']);
Route::post('/users', [ApiController::class, 'createUser']);
Route::post('/users/search', [ApiController::class, 'searchUsers']);
Route::get('/users/{id}', [ApiController::class, 'getUser']);
Route::put('/users/{id}', [ApiController::class, 'updateUser']);

// Skippers
Route::get('/skippers', [ApiController::class, 'getSkippers']);

// General
Route::get('/objects/{entity}/properties', [ApiController::class, 'getEntityProperties']);
