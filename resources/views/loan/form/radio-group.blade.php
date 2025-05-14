@props([
    'name',
    'label' => '',
    'options' => [],
    'selected' => null,
    'required' => false,
])

<fieldset class="space-y-2">
    @if ($label)
        <legend class="text-sm font-medium text-gray-700">{{ $label }}</legend>
    @endif

    <div class="space-y-1">
        @foreach ($options as $value => $text)
            <div class="flex items-center space-x-2">
                <input
                    type="radio"
                    id="{{ $name . '-' . $value }}"
                    name="{{ $name }}"
                    value="{{ $value }}"
                    @checked(old($name, $selected) == $value)
                    @required($required)
                    class="text-indigo-600 border-gray-300 focus:ring-indigo-500"
                >
                <label for="{{ $name . '-' . $value }}" class="text-sm text-gray-700">
                    {{ $text }}
                </label>
            </div>
        @endforeach
    </div>
</fieldset>
