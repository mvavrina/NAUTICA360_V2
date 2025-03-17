<a href="{{ !empty($city->link) ? $city->link : '#' }}" class="relative after:content-[''] after:absolute after:top-0 after:left-0 after:w-full after:h-full after:max-h-[calc(100%-2px)] after:bg-gradient-to-b after:from-[#0037c100] after:to-[#001a5b90] after:opacity-100 after:rounded-xl after:overflow-hidden card-region-item">
    <!-- Card Region Image with Flag and Name -->
    <div class="relative rounded-xl">
        <img src="{{ Storage::url($city->img) }}" alt="{{ $city->heading }}" class="w-full h-full rounded-xl overflow-hidden card-region-item-thumb">
        <!-- Image -->

        <!-- Flag and Name Overlay -->
        <div class="absolute bottom-0 left-0 p-6 text-white z-10 ">
            <div class="flex items-center gap-3 mb-1">
                <h3 class="text-lg text-white m-0">{{ $city->heading }}</h3>
            </div>
            <p class="text-center text-base font-medium max-w-[684px] mx-auto m-0 text-white">{{ $city->text }}</p>
        </div>
    </div>
</a>