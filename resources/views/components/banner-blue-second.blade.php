<div class="bg-cover bg-center h-64 action-container text-center pt-10 xl:pt-20 my-20">
    <div class="action-container-background">
        <img src="{{asset('img/action.webp')}}" alt="">
    </div>
    <h2 class="text-white my-0">Recenze</h2>
    <img src="{{asset('img/vlny-gold.svg')}}" class="my-1" alt="Vlny icon">
    <div class="shadow-xl relative action-items bg-white py-10 lg:py-20 px-4 lg:px-10 max-w-[calc(100%-60px)] lg:max-w-[1100px] mx-auto mt-5 rounded-2xl">
        <div class="swiper-container overflow-hidden">
            <div class="swiper-wrapper">
                <!-- First action item -->
                @foreach ($testimonials as $item)
                    <div class="swiper-slide">
                        <img src="{{Storage::url($item->img)}}" class="w-[80px] rounded mb-6 mx-auto" alt="">
                        <div class="action-item px-0 md:px-6">
                            {{$item->text}}
                            <h4 class="mb-1 mt-10">{{$item->name}}</h4>
                            <p class="uppercase my-0">{{$item->customer_type}}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</div>

