<div class="my-20 py-10">
    <!-- Heading Section -->
    <h2 class="text-center mb-2">Pronájem lodí ve Středozemním moři</h2>
    <p class="text-center max-w-[684px] mx-auto mb-10">Nejste si jisti, kam plout? Začněte prozkoumáním nejoblíbenějších destinací. Vyberte si místo, kde chcete strávit svůj čas, my se postaráme o zbytek.</p>

    <!-- Loop through Card Regions -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-[1.1em] gap-y-[1em]">
        @foreach ($cardRegions as $region)
            <x-card-regions-item :region="$region"></x-card-regions-item>
        @endforeach
    </div>
</div>
