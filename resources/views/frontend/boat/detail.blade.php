<x-frontend-layout>
    <div class="container mx-auto px-4 px-2 box-border pt-10">
        <h1 class="text-center">{{ $yacht->name }} - {{ $yacht->model }}</h1>

        <div class="swiper yacht-detail-swiper rouded-xl rounded-3xl overflow-hidden">
            <div class="swiper-wrapper">
                @foreach ($yacht->images as $image)
                @php
                    $imageName = pathinfo($image->name, PATHINFO_FILENAME); // Get the file name without extension
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

        <section class="my-20">
                <h2 class="mb-4">Informace o chartě</h2>
                <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-[2fr_1fr] gap-20">
                    <div>
                        <div class="grid grid-cols-1 2xl:grid-cols-2 gap-2 w-full">
                            <p class="m-0 grid grid-cols-[1fr_1fr] gap-4">Model: <strong class="font-[600]">{{ $yacht->model }}</strong></p>
                            <p class="m-0 grid grid-cols-[1fr_1fr] gap-4">Rok výroby: <strong class="font-[600]">{{ $yacht->year }}</strong></p>
                            <p class="m-0 grid grid-cols-[1fr_1fr] gap-4">Délka: <strong class="font-[600]">{{ $yacht->length }} m</strong></p>
                            <p class="m-0 grid grid-cols-[1fr_1fr] gap-4">Ponor: <strong class="font-[600]">{{ $yacht->draught }} m</strong></p>
                            <p class="m-0 grid grid-cols-[1fr_1fr] gap-4">Počet lůžek: <strong class="font-[600]">{{ $yacht->berths }}</strong></p>
                            <p class="m-0 grid grid-cols-[1fr_1fr] gap-4">Počet kajut: <strong class="font-[600]">{{ $yacht->cabins }}</strong></p>
                            <p class="m-0 grid grid-cols-[1fr_1fr] gap-4">Počet WC: <strong class="font-[600]">{{ $yacht->wc }}</strong></p>
                            <p class="m-0 grid grid-cols-[1fr_1fr] gap-4">Kapacita vody: <strong class="font-[600]">{{ $yacht->waterCapacity }} l</strong></p>
                            <p class="m-0 grid grid-cols-[1fr_1fr] gap-4">Kapacita paliva: <strong class="font-[600]">{{ $yacht->fuelCapacity }} l</strong></p>
                            <p class="m-0 grid grid-cols-[1fr_1fr] gap-4">Motor: <strong class="font-[600]">{{ $yacht->engine }} hp</strong></p>
                            <p class="m-0 grid grid-cols-[1fr_1fr] gap-4">Marina: <a href="{{ route('Detail maríny', ['id' => $yacht->homeBaseId]) }}" target="_blank" class="underline text-[#5E6666]"><strong class="font-[600]">{{ $yacht->homeBase }}</strong></a></p>
                            <p class="m-0 grid grid-cols-[1fr_1fr] gap-4">Společnost: <strong class="font-[600]">{{ $yacht->company }}</strong></p>
                            <p class="m-0 grid grid-cols-[1fr_1fr] gap-4">Typ lodě: <strong class="font-[600]">{{ $yacht->kind }}</strong></p>
                        </div>
                    </div>
                    <div class="w-auto box-content flex flex-col gap-8">
                        @livewire('yacht-rental-form', ['yacht' => $yacht, 'startDate' => request('startDate'), 'endDate' => request('endDate'), 'extras' => $extras[1]])
                        @livewire('rent-yacht-calendar', ['startDate' => request('startDate'), 'endDate' => request('endDate'), 'yachtId' => $yacht->id])
                    </div>
                </div>
            </section>
        <!-- Display other yacht details like equipment, crew, etc. -->

        @if (!empty($extras[0]))
            <section class="my-20">
                <h2 class="mb-4">Volitelné služby</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    @foreach ($extras[0] as $extra)
                        <p class="m-0 grid grid-cols-[1fr_100px] gap-4">{{ $extra->name }} @if($extra->price > 0) <strong class="font-[600]">{{$extra->price}}€</strong> @else <span>{{$extra->price}}€</span> @endif</p>
                    @endforeach
                </div>
            </section>
        @endif

        @if (empty($extras[1]))
            <section class="my-20">
                <h2 class="mb-4">Povinné služby</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    @forelse ($extras[1] as $extra)
                        <p class="grid grid-cols-[1fr_100px] gap-4 m-0">{{$extra->name}} @if($extra->price > 0) <strong class="font-[600]">{{$extra->price}}€</strong> @else <span>{{$extra->price}}€</span> @endif</p>
                    @empty
                    @endforelse
                </div>
            </section>
        @endif


        <section class="my-20">
            <h2 class="mb-4">Vybavení lodi</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @forelse ($equipments as $equipment)
                    @if(in_array($equipment->id, $yachtEquipmentIds))
                        <p class="m-0 grid grid-cols-[1fr_100px] gap-4">{{__($equipment->name)}} <strong class="font-[600]">Yes</strong></p>
                    @else
                        <p class="m-0 grid grid-cols-[1fr_100px] gap-4">{{__($equipment->name)}} <span>No</span></p>
                    @endif
                    @empty
                @endforelse
            </div>
        </section>

        <section class="my-20">
            <x-map latitude="{{$base->latitude}}" longtitude="{{$base->longitude}}" name="{{ $base->name }}"></x-map>
        </section>
    </div>
</x-frontend-layout>