<div class="my-20 py-10">
    <!-- Heading Section -->
    <h2 class="text-center mb-2">Populární přístavní města</h2>
    <p class="text-center max-w-[684px] mx-auto mb-10">Objevte nejkrásnější přístavní města, která lákají svou atmosférou, historií a nádhernými výhledy na moře. Vyberte si destinaci, kde kotví nejen lodě, ale i nezapomenutelné zážitky.</p>

    <!-- Loop through Card Regions -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-x-[1.1em] gap-y-[1em]">
        @foreach ($cardCities as $city)
            <x-card-cities-item :city="$city"></x-card-cities-item>
        @endforeach
    </div>
</div>
