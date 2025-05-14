@props([
    'id',
    'name',
    'label' => '',
    'value' => '',
    'step' => '1',
    'min' => null,
    'max' => null,
    'required' => false,
    'disabled' => false,
])

@php
    // Ensure value is never an array
    $safeValue = old($name, $value);
    if (is_array($safeValue)) {
        $safeValue = ''; // Fallback for safety
    }
@endphp

<div>
    @if($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-white mb-1">
            {{ $label }}
        </label>
    @endif

    <input
        type="number"
        id="{{ $id }}"
        name="{{ $name }}"
        value="{{ $safeValue }}"
        step="{{ $step }}"
        @if($min !== null) min="{{ $min }}" @endif
        @if($max !== null) max="{{ $max }}" @endif
        @if($required) required @endif
        @if($disabled) disabled @endif
        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-gray-900"
    />

    @error($name)
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>
