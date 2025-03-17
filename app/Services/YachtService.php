<?php

namespace App\Services;

use App\Models\Api\Yacht;
use App\Models\Api\YachtCrew;
use App\Models\Api\YachtDescription;
use App\Models\Api\YachtEquipment;
use App\Models\Api\YachtExtra;
use App\Models\Api\YachtImage;
use App\Models\Api\YachtProduct;
use Illuminate\Support\Facades\Log;

class YachtService
{ 
    protected $updatedYachts = 0;
    protected $updatedImages = 0;
    protected $updatedCrews = 0;
    protected $updatedProducts = 0;
    protected $updatedExtras = 0;
    protected $updatedEquipments = 0;
    protected $updatedDescriptions = 0;

    // Variables to track creations
    protected $createdYachts = 0;
    protected $createdImages = 0;
    protected $createdCrews = 0;
    protected $createdProducts = 0;
    protected $createdExtras = 0;
    protected $createdEquipments = 0;
    protected $createdDescriptions = 0;

    // Constructor to initialize all the variables
    public function __construct()
    {
        // Initialize to 0 if necessary
        $this->resetCounters();
    }

    // Function to reset all counters to 0
    protected function resetCounters()
    {
        $this->updatedYachts = 0;
        $this->updatedImages = 0;
        $this->updatedCrews = 0;
        $this->updatedProducts = 0;
        $this->updatedExtras = 0;
        $this->updatedEquipments = 0;
        $this->updatedDescriptions = 0;

        $this->createdYachts = 0;
        $this->createdImages = 0;
        $this->createdCrews = 0;
        $this->createdProducts = 0;
        $this->createdExtras = 0;
        $this->createdEquipments = 0;
        $this->createdDescriptions = 0;
    }

    public function updateOrCreateYacht($apiData, $model)
    {
        $existingYachts = Yacht::whereIn('id', collect($apiData)->pluck('id'))->get()->keyBy('id');
        $existingImages = YachtImage::whereIn('yacht_id', collect($apiData)->pluck('id'))->get()->groupBy('yacht_id');
        $allProducts = YachtProduct::whereIn('yacht_id', collect($apiData)->pluck('id'))->get()->groupBy('yacht_id');
        $allExtras = YachtExtra::whereIn('yacht_id', collect($apiData)->pluck('id'))->get()->groupBy('yacht_id');
        $allEquipments = YachtEquipment::whereIn('yacht_id', collect($apiData)->pluck('id'))->get()->groupBy('yacht_id');
        $allDescriptions = YachtDescription::whereIn('yacht_id', collect($apiData)->pluck('id'))->get()->groupBy('yacht_id');
        $allCrews = YachtCrew::whereIn('yacht_id', collect($apiData)->pluck('id'))->get()->groupBy('yacht_id');


        $totalTimeImages = 0;
        $totalTimeProducts = 0;
        $totalTimeEquipment = 0;
        $totalTimeDescriptions = 0;
        $totalTimeCrew = 0;
        $totalTimeUpdateCreateYacht = 0;

        foreach ($apiData as $item) {
            // Time to update or create yacht
            $startTime = microtime(true);
            $record = $existingYachts->get($item['id']);
            if ($record) {
                $this->updateYacht($record, $item);
            } else {
                $record = $this->createYacht($item, $model);
            }
            $elapsedTime = microtime(true) - $startTime;
            $totalTimeUpdateCreateYacht += $elapsedTime;


            // Time to handle images
            $startTime = microtime(true);
            if(!empty($item['images'])){
                $this->handleImages($item, $record, $existingImages);
            }
            $elapsedTime = microtime(true) - $startTime;
            $totalTimeImages += $elapsedTime;

            // Time to handle products
            $startTime = microtime(true);
            if(!empty($item['products'])){
                $this->handleProducts($record, $item['products'] ?? [], $allProducts, $allExtras);
            }
            $elapsedTime = microtime(true) - $startTime;
            $totalTimeProducts += $elapsedTime;

            // Time to handle equipment
            $startTime = microtime(true);
            if(!empty($item['equipment'])){
                $this->handleEquipment($record, $item['equipment'], $allEquipments);
            }
            $elapsedTime = microtime(true) - $startTime;
            $totalTimeEquipment += $elapsedTime;

            // Time to handle descriptions
            $startTime = microtime(true);
            if($item['descriptions']){
                $this->handleDescriptions($record, $item['descriptions'] ?? [], $allDescriptions);
            }
            $elapsedTime = microtime(true) - $startTime;
            $totalTimeDescriptions += $elapsedTime;

            // Time to handle crew
            $startTime = microtime(true);
            if($item['crew']){
                $this->handleCrew($record, $item['crew'] ?? [], $allCrews);
            }
            $elapsedTime = microtime(true) - $startTime;
            $totalTimeCrew += $elapsedTime;
        }
        // Log updated variables
        if(config('app.debug') == true){
            $this->logChanges();

            Log::channel('api_sync_log')->info('Total Time for all iterations (Update/Create Yacht): ' . number_format($totalTimeUpdateCreateYacht, 4) . ' seconds');
            Log::channel('api_sync_log')->info('Total Time for all iterations (Images): ' . number_format($totalTimeImages, 4) . ' seconds');
            Log::channel('api_sync_log')->info('Total Time for all iterations (Products): ' . number_format($totalTimeProducts, 4) . ' seconds');
            Log::channel('api_sync_log')->info('Total Time for all iterations (Equipment): ' . number_format($totalTimeEquipment, 4) . ' seconds');
            Log::channel('api_sync_log')->info('Total Time for all iterations (Descriptions): ' . number_format($totalTimeDescriptions, 4) . ' seconds');
            Log::channel('api_sync_log')->info('Total Time for all iterations (Crew): ' . number_format($totalTimeCrew, 4) . ' seconds');
        }
    }

    // Update existing yacht record
    private function updateYacht($record, $item)
    {
        // Convert 'allCheckInDays' to JSON if it's an array
        if (isset($item['allCheckInDays']) && is_array($item['allCheckInDays'])) {
            $item['allCheckInDays'] = json_encode($item['allCheckInDays']);
        }

        $changed = false;

        // Compare each attribute to check if any value has changed
        foreach ($record->getAttributes() as $key => $value) {
            if (array_key_exists($key, $item)) {
                // Check if the value is a JSON string and compare as arrays
                $decodedValue = json_decode($value, true);
                $decodedItemValue = json_decode($item[$key], true);

                // Fallback to regular comparison if not JSON
                $actualValue = $decodedValue ?? $value;
                $actualItemValue = $decodedItemValue ?? $item[$key];

                if ($actualValue !== $actualItemValue) {
                    $record->$key = $item[$key];
                    $changed = true;
                }
            }
        }

        // If any value has changed, save the updated record
        if ($changed) {
            $record->save(); // Save the updated record
            $this->updatedYachts++;
        }
    }

    // Create new yacht record
    private function createYacht($item, $model)
    {
        // Convert 'allCheckInDays' to JSON if it's an array
        if (isset($item['allCheckInDays']) && is_array($item['allCheckInDays'])) {
            $item['allCheckInDays'] = json_encode($item['allCheckInDays']);
        }

        // Create new record
        $record = $model::create($item);
        $this->createdYachts++;
        return $record;
    }

    private function handleImages($item, $record, $existingImages)
    {
        if (!empty($item['images']) && is_array($item['images'])) {
            // Get existing images for this yacht from pre-loaded data (grouped by yacht_id)
            $existingImagesForYacht = $existingImages->get($record->id, collect());
    
            // Transform the existing images into an associative array based on the 'url' for fast lookup
            $existingImagesForYacht = $existingImagesForYacht->keyBy('url');
    
            // Arrays to collect updates and new images
            $updates = [];
            $creates = [];
    
            foreach ($item['images'] as $image) {
                if (empty($image['url'])) {
                    continue; // Skip if URL is missing
                }
    
                // Check if the image already exists in the pre-loaded data based on URL
                $existingImage = $existingImagesForYacht->get($image['url']);
    
                if ($existingImage) {
                    // If the image exists, check if any fields need to be updated
                    $updateFields = false;
    
                    foreach (['name', 'description', 'sortOrder'] as $field) {
                        if (array_key_exists($field, $image) && $existingImage->$field !== ($image[$field] ?? null)) {
                            // If the value differs, update the field
                            $existingImage->$field = $image[$field] ?? null;
                            $updateFields = true;
                        }
                    }
    
                    // If there are any changes, add it to the updates list
                    if ($updateFields) {
                        $updates[] = $existingImage;
                    }
                } else {
                    // If the image doesn't exist, prepare it for creation
                    $creates[] = [
                        'yacht_id' => $record->id,
                        'name' => $image['name'] ?? '',
                        'description' => $image['description'] ?? '',
                        'url' => $image['url'],
                        'sortOrder' => $image['sortOrder'] ?? null,
                    ];
                }
            }
    
            // After processing the loop, perform all updates in bulk
            if (!empty($updates)) {
                foreach ($updates as $update) {
                    $update->save(); // Save each updated image at once
                    $this->updatedImages++;
                }
            }
    
            // If there are new images, insert them in bulk
            if (!empty($creates)) {
                try {
                    // Bulk insert the new images
                    YachtImage::insert($creates);
                    $this->createdImages += count($creates);
                } catch (\Illuminate\Database\QueryException $e) {
                    // Log any error during insertion
                    Log::error('Query Exception: ' . $e->getMessage());
                }
            }
        }
    }
    
    public function handleProducts($record, $products, $allProducts, $allExtras)
    {
        if (isset($products) && is_array($products) && count($products) > 0) {
            foreach ($products as $product) {
                // Get the products for the current yacht ID (ensure it's a collection)
                $existingProductYacht = $allProducts->get($record->id);

                // If no products exist for the given yacht_id, we skip this iteration
                if ($existingProductYacht) {
                    // Now, filter by the product name
                    $existingProduct = $existingProductYacht->where('name', $product['name'])->first();

                    if ($existingProduct) {
                        // Update only if data has changed
                        if (
                            $existingProduct->name !== ($product['name'] ?? '') ||
                            (bool)$existingProduct->crewedByDefault !== (bool)($product['crewedByDefault'] ?? false) ||
                            (bool)$existingProduct->isDefaultProduct !== (bool)($product['isDefaultProduct'] ?? false)
                        ) {
                            // If the values differ, update the product
                            $existingProduct->update([
                                'name' => $product['name'],
                                'crewedByDefault' => (bool)($product['crewedByDefault'] ?? false),
                                'isDefaultProduct' => (bool)($product['isDefaultProduct'] ?? false),
                            ]);
                            $this->updatedProducts++;
                        }
                    }
                } else {
                    // If the product does not exist in $existingProductYacht, create a new one
                    $record->products()->create([
                        'yacht_id' => $record->id,
                        'name' => $product['name'],
                        'crewedByDefault' => (bool)($product['crewedByDefault'] ?? false),
                        'isDefaultProduct' => (bool)($product['isDefaultProduct'] ?? false),
                    ]);
                    $this->createdProducts++;
                }

                // Handle the extras for this product
                $this->handleProductExtras($record, $product, $allExtras);
            }
        } else {
            Log::error("No products found in the input data.");
        }
    }

    public function handleProductExtras($record, $product, $allExtras)
    {
        if (isset($product['extras']) && is_array($product['extras']) && count($product['extras']) > 0) {
            // Collect existing extras for this yacht_id from the pre-loaded data
            $existingExtrasForYacht = $allExtras->get($record->id) ?? collect();
            // Arrays to collect updates and new extras
            $updates = [];
            $creates = [];
    
            foreach ($product['extras'] as $extra) {
                if ($extra['availableInBase'] === -1) {
                    $extra['availableInBase'] = 0;
                }
                if ($extra['id'] === -1) {
                    $extra['id'] = 0;
                }
    
                if (empty($extra['id']) || empty($record->id)) {
                    continue;  // Skip this extra if critical data is missing
                }
    
                // Check if the extra already exists in the existing data
                $existingExtra = $existingExtrasForYacht
                    ->where('id', $extra['id'])
                    ->where('unit', $extra['unit'])
                    ->first();
    
                if ($existingExtra) {
                    // Compare values and prepare updates if they differ
                    $updateFields = [];
    
                    foreach (
                        [
                            'name',
                            'price',
                            'currency',
                            'unit',
                            'payableInBase',
                            'obligatory',
                            'includesDepositWaiver',
                            'validDaysFrom',
                            'validDaysTo',
                            'sailingDateFrom',
                            'sailingDateTo',
                            'validDateFrom',
                            'validDateTo',
                            'description',
                            'availableInBase',
                            'validSailingAreas'
                        ] as $field
                    ) {
                        if (array_key_exists($field, $extra)) {
                            // Special handling for date fields (Carbon objects)
                            if (in_array($field, ['validDateFrom', 'validDateTo', 'sailingDateFrom', 'sailingDateTo'])) {
                                $existingValue = $existingExtra->$field instanceof \Carbon\Carbon
                                    ? $existingExtra->$field->toDateTimeString()
                                    : (string)$existingExtra->$field;
    
                                $newValue = $extra[$field] instanceof \Carbon\Carbon
                                    ? $extra[$field]->toDateTimeString()
                                    : (string)$extra[$field];
    
                                if ($existingValue !== $newValue) {
                                    $updateFields[$field] = $newValue;
                                }
                            } elseif ($field === 'validSailingAreas') {
                                // Decode the existing value into an array
                                $existingValueArray = json_decode($existingExtra->$field, true);
    
                                $newValueArray = is_array($extra[$field])
                                    ? $extra[$field]
                                    : json_decode($extra[$field], true);
    
                                if ($existingValueArray !== $newValueArray) {
                                    $updateFields[$field] = json_encode($newValueArray);
                                }
                            } elseif ($field === 'price') {
                                // Handle price formatting (ensure consistent formatting)
                                $newValue = number_format($extra[$field], 2, '.', '');
                                if ($existingExtra->$field !== $newValue) {
                                    $updateFields[$field] = $newValue;
                                }
                            } else {
                                // For all other fields
                                $newValue = $extra[$field];
                                if ($existingExtra->$field !== $newValue) {
                                    $updateFields[$field] = $newValue;
                                }
                            }
                        }
                    }
    
                    // If there are any changes, add to the updates list
                    if (!empty($updateFields)) {
                        $updates[] = [
                            'id' => $extra['id'],
                            'yacht_id' => $record->id ?? null,
                            'name' => $extra['name'] ?? '',
                            'price' => $extra['price'] ?? '0.00',
                            'currency' => $extra['currency'] ?? 'EUR',
                            'unit' => $extra['unit'] ?? '',
                            'payableInBase' => $extra['payableInBase'] ?? 0,
                            'obligatory' => $extra['obligatory'] ?? 0,
                            'includesDepositWaiver' => $extra['includesDepositWaiver'] ?? 0,
                            'validDaysFrom' => $extra['validDaysFrom'] ?? 0,
                            'validDaysTo' => $extra['validDaysTo'] ?? 365,
                            'sailingDateFrom' => $extra['sailingDateFrom'] ?? '1970-01-01 00:00:00',
                            'sailingDateTo' => $extra['sailingDateTo'] ?? '2129-05-02 23:59:59',
                            'validDateFrom' => $extra['validDateFrom'] ?? '1970-01-01 00:00:00',
                            'validDateTo' => $extra['validDateTo'] ?? '2129-05-02 00:00:00',
                            'description' => $extra['description'] ?? '',
                            'availableInBase' => $extra['availableInBase'] ?? 0,
                            'validSailingAreas' => json_encode($extra['validSailingAreas'] ?? []),
                        ];
                    }
                } else {
                    // If the extra does not exist, add it to the creation list
                    $creates[] = [
                        'id' => $extra['id'] === -1 ? 0 : $extra['id'],
                        'yacht_id' => $record->id,
                        'name' => $extra['name'] ?? '',
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
                        'validSailingAreas' => json_encode($extra['validSailingAreas']),
                    ];
                }
            }
    
            // Perform batch updates if there are any
            if (!empty($updates)) {
                try {
                    foreach ($updates as $update) {
                        YachtExtra::where('id', $update['id'])
                            ->where('unit', $update['unit'])
                            ->update($update);
                    }
            
                    $this->updatedExtras += count($updates);
                } catch (\Illuminate\Database\QueryException $e) {
                    // Log any error during the update
                    Log::error('Query Exception during update: ' . $e->getMessage());
                }
            }
    
            // Perform bulk insert for new extras if there are any
            if (!empty($creates)) {
                try {
                    // Bulk insert the new extras
                    YachtExtra::insert($creates);
                    $this->createdExtras += count($creates);
                } catch (\Illuminate\Database\QueryException $e) {
                    // Log any error during insertion
                    Log::error('Query Exception: ' . $e->getMessage());
                }
            }
        }
    }

    private function handleEquipment($record, $apiEquipments, $allEquipments)
    {
        if (empty($apiEquipments) || !is_array($apiEquipments)) {
            return;
        }
    
        // Get the existing equipment for the current yacht from allEquipments (grouped by yacht_id)
        $existingEquipments = $allEquipments->get($record->id);

        // Loop through each unique equipment item
        foreach ($apiEquipments as $equipment) {

            if (empty($equipment['id'])) {
                continue; // Skip if equipment ID is empty
            }
    
            // Ensure 'value' is set
            
            // Try to find the existing equipment by equipmentId
            if(!empty($existingEquipments)){
                if(isset($equipment['id']) && isset($record->id)){
                    $existingEquipment = $existingEquipments->where('equipmentId', $equipment['id'])
                    ->where('yacht_id', $record->id)
                    ->first();
                }else{
                    $existingEquipment = false;
                }
            }else{
                $existingEquipment = false;
            }

            if (!isset($equipment['value'])) {
                $equipment['value'] = ''; // Default to empty string if 'value' is not set
            }
            

            if ($existingEquipment) {
                // If the equipment exists, check if the value has changed
                if ($existingEquipment->value != $equipment['value']) {

                    $existingEquipment->update([
                        'value' => $equipment['value']
                    ]);

                    $this->updatedEquipments++; // Increment the updated count
                }
            } else {
                // If the equipment doesn't exist for the yacht, create a new record
                $record->equipment()->create([
                    'yacht_id' => $record->id,
                    'equipmentId' => $equipment['id'],
                    'value' => $equipment['value']
                ]);
                $this->createdEquipments++; // Increment the created count
            }
        }
    }
    
    
    public function handleDescriptions($record, $descriptions, $allDescriptions)
    {
        if (empty($descriptions) || !is_array($descriptions)) {
            return;
        }
    
        // Get existing descriptions for the yacht, keyed by category for fast lookup
        $existingDescriptions = $allDescriptions->get($record->id, collect())->keyBy('category');
    
        // Arrays for collecting updates and new descriptions
        $updates = [];
        $creates = [];
    
        foreach ($descriptions as $description) {
            if (empty($description['category'])) {
                continue;  // Skip if category is missing
            }
    
            $category = $description['category'];
            $descriptionData = [
                'text' => $description['text'] ?? '',
                'documents' => json_encode($description['documents'] ?? [])
            ];
    
            $existingDescription = $existingDescriptions->get($category);
    
            if ($existingDescription) {
                // Check if the existing description needs an update
                if (
                    $existingDescription->text !== $descriptionData['text'] ||
                    $existingDescription->documents !== $descriptionData['documents']
                ) {
                    // If there are changes, add to the updates array
                    $updates[] = [
                        'id' => $existingDescription->id,
                        'text' => $descriptionData['text'],
                        'documents' => $descriptionData['documents'],
                    ];
                }
            } else {
                // If the description does not exist, prepare for batch insertion
                $creates[] = array_merge([
                    'yacht_id' => $record->id,
                    'category' => $category,
                ], $descriptionData);
            }
        }
    
        // Perform batch updates if there are any
        if (!empty($updates)) {
            foreach ($updates as $update) {
                try {
                    // Update existing descriptions
                    YachtDescription::where('id', $update['id'])->update([
                        'text' => $update['text'],
                        'documents' => $update['documents'],
                    ]);
                    $this->updatedDescriptions++;
                } catch (\Illuminate\Database\QueryException $e) {
                    Log::error('Failed to update description: ' . $e->getMessage());
                }
            }
        }
    
        // Perform batch inserts if there are any new descriptions
        if (!empty($creates)) {
            try {
                // Bulk insert new descriptions
                YachtDescription::insert($creates);
                $this->createdDescriptions += count($creates);
            } catch (\Illuminate\Database\QueryException $e) {
                Log::error('Failed to insert description: ' . $e->getMessage());
            }
        }
    }

    public function handleCrew($record, $crew, $allCrews)
    {
        if (!isset($crew) || !is_array($crew)) {
            return;
        }

        foreach ($crew as $crewMember) {
            $this->updateCrew($record, $crewMember, $allCrews);
        }
    }

    private function updateCrew($record, $crewMember, $allCrews)
    {
        if (!isset($crewMember['name'])) {
            return;
        }

        // Find the crew member in allCrews by yacht_id and name
        $existingCrewMember = $allCrews->get($record->id) ? $allCrews->get($record->id)->where('name', $crewMember['name'])->first() : null;

        $crewData = [
            'name' => $crewMember['name'],
            'description' => $crewMember['description'] ?? '',
            'age' => $crewMember['age'] ?? null,
            'nationality' => $crewMember['nationality'] ?? '',
            'roles' => isset($crewMember['roles']) ? json_encode($crewMember['roles']) : '[]',
            'licenses' => isset($crewMember['licenses']) ? json_encode($crewMember['licenses']) : '[]',
            'languages' => isset($crewMember['languages']) ? json_encode($crewMember['languages']) : '[]',
            'images' => isset($crewMember['images']) ? json_encode($crewMember['images']) : '[]',
        ];

        if ($existingCrewMember) {
            // If crew member exists in $allCrews, compare the data
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
                // Update the existing crew member's details in $allCrews
                $existingCrewMember->update($crewData);
                $this->updatedCrews++;
            }
        } else {
            // If the crew member doesn't exist, create a new one
            $record->crew()->create(array_merge($crewData, [
                'name' => $crewMember['name'],
                'yacht_id' => $record->id,
            ]));
            $this->createdCrews++;
        }
    }

    private function logChanges()
    {
        $isLogged = false; // Flag to track if any log was created

        if ($this->updatedYachts != 0) {
            Log::channel('api_sync_log')->info('Updated Yachts: ', ['updatedYachts' => $this->updatedYachts]);
            $isLogged = true;
        }

        if ($this->updatedImages != 0) {
            Log::channel('api_sync_log')->info('Updated Images: ', ['updatedImages' => $this->updatedImages]);
            $isLogged = true;
        }

        if ($this->updatedCrews != 0) {
            Log::channel('api_sync_log')->info('Updated Crews: ', ['updatedCrews' => $this->updatedCrews]);
            $isLogged = true;
        }

        if ($this->updatedProducts != 0) {
            Log::channel('api_sync_log')->info('Updated Products: ', ['updatedProducts' => $this->updatedProducts]);
            $isLogged = true;
        }

        if ($this->updatedExtras != 0) {
            Log::channel('api_sync_log')->info('Updated Extras: ', ['updatedExtras' => $this->updatedExtras]);
            $isLogged = true;
        }

        if ($this->updatedEquipments != 0) {
            Log::channel('api_sync_log')->info('Updated Equipments: ', ['updatedEquipments' => $this->updatedEquipments]);
            $isLogged = true;
        }

        if ($this->updatedDescriptions != 0) {
            Log::channel('api_sync_log')->info('Updated Descriptions: ', ['updatedDescriptions' => $this->updatedDescriptions]);
            $isLogged = true;
        }

        // Log created variables
        if ($this->createdYachts != 0) {
            Log::channel('api_sync_log')->info('Created Yachts: ', ['createdYachts' => $this->createdYachts]);
            $isLogged = true;
        }

        if ($this->createdImages != 0) {
            Log::channel('api_sync_log')->info('Created Images: ', ['createdImages' => $this->createdImages]);
            $isLogged = true;
        }

        if ($this->createdCrews != 0) {
            Log::channel('api_sync_log')->info('Created Crews: ', ['createdCrews' => $this->createdCrews]);
            $isLogged = true;
        }

        if ($this->createdProducts != 0) {
            Log::channel('api_sync_log')->info('Created Products: ', ['createdProducts' => $this->createdProducts]);
            $isLogged = true;
        }

        if ($this->createdExtras != 0) {
            Log::channel('api_sync_log')->info('Created Extras: ', ['createdExtras' => $this->createdExtras]);
            $isLogged = true;
        }

        if ($this->createdEquipments != 0) {
            Log::channel('api_sync_log')->info('Created Equipments: ', ['createdEquipments' => $this->createdEquipments]);
            $isLogged = true;
        }

        if ($this->createdDescriptions != 0) {
            Log::channel('api_sync_log')->info('Created Descriptions: ', ['createdDescriptions' => $this->createdDescriptions]);
            $isLogged = true;
        }

        // If no log was created, log that the db is already synced with the API
        if (!$isLogged) {
            Log::channel('api_sync_log')->info('DB is already synced with API');
        } else {
            Log::channel('api_sync_log')->info('DB is succesfully synced with API');
        }
    }
}
