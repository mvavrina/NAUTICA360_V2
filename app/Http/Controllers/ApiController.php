<?php

namespace App\Http\Controllers;

use App\Services\YachtService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Api\{Base, Country, WorldRegion, YachtImage, Company, Yacht, YachtLicense, YachtCrew, YachtProduct, Equipment, YachtDescription, YachtType, SailingArea, YachtEquipment, Shipyard, YachtExtra};
use Illuminate\Support\Facades\Cache;

// yacht id 5598752170000106841
class ApiController extends Controller
{
    protected $yachtService;

    public function __construct(YachtService $yachtService)
    {
        $this->yachtService = $yachtService;
    }

    protected function apiRequest($endpoint, $method = 'GET', $data = [])
    {
        $baseUrl = config('api.base_url');
        $data['language'] = 'cs';

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => config('services.api_key_secret')
        ])->timeout(600)->{$method}("{$baseUrl}/{$endpoint}", $data);

        return $response->successful()
            ? Log::info($response->json())
            : response()->json(['error' => 'API request failed'], $response->status());
    }

    protected function apiRequestSave($endpoint, $model, $method = 'GET', $data = [])
    {
        $baseUrl = config('api.base_url');
        $data['language'] = 'cs';

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => config('services.api_key_secret')
        ])->timeout(600)->{$method}("{$baseUrl}/{$endpoint}", $data);

        if (!$response->successful()) {
            return response()->json(['error' => 'API request failed'], $response->status());
        }

        $apiData = collect($response->json()); // Data from API
        $existingRecords = $model::all()->keyBy('id'); // Existing records in DB by ID
        $updatedCount = 0;
        $createdCount = 0;

        // Synchronize data
        foreach ($apiData as $item) {
            $record = $existingRecords->get($item['id']);

            // Ensure sailingAreas is properly formatted as JSON
            if (isset($item['sailingAreas']) && is_array($item['sailingAreas'])) {
                $item['sailingAreas'] = json_encode($item['sailingAreas']);
            }

            // If an existing record is found, only compare other columns
            if ($record) {

                // If data is different, perform update
                $record->update($item);
                $updatedCount++;

                // Remove the record from the existing records collection
                $existingRecords->forget($item['id']);
            } else {
                // If the record doesn't exist, create a new one
                if (isset($item['allCheckInDays']) && is_array($item['allCheckInDays'])) {
                    $item['allCheckInDays'] = json_encode($item['allCheckInDays']);
                }
                $model::create($item);
                $createdCount++;
            }
        }

        // Delete records that are no longer in the API data
        $existingRecords->each->delete();

        // Log synchronization details
        Log::channel('api_sync_log')->info('ApiSyncLog', [
            'table' => (new $model)->getTable(),
            'updated' => $updatedCount,
            'created' => $createdCount,
            'deleted' => $existingRecords->count()
        ]);

        return response()->json(['message' => 'Data synchronized successfully']);
    }

    //help func
    protected function fetchNonEmptyValues($item)
    {
        // Define an array of fields that need to be checked for non-empty values
        $fieldsToCheck = [
            'certificate',
            'wcNote',
            'berthsNote',
            'cabinsNote',
            'yearNote',
            'comment',
            'images',
            'equipment',
            'products',
            'descriptions',
            'crew'
        ];

        // Loop through each field and log it if it's not empty
        foreach ($fieldsToCheck as $field) {
            // Special handling for array-type fields like 'images', 'equipment', 'products', etc.
            if (is_array($item[$field])) {
                // Handle special cases where the field is an array
                if (!empty($item[$field])) {
                    // Check each item within arrays for non-empty descriptions or values
                    foreach ($item[$field] as $subFieldKey => $subFieldValue) {
                        if (!is_array($subFieldValue)) {
                            if (!empty($subFieldValue)) {
                                Log::info("Column: {$field} -> Subfield: {$subFieldKey} /n Value: {$subFieldValue}");
                            }
                        }

                        // Special case for products -> extras -> validSailingAreas
                        if ($field === 'products' && isset($subFieldValue['extras'])) {
                            foreach ($subFieldValue['extras'] as $extra) {
                                if (isset($extra['validSailingAreas']) && !empty($extra['validSailingAreas'])) {
                                    Log::info("Column: {$field} -> Subfield: {$subFieldKey} -> validSailingAreas /n Value: " . json_encode($extra['validSailingAreas']));
                                }
                            }
                        }
                    }
                }
            } else {
                // Handle regular fields (non-arrays) with a simple check for non-empty values
                if (!empty($item[$field])) {
                    Log::info("Column: {$field} /n Value: {$item[$field]}");
                }
            }
        }
    }


    public function apiRequestSaveYachts($endpoint, $model, $method = 'GET', $data = [])
    {
        $cacheKey = 'api_yachts_' . md5($endpoint . json_encode($data));
        $cacheTTL = 3600; // Cache na 1 hodinu (v sekundách)

        // Zkontrolujeme, jestli data existují v Redis cache
        $apiData = Cache::remember($cacheKey, $cacheTTL, function () use ($endpoint, $method, $data) {
            $baseUrl = config('api.base_url');
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => config('services.api_key_secret')
            ])->timeout(300)->{$method}("{$baseUrl}/{$endpoint}", $data);

            if (!$response->successful()) {
                throw new \Exception('API request failed: ' . $response->status());
            }

            return $response->json();
        });

        $apiData = collect($apiData); // Data from cache nebo API


        // Zavoláme metodu z YachtService pro synchronizaci dat
        try {
            $this->yachtService->updateOrCreateYacht($apiData, $model);
            return view('welcome');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /*
     // working save yachts
    protected function apiRequestSaveYachts($endpoint, $model, $method = 'GET', $data = [])
    {
        $cacheKey = 'api_yachts_' . md5($endpoint . json_encode($data));
        $cacheTTL = 3600; // Cache na 1 hodinu (v sekundách)

        // Zkontrolujeme, jestli data existují v Redis cache
        $apiData = Cache::remember($cacheKey, $cacheTTL, function () use ($endpoint, $method, $data) {
            $baseUrl = config('api.base_url');
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => config('services.api_key_secret')
            ])->timeout(600)->{$method}("{$baseUrl}/{$endpoint}", $data);
            if (!$response->successful()) {
                throw new \Exception('API request failed: ' . $response->status());
            }

            return $response->json();
        });

        $apiData = collect($apiData)->take(10); // Data from cache nebo API
        

        //$apiData = collect($response->json()); // Data from API
        $existingRecords = $model::all()->keyBy('id'); // Existující záznamy podle id
        $updatedCount = 0;
        $createdCount = 0;

        // Synchronizace dat
        foreach ($apiData as $item) {

            // Hledání existujícího záznamu podle id
            $record = $existingRecords->get($item['id']); // 'id' je z API

            if ($record) {
                // If the record exists, update only if values are different
                if (isset($item['allCheckInDays']) && is_array($item['allCheckInDays'])) {
                    $item['allCheckInDays'] = json_encode($item['allCheckInDays']);
                }

                $changed = false;
                foreach ($record->getAttributes() as $key => $value) {
                    if (array_key_exists($key, $item) && $item[$key] !== $value) {
                        $record->$key = $item[$key];
                        $changed = true;
                    }
                }
                
                if ($changed) {
                    $record->save(); // Save the updated record
                    $updatedCount++;
                }
                
                $existingRecords->forget($item['id']); // Remove from existing records
            } else {
                // Create a new record if it doesn't exist
                if (isset($item['allCheckInDays']) && is_array($item['allCheckInDays'])) {
                    $item['allCheckInDays'] = json_encode($item['allCheckInDays']);
                }
                
                $record = $model::create($item); // Create new record
                $createdCount++;
            }

            // Pokud máte nějaké vztahy (např. obrázky, vybavení atd.)
            if (!empty($item['images']) && is_array($item['images'])) {
                foreach ($item['images'] as $image) {
                    if (empty($image['url'])) {
                        continue; // Skip if URL is missing
                    }
            
                    $existingImage = $record->images()->where('url', $image['url'])->first();
            
                    if ($existingImage) {
                        // Check if any value differs
                        $updates = [];
            
                        foreach (['name', 'description', 'sortOrder'] as $field) {
                            if (
                                array_key_exists($field, $image) &&
                                $existingImage->$field !== ($image[$field] ?? null)
                            ) {
                                $updates[$field] = $image[$field] ?? null;
                            }
                        }
            
                        if (!empty($updates)) {
                            $existingImage->update($updates);
                        }
                    } else {
                        // Create new image if not exists
                        $record->images()->create([
                            'yacht_id' => $record->id,
                            'name' => $image['name'] ?? '',
                            'description' => $image['description'] ?? '',
                            'url' => $image['url'],
                            'sortOrder' => $image['sortOrder'] ?? null,
                        ]);
                    }
                }
            }
            
            // Syncing equipment data and storing the id in equipmentId
            if (!empty($item['equipment']) && is_array($item['equipment'])) {
                $uniqueEquipment = array_map("unserialize", array_unique(array_map("serialize", $item['equipment'])));
            
                foreach ($uniqueEquipment as $equipment) {
                    if (empty($equipment['id'])) {
                        continue; // Skip if ID is missing
                    }
            
                    $existingEquipment = $record->equipment()
                        ->where('equipmentId', $equipment['id'])
                        ->first();
            
                    if ($existingEquipment) {
                        // Check if value differs
                        if ($existingEquipment->value !== ($equipment['value'] ?? '')) {
                            $existingEquipment->update([
                                'value' => $equipment['value'] ?? ''
                            ]);
                        }
                    } else {
                        // Create new equipment record if not exists
                        $record->equipment()->create([
                            'yacht_id' => $record->id,
                            'equipmentId' => $equipment['id'],
                            'value' => $equipment['value'] ?? ''
                        ]);
                    }
                }
            }
        

            // Syncing other relationships
            $this->syncOtherRelationships($item, $record);
        }

        // Odstraníme záznamy, které již nejsou v API datech
        $existingRecords->each->delete();

        // Logování
        Log::channel('api_sync_log')->info('ApiSyncLog', [
            'table' => (new $model)->getTable(),
            'updated' => $updatedCount,
            'created' => $createdCount,
            'deleted' => $existingRecords->count()
        ]);

        return response()->json(['message' => 'Data synchronized successfully']);
    }
    */

    protected function apiRequestSaveSingleYacht($model, $endpoint, $yachtId, $method = 'GET', $data = [])
    {
        $baseUrl = config('api.base_url');

        // Dynamická URL s použitím endpointu a yachtId
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => config('services.api_key_secret')
        ])->timeout(600)->{$method}("{$baseUrl}/{$endpoint}/{$yachtId}", $data);

        if (!$response->successful()) {
            return response()->json(['error' => 'API request failed'], $response->status());
        }

        $apiData = $response->json();

        if (!isset($apiData['id'])) {
            return response()->json(['error' => 'Invalid data from API'], 400);
        }

        // Najdeme existující záznam podle id
        $existingRecord = $model::find($apiData['id']);

        if ($existingRecord) {
            // Aktualizace existující jachty
            $existingRecord->update($apiData);
            $updatedCount = 1;
            $createdCount = 0;
        } else {
            // Vytvoření nové jachty

            if (isset($apiData['allCheckInDays']) && is_array($apiData['allCheckInDays'])) {
                $apiData['allCheckInDays'] = json_encode($apiData['allCheckInDays']);
            }
            $existingRecord = $model::create($apiData);
            $updatedCount = 0;
            $createdCount = 1;
        }

        // Synchronizace obrázků
        if (isset($apiData['images']) && is_array($apiData['images'])) {
            foreach ($apiData['images'] as $image) {
                if (!isset($image['url'])) {
                    continue; // Přeskočíme, pokud chybí URL obrázku
                }

                $existingImage = $existingRecord->images()
                    ->where('url', $image['url'])
                    ->first();

                if ($existingImage) {
                    // Pokud existuje, aktualizujeme jen pokud se liší
                    if (
                        $existingImage->name !== ($image['name'] ?? '') ||
                        $existingImage->description !== ($image['description'] ?? '') ||
                        $existingImage->sortOrder !== ($image['sortOrder'] ?? null)
                    ) {
                        $existingImage->update([
                            'name' => $image['name'] ?? '',
                            'description' => $image['description'] ?? '',
                            'sortOrder' => $image['sortOrder'] ?? null,
                        ]);
                    }
                } else {
                    // Pokud neexistuje, vytvoříme nový záznam
                    $existingRecord->images()->create([
                        'yacht_id' => $existingRecord->id,
                        'name' => $image['name'] ?? '',
                        'description' => $image['description'] ?? '',
                        'url' => $image['url'],
                        'sortOrder' => $image['sortOrder'] ?? null,
                    ]);
                }
            }
        }


        // Synchronizace vybavení
        if (isset($apiData['equipment']) && is_array($apiData['equipment'])) {
            $uniqueEquipment = array_map("unserialize", array_unique(array_map("serialize", $apiData['equipment'])));

            foreach ($uniqueEquipment as $equipment) {
                if (!isset($equipment['id'])) {
                    continue; // Přeskočíme, pokud chybí ID
                }

                $existingEquipment = $existingRecord->equipment()
                    ->where('equipmentId', $equipment['id'])
                    ->first();

                if ($existingEquipment) {
                    // Pokud existuje, aktualizujeme jen pokud se liší hodnota
                    if ($existingEquipment->value !== ($equipment['value'] ?? '')) {
                        $existingEquipment->update([
                            'value' => $equipment['value'] ?? ''
                        ]);
                    }
                } else {
                    // Pokud neexistuje, vytvoříme nový záznam
                    $existingRecord->equipment()->create([
                        'yacht_id' => $existingRecord->id,
                        'equipmentId' => $equipment['id'],
                        'value' => $equipment['value'] ?? ''
                    ]);
                }
            }
        }



        // Další synchronizace vztahů
        $this->syncOtherRelationships($apiData, $existingRecord);

        // Logování
        Log::channel('api_sync_log')->info('ApiSyncLog', [
            'table' => (new $model)->getTable(),
            'updated' => $updatedCount,
            'created' => $createdCount,
            'deleted' => 0 // Pro jednu jachtu není potřeba mazat
        ]);

        return response()->json(['message' => 'Single yacht synchronized successfully']);
    }

    protected function syncOtherRelationships($item, $record)
    {
        if (isset($item['products']) && is_array($item['products']) && count($item['products']) > 0) {
            if ($record) {
                foreach ($item['products'] as $product) {
                    $existingProduct = $record->products()
                        ->where('name', $product['name'])
                        ->first();

                    if ($existingProduct) {
                        // Aktualizujeme pouze pokud se data změnila
                        if (
                            $existingProduct->crewedByDefault !== ($product['crewedByDefault'] ?? false) ||
                            $existingProduct->isDefaultProduct !== ($product['isDefaultProduct'] ?? false)
                        ) {
                            $existingProduct->update([
                                'crewedByDefault' => $product['crewedByDefault'] ?? false,
                                'isDefaultProduct' => $product['isDefaultProduct'] ?? false,
                            ]);
                        }
                    } else {
                        // Pokud produkt neexistuje, vytvoříme nový záznam
                        $record->products()->create([
                            'yacht_id' => $record->id,
                            'name' => $product['name'],
                            'crewedByDefault' => $product['crewedByDefault'] ?? false,
                            'isDefaultProduct' => $product['isDefaultProduct'] ?? false,
                        ]);

                        if (isset($product['extras']) && is_array($product['extras']) && count($product['extras']) > 0) {
                            // Loop through each extra for this product
                            foreach ($product['extras'] as $extra) {
                                // Check if the extra already exists in the database for this yacht
                                if (empty($extra['id']) || empty($record->id)) {
                                    continue;  // Skip this extra if critical data is missing
                                }

                                $existingExtra = YachtExtra::where('id', $extra['id'])
                                    ->where('yacht_id', $record->id)  // Ensure the yacht_id matches
                                    ->first();

                                if ($existingExtra) {
                                    // If the extra exists, update it
                                    try {
                                        $existingExtra->update([
                                            'name' => $extra['name'],
                                            'price' => $extra['price'],
                                            'currency' => $extra['currency'],
                                            'unit' => $extra['unit'],
                                            'payableInBase' => $extra['payableInBase'],
                                            'obligatory' => $extra['obligatory'],
                                            'includesDepositWaiver' => $extra['includesDepositWaiver'],
                                            'validDaysFrom' => $extra['validDaysFrom'],
                                            'validDaysTo' => $extra['validDaysTo'],
                                            'sailingDateFrom' => $extra['sailingDateFrom'],
                                            'sailingDateTo' => $extra['sailingDateTo'],
                                            'validDateFrom' => $extra['validDateFrom'],
                                            'validDateTo' => $extra['validDateTo'],
                                            'description' => $extra['description'],
                                            'availableInBase' => $extra['availableInBase'] === -1 ? 0 : $extra['availableInBase'],
                                            'validSailingAreas' => json_encode($extra['validSailingAreas']), // Assuming this is the correct structure
                                        ]);
                                    } catch (\Illuminate\Database\QueryException $e) {
                                        Log::error('Query Exception: ' . $e->getMessage(), [
                                            'sql' => $e->getSql(),
                                            'bindings' => $e->getBindings(),
                                            'trace' => $e->getTraceAsString(),
                                        ]);
                                    }
                                } else {
                                    // If the extra doesn't exist, create a new one
                                    YachtExtra::create([
                                        'id' => $extra['id'] === -1 ? 0 : $extra['id'],  // Make sure the ID is provided (or handled)
                                        'yacht_id' => $record->id,  // Associate with the correct yacht
                                        'name' => $extra['name'],
                                        'price' => $extra['price'],
                                        'currency' => $extra['currency'],
                                        'unit' => $extra['unit'],
                                        'payableInBase' => $extra['payableInBase'],
                                        'obligatory' => $extra['obligatory'],
                                        'includesDepositWaiver' => $extra['includesDepositWaiver'],
                                        'validDaysFrom' => $extra['validDaysFrom'],
                                        'validDaysTo' => $extra['validDaysTo'],
                                        'sailingDateFrom' => $extra['sailingDateFrom'],
                                        'sailingDateTo' => $extra['sailingDateTo'],
                                        'validDateFrom' => $extra['validDateFrom'],
                                        'validDateTo' => $extra['validDateTo'],
                                        'description' => $extra['description'],
                                        'availableInBase' => $extra['availableInBase'] === -1 ? 0 : $extra['availableInBase'],
                                        'validSailingAreas' => json_encode($extra['validSailingAreas']), // Assuming this is the correct structure
                                    ]);
                                }
                            }
                        } else {
                            Log::warning("No extras found for product: " . json_encode($product['name']));
                        }
                    }
                }
            } else {
                Log::error("Record with ID {$item['id']} not found in the database for products sync.");
            }
        } else {
            Log::error("No products found in the input data.");
        }

        if (isset($item['descriptions']) && is_array($item['descriptions'])) {
            foreach ($item['descriptions'] as $description) {
                if (!isset($description['category'])) {
                    continue; // Přeskočíme, pokud chybí kategorie
                }

                $existingDescription = $record->descriptions()
                    ->where('category', $description['category'])
                    ->first();

                if ($existingDescription) {
                    // Pokud existuje, aktualizujeme jen pokud se liší
                    if (
                        $existingDescription->text !== ($description['text'] ?? '') ||
                        $existingDescription->documents !== json_encode($description['documents'] ?? [])
                    ) {
                        $existingDescription->update([
                            'text' => $description['text'] ?? '',
                            'documents' => json_encode($description['documents'] ?? [])
                        ]);
                    }
                } else {
                    // Pokud neexistuje, vytvoříme nový záznam
                    $record->descriptions()->create([
                        'yacht_id' => $record->id,
                        'category' => $description['category'],
                        'text' => $description['text'] ?? '',
                        'documents' => json_encode($description['documents'] ?? [])
                    ]);
                }
            }
        }


        if (isset($item['crew']) && is_array($item['crew'])) {
            foreach ($item['crew'] as $crewMember) {
                if (!isset($crewMember['name'])) {
                    continue; // Skip if there's no ID to identify the record
                }

                // Find existing crew member by ID and yacht_id
                $existingCrewMember = $record->crew()
                    ->where('name', $crewMember['name'])
                    ->where('yacht_id', $record->id)
                    ->first();

                // Prepare the data, encoding arrays as JSON
                $crewData = [
                    'name' => $crewMember['name'] ?? '',
                    'description' => $crewMember['description'] ?? '',
                    'age' => $crewMember['age'] ?? null,
                    'nationality' => $crewMember['nationality'] ?? '',
                    'roles' => isset($crewMember['roles']) ? json_encode($crewMember['roles']) : '[]',
                    'licenses' => isset($crewMember['licenses']) ? json_encode($crewMember['licenses']) : '[]',
                    'languages' => isset($crewMember['languages']) ? json_encode($crewMember['languages']) : '[]',
                    'images' => isset($crewMember['images']) ? json_encode($crewMember['images']) : '[]',
                ];

                if ($existingCrewMember) {
                    // Update only if data has changed
                    if (
                        $existingCrewMember->name !== $crewData['name'] ||
                        $existingCrewMember->description !== $crewData['description'] ||
                        $existingCrewMember->age !== $crewData['age'] ||
                        $existingCrewMember->nationality !== $crewData['nationality'] ||
                        $existingCrewMember->roles !== $crewData['roles'] ||
                        $existingCrewMember->licenses !== $crewData['licenses'] ||
                        $existingCrewMember->languages !== $crewData['languages'] ||
                        $existingCrewMember->images !== $crewData['images']
                    ) {
                        $existingCrewMember->update($crewData);
                    }
                } else {
                    // Create new record if not found
                    $record->crew()->create(array_merge($crewData, [
                        'name' => $crewMember['name'],
                        'yacht_id' => $record->id
                    ]));
                }
            }
        }
    }

    public function getCountries()
    {
        return $this->apiRequestSave('countries', Country::class);
    }

    public function getCountry($id)
    {
        return $this->apiRequestSave("country/{$id}", Country::class);
    }

    public function getWorldRegions()
    {
        return $this->apiRequestSave('worldRegions', WorldRegion::class);
    }

    public function getWorldRegion($id)
    {
        return $this->apiRequestSave("worldRegion/{$id}", WorldRegion::class);
    }

    public function getSailingAreas()
    {
        return $this->apiRequestSave('sailingAreas', SailingArea::class);
    }

    public function getSailingArea($id)
    {
        return $this->apiRequestSave("sailingArea/{$id}", SailingArea::class);
    }

    public function getBases()
    {
        return $this->apiRequestSave('bases', Base::class);
    }

    public function getBase($id)
    {
        return $this->apiRequestSave("bases/{$id}", Base::class);
    }

    public function getEquipment()
    {
        return $this->apiRequestSave('equipment', Equipment::class);
    }

    public function getCompanies()
    {
        return $this->apiRequestSave('companies', Company::class);
    }

    public function getCompany($id)
    {
        return $this->apiRequestSave("company/{$id}", Company::class);
    }

    public function getShipyards()
    {
        return $this->apiRequestSave('shipyards', Shipyard::class);
    }

    public function getShipyard($id)
    {
        return $this->apiRequestSave("shipyard/{$id}", Shipyard::class);
    }

    public function getYachts()
    {
        return $this->apiRequestSaveYachts('yachts?language=cs', Yacht::class);
    }

    public function getYacht($id)
    {
        return $this->apiRequestSaveSingleYacht(Yacht::class, 'yacht?language=cs', $id);
    }

    public function getYachtTypes()
    {
        return $this->apiRequestSave('yachtTypes', YachtType::class);
    }

    public function getYachtImages()
    {
        return $this->apiRequestSave('yachtImages', YachtImage::class);
    }

    public function getYachtLicenses()
    {
        return $this->apiRequestSave('yachtLicenses', YachtLicense::class);
    }

    public function getYachtCrew()
    {
        return $this->apiRequestSave('yachtCrew', YachtCrew::class);
    }

    public function getYachtProducts()
    {
        return $this->apiRequestSave('yachtProducts', YachtProduct::class);
    }

    public function getYachtDescriptions()
    {
        return $this->apiRequestSave('yachtDescriptions', YachtDescription::class);
    }

    public function getYachtEquipment()
    {
        return $this->apiRequestSave('yachtEquipment', YachtEquipment::class);
    }

    public function getYachtExtras()
    {
        return $this->apiRequestSave('yachtExtras', YachtExtra::class);
    }

    public function getOffers()
    {
        return $this->apiRequest('offers');
    }

    public function getSpecialOffers()
    {
        //return $this->apiRequestSave('specialOffers', SpecialOffer::class);
    }

    public function getSpecialOffersByType($offerType)
    {
        //return $this->apiRequestSave("specialOffers/{$offerType}", SpecialOffer::class);
    }

    public function getPrices(Request $request)
    {
        // Collect the necessary data from the request (query parameters)
        $data = $request->only([
            'dateFrom',
            'dateTo',
            'companyId',
            'country',
            'productName',
            'yachtId',
            'currency',
            'tripDuration'
        ]);

        return $this->apiRequest('prices', 'GET', $data);
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
