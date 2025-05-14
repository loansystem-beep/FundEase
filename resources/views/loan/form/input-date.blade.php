@props([
    'id',
    'name',
    'label' => '',
    'value' => '',
    'required' => false,
    'disabled' => false,
])

<div>
    @if($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-white mb-1">
            {{ $label }}
        </label>
    @endif
    <input
        type="date"
        id="{{ $id }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        @if($required) required @endif
        @if($disabled) disabled @endif
        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-gray-900"
    />
    @error($name)
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>
