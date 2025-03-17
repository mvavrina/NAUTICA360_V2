<section class="container mx-auto px-2 box-border max-w relative my-20 py-10 mb-12">
    <h2 class="text-center mb-2">Novinky a informace</h2>
    <p class="text-center max-w-[800px] mx-auto mb-10">Buďte v obraze s našimi nejnovějšími expedicemi, plavbami a dobrodružstvími na moři. Objevte destinace, získávejte nové námořní zkušenosti a nechte se inspirovat nezapomenutelnými cestami.</p>

    <div class="blog-swiper overflow-hidden">
        <div class="swiper-wrapper">
          @foreach ($posts as $post)
              <x-card-blog-item :post="$post" :slide="true"></x-card-blog-item>
          @endforeach
        </div>
      
        <!-- Navigation buttons -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</section>
<div class="text-center">
    <x-button style="primary" url="{{route('prehled-prispevku')}}" text="Zobrazit vše"/>
</div>
  