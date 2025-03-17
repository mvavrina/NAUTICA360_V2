<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Livewire\Attributes\On;

class YachtRentalForm extends Component
{
    public $yacht;
    public $startDate;
    public $endDate;
    public $pricingData;
    public $formatedStartDate;
    public $formatedEndDate;
    public $extras;

    // Mount method to accept props
    public function mount($yacht, $startDate, $endDate, $extras)
    {
        $this->yacht = $yacht;
        $this->extras = $extras;
    
        // If start date is not provided, set it to the upcoming Sunday
        if (empty($startDate)) {
            $startDate = Carbon::now()->next(Carbon::SATURDAY)->format('Y-m-d');
        }
    
        $this->startDate = $startDate;
    
        // If end date is not provided, set it to the next Sunday after the start date
        if (empty($endDate)) {
            $endDate = Carbon::parse($startDate)->addWeek()->format('Y-m-d');
        }
    
        $this->endDate = $endDate;
    
        // Format the start and end dates
        $this->formatedStartDate = Carbon::parse($startDate)->format('d.m.Y');
        $this->formatedEndDate = Carbon::parse($endDate)->format('d.m.Y');
    
        // Fetch pricing data for the selected date range
        $this->fetchPricingData();
    }


    // Method to fetch pricing data from the API
    public function fetchPricingData()
    {
        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate);

        // Prepare the query parameters
        $data = [
            'yachtId' => $this->yacht->id,
            'dateFrom' => $start->format('Y-m-d\TH:i:s'),  // Start date for the range
            'dateTo' => $end->format('Y-m-d\TH:i:s'),  // End date for the range
            'currency' => 'EUR',  // Currency in lowercase
        ];

        // Construct the final URL for the /prices endpoint
        $baseUrl = config('api.base_url');
        $url = "{$baseUrl}/prices?" . http_build_query($data);
        // Make the API request using the constructed URL
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => config('services.api_key_secret'),
        ])->timeout(600)->get($url);
        
        // If successful, store the response data, otherwise log the error
        if ($response->successful()) {
            $this->pricingData = $response->json();  // Store the pricing data
        } else {
            Log::error('API request failed: ' . $response->status());
            $this->pricingData = ['error' => 'Failed to fetch pricing data'];
        }
    }

    public function render()
    {
        return view('livewire.yacht-rental-form', [
            'pricingData' => $this->pricingData,  // Pass pricing data to the view
        ]);
    }
}
