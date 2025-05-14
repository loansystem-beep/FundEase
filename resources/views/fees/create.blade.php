@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-3xl font-semibold text-gray-800 mb-6">Add New Loan Fee</h2>

    <form action="{{ route('fees.store') }}" method="POST">
        @csrf
        @include('fees._form', ['fee' => null])

        <!-- Submit button -->
        <div class="mt-6 text-center">
            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-700 transition duration-300 ease-in-out">
                Save Fee
            </button>
        </div>
    </form>
</div>
@endsection
