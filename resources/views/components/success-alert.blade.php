@if($message)
    <div x-data="{ show: true }"
         x-init="setTimeout(() => show = false, 4000)"
         x-show="show"
         class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transition-transform transform ease-in-out duration-300">
        <p class="font-semibold">{{ $message }}</p>
    </div>
@endif
