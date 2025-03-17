@props(['style', 'url' => '', 'text', 'submit' => false])

@php
    $buttonClasses = match($style) {
        'primary' => 'cursor-pointer bg-blue-light rounded-xl text-white py-[20px] px-[50px] border-none text-16 font-medium bg-blue-700 hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700',
        'secondary' => 'cursor-pointer secondary p-4 pl-2 ml-[-8px] text-grey-13 text-18 font-semibold capitalize duration-200 border-none',
        default => 'cursor-pointer bg-green-500 hover:bg-green-700 text-white py-2 px-4 rounded',
    };

    $secondaryIcon = '<img src="/img/button-secondary.png" alt="" class="w-[90px] h-[6px] mt-2 mx-auto absolute top-center translate-y-4 left-0" />';
@endphp

@if ($url)
    <!-- If URL is provided, render a link -->
    <a href="{{ $url }}" class="{{ $buttonClasses }}">
        {{ $text }}
        @if ($style === 'secondary')
            {!!$secondaryIcon!!}
        @endif
    </a>
@else
    <!-- If no URL is provided, render a button -->
    <button class="{{ $buttonClasses }} " @if($submit) type="submit" @endif>
        {{ $text }}
        @if ($style === 'secondary')
            {!!$secondaryIcon!!}
        @endif
    </button>
@endif
