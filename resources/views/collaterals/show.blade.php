<!-- resources/views/collaterals/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-md mt-10">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Collateral Details</h1>
        <div class="space-x-2">
            <a href="{{ route('collaterals.edit', $collateral->id) }}"
               class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-md shadow">
                Edit Collateral
            </a>
            <form action="{{ route('collaterals.destroy', $collateral->id) }}" method="POST" class="inline-block"
                  onsubmit="return confirm('Are you sure you want to delete this collateral?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-md shadow">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <!-- Collateral Info -->
        <div class="space-y-4">
            <div>
                <p class="text-sm text-gray-500">Name</p>
                <p class="text-lg font-medium text-gray-800">{{ $collateral->name }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Type</p>
                <p class="text-lg font-medium text-gray-800">{{ $collateral->type }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Value</p>
                <p class="text-lg font-medium text-gray-800">{{ number_format($collateral->value, 2) }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Status</p>
                <span class="inline-block px-2 py-1 text-sm rounded {{ $collateral->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ ucfirst($collateral->status) }}
                </span>
            </div>

            <div>
                <p class="text-sm text-gray-500">Borrower</p>
                <p class="text-lg font-medium text-gray-800">
                    {{ $collateral->borrower->first_name ?? '' }} {{ $collateral->borrower->last_name ?? '' }}
                </p>
            </div>
        </div>

        <!-- Collateral Image -->
        <div>
            <p class="text-sm text-gray-500 mb-2">Collateral Image</p>
            @if ($collateral->photo)
                <img src="{{ asset('storage/' . $collateral->photo) }}" alt="Collateral Image"
                     class="w-full max-w-md rounded border border-gray-300 shadow-sm">
            @else
                <div class="text-gray-500 italic">No image available</div>
            @endif
        </div>
    </div>
</div>
@endsection
