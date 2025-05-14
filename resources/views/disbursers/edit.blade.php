<!-- resources/views/disbursers/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-semibold text-gray-900 mb-6">Edit Disburser</h2>

        <form action="{{ route('disbursers.update', $disburser->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $disburser->name) }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" name="description" rows="4" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $disburser->description) }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="inline-block bg-green-500 text-white py-2 px-6 rounded hover:bg-green-600">Update Disburser</button>
                <a href="{{ route('disbursers.index') }}" class="text-gray-500 hover:text-gray-700">Cancel</a>
            </div>
        </form>
    </div>
@endsection
