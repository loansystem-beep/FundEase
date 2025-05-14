@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold mb-6">Borrower Details</h1>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p><strong>Full Name:</strong> {{ $borrower->full_name }}</p>
                <p><strong>Date of Birth:</strong> {{ $borrower->date_of_birth ? $borrower->date_of_birth : 'Not Provided' }}</p>
                <p><strong>Mobile:</strong> {{ $borrower->phone_number ? $borrower->phone_number : 'Not Provided' }}</p>
                <p><strong>Email:</strong> {{ $borrower->email ? $borrower->email : 'Not Provided' }}</p>
                <p><strong>Borrower Type:</strong> {{ ucfirst($borrower->borrower_type) }}</p>
                <p><strong>Gender:</strong> {{ $borrower->gender ? $borrower->gender : 'Not Provided' }}</p>
            </div>
            <div>
                <p><strong>Title:</strong> {{ $borrower->title ? $borrower->title : 'Not Provided' }}</p>
                <p><strong>Address:</strong> {{ $borrower->address ? $borrower->address : 'Not Provided' }}</p>
                <p><strong>Description:</strong> {{ $borrower->description ? $borrower->description : 'Not Provided' }}</p>
                @if ($borrower->photo)
                    <div class="mt-4">
                        <strong>Photo:</strong>
                        <img src="{{ asset('storage/' . $borrower->photo) }}" alt="Borrower Photo" class="w-32 h-32 rounded-lg">
                    </div>
                @endif
            </div>
        </div>

        <h2 class="text-2xl font-semibold mt-6">Loan Details</h2>
        <p><strong>Total Loan Amount:</strong> KES {{ number_format($borrower->total_loan_amount, 2) }}</p>
        <p><strong>Outstanding Balance:</strong> KES {{ number_format($borrower->outstanding_balance, 2) }}</p>
        <p><strong>Repayment Status:</strong> 
            @if ($borrower->outstanding_balance > 0)
                <span class="text-red-600">Pending</span>
            @else
                <span class="text-green-600">Fully Repaid</span>
            @endif
        </p>
    </div>

    <a href="{{ route('borrowers.index') }}" class="mt-4 inline-block bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700">Back to Borrowers List</a>
</div>
@endsection
