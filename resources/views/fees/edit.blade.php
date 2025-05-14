@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 bg-white shadow rounded-lg">
        <h2 class="text-3xl font-semibold text-gray-800 mb-6">Edit Fee</h2>

        <!-- Success and Error Messages -->
        @if(session('success'))
            <div class="mb-4 text-green-500">
                <p>{{ session('success') }}</p>
            </div>
        @elseif(session('error'))
            <div class="mb-4 text-red-500">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <form action="{{ route('fees.update', $fee->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            @include('fees._form', ['fee' => $fee]) {{-- Pass the existing fee for editing --}}

            <!-- Submit button -->
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Update Fee
                </button>
            </div>
        </form>
    </div>
@endsection
