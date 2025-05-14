@props(['title' => '', 'collapsible' => false])

<div x-data="{ open: true }" class="mb-6 border rounded-xl shadow-sm p-4 bg-white">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">{{ $title }}</h2>
        @if($collapsible)
            <button type="button" @click="open = !open" class="text-sm text-blue-600 hover:underline">
                <span x-show="open">Hide</span>
                <span x-show="!open">Show</span>
            </button>
        @endif
    </div>
    <div x-show="open" x-cloak>
        {{ $slot }}
    </div>
</div>
