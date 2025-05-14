@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold mb-6">Add New Borrower</h1>
    
    <!-- Alert Message for Duplicate Borrower -->
    <div id="duplicate-alert" class="hidden p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg transition-opacity duration-500 ease-in-out" role="alert">
        <span class="font-medium">Warning!</span> A borrower with these details already exists.
    </div>
    
    <form id="borrower-form" action="{{ route('borrowers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Borrower Type -->
            <div class="form-group">
                <label for="borrower_type" class="block text-sm font-medium text-gray-700">Borrower Type</label>
                <select name="borrower_type" id="borrower_type" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    <option value="individual" selected>Individual</option>
                    <option value="business">Business</option>
                </select>
            </div>

            <!-- Title -->
            <div class="form-group">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('title') }}">
            </div>

            <!-- First Name -->
            <div class="form-group">
                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                <input type="text" name="first_name" id="first_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('first_name') }}" required>
            </div>

            <!-- Last Name -->
            <div class="form-group">
                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                <input type="text" name="last_name" id="last_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('last_name') }}" required>
            </div>

            <!-- Business Name -->
            <div class="form-group">
                <label for="business_name" class="block text-sm font-medium text-gray-700">Business Name</label>
                <input type="text" name="business_name" id="business_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('business_name') }}">
            </div>

            <!-- Date of Birth -->
            <div class="form-group">
                <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                <input type="date" name="date_of_birth" id="date_of_birth" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('date_of_birth') }}" required>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('email') }}">
            </div>

            <!-- Phone Number -->
            <div class="form-group">
                <label for="phone_number" class="block text-sm font-medium text-gray-700">Mobile</label>
                <input type="text" name="phone_number" id="phone_number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('phone_number') }}" required>
            </div>

            <!-- Gender -->
            <div class="form-group">
                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                <select name="gender" id="gender" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>

            <!-- Address -->
            <div class="form-group">
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <input type="text" name="address" id="address" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('address') }}">
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
            </div>
        </div>

        <button type="submit" class="mt-6 px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">Create Borrower</button>
    </form>
</div>

<script>
    document.getElementById('borrower-form').addEventListener('submit', function(event) {
        event.preventDefault();
        
        const firstName = document.getElementById('first_name').value.trim();
        const lastName = document.getElementById('last_name').value.trim();
        const phoneNumber = document.getElementById('phone_number').value.trim();
        const email = document.getElementById('email').value.trim();

        // Simulate checking for duplicates (replace with an actual AJAX call if needed)
        const existingBorrowers = [
            { first_name: 'John', last_name: 'Doe', phone_number: '123456789', email: 'john.doe@example.com' },
            // Add more existing borrowers here
        ];

        const duplicate = existingBorrowers.some(borrower =>
            borrower.first_name.toLowerCase() === firstName.toLowerCase() &&
            borrower.last_name.toLowerCase() === lastName.toLowerCase() &&
            borrower.phone_number === phoneNumber &&
            borrower.email.toLowerCase() === email.toLowerCase()
        );

        if (duplicate) {
            // Show the duplicate alert with fade-in effect
            const alert = document.getElementById('duplicate-alert');
            alert.classList.remove('hidden');
            alert.classList.add('opacity-100');
            
            // Hide the alert after 3 seconds
            setTimeout(() => {
                alert.classList.add('opacity-0');
                alert.classList.remove('opacity-100');
            }, 3000);
        } else {
            // If no duplicate found, submit the form (replace with your actual form submission logic)
            this.submit();
        }
    });
</script>
@endsection
