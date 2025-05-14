@props(['label' => '', 'name', 'type' => 'text', 'required' => false, 'value' => null])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
    @endif
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $required ? 'required' : '' }}
        value="{{ old($name, $value) }}"
        {{ $attributes->merge(['class' => 'w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500']) }}
    >
</div>
