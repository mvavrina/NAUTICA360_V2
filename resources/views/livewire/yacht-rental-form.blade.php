<div class="grid gap-6 bg-white shadow-xl p-4 rounded-[1rem] w-full box-border">
    <!-- Yacht Information -->
    <div class="space-y-4">
        <h2 class="text-2xl font-semibold text-gray-900">{{ $yacht->name }} – {{ $yacht->homeBase }}</h2>
        <div class="flex justify-between">
            <p class="font-medium text-gray-700">
                <span>🇬🇷</span> 
                <a href="{{ route('Detail maríny', ['id' => $yacht->homeBaseId]) }}" target="_blank" class="text-blue-600 underline hover:text-blue-800">{{ $yacht->homeBase }}</a>
            </p>
            <p class="text-2xl font-bold text-green-600">{{ number_format($pricingData[0]['price'] * (1 - config('yacht.percentage_sale') / 100), 2) }} €</p>
        </div>
        <div class="flex justify-between items-center">
            <span>Termín:</span>
            <span>{{ $formatedStartDate }} - {{ $formatedEndDate }}</span>
        </div>
    <div class="flex justify-between items-center">
            <span>Společnost:</span>
        <a href="{{ route('Detail společnosti', ['id' => $yacht->companyId]) }}" target="_blank" class="text-blue-600 underline hover:text-blue-800">{{ $yacht->company }}</a>
        </div>

        <!-- Additional Info -->
        <div class="space-y-2 ">
            <div class="flex justify-between">
                <span class="max-w-[calc(100% - 150px)]">Základní cena:</span>
                <span class="font-semibold w-[150px] text-right">{{ number_format($pricingData[0]['price'], 2) }} €</span>
            </div>
            <div class="flex justify-between">
                <span class="max-w-[calc(100% - 150px)]">Sleva:</span>
                <span class="font-semibold w-[150px] text-right text-green-600">{{config('yacht.percentage_sale')}}%</span>
            </div>
            <hr class="my-4 border-gray-300">
            <div class="flex justify-between">
                <span class="max-w-[calc(100% - 150px)]">Vaše cena:</span>
                <span class="font-semibold w-[150px] text-right">{{ $pricingData[0]['price'] * (1 - config('yacht.percentage_sale') / 100), 2 }} €</span>
            </div>
            <div class="flex justify-between">
                <span class="max-w-[calc(100% - 150px)]">Kauce:</span>
                <span class="font-semibold w-[150px] text-right">{{ number_format($yacht->deposit, 2) }} €</span>
            </div>
            @if(!empty($extras))
                <hr class="my-4 border-gray-300">
                <p class="text-center">Povinné poplatky</p>
                @foreach ($extras as $extra)
                    <div class="flex justify-between">
                        <span class="max-w-[calc(100% - 150px)]">{{$extra->name}}:</span>
                        <span class="font-semibold w-[150px] text-right">{{ $extra->price, 2 }} €</span>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Book Now Button -->
        <div class="mt-12 text-right">
            <a href="{{ route('yacht.reservation', [
                'id' => $yacht->id, 
                'dateFrom' => urlencode(\Carbon\Carbon::parse($startDate)->format('m/d/Y')), 
                'dateTo' => urlencode(\Carbon\Carbon::parse($endDate)->format('m/d/Y'))
            ]) }}"
            class="mt-4 inline-block bg-blue-600 text-white py-4 px-6 rounded-lg hover:bg-blue-700 transition ml-auto">
            Rezervovat loď
        </a>
        
        </div>
    </div>
</div>