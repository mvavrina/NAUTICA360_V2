<x-frontend-layout>
    @livewire('reservation-form', [
        'yacht_id' => $yacht->id,
        'date_from' => $startDate,
        'date_to' => $endDate,
        'price' => $pricingData[0]['price']
    ])
    
</x-frontend-layout>
