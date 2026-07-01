@props([
    'label',
    'name',
    'unit',
    'min',
    'max',
    'step' => 1,
    'default' => null,
    'optimal' => '',
])

@php $defaultVal = old($name, $default ?? round(($min + $max) / 2, 1)); @endphp

<div class="param-slider-group" id="group-{{ $name }}">
    {{-- Header --}}
    <div class="param-slider-header">
        <span class="param-slider-label">{{ $label }}</span>
        <span class="param-slider-unit">{{ $unit }}</span>
    </div>

    {{-- Slider + Number --}}
    <div class="param-slider-body">
        <span class="param-slider-min">{{ $min }}</span>
        <input
            type="range"
            id="slider-{{ $name }}"
            min="{{ $min }}"
            max="{{ $max }}"
            step="{{ $step }}"
            value="{{ $defaultVal }}"
            class="param-range"
            title="Rata-rata optimal: {{ $optimal }}"
            aria-label="{{ $label }}"
        >
        <span class="param-slider-max">{{ $max }}</span>
        <input
            type="number"
            id="input-{{ $name }}"
            name="{{ $name }}"
            min="{{ $min }}"
            max="{{ $max }}"
            step="{{ $step }}"
            value="{{ $defaultVal }}"
            class="param-number-input"
            inputmode="decimal"
            required
            aria-label="{{ $label }} value"
        >
    </div>

    {{-- Footer --}}
    <div class="param-slider-footer">
        <span class="param-slider-hint">Min: {{ $min }} · Max: {{ $max }} · {{ $optimal ? "Optimal: $optimal" : "Satuan: $unit" }}</span>
        <span class="param-slider-error" id="error-{{ $name }}">Nilai harus antara {{ $min }} dan {{ $max }}</span>
    </div>

    {{-- Validation error from server --}}
    @error($name)
        <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
    @enderror
</div>

<script>
(function() {
    const slider = document.getElementById('slider-{{ $name }}');
    const input  = document.getElementById('input-{{ $name }}');
    const error  = document.getElementById('error-{{ $name }}');
    const min = {{ $min }};
    const max = {{ $max }};

    function updateFill() {
        const pct = ((slider.value - min) / (max - min)) * 100;
        slider.style.background = `linear-gradient(to right, #40916C 0%, #40916C ${pct}%, #E5E7EB ${pct}%, #E5E7EB 100%)`;

        // Boundary warning
        if (parseFloat(slider.value) <= min || parseFloat(slider.value) >= max) {
            slider.classList.add('at-boundary');
        } else {
            slider.classList.remove('at-boundary');
        }
    }

    slider.addEventListener('input', function() {
        input.value = this.value;
        input.classList.remove('input-error');
        error.classList.remove('visible');
        updateFill();
    });

    input.addEventListener('input', function() {
        const v = parseFloat(this.value);
        if (isNaN(v) || v < min || v > max) {
            this.classList.add('input-error');
            error.classList.add('visible');
        } else {
            this.classList.remove('input-error');
            error.classList.remove('visible');
            slider.value = v;
            updateFill();
        }
    });

    // Keyboard: Home = min, End = max
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Home') { e.preventDefault(); this.value = min; slider.value = min; updateFill(); }
        if (e.key === 'End')  { e.preventDefault(); this.value = max; slider.value = max; updateFill(); }
    });

    updateFill();
})();
</script>
