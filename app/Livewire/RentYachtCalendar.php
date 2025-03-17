<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class RentYachtCalendar extends Component
{
    public $startDate;
    public $endDate;
    public $yachtId;
    public $availabilityData;

    // Mount method to accept props
    public function mount($startDate, $endDate, $yachtId)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->yachtId = $yachtId;

        // Fetch availability data based on the start and end dates
        $this->fetchAvailabilityData($yachtId);
    }

    // Method to fetch availability data from the API
    public function fetchAvailabilityData($yachtId)
    {
        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate);

        // Get current date and time in required format (yyyy-MM-dd'T'HH:mm:ss)
        $currentDate = Carbon::now()->format('Y-m-d\TH:i:s');
        
        // Calculate the date 8 weeks later
        $dateEightWeeksLater = Carbon::now()->addWeeks(8)->format('Y-m-d\TH:i:s');

        // Prepare the query parameters
        $data = [
            'yachtId' => $yachtId,
            'dateFrom' => $currentDate,  // Use the formatted date for 'dateFrom'
            'dateTo' => $dateEightWeeksLater,  // Use the formatted date for 'dateTo'
            'flexibility' => 6,  // Assuming flexibility 2 (week)
            'currency' => 'EUR',  // Currency in lowercase as per your example
            'showOptions' => true,  // Assuming show options flag
        ];

        // Construct the final URL
        $baseUrl = config('api.base_url');
        $url = "{$baseUrl}/offers?" . http_build_query($data);

        // Make the API request using the constructed URL
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => config('services.api_key_secret'),
        ])->timeout(600)->get($url);

        // If successful, store the response data, otherwise log the error
        if ($response->successful()) {
            $this->availabilityData = $response->json();  // Store the data in a public property
        } else {
            Log::error('API request failed: ' . $response->status());
            $this->availabilityData = ['error' => 'Failed to fetch availability data'];
        }
    }

    public function render()
    {
        return view('livewire.rent-yacht-calendar', [
            'availabilityData' => $this->availabilityData,  // Pass data to the view
        ]);
    }
}
