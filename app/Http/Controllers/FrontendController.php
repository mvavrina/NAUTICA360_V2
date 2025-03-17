<?php

namespace App\Http\Controllers;

use App\Models\Api\Equipment;
use App\Models\Api\Yacht;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FrontendController extends Controller
{
    //

    public function search(){
        return view('frontend.boat.list');
    }

    public function boatDetail($id){
        $equipments = Equipment::orderBy('name')->get();
        $yacht = Yacht::find($id);

        // Get all the associated equipment IDs for the yacht
        $yachtEquipmentIds = $yacht->equipment->pluck('equipmentId')->toArray();
        
        $allExtras = $yacht->productsExtras()->get()->unique('name');
        $extras = [$allExtras->where('obligatory', '!=', 1), $allExtras->where('obligatory', '=', 1)];

        $base = $yacht->homeBase()->first();

        return view('frontend.boat.detail', [
            'yacht' => $yacht, 
            'base' => $base, 
            'extras' => $extras, 
            'equipments' => $equipments,
            'yachtEquipmentIds' => $yachtEquipmentIds
        ]);
    }

    public function reservation(Request $request)
    {
        $id = $request->query('id');
        $dateFrom = urldecode($request->query('dateFrom'));  // Decode the URL-encoded start date
        $dateTo = urldecode($request->query('dateTo'));  // Decode the URL-encoded end date
        
        if(empty($id) || empty($dateFrom) || empty($dateTo)){
            return abort(404);
        }
        // Convert dates to Carbon instances and format them as Y-m-d\TH:i:s
        $startDate = Carbon::createFromFormat('m/d/Y', $dateFrom)->format('Y-m-d\TH:i:s');  // Format as '2025-04-19T00:00:00'
        $endDate = Carbon::createFromFormat('m/d/Y', $dateTo)->format('Y-m-d\TH:i:s');  // Format as '2025-04-26T00:00:00'
    
        // URL encode the formatted dates to ensure the correct structure
        $startDateEncoded = urlencode($startDate);  // E.g., '2025-04-19T00:00:00' becomes '2025-04-19T00%3A00%3A00'
        $endDateEncoded = urlencode($endDate);  // E.g., '2025-04-26T00:00:00' becomes '2025-04-26T00%3A00%3A00'
    
        // Perform any additional logic, like fetching the yacht data
        $yacht = Yacht::findOrFail($id);  // Assuming you're fetching a yacht by its ID

    
        // Prepare API request parameters
        $data = [
            'yachtId' => $yacht->id,
            'dateFrom' => $startDate,
            'dateTo' => $endDate,
            'currency' => 'EUR',
        ];
    
        // Construct the URL for the /prices endpoint
        $baseUrl = config('api.base_url');
        $url = "{$baseUrl}/prices/?yachtId={$yacht->id}&dateFrom={$startDateEncoded}&dateTo={$endDateEncoded}&currency=EUR";
    
        try {
            // Make the API request
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => config('services.api_key_secret'),
            ])->timeout(10)->get($url);
    
            if ($response->successful()) {
                $pricingData = $response->json();
            } else {
                $pricingData = ['error' => 'Failed to fetch pricing data'];
            }
        } catch (\Exception $e) {
            $pricingData = ['error' => 'Exception occurred while fetching pricing'];
        };
        // Pass data to the view
        return view('frontend.reservation', compact('yacht', 'startDate', 'endDate', 'pricingData'));
    }

    public function fqs(){
        
    }

    public function sitemap(){
        
    }
}
