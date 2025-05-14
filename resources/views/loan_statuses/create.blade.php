@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-6 py-8 bg-white shadow-lg rounded-lg">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Add New Loan Status</h1>

    <form method="POST" action="{{ route('loan-statuses.store') }}">
        @csrf

        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-700">Status Name</label>
            <input type="text" id="name" name="name" class="form-input mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('name')
                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
            <select id="category" name="category" class="form-select mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="processing">Processing</option>
                <option value="open">Open</option>
                <option value="defaulted">Defaulted</option>
                <option value="denied">Denied</option>
                <option value="not_taken_up">Not Taken Up</option>
            </select>
            @error('category')
                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">Save</button>
        </div>
    </form>
</div>
@endsection
