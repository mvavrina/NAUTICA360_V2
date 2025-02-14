<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    protected function apiRequest($endpoint, $method = 'GET', $data = [])
    {
        $baseUrl = config('api.base_url');
    
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => config('services.api_key_secret')
        ])->{$method}("{$baseUrl}/{$endpoint}", $data);
    
        return $response->successful()
            ? response()->json($response->json())
            : response()->json(['error' => 'API request failed'], $response->status());
    }
    
    public function getCountries()
    {
        return $this->apiRequest('countries');
    }

    public function getCountry($id)
    {
        return $this->apiRequest("countries/{$id}");
    }

    public function getWorldRegions()
    {
        return $this->apiRequest('worldRegions');
    }

    public function getWorldRegion($id)
    {
        return $this->apiRequest("worldRegions/{$id}");
    }

    public function getSailingAreas()
    {
        return $this->apiRequest('sailingAreas');
    }

    public function getSailingArea($id)
    {
        return $this->apiRequest("sailingAreas/{$id}");
    }

    public function getBases()
    {
        return $this->apiRequest('bases');
    }

    public function getBase($id)
    {
        return $this->apiRequest("bases/{$id}");
    }

    public function getEquipment()
    {
        return $this->apiRequest('equipment');
    }

    public function getCompanies()
    {
        return $this->apiRequest('companies');
    }

    public function getCompany($id)
    {
        return $this->apiRequest("companies/{$id}");
    }

    public function getShipyards()
    {
        return $this->apiRequest('shipyards');
    }

    public function getShipyard($id)
    {
        return $this->apiRequest("shipyards/{$id}");
    }

    public function getYachts()
    {
        return $this->apiRequest('yachts');
    }

    public function getYacht($id)
    {
        return $this->apiRequest("yachts/{$id}");
    }

    public function getYachtTypes()
    {
        return $this->apiRequest('yachtTypes');
    }

    public function getOffers()
    {
        return $this->apiRequest('offers');
    }

    public function getSpecialOffers()
    {
        return $this->apiRequest('specialOffers');
    }

    public function getSpecialOffersByType($offerType)
    {
        return $this->apiRequest("specialOffers/{$offerType}");
    }

    public function getPrices()
    {
        return $this->apiRequest('prices');
    }

    public function setWeeklyPrice($id, Request $request)
    {
        return $this->apiRequest("setWeeklyPrice/{$id}", 'PUT', $request->all());
    }

    public function createReservation(Request $request)
    {
        return $this->apiRequest('reservation', 'POST', $request->all());
    }

    public function getReservation($reservationId)
    {
        return $this->apiRequest("reservation/{$reservationId}");
    }

    public function confirmReservation($reservationId)
    {
        return $this->apiRequest("reservation/{$reservationId}", 'PUT');
    }

    public function cancelReservation($reservationId)
    {
        return $this->apiRequest("reservation/{$reservationId}", 'DELETE');
    }

    public function getReservations($year)
    {
        return $this->apiRequest("reservations/{$year}");
    }

    public function getAvailability($year)
    {
        return $this->apiRequest("availability/{$year}");
    }

    public function getShortAvailability($year)
    {
        return $this->apiRequest("shortAvailability/{$year}");
    }

    public function addDocument($itemType, Request $request)
    {
        return $this->apiRequest("addDocument/{$itemType}", 'POST', $request->all());
    }

    public function getCrewListLink($reservationId)
    {
        return $this->apiRequest("crewListLink/{$reservationId}");
    }

    public function getInvoices($invoiceType)
    {
        return $this->apiRequest("invoices/{$invoiceType}");
    }

    public function getUsers()
    {
        return $this->apiRequest('users');
    }

    public function createUser(Request $request)
    {
        return $this->apiRequest('users', 'POST', $request->all());
    }

    public function searchUsers(Request $request)
    {
        return $this->apiRequest('users/search', 'POST', $request->all());
    }

    public function getUser($id)
    {
        return $this->apiRequest("users/{$id}");
    }

    public function updateUser($id, Request $request)
    {
        return $this->apiRequest("users/{$id}", 'PUT', $request->all());
    }

    public function getSkippers()
    {
        return $this->apiRequest('skippers');
    }

    public function getEntityProperties($entity)
    {
        return $this->apiRequest("objects/{$entity}/properties");
    }
}
