@props(['name', 'description', 'image', 'link'])

<a href="{{$link}}" class="boat-category-item flex flex-col space-y-4 relative after:content-[''] after:absolute after:top-0 after:left-0 duration-50 after:w-full after:h-full after:max-h-[calc(100%)] overflow-hidden rounded-xl after:bg-gradient-to-b after:from-[#0037c120] after:to-[#001a5b4c] after:opacity-100 after:rounded-xl after:overflow-hidden card-region-item">
    <img src="{{$image}}" alt="Image 1" class="w-full h-auto card-region-item-thumb">
    <div class="absolute z-10 bottom-0 left-0 p-6 text-left">
        <p class="text-white text-2xl font-semibold m-0">{{$name}}</p>
        <p class="text-white text-18 font-regular m-0 text-left">{{$description}}</p>
    </div>
</a>
