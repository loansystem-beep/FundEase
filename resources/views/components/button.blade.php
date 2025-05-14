@props(['type' => 'submit'])

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-xl']) }}
>
    {{ $slot }}
</button>
