@props(['post', 'slide' => false, 'taxonSlug' => 'prispevek'])

@if($slide == true)
<div class="swiper-slide pb-10">
    @endif

    <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col h-[100%]">
        @if ($post->thumbnail)
        <a href="{{ $taxonSlug.'/'.$post->slug }}"><img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-auto rounded-lg aspect-[16/11] object-cover"></a>
        @else
        <a href="{{ $taxonSlug.'/'.$post->slug }}" class="aspect-[16/11] flex justify-center align-middle dark:bg-gray-900"><img src="{{asset('/img/logo.png')}}" alt="{{ $post->title }}" class="w-[50%] rounded-lg object-contain position-center object-center"></a>
        @endif
        <div class="p-4 flex flex-col flex-grow">
            <div class="post-date text-gray-500 text-sm mb-0">
                @if($post->published) {{ $post->published->locale('cs')->translatedFormat('j. F Y') }}  @endif

            </div>
            <h2 class="h3 font-semibold mb-0 mt-2">{{ $post->title }}</h2>
            <p class="my-4">{{$post->exceprt }}</p>

            <div class="mt-auto mb-2">
                <div class="post-readmore mt-auto relative">
                    @php
                    // Get the first segment of the URL dynamically
                    $firstSegment = request()->segment(1) ?? 'prispevek';
                    if($firstSegment == 'prispevky'){
                        $firstSegment = 'prispevek';
                    }
                    $baseBackPath = '/' . $firstSegment;
                   
                @endphp
                
                <x-button style="secondary" url="{{ $baseBackPath . '/' . $post->slug }}" text="Read more"/>
                
                </div>
            </div>
        </div>
    </div>
    @if($slide == true)
</div>
@endif