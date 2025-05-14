@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold mb-6">Edit Borrower</h1>
    
    <form action="{{ route('borrowers.update', $borrower->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Borrower Type -->
            <div class="form-group">
                <label for="borrower_type" class="block text-sm font-medium text-gray-700">Borrower Type</label>
                <select name="borrower_type" id="borrower_type" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    <option value="individual" {{ $borrower->borrower_type == 'individual' ? 'selected' : '' }}>Individual</option>
                    <option value="business" {{ $borrower->borrower_type == 'business' ? 'selected' : '' }}>Business</option>
                </select>
            </div>

            <!-- Title -->
            <div class="form-group">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('title', $borrower->title) }}">
            </div>

            <!-- First Name -->
            <div class="form-group">
                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                <input type="text" name="first_name" id="first_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('first_name', $borrower->first_name) }}" required>
            </div>

            <!-- Last Name -->
            <div class="form-group">
                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                <input type="text" name="last_name" id="last_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('last_name', $borrower->last_name) }}" required>
            </div>

            <!-- Business Name -->
            <div class="form-group">
                <label for="business_name" class="block text-sm font-medium text-gray-700">Business Name</label>
                <input type="text" name="business_name" id="business_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('business_name', $borrower->business_name) }}">
            </div>

            <!-- Date of Birth -->
            <div class="form-group">
                <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                <input type="date" name="date_of_birth" id="date_of_birth" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('date_of_birth', $borrower->date_of_birth) }}" required>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('email', $borrower->email) }}">
            </div>

            <!-- Phone Number -->
            <div class="form-group">
                <label for="phone_number" class="block text-sm font-medium text-gray-700">Mobile</label>
                <input type="text" name="phone_number" id="phone_number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('phone_number', $borrower->phone_number) }}" required>
            </div>

            <!-- Gender -->
            <div class="form-group">
                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                <select name="gender" id="gender" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    <option value="male" {{ $borrower->gender == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ $borrower->gender == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <!-- Address -->
            <div class="form-group">
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <input type="text" name="address" id="address" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('address', $borrower->address) }}">
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description', $borrower->description) }}</textarea>
            </div>
        </div>

        <button type="submit" class="mt-6 px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">Update Borrower</button>
    </form>
</div>
@endsection
