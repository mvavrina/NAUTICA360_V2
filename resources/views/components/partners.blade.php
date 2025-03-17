<section class="container mx-auto px-2 box-border max-w relative my-20 py-20">
    <h2 class="text-center mb-2">Naši partneři</h2>
    <p class="text-center max-w-[800px] mx-auto mb-10">Buďte v obraze s našimi nejnovějšími expedicemi, plavbami a
        dobrodružstvími na moři. Objevte destinace, získávejte nové námořní zkušenosti a nechte se inspirovat
        nezapomenutelnými cestami.</p>
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-[1.1em] gap-y-[1em]">
        @foreach ($partners as $item)
        @for ($i = 0; $i < 8; $i++) <div class="p-4 py-8 text-center partner-item rounded-xl"><img
                src="{{Storage::url($item->img)}}" height="80" alt=""></div>
    @endfor
    @endforeach
    </div>
</section>