@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Create Repayment</h2>

    <form action="{{ route('repayments.store') }}" method="POST">
        @csrf

        <!-- Borrower Selection -->
        <div class="mb-6">
            <label for="borrower" class="block text-gray-700 font-medium mb-2">Select Borrower</label>
            <select id="borrower" name="borrower_id" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" onchange="filterLoansByBorrower()">
                <option value="">Select Borrower</option>
                @foreach($borrowers as $borrower)
                    <option value="{{ $borrower->id }}">{{ $borrower->first_name }} {{ $borrower->last_name }}</option>
                @endforeach
            </select>
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
        </div>

        <!-- Remaining Balance -->
        <div class="mb-6" id="remaining-balance-container" style="display:none;">
            <label for="remaining_balance" class="block text-gray-700 font-medium mb-2">Remaining Balance</label>
            <input type="text" id="remaining_balance" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" readonly>
        </div>

        <!-- Amount Paid -->
        <div class="mb-6">
            <label for="amount_paid" class="block text-gray-700 font-medium mb-2">Amount Paid</label>
            <input type="number" name="amount_paid" id="amount_paid" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" min="1" step="1" required oninput="updateRemainingBalance()">
        </div>

        <!-- Repayment Date -->
        <div class="mb-6">
            <label for="repayment_date" class="block text-gray-700 font-medium mb-2">Repayment Date</label>
            <input type="date" name="repayment_date" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>

        <!-- Status -->
        <div class="mb-6">
            <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
            <select name="status" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                Save Repayment
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
        if (loan.getAttribute('data-borrower') == borrowerId || borrowerId == "") {
            loan.style.display = 'block'; // Show the loan
        } else {
            loan.style.display = 'none'; // Hide the loan
        }
    });

    // Reset remaining balance display
    document.getElementById('remaining-balance-container').style.display = 'none';
    document.getElementById('remaining_balance').value = '';
    document.getElementById('amount_paid').value = ''; // Clear amount paid input
}

// Function to display the remaining balance when a loan is selected
function displayRemainingBalance() {
    const loanSelect = document.getElementById('loan');
    const selectedLoan = loanSelect.options[loanSelect.selectedIndex];
    
    const remainingBalance = selectedLoan.getAttribute('data-balance');

    if (remainingBalance) {
        document.getElementById('remaining_balance').value = remainingBalance;
        document.getElementById('remaining-balance-container').style.display = 'block'; // Show the remaining balance input field
    } else {
        document.getElementById('remaining-balance-container').style.display = 'none'; // Hide if no loan selected
    }
}

// Function to update remaining balance based on the repayment amount
function updateRemainingBalance() {
    const loanSelect = document.getElementById('loan');
    const selectedLoan = loanSelect.options[loanSelect.selectedIndex];

    const originalBalance = parseFloat(selectedLoan.getAttribute('data-balance'));
    const amountPaid = parseFloat(document.getElementById('amount_paid').value);

    if (!isNaN(originalBalance) && !isNaN(amountPaid)) {
        const updatedBalance = originalBalance - amountPaid;
        document.getElementById('remaining_balance').value = updatedBalance.toFixed(2);
    } else {
        document.getElementById('remaining_balance').value = originalBalance.toFixed(2);
    }
}
</script>

@endsection
