<x-frontend-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            @php
            $segments = request()->segments();
            
            // If the first segment is 'prispevek', redirect to 'prispevky'
            if (!empty($segments) && $segments[0] === 'prispevek') {
                $backUrl = url('prispevky');
            } else {
                array_pop($segments); // Remove the last segment (post slug)
                $backUrl = url(implode('/', $segments));
            }
        @endphp
        
        <a href="{{ $backUrl }}" class="hover:underline flex items-center">
            <x-heroicon-o-arrow-left class="w-5 h-5 mr-2" />
            Zpět na {{ isset($taxon) ? $taxon->title : 'Přehled příspěvků' }}
        </a>
        
        </div>
        
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            @if ($post->thumbnail)
                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover">
            @endif

            <div class="p-6 post-content">
                <h1 class="h2 mb-10 text-center">{{ $post->title }}</h1>
                <div class="post-content">
                    {!! $post->content !!}
                </div>
            </div>
        </div>
    </div>
</x-frontend-layout>
