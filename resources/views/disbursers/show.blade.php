<!-- resources/views/disbursers/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto p-6 bg-white rounded shadow">
        <h1 class="text-2xl font-bold mb-6">Disburser Details</h1>

        <div class="mb-4">
            <strong class="text-lg">Name:</strong>
            <p class="text-gray-700">{{ $disburser->name }}</p>
        </div>

        <div class="mb-4">
            <strong class="text-lg">Description:</strong>
            <p class="text-gray-700">{{ $disburser->description ?? 'No description available' }}</p>
        </div>

        <div class="mt-6">
            <a href="{{ route('disbursers.index') }}" class="inline-block bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Back to List</a>
        </div>
    </div>
@endsection
