<x-frontend-layout>
    <div class="mainscreen text-center py-20 mb-20 min-h-40 align-center flex flex-col justify-center">
        <h1 class="text-white my-0">Vítejte na palubě</h1>
        <h2 class="text-white text-2xl font-[400] mt-0 mb-20">Pronájem lodí a kapitánské kurzy na jednom místě</h2>
        <div class="bg-white p-4 max-w-6xl mx-auto rounded-xl">
            <x-search-field></x-search-field>
        </div>
    </div>

    <div class="container mx-auto px-2 box-border mt-20 pt-10">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-y-0 gap-x-5">
            <x-page-segment-info title="Vyhledávač lodí" image="/img/wheel.svg"
                text="Tisíce lodí, vždy aktuální slevy a on-line dostupnost." />
            <x-page-segment-info title="Dovolená na lodi" image="/img/vacination.svg"
                text="Plavba po moři přináší nepopsatelný pocit svobody." />
            <x-page-segment-info title="Kapitánské kurzy" image="/img/captain.svg"
                text="Přestaňte snít a staňte se kapitánem! Vydejte se s námi na týdenní plavbu." />
        </div>
        
        <x-card-regions></x-card-regions>

        <x-card-cities></x-card-cities>
        
        <x-boat-types></x-boat-types>

        <x-card-blog></x-card-blog>

        <x-banner-blue-second></x-banner-blue-second>

        <x-partners></x-partners>
    </div>
</x-frontend-layout>