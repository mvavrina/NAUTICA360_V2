<x-filament-forms::field-wrapper :id="$getId()" :label="$getLabel()" :state-path="$getStatePath()">
    <textarea 
        x-data 
        x-init="CKEDITOR.replace('{{ $getId() }}')" 
        id="{{ $getId() }}" 
        style="height: 500px"
        name="{{ $getStatePath() }}" 
        wire:model.defer="{{ $getStatePath() }}"
        {!! $attributes->merge(['class' => 'hidden']) !!}>
        {{ $getState() }}
    </textarea>
</x-filament-forms::field-wrapper>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<style>
    .cke_notifications_area{
        display: none !important;
    }
</style>