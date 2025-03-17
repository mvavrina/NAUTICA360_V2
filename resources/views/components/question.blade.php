<div class="p-4 xl:max-width-[700px]">
    <!-- Heading -->
    <h2 class="text-primary mb-0">Časté otázky</h2>

    <!-- Text -->
    <p class="mb-8 mt-2">Dolore magna aliqua enim ad minim veniam, quis nostrudreprehenderits
        dolore fugiat nulla pariatur lorem ipsum dolor sit amet.</p>
    
    <!-- Icon -->
    <img src="{{asset('img/vlny-gold.svg')}}" class="mb-8" alt="Vlny icon">

    <div class="space-y-6">
        @foreach ($questions as $item)
        <div x-data="{ open: false }" >
            <button @click="open = !open" :class="open ? 'active' : ''" class="flex items-center justify-between w-full text-left font-semibold text-lg custom-box relative">
                <span class="flex items-center text-grey-16 font-[400]">
                    <img class="qa-number-bg" src="{{asset('img/qa.svg')}}" alt="">
                    <span class="mr-6 qa-number">{{$loop->iteration}}.</span> {{$item->question}}
                </span>
                <span :class="open ? 'rotate-180' : ''" class="transition-transform duration-0 ">
                    ⌄
                </span>
            </button>
            <p x-show="open" x-transition class="text-primary pl-10 qa-answer mt-6">{{$item->answer}}</p>
        </div>
        @endforeach
    </div>
</div>