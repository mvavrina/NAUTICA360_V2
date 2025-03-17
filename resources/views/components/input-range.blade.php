<div x-data="rangeSlider({{ $min }}, {{ $max }})" class="space-y-4">
    <div class="flex space-x-4 items-center">
        <input 
            type="number" 
            x-model="minValue" 
            @input="updateMin" 
            class="w-20 px-2 py-1 border rounded"
        >
        <input 
            type="range" 
            x-model="minValue" 
            :min="min" 
            :max="max" 
            @input="updateMin" 
            class="flex-1"
        >
    </div>
    <div class="flex space-x-4 items-center">
        <input 
            type="number" 
            x-model="maxValue" 
            @input="updateMax" 
            class="w-20 px-2 py-1 border rounded"
        >
        <input 
            type="range" 
            x-model="maxValue" 
            :min="min" 
            :max="max" 
            @input="updateMax" 
            class="flex-1"
        >
    </div>
</div>

<script>
    function rangeSlider(min, max) {
        return {
            min: min,
            max: max,
            minValue: min,
            maxValue: max,
            updateMin() {
                if (this.minValue < this.min) this.minValue = this.min;
                if (this.minValue > this.maxValue) this.minValue = this.maxValue;
            },
            updateMax() {
                if (this.maxValue > this.max) this.maxValue = this.max;
                if (this.maxValue < this.minValue) this.maxValue = this.minValue;
            }
        };
    }
</script>