@props(['title', 'image', 'text'])

<div class="flex gap-4 sm:gap-8 py-5 max-w-96">
    {{-- Left column with image --}}
    <div class="w-[60px]">
        <img src="{{ $image }}" alt="{{ $title }}" class="w-16 sm:w-[66px]">
    </div>

    {{-- Right column with text --}}
    <div class="flex-1">
        <h3 class="my-0">{{ $title }}</h3>
        <img src="img/vlny.svg" class="my-1" alt="Vlny icon">
        <p class="my-0">{{ $text }}</p>
    </div>
</div>
