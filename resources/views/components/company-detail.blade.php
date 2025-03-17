@if ($company)
<div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-2xl text-center mb-10">{{ $company->name }}</h2>
    <div class="space-y-2">
        @foreach ([
            'address' => 'Adresa',
            'city' => 'Město',
            'zip' => 'PSČ',
            'country' => 'Země',
            'telephone' => 'Telefon',
            'telephone2' => 'Telefon 2',
            'mobile' => 'Mobil',
            'mobile2' => 'Mobil 2',
            'email' => 'E-mail',
            'web' => 'Web'
        ] as $key => $label)
            @if (!empty($company->$key))
                <div class="flex justify-between border-b py-2">
                    <span class="font-semibold">{{ $label }}:</span>
                    <span>{{ $company->$key }}</span>
                </div>
            @endif
        @endforeach
    </div>
</div>
@else
<p class="text-center text-red-500">Společnost nebyla nalezena.</p>
@endif

<a href="{{route('Přehled společností')}}" class="hover:underline flex items-center"><x-heroicon-o-arrow-left class="w-5 h-5 mr-2" /> Zpět na seznam společností</a>
