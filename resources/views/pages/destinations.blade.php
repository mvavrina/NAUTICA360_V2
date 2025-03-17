<x-frontend-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-6">Destinace</h1>
    
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($destinations as $destination)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    @if ($destination->img)
                        <img src="{{ asset('storage/' . $destination->img) }}" alt="{{ $destination->heading }}" class="w-full h-48 object-cover">
                    @endif
    
                    <div class="p-4">
                        <h2 class="text-xl font-semibold mb-2">{{ $destination->heading }}</h2>
                        <p class="text-gray-600">{{ $destination->text }}</p>
    
                        <div class="mt-4 flex items-center">
                            @if ($destination->flag)
                                <img src="{{ asset('storage/' . $destination->flag) }}" alt="Flag" class="w-6 h-4 mr-2">
                            @endif
                            <a href="{{ $destination->link }}" class="text-blue-600 hover:underline">Více informací</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-frontend-layout>