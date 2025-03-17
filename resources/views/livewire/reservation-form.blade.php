<div class="container mx-auto max-w-[800px] p-6 ">
    <a href="{{url()->previous()}}" class="hover:underline flex items-center"><x-heroicon-o-arrow-left class="w-5 h-5 mr-2" /> Zpět na detail lodě</a>
    
    <div class="grid gap-6 bg-white shadow-xl p-4 rounded-[1rem] w-full mt-4">
        <div class="swiper yacht-detail-swiper rouded-xl rounded-3xl overflow-hidden">
            <div class="swiper-wrapper">
                @foreach ($yacht->images as $image)
                @php
                    $imageName = pathinfo($image->name, PATHINFO_FILENAME); 
                    $newImage = $imageName . '_1600px.webp';
                @endphp
                    <div class="swiper-slide">
                        <img src="{{ asset('storage/yacht_images/' . $yacht->id . '/' . $newImage) }}" alt="">
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
        <div class="space-y-4">
            <h2 class="text-2xl font-semibold text-gray-900">{{ $yacht['name'] .' - ' . $yacht['model']}}</h2>
            <div class="flex justify-between items-center">
                <span>Termín:</span>
                <span>{{ $date_from->format('d.m.Y') }} - {{ $date_to->format('d.m.Y') }}</span>
            </div>

            <div class="flex justify-between items-center">
                <span>Základní cena:</span>
                <span class="font-semibold w-[150px] text-right">{{ number_format($base_price, 2) }} €</span>
            </div>
            <div class="flex justify-between items-center">
                <span>Sleva:</span>
                <span class="font-semibold w-[150px] text-right">{{ $discount }}%</span>
            </div>
            <div class="flex justify-between items-center">
                <span>Vaše cena:</span>
                <span class="font-semibold w-[150px] text-right text-green-600">{{ number_format($price, 2) }} €</span>
            </div>
            
        </div>

        <!-- Reservation Form -->
        <div class="mt-6">
            <form wire:submit.prevent="submit">
                <!-- Name fields -->
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <input type="text" id="first_name" wire:model="first_name" class="custom-input w-full" required placeholder="Jméno">
                    </div>
                    <div class="mb-4">
                        <input type="text" id="last_name" wire:model="last_name" class="custom-input w-full" required placeholder="Příjmení">
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <input type="email" id="email" wire:model="email" class="custom-input" required placeholder="E-mail">
                    </div>
                    <div class="mb-4">
                        <input type="tel" id="tel" wire:model="tel" class="custom-input" required placeholder="Telefon">
                    </div>
                </div>

                <div class="mb-4">
                    <textarea id="note" wire:model="note" class="custom-input" rows="4" placeholder="Poznámka"></textarea>
                </div>

                <div class="mb-4">
                    <label for="agreement" class="border border-gray-700 text-sm text-gray-700">Odesláním tohoto formuláře souhlasíte s obchodními podmínkami a zpracováním osobních údajů.</label>
                </div>

                <!-- Submit Button -->
                <div class="mt-6 text-right">
                    <x-button style="primary" type="submit" text="Nezávazně rezervovat" submit="true"></x-button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success Message -->
@if (session()->has('message'))
    <div class="mt-4 p-4 bg-green-100 text-green-700 rounded">
        {{ session('message') }}
    </div>
@endif
