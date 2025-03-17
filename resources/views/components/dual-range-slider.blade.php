@props(['name', 'label', 'min', 'max', 'values' => null, 'unit' => ''])

@php
    // If values are not provided, set them to min and max
    $values = $values ?? [$min, $max];
@endphp

<div>
    <!-- Range Label -->
    <p>
        <label for="amount-{{ $name }}">{{ $label }}:</label>
        <input type="text" id="amount-{{ $name }}" readonly style="border:0; color:rgb(37 99 235 / var(--tw-bg-opacity, 1)); font-weight:medium;">
    </p>

    <!-- Slider -->
    <div id="slider-range-{{ $name }}"></div>
</div>

<!-- Script -->
<script>
    $(function() {
        let values = @json($values);
        let unit = @json($unit);

        $("#slider-range-{{ $name }}").slider({
            range: true,
            min: {{ $min }},
            max: {{ $max }},
            values: values,
            slide: function(event, ui) {
                $("#amount-{{ $name }}").val(unit + ui.values[0] + " - " + unit + ui.values[1]);
            }
        });

        // Set initial value
        $("#amount-{{ $name }}").val(unit + values[0] + " - " + unit + values[1]);
    });
</script>
