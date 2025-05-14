@props([
    'id' => Str::random(8),
    'name',
    'label' => '',
    'value' => 1,
    'checked' => false,
    'disabled' => false,
    'required' => false,
])

@php
    $uid = $id ?? Str::slug($name) . '-' . uniqid();
@endphp

<div class="flex items-center space-x-2">
    <input
        type="checkbox"
        id="{{ $uid }}"
        name="{{ $name }}"
        value="{{ $value }}"
        @checked(old($name, $checked))
        @disabled($disabled)
        @required($required)
        {{ $attributes->merge(['class' => 'rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500']) }}
    />
    @if($label)
        <label for="{{ $uid }}" class="text-sm text-gray-700">{{ $label }}</label>
    @endif
</div>
