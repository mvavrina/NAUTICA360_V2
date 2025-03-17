<?php

namespace App\Livewire;

use App\Models\Api\Yacht;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Search extends Component
{
    use WithPagination;

    public $page = 1;
    public $perPage = 20; // Number of results per page

    // Properties to sync with the URL
    public $portName;
    public $yachtType;
    public $startDate;
    public $endDate;
    public $currency = 'EUR';
    public $showResults = false;

    // Sync these properties with the URL
    protected $queryString = [
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
        'currency' => ['except' => 'EUR'], // Default value is 'EUR'
        'page' => ['except' => 1], // Include page in the URL
    ];

    public function mount()
    {
        // Decode URL-encoded dates
        $this->startDate = urldecode($this->startDate);
        $this->endDate = urldecode($this->endDate);

        // Check if startDate and endDate are present and valid
        if ($this->startDate && $this->endDate) {
            // Validate the dates
            $validatedData = $this->validate([
                'startDate' => 'required|date',
                'endDate' => 'required|date|after_or_equal:startDate',
            ]);

            // If validation passes, trigger the search
            $this->callToSearch();
        }
    }

    #[On('updateDates')]
    public function setStartDate($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    // Metoda pro API požadavek s cachováním
    protected function apiRequest($endpoint, $method = 'GET', $data = [])
    {
        $cacheKey = 'api_request_' . md5($endpoint . json_encode($data));
        $cacheTTL = 3600; // Cache na 1 hodinu

        $apiData = Cache::get($cacheKey);

        if (!$apiData) {
            // Formátování dat
            if (isset($data['dateFrom'])) {
                $data['dateFrom'] = \Carbon\Carbon::parse($data['dateFrom'])->format('Y-m-d\TH:i:s');
            }
            if (isset($data['dateTo'])) {
                $data['dateTo'] = \Carbon\Carbon::parse($data['dateTo'])->format('Y-m-d\TH:i:s');
            }

            // Sestavení URL
            $baseUrl = config('api.base_url');
            $queryString = http_build_query($data);
            $url = "{$baseUrl}/{$endpoint}?{$queryString}";

            // Provedení API požadavku
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => config('services.api_key_secret')
            ])->timeout(300)->{$method}($url);

            if ($response->successful()) {
                $apiData = $response->json();
                Cache::put($cacheKey, $apiData, $cacheTTL); // Uložení do cache
            } else {
                throw new \Exception('API request failed: ' . $response->status());
            }
        }

        return $apiData;
    }

    // Metoda pro vyvolání vyhledávání
    public function callToSearch()
    {
        // Validate the input fields
        $this->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'currency' => 'required|string',
        ]);

        // Only reset the page if it's a new search (not when initializing from the URL)
        if (!$this->showResults && $this->page === 1) {
            $this->resetPage();
        }

        // Set the flag to show results
        $this->showResults = true;
    }

    // Metoda pro získání výsledků s paginací
    public function getResultsProperty()
    {

        if (!$this->showResults) {
            return collect()->paginate($this->perPage);
        }

        // Fetch results from the API
        $data = [
            'dateFrom' => $this->startDate,
            'dateTo' => $this->endDate,
            'currency' => $this->currency,
        ];
        $response = $this->apiRequest('/offers', 'GET', $data);

        // Collect and ensure unique yachts based on yachtId
        $results = collect($response)->unique(function ($item) {
            return $item['yachtId'] . '-' . $item['price']; // Combine yachtId and price to ensure uniqueness
        })->values();

        // Paginate the unique yacht results
        $paginatedResults = $results->forPage($this->page, $this->perPage);

        // Extract yacht IDs from the current page's items
        $yachtIds = collect($paginatedResults)->pluck('yachtId')->unique()->toArray();

        // Stáhnout pouze existující jachty
        $yachtsWithImages = DB::table('api_yachts')
            ->leftJoin('api_yacht_images', 'api_yachts.id', '=', 'api_yacht_images.yacht_id')
            ->whereIn('api_yachts.id', $yachtIds)
            ->select(
                'api_yachts.*',
                'api_yacht_images.id as image_id',
                DB::raw('CASE WHEN api_yacht_images.image_generated = 0 THEN api_yacht_images.url ELSE api_yacht_images.name END AS image_url')
            )
            ->get()
            ->groupBy('id');

        // Najít chybějící jachty
        $existingYachtIds = $yachtsWithImages->keys()->toArray();
        $missingYachtIds = array_diff($yachtIds, $existingYachtIds);

        // Pokud jsou chybějící jachty, zavolej API pro každou z nich
        if (!empty($missingYachtIds)) {
            foreach ($missingYachtIds as $missingId) {
                Http::timeout(15)->get(url('/yacht/' . $missingId));
            }

            // Po zavolání API znovu stáhneme nově přidané jachty
            $newYachtsWithImages = DB::table('api_yachts')
                ->leftJoin('api_yacht_images', 'api_yachts.id', '=', 'api_yacht_images.yacht_id')
                ->whereIn('api_yachts.id', $missingYachtIds)
                ->select(
                    'api_yachts.*',
                    'api_yacht_images.id as image_id',
                    DB::raw('CASE WHEN api_yacht_images.image_generated = 0 THEN api_yacht_images.url ELSE api_yacht_images.name END AS image_url')
                )
                ->get()
                ->groupBy('id');

            // Sloučíme nové jachty s těmi původními
            $yachtsWithImages = $yachtsWithImages->merge($newYachtsWithImages);
        }

        // Omezit obrázky a sjednotit kolekci
        $yachtsWithImages = $yachtsWithImages->map(fn($yachtImages) => $yachtImages->take(5))->flatten();

        // Group images by yacht ID
        $groupedYachts = $yachtsWithImages->groupBy('id')->map(function ($yacht) {
            return [
                'yacht' => $yacht->first(),
                'images' => $yacht->pluck('image_url')->filter()->values(),
            ];
        });

        // Combine API results with yacht data
        $combinedResults = collect($paginatedResults)->map(function ($item) use ($groupedYachts) {
            $item['yacht'] = $groupedYachts->get($item['yachtId']); // Add yacht data to the API result
            return $item;
        });

        // Return a new paginator with the combined results
        return new LengthAwarePaginator(
            $combinedResults,
            count($results), // Total count of unique yachts
            $this->perPage,
            $this->page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );
    }

    public function gotoPage($id, $name)
    {
        $this->page = $id;
    }


    // Renderování view s paginovanými výsledky
    public function render()
    {
        return view('livewire.search', [
            'results' => $this->getResultsProperty(),
        ]);
    }
}
