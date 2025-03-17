@if ($base)
<div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-bold text-center mb-4">{{ $base->name }}</h2>
    <div class="space-y-2">
        @foreach ([
        'city' => 'Město',
        'country' => 'Země',
        'address' => 'Adresa',
        'latitude' => 'Zeměpisná šířka',
        'longitude' => 'Zeměpisná délka'
        ] as $key => $label)
        @if (!empty($base->$key))
        <div class="flex justify-between border-b py-2">
            <span class="font-semibold">{{ $label }}:</span>
            <span>{{ $base->$key }}</span>
        </div>
        @endif
        @endforeach

        @if (!empty($base->countryId))
        <div class="flex justify-between border-b py-2">
            <span class="font-semibold">Země:</span>
            <span>{{ $base->getCountry->name }}</span>
        </div>
        @endif

        @if (!empty($base->sailingAreas))
        @php
        $sailingAreaIds = json_decode($base->sailingAreas, true);
        @endphp

        @if (is_array($sailingAreaIds))
        <div class="flex justify-between border-b py-2">
            <span class="font-semibold">Oblasti plavby:</span>
            <span>
                {{ implode(', ', array_map(fn($id) => $areas->firstWhere('id', $id)?->name ?? "ID: $id",
                $sailingAreaIds)) }}
            </span>
        </div>
        @endif
        @endif

    </div>

    <x-map latitude="{{$base->latitude}}" longtitude="{{$base->longitude}}" name="{{ $base->name }}"></x-map>

</div>
@else
<p class="text-center text-red-500">Marína nebyla nalezena.</p>
@endif

<a href="{{route('Přehled marín')}}" class="hover:underline flex items-center"><x-heroicon-o-arrow-left class="w-5 h-5 mr-2" /> Zpět na seznam marín</a>