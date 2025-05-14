<!-- resources/views/payments/form.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Make a Payment</h2>

    <!-- Display success or error messages -->
    @if(session('success'))
        <div class="alert alert-success bg-green-500 text-white p-4 mb-4 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger bg-red-500 text-white p-4 mb-4 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('payment.store') }}" method="POST" class="max-w-lg mx-auto bg-white p-6 shadow-md rounded-lg">
        @csrf

        <div class="form-group mb-4">
            <label for="mpesa_number" class="block text-gray-700 font-semibold mb-2">MPesa Number</label>
            <input type="text" class="form-control @error('mpesa_number') border-red-500 @enderror block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                   id="mpesa_number" name="mpesa_number" value="{{ old('mpesa_number') }}" required>
            @error('mpesa_number')
                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="amount" class="block text-gray-700 font-semibold mb-2">Amount (KES)</label>
            <input type="number" class="form-control @error('amount') border-red-500 @enderror block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                   id="amount" name="amount" value="{{ old('amount', 1) }}" min="1" required>
            @error('amount')
                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex justify-center">
            <button type="submit" class="btn btn-primary bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 ease-in-out">Pay Now</button>
        </div>
    </form>
</div>
@endsection
