@props([
    'name',
    'label' => '',
    'options' => [],
    'selected' => null,
    'required' => false,
])

<div class="space-y-2">
    @if ($label)
        <label for="{{ $name }}" class="text-sm font-medium text-gray-700">{{ $label }}</label>
    @endif

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        @required($required)
        class="block w-full mt-1 border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm"
    >
        @foreach ($options as $value => $text)
            <option value="{{ $value }}" @selected(old($name, $selected) == $value)>
                {{ $text }}
            </option>
        @endforeach
    </select>
</div>
