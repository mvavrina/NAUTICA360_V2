<div class="container-big mx-auto px-4 px-2 box-border mt-0 pt-10">
    <h1 class="text-center h2">Vyhledávač jachet</h1>
    <form class="mx-auto" wire:submit.prevent="callToSearch" id="searchForm">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <div class="flex space-x-4 justify-center">
            <input type="text" wire:model="portName" id="port-name"
                   class="custom-input input-dynamic-width"
                   placeholder="Kde hledáte loď?" />
        
            <!-- Date Selector with Calendar -->
            <div id="date-range-picker" date-rangepicker class="flex items-center" wire:ignore>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 mt-[-3px] flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>
                    <input wire:model="startDate" id="datepicker-range-start" required name="start" type="text"
                           class="custom-input input-dynamic-width date-picker-input"
                           placeholder="Select date start">
                </div>
                <div class="relative ml-4">
                    <div class="absolute inset-y-0 start-0 mt-[-3px] flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>
                    <input wire:model="endDate" id="datepicker-range-end" required name="end" type="text"
                           class="custom-input input-dynamic-width date-picker-input"
                           placeholder="Select date end">
                </div>
            </div>
        
            <!-- Select Type of Yacht -->
            <select wire:model="yachtType" id="yacht-type"
                    class="custom-input input-dynamic-width">
                <option value="">Select Yacht Type</option>
                <option value="sailboat">Sailboat</option>
                <option value="motorboat">Motorboat</option>
                <option value="catamaran">Catamaran</option>
                <option value="gulet">Gulet</option>
                <option value="motorsailer">Motorsailer</option>
                <option value="motoryacht">Motoryacht</option>
                <option value="woodenboat">Woodenboat</option>
                <option value="cruiser">Cruiser</option>
                <option value="powercatamaran">Powercatamaran</option>
                <option value="trimaran">Trimaran</option>
                <option value="houseboat">Houseboat</option>
                <option value="rubberboat">Rubberboat</option>
                <option value="other">Other</option>
            </select>
        


            <!-- Search Button -->
            <button type="submit"
                class="inline-flex items-center justify-center p-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-blue-300 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Search
                <svg class="w-4 h-4 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </button>
        </div>
    </form>


    <section class="boat-filter p-6 bg-white rounded-lg shadow-md">
        <h3 class="text-xl font-semibold mb-4">Filtrovat</h3>
        
        <!-- Kajuty -->
        <div class="space-y-6 flex flex-wrap">
            <x-dual-range-slider name="capacite" min="0" max="20" label="Kapacita" />
            <x-dual-range-slider name="cajute" min="0" max="10" label="Počet kajut" />
            <x-dual-range-slider name="beds" min="0" max="10" label="Počet postelí" />
            <x-dual-range-slider name="length" min="3" max="25" label="Délka lodě" />
            <x-dual-range-slider name="year" min="0" max="15000" label="Rok výroby" />
            <x-dual-range-slider name="price" min="0" max="15000" label="Cena za týden" />
    
            <br>
            <x-model-input model="company" name="company" label="Společnost" placeholder="Vyberte společnost" />
            <x-model-input model="companies" name="model" label="Model" placeholder="Vyberte model" />
            <x-model-input model="extensions" name="extensions" label="Vybavení lodi" placeholder="Vyhledat" />
            
            <br>
            <x-model-input model="countries" name="extensions" label="Mariny" placeholder="Vyberte maríny" />

        </div>
    </section>
    
    

    <!-- Display Results -->
    @isset($results)
    <div class="mt-6">
    
        <div class="pb-20 mx-[-.75rem] relative grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 searchresults-items gap-0">
            @foreach($results as $result)
            <div class="md:py-6 md:px-3 py-4 px-2 yacht-serach-item">
                <div class="bg-white shadow-xl rounded-lg overflow-hidden h-full flex flex-col">
                    <!-- Yacht Images Slider -->
                    <div class="swiper-yachts overflow-hidden relative">
                        <div class="swiper-wrapper">
                            @if($result['yacht'] && $result['yacht']['images'])
                                @forelse($result['yacht']['images'] as $image)
                                    @php
                                        $imageName = pathinfo($image, PATHINFO_FILENAME); // Get the file name without extension
                                        $newImage = $imageName . '_'.config('yacht.serachThumbSize').'px.webp';
                                    @endphp
                                    <div class="swiper-slide">

                                        @if(str_contains($image, 'https://'))
                                            <img src="{{ $image }}" class="w-full aspect-[16/9] object-cover object-center" alt="{{ $result['yacht']['yacht']->name}}" />
                                        @else
                                            <img src="{{ asset('storage/yacht_images/' . $result['yachtId'] . '/' . $newImage) }}" class="w-full aspect-[16/9] object-cover object-center" alt="{{ $result['yacht']['yacht']->name}}" />
                                        @endif

                                    </div>
                                @empty
                                <div class="swiper-slide">
                                    <a href="" class="aspect-[16/9] flex justify-center align-middle dark:bg-gray-900"><img src="{{asset('/img/logo.png')}}" alt="" class="w-[50%] rounded-lg object-contain position-center object-center"></a>
                                </div>
                                @endforelse
                            @else
                                <p>No images available.</p>
                            @endif
                        </div>
                        <!-- Add Pagination (dots) -->
                        <div class="swiper-pagination"></div>
                        <!-- Add Navigation arrows -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
            
                    <!-- Yacht Details -->
                    <div class="p-4 mb-auto">
                        <a href="{{route('yacht.detail', $result['yachtId'])}}?startDate={{urlencode($startDate)}}&endDate={{urlencode($endDate)}}" class="h4 tracking-wide text-l font-semibold text-gray-700 my-0">{{ $result['yacht']['yacht']->name}} - {{$result['yacht']['yacht']->model}}</a>
                    </div>

                    <div class="flex px-4 py-1 border-t border-gray-300 text-gray-700">
                        <div class="flex-1 inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" stroke-width="1.5" viewBox="0 0 24 24" fill="none" class="h-6 w-6 text-gray-500 mr-3">
                                <path d="M1 20V19C1 15.134 4.13401 12 8 12V12C11.866 12 15 15.134 15 19V20" stroke="currentColor" stroke-linecap="round"/>
                                <path d="M13 14V14C13 11.2386 15.2386 9 18 9V9C20.7614 9 23 11.2386 23 14V14.5" stroke="currentColor" stroke-linecap="round"/>
                                <path d="M8 12C10.2091 12 12 10.2091 12 8C12 5.79086 10.2091 4 8 4C5.79086 4 4 5.79086 4 8C4 10.2091 5.79086 12 8 12Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M18 9C19.6569 9 21 7.65685 21 6C21 4.34315 19.6569 3 18 3C16.3431 3 15 4.34315 15 6C15 7.65685 16.3431 9 18 9Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            <p class="text-15">{{ isset($result['yacht']['yacht']->maxPeopleOnBoard) || !empty($result['yacht']['yacht']->maxPeopleOnBoard) ? $result['yacht']['yacht']->maxPeopleOnBoard : 'Neuvedeno' }}</p>
                        </div>
                        <div class="flex-1 inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="h-6 w-6 text-gray-600 mr-3">
                                <circle cx="12" cy="12" r="11.5" stroke="black"/>
                                <circle cx="2.5" cy="12.5" r="0.5" fill="black"/>
                                <path d="M5 14L6.22984 13.3851C7.35251 12.8237 8.66538 12.7852 9.81908 13.2796L9.95404 13.3374C10.9413 13.7605 12.0587 13.7605 13.046 13.3374L13.7933 13.0172C14.5461 12.6945 15.4109 12.7739 16.0924 13.2282V13.2282C17.1626 13.9417 18.6038 13.6949 19.3756 12.6658L19.5 12.5" stroke="black"/>
                                <path d="M6 16.5L7.22984 15.8851C8.35251 15.3237 9.66538 15.2852 10.8191 15.7796L10.954 15.8374C11.9413 16.2605 13.0587 16.2605 14.046 15.8374L15.2552 15.3192C15.7198 15.1201 16.2536 15.1691 16.6743 15.4495L16.9199 15.6132C17.809 16.206 19 15.5686 19 14.5V14.5" stroke="black"/>
                                <circle cx="12" cy="12" r="7.5" stroke="black"/>
                                <circle cx="5.5" cy="18.5" r="0.5" fill="black"/>
                                <circle cx="4.5" cy="5.5" r="0.5" fill="black"/>
                                <circle cx="18.5" cy="5.5" r="0.5" fill="black"/>
                                <circle cx="11.5" cy="2.5" r="0.5" fill="black"/>
                                <circle cx="11.5" cy="21.5" r="0.5" fill="black"/>
                                <circle cx="21.5" cy="12.5" r="0.5" fill="black"/>
                                <circle cx="18.5" cy="18.5" r="0.5" fill="black"/>
                                </svg>
                            <p class="text-gray-900 text-16 m-0">{{ $result['yacht']['yacht']->cabins ?? 'Neuvedeno' }} kajuty</p>
                        </div>
                    </div>

                    <div class="flex px-4 py-1 border-t border-gray-300 text-gray-700">
                        <div class="flex-1 inline-flex items-center">
                            <svg class="h-6 w-6 text-gray-600 fill-current mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M17.03 21H7.97a4 4 0 0 1-1.3-.22l-1.22 2.44-.9-.44 1.22-2.44a4 4 0 0 1-1.38-1.55L.5 11h7.56a4 4 0 0 1 1.78.42l2.32 1.16a4 4 0 0 0 1.78.42h9.56l-2.9 5.79a4 4 0 0 1-1.37 1.55l1.22 2.44-.9.44-1.22-2.44a4 4 0 0 1-1.3.22zM21 11h2.5a.5.5 0 1 1 0 1h-9.06a4.5 4.5 0 0 1-2-.48l-2.32-1.15A3.5 3.5 0 0 0 8.56 10H.5a.5.5 0 0 1 0-1h8.06c.7 0 1.38.16 2 .48l2.32 1.15a3.5 3.5 0 0 0 1.56.37H20V2a1 1 0 0 0-1.74-.67c.64.97.53 2.29-.32 3.14l-.35.36-3.54-3.54.35-.35a2.5 2.5 0 0 1 3.15-.32A2 2 0 0 1 21 2v9zm-5.48-9.65l2 2a1.5 1.5 0 0 0-2-2zm-10.23 17A3 3 0 0 0 7.97 20h9.06a3 3 0 0 0 2.68-1.66L21.88 14h-7.94a5 5 0 0 1-2.23-.53L9.4 12.32A3 3 0 0 0 8.06 12H2.12l3.17 6.34z"></path>
                            </svg>
                            <p class="text-15 m-0">{{ empty($result['yacht']['yacht']->wcNote) ? 'Neuvedeno' : $result['yacht']['yacht']->wcNote}}</p>

                        </div>
                    </div>

            
                    <!-- Contact Information -->
                    <div class="px-4 pt-3 pb-4 border-t border-gray-300 bg-gray-100 grid grid-cols-2 mt-4 searchYachtPrice">
                        <div class="pt-2">
                            <p class="my-0 text-l font-semibold text-gray-700 tracking-wide">{{$result['yacht']['yacht']->company}}</p>
                            <p class="my-0 text-sm text-gray-500">{{$result['yacht']['yacht']->kind}} ({{isset($result['yacht']['yacht']->year) ? $result['yacht']['yacht']->year : ''}})</p>

                        </div>

                        <div class="text-right mt-auto w-auto pt-2">
                            <p class="text-l my-0 text-blue-600 font-semibold">{!! $result['price'] .'&nbsp;'. $result['currency'] !!}</p>
                            <a href="{{route('yacht.detail', $result['yachtId'])}}?startDate={{urlencode($startDate)}}&endDate={{urlencode($endDate)}}" class="secondary p-4 mr-[-16px] text-gray-500 text-sm capitalize duration-200 border-none hover:underline">Více informací <x-heroicon-o-arrow-right class="w-3.5 h-3.5 ml-1 relative top-[1px]" /></a>
                        </div>
                    </div>
                </div>
            </div>
            
            @endforeach
        </div>

        <div>
            {{ $results->links() }}
        </div>
    </div>
    @endisset

    <script>
        document.getElementById('searchForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            // Get date values
            var startDate = document.getElementById('datepicker-range-start').value;
            var endDate = document.getElementById('datepicker-range-end').value;
            
            // Send dates to Livewire component
            Livewire.dispatch('updateDates', { startDate: startDate, endDate: endDate });
        });

    </script>
</div>