<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    return view('welcome');
});

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

