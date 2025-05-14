<!-- resources/views/collaterals/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow-md mt-10">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">Edit Collateral</h1>

    <form method="POST" action="{{ route('collaterals.update', $collateral->id) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Collateral Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $collateral->name) }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 @error('name') border-red-500 @enderror" required>
            @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
            <input type="text" name="type" id="type" value="{{ old('type', $collateral->type) }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 @error('type') border-red-500 @enderror" required>
            @error('type')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="value" class="block text-sm font-medium text-gray-700">Value</label>
            <input type="number" name="value" id="value" value="{{ old('value', $collateral->value) }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 @error('value') border-red-500 @enderror" required>
            @error('value')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="borrower_id" class="block text-sm font-medium text-gray-700">Borrower</label>
            <select name="borrower_id" id="borrower_id"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 @error('borrower_id') border-red-500 @enderror" required>
                <option value="">Select Borrower</option>
                @foreach ($borrowers as $borrower)
                    <option value="{{ $borrower->id }}"
                        {{ old('borrower_id', $collateral->borrower_id) == $borrower->id ? 'selected' : '' }}>
                        {{ $borrower->first_name }} {{ $borrower->last_name }}
                    </option>
                @endforeach
            </select>
            @error('borrower_id')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 @error('status') border-red-500 @enderror" required>
                <option value="active" {{ old('status', $collateral->status) == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $collateral->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="image" class="block text-sm font-medium text-gray-700">Collateral Image</label>
            <input type="file" name="image" id="image"
                class="mt-1 block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100 @error('image') border-red-500 @enderror">
            @error('image')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror

            @if ($collateral->image)
                <div class="mt-3">
                    <img src="{{ asset('storage/' . $collateral->image) }}" alt="Collateral Image" class="w-36 rounded border border-gray-300">
                    <p class="text-sm text-gray-600 mt-1">Current Image</p>
                </div>
            @endif
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold rounded-md shadow-sm">
                Update Collateral
            </button>
        </div>
    </form>
</div>
@endsection
