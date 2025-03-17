@props(['type' => ''])

{{-- Determine wrapper class based on type --}}
@php
    empty($type) ? $type = '' : '';
    $ulStyles = '';
    switch ($type) {
        case 'footer':
            $wrapperClass = 'footer-menu-wrapper'; // Replace with your specific class for footer
            $linkClass = '';
            break;
        case 'header':
            $wrapperClass = 'mb-0 relative'; // Replace with your specific class for header
            $linkClass= 'block py-2 pr-4 pl-3 text-white rounded lg:bg-transparent lg:text-blue-700 dark:text-white lg:px-0 py-3';
            $ulStyles = 'd-none';
            break;
        default:
            $wrapperClass = ''; // Default or other types
            $linkClass = '';
    }
@endphp

<li class="{{ $item->wrapper_class }} {{ $wrapperClass }}" 
    @if(!$item->children->isEmpty()) x-data="{submenuShow : false}" @mouseleave="submenuShow = false" @mouseover="submenuShow = true" @endif>
    
    <a target="{{ $item->target }}" class="{{ $linkClass }}" href="{{ $item->link }}">
        {{ $item->name }}
    </a>

    @if(!$item->children->isEmpty())
        <ul class="sub-menu rounded-xl shadow p-4 dark:bg-gray-800 pt-0" :class="submenuShow ? 'active' : ''">
            @foreach($item->children as $child)
                <li>
                    <a target="{{ $child->target }}" class="{{ $linkClass }} lg:p-0" href="{{ $child->link }}">
                        {{$child->name}}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</li>
