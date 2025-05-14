@props(['title'])

<div class="bg-white shadow-sm rounded-xl mb-6 p-6 border border-gray-200">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">
        {{ $title }}
    </h2>

    {{ $slot }}
</div>
