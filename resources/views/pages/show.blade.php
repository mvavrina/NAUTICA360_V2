<x-frontend-layout>
    <div class="container my-20 mx-auto">
        <h1 class="text-center">{{ $page->title }}</h1>
        <div>{!! $page->content !!}</div>
    </div>
</x-frontend-layout>