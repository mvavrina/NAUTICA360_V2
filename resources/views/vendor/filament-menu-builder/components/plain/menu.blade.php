@props(['type' => ''])

{{-- Determine wrapper class based on type --}}
@php
$isFooter = false;
switch ($type) {
    case 'footer':
            $wrapperClass = 'footer-menu-wrapper'; // Replace with your specific class for footer
            $isFooter = true;
            break;
        case 'header':
            $wrapperClass = 'flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0 mb-0 list-none pl-0 absolute lg:relative dark:bg-gray-900 left-0 max-lg:top-[84px] max-lg:z-10 max-lg:w-[100%] max-lg:mt-0 max-lg:pb-10 max-lg:rounded-br-xl max-lg:rounded-bl-xl'; // Replace with your specific class for header
            break;
        default:
            $wrapperClass = ''; // Default or other types
    }
@endphp

@if($type !== 'footer')
    <ul class="{{ $wrapperClass }}">
        @foreach($menuItems as $menuItem)
            @include('filament-menu-builder::components.plain.menu-item', ['item' => $menuItem])
        @endforeach
    </ul>
@endif

@if($isFooter)
    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:col-span-2 md:grid-cols-4">
        @foreach($menuItems as $menuItem)
            <div class="text-center sm:text-left">
                @if ( !empty($menuItem->link))
                    <a href="{{$menuItem->link}}" target="{{$menuItem->target}}" class="text-lg font-medium text-white">{{ $menuItem->name }}</a>
                @else
                    <p class="text-lg font-medium text-white m-0">{{ $menuItem->name }}</p>
                @endif
                
                @if(!$menuItem->children->isEmpty())
                <nav class="mt-2">
                    <ul class="space-y-4 text-sm pl-0">
                        {{-- Check if item has children --}}
                                @foreach($menuItem->children as $child)
                            
                                    <li class="list-none">
                                        <a class="text-white transition hover:text-white/75" target="{{$child->target}}" href="{{ $child->link }}">
                                            {{ $child->name }}
                                        </a>
                                    </li>

                                @endforeach
                            </ul>
                        </nav>
                        @else
                    @endif
            </div>
        @endforeach
    </div>
@endif