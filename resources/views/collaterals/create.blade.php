@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Create Collateral</h2>

    <form action="{{ route('collaterals.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Borrower Selection -->
        <div class="mb-6">
            <label for="borrower" class="block text-gray-700 font-medium mb-2">Select Borrower</label>
            <select id="borrower" name="borrower_id" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" onchange="filterLoansByBorrower()">
                <option value="">Select Borrower</option>
                @foreach($borrowers as $borrower)
                    <option value="{{ $borrower->id }}" {{ old('borrower_id') == $borrower->id ? 'selected' : '' }}>
                        {{ $borrower->first_name }} {{ $borrower->last_name }}
                    </option>
                @endforeach
            </select>
            @error('borrower_id')
                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Loans related to selected borrower -->
        <div class="mb-6">
            <label for="loan" class="block text-gray-700 font-medium mb-2">Select Loan</label>
            <select id="loan" name="loan_id" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" onchange="displayRemainingBalance()">
                <option value="">Select a Loan</option>
                @foreach($loans as $loan)
                    <option class="loan-option loan-{{ $loan->borrower_id }}" value="{{ $loan->id }}" data-borrower="{{ $loan->borrower_id }}" data-balance="{{ $loan->balance }}">
                        Loan Amount: {{ number_format($loan->amount, 2) }} | Status: {{ ucfirst($loan->status) }}
                    </option>
                @endforeach
            </select>
            <div id="loan-balance" class="mt-2 text-sm text-gray-500 hidden">
                Remaining Balance: <span id="remaining-balance"></span>
            </div>
            @error('loan_id')
                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Collateral Name -->
        <div class="mb-6">
            <label for="name" class="block text-gray-700 font-medium mb-2">Collateral Name</label>
            <input type="text" name="name" id="name" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter the name of the collateral (e.g., Car, Laptop)" required value="{{ old('name') }}">
            @error('name')
                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Collateral Type -->
        <div class="mb-6">
            <label for="type" class="block text-gray-700 font-medium mb-2">Collateral Type</label>
            <input type="text" name="type" id="type" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter the type of collateral (e.g., Vehicle, Electronics)" required value="{{ old('type') }}">
            @error('type')
                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Collateral Value -->
        <div class="mb-6">
            <label for="value" class="block text-gray-700 font-medium mb-2">Collateral Value</label>
            <input type="number" name="value" id="value" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" min="1" step="1" placeholder="Enter the value of the collateral in your currency" required value="{{ old('value') }}">
            @error('value')
                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Collateral Status -->
        <div class="mb-6">
            <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
            <select name="status" id="status" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="seized" {{ old('status') == 'seized' ? 'selected' : '' }}>Seized</option>
            </select>
            @error('status')
                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Photo Upload -->
        <div class="mb-6">
            <label for="photo" class="block text-gray-700 font-medium mb-2">Upload Collateral Photo</label>
            <input type="file" name="photo" id="photo" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            @error('photo')
                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                Save Collateral
            </button>
        </div>
    </form>
</div>

<script>
// JavaScript function to filter loans based on the selected borrower
function filterLoansByBorrower() {
    const borrowerId = document.getElementById('borrower').value;
    
    const loans = document.querySelectorAll('.loan-option');
    loans.forEach(loan => {
        // Check if the loan belongs to the selected borrower
        if (loan.getAttribute('data-borrower') == borrowerId || borrowerId == "") {
            loan.style.display = 'block'; // Show the loan
        } else {
            loan.style.display = 'none'; // Hide the loan
        }
    });
}

// JavaScript function to display the remaining balance for the selected loan
function displayRemainingBalance() {
    const selectedLoan = document.getElementById('loan').selectedOptions[0];
    
    if (selectedLoan) {
        const remainingBalance = selectedLoan.getAttribute('data-balance');
        const balanceElement = document.getElementById('loan-balance');
        const remainingBalanceSpan = document.getElementById('remaining-balance');
        
        remainingBalanceSpan.textContent = `₦${parseFloat(remainingBalance).toLocaleString()}`;
        balanceElement.classList.remove('hidden');  // Show the balance element
    }
}

// Call the function on page load to filter loans based on the selected borrower
window.onload = function() {
    filterLoansByBorrower();
}
</script>

@endsection
