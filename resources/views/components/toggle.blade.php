@props(['name', 'checked' => false, 'label' => ''])

<label class="flex items-center gap-2 cursor-pointer">
    <span class="text-sm text-gray-700">{{ $label }}</span>
    <input type="hidden" name="{{ $name }}" value="0">
    <input type="checkbox"
           name="{{ $name }}"
           value="1"
           {{ $checked ? 'checked' : '' }}
           class="toggle-checkbox hidden"
    >
    <div class="w-10 h-5 flex items-center bg-gray-300 rounded-full p-1 toggle-bg">
        <div class="bg-white w-4 h-4 rounded-full shadow-md transform duration-300 ease-in-out toggle-dot"></div>
    </div>
</label>

<style>
    .toggle-checkbox:checked + .toggle-bg {
        background-color: #4ade80; /* green-400 */
    }
    .toggle-checkbox:checked + .toggle-bg .toggle-dot {
        transform: translateX(1.25rem);
    }
</style>
