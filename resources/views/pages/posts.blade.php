<x-frontend-layout>
    <div class="container mx-auto px-4 py-8 box-border">

        @isset($taxon)
            <h1 class="text-center mb-2 h2">{{ $taxon->title }}</h1>
            @empty(!$taxon->description)
                <p class="text-center max-w-[900px] mx-auto mb-10">{{ $taxon->description }}</p>
            @endempty
        @else
            <h1 class="text-center mb-2 h2">Přehled příspěvků</h1>
        @endisset

        @isset($allTaxons)
        <!-- Taxon Filter Dropdown -->
        <form method="GET" class="mb-6 text-center" id="taxonFilterForm">
            <select name="taxonSlug" class="border rounded px-4 py-2" id="taxonSelect">
                <option value="{{ route('prehled-prispevku') }}" {{ request()->route('taxonSlug') == null ? 'selected' : '' }}>
                    Všechny kategorie
                </option>
                @foreach($allTaxons as $t)
                    <option value="{{ route('prehled-prispevku', $t->slug) }}" 
                        {{ request()->route('taxonSlug') == $t->slug ? 'selected' : '' }}>
                        {{ $t->title }}
                    </option>
                @endforeach
            </select>
        </form>
        
        <script>
            document.getElementById('taxonSelect').addEventListener('change', function () {
                window.location.href = this.value;
            });
        </script>
        @endisset

        @if ($posts->isEmpty())
            <p class="text-center text-gray-500">Žádné příspěvky nebyly nalezeny.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-10">
                @foreach ($posts as $post)
                    @isset($taxon)
                        <x-card-blog-item :taxonSlug="$taxon->slug" :post="$post" :slide="false"></x-card-blog-item>
                    @else
                        <x-card-blog-item :post="$post" :taxonSlug="'prispevky'" :slide="false"></x-card-blog-item>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</x-frontend-layout>
